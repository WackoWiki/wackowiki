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
      // match[1] = leading whitespace
      // match[2] = list marker (e.g., "*" or "1.")
      // match[7] = content after marker
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
      // match[1] = leading ws, match[2] = ws after begin, match[3] = marker, match[8] = content
      text = match[1] + beginMarker + match[2] + match[3] + tag + match[8];
    } else {
      // Generic begin marker pattern: "  !!text"
      match = text.match(beginGenericRe);
      if (match) {
        // match[1] = text before begin, match[2] = ws after begin, match[3] = text after begin
        text = match[1] + beginMarker + match[2] + tag + match[3];
      }
    }
  }

  // ── Step 2: Process end of line (trailing region detection) ─────

  const endRe = new RegExp(`([ ]*)${endMarker}(.*)$`);
  match = text.match(endRe);

  if (match) {
    // match[1] = leading ws, match[2] = text after end marker
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

// ── Main MarkUp logic (broken into manageable chunks) ────────────

/**
 * Core markup application function.
 * Handles multi-line selection wrapping with special cases for:
 * - Lists (ordered/unordered)
 * - Bold markers
 * - Region/block awareness
 * - Strip mode (removes existing markup)
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

  for (let line of lines) {
    // Track region state
    if (editor.rbegin.test(line)) {
      fIn = true;
      // Remove one level of begin marker indentation
      line = line.replace(new RegExp('^' + editor.begin + '([ ]*)'), '$1' + editor.begin);
    }
    if (editor.rendb.test(line)) fIn = false;

    // Remove one level of indentation
    if (result) result += '\n';
    result += fIn ? line.replace(/^(( {2})|\t)/, '') : line;

    if (editor.rend.test(line)) fIn = false;
  }

  editor.setAreaContent(result);
  return true;
}

// ── New extensibility helpers ─────────────────────────────────────

/**
 * Wraps an inline selection with open/close tags.
 * Simple prefix/suffix insertion for simple markup.
 * 
 * @param {string} open - Opening tag
 * @param {string} close - Closing tag
 * @param {string} text - Text to wrap
 * @returns {string} Wrapped text
 */
export function wrapInline(open, close, text) {
  return open + text + close;
}

/**
 * Wraps multiple lines (block) with a tag on each line.
 * 
 * @param {string} tag - Tag to prepend to each line
 * @param {string} text - Multi-line text
 * @param {boolean} onNewLine - If true, tag goes on new line
 * @returns {string} Block-wrapped text
 */
export function wrapBlock(tag, text, onNewLine = false) {
  const lines = text.split('\n');
  return lines
    .map(line => onNewLine ? `\n${tag}${line}` : `${tag}${line}`)
    .join('\n');
}

/**
 * Handles list indentation/deindentation.
 * Processes lines with list markers to adjust their indent level.
 * 
 * @param {string} direction - 'indent' or 'outdent'
 * @param {string} text - Text with potential list items
 * @returns {string} Text with adjusted list indentation
 */
export function handleListIndent(direction, text) {
  const lines = text.split('\n');
  const indentStr = '  '; // Two spaces per indent level

  return lines.map(line => {
    // Match list item pattern
    const match = line.match(LIST_ITEM_RE);
    if (match) {
      if (direction === 'indent') {
        // Increase indent
        return indentStr + line;
      } else {
        // Decrease indent (remove leading spaces up to indentStr)
        return line.startsWith(indentStr)
          ? line.slice(indentStr.length)
          : line.replace(/^ /, '');
      }
    }
    return line;
  }).join('\n');
}
