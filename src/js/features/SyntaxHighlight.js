// src/js/features/SyntaxHighlight.js

import logger from '../utils/logger.js';

/**
 * Sets up the syntax highlighting overlay and attaches all related listeners.
 * Call once during init, after the toolbar is built.
 * @param {import('../core/WikiEdit.js').WikiEdit} editor
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
  ['font', 'lineHeight', 'tabSize', 'letterSpacing', 'wordSpacing', 'padding'].forEach(prop => {
    editor.highlighter.style[prop] = style[prop];
  });

  // Load saved syntax state from localStorage (overrides data-attribute)
  const saved = localStorage.getItem('we_syntax_enabled');
  if (saved !== null) {
    editor.syntaxHighlighting = saved === 'true';
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
 * @param {import('../core/WikiEdit.js').WikiEdit} editor
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
 * @param {import('../core/WikiEdit.js').WikiEdit} editor
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
 * @param {import('../core/WikiEdit.js').WikiEdit} editor
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
 * @param {import('../core/WikiEdit.js').WikiEdit} editor
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
 * @param {import('../core/WikiEdit.js').WikiEdit} editor
 */
function toggleSyntaxHighlight(editor) {
  if (editor.syntaxHighlightEnabled) {
    disableSyntaxHighlighting(editor);
  } else {
    enableSyntaxHighlighting(editor);
  }

  localStorage.setItem('we_syntax_enabled', editor.syntaxHighlightEnabled);
  editor.updateToolbarButtonStates();
}

/**
 * Synchronizes the overlay dimensions with the textarea.
 * @param {import('../core/WikiEdit.js').WikiEdit} editor
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
 * @param {string} text
 * @returns {string} HTML with span-wrapped tokens
 */
function highlightWikiSyntax(text) {
  if (!text) return '';

  let html = text
    .replace(/&/g, '&amp;')
    .replace(/</g, '&lt;')
    .replace(/>/g, '&gt;');

  // Extract code blocks and literal blocks (""..."" and %%...%%) to protect them
  const blocks = [];
  html = html.replace(/(""[\s\S]*?""|%%[\s\S]*?%%|``[\s\S]*?``)/g, (match) => {
    const id = blocks.length;
    if (match.startsWith('""')) {
      blocks.push({ type: 'literal', content: match });
    } else {
      blocks.push({ type: 'block', content: `<span class="wiki-block">${match}</span>` });
    }
    return `WIKI_TOKEN_${id}`;
  });

  // Apply inline syntax highlighting to the rest
  html = html.replace(/^(={3,7})(.+?)\1/gm, '<span class="wiki-h">\$1\$2$1</span>');
  html = html.replace(/\*\*(?!\s)(.+?)(?<!\s)\*\*/g, '<span class="wiki-bold">**$1**</span>');
  html = html.replace(/\/\/(?!\s)(.+?)(?<!\s)\/\//g, '<span class="wiki-italic">//$1//</span>');
  html = html.replace(/\+\+(?!\s)(.+?)(?<!\s)\+\+/g, '<span class="wiki-italic">++$1++</span>');
  html = html.replace(/__(?!\s)(.+?)(?<!\s)__/g, '<span class="wiki-underline">__$1__</span>');
  html = html.replace(/--(?!\s)(.+?)(?<!\s)--/g, '<span class="wiki-strike">--$1--</span>');
  html = html.replace(/##(?!\s)(.+?)(?<!\s)##/g, '<span class="wiki-code">##$1##</span>');
  html = html.replace(/\[\[(.+?)\]\]/g, '<span class="wiki-link">[[$1]]</span>');
  html = html.replace(/\(\((.+?)\)\)/g, '<span class="wiki-link">(($1))</span>');
  html = html.replace(/(file:((\.\.|!)\/|\/)?[\p{L}\p{Nd}][\p{L}\p{Nd}\/._-]*\.[\p{L}\p{Nd}]+(\?[a-zA-Z0-9&=]*)?)/ug, '<span class="wiki-link">$1</span>');
  html = html.replace(/(^([ ]{2}|\t)+(([*-]|\d+\.|[a-zA-Z]\.))[ \t]+)/gm, '<span class="wiki-list">$1</span>');
  html = html.replace(/&lt;\[.*?\]&gt;/gs, '<span class="wiki-block">$&</span>');
  html = html.replace(/(\{\{)(.+?)(\}\})/gs, '<span class="wiki-block">\$1\$2$3</span>');
  html = html.replace(/(\?\?)(?=\S)(.+?)(?<=\S)(\?\?)/gs, '<span class="wiki-block">\$1\$2$3</span>');
  html = html.replace(/(\!\!)(?=\S)(.+?)(?<=\S)(\!\!)/gs, '<span class="wiki-block">\$1\$2$3</span>');
  html = html.replace(/^----$/gm, '<span class="wiki-hr">----</span>');

  // Restore protected blocks
  html = html.replace(/WIKI_TOKEN_(\d+)/g, (match, id) => {
    return blocks[parseInt(id, 10)].content;
  });

  return html;
}
