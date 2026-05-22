// src/js/features/Autosave.js

import logger from '../utils/logger.js';
import { safeSetItem, safeGetItem, safeRemoveItem } from '../utils/storage.js';

/**
 * Sets up autosave listeners, prepares the storage key,
 * and loads any existing draft.
 * Registers cleanup function for proper destruction.
 * @param {import('../core/WikiEdit.js').WikiEdit} editor
 */
export function setupAutosave(editor) {
  if (editor.area.dataset.autosaveDraft === '0') return;

  const path = window.location.pathname;
  const section = window.location.search || '';
  const uniqueKey = `${editor.id}-${path}${section}`;
  editor.draftKey = editor.DRAFT_KEY_PREFIX + uniqueKey;

  // Store references for cleanup
  editor._autosaveInputHandler = () => {
    editor.setModified();
    debounceAutosave(editor);
  };

  // Blur saves immediately
  editor._autosaveBlurHandler = () => {
    clearTimeout(editor.autosaveTimer);
    saveDraft(editor);
  };

  editor._autosaveBeforeUnloadHandler = () => {
    if (!editor.isSubmitting) {
      saveDraft(editor);
    }
  };

  // Input → mark as modified + debounced save
  editor.area.addEventListener('input', editor._autosaveInputHandler);

  // Blur saves immediately
  editor.area.addEventListener('blur', editor._autosaveBlurHandler);

  // beforeunload save
  window.addEventListener('beforeunload', editor._autosaveBeforeUnloadHandler, { passive: true });

  // Form submit: clear draft and ignore modified warning
  const form = editor.area.form || editor.area.closest('form');
  if (form) {
    editor._autosaveSubmitHandler = () => {
      editor.isSubmitting = true;
      editor.ignoreModified();
      clearDraft(editor);
    };
    form.addEventListener('submit', editor._autosaveSubmitHandler);
  }

  // Load any existing draft
  loadAutosavedDraft(editor);

  // Register cleanup function
  editor._cleanupAutosave = () => cleanup(editor);

  logger.debug('Autosave: setup complete with cleanup registered');
}

/**
 * Cleanup function for autosave feature.
 * Removes all event listeners and clears timers to prevent memory leaks.
 * @param {import('../core/WikiEdit.js').WikiEdit} editor
 */
function cleanup(editor) {
  logger.info('Autosave: cleaning up');

  const ta = editor.area;

  // Remove textarea listeners
  if (ta) {
    if (typeof editor._autosaveInputHandler === 'function') {
      ta.removeEventListener('input', editor._autosaveInputHandler);
    }
    if (typeof editor._autosaveBlurHandler === 'function') {
      ta.removeEventListener('blur', editor._autosaveBlurHandler);
    }
  }

  // Remove window listener
  if (typeof editor._autosaveBeforeUnloadHandler === 'function') {
    window.removeEventListener('beforeunload', editor._autosaveBeforeUnloadHandler);
  }

  // Remove form submit listener
  if (typeof editor._autosaveSubmitHandler === 'function') {
    const form = ta?.form || ta?.closest('form');
    if (form) {
      form.removeEventListener('submit', editor._autosaveSubmitHandler);
    }
  }

  // Clear autosave timer
  if (editor.autosaveTimer) {
    clearTimeout(editor.autosaveTimer);
    editor.autosaveTimer = null;
  }

  // Clean up method references
  delete editor._autosaveInputHandler;
  delete editor._autosaveBlurHandler;
  delete editor._autosaveBeforeUnloadHandler;
  delete editor._autosaveSubmitHandler;
  delete editor._cleanupAutosave;

  logger.debug('Autosave: cleanup finished');
}

/**
 * Saves the current editor content to localStorage.
 * Empty content clears the draft.
 * @param {import('../core/WikiEdit.js').WikiEdit} editor
 */
export function saveDraft(editor) {
  if (!editor.cf_modified) {
    logger.debug('Draft save skipped – no changes');
    return;
  }
  if (!editor.draftKey) return;

  const content = editor.getContent().trim();   // Use state instead of direct textarea
  if (content === '') {
    safeRemoveItem(editor.draftKey);
    return;
  }

  const draftData = {
    content,
    timestamp: Date.now(),
    title: document.getElementById('page_title')?.value?.trim() || ''
  };

  if (safeSetItem(editor.draftKey, JSON.stringify(draftData))) {
    editor.showMessage(`✓ ${t('DraftSaved') || 'Draft saved'}`);
  }
}

/**
 * Clears the stored draft.
 * @param {import('../core/WikiEdit.js').WikiEdit} editor
 */
export function clearDraft(editor) {
  if (!editor.draftKey) return;
  safeRemoveItem(editor.draftKey);
  logger.info('Draft cleared');
  editor.showMessage(`${t('DraftCleared') || 'Draft cleared'}`);
}

/**
 * Debounced autosave – fires after user stops typing for `autosaveDelay` ms.
 * @param {import('../core/WikiEdit.js').WikiEdit} editor
 */
function debounceAutosave(editor) {
  clearTimeout(editor.autosaveTimer);
  editor.autosaveTimer = setTimeout(() => {
    saveDraft(editor);
  }, editor.autosaveDelay);
}

/**
 * Checks for an existing draft and displays an infobox to recover or discard it.
 * @param {import('../core/WikiEdit.js').WikiEdit} editor
 */
function loadAutosavedDraft(editor) {
  const saved = safeGetItem(editor.draftKey);
  if (!saved) return;

  let draft;
  try {
    draft = JSON.parse(saved);
  } catch (e) {
    safeRemoveItem(editor.draftKey);
    return;
  }

  if (!draft.content) {
    safeRemoveItem(editor.draftKey);
    return;
  }

  showDraftInfobox(editor, draft);
}

/**
 * Renders the draft recovery infobox with buttons.
 * @param {import('../core/WikiEdit.js').WikiEdit} editor
 * @param {object} draft
 */
function showDraftInfobox(editor, draft) {
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
      safeRemoveItem(editor.draftKey);
      document.getElementById('draft-infobox')?.remove();
    });
  }

  if (discardBtn) {
    discardBtn.addEventListener('click', () => {
      safeRemoveItem(editor.draftKey);
      document.getElementById('draft-infobox')?.remove();
    });
  }
}