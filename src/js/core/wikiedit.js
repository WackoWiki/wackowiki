// src/core/WikiEdit.js

import { ProtoEdit } from './protoedit.js';           // your base class (now a module)
import { EditorState } from './EditorState.js';
import logger from '../utils/logger.js';
import { loadPreferredNumber } from '../utils/storage.js';
import { getRelativeTime } from '../utils/time.js';
import { buttonDefs, getDefaultToolbarOrder } from '../toolbar/ToolbarConfig.js';
import { loadAndBuildToolbar } from '../toolbar/ToolbarBuilder.js';

// Feature modules
import { setupToolbarDelegation } from '../toolbar/ToolbarDelegation.js';
import { setupAutosave } from '../features/Autosave.js';
import { setupLivePreview } from '../features/LivePreview.js';
import { setupSyntaxHighlighting } from '../features/SyntaxHighlight.js';
import { wackoToMarkdown, markdownToWacko } from '../features/MarkupConversion.js';
import { setupMarkupHelpers } from '../features/MarkupHelpers.js';
import { setupUndoRedo } from '../features/UndoRedo.js';
import { setupHeartbeat, stopHeartbeat } from '../features/SessionHeartbeat.js';
import { setupMediaUpload } from '../features/MediaUpload.js';
import { setupKeyboardShortcuts } from '../features/KeyboardShortcuts.js';
import { setupDarkZenMode } from '../features/DarkZenMode.js';
import { setupModals } from '../features/Modals.js';
import { setupUIFeatures } from '../features/UIFeatures.js';



/*!
 * WikiEdit v3.26 (ES2023+)
 * https://wackowiki.org/doc/Dev/Projects/WikiEdit
 *
 * Licensed BSD © Roman Ivanov, Evgeny Nedelko, WackoWiki Team
 */

export class WikiEdit extends ProtoEdit {

  static buttonDefs = buttonDefs;

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

    // === Initialize State with current textarea content ===
    this.#state.setContent(ta.value, false);

    // === State → UI Sync ===
    this.#state.subscribe((change) => {
      const ta = this.area;
      if (!ta) return;

      if (change.type === 'content') {
        if (ta.value !== change.content) {
          ta.value = change.content;
        }

        if (change.selection) {
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

        ta.dispatchEvent(new Event('input', { bubbles: true }));
      }
    });

    const inputHandler = () => {
      this.#state.setContent(ta.value, false);
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
    setupUndoRedo(this);
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

    // Push to undo stack only when explicitly requested
    if (pushToUndo && typeof this.pushState === 'function') {
      this.pushState();
    }

    this.#state.setContent(newText || '', pushToUndo, {
      selection: finalSelection,
      scroll: scroll ?? this.area.scrollTop
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
