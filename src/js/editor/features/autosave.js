// src/js/editor/features/autosave.js

import logger from '../../utils/logger.js';
import Storage from '../../utils/storage.js';

class AutosaveController {
  #editor;
  #timer = null;
  #draftKey = '';
  #inputHandler;
  #blurHandler;
  #beforeUnloadHandler;
  #submitHandler;

  constructor(editor) {
    this.#editor = editor;
    this.#init();
  }

  #init() {
    const editor = this.#editor;
    if (editor.area.dataset.autosaveDraft === '0') return;

    const path = window.location.pathname;
    const section = window.location.search || '';
    const uniqueKey = `${editor.id}-${path}${section}`;
    this.#draftKey = editor.DRAFT_KEY_PREFIX + uniqueKey;

    // Store draft key on editor for external access (e.g., clearDraft)
    editor.draftKey = this.#draftKey;

    // Define event handlers (arrow functions to capture `this`)
    this.#inputHandler = () => {
      editor.setModified();
      this.#debounceAutosave();
    };

    this.#blurHandler = () => {
      clearTimeout(this.#timer);
      this.saveDraft();
    };

    this.#beforeUnloadHandler = () => {
      if (!editor.isSubmitting) {
        this.saveDraft();
      }
    };

    this.#submitHandler = () => {
      editor.isSubmitting = true;
      editor.ignoreModified();
      this.clearDraft();
    };

    // Attach listeners
    editor.area.addEventListener('input', this.#inputHandler);
    editor.area.addEventListener('blur', this.#blurHandler);
    window.addEventListener('beforeunload', this.#beforeUnloadHandler, { passive: true });

    const form = editor.area.form || editor.area.closest('form');
    if (form) {
      form.addEventListener('submit', this.#submitHandler);
    }

    // Load any existing draft
    this.#loadAutosavedDraft();
  }

  /** Debounced autosave – fires after user stops typing */
  #debounceAutosave() {
    clearTimeout(this.#timer);
    this.#timer = setTimeout(() => {
      this.saveDraft();
    }, this.#editor.autosaveDelay);
  }

  /** Saves the current editor content to localStorage */
  saveDraft() {
    const editor = this.#editor;
    if (!editor.cf_modified) {
      logger.debug('Draft save skipped – no changes');
      return;
    }
    if (!this.#draftKey) return;

    const content = editor.getContent().trim();
    if (content === '') {
      Storage.remove(this.#draftKey);
      return;
    }

    const draftData = {
      content,
      timestamp: Date.now(),
      title: document.getElementById('page_title')?.value?.trim() || ''
    };

    if (Storage.set(this.#draftKey, JSON.stringify(draftData))) {
      editor.showMessage(`✓ ${t('DraftSaved') || 'Draft saved'}`);
    }
  }

  /** Clears the stored draft */
  clearDraft() {
    if (!this.#draftKey) return;
    Storage.remove(this.#draftKey);
    logger.info('Draft cleared');
    this.#editor.showMessage(`${t('DraftCleared') || 'Draft cleared'}`);
  }

  /** Loads an existing draft and shows recovery infobox */
  #loadAutosavedDraft() {
    const saved = Storage.get(this.#draftKey);
    if (!saved) return;

    let draft;
    try {
      draft = JSON.parse(saved);
    } catch (e) {
      Storage.remove(this.#draftKey);
      return;
    }

    if (!draft.content) {
      Storage.remove(this.#draftKey);
      return;
    }

    this.#showDraftInfobox(draft);
  }

  /** Renders the draft recovery infobox */
  #showDraftInfobox(draft) {
    const editor = this.#editor;
    const date = new Date(draft.timestamp);
    const timeStr = date.toLocaleString();
    const relativeTime = editor.getRelativeTime(date);

    const infoboxHTML = `
      <div id="draft-infobox" class="info-box draft-infobox">
        <strong>${t('DraftFound') || 'Draft found'}</strong> — 
        ${t('SavedOn') || 'saved'} 
        <time datetime="${date.toISOString()}" title="${timeStr}">
          ${relativeTime}
        </time><br>
        <span class="visuallyhidden">${t('RecoverDraftQuestion') || 'Do you want to recover the draft?'}</span>
        <br>
        <button type="button" class="btn btn-primary" id="recover-draft-btn">${t('RecoverDraft') || 'Recover Draft'}</button>
        <button type="button" class="btn btn-cancel" id="discard-draft-btn">${t('DiscardDraft') || 'Discard Draft'}</button>
      </div>
    `;

    const placeholder = document.getElementById('draft-infobox-placeholder');
    if (placeholder) {
      placeholder.innerHTML = infoboxHTML;
    } else {
      const target = editor.area?.parentNode;
      if (target) {
        const div = document.createElement('div');
        div.innerHTML = infoboxHTML;
        target.insertBefore(div, editor.area);
      }
    }

    // Attach event listeners
    const recoverBtn = document.getElementById('recover-draft-btn');
    const discardBtn = document.getElementById('discard-draft-btn');

    if (recoverBtn) {
      recoverBtn.addEventListener('click', () => {
        editor.replaceContent(draft.content);
        Storage.remove(this.#draftKey);
        document.getElementById('draft-infobox')?.remove();
      });
    }

    if (discardBtn) {
      discardBtn.addEventListener('click', () => {
        Storage.remove(this.#draftKey);
        document.getElementById('draft-infobox')?.remove();
      });
    }
  }

  /** Cleanup: remove listeners, clear timer */
  destroy() {
    logger.info('Autosave: cleaning up');

    const editor = this.#editor;
    const ta = editor.area;

    if (ta) {
      ta.removeEventListener('input', this.#inputHandler);
      ta.removeEventListener('blur', this.#blurHandler);
    }

    window.removeEventListener('beforeunload', this.#beforeUnloadHandler);

    const form = ta?.form || ta?.closest('form');
    if (form) {
      form.removeEventListener('submit', this.#submitHandler);
    }

    clearTimeout(this.#timer);
    this.#timer = null;

    // Remove editor references
    delete editor._autosaveController;
    delete editor._cleanupAutosave;
    delete editor.draftKey;

    logger.debug('Autosave: cleanup finished');
  }
}

/**
 * Sets up autosave listeners using a private controller class.
 * @param {import('../editor/wikiedit.js').WikiEdit} editor
 */
export function setupAutosave(editor) {
  if (editor.area.dataset.autosaveDraft === '0') return;

  const controller = new AutosaveController(editor);
  editor._autosaveController = controller;

  // Register cleanup function
  editor._cleanupAutosave = () => controller.destroy();

  // Expose public methods for external use (e.g., from toolbar)
  editor.saveDraft = () => controller.saveDraft();
  editor.clearDraft = () => controller.clearDraft();

  logger.debug('Autosave: setup complete with cleanup registered');
}

// Re-export for external use (optional)
export { AutosaveController };