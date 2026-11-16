// src/editor/features/markup-conversion.js

/**
 * Convert WackoWiki markup to Markdown (approximate) and back.
 *
 * The conversion follows the current WackoWiki formatter rules:
 *
 * ── Inline code (##…##) ─────────────────────────────────────────
 *   - The delimiter is a maximal run of '#' (N >= 2); the closing run
 *     must be a maximal run of exactly N characters. Runs with fewer
 *     '#' are ordinary content.
 *   - A span never crosses a line break.
 *   - The content is shown as typed: it is NOT parsed as wiki markup,
 *     so it is never converted (no links, no actions, no typography).
 *   - A literal '##' inside a span is written with a longer delimiter
 *     (### ## code ## ###), so the converter emits a delimiter that is
 *     longer than any '#' run inside the content.
 *
 * ── Code blocks (%%…%% and ``…``) ───────────────────────────────
 *   - The fence length is the delimiter: a block is closed by a run of
 *     exactly the same length, a run of any other length is ordinary
 *     content.
 *   - A top level block is opened by a run of at least BASE_LENGTH
 *     characters; a longer run must be alone on its line.
 *   - Nested blocks follow the k+1 rule.
 *   - The highlight options of the opening fence ((hl css wrapper=…))
 *     are reduced to the language, the rest has no Markdown equivalent.
 *
 * ── Literal pipes inside tables ─────────────────────────────────
 *   In a WackoWiki table the pipe character separates the cells. A pipe
 *   that is meant as plain text is therefore written as a literal region:
 *
 *       ""|""      WackoWiki – literal pipe (plain text)
 *       \|         Markdown  – literal pipe (plain text)
 *
 *   The same rule applies to a pipe inside inline code (##…##) and inside
 *   literal text (""…"") of a table cell – otherwise the pipe would be
 *   mistaken for a cell separator.
 */

// ── Syntax constants ───────────────────────────────────────────────

/** Minimum length of an inline code delimiter / a block fence. */
const BASE_LENGTH = 2;

/** Characters that may be used as block level code fences. */
const FENCE_CHARS = ['%', '`'];

// ── Literal pipes inside tables ───────────────────────────────────
//
// In a WackoWiki table the pipe character separates the cells. A pipe
// that is meant as plain text is therefore written as a literal region:
//
//     ""|""      WackoWiki – literal pipe (plain text)
//     \|         Markdown  – literal pipe (plain text)
//
// The same rule applies to a pipe inside inline code (##…##) and inside
// literal text (""…"") of a table cell – otherwise the pipe would be
// mistaken for a cell separator.

/** Marker used while a table row is split into cells. */
const LITERAL_PIPE_TOKEN = '\u0001LITPIPE\u0001';
const LITERAL_PIPE_RE = /\u0001LITPIPE\u0001/g;

/** Wacko syntax for a literal pipe inside a table cell. */
const WACKO_LITERAL_PIPE = '""' + '|' + '""';

// ── Low level helpers ──────────────────────────────────────────────

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
 * Returns the length of the longest run of `ch` inside the text.
 * @param {string} text
 * @param {string} ch
 * @returns {number}
 */
function longestRun(text, ch) {
  let max = 0;
  let current = 0;
  for (let i = 0; i < text.length; i++) {
    if (text[i] === ch) {
      current++;
      if (current > max) max = current;
    } else {
      current = 0;
    }
  }
  return max;
}

/**
 * Checks whether every character of the string is `ch`.
 * @param {string} str
 * @param {string} ch
 * @returns {boolean}
 */
function isRunOf(str, ch) {
  if (!str.length) return false;
  for (let i = 0; i < str.length; i++) {
    if (str[i] !== ch) return false;
  }
  return true;
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
 * @param {string} ch
 * @returns {boolean} true for spaces/tabs (line breaks excluded)
 */
function isHorizontalSpace(ch) {
  return ch === ' ' || ch === '\t' || ch === '\r' || ch === '\f' || ch === '\v';
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
 * Checks whether a fence run is allowed to act as a delimiter.
 *
 * Runs longer than BASE_LENGTH must be alone on their line, so that
 * ordinary text can neither open nor close a block. Base length runs may
 * appear inline.
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
 * Searches for a needle without crossing a line break.
 * @param {string} text
 * @param {number} from
 * @param {string} needle
 * @returns {number} index of the needle or -1
 */
function findOnLine(text, from, needle) {
  const idx = text.indexOf(needle, from);
  if (idx === -1) return -1;
  const nl = text.indexOf('\n', from);
  if (nl !== -1 && nl < idx) return -1;
  const cr = text.indexOf('\r', from);
  if (cr !== -1 && cr < idx) return -1;
  return idx;
}

/**
 * Finds the matching closing parenthesis.
 * @param {string} text
 * @param {number} index index of the opening parenthesis
 * @returns {number} index of the closing parenthesis or -1
 */
function findClosingParen(text, index) {
  let depth = 0;
  for (let i = index; i < text.length; i++) {
    if (text[i] === '(') depth++;
    else if (text[i] === ')') {
      depth--;
      if (depth === 0) return i;
    }
  }
  return -1;
}

// ── Wacko syntax scanners ──────────────────────────────────────────

/**
 * Finds the closing run of an inline code span (##…##).
 *
 * The closing delimiter must be a maximal run of exactly `runLen` '#'.
 * Runs of a different length are ordinary content and are skipped.
 *
 * Inline code spans never cross a line break: the search stops at the end
 * of the current line.
 *
 * @param {string} text
 * @param {number} from index to start searching at
 * @param {number} runLen length of the opening delimiter
 * @returns {number} index of the closing run or -1
 */
function findWackoInlineCodeEnd(text, from, runLen) {
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

/**
 * Finds the closing fence of a Wacko code block.
 *
 * The block is closed by a maximal run of exactly `openLen` characters of
 * the same fence character. A run of `openLen + 1` characters opens a nested
 * block (k+1 rule) and is skipped over. Every other run length is ordinary
 * content.
 *
 * @param {string} text
 * @param {number} from index to start searching at
 * @param {number} openLen length of the opening fence
 * @param {string} ch fence character ('%' or '`')
 * @returns {number} index of the closing run or -1
 */
function findWackoBlockEnd(text, from, openLen, ch) {
  let i = from;

  while (i < text.length) {
    if (text[i] !== ch) {
      i++;
      continue;
    }

    const runLen = countRun(text, i, ch);

    // Closing fence: exactly the same length as the opening fence
    if (runLen === openLen && isValidFence(text, i, runLen)) return i;

    // Nested block: k+1 rule
    if (runLen === openLen + 1 && isValidFence(text, i, runLen)) {
      const nestedClose = findWackoBlockEnd(text, i + runLen, runLen, ch);
      if (nestedClose !== -1) {
        i = nestedClose + runLen;
        continue;
      }
    }

    // Any other run length is ordinary content
    i += runLen;
  }

  return -1;
}

/**
 * Scans a Wacko code block at the given position.
 *
 * @param {string} text
 * @param {number} start index of the opening fence run
 * @returns {null | {content: string, language: string, end: number}}
 */
function scanWackoCodeBlock(text, start) {
  const ch = text[start];
  const openLen = countRun(text, start, ch);

  if (openLen < BASE_LENGTH) return null;
  if (!isValidFence(text, start, openLen)) return null;

  // Optional options of the opening fence: (hl css wrapper=shade)
  let pos = start + openLen;
  let options = '';
  let cursor = pos;
  while (cursor < text.length && isHorizontalSpace(text[cursor])) cursor++;
  if (text[cursor] === '(') {
    const closeParen = findClosingParen(text, cursor);
    if (closeParen !== -1) {
      options = text.slice(cursor + 1, closeParen);
      pos = closeParen + 1;
    }
  }

  const close = findWackoBlockEnd(text, pos, openLen, ch);
  if (close === -1) return null;

  return {
    content: text.slice(pos, close),
    language: parseHighlightLanguage(options),
    end: close + openLen
  };
}

/**
 * Extracts the language from the options of an opening fence.
 *
 * "(hl css wrapper=shade)" → "css"
 * @param {string} options
 * @returns {string}
 */
function parseHighlightLanguage(options) {
  if (!options) return '';
  const parts = options.trim().split(/\s+/);
  if (parts[0] && parts[0].toLowerCase() === 'hl' && parts[1]) {
    if (parts[1].indexOf('=') === -1) return parts[1];
  }
  return '';
}

/**
 * Scans a Wacko text fragment for protected regions.
 *
 * Inline code (##…##), literal text (""…"") and code blocks (%%…%% /
 * ``…``) are content and must not be touched by the inline rules.
 *
 * @param {string} text
 * @returns {Array<{type: string, content: string, start: number, end: number}>}
 */
function scanWackoRegions(text) {
  const regions = [];
  let i = 0;

  while (i < text.length) {
    const ch = text[i];

    // Code block: %%…%% or ``…`` (fence length is the delimiter length)
    if (isFenceChar(ch)) {
      const block = scanWackoCodeBlock(text, i);
      if (block) {
        regions.push({
          type: 'block',
          content: block.content,
          language: block.language,
          start: i,
          end: block.end
        });
        i = block.end;
        continue;
      }
    }

    // Inline code: ##…## (maximal run, exact length closer, single line)
    if (ch === '#') {
      const runLen = countRun(text, i, '#');
      if (runLen >= BASE_LENGTH) {
        const close = findWackoInlineCodeEnd(text, i + runLen, runLen);
        if (close !== -1) {
          regions.push({
            type: 'code',
            content: text.slice(i + runLen, close),
            start: i,
            end: close + runLen
          });
          i = close + runLen;
          continue;
        }
      }
    }

    // Literal text: ""…"" (single line)
    if (ch === '"') {
      const close = findOnLine(text, i + 2, '""');
      if (close !== -1) {
        regions.push({
          type: 'literal',
          content: text.slice(i + 2, close),
          start: i,
          end: close + 2
        });
        i = close + 2;
        continue;
      }
    }

    i++;
  }

  return regions;
}

// ── Wacko → Markdown ───────────────────────────────────────────────

/**
 * Protect pipes that are literal text inside a Wacko table row.
 *
 * Pipes inside a literal region (""…"") or inside inline code (##…##)
 * are content and not cell separators, so they are replaced by a marker
 * before the row is split into cells.
 *
 * @param {string} line - Wacko table row
 * @returns {string} Row with literal pipes replaced by LITERAL_PIPE_TOKEN
 */
function protectWackoPipes(line) {
  const regions = scanWackoRegions(line);
  if (!regions.length) return line;

  let out = '';
  let pos = 0;

  for (const region of regions) {
    out += line.slice(pos, region.start);
    out += line.slice(region.start, region.end).replace(/\|/g, LITERAL_PIPE_TOKEN);
    pos = region.end;
  }
  out += line.slice(pos);

  return out;
}

/**
 * Extract the protected regions of a Wacko table cell.
 *
 * Inline code (##…##), literal text (""…"") and code blocks must not be
 * touched by the inline formatting rules, so they are replaced by
 * placeholders. A scanner is used instead of a regular expression,
 * because escape regions can be adjacent ("""" = end of one + start of
 * the next).
 *
 * @param {string} cell - Wacko table cell
 * @returns {{text: string, regions: Array<{type: string, content: string}>}}
 */
function extractWackoRegions(cell) {
  const regions = scanWackoRegions(cell);
  let out = '';
  let pos = 0;

  regions.forEach((region, index) => {
    out += cell.slice(pos, region.start);
    out += `§§REGION${index}§§`;
    pos = region.end;
  });
  out += cell.slice(pos);

  return {
    text: out,
    regions: regions.map((region) => ({
      type: region.type,
      content: region.content,
      language: region.language
    }))
  };
}

/**
 * Converts the literal pipe marker into the Markdown escape sequence.
 * @param {string} content
 * @returns {string}
 */
function literalPipesToMarkdown(content) {
  return content.replace(LITERAL_PIPE_RE, () => '\\|');
}

/**
 * Convert the content of a Wacko inline code span to Markdown.
 *
 * The "" markers around a literal pipe are Wacko table syntax – in
 * Markdown the pipe is escaped instead.
 *
 * @param {string} content
 * @returns {string}
 */
function wackoCodeToMarkdown(content) {
  const out = content.replace(
    /""(\s*)\u0001LITPIPE\u0001(\s*)""/g,
    '$1\u0001LITPIPE\u0001$2'
  );
  return literalPipesToMarkdown(out);
}

/**
 * Convert the content of a Wacko literal region to Markdown.
 * @param {string} content
 * @returns {string}
 */
function wackoLiteralToMarkdown(content) {
  return literalPipesToMarkdown(content);
}

/**
 * Wraps content in a Markdown inline code span.
 *
 * The backtick run is longer than any backtick run inside the content and
 * a space is added when the content starts or ends with a backtick (the
 * delimiter would merge with it otherwise).
 *
 * @param {string} content
 * @returns {string}
 */
function markdownInlineCode(content) {
  const fence = '`'.repeat(Math.max(1, longestRun(content, '`') + 1));
  let body = content;
  if (body.startsWith('`') || body.endsWith('`')) body = ' ' + body + ' ';
  return fence + body + fence;
}

/**
 * Convert a Wacko inline code span to Markdown.
 *
 * The content is shown as typed – it is not parsed as wiki markup, so it
 * is copied verbatim into the Markdown code span.
 *
 * @param {string} content
 * @returns {string}
 */
function wackoInlineCodeToMarkdown(content) {
  return markdownInlineCode(wackoCodeToMarkdown(content));
}

/**
 * Convert a Wacko code block to a Markdown fenced code block.
 *
 * The backtick fence is longer than any backtick run inside the content.
 *
 * @param {{content: string, language: string}} block
 * @returns {string}
 */
function wackoCodeBlockToMarkdown(block) {
  const code = block.content.trim();
  const fence = '`'.repeat(Math.max(3, longestRun(code, '`') + 1));
  const info = block.language ? block.language + '\n' : '';
  return fence + info + code + '\n' + fence;
}

/**
 * Finds the end of a Wacko table block (#| … |#).
 * @param {string} text
 * @param {number} start index of the opening "#|"
 * @returns {number} index after the closing "|#" or -1
 */
function findWackoTableEnd(text, start) {
  const re = /\|\|?#/g;
  re.lastIndex = start + 2;
  const match = re.exec(text);
  return match ? match.index + match[0].length : -1;
}

/**
 * Extracts the protected regions of a Wacko document.
 *
 * The regions are extracted in the order of the source text, so the region
 * that starts first wins (e.g. ""##x##"" is a literal region, ##""x""## is
 * an inline code span). The content of a region is never parsed as wiki
 * markup.
 *
 * @param {string} text
 * @param {string[]} placeholders shared placeholder store
 * @returns {string} text with placeholders
 */
function scanWackoDocument(text, placeholders) {
  let out = '';
  let i = 0;

  while (i < text.length) {
    const ch = text[i];

    // Table: #| … |#
    if (ch === '#' && text.startsWith('#|', i)) {
      const end = findWackoTableEnd(text, i);
      if (end !== -1) {
        placeholders.push(wackoTableToMarkdown(text.slice(i, end)));
        out += `§§TABLE${placeholders.length - 1}§§`;
        i = end;
        continue;
      }
    }

    // Code block: %%…%% or ``…`` (fence length is the delimiter length)
    if (isFenceChar(ch)) {
      const block = scanWackoCodeBlock(text, i);
      if (block) {
        placeholders.push(wackoCodeBlockToMarkdown(block));
        out += `§§CODEBLOCK${placeholders.length - 1}§§`;
        i = block.end;
        continue;
      }
    }

    // Inline code: ##…## (maximal run, exact length closer, single line)
    if (ch === '#') {
      const runLen = countRun(text, i, '#');
      if (runLen >= BASE_LENGTH) {
        const close = findWackoInlineCodeEnd(text, i + runLen, runLen);
        if (close !== -1) {
          placeholders.push(wackoInlineCodeToMarkdown(text.slice(i + runLen, close)));
          out += `§§INLINECODE${placeholders.length - 1}§§`;
          i = close + runLen;
          continue;
        }
      }
    }

    // Literal text: ""…"" (single line)
    if (ch === '"') {
      const close = findOnLine(text, i + 2, '""');
      if (close !== -1) {
        placeholders.push(text.slice(i + 2, close));
        out += `§§ESCAPED${placeholders.length - 1}§§`;
        i = close + 2;
        continue;
      }
    }

    out += ch;
    i++;
  }

  return out;
}

/**
 * Convert WackoWiki markup to Markdown (approximate).
 * @param {string} text - Wacko markup text
 * @returns {string} Markdown text
 */
export function wackoToMarkdown(text) {
  let md = text;
  const placeholders = [];

  // 0. Protected regions are extracted FIRST – their content is shown as
  //    typed and is never parsed as wiki markup. The scan follows the
  //    order of the source text, so the region that starts first wins.
  md = scanWackoDocument(md, placeholders);

  // 1. Headings: === Title === → ## Title (etc.)
  md = md.replace(/^={2,7}\s*(.*?)\s*={2,}$/gm, (match, title) => {
    const level = match.match(/^=+/)[0].length;
    const marker = '#'.repeat(level - 1);
    placeholders.push(marker);
    return `§§HEADING${placeholders.length - 1}§§ ${title.trim()}`;
  });

  // Italic: //text// → *text*
  md = md.replace(/\/\/(.*?)\/\//g, '*\$1*');
  // Strikethrough: --text-- → ~~text~~
  md = md.replace(/--(.*?)--/g, '~~\$1~~');
  // Small text: ++text++ → <small>text</small>
  md = md.replace(/\+\+(.*?)\+\+/g, '<small>$1</small>');
  // Highlight / Marked text: ??text?? and !!text!! → **text**
  md = md.replace(/\?\?(.*?)\?\?/g, '**\$1**');
  md = md.replace(/!!(.*?)!!/g, '**\$1**');
  md = md.replace(/!!\([^)]+\)(.*?)!!/g, '$1');

  // Quote: <[ text ]> → > text
  md = md.replace(/<\[(.*?)\]>/gs, '> $1');

  // Lists: leading * → -
  md = md.replace(/^(\s*)[*-]\s+/gm, '$1- ');

  // Links: ((url text)) → [text](url)
  md = md.replace(/\(\(([^)]+?)\s+([^\)]+?)\)\)/g, '[\$2](\$1)');
  // Wiki pages: [[page]] → [page](page)
  md = md.replace(/\[\[([^\]]+?)\]\]/g, '[\$1](\$1)');

  // Horizontal rule: ---- → ---
  md = md.replace(/^----$/gm, '---');

  // Restore placeholders in order
  md = md.replace(/§§TABLE(\d+)§§/g, (match, idx) => placeholders[Number(idx)]);
  md = md.replace(/§§INLINECODE(\d+)§§/g, (match, idx) => placeholders[Number(idx)]);
  md = md.replace(/§§CODEBLOCK(\d+)§§/g, (match, idx) => placeholders[Number(idx)]);
  md = md.replace(/§§HEADING(\d+)§§/g, (match, idx) => placeholders[Number(idx)]);
  md = md.replace(/§§ESCAPED(\d+)§§/g, (match, idx) => placeholders[Number(idx)]);

  return md;
}

/**
 * Convert a single Wacko table block (#| … |#) to Markdown.
 * @param {string} block - Wacko table block
 * @returns {string} Markdown table
 */
function wackoTableToMarkdown(block) {
  const lines = block.split(/\r?\n/).filter(l => l.trim());
  const mdRows = [];
  let headerRow = null;

  // Helper function to apply inline formatting to cell content
  const formatCellContent = (content) => {
    // Split the cell into protected regions (inline code / literal text /
    // code blocks) and plain text, so that the inline rules cannot touch
    // them.
    const { text, regions } = extractWackoRegions(content);
    let out = text;

    // Italic
    out = out.replace(/\/\/(.*?)\/\//g, '*$1*');

    // Bold (Wacko uses ** or !!)
    out = out.replace(/\*\*(.*?)\*\*/g, '**\$1**');

    // Strikethrough
    out = out.replace(/--(.*?)--/g, '~~\$1~~');

    // Small text
    out = out.replace(/\+\+(.*?)\+\+/g, '<small>$1</small>');

    // Highlight/Marked
    out = out.replace(/\?\?(.*?)\?\?/g, '**\$1**');
    out = out.replace(/!!(.*?)!!/g, '**\$1**');
    out = out.replace(/!!\([^)]+\)(.*?)!!/g, '$1');

    // Links
    out = out.replace(/\(\(([^)]+?)\s+([^\)]+?)\)\)/g, '[\$2](\$1)');
    out = out.replace(/\[\[([^\]]+?)\]\]/g, '[\$1](\$1)');

    // Restore the protected regions
    out = out.replace(/§§REGION(\d+)§§/g, (match, idx) => {
      const region = regions[Number(idx)];
      if (!region) return '';
      if (region.type === 'code') {
        return markdownInlineCode(wackoCodeToMarkdown(region.content));
      }
      if (region.type === 'block') {
        return markdownInlineCode(literalPipesToMarkdown(region.content.trim()));
      }
      return wackoLiteralToMarkdown(region.content);
    });

    return out;
  };

  for (let line of lines) {
    line = line.trim();

    // Skip opening/closing markers
    if (line === '#|' || line === '#||' || line === '|#' || line === '||#') continue;

    // Protect literal pipes (inside ""…"" or ##…##) BEFORE the row is
    // split – otherwise a literal pipe would be a cell separator.
    line = protectWackoPipes(line);

    let isHeader = false;
    if (line.startsWith('*|') || line.endsWith('|*')) {
      isHeader = true;
      // Remove header markers
      line = line.replace(/^\*\|?\s*/, '').replace(/\s*\|?\*$/, '');
    } else {
      // Remove row markers
      line = line.replace(/^\|?\|\s*/, '').replace(/\s*\|\|?\s*$/, '');
    }

    // Strip cell attributes like (colspan=2 align=center) – only real
    // attributes, so that ordinary text such as (i.e. …) is preserved.
    line = line.replace(/\(\s*[a-z_][a-z0-9_-]*\s*=\s*[^)]*\)/gi, '');

    // Split into cells and apply formatting to each cell
    // (literal pipes are protected and do not split the row)
    const cells = line.split('|').map(cell => {
      return formatCellContent(cell.trim());
    });

    if (cells.length < 1) continue;

    if (isHeader) {
      headerRow = '| ' + cells.join(' | ') + ' |';
    } else {
      mdRows.push('| ' + cells.join(' | ') + ' |');
    }
  }

  // Build markdown table
  let mdTable = '';
  if (headerRow) {
    mdTable += headerRow + '\n';
    // Count actual columns in header
    const cols = headerRow.split('|').filter(c => c.trim()).length;
    mdTable += '| ' + Array(cols).fill('---').join(' | ') + ' |\n';
  }
  mdTable += mdRows.join('\n');

  return mdTable;
}

// ── Markdown → Wacko ───────────────────────────────────────────────

/**
 * Finds the closing run of a Markdown inline code span.
 *
 * The closing delimiter must be a maximal run of exactly `runLen`
 * backticks. Inline code spans never cross a line break.
 *
 * @param {string} text
 * @param {number} from index to start searching at
 * @param {number} runLen length of the opening delimiter
 * @returns {number} index of the closing run or -1
 */
function findMarkdownInlineCodeEnd(text, from, runLen) {
  let i = from;

  while (i < text.length) {
    const ch = text[i];

    if (ch === '\n' || ch === '\r') return -1;

    if (ch !== '`') {
      i++;
      continue;
    }

    const len = countRun(text, i, '`');
    if (len === runLen) return i;
    i += len;
  }

  return -1;
}

/**
 * Extracts the Markdown inline code spans.
 *
 * The raw content is stored, so that a table cell can convert a literal
 * pipe inside the code span (see markdownTableToWacko).
 *
 * @param {string} text
 * @param {string[]} placeholders shared placeholder store
 * @returns {string} text with placeholders
 */
function scanMarkdownInlineCode(text, placeholders) {
  let out = '';
  let i = 0;

  while (i < text.length) {
    if (text[i] === '`') {
      const runLen = countRun(text, i, '`');
      const close = findMarkdownInlineCodeEnd(text, i + runLen, runLen);
      if (close !== -1) {
        let content = text.slice(i + runLen, close);

        // CommonMark: a space on both sides of the content is stripped
        if (content.length > 2 && content.startsWith(' ') &&
            content.endsWith(' ') && content.trim().length) {
          content = content.slice(1, -1);
        }

        placeholders.push(content);
        out += `§§INLINECODE${placeholders.length - 1}§§`;
        i = close + runLen;
        continue;
      }
    }

    out += text[i];
    i++;
  }

  return out;
}

/**
 * Matches an opening Markdown code fence at the given position.
 *
 * The fence must be at the beginning of a line (indentation allowed) and
 * consist of at least three backticks or tildes.
 *
 * @param {string} text
 * @param {number} index
 * @returns {null | {char: string, length: number, info: string, contentStart: number}}
 */
function matchMarkdownFenceOpen(text, index) {
  // The fence must be at the beginning of a line (indentation allowed)
  let lineStart = index;
  while (lineStart > 0 && text[lineStart - 1] !== '\n') lineStart--;
  for (let k = lineStart; k < index; k++) {
    if (text[k] !== ' ' && text[k] !== '\t') return null;
  }

  const ch = text[index];
  if (ch !== '`' && ch !== '~') return null;

  const len = countRun(text, index, ch);
  if (len < 3) return null;

  let lineEnd = text.indexOf('\n', index);
  if (lineEnd === -1) lineEnd = text.length;
  const info = text.slice(index + len, lineEnd).trim();

  // The info string of a backtick fence must not contain a backtick
  if (ch === '`' && info.indexOf('`') !== -1) return null;

  return {
    char: ch,
    length: len,
    info,
    contentStart: lineEnd < text.length ? lineEnd + 1 : lineEnd
  };
}

/**
 * Finds the closing Markdown code fence.
 * @param {string} text
 * @param {number} from index to start searching at
 * @param {string} ch fence character
 * @param {number} minLen minimum length of the closing fence
 * @returns {null | {contentStart: number, end: number}}
 */
function findMarkdownFenceClose(text, from, ch, minLen) {
  let i = from;

  while (i <= text.length) {
    let lineEnd = text.indexOf('\n', i);
    if (lineEnd === -1) lineEnd = text.length;

    const line = text.slice(i, lineEnd).trim();
    if (line.length >= minLen && isRunOf(line, ch)) {
      return {
        contentStart: i,
        end: lineEnd < text.length ? lineEnd + 1 : lineEnd
      };
    }

    if (lineEnd >= text.length) break;
    i = lineEnd + 1;
  }

  return null;
}

/**
 * Chooses the Wacko fence for a code block.
 *
 * The fence must be longer than any '%' run inside the content, so that a
 * '%%' inside the block stays content ("own escape" rule) and is not
 * mistaken for a nested block (k+1 rule).
 *
 * @param {string} content
 * @returns {string} the fence
 */
function chooseWackoFence(content) {
  return '%'.repeat(Math.max(BASE_LENGTH, longestRun(content, '%') + 1));
}

/**
 * Convert a Markdown fenced code block to a Wacko code block.
 * @param {string} content
 * @param {string} info info string of the fence (e.g. "js")
 * @returns {string}
 */
function markdownCodeBlockToWacko(content, info) {
  const code = content.trim();
  const language = (info || '').trim().split(/\s+/)[0] || '';
  const fence = chooseWackoFence(code);
  const header = language ? `${fence}(hl ${language})` : fence;
  return `${header}\n${code}\n${fence}`;
}

/**
 * Extracts the Markdown fenced code blocks.
 * @param {string} text
 * @param {string[]} placeholders shared placeholder store
 * @returns {string} text with placeholders
 */
function scanMarkdownCodeBlocks(text, placeholders) {
  let out = '';
  let i = 0;

  while (i < text.length) {
    const fence = matchMarkdownFenceOpen(text, i);
    if (fence) {
      const close = findMarkdownFenceClose(text, fence.contentStart, fence.char, fence.length);
      if (close) {
        const content = text.slice(fence.contentStart, close.contentStart);
        placeholders.push(markdownCodeBlockToWacko(content, fence.info));
        out += `§§CODEBLOCK${placeholders.length - 1}§§`;
        i = close.end;
        continue;
      }
    }

    out += text[i];
    i++;
  }

  return out;
}

/**
 * Convert a Markdown inline code span to Wacko.
 *
 * The delimiter is a maximal run of '#' that is longer than any '#' run
 * inside the content – a literal '##' therefore needs a longer delimiter
 * (### ## code ## ###).
 *
 * @param {string} content
 * @returns {string}
 */
function wackoInlineCode(content) {
  const len = Math.max(BASE_LENGTH, longestRun(content, '#') + 1);
  let body = content;

  if (!body) {
    body = ' ';
  } else if (body.startsWith('#') || body.endsWith('#')) {
    // The delimiter must be a maximal run – a space keeps it separated
    // from a '#' at the beginning or at the end of the content.
    body = ' ' + body + ' ';
  }

  return '#'.repeat(len) + body + '#'.repeat(len);
}

/**
 * Convert Markdown to WackoWiki markup (approximate).
 * @param {string} text - Markdown text
 * @returns {string} Wacko markup text
 */
export function markdownToWacko(text) {
  let w = text;
  const placeholders = [];

  // 1. Fenced code blocks: ```lang … ``` → %%(hl lang) … %%
  //    The fence of the Wacko block is longer than any '%' run inside the
  //    content, so a '%%' inside the code stays content.
  w = scanMarkdownCodeBlocks(w, placeholders);

  // 2. Inline code: `text` → ##text##
  //    The RAW content is stored, so that a table cell can convert a
  //    literal pipe inside the code span (see markdownTableToWacko).
  w = scanMarkdownInlineCode(w, placeholders);

  // 3. Horizontal rules: ---, ***, ___ → ----
  w = w.replace(/^(?:[-*_]){3,}[ \t]*$/gm, '----');

  // 4. Blockquote: > text → <[text]>
  w = w.replace(/^>\s+(.*)$/gm, '<[$1]>');

  // 5. Lists: normalize indentation to Wacko conventions
  w = w.replace(
    /^(?!\s*----)(?!\s*\*\*)(\s*)([*+-]|\d+\.|[A-Za-z]\.)([ \t]*)/gm,
    (match, indent, marker, postSpace) => {
      const len = indent.length;
      let newIndent = indent;
      if (len % 4 === 0 && len >= 4) {
        newIndent = ' '.repeat(len / 2 + 2);
      } else if (len < 4) {
        newIndent = '  ';
      }
      return newIndent + marker + postSpace;
    }
  );

  // 6. Headings: # Title → === Title === (etc.)
  w = w.replace(/^#{1,7}\s+(.*)$/gm, (match, title) => {
    const level = match.match(/^#+/)[0].length;
    const marker = '='.repeat(level + 1);
    return `${marker} ${title} ${marker}`;
  });

  // 7. Bold: already compatible (but convert __text__ → **text**)
  w = w.replace(/__(.*?)__/g, '**$1**');

  // 8. Italic: *text* → //text//
  w = w.replace(
    /(^|[^*\w])\*(?!\*)([^*\s][^*]*[^*\s])\*(?![*\w])/g,
    '\$1//\$2//'
  );
  w = w.replace(
    /(^|[^*\w])\*(?!\*)([^*\s])\*(?![*\w])/g,
    '\$1//\$2//'
  );

  // 9. Italic: _text_ → //text//
  w = w.replace(
    /(^|[^_\w])_(?!_)([^_\s][^_]*[^_\s])_(?![_\w])/g,
    '\$1//\$2//'
  );
  w = w.replace(
    /(^|[^_\w])_(?!_)([^_\s])_(?![_\w])/g,
    '\$1//\$2//'
  );

  // 10. Strikethrough: ~~text~~ → --text--
  w = w.replace(/~~(.*?)~~/g, '--$1--');
  // Small text: <small>text</small> → ++text++
  w = w.replace(/<small>(.*?)<\/small>/g, '++$1++');

  // 11. Images: ![alt](url) → ((url alt))
  w = w.replace(/!\[([^\]]*)\]\(([^)]+)\)/g, '((\$2 \$1))');

  // 12. Links: [text](url) → ((url text))
  w = w.replace(/\[([^\]]+)\]\(([^)]+)\)/g, '((\$2 \$1))');

  // 13. Tables: Markdown table blocks → Wacko table
  w = w.replace(
    /^(?:\|.*\|\n\|[-:\s|]+\|\n(?:\|.*\|\n?)+)/gm,
    block => markdownTableToWacko(block, placeholders)
  );

  // Restore code blocks and inline code placeholders
  w = w.replace(/§§CODEBLOCK(\d+)§§/g, (match, idx) => placeholders[Number(idx)]);
  w = w.replace(/§§INLINECODE(\d+)§§/g, (match, idx) => {
    return wackoInlineCode(placeholders[Number(idx)] ?? '');
  });

  return w;
}

/**
 * Convert a single Markdown table block to Wacko table.
 * @param {string} block - Markdown table block
 * @param {string[]} placeholders - Shared placeholder store (inline code)
 * @returns {string} Wacko table
 */
function markdownTableToWacko(block, placeholders = []) {
  const lines = block.trim().split(/\r?\n/);
  if (lines.length < 3) return block; // not a valid table

  let wacko = '#|\n';

  /**
   * Split a Markdown table row into cells.
   *
   * An escaped pipe (\|) is a literal pipe inside the cell – it does not
   * separate cells and becomes ""|"" in Wacko markup.
   *
   * Drops only the empty first/last entries produced by the surrounding
   * `|` pipes, preserving empty cells inside the row.
   */
  const splitRow = (line) => {
    const cells = [];
    let current = '';

    for (let i = 0; i < line.length; i++) {
      const ch = line[i];

      // Escaped pipe → literal pipe inside the cell
      if (ch === '\\' && line[i + 1] === '|') {
        current += LITERAL_PIPE_TOKEN;
        i++;
        continue;
      }

      // Escaped backslash → a single literal backslash
      if (ch === '\\' && line[i + 1] === '\\') {
        current += '\\';
        i++;
        continue;
      }

      // Cell separator
      if (ch === '|') {
        cells.push(current);
        current = '';
        continue;
      }

      current += ch;
    }
    cells.push(current);

    const parts = cells.map(c => c.trim());
    if (parts.length && parts[0] === '') parts.shift();
    if (parts.length && parts[parts.length - 1] === '') parts.pop();
    return parts;
  };

  /**
   * Resolve inline code placeholders inside a cell.
   *
   * Inline code was replaced by a placeholder before the table was
   * converted, so that its content is not touched by the other rules.
   * Inside a table cell a pipe is literal text and therefore has to use
   * the Wacko literal pipe syntax ("" | "").
   */
  const resolveInlineCode = (cell) => cell.replace(/§§INLINECODE(\d+)§§/g, (match, idx) => {
    const content = placeholders[Number(idx)] ?? '';
    const escaped = content
      .replace(/\\\|/g, LITERAL_PIPE_TOKEN)   // escaped pipe → literal pipe
      .replace(/\|/g, LITERAL_PIPE_TOKEN);    // raw pipe → literal pipe
    return wackoInlineCode(escaped);
  });

  const headerCells = splitRow(lines[0]).map(resolveInlineCode);
  if (headerCells.length) {
    wacko += '*| ' + headerCells.join(' | ') + ' |*\n';
  }

  // Skip separator line (lines[1])
  for (let i = 2; i < lines.length; i++) {
    const cells = splitRow(lines[i]).map(resolveInlineCode);
    if (cells.length) {
      wacko += '|| ' + cells.join(' | ') + ' ||\n';
    }
  }

  wacko += '|#\n';

  // Literal pipes (\|) become ""|"" in Wacko markup
  return wacko.replace(LITERAL_PIPE_RE, () => WACKO_LITERAL_PIPE);
}
