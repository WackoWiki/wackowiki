// src/js/editor/features/syntax-highlight.js

import logger from '../../utils/logger.js';
import Storage from '../../utils/storage.js';

/**
 * Minimum number of fence characters required to open a top level code block.
 *
 * Block fence rules implemented by the highlighter (for BOTH '%' and '`'):
 *  - A top level block is opened by a run of at least BASE_LENGTH characters.
 *  - A run longer than BASE_LENGTH must be alone on its line, otherwise it is
 *    ordinary content. This keeps ordinary text from opening or closing a block.
 *  - A block is closed by a run of exactly the same length as its opening run.
 *  - Runs of any other length are ordinary content ("own escape" rule).
 *  - Nested blocks keep the k+1 rule: inside a block of length N a nested block
 *    is opened (and closed) by a run of exactly N+1 characters.
 */
const BASE_LENGTH = 2;

/**
 * Characters that may be used as block level code fences.
 * '%%' and '``' are equivalent alternatives:
 *
 *   %% code block %%
 *   `` code block ``
 *
 * Both support the same own-escape / exact-length / k+1 nesting behaviour.
 */
const FENCE_CHARS = ['%', '`'];

/**
 * Minimum number of '#' characters required to open an inline code span.
 *
 * Inline code span rules implemented by the highlighter:
 *  - The opening delimiter is a maximal run of '#' with a length N >= 2.
 *  - The closing delimiter must be a maximal run of exactly N characters.
 *  - Runs with fewer (or more) '#' are ordinary content, so a literal '##'
 *    inside a span has to be written with a longer delimiter, e.g.
 *    '### ## code ## ###' renders as <code>## code ##</code>.
 *  - A delimiter can only be escaped by its own escape (a longer run),
 *    nothing else.
 *  - The span is inline: the closing delimiter must be on the same line as
 *    the opening one, a span never crosses a line break.
 *  - The content of a span is never parsed as wiki markup: no HTML, no links,
 *    no actions, no typography. It is shown as typed (HTML escaped).
 */
const INLINE_CODE_MIN_LENGTH = 2;

/**
 * Placeholder markers used to protect regions from further processing.
 * A NUL character is used so that user content cannot collide with them.
 */
const TOKEN_PREFIX = '\u0000WIKI_TOKEN_';
const TOKEN_SUFFIX = '\u0000';

/**
 * Sets up the syntax highlighting overlay and attaches all related listeners.
 * Call once during init, after the toolbar is built.
 * @param {import('../editor/wikiedit.js').WikiEdit} editor
 */
export function setupSyntaxHighlighting(editor) {
  if (!editor.syntaxHighlighting) return;

  // === Original setup from your file ===
  editor.syntaxContainer = document.createElement('div');
  editor.syntaxContainer.className = 'syntax-container';

  editor.highlighter = document.createElement('pre');
  editor.highlighter.className = 'syntax-highlighter';

  editor.syntaxContainer.appendChild(editor.highlighter);

  const parent = editor.area.parentNode;
  parent.insertBefore(editor.syntaxContainer, editor.area);
  editor.syntaxContainer.appendChild(editor.area); // textarea on top

  // Copy relevant styles from textarea to highlighter
  const style = getComputedStyle(editor.area);
  ['tabSize', 'letterSpacing', 'wordSpacing', 'padding'].forEach(prop => {
    editor.highlighter.style[prop] = style[prop];
  });

  // Load saved syntax state from localStorage (overrides data-attribute)
  const saved = Storage.get('syntax_enabled');
  if (saved !== null) {
    editor.syntaxHighlighting = !!saved;
  }

  // Apply initial state
  if (editor.syntaxHighlighting) {
      enableSyntaxHighlighting(editor);
  } else {
      disableSyntaxHighlighting(editor);
  }

  // Attach the toggle function to the editor so toolbar delegation can call it
  editor.toggleSyntaxHighlight = () => toggleSyntaxHighlight(editor);
  editor.refreshSyntaxHighlight = () => refreshSyntaxHighlight(editor);

  // Live update on input - triggers idle highlight
  editor.area.addEventListener('input', () => {
    if (editor.syntaxHighlightEnabled) {
      editor.refreshSyntaxHighlight();
    }
  });

  // Scroll sync
  editor.area.addEventListener('scroll', () => {
    if (editor.highlighter) {
      editor.highlighter.scrollTop = editor.area.scrollTop;
      editor.highlighter.scrollLeft = editor.area.scrollLeft;
    }
  });

  // Resize observer
  if (editor.resizeObserver) editor.resizeObserver.disconnect();
  editor.resizeObserver = new ResizeObserver(() => syncContentSize(editor));
  editor.resizeObserver.observe(editor.area);

  // Idle / RAF tracking
  editor._syntaxHighlightIdleId = null;
  editor._syntaxHighlightRafId = null;

  // Initial highlight
  setTimeout(() => editor.refreshSyntaxHighlight(), 80);

  editor._cleanupSyntaxHighlight = () => cleanup(editor);

  logger.debug('SyntaxHighlight: setup complete with idle scheduling');
}

/**
 * Cleanup function for Syntax Highlighting.
 * @param {import('../editor/wikiedit.js').WikiEdit} editor
 */
function cleanup(editor) {
  logger.info('SyntaxHighlight: cleaning up');

  if (editor._syntaxHighlightIdleId) {
    cancelIdleCallback(editor._syntaxHighlightIdleId);
    editor._syntaxHighlightIdleId = null;
  }
  if (editor._syntaxHighlightRafId) {
    cancelAnimationFrame(editor._syntaxHighlightRafId);
    editor._syntaxHighlightRafId = null;
  }

  if (editor.resizeObserver) {
    editor.resizeObserver.disconnect();
    editor.resizeObserver = null;
  }

  delete editor.refreshSyntaxHighlight;
  delete editor.toggleSyntaxHighlight;
  delete editor._syntaxHighlightIdleId;
  delete editor._syntaxHighlightRafId;
  delete editor._cleanupSyntaxHighlight;

  logger.debug('SyntaxHighlight: cleanup finished');
}

/**
 * Request syntax highlighting using requestIdleCallback (preferred) 
 * with requestAnimationFrame fallback.
 * @param {import('../editor/wikiedit.js').WikiEdit} editor
 */
function refreshSyntaxHighlight(editor) {
  if (!editor.syntaxHighlightEnabled || !editor.highlighter) return;

  // Cancel previous tasks
  if (editor._syntaxHighlightIdleId) cancelIdleCallback(editor._syntaxHighlightIdleId);
  if (editor._syntaxHighlightRafId) cancelAnimationFrame(editor._syntaxHighlightRafId);

  const doHighlight = () => {
    try {
      const content = editor.getContent() || '';
      editor.highlighter.innerHTML = highlightWikiSyntax(content) + '\n';
    } catch (err) {
      logger.error('Syntax highlighting failed:', err);
    }
  };

  // Prefer idle callback
  if (typeof requestIdleCallback === 'function') {
    editor._syntaxHighlightIdleId = requestIdleCallback((deadline) => {
      if (deadline.timeRemaining() > 10) {
        doHighlight();
      } else {
        editor._syntaxHighlightRafId = requestAnimationFrame(doHighlight);
      }
    }, { timeout: 200 });
  } else {
    editor._syntaxHighlightRafId = requestAnimationFrame(doHighlight);
  }
}

/**
 * Enables syntax highlighting (shows overlay, makes textarea transparent).
 * @param {import('../editor/wikiedit.js').WikiEdit} editor
 */
export function enableSyntaxHighlighting(editor) {
  editor.syntaxHighlightEnabled = true;
  editor.area.classList.add('syntax-enabled');

  if (!editor.syntaxContainer) {
    setupSyntaxHighlighting(editor);
    return;
  }

  editor.area.style.background = 'transparent';
  editor.area.style.color = 'transparent';
  editor.area.style.caretColor = 'var(--we-textarea-caret, #000)';

  editor.highlighter.style.display = 'block';
  syncContentSize(editor);
  refreshSyntaxHighlight(editor);
}

/**
 * Disables syntax highlighting (hides overlay, restores textarea colors).
 * @param {import('../editor/wikiedit.js').WikiEdit} editor
 */
export function disableSyntaxHighlighting(editor) {
  editor.syntaxHighlightEnabled = false;
  editor.area.classList.remove('syntax-enabled');

  if (editor.highlighter) {
    editor.highlighter.style.display = 'none';
  }

  editor.area.style.background = 'var(--we-textarea-bg, #fff)';
  editor.area.style.color = 'var(--we-textarea-text, #222)';
  editor.area.style.caretColor = 'var(--we-textarea-caret, #000)';
}

/**
 * Toggles syntax highlighting on/off and persists the choice.
 * @param {import('../editor/wikiedit.js').WikiEdit} editor
 */
function toggleSyntaxHighlight(editor) {
  if (editor.syntaxHighlightEnabled) {
    disableSyntaxHighlighting(editor);
  } else {
    enableSyntaxHighlighting(editor);
  }

  Storage.set('syntax_enabled', editor.syntaxHighlightEnabled);
  editor.updateToolbarButtonStates();
}

/**
 * Synchronizes the overlay dimensions with the textarea.
 * @param {import('../editor/wikiedit.js').WikiEdit} editor
 */
function syncContentSize(editor) {
  if (!editor.highlighter || !editor.area) return;

  const ta = editor.area;
  const style = getComputedStyle(ta);

  const width = ta.clientWidth - parseFloat(style.paddingLeft) - parseFloat(style.paddingRight);
  const height = ta.clientHeight - parseFloat(style.paddingTop) - parseFloat(style.paddingBottom);
  const padding = parseFloat(style.padding) + parseFloat(style.borderTopWidth);

  editor.highlighter.style.width = `${width}px`;
  editor.highlighter.style.height = `${height}px`;
  editor.highlighter.style.padding = `${padding}px`;
}

/**
 * Applies wiki syntax highlighting to a text string.
 *
 * @param {string} text
 * @returns {string} HTML with span-wrapped tokens
 */
function highlightWikiSyntax(text) {
  if (!text) return '';

  let html = escapeHtml(text);

  // Protected regions: literal blocks (""...""), code blocks (%%...%% and
  // ``...``) and inline code spans (##...##). Their content is never parsed as
  // wiki markup and is therefore also protected against any later stage
  // (e.g. typography).
  const blocks = [];
  html = extractProtectedRegions(html, blocks);

  // Apply inline syntax highlighting to the rest
  html = html.replace(/^(={3,7})(.+?)\1/gm, '<span class="wiki-h">\$1\$2$1</span>');
  html = html.replace(/\*\*(?!\s)(.+?)(?<!\s)\*\*/g, '<span class="wiki-bold">**$1**</span>');
  html = html.replace(/\/\/(?!\s)(.+?)(?<!\s)\/\//g, '<span class="wiki-italic">//$1//</span>');
  html = html.replace(/\+\+(?!\s)(.+?)(?<!\s)\+\+/g, '<span class="wiki-italic">++$1++</span>');
  html = html.replace(/__(?!\s)(.+?)(?<!\s)__/g, '<span class="wiki-underline">__$1__</span>');
  html = html.replace(/--(?!\s)(.+?)(?<!\s)--/g, '<span class="wiki-strike">--$1--</span>');
  html = html.replace(/\[\[(.+?)\]\]/g, '<span class="wiki-link">[[$1]]</span>');
  html = html.replace(/\(\((.+?)\)\)/g, '<span class="wiki-link">(($1))</span>');
  html = html.replace(/(file:((\.\.|!)\/|\/)?[\p{L}\p{Nd}][\p{L}\p{Nd}\/._-]*\.[\p{L}\p{Nd}]+(\?[a-zA-Z0-9&;=]*)?)/ug, '<span class="wiki-link">$1</span>');
  html = html.replace(/(^([ ]{2}|\t)+(([*-]|\d+\.|[a-zA-Z]\.))[ \t]+)/gm, '<span class="wiki-list">$1</span>');
  html = html.replace(/&lt;\[.*?\]&gt;/gs, '<span class="wiki-block">$&</span>');
  html = html.replace(/(\{\{)(.+?)(\}\})/gs, '<span class="wiki-block">\$1\$2$3</span>');
  html = html.replace(/(\?\?)(?=\S)(.+?)(?<=\S)(\?\?)/gs, '<span class="wiki-block">\$1\$2$3</span>');
  html = html.replace(/(\!\!)(?=\S)(.+?)(?<=\S)(\!\!)/gs, '<span class="wiki-block">\$1\$2$3</span>');
  html = html.replace(/^----$/gm, '<span class="wiki-hr">----</span>');

  // Restore protected regions
  html = html.replace(/\u0000WIKI_TOKEN_(\d+)\u0000/g, (match, id) => {
    const block = blocks[parseInt(id, 10)];
    return block === undefined ? match : block;
  });

  return html;
}

/**
 * Escapes the HTML special characters of the raw text.
 * @param {string} text
 * @returns {string}
 */
function escapeHtml(text) {
  return text
    .replace(/&/g, '&amp;')
    .replace(/</g, '&lt;')
    .replace(/>/g, '&gt;');
}

/**
 * Counts the length of the maximal run of `ch` starting at `index`.
 * @param {string} text
 * @param {number} index
 * @param {string} ch
 * @returns {number}
 */
function countRun(text, index, ch) {
  let n = 0;
  while (index + n < text.length && text[index + n] === ch) n++;
  return n;
}

/**
 * Checks whether a character may be used as a block code fence.
 * @param {string} ch
 * @returns {boolean}
 */
function isFenceChar(ch) {
  return FENCE_CHARS.indexOf(ch) !== -1;
}

/**
 * Checks whether a fence run is allowed to act as a delimiter.
 *
 * Runs longer than BASE_LENGTH must be alone on their line, so that ordinary
 * text can neither open nor close a block. Base length runs may appear inline.
 * @param {string} text
 * @param {number} index start of the run
 * @param {number} runLen length of the run
 * @returns {boolean}
 */
function isValidFence(text, index, runLen) {
  if (runLen <= BASE_LENGTH) return true;
  return isAloneOnLine(text, index, runLen);
}

/**
 * Checks whether a run is the only thing on its line (whitespace allowed).
 * @param {string} text
 * @param {number} index start of the run
 * @param {number} runLen length of the run
 * @returns {boolean}
 */
function isAloneOnLine(text, index, runLen) {
  let i = index - 1;
  while (i >= 0 && text[i] !== '\n') {
    if (!isHorizontalSpace(text[i])) return false;
    i--;
  }
  let j = index + runLen;
  while (j < text.length && text[j] !== '\n') {
    if (!isHorizontalSpace(text[j])) return false;
    j++;
  }
  return true;
}

/**
 * @param {string} ch
 * @returns {boolean} true for spaces/tabs (line breaks excluded)
 */
function isHorizontalSpace(ch) {
  return ch === ' ' || ch === '\t' || ch === '\r' || ch === '\f' || ch === '\v';
}

/**
 * Finds the end of a block level code region.
 *
 * The block is closed by a run of exactly `openLen` characters of the same
 * fence character. A run of `openLen + 1` characters opens a nested block
 * (k+1 rule) and is skipped over. Every other run length is ordinary content.
 * @param {string} text
 * @param {number} start index of the opening fence run
 * @param {number} openLen length of the opening fence run
 * @param {string} ch fence character ('%' or '`')
 * @returns {number} index just after the closing fence, or -1 if unclosed
 */
function findBlockEnd(text, start, openLen, ch) {
  let i = start + openLen;

  while (i < text.length) {
    if (text[i] !== ch) {
      i++;
      continue;
    }

    const runLen = countRun(text, i, ch);

    // Closing fence: exactly the same length as the opening fence
    if (runLen === openLen && isValidFence(text, i, runLen)) {
      return i + runLen;
    }

    // Nested block: k+1 rule
    if (runLen === openLen + 1 && isValidFence(text, i, runLen)) {
      const nestedEnd = findBlockEnd(text, i, runLen, ch);
      if (nestedEnd !== -1) {
        i = nestedEnd;
        continue;
      }
    }

    // Any other run length is ordinary content
    i += runLen;
  }

  return -1;
}

/**
 * Wraps nested blocks of a block region in their own span.
 * @param {string} text
 * @param {number} from start of the region (inclusive)
 * @param {number} to end of the region (exclusive)
 * @param {number} parentLen length of the fence of the enclosing block
 * @param {string} ch fence character ('%' or '`')
 * @returns {string} HTML
 */
function wrapNestedBlocks(text, from, to, parentLen, ch) {
  let out = '';
  let i = from;

  while (i < to) {
    if (text[i] !== ch) {
      out += text[i];
      i++;
      continue;
    }

    const runLen = countRun(text, i, ch);

    if (runLen === parentLen + 1 && isValidFence(text, i, runLen)) {
      const nestedEnd = findBlockEnd(text, i, runLen, ch);
      if (nestedEnd !== -1 && nestedEnd <= to) {
        out += '<span class="wiki-block wiki-block-nested">';
        out += wrapNestedBlocks(text, i, nestedEnd, runLen, ch);
        out += '</span>';
        i = nestedEnd;
        continue;
      }
    }

    out += text.slice(i, i + runLen);
    i += runLen;
  }

  return out;
}

/**
 * Extracts the protected regions from the text and replaces them with
 * placeholders, so that the inline rules never touch their content.
 *
 * Protected regions:
 *  - Literal blocks: ""...""
 *  - Code blocks:    %%...%% and ``...`` (fence length is the delimiter length)
 *  - Inline code:   ##...## (maximal run, exact length closer, single line)
 *
 * The content of a region is shown as typed (HTML escaped) and is never parsed
 * as wiki markup.
 *
 * @param {string} text
 * @param {string[]} blocks collects the HTML of every extracted region
 * @returns {string} text with placeholders
 */
function extractProtectedRegions(text, blocks) {
  let out = '';
  let i = 0;

  while (i < text.length) {
    const ch = text[i];

    // Literal block: ""..."" (content is kept verbatim)
    if (ch === '"' && text.startsWith('""', i)) {
      const close = text.indexOf('""', i + 2);
      if (close !== -1) {
        const end = close + 2;
        out += storeRegion(blocks, text.slice(i, end));
        i = end;
        continue;
      }
    }

    // Code block: %%...%% or ``...`` (fence length is the delimiter length)
    if (isFenceChar(ch)) {
      const runLen = countRun(text, i, ch);
      if (runLen >= BASE_LENGTH && isValidFence(text, i, runLen)) {
        const end = findBlockEnd(text, i, runLen, ch);
        if (end !== -1) {
          const inner = wrapNestedBlocks(text, i, end, runLen, ch);
          out += storeRegion(blocks, `<span class="wiki-block">${inner}</span>`);
          i = end;
          continue;
        }
      }
      // Not a valid (or unclosed) fence: ordinary content
      out += text.slice(i, i + runLen);
      i += runLen;
      continue;
    }

    // Inline code span: ##...## (maximal run, exact length closer, single line)
    if (ch === '#') {
      const runLen = countRun(text, i, ch);
      if (runLen >= INLINE_CODE_MIN_LENGTH) {
        const close = findInlineCodeEnd(text, i + runLen, runLen);
        if (close !== -1) {
          const end = close + runLen;
          out += storeRegion(blocks, `<span class="wiki-code">${text.slice(i, end)}</span>`);
          i = end;
          continue;
        }
      }
      // No matching closer on this line: ordinary content
      out += text.slice(i, i + runLen);
      i += runLen;
      continue;
    }

    out += ch;
    i++;
  }

  return out;
}

/**
 * Stores a region and returns its placeholder.
 * @param {string[]} blocks
 * @param {string} html
 * @returns {string}
 */
function storeRegion(blocks, html) {
  const id = blocks.length;
  blocks.push(html);
  return `${TOKEN_PREFIX}${id}${TOKEN_SUFFIX}`;
}

/**
 * Finds the closing run of an inline code span.
 *
 * The closing delimiter must be a maximal run of exactly `runLen` '#'.
 * Runs of a different length are ordinary content and are skipped.
 *
 * Inline code spans never cross a line break: the search stops at the end of
 * the current line, so a span without a closer on its own line is not a span.
 *
 * @param {string} text
 * @param {number} from index to start searching at
 * @param {number} runLen length of the opening delimiter
 * @returns {number} index of the first maximal run with exactly `runLen` '#', or -1
 */
function findInlineCodeEnd(text, from, runLen) {
  let i = from;

  while (i < text.length) {
    const ch = text[i];

    // Inline syntax: the span must not cross a line break
    if (ch === '\n' || ch === '\r') return -1;

    if (ch !== '#') {
      i++;
      continue;
    }

    const len = countRun(text, i, '#');
    if (len === runLen) return i;
    i += len;
  }

  return -1;
}
