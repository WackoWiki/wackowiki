// src/js/features/UndoRedo.js

import logger from '../utils/logger.js';

/**
 * Sets up undo/redo stacks and listeners on the editor instance.
 * Now uses EditorState for content management and registers cleanup.
 * @param {import('../core/WikiEdit.js').WikiEdit} editor
 */
export function setupUndoRedo(editor) {
  const state = editor.state;

  // Initialize stacks
  editor.undoStack = [];
  editor.redoStack = [];
  editor.maxHistory = editor.maxHistory || 100;

  // Core methods
  editor.pushState = () => pushState(editor);
  editor.undo = () => undo(editor);
  editor.redo = () => redo(editor);
  editor.validateState = (state) => validateState(state);

  // Debounce helper
  editor._debouncePushState = () => _debouncePushState(editor);

  // Listen to EditorState for automatic history pushing
  const unsubscribe = state.subscribe((change) => {
    if (change.type === 'content' && change.pushToUndo) {
      editor.pushState();
    }
  });

  editor._undoStateUnsubscribe = unsubscribe;

  // Capture beforeinput to push current state before native changes
  editor.area.addEventListener('beforeinput', (e) => handleBeforeInput(editor, e));

  // Register cleanup function for destroy()
  editor._cleanupUndoRedo = () => cleanup(editor);

  logger.debug('UndoRedo: setup complete with cleanup registered');
}

/**
 * Cleanup function for undo/redo feature.
 * @param {import('../core/WikiEdit.js').WikiEdit} editor
 */
function cleanup(editor) {
  logger.info('UndoRedo: cleaning up');

  // Unsubscribe from EditorState
  if (typeof editor._undoStateUnsubscribe === 'function') {
    editor._undoStateUnsubscribe();
    editor._undoStateUnsubscribe = null;
    logger.debug('UndoRedo: state subscription removed');
  }

  // Clear timers
  if (editor.pushTimer) {
    clearTimeout(editor.pushTimer);
    editor.pushTimer = null;
  }

  // Clear stacks
  editor.undoStack = [];
  editor.redoStack = [];

  // Remove beforeinput listener
  if (editor.area) {
    editor.area.removeEventListener('beforeinput', editor._beforeInputHandler || handleBeforeInput);
    logger.debug('UndoRedo: beforeinput listener removed');
  }

  // Clean up method references (optional but good hygiene)
  delete editor.pushState;
  delete editor.undo;
  delete editor.redo;
  delete editor.validateState;
  delete editor._debouncePushState;
  delete editor._cleanupUndoRedo;

  logger.debug('UndoRedo: cleanup finished');
}

/**
 * Push the current state (from EditorState + textarea metadata) onto the undo stack.
 * @param {import('../core/WikiEdit.js').WikiEdit} editor
 */
function pushState(editor) {
  const state = editor.state;
  const t = editor.area;
  if (!t) return;

  const currentState = {
    text: state.content,
    start: t.selectionStart,
    end: t.selectionEnd,
    scroll: t.scrollTop
  };

  if (!validateState(currentState)) {
    logger.error('UndoRedo: invalid state – refusing to push to undo stack');
    return;
  }

  // Avoid duplicate consecutive states
  const last = editor.undoStack[editor.undoStack.length - 1];
  if (last &&
      last.text === currentState.text &&
      last.start === currentState.start &&
      last.end === currentState.end &&
      last.scroll === currentState.scroll) {
    return;
  }

  editor.undoStack.push(currentState);
  if (editor.undoStack.length > editor.maxHistory) {
    editor.undoStack.shift();
  }
  editor.redoStack = [];
}

/**
 * Undo the last change.
 * @param {import('../core/WikiEdit.js').WikiEdit} editor
 * @returns {boolean} success
 */
function undo(editor) {
  if (editor.undoStack.length === 0) return false;

  const t = editor.area;
  const state = editor.state;

  const current = {
    text: state.content,
    start: t.selectionStart,
    end: t.selectionEnd,
    scroll: t.scrollTop
  };

  if (!validateState(current)) {
    logger.warn('UndoRedo: current state invalid before undo – still proceeding');
  }

  editor.redoStack.push(current);
  const prev = editor.undoStack.pop();

  if (!validateState(prev)) {
    logger.error('UndoRedo: corrupted undo state popped! Stack sanitized.');
    editor.undoStack = editor.undoStack.filter(s => validateState(s));
    return false;
  }

  editor.replaceContent(prev.text, false, {
    selection: { start: prev.start, end: prev.end },
    scroll: prev.scroll
  });

  // Use replaceContent without pushing to undo (we already popped)
  editor.replaceContent(prev.text, false);
  t.setSelectionRange(prev.start, prev.end);
  t.scrollTop = prev.scroll ?? 0;
  t.focus();

  return true;
}

/**
 * Redo the last undone change.
 * @param {import('../core/WikiEdit.js').WikiEdit} editor
 * @returns {boolean} success
 */
function redo(editor) {
  if (editor.redoStack.length === 0) return false;

  const t = editor.area;
  const state = editor.state;

  const current = {
    text: state.content,
    start: t.selectionStart,
    end: t.selectionEnd,
    scroll: t.scrollTop
  };

  if (!validateState(current)) {
    logger.warn('UndoRedo: current state invalid before redo – still proceeding');
  }

  editor.undoStack.push(current);
  const next = editor.redoStack.pop();

  if (!validateState(next)) {
    logger.error('UndoRedo: corrupted redo state popped! Stack sanitized.');
    editor.redoStack = editor.redoStack.filter(s => validateState(s));
    return false;
  }
  
  editor.replaceContent(next.text, false, {
    selection: { start: next.start, end: next.end },
    scroll: next.scroll
  });

  editor.replaceContent(next.text, false);
  t.setSelectionRange(next.start, next.end);
  t.scrollTop = next.scroll ?? 0;
  t.focus();

  return true;
}

/**
 * Validate a state object.
 * @param {object} state
 * @returns {boolean}
 */
function validateState(state) {
  if (!state || typeof state !== 'object') {
    logger.warn('UndoRedo: state is not an object');
    return false;
  }
  if (typeof state.text !== 'string') {
    logger.warn('UndoRedo: state.text is not a string');
    return false;
  }
  const len = state.text.length;
  if (typeof state.start !== 'number' || state.start < 0 || state.start > len) {
    logger.warn('UndoRedo: invalid selectionStart', state.start, '(text length =', len, ')');
    return false;
  }
  if (typeof state.end !== 'number' || state.end < state.start || state.end > len) {
    logger.warn('UndoRedo: invalid selectionEnd', state.end, '(start =', state.start, ', length =', len, ')');
    return false;
  }
  if (typeof state.scroll !== 'number' || state.scroll < 0) {
    logger.warn('UndoRedo: invalid scrollTop', state.scroll);
    return false;
  }
  return true;
}

/**
 * Handles the `beforeinput` event to push state before native changes.
 * @param {import('../core/WikiEdit.js').WikiEdit} editor
 * @param {InputEvent} e
 */
function handleBeforeInput(editor, e) {
  // Never interfere with browser's own history undo/redo
  if (e.inputType === 'historyUndo' || e.inputType === 'historyRedo') {
    return;
  }
  _debouncePushState(editor);
}

/**
 * Debounced pushState to avoid excessive pushes on large texts.
 * @param {import('../core/WikiEdit.js').WikiEdit} editor
 */
function _debouncePushState(editor) {
  const t = editor.area;
  if (!t) return;
  const len = t.value.length;

  if (len < 20000) {
    editor.pushState();
    return;
  }

  // Large text: debounce aggressively
  clearTimeout(editor.pushTimer);
  editor.pushTimer = setTimeout(() => {
    editor.pushState();
    editor.pushTimer = null;
  }, 650);
}