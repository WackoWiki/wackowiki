// src/js/editor/features/markup-helpers.js

import logger from '../../utils/logger.js';

/**
 * Attach all markup helper methods to the editor instance.
 * Call once during init, before any toolbar or keyboard actions.
 * @param {import('../editor/wikiedit.js').WikiEdit} editor
 */
export function setupMarkupHelpers(editor) {
  // Selection helper – must be available to other methods
  editor.getDefines = () => getDefines(editor);

  // ── Public markup operations ────────────────────────────────────
  editor.MarkUp = (tag, text, tag2, onNewLine, expand, strip) =>
    MarkUp(editor, tag, text, tag2, onNewLine, expand, strip);

  editor.insTag = (tag, tag2, onNewLine, expand, strip) =>
    insTag(editor, tag, tag2, onNewLine, expand, strip);

  editor.insBlockWrapper = (openTag, closeTag) =>
    insBlockWrapper(editor, openTag, closeTag);

  // ── New code syntax: inline code (##…##) and code blocks (%%…%%) ─
  editor.insCode = () => insCode(editor);
  editor.insCodeBlock = () => insCodeBlock(editor);

  editor.unindent = () => unindent(editor);

  logger.debug('MarkupHelpers: setup complete');
}

// ── Selection helper ──────────────────────────────────────────────

function getDefines(editor) {
  const t = editor.area;
  const text = t.value;

  editor.ss = t.selectionStart;
  editor.se = t.selectionEnd;
  editor.sel1 = text.slice(0, editor.ss);
  editor.sel2 = text.slice(editor.se);
  editor.sel = text.slice(editor.ss, editor.se);
  editor.str = editor.sel1 + editor.begin + editor.sel + editor.end + editor.sel2;
  editor.scroll = t.scrollTop;
}

// ── Regex patterns (extracted for clarity and reuse) ──────────────

/**
 * Matches list item patterns at start of line:
 * - Unordered: `*`, `**` (bold list), etc.
 * - Ordered: `1.`, `2)`, `a.`, `A)`, etc.
 */
const LIST_ITEM_RE = /^([ ]*)(([*-]|([1-9]\d*|[\p{Ll}\p{Lu}])([.]|[)]))( |))(.*)$/u;

/**
 * Matches bold marker `**` at start of text (after leading whitespace).
 */
const BOLD_MARKER_RE = /^([ ]*)([*][*])(.*)$/;

/**
 * Matches leading whitespace + any content.
 */
const LEADING_WHITESPACE_RE = /^([ ]*)(.*)$/;

/**
 * Matches trailing whitespace at end of text.
 */
const TRAILING_WHITESPACE_RE = /^(.*)([ ]*)$/;

// ═══════════════════════════════════════════════════════════════════
//  CODE SYNTAX – inline code (##…##) and code blocks (%%…%% / ``…``)
// ═══════════════════════════════════════════════════════════════════

/**
 * Minimum length of an inline code delimiter / a block fence.
 */
const CODE_BASE_LENGTH = 2;

/**
 * Characters that may be used as block level code fences.
 */
const CODE_FENCE_CHARS = ['%', '`'];

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
 * @param {string} ch
 * @returns {boolean} true if the character may be used as a block fence
 */
function isFenceChar(ch) {
  return CODE_FENCE_CHARS.indexOf(ch) !== -1;
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
 * Runs longer than BASE_LENGTH must be alone on their line.
 * @param {string} text
 * @param {number} index start of the run
 * @param {number} runLen length of the run
 * @returns {boolean}
 */
function isValidFence(text, index, runLen) {
  if (runLen <= CODE_BASE_LENGTH) return true;
  return isAloneOnLine(text, index, runLen);
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

/**
 * Finds the closing run of an inline code span (##…##).
 *
 * The closing delimiter must be a maximal run of exactly `runLen` '#'.
 * Runs of a different length are ordinary content and are skipped.
 * An inline span never crosses a line break.
 *
 * @param {string} text
 * @param {number} from index to start searching at
 * @param {number} runLen length of the opening delimiter
 * @returns {number} index of the closing run or -1
 */
function findInlineCodeEnd(text, from, runLen) {
  let i = from;

  while (i < text.length) {
    const ch = text[i];

    if (ch === '\n' || ch === '\r') return -1;
    if (ch !== '#') { i++; continue; }

    const len = countRun(text, i, '#');
    if (len === runLen) return i;
    i += len;
  }

  return -1;
}

/**
 * Finds the closing fence of a code block.
 *
 * The block is closed by a maximal run of exactly `openLen` characters of
 * the same fence character. A run of `openLen + 1` characters opens a nested
 * block (k+1 rule) and is skipped over. Every other run length is ordinary
 * content ("own escape" rule).
 *
 * @param {string} text
 * @param {number} from index to start searching at
 * @param {number} openLen length of the opening fence
 * @param {string} ch fence character ('%' or '`')
 * @returns {number} index of the closing run or -1
 */
function findBlockClose(text, from, openLen, ch) {
  let i = from;

  while (i < text.length) {
    if (text[i] !== ch) { i++; continue; }

    const runLen = countRun(text, i, ch);

    // Closing fence: exactly the same length as the opening fence
    if (runLen === openLen && isValidFence(text, i, runLen)) return i;

    // Nested block: k+1 rule
    if (runLen === openLen + 1 && isValidFence(text, i, runLen)) {
      const nestedClose = findBlockClose(text, i + runLen, runLen, ch);
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
 * Scans a code block at the given position.
 *
 * @param {string} text
 * @param {number} start index of the opening fence run
 * @param {string} ch fence character
 * @param {number} runLen length of the opening fence run
 * @returns {null | object} the block region
 */
function scanCodeBlock(text, start, ch, runLen) {
  // Optional options of the opening fence: (hl css wrapper=shade)
  let headerEnd = start + runLen;
  let options = '';
  let cursor = headerEnd;

  while (cursor < text.length && isHorizontalSpace(text[cursor])) cursor++;
  if (text[cursor] === '(') {
    const closeParen = findClosingParen(text, cursor);
    if (closeParen !== -1) {
      options = text.slice(cursor + 1, closeParen);
      headerEnd = closeParen + 1;
    }
  }

  // The content starts after the line break that terminates the fence line
  const lineEnd = text.indexOf('\n', headerEnd);
  const contentStart = lineEnd === -1 ? headerEnd : lineEnd + 1;

  const close = findBlockClose(text, contentStart, runLen, ch);
  if (close === -1) return null;

  // A 'wacko wrapper=…' block is a *text* wrapper (the content is still
  // parsed as wiki markup) – it is not a literal code block.
  const literal = !/\bwacko\s+wrapper\s*=/i.test(options);

  return {
    type: 'block',
    start,                 // index of the opening fence run
    end: close + runLen,   // index after the closing fence run
    headerEnd,             // index after the opening run (+ options)
    contentStart,          // index where the content starts
    contentEnd: close,     // index where the closing fence starts
    closeStart: close,
    closeEnd: close + runLen,
    fenceLen: runLen,
    fenceChar: ch,
    literal
  };
}

/**
 * Scans the text for all code regions (inline code and code blocks).
 *
 * The rules are the same as in the highlighter and in the syntax converter:
 *  - inline code: maximal run of '#' (N >= 2), closer is a maximal run of
 *    exactly N, never crosses a line break;
 *  - code blocks: the fence length is the delimiter, a run longer than
 *    BASE_LENGTH must be alone on its line, nested blocks use N+1.
 *
 * @param {string} text
 * @returns {Array<object>} the regions in the order of the source text
 */
function scanCodeRegions(text) {
  const regions = [];
  let i = 0;

  while (i < text.length) {
    const ch = text[i];

    // Code block: %%…%% or ``…``
    if (isFenceChar(ch)) {
      const runLen = countRun(text, i, ch);
      if (runLen >= CODE_BASE_LENGTH && isValidFence(text, i, runLen)) {
        const block = scanCodeBlock(text, i, ch, runLen);
        if (block) {
          regions.push(block);
          i = block.end;
          continue;
        }
      }
      i += runLen;
      continue;
    }

    // Inline code span: ##…##
    if (ch === '#') {
      const runLen = countRun(text, i, '#');
      if (runLen >= CODE_BASE_LENGTH) {
        const close = findInlineCodeEnd(text, i + runLen, runLen);
        if (close !== -1) {
          regions.push({
            type: 'inline',
            start: i,
            end: close + runLen,
            contentStart: i + runLen,
            contentEnd: close,
            fenceLen: runLen
          });
          i = close + runLen;
          continue;
        }
      }
      i += runLen;
      continue;
    }

    i++;
  }

  return regions;
}

/**
 * Returns all code regions that contain the given selection.
 * @param {Array<object>} regions
 * @param {number} start
 * @param {number} end
 * @returns {Array<object>}
 */
function findContainingRegions(regions, start, end) {
  return regions.filter(region => {
    if (region.start > start || end > region.end) return false;
    // An empty selection (cursor) must not sit behind the region
    if (start === end && start >= region.end) return false;
    return true;
  });
}

/**
 * Checks whether the selection overlaps a code region without being
 * contained in it (the content of a code region is literal).
 * @param {Array<object>} regions
 * @param {number} start
 * @param {number} end
 * @returns {boolean}
 */
function overlapsRegion(regions, start, end) {
  if (start === end) {
    return regions.some(r => r.start < start && start < r.end);
  }
  return regions.some(r => r.start < end && start < r.end);
}

// ── Inline selection helpers ─────────────────────────────────────

/**
 * Inserts tag at the beginning of text, with special handling for:
 * - Bold markers (`**`) - inserts before the `**`
 * - List items - inserts after the list marker
 *
 * @param {string} tag - The tag to insert
 * @param {string} text - The text to process
 * @param {number} skip - If 1, apply special list/bold detection
 * @returns {string} Modified text with tag inserted at start
 */
function wrapInlineSelection(tag, text, skip) {
  // Special handling for bold marker detection (skip === 1)
  if (skip) {
    // Case: **bold** style - insert before the **
    let match = text.match(BOLD_MARKER_RE);
    if (match) {
      return match[1] + tag + match[2] + match[3];
    }

    // Case: List item - insert after the list marker
    // Pattern: leading whitespace + marker + optional space + content
    match = text.match(LIST_ITEM_RE);
    if (match) {
      // match[1] = leading ws, match[2] = list marker, match[7] = content after marker
      return match[1] + match[2] + tag + match[7];
    }
  }

  // Default: simple prefix insertion after leading whitespace
  const match = text.match(LEADING_WHITESPACE_RE);
  return match[1] + tag + match[2];
}

/**
 * Appends closing tag to end of text, preserving trailing whitespace.
 *
 * @param {string} text - The text to process
 * @param {string} tag - The tag to append
 * @returns {string} Modified text with tag at end
 */
function appendClosingTag(text, tag) {
  const match = text.match(TRAILING_WHITESPACE_RE);
  return match[1] + tag + match[2];
}

/**
 * Handles toggle-style markup with full awareness of:
 * - Editor's begin/end markers
 * - Bold markers (`**`)
 * - List items
 * - Trailing whitespace handling
 *
 * @param {string} text - The text to process
 * @param {string} tag - Opening tag
 * @param {string} tag2 - Closing tag
 * @param {number} skip - If 1, apply list/bold detection
 * @param {object} editor - Editor instance (for begin/end markers)
 * @returns {string} Text with toggle markup applied
 */
function toggleMarkup(text, tag, tag2, skip, editor) {
  const beginMarker = editor.begin;
  const endMarker = editor.end;

  // ── Step 1: Process beginning of line (leading region detection) ──

  // Build patterns dynamically with editor's begin marker
  const beginBoldRe = new RegExp(`^([ ]*)${beginMarker}([ ]*)([*][*])(.*)$`);
  const beginListRe = new RegExp(
    `^([ ]*)${beginMarker}([ ]*)(([*-]|([1-9]\\d*|[\\p{Ll}\\p{Lu}])([.]|[)]))( |))(.*)$`,
    'u'
  );
  const beginGenericRe = new RegExp(`^(.*)${beginMarker}([ ]*)(.*)$`);

  // Try bold marker pattern first: "  !!**text"
  let match = text.match(beginBoldRe);
  if (match) {
    // match[1] = leading ws, match[2] = ws after begin, match[3] = "**", match[4] = text
    text = match[1] + beginMarker + match[2] + tag + match[3] + match[4];
  } else {
    // Try list item pattern: "  !!* item" or "  !!1. item"
    match = text.match(beginListRe);
    if (skip && match) {
      // Insert tag after the list marker
      text = match[1] + beginMarker + match[2] + match[3] + tag + match[8];
    } else {
      // Generic begin marker pattern: "  !!text"
      match = text.match(beginGenericRe);
      if (match) {
        text = match[1] + beginMarker + match[2] + tag + match[3];
      }
    }
  }

  // ── Step 2: Process end of line (trailing region detection) ─────

  const endRe = new RegExp(`([ ]*)${endMarker}(.*)$`);
  match = text.match(endRe);

  if (match) {
    const beforeEndRe = new RegExp(`^(.*)${endMarker}`);
    const beforeMatch = text.match(beforeEndRe);

    if (beforeMatch) {
      let beforeEnd = beforeMatch[1];

      // Strip trailing spaces before the end marker (crucial for clean output)
      let lastChar = beforeEnd.slice(-1);
      while (lastChar === ' ') {
        beforeEnd = beforeEnd.slice(0, -1);
        lastChar = beforeEnd.slice(-1);
      }

      text = beforeEnd + tag2 + match[1] + endMarker + match[2];
    }
  }

  return text;
}

// ── Region/state detection helpers ───────────────────────────────

/**
 * Checks if line contains a region begin marker.
 */
function isRegionBegin(line, rbegin) {
  return rbegin.test(line);
}

/**
 * Checks if line contains a region end (begin side).
 */
function isRegionEndBegin(line, rendb) {
  return rendb.test(line);
}

/**
 * Checks if line contains a region end marker.
 */
function isRegionEnd(line, rend) {
  return rend.test(line);
}

// ── Code protection (literal content) ────────────────────────────

/**
 * Returns the index of the line that contains the given offset.
 * @param {number} offset
 * @param {number[]} lineStarts
 * @returns {number}
 */
function lineIndexAt(offset, lineStarts) {
  let lo = 0;
  let hi = lineStarts.length - 1;
  while (lo < hi) {
    const mid = Math.ceil((lo + hi) / 2);
    if (lineStarts[mid] <= offset) lo = mid;
    else hi = mid - 1;
  }
  return lo;
}

/**
 * Determines which lines of the given text are inside a code region.
 *
 * The content of an inline code span or of a code block is literal: it is
 * shown as typed and must not be touched by any other markup rule
 * (no bold, no italic, no list indent, no typography).
 *
 * The text may contain the editor's begin/end markers; the markers are
 * removed before the scan (they look like an inline code span themselves)
 * and the selection range is mapped back to the original coordinates.
 *
 * @param {object} editor
 * @param {string} text text (possibly with the begin/end markers)
 * @returns {boolean[]} one flag per line
 */
function computeCodeProtectedLines(editor, text) {
  const lines = text.split('\n');
  const protectedLines = new Array(lines.length).fill(false);

  const beginMarker = editor.begin || '';
  const endMarker = editor.end || '';

  const beginPos = beginMarker ? text.indexOf(beginMarker) : -1;
  const endPos = (beginMarker && endMarker)
    ? text.indexOf(endMarker, beginPos + beginMarker.length)
    : -1;

  let original = text;
  let selStart = 0;
  let selEnd = text.length;

  if (beginPos !== -1 && endPos > beginPos) {
    selStart = beginPos;
    selEnd = endPos - beginMarker.length;
    original = text.slice(0, beginPos) +
               text.slice(beginPos + beginMarker.length, endPos) +
               text.slice(endPos + endMarker.length);
  }

  const regions = scanCodeRegions(original);
  if (!regions.length) return protectedLines;

  // Line start offsets of the original text (the markers contain no line
  // break, so the line numbering of both texts is identical).
  const lineStarts = [0];
  for (let i = 0; i < original.length; i++) {
    if (original[i] === '\n') lineStarts.push(i + 1);
  }

  for (const region of regions) {
    const from = Math.max(region.start, selStart);
    const to = Math.min(region.end, selEnd);
    if (from >= to) continue;

    const first = lineIndexAt(from, lineStarts);
    const last = lineIndexAt(to - 1, lineStarts);
    for (let i = first; i <= last && i < protectedLines.length; i++) {
      protectedLines[i] = true;
    }
  }

  return protectedLines;
}

// ── Main MarkUp logic (broken into manageable chunks) ────────────

/**
 * Core markup application function.
 * Handles multi-line selection wrapping with special cases for:
 * - Lists (ordered/unordered)
 * - Bold markers
 * - Region/block awareness
 * - Strip mode (removes existing markup)
 *
 * Code regions (inline code and code blocks) are skipped: their content is
 * literal and must be shown as typed.
 *
 * @param {object} editor - Editor instance
 * @param {string} tag - Opening tag
 * @param {string} text - Text to process
 * @param {string} tag2 - Closing tag (default: tag)
 * @param {number} onNewLine - When to apply: 0=always, 1=first line, 2=first+last
 * @param {number} expand - If 1, use expand mode (simple LSum+RSum)
 * @param {number} strip - If 1, strip existing markup first
 * @returns {string} Processed text
 */
function MarkUp(editor, tag, text, tag2 = tag, onNewLine = 0, expand = 0, strip = 0) {
  // Skip flag is inverse of expand: skip=1 when expand=0
  const skip = expand === 0 ? 1 : 0;

  // State tracking
  let result = '';
  let add = 0;           // Line counter for tracking first/last
  let fIn = false;       // Currently inside a region
  let fOut = false;      // Region ends on this line

  // Normalize line endings (Windows → Unix)
  text = text.replace(/\r/g, '');
  const lines = text.split('\n');

  // Code regions are literal – their lines must not be modified
  const codeLines = computeCodeProtectedLines(editor, text);

  // Pre-compile regex patterns for efficiency
  const { rbegin, rend, rendb } = editor;
  const listStripRe = /^ {2}( *)(([*-]|([1-9]\d*|[\p{Ll}\p{Lu}])([.]|[)]))( |))/u;

  // ── Process each line ─────────────────────────────────────────
  for (let i = 0; i < lines.length; i++) {
    let line = lines[i];

    // Track region state
    fIn = updateRegionState(line, lines[i + 1], fIn, rbegin, rend, rendb, lines, i);
    fOut = detectRegionEnd(line, lines[i + 1], rend, rendb, lines, i);

    // Build result with newline separator
    if (result) result += '\n';

    // ── Code regions are literal: keep the line as typed ───────
    if (codeLines[i]) {
      result += line;
      if (fOut) fIn = false;
      continue;
    }

    // ── Strip mode: remove existing block markup ──────────────
    if (fIn && strip === 1) {
      line = stripBlockMarkup(line, rbegin, listStripRe);
    }

    // ── Determine if markup should be applied ────────────────
    if (fIn && shouldApplyMarkup(onNewLine, add, fOut)) {
      // Apply markup based on mode
      if (expand === 1) {
        line = applyExpandMarkup(line, tag, tag2, add, fOut, onNewLine, skip);
      } else {
        line = applyToggleMarkup(line, tag, tag2, add, fOut, onNewLine, skip, editor);
      }
      add++;
    }

    result += line;

    // Clear fIn if we just processed a region end
    if (fOut) fIn = false;
  }

  return result;
}

/**
 * Updates the fIn (inside-region) flag based on current line.
 *
 * @param {string} line - Current line
 * @param {string} nextLine - Next line (may be undefined)
 * @param {boolean} fIn - Current inside-region state
 * @param {RegExp} rbegin - Region begin pattern
 * @param {RegExp} rend - Region end pattern
 * @param {RegExp} rendb - Region end begin pattern
 * @param {Array} lines - All lines (for modification)
 * @param {number} i - Current line index
 * @returns {boolean} New fIn state
 */
function updateRegionState(line, nextLine, fIn, rbegin, rend, rendb, lines, i) {
  // Enter region on begin marker
  if (rbegin.test(line)) {
    return true;
  }

  // Exit region on end marker (begin side)
  if (rendb.test(line)) {
    return false;
  }

  // Special case: if next line starts with end marker (begin side),
  // current line will get the end marker appended, so we should exit
  if (nextLine !== undefined && rendb.test(nextLine)) {
    // Remove end from next line and append to current line
    lines[i + 1] = nextLine.replace(rend, '');
    return false; // Will exit region after this line
  }

  return fIn;
}

/**
 * Detects if the current line causes a region to end.
 *
 * @param {string} line - Current line
 * @param {string} nextLine - Next line
 * @param {RegExp} rend - Region end pattern
 * @param {RegExp} rendb - Region end begin pattern
 * @param {Array} lines - All lines
 * @param {number} i - Current index
 * @returns {boolean} True if region ends on this line
 */
function detectRegionEnd(line, nextLine, rend, rendb, lines, i) {
  // Line contains end marker
  if (rend.test(line)) {
    return true;
  }

  // Next line starts with end marker (begin side) - end will be moved here
  if (nextLine !== undefined && rendb.test(nextLine)) {
    return true;
  }

  return false;
}

/**
 * Determines whether markup should be applied based on onNewLine mode.
 *
 * @param {number} onNewLine - Application mode
 * @param {number} add - Line counter
 * @param {boolean} fOut - Region ends on this line
 * @returns {boolean} Whether to apply markup
 */
function shouldApplyMarkup(onNewLine, add, fOut) {
  switch (onNewLine) {
    case 0: // Always inside region
      return true;
    case 1: // First line only
      return add === 0;
    case 2: // First line or end-of-region
      return add === 0 || fOut;
    default:
      return true;
  }
}

/**
 * Applies expand-mode markup (simple LSum + RSum).
 * Uses skip=1 for list/bold awareness when add=0.
 *
 * @param {string} line - Line to process
 * @param {string} tag - Opening tag
 * @param {string} tag2 - Closing tag
 * @param {number} add - Line counter
 * @param {boolean} fOut - Region ends on this line
 * @param {number} onNewLine - Application mode
 * @param {number} skip - List/bold awareness flag
 * @returns {string} Processed line
 */
function applyExpandMarkup(line, tag, tag2, add, fOut, onNewLine, skip) {
  // Add opening tag
  if (add === 0) {
    // First line: apply with full list/bold detection
    line = wrapInlineSelection(tag, line, skip);
  }

  // Add closing tag if end of region
  if (fOut) {
    line = appendClosingTag(line, tag2);
  }

  // For non-first lines (in multi-line operations)
  if (add !== 0 && onNewLine !== 2) {
    line = wrapInlineSelection(tag, line, skip);
  }

  // Add closing tag for non-end lines in toggle mode
  if (!fOut && onNewLine !== 2) {
    line = appendClosingTag(line, tag2);
  }

  return line;
}

/**
 * Applies toggle-mode markup (uses _TSum logic).
 * Handles editor begin/end markers with full awareness.
 *
 * @param {string} line - Line to process
 * @param {string} tag - Opening tag
 * @param {string} tag2 - Closing tag
 * @param {number} add - Line counter
 * @param {boolean} fOut - Region ends on this line
 * @param {number} onNewLine - Application mode
 * @param {number} skip - List/bold awareness flag
 * @param {object} editor - Editor instance
 * @returns {string} Processed line
 */
function applyToggleMarkup(line, tag, tag2, add, fOut, onNewLine, skip, editor) {
  // Use toggle markup function for full begin/end handling
  line = toggleMarkup(line, tag, tag2, skip, editor);

  // Add opening tag for non-first lines
  if (add !== 0 && onNewLine !== 2) {
    line = wrapInlineSelection(tag, line, skip);
  }

  // Add closing tag for non-end lines
  if (!fOut && onNewLine !== 2) {
    line = appendClosingTag(line, tag2);
  }

  return line;
}

/**
 * Strips existing block markup from a line (used in strip mode).
 *
 * @param {string} line - Line to process
 * @param {RegExp} rbegin - Region begin pattern
 * @param {RegExp} listRe - List item pattern
 * @returns {string} Stripped line
 */
function stripBlockMarkup(line, rbegin, listRe) {
  // Check if line is a region begin
  const isBegin = rbegin.test(line);
  const result = line
    .replace(rbegin, '')      // Remove begin marker
    .replace(listRe, '$1');   // Remove list indent, keep one level

  // Restore begin marker if it was there
  return isBegin ? (line.match(rbegin)?.[0] ?? '') + result : result;
}

// ── Public API methods ─────────────────────────────────────────────

/**
 * Inserts or toggles a tag around selection.
 * Handles both insertion and removal (toggle) of surrounding tags.
 *
 * @param {object} editor - Editor instance
 * @param {string} tag - Opening tag
 * @param {string} tag2 - Closing tag
 * @param {number} onNewLine - When to apply
 * @param {number} expand - Expand mode
 * @param {number} strip - Strip mode
 * @returns {boolean} Success
 */
function insTag(editor, tag, tag2, onNewLine = 0, expand = 0, strip = 0) {
  const t = editor.area;
  t.focus();
  editor.getDefines();

  const isIndentOrListOp = (expand === 1 || strip === 1);
  const tagLen = tag.length;
  const tag2Len = tag2.length;
  let applied = false;

  // ── Toggle mode: remove existing tags ─────────────────────────
  if (!isIndentOrListOp && editor.sel &&
      editor.sel.length >= tagLen + tag2Len &&
      editor.sel.startsWith(tag) &&
      editor.sel.endsWith(tag2)) {
    // Tags are inside the current selection - strip them
    const newSel = editor.sel.slice(tagLen, -tag2Len);
    const newValue = editor.sel1 + newSel + editor.sel2;
    const newStart = editor.sel1.length;
    const newEnd = newStart + newSel.length;

    editor.replaceContent(newValue, true, { scroll: editor.scroll });
    t.setSelectionRange(newStart, newEnd);
    applied = true;
  } else if (!isIndentOrListOp &&
             editor.sel1.length >= tagLen &&
             editor.sel1.endsWith(tag) &&
             editor.sel2.length >= tag2Len &&
             editor.sel2.startsWith(tag2)) {
    // Remove surrounding tags (outside selection)
    const newValue = editor.sel1.slice(0, -tagLen) + editor.sel + editor.sel2.slice(tag2Len);
    const newStart = editor.sel1.length - tagLen;
    const newEnd = newStart + editor.sel.length;

    editor.replaceContent(newValue, true, { scroll: editor.scroll });
    t.setSelectionRange(newStart, newEnd);
    applied = true;
  }

  if (applied) return true;

  // ── Normal insertion ──────────────────────────────────────────
  const str = MarkUp(editor, tag, editor.str, tag2, onNewLine, expand, strip);
  editor.setAreaContent(str);
  return true;
}

/**
 * Inserts a block wrapper with newlines (e.g., for HTML blocks).
 * Handles toggle: wrapping or unwrapping based on selection.
 *
 * @param {object} editor - Editor instance
 * @param {string} openTag - Opening tag
 * @param {string} closeTag - Closing tag
 * @returns {boolean} Success
 */
function insBlockWrapper(editor, openTag, closeTag = '%%') {
  const t = editor.area;
  t.focus();
  editor.getDefines();

  // The selection is inside a literal code region → do not touch it
  const regions = scanCodeRegions(editor.area.value);
  const inside = regions.some(r => r.literal !== false &&
    r.start <= editor.ss && editor.se <= r.end &&
    !(r.start === editor.ss && r.end === editor.se));
  if (inside) return true;

  const openWithNl = openTag + '\n';
  const closeWithNl = '\n' + closeTag;
  let applied = false;

  // ── Toggle: unwrap if already wrapped ────────────────────────
  if (editor.sel &&
      editor.sel.length >= openWithNl.length + closeWithNl.length &&
      editor.sel.startsWith(openWithNl) &&
      editor.sel.endsWith(closeWithNl)) {
    // Whole block selected - unwrap
    const newSel = editor.sel.slice(openWithNl.length, -closeWithNl.length);
    const newValue = editor.sel1 + newSel + editor.sel2;
    const newStart = editor.sel1.length;
    const newEnd = newStart + newSel.length;

    editor.replaceContent(newValue, true, { scroll: editor.scroll });
    t.setSelectionRange(newStart, newEnd);
    applied = true;
  } else if (editor.sel1.endsWith(openWithNl) &&
             editor.sel2.startsWith(closeWithNl)) {
    // Inner content selected, wrappers outside - unwrap
    const newValue = editor.sel1.slice(0, -openWithNl.length) + editor.sel + editor.sel2.slice(closeWithNl.length);
    const newStart = editor.sel1.length - openWithNl.length;
    const newEnd = newStart + editor.sel.length;

    editor.replaceContent(newValue, true, { scroll: editor.scroll });
    t.setSelectionRange(newStart, newEnd);
    applied = true;
  }

  if (applied) return true;

  // ── Wrap new content ──────────────────────────────────────────
  const content = editor.sel || '';
  const wrapped = `${openTag}\n${content}\n${closeTag}`;
  const newValue = editor.sel1 + wrapped + editor.sel2;

  editor.replaceContent(newValue, true, { scroll: editor.scroll });

  // Position cursor inside the wrapped block
  const cursorPos = editor.sel1.length + openTag.length + 1;
  t.setSelectionRange(cursorPos, cursorPos);
  return true;
}

/**
 * Removes indentation from selected lines.
 * Handles region markers and list items specially.
 * 
 * @param {object} editor - Editor instance
 * @returns {boolean} Success
 */
function unindent(editor) {
  const t = editor.area;
  t.focus();
  editor.getDefines();

  let result = '';
  let fIn = false;
  const lines = editor.str.split('\n');

  // Code regions are literal – their lines must not be re-indented
  const codeLines = computeCodeProtectedLines(editor, editor.str);

  for (let i = 0; i < lines.length; i++) {
    let line = lines[i];

    // Track region state
    if (editor.rbegin.test(line)) {
      fIn = true;
      // Remove one level of begin marker indentation
      line = line.replace(new RegExp('^' + editor.begin + '([ ]*)'), '$1' + editor.begin);
    }
    if (editor.rendb.test(line)) fIn = false;

    // Remove one level of indentation
    if (result) result += '\n';
    result += (fIn && !codeLines[i]) ? line.replace(/^(( {2})|\t)/, '') : line;

    if (editor.rend.test(line)) fIn = false;
  }

  editor.setAreaContent(result);
  return true;
}


// ── New code syntax helpers ───────────────────────────────────────

/**
 * Wraps the selection in an inline code span (##…##).
 *
 * The delimiter is a maximal run of '#' that is longer than any '#' run
 * inside the content, so the content stays literal:
 *
 *   'code'        → '##code##'
 *   '## code ##'  → '### ## code ## ###'
 *
 * @param {object} editor
 * @param {number} selStart
 * @param {number} selEnd
 * @returns {boolean} Success
 */
function wrapInlineCode(editor, selStart, selEnd) {
  const t = editor.area;
  const text = t.value;
  const content = text.slice(selStart, selEnd);
  const lines = content.split('\n');

  const parts = [];
  let firstContentOffset = 0;

  lines.forEach((line, index) => {
    // The delimiter must be longer than every '#' run of the line
    const fenceLen = Math.max(CODE_BASE_LENGTH, longestRun(line, '#') + 1);
    const fence = '#'.repeat(fenceLen);

    // A delimiter is a maximal run: it must not merge with a '#' of the
    // content (the separator blank goes *inside* the span).
    const open = fence + (line.startsWith('#') ? ' ' : '');
    const close = (line.endsWith('#') ? ' ' : '') + fence;

    if (index === 0) firstContentOffset = open.length;

    if (line === '') {
      // An empty line: keep the span valid ('## ##')
      parts.push(fence + ' ' + fence);
    } else {
      parts.push(open + line + close);
    }
  });

  let wrapped = parts.join('\n');

  // The fence must not merge with a '#' in front of the selection
  const prefix = (selStart > 0 && text[selStart - 1] === '#') ? ' ' : '';
  // … nor with a '#' behind the selection
  const suffix = (selEnd < text.length && text[selEnd] === '#') ? ' ' : '';

  const newValue = text.slice(0, selStart) + prefix + wrapped + suffix + text.slice(selEnd);

  editor.replaceContent(newValue, true, { scroll: editor.scroll });

  // The content stays selected → a second click removes the markup again
  const newStart = selStart + prefix.length + firstContentOffset;

  if (content === '') {
    // Empty selection: place the cursor between the delimiters
    t.setSelectionRange(newStart + 1, newStart + 1);
  } else {
    t.setSelectionRange(newStart, newStart + content.length);
  }

  return true;
}


/**
 * Removes the delimiters of an inline code span.
 *
 * The *actual* delimiter length is removed (it may have been extended to
 * '###' or more), so the "unset" works for every delimiter length.
 *
 * @param {object} editor
 * @param {object} region the inline region
 * @returns {boolean} Success
 */
function unwrapInlineCode(editor, region) {
  const t = editor.area;
  const text = t.value;

  let content = text.slice(region.contentStart, region.contentEnd);

  // The separator blanks that were added when the content began or ended
  // with a '#' are removed as well – they are not part of the content.
  if (content.startsWith(' ') && content.endsWith(' ') && content.trim() !== '') {
    content = content.slice(1, -1);
  }

  const newValue = text.slice(0, region.start) + content + text.slice(region.end);

  editor.replaceContent(newValue, true, { scroll: editor.scroll });

  const newStart = region.start;
  t.setSelectionRange(newStart, newStart + content.length);

  return true;
}

/**
 * Inserts or removes inline code (##…##) – the 'code' toolbar button.
 *
 * Toggle semantics:
 *  - the selection is exactly one complete span → it is wrapped again with a
 *    longer delimiter ('## code ##' → '### ## code ## ###')
 *  - the selection is inside a span             → the markup is removed
 *  - otherwise                                  → the selection is wrapped
 *
 * @param {object} editor
 * @returns {boolean} Success
 */
function insCode(editor) {
  const t = editor.area;
  t.focus();
  editor.getDefines();

  const text = t.value;
  const selStart = editor.ss;
  const selEnd = editor.se;

  const regions = scanCodeRegions(text);
  const containers = findContainingRegions(regions, selStart, selEnd);

  // Inside a code block the content is literal – do not touch it
  if (containers.some(r => r.type === 'block' && r.literal)) return true;

  const inline = containers.find(r => r.type === 'inline');
  if (inline) {
    // The whole span is selected → wrap it again (longer delimiter)
    if (inline.start === selStart && inline.end === selEnd) {
      return wrapInlineCode(editor, selStart, selEnd);
    }
    // A cursor inside a span: nothing sensible to do
    if (selStart === selEnd) return true;
    // The content is selected → remove the markup again
    return unwrapInlineCode(editor, inline);
  }

  // The selection touches a code region → literal content, ignore
  if (overlapsRegion(regions, selStart, selEnd)) return true;

  return wrapInlineCode(editor, selStart, selEnd);
}

/**
 * Wraps the selection in a code block (%%…%%).
 *
 * The fence length *is* the delimiter and must be longer than every '%' run
 * inside the content, so that a '%%' inside the block stays content:
 *
 *   'code'        → '%%\ncode\n%%'
 *   '%% code %%'  → '%%%\n%% code %%\n%%%'
 *
 * A run longer than BASE_LENGTH must be alone on its line – the necessary
 * line breaks are added automatically.
 *
 * @param {object} editor
 * @param {number} selStart
 * @param {number} selEnd
 * @returns {boolean} Success
 */
function wrapCodeBlock(editor, selStart, selEnd) {
  const t = editor.area;
  const text = t.value;
  const content = text.slice(selStart, selEnd);

  // The fence must be longer than every '%' run inside the content
  const fenceLen = Math.max(CODE_BASE_LENGTH, longestRun(content, '%') + 1);
  const fence = '%'.repeat(fenceLen);

  const before = text.slice(0, selStart);
  const after = text.slice(selEnd);

  let prefix = '';
  let suffix = '';

  if (fenceLen > CODE_BASE_LENGTH) {
    // A long fence must be alone on its line
    if (before.length && !before.endsWith('\n')) prefix += '\n';
    if (after.length && !after.startsWith('\n')) suffix += '\n';
  } else {
    // The fence must not merge with a '%' of the surrounding text
    if (before.endsWith('%')) prefix += '\n';
    if (after.startsWith('%')) suffix += '\n';
  }

  const block = `${fence}\n${content}\n${fence}`;
  const newValue = before + prefix + block + suffix + after;

  editor.replaceContent(newValue, true, { scroll: editor.scroll });

  // The content stays selected → a second click removes the markup again
  const contentStart = selStart + prefix.length + fence.length + 1;
  t.setSelectionRange(contentStart, contentStart + content.length);

  return true;
}

/**
 * Removes the fences of a code block.
 *
 * The block is located by the scanner, so the *actual* fence length is
 * removed – this is what the old "unset" feature could not do when the
 * delimiter had been extended (e.g. '%%%' instead of '%%').
 *
 * @param {object} editor
 * @param {object} region the block region
 * @returns {boolean} Success
 */
function unwrapCodeBlock(editor, region) {
  const t = editor.area;
  const text = t.value;

  // ── Opening fence ───────────────────────────────────────────────
  const openLineStart = text.lastIndexOf('\n', region.start - 1) + 1;
  const openLineEnd = text.indexOf('\n', region.headerEnd);
  const beforeOpen = text.slice(openLineStart, region.start);
  const afterOpen = openLineEnd === -1 ? '' : text.slice(region.headerEnd, openLineEnd);

  // The fence is "alone on its line" if nothing but whitespace surrounds it
  const openAlone = beforeOpen.trim() === '' && afterOpen.trim() === '';

  let openRemoveStart = region.start;
  let openRemoveEnd = region.headerEnd;

  if (openAlone && openLineEnd !== -1) {
    // Remove the whole opening line (including its indentation)
    openRemoveStart = openLineStart;
    openRemoveEnd = openLineEnd + 1;
  }

  // ── Closing fence ───────────────────────────────────────────────
  const closeLineStart = text.lastIndexOf('\n', region.closeStart - 1) + 1;
  const beforeClose = text.slice(closeLineStart, region.closeStart);
  const closeAlone = beforeClose.trim() === '';

  let closeRemoveStart = region.closeStart;
  let closeRemoveEnd = region.closeEnd;

  if (closeAlone) {
    // Remove the whole closing line (the preceding line break stays)
    closeRemoveStart = closeLineStart;
  }

  // ── Content between the fences ──────────────────────────────────
  let middle = text.slice(openRemoveEnd, closeRemoveStart);

  if (!openAlone) {
    // Inline block ('%% code %%'): drop the separating blanks
    middle = middle.replace(/^[ \t]/, '').replace(/[ \t]$/, '');
  }

  const newValue = text.slice(0, openRemoveStart) + middle + text.slice(closeRemoveEnd);

  editor.replaceContent(newValue, true, { scroll: editor.scroll });

  // Select the remaining content (without the trailing line break)
  const plain = middle.replace(/\n$/, '');
  t.setSelectionRange(openRemoveStart, openRemoveStart + plain.length);

  return true;
}

/**
 * Inserts or removes a code block (%%…%%) – the 'source' toolbar button.
 *
 * Toggle semantics:
 *  - the selection is inside a block            → the fences are removed
 *  - the selection is exactly one complete block → it is wrapped again with a
 *    longer fence ('%% code %%' → '%%%\n%% code %%\n%%%')
 *  - otherwise                                  → the selection is wrapped
 *
 * @param {object} editor
 * @returns {boolean} Success
 */
function insCodeBlock(editor) {
  const t = editor.area;
  t.focus();
  editor.getDefines();

  const text = t.value;
  const selStart = editor.ss;
  const selEnd = editor.se;

  const regions = scanCodeRegions(text);
  const containers = findContainingRegions(regions, selStart, selEnd);

  const block = containers.find(r => r.type === 'block' && r.literal);
  if (block) {
    // The whole block is selected → wrap it again (longer fence)
    if (block.start === selStart && block.end === selEnd) {
      return wrapCodeBlock(editor, selStart, selEnd);
    }
    // The content is selected → remove the fences again
    return unwrapCodeBlock(editor, block);
  }

  // The selection touches a code region → literal content, ignore
  if (overlapsRegion(regions, selStart, selEnd)) return true;

  return wrapCodeBlock(editor, selStart, selEnd);
}