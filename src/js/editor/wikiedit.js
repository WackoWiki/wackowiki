// src/editor/wikiedit.js

import { ProtoEdit } from './protoedit.js';
import { EditorState } from './editor-state.js';

import { buttonDefs } from './toolbar/toolbar-config.js';
import { loadAndBuildToolbar } from './toolbar/toolbar-builder.js';

// Features (import the setup functions you use in init()) / use explicit initialization
import { setupMarkupHelpers } from './features/markup-helpers.js';
import { setupHeartbeat } from './features/session-heartbeat.js';
import { setupMediaUpload } from './features/media-upload.js';
import { setupToolbarDelegation } from './toolbar/toolbar-delegation.js';
import { setupLivePreview } from './features/live-preview.js';
import { setupSyntaxHighlighting } from './features/syntax-highlight.js';
import { wackoToMarkdown, markdownToWacko } from './features/markup-conversion.js';
import { setupAutosave } from './features/autosave.js';
import { setupKeyboardShortcuts } from './features/keyboard-shortcuts.js';
import { setupDarkZenMode } from './features/zen-mode.js';
import { setupModals } from './features/modals.js';
import { setupUIFeatures } from './features/ui-features.js';

// Core utilities used by the class
import logger from '../utils/logger.js';
import { loadPreferredNumber } from '../utils/storage.js';
import { getRelativeTime } from '../utils/time.js';

/*!
 * WikiEdit v3.26 (ES2023+)
 * https://wackowiki.org/doc/Dev/Projects/WikiEdit
 *
 * Licensed BSD © Roman Ivanov, Evgeny Nedelko, WackoWiki Team
 */

export class WikiEdit extends ProtoEdit {

  static buttonDefs = buttonDefs;

  // Private fields for truly internal state
  #undoStack = [];
  #redoStack = [];
  #maxHistory = 100;
  #pushTimer = null;
  #undoStateUnsubscribe = null;
  #beforeInputHandler = null;

  #state;

  constructor() {
    super();

    this.#state = new EditorState();

    this.enabled = true;
    this.manual = 'https://wackowiki.org/doc/';
    this.mark = '##inspoint##';
    this.begin = '##startpoint##';
    this.end = '##endpoint##';
    this.rbegin = new RegExp(this.begin);
    this.rend = new RegExp(this.end);
    this.rendb = new RegExp('^' + this.end);
    this.enterpressed = false;
    this.imagesPath = '';
    this.id = null;
    this.area = null;
    this.canUpload = false;
    this.livePreviewDefault = false;
    this.syntaxHighlighting = true;
    this.preferredHeight = 400;
    this.HEIGHT_KEY = 'we_editor_height';
    this.DEFAULT_HEIGHT = 400;
    this.DRAFT_KEY_PREFIX = 'we_draft_';
    this.autosaveDelay = 8000;
    this.isSubmitting = false;
    this.cf_modified = false;
  }

  // ===================================================================
  // INITIALISATION
  // ===================================================================
  init(id, imgPath) {
    this._init(id);               // ProtoEdit setup, creates this.area
    this.imagesPath = imgPath || 'image/';
    this.area.wikiEditInstance = this;

    const ta = this.area;

    // Editor height
    this.preferredHeight = loadPreferredNumber(
      ta, this.HEIGHT_KEY, 'editorHeight', 300, 800, this.DEFAULT_HEIGHT
    );
    ta.style.height = `${this.preferredHeight}px`;

    document.documentElement.style.setProperty('color-scheme', 'light dark');

    // Feature flags
    this.syntaxHighlighting = ta.dataset.syntaxHighlighting !== '0';
    this.livePreviewDefault = ta.dataset.livePreviewDefault === '1';
    this.canUpload = ta.dataset.canUpload === '1';

    // Context detection
    this.isCommentMode = ta.id === 'addcomment' || ta.name === 'payload';

    // === Initialize State - push initial content to undo stack ===
    this.#state.setContent(ta.value, { _programmatic: true });

    // === State → UI Sync ===
    this.#state.subscribe((change) => {
      const ta = this.area;
      if (!ta) return;

      if (change.type === 'content') {
        // For toolbar buttons (_programmatic: true): subscription does nothing
        // For undo/redo (_programmatic: true): subscription does nothing
        // For keyboard/paste: pushState is called in inputHandler, subscription only updates UI

        // Just update UI
        if (ta.value !== change.content) {
          ta.value = change.content;
        }

        // Update selection only when explicitly provided
        if (change.selection !== undefined) {
          ta.setSelectionRange(change.selection.start, change.selection.end);
        }

        if (typeof change.scroll === 'number') {
          ta.scrollTop = change.scroll;
        }

        this.updateStatus?.();

        if (this.livePreviewEnabled && typeof this.updatePreview === 'function') {
          setTimeout(() => this.updatePreview(), 20);
        }

        // Trigger syntax highlight (non-blocking)
        this.refreshSyntaxHighlight?.();
      }
    });

    // Input handler for keyboard/paste
    const inputHandler = () => {
      // CRITICAL: Save cursor position BEFORE the change
      // This is where cursor SHOULD be after undo
      const savedSelection = {
        start: ta.selectionStart,
        end: ta.selectionEnd
      };

      // Call pushState BEFORE setContent updates state.content
      // pushState needs to capture the OLD content with the cursor position BEFORE the change
      this.pushState();

      // Restore saved cursor position for the OLD state
      // This ensures the restored state has the correct cursor position
      this._savedSelection = savedSelection;

      // Then update state (subscription only updates UI, no push)
      this.#state.setContent(ta.value);
    };

    const selectionHandler = () => {
      this.#state.setSelection(ta.selectionStart, ta.selectionEnd);
    };

    ta.addEventListener('input', inputHandler);
    ta.addEventListener('select', selectionHandler);
    ta.addEventListener('keydown', selectionHandler);

    // Store handlers for later removal in destroy()
    this._inputHandler = inputHandler;
    this._selectionHandler = selectionHandler;

    const form = ta.closest('form');
    this.ajaxUrl = form
      ? (form.getAttribute('action') || window.location.href)
      : window.location.href;

    // Markup helpers (needed before toolbar / keyboard)
    setupMarkupHelpers(this);

    // Toolbar (must come before features that depend on toolbar buttons)
    loadAndBuildToolbar(this);

    // Core features
    this.#setupUndoRedo();
    setupKeyboardShortcuts(this);
    setupHeartbeat(this);
    setupAutosave(this);
    setupMediaUpload(this);

    // UI features (after toolbar is in DOM)
    setupDarkZenMode(this);
    setupLivePreview(this);
    setupSyntaxHighlighting(this);
    setupToolbarDelegation(this);
    setupModals(this);
    setupUIFeatures(this);

    // Post-setup
    this.updateToolbarButtonStates?.();

    // Legacy global
    window.weSave = () => this.savePage();

    logger.success(`WikiEdit initialized: ${id}`);
  }

  // ===================================================================
  // Override buildToolbar e.g. Autocomplete
  // ===================================================================
  _protoBuildToolbar(configArray) {
    super.buildToolbar(configArray);
  }

  // ===================================================================
  // PRIVATE: Undo/Redo setup
  // ===================================================================
  #setupUndoRedo() {
    const state = this.#state;

    // Public API methods – they close over the instance (this) so they
    // can access private fields.
    this.pushState = this.#pushState.bind(this);
    this.undo = this.#undo.bind(this);
    this.redo = this.#redo.bind(this);
    this.validateState = this.#validateState.bind(this);

    // Debounce helper (exposed as a method for internal use, but still private)
    this._debouncePushState = this.#debouncePushState.bind(this);

    // No subscription needed here - handled in init()
    // The subscription in init() handles all state changes

    logger.debug('UndoRedo: setup complete');
  }

  // All private methods now use # prefix
  #pushState() {
    const state = this.#state;
    const t = this.area;
    if (!t) return;

    // Use saved cursor position if available (from keyboard input)
    // Otherwise use current cursor position
    const savedSel = this._savedSelection;
    const start = savedSel ? savedSel.start : t.selectionStart;
    const end = savedSel ? savedSel.end : t.selectionEnd;
    
    // Clear the saved selection after using it
    this._savedSelection = null;

    const currentState = {
      text: state.content,
      start: start,
      end: end,
      scroll: t.scrollTop
    };

    if (!this.#validateState(currentState)) {
      logger.error('UndoRedo: invalid state – refusing to push to undo stack');
      return;
    }

    // Avoid duplicate consecutive states
    const last = this.#undoStack[this.#undoStack.length - 1];
    if (last &&
        last.text === currentState.text &&
        last.start === currentState.start &&
        last.end === currentState.end &&
        last.scroll === currentState.scroll) {
      return;
    }

    this.#undoStack.push(currentState);
    if (this.#undoStack.length > this.#maxHistory) {
      this.#undoStack.shift();
    }
    this.#redoStack = [];
  }

  #undo() {
    if (this.#undoStack.length === 0) return false;

    const t = this.area;
    const state = this.#state;

    const current = {
      text: state.content,
      start: t.selectionStart,
      end: t.selectionEnd,
      scroll: t.scrollTop
    };

    const prev = this.#undoStack.pop();
    if (!prev || !this.#validateState(prev)) {
      return false;
    }

    this.#redoStack.push(current);

    // Clamp cursor position
    const maxPos = prev.text.length;
    const safeStart = Math.min(prev.start, maxPos);
    const safeEnd = Math.min(prev.end, maxPos);

    // Set value and scroll first
    t.value = prev.text;
    t.scrollTop = prev.scroll ?? 0;
    t.focus();

    // Set cursor immediately
    t.setSelectionRange(safeStart, safeEnd);

    // Update internal state - DON'T pass selection here!
    // The subscription should NOT override cursor for programmatic changes
    // undo() already set it above
    state.setContent(prev.text, {
      selection: undefined,  // Explicitly undefined so subscription skips it
      scroll: prev.scroll,
      _programmatic: true
    });

    return true;
  }

  #redo() {
    if (this.#redoStack.length === 0) return false;

    const t = this.area;
    const state = this.#state;

    const current = {
      text: state.content,
      start: t.selectionStart,
      end: t.selectionEnd,
      scroll: t.scrollTop
    };

    const next = this.#redoStack.pop();
    if (!next || !this.#validateState(next)) {
      return false;
    }

    this.#undoStack.push(current);

    // Clamp cursor position
    const maxPos = next.text.length;
    const safeStart = Math.min(next.start, maxPos);
    const safeEnd = Math.min(next.end, maxPos);

    // Set value and scroll first
    t.value = next.text;
    t.scrollTop = next.scroll ?? 0;
    t.focus();

    // Set cursor immediately
    t.setSelectionRange(safeStart, safeEnd);

    // Update internal state - DON'T pass selection here!
    state.setContent(next.text, {
      selection: undefined,  // Explicitly undefined so subscription skips it
      scroll: next.scroll,
      _programmatic: true
    });

    return true;
  }

  #validateState(state) {
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

  #handleBeforeInput(e) {
    // Native beforeinput is now handled in init()
    // This method kept for compatibility but does nothing
  }

  #debouncePushState() {
    const t = this.area;
    if (!t) return;
    const len = t.value.length;

    if (len < 20000) {
      this.#pushState();
      return;
    }

    // Large text: debounce aggressively
    clearTimeout(this.#pushTimer);
    this.#pushTimer = setTimeout(() => {
      this.#pushState();
      this.#pushTimer = null;
    }, 650);
  }


  // ==================== Content API (now using state) ====================

  savePage() {
    if (!confirm(t('ReallySave') || 'Really save this page?')) return;
    this.isSubmitting = true;
    this.ignoreModified();
    // clear draft handled by autosave module's submit listener

    // Find the edit form (works with both name="edit" and id="edit_page")
    const form = this.area.form ||
      this.area.closest('form') ||
      document.forms.namedItem('edit') ||
      document.querySelector('form[name="edit"], form#edit_page');

    if (!form) {
      logger.warn('savePage: could not find form');
      return;
    }

    // This sends name="save" in the POST data so the backend actually saves
    const saveBtn = form.querySelector('input[name="save"], button[name="save"]');
    if (saveBtn) {
      saveBtn.click();
    } else {
      form.submit();
    }
  }

  /**
   * Replace editor content through EditorState.
   * @param {string} newText
   * @param {boolean} pushToUndo
   * @param {object} options - {selection?, scroll?}
   */
  replaceContent(newText, pushToUndo = true, options = {}) {
    if (!this.area) return;

    const { selection, scroll } = options;

    let finalSelection = selection || {
      start: this.area.selectionStart,
      end: this.area.selectionEnd
    };

    // Push to undo stack BEFORE making the change (for toolbar buttons, etc.)
    if (pushToUndo && typeof this.pushState === 'function') {
      this.pushState();
    }

    // Apply change - subscription won't push because _programmatic: true
    this.#state.setContent(newText || '', {
      selection: finalSelection,
      scroll: scroll ?? this.area.scrollTop,
      _programmatic: true
    });
  }

  setAreaContent(str) {
    const t = this.area;
    if (!t) return;

    const beginMatch = str.match(new RegExp('((.|\n)*)' + this.begin));
    const endMatch = str.match(new RegExp(this.begin + '((.|\n)*)' + this.end));

    const l = beginMatch ? beginMatch[1].length : 0;
    const l1 = endMatch ? endMatch[1].length : 0;

    str = str.replace(this.rbegin, '').replace(this.rend, '');

    // Use replaceContent instead of manual setContent call
    this.replaceContent(str, true, {
      selection: { start: l, end: l + l1 },
      scroll: this.scroll || 0
    });
  }

  getContent() {
    return this.#state.content;
  }

  get isDirty() {
    return this.#state.isDirty;
  }

  get isModified() {
    return this.#state.isModified;
  }

  markClean() {
    this.#state.markClean();
  }

  markSaved() {
    this.#state.markSaved();
  }

  // Optional: direct access to state (use sparingly)
  get state() {
    return this.#state;
  }

  changeEditorHeight(delta) {
    let newH = this.preferredHeight + delta;
    newH = Math.max(300, Math.min(800, newH));
    this.preferredHeight = newH;

    if (this.splitContainer) {
      this.splitContainer.style.height = `${newH}px`;
      this.splitContainer.style.minHeight = `${Math.max(300, newH)}px`;
    } else {
      this.area.style.height = `${newH}px`;
    }

    localStorage.setItem(this.HEIGHT_KEY, newH);
    this.updateStatus?.();
  }

  convertToMarkdown() {
    if (!this.area) return;
    const md = wackoToMarkdown(this.getContent());
    this.replaceContent(md);
    this.showMessage('✓ Wacko → Markdown');
  }

  convertToWacko() {
    if (!this.area) return;
    const wacko = markdownToWacko(this.getContent());
    this.replaceContent(wacko);
    this.showMessage('✓ Markdown → Wacko');
  }

  getRelativeTime(date) {
    return getRelativeTime(date, window.t); // or inject t
  }

  /**
     * Clean up all resources, event listeners, subscriptions, and feature modules
     * when the editor instance is destroyed. Prevents memory leaks.
     */
  destroy() {
    logger.info(`Destroying WikiEdit instance: ${this.id || 'unknown'}`);

    if (typeof this.#undoStateUnsubscribe === 'function') {
      this.#undoStateUnsubscribe();
      this.#undoStateUnsubscribe = null;
    }

    // Clear timer
    if (this.#pushTimer) {
      clearTimeout(this.#pushTimer);
      this.#pushTimer = null;
    }

    // Clear stacks
    this.#undoStack = [];
    this.#redoStack = [];

    // Remove beforeinput listener
    if (this.#beforeInputHandler) {
      this.area?.removeEventListener('beforeinput', this.#beforeInputHandler);
      this.#beforeInputHandler = null;
    }

    // Remove public methods that were bound
    delete this.pushState;
    delete this.undo;
    delete this.redo;
    delete this.validateState;
    delete this._debouncePushState;

    // Call feature cleanups in reverse order of setup (best practice)
    // Feature cleanups in reverse setup order
    if (typeof this._cleanupUndoRedo === 'function') this._cleanupUndoRedo();
    if (typeof this._cleanupAutosave === 'function') this._cleanupAutosave();
    if (typeof this._cleanupHeartbeat === 'function') this._cleanupHeartbeat();
    if (typeof this._cleanupLivePreview === 'function') this._cleanupLivePreview();
    if (typeof this._cleanupKeyboardShortcuts === 'function') this._cleanupKeyboardShortcuts();
    if (typeof this._cleanupMediaUpload === 'function') this._cleanupMediaUpload();
    if (typeof this._cleanupDarkZenMode === 'function') this._cleanupDarkZenMode();
    if (typeof this._cleanupModals === 'function') this._cleanupModals();
    if (typeof this._cleanupUIFeatures === 'function') this._cleanupUIFeatures();
    if (typeof this._cleanupSyntaxHighlight === 'function') this._cleanupSyntaxHighlight();

    // Fallback: Clean EditorState subscription if not already handled
    if (typeof this._undoStateUnsubscribe === 'function') {
      this._undoStateUnsubscribe();
      this._undoStateUnsubscribe = null;
      logger.debug('EditorState subscription cleaned up (fallback)');
    }

    // Remove textarea event listeners added in init()
    const ta = this.area;
    if (ta) {
      if (typeof this._inputHandler === 'function') {
        ta.removeEventListener('input', this._inputHandler);
      }
      if (typeof this._selectionHandler === 'function') {
        ta.removeEventListener('select', this._selectionHandler);
        ta.removeEventListener('keydown', this._selectionHandler);
      }

      delete ta.wikiEditInstance;
      logger.debug('Textarea event listeners removed');
    }

    // Clear core references
    this.area = null;
    this.#state = null;

    // Clear major arrays and timers
    if (this.undoStack) this.undoStack = [];
    if (this.redoStack) this.redoStack = [];
    if (this.pushTimer) {
      clearTimeout(this.pushTimer);
      this.pushTimer = null;
    }

    // Call parent destroy if it exists
    if (typeof super.destroy === 'function') {
      super.destroy();
    }

    logger.success(`WikiEdit instance destroyed: ${this.id || 'unknown'}`);
  }
}

window.WikiEdit = WikiEdit;
