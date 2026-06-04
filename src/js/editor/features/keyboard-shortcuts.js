// src/js/editor/features/keyboard-shortcuts.js

import logger from '../../utils/logger.js';

/**
 * Sets up keyboard shortcuts and auto-list continuation on the editor.
 * @param {import('../editor/wikiedit.js').WikiEdit} editor
 */
export function setupKeyboardShortcuts(editor) {
  // Remove any previous listener (safe for re-init)
  editor.area.removeEventListener('keydown', editor._keyDownHandler);

  // Store handler for later removal
  editor._keyDownHandler = (e) => keyDownHandler(editor, e);
  editor.area.addEventListener('keydown', editor._keyDownHandler);

  // Global shortcuts
  editor._globalKeyHandler = (e) => globalKeyHandler(editor, e);
  document.addEventListener('keydown', editor._globalKeyHandler);

  // Register cleanup
  editor._cleanupKeyboardShortcuts = () => cleanup(editor);

  logger.debug('KeyboardShortcuts: setup complete with cleanup registered');
}

/**
 * Cleanup function for Keyboard Shortcuts.
 * @param {import('../editor/wikiedit.js').WikiEdit} editor
 */
function cleanup(editor) {
  logger.info('KeyboardShortcuts: cleaning up');

  const ta = editor.area;
  if (ta) {
    if (typeof editor._keyDownHandler === 'function') {
      ta.removeEventListener('keydown', editor._keyDownHandler);
    }
  }

  if (typeof editor._globalKeyHandler === 'function') {
    document.removeEventListener('keydown', editor._globalKeyHandler);
  }

  // Clean up references
  delete editor._keyDownHandler;
  delete editor._globalKeyHandler;
  delete editor._cleanupKeyboardShortcuts;

  logger.debug('KeyboardShortcuts: cleanup finished');
}

/**
 * Main keydown handler for the textarea.
 * @param {import('../editor/wikiedit.js').WikiEdit} editor
 * @param {KeyboardEvent} e
 */
function keyDownHandler(editor, e) {
  if (!editor.enabled) return;

  const t = editor.area;
  let res = false;
  let justenter = false;
  let noscroll = false;

  const scroll = t.scrollTop;

  // Refresh selection state (so `this.sel` is accurate)
  editor.getDefines();

  // Let autocomplete handle first
  if (editor.autocomplete?.keyDown(e)) {
    res = true;
  }

  const ctrl = e.ctrlKey || e.metaKey;
  const alt = e.altKey;
  const shift = e.shiftKey;
  const key = e.key.toLowerCase();

  // ── Standard shortcuts ──────────────────────────────
  if (ctrl && key === 'z') {
    const success = shift ? editor.redo() : editor.undo();
    if (success) {
      res = true;
      noscroll = true;
    }
  } else if (ctrl && key === 'f') {
    editor.showFindReplace();
    res = true;
  } else if (alt && (key === 'u' || key === 'i')) {
    res = shift || (alt && key === 'u')
      ? editor.unindent()
      : editor.insTag('  ', '', 0, 1);
  } else if (ctrl && /^[1-6]$/.test(key)) {
    const level = parseInt(key);
    const tag = '='.repeat(level + 1);
    res = editor.insTag(tag, tag, 0, 1);
  } else if (key === '=' && editor.sel) {
    res = editor.insTag('++', '++');
  } else if (key === '_' && ctrl) {
    res = editor.insTag('', '\n----\n', 2);
  } else if (ctrl && editor.sel) {
    if (key === 'b') res = editor.insTag('**', '**');
    else if (key === 's') res = editor.insTag('--', '--');
    else if (key === 'u') res = editor.insTag('__', '__');
    else if (key === 'i') res = editor.insTag('//', '//');
    else if (key === 'j') res = editor.insTag('!!', '!!', 2);
    else if (key === 'h') res = editor.insTag('??', '??', 2);
  } else if (alt && key === 's') {
    editor.savePage();
    res = true;
  } else if ((ctrl || alt) && key === 'l') {
    if (shift && ctrl) {
      res = editor.insTag('  * ', '', 0, 1, 1);
    } else {
      res = editor.createLink(alt);
    }
  } else if (ctrl && shift && (key === 'n' || key === 'o')) {
    res = editor.insTag('  1. ', '', 0, 1, 1);
  } else if (e.key === 'Enter' && !e.shiftKey) {
    // Auto‑list continuation
    const result = handleEnterKey(editor, t, scroll);
    if (result) {
      res = result.res;
      noscroll = result.noscroll;
      justenter = result.justenter;
    }
  }

  editor.enterpressed = justenter;

  if (res) {
    e.preventDefault();
    if (!noscroll) t.scrollTop = scroll;
  }
}

/**
 * Global keyboard shortcuts (e.g., Ctrl+Alt+Z for Zen mode).
 * @param {import('../editor/wikiedit.js').WikiEdit} editor
 * @param {KeyboardEvent} e
 */
function globalKeyHandler(editor, e) {
  if ((e.ctrlKey || e.metaKey) && e.altKey && e.key.toLowerCase() === 'z') {
    e.preventDefault();
    editor.toggleZenMode();
  }
}

/**
 * Handles the Enter key for automatic list continuation.
 * @param {import('../editor/wikiedit.js').WikiEdit} editor
 * @param {HTMLTextAreaElement} t
 * @param {number} scroll - current scrollTop
 * @returns {{res: boolean, noscroll: boolean, justenter: boolean}|null}
 */
function handleEnterKey(editor, t, scroll) {
  const text = t.value.replace(/\r/g, '');
  const sel1 = text.slice(0, t.selectionStart);
  const sel2 = text.slice(t.selectionEnd);

  const re = new RegExp(
    '(^|\n)(( +)((([*-]|([1-9]\d*|[\p{Ll}\p{Lu}])([.]|[)]))( |))|))(' +
    (editor.enterpressed ? '\\s' : '[^\\r\\n]') + '*)' + '$',
    'u'
  );
  const q = sel1.match(re);

  if (!q) return null;

  let prefix = q[2];
  const currentContent = q[9] || '';

  if (editor.enterpressed && currentContent.trim() === '') {
    prefix = '';
  } else if (!editor.enterpressed) {
    if (q[3].length % 2 === 1) {
      prefix = '';
    } else {
      const numRe = /([1-9]\d*)([.]|[)])/;
      const q2 = q[2].match(numRe);
      if (q2) prefix = q[2].replace(numRe, String(Number(q2[1]) + 1) + q2[2]);
    }
  }

  const newValue = sel1 + '\n' + prefix + sel2;
  editor.replaceContent(newValue, true);

  const newSel = sel1.length + 1 + prefix.length;
  t.setSelectionRange(newSel, newSel);

  const lines = text.slice(0, newSel).split('\n').length - 1;
  const total = t.value.split('\n').length - 1;
  if (scroll + t.offsetHeight + 25 > Math.floor((t.scrollHeight / (total + 1)) * lines)) {
    t.scrollTop = Math.floor((t.scrollHeight / (total + 1)) * lines) - t.offsetHeight + 20;
    return { res: true, noscroll: true, justenter: true };
  }

  return { res: true, noscroll: false, justenter: true };
}
