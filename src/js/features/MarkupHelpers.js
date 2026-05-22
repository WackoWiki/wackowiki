// src/features/MarkupHelpers.js

import logger from '../utils/logger.js';

/**
 * Attach all markup helper methods to the editor instance.
 * Call once during init, before any toolbar or keyboard actions.
 * @param {import('../core/WikiEdit.js').WikiEdit} editor
 */
export function setupMarkupHelpers(editor) {
  // Selection helper – must be available to other methods
  editor.getDefines = () => getDefines(editor);

  // Private helpers (exposed for testing if needed)
  editor._LSum = (tag, text, skip) => _LSum(editor, tag, text, skip);
  editor._RSum = (text, tag) => _RSum(editor, text, tag);
  editor._TSum = (text, tag, tag2, skip) => _TSum(editor, text, tag, tag2, skip);

  // Public markup operations
  editor.MarkUp = (tag, text, tag2, onNewLine, expand, strip) =>
    MarkUp(editor, tag, text, tag2, onNewLine, expand, strip);
  editor.insTag = (tag, tag2, onNewLine, expand, strip) =>
    insTag(editor, tag, tag2, onNewLine, expand, strip);
  editor.insBlockWrapper = (openTag, closeTag) =>
    insBlockWrapper(editor, openTag, closeTag);
  editor.unindent = () => unindent(editor);
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

// ── Internal markup helpers ───────────────────────────────────────

function _LSum(editor, tag, text, skip) {
  if (skip) {
    let q = text.match(/^([ ]*)([*][*])(.*)$/);
    if (q) return q[1] + tag + q[2] + q[3];
    q = text.match(/^([ ]*)(([*]|([1-9]\d*|[\p{Ll}\p{Lu}])([.]|[)]))( |))(.*)$/u);
    if (q) return q[1] + q[2] + tag + q[7];
  }
  const q = text.match(/^([ ]*)(.*)$/);
  return q[1] + tag + q[2];
}

function _RSum(editor, text, tag) {
  const q = text.match(/^(.*)([ ]*)$/);
  return q[1] + tag + q[2];
}

function _TSum(editor, text, tag, tag2, skip) {
  let q = text.match(new RegExp('^([ ]*)' + editor.begin + '([ ]*)([*][*])(.*)$'));
  if (q) {
    text = q[1] + editor.begin + q[2] + tag + q[3] + q[4];
  } else {
    q = text.match(new RegExp('^([ ]*)' + editor.begin + '([ ]*)(([*]|([1-9]\d*|[\p{Ll}\p{Lu}])([.]|[)]))( |))(.*)$', 'u'));
    if (skip && q) {
      text = q[1] + editor.begin + q[2] + q[3] + tag + q[8];
    } else {
      q = text.match(new RegExp('^(.*)' + editor.begin + '([ ]*)(.*)$'));
      if (q) text = q[1] + editor.begin + q[2] + tag + q[3];
    }
  }

  q = text.match(new RegExp('([ ]*)' + editor.end + '(.*)$'));
  if (q) {
    const q1 = text.match(new RegExp('^(.*)' + editor.end));
    if (q1) {
      let s = q1[1];
      let ch = s.slice(-1);
      while (ch === ' ') {
        s = s.slice(0, -1);
        ch = s.slice(-1);
      }
      text = s + tag2 + q[1] + editor.end + q[2];
    }
  }
  return text;
}

// ── Main markup methods ──────────────────────────────────────────

function MarkUp(editor, tag, text, tag2, onNewLine = 0, expand = 0, strip = 0) {
  const skip = expand === 0 ? 1 : 0;
  let r = '';
  let fIn = false;
  let fOut = false;
  let add = 0;
  let f = false;

  const listRe = /^ {2}( *)(([*]|([1-9]\d*|[\p{Ll}\p{Lu}])([.]|[)]))( |))/u;

  text = text.replace(/\r/g, '');
  const lines = text.split('\n');

  for (let i = 0; i < lines.length; i++) {
    let line = lines[i];

    if (editor.rbegin.test(line)) fIn = true;
    if (editor.rendb.test(line)) fIn = false;
    if (editor.rend.test(line)) fOut = true;
    if (editor.rendb.test(lines[i + 1] ?? '')) {
      fOut = true;
      lines[i + 1] = lines[i + 1].replace(editor.rend, '');
      line += editor.end;
    }

    if (r) r += '\n';

    if (fIn && strip === 1) {
      f = editor.rbegin.test(line);
      line = line.replace(editor.rbegin, '');
      line = line.replace(listRe, '$1');
      if (f) line = editor.begin + line;
    }

    if (fIn && (onNewLine === 0 || (onNewLine === 1 && add === 0) || (onNewLine === 2 && (add === 0 || fOut)))) {
      if (expand === 1) {
        let l = line;
        if (add === 0) l = _LSum(editor, tag, l, skip);
        if (fOut) l = _RSum(editor, l, tag2);
        if (add !== 0 && onNewLine !== 2) l = _LSum(editor, tag, l, skip);
        if (!fOut && onNewLine !== 2) l = _RSum(editor, l, tag2);
        r += l;
      } else {
        let l = _TSum(editor, line, tag, tag2, skip);
        if (add !== 0 && onNewLine !== 2) l = _LSum(editor, tag, l, skip);
        if (!fOut && onNewLine !== 2) l = _RSum(editor, l, tag2);
        r += l;
      }
      add++;
    } else {
      r += line;
    }

    if (fOut) fIn = false;
  }
  return r;
}

function insTag(editor, tag, tag2, onNewLine = 0, expand = 0, strip = 0) {
  const t = editor.area;
  t.focus();
  editor.getDefines();

  const isIndentOrListOp = (expand === 1 || strip === 1);
  const tagLen = tag.length;
  const tag2Len = tag2.length;
  let applied = false;

  if (!isIndentOrListOp && editor.sel &&
      editor.sel.length >= tagLen + tag2Len &&
      editor.sel.startsWith(tag) &&
      editor.sel.endsWith(tag2)) {
    // Tags are inside the current selection
    const newSel = editor.sel.slice(tagLen, -tag2Len);
    const newValue = editor.sel1 + newSel + editor.sel2;
    const newStart = editor.sel1.length;
    const newEnd = newStart + newSel.length;

    editor.replaceContent(newValue);
    t.setSelectionRange(newStart, newEnd);
    t.scrollTop = editor.scroll;
    applied = true;
  } else if (!isIndentOrListOp &&
             editor.sel1.length >= tagLen &&
             editor.sel1.endsWith(tag) &&
             editor.sel2.length >= tag2Len &&
             editor.sel2.startsWith(tag2)) {
    // Tags surround the current selection
    const newValue = editor.sel1.slice(0, -tagLen) + editor.sel + editor.sel2.slice(tag2Len);
    const newStart = editor.sel1.length - tagLen;
    const newEnd = newStart + editor.sel.length;

    editor.replaceContent(newValue);
    t.setSelectionRange(newStart, newEnd);
    t.scrollTop = editor.scroll;
    applied = true;
  }

  if (applied) return true;

  // Fallback to original behaviour
  const str = MarkUp(editor, tag, editor.str, tag2, onNewLine, expand, strip);
  editor.setAreaContent(str);
  return true;
}

function insBlockWrapper(editor, openTag, closeTag = '%%') {
  const t = editor.area;
  t.focus();
  editor.getDefines();

  const openWithNl = openTag + '\n';
  const closeWithNl = '\n' + closeTag;
  let applied = false;

  if (editor.sel &&
      editor.sel.length >= openWithNl.length + closeWithNl.length &&
      editor.sel.startsWith(openWithNl) &&
      editor.sel.endsWith(closeWithNl)) {
    // Whole block selected
    const newSel = editor.sel.slice(openWithNl.length, -closeWithNl.length);
    const newValue = editor.sel1 + newSel + editor.sel2;
    const newStart = editor.sel1.length;
    const newEnd = newStart + newSel.length;

    editor.replaceContent(newValue);
    t.setSelectionRange(newStart, newEnd);
    t.scrollTop = editor.scroll;
    applied = true;
  } else if (editor.sel1.endsWith(openWithNl) &&
             editor.sel2.startsWith(closeWithNl)) {
    // Inner content selected, wrappers outside
    const newValue = editor.sel1.slice(0, -openWithNl.length) + editor.sel + editor.sel2.slice(closeWithNl.length);
    const newStart = editor.sel1.length - openWithNl.length;
    const newEnd = newStart + editor.sel.length;

    editor.replaceContent(newValue);
    t.setSelectionRange(newStart, newEnd);
    t.scrollTop = editor.scroll;
    applied = true;
  }

  if (applied) return true;

  // Not yet wrapped
  const content = editor.sel || '';
  const wrapped = `${openTag}\n${content}\n${closeTag}`;
  const newValue = editor.sel1 + wrapped + editor.sel2;
  editor.replaceContent(newValue);

  const cursorPos = editor.sel1.length + openTag.length + 1; // after opening tag + newline
  t.setSelectionRange(cursorPos, cursorPos);
  return true;
}

function unindent(editor) {
  const t = editor.area;
  t.focus();
  editor.getDefines();

  let r = '';
  let fIn = false;
  const lines = editor.str.split('\n');

  for (let line of lines) {
    if (editor.rbegin.test(line)) {
      fIn = true;
      line = line.replace(new RegExp('^' + editor.begin + '([ ]*)'), '$1' + editor.begin);
    }
    if (editor.rendb.test(line)) fIn = false;

    if (r) r += '\n';
    r += fIn ? line.replace(/^(( {2})|\t)/, '') : line;

    if (editor.rend.test(line)) fIn = false;
  }

  editor.setAreaContent(r);
  return true;
}
