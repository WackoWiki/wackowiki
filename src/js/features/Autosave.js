// src/features/Autosave.js

import logger from '../utils/logger.js';
import { safeSetItem, safeGetItem, safeRemoveItem } from '../utils/storage.js';

/**
 * Sets up autosave listeners, prepares the storage key,
 * and loads any existing draft.
 * @param {import('../core/WikiEdit.js').WikiEdit} editor
 */
export function setupAutosave(editor) {
  if (editor.area.dataset.autosaveDraft === '0') return;

  const path = window.location.pathname;
  const section = window.location.search || '';
  const uniqueKey = `${editor.id}-${path}${section}`;
  editor.draftKey = editor.DRAFT_KEY_PREFIX + uniqueKey;

  // Input → mark as modified + debounced save
  editor.area.addEventListener('input', () => {
    editor.setModified();
    debounceAutosave(editor);
  });

  // Blur saves immediately
  editor.area.addEventListener('blur', () => {
    clearTimeout(editor.autosaveTimer);
    saveDraft(editor);
  });

  // beforeunload save
  window.addEventListener('beforeunload', () => {
    if (!editor.isSubmitting) {
      saveDraft(editor);
    }
  }, { passive: true });

  // Form submit: clear draft and ignore modified warning
  const form = editor.area.form || editor.area.closest('form');
  if (form) {
    form.addEventListener('submit', () => {
      editor.isSubmitting = true;
      editor.ignoreModified();
      clearDraft(editor);
    });
  }

  // Load any existing draft
  loadAutosavedDraft(editor);
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

  const content = editor.area.value.trim();
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
  const relativeTime = editor.getRelativeTime(date);   // still in class, but could be extracted later

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
