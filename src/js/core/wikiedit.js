// src/core/WikiEdit.js

import { ProtoEdit } from './protoedit.js';           // your base class (now a module)
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

  static buttonDefs = buttonDefs;   // keep static access if other code relies on it

  constructor() {
    super();
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

  destroy() {
    stopHeartbeat(this);
    if (this.pushTimer) clearTimeout(this.pushTimer);
    if (this.resizeObserver) this.resizeObserver.disconnect();
    // ... any other cleanup
  }

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

  replaceContent(newText, pushToUndo = true, targetArea = null) {
    const area = targetArea || this.area;
    if (!area) return;

    if (pushToUndo) this.pushState?.();
    area.value = newText || '';

    this.refreshSyntaxHighlight?.();
    this.updateStatus?.();

    if (this.livePreviewEnabled && typeof this.updatePreview === 'function') {
      setTimeout(() => this.updatePreview(), 20);
    }

    area.dispatchEvent(new Event('input', { bubbles: true }));
  }

  setAreaContent(str) {
    const t = this.area;
    const beginMatch = str.match(new RegExp('((.|\n)*)' + this.begin));
    const endMatch = str.match(new RegExp(this.begin + '((.|\n)*)' + this.end));

    const l = beginMatch ? beginMatch[1].length : 0;
    const l1 = endMatch ? endMatch[1].length : 0;

    str = str.replace(this.rbegin, '').replace(this.rend, '');
    this.replaceContent(str);
    t.setSelectionRange(l, l + l1);
    t.scrollTop = this.scroll;
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
    const md = wackoToMarkdown(this.area.value);
    this.replaceContent(md);
    this.showMessage('✓ Wacko → Markdown');
  }

  convertToWacko() {
    if (!this.area) return;
    const wacko = markdownToWacko(this.area.value);
    this.replaceContent(wacko);
    this.showMessage('✓ Markdown → Wacko');
  }

  getRelativeTime(date) {
    return getRelativeTime(date, window.t); // or inject t
  }
}

window.WikiEdit = WikiEdit;
