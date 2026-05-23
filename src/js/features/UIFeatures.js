// src/js/features/UIFeatures.js

import logger from '../utils/logger.js';

/**
 * Sets up status bar, fullscreen, and critical-field warning.
 * @param {import('../core/WikiEdit.js').WikiEdit} editor
 */
export function setupUIFeatures(editor) {
	setupStatusBar(editor);
	setupFullscreen(editor);
	setupCriticalFields(editor);

  editor._cleanupUIFeatures = () => cleanup(editor);

  logger.debug('UIFeatures: setup complete with cleanup registered');
}

/**
 * Cleanup function for UI Features.
 * @param {import('../core/WikiEdit.js').WikiEdit} editor
 */
function cleanup(editor) {
  logger.info('UIFeatures: cleaning up');

  const ta = editor.area;
  if (ta) {
    // Remove resize observer if used
    if (editor._resizeObserver) {
      editor._resizeObserver.disconnect();
      delete editor._resizeObserver;
    }
  }

  delete editor._cleanupUIFeatures;
  delete editor._statusBar

  logger.debug('UIFeatures: cleanup finished');
}

// ── Status Bar ─────────────────────────────────────────────────────

function setupStatusBar(editor) {
  editor.createStatusBar = () => createStatusBar(editor);
  editor.updateStatus = () => updateStatus(editor);
  editor.showMessage = (msg, isError = false, duration = 3000) => showMessage(editor, msg, isError, duration);

  // Insert status bar after the textarea (or split container)
  const statusBar = createStatusBar(editor);

  // Store reference for later use (avoids DOM query issues with wrappers)
  editor._statusBar = statusBar;

  // Determine the correct insertion point:
  // If textarea's parent is a known wrapper (e.g., '.syntax-container'),
  // insert after that wrapper; otherwise insert after the textarea itself.
  const wrapper = editor.area.parentNode;
  const insertAfter = wrapper.classList.contains('syntax-container')
    ? wrapper
    : editor.area;

  insertAfter.parentNode.insertBefore(statusBar, insertAfter.nextSibling);

  // Attach event listeners for status updates
  const handler = () => editor.updateStatus();
  editor.area.addEventListener('input', handler);
  editor.area.addEventListener('keyup', handler);
  editor.area.addEventListener('click', handler);
  editor.area.addEventListener('mouseup', handler);
}

function createStatusBar(editor) {
  const bar = document.createElement('div');
  bar.className = 'we-statusbar';
  bar.innerHTML = `
    <div style="display: flex; align-items: center; gap: 12px;">
      <span class="we-chars">0 chars</span> • 
      <span class="we-words">0 words</span> • 
      <span class="we-cursor">1:1</span>
    </div>
    <span class="we-message"></span>
  `;
  return bar;
}

function updateStatus(editor) {
  const bar = editor._statusBar; // use stored reference
  if (!bar) return;

  const text = editor.area.value;
  const chars = text.length;
  const words = text.trim() ? text.trim().split(/\s+/).length : 0;

  const cursorPos = editor.area.selectionStart;
  const lines = text.substring(0, cursorPos).split('\n');
  const row = lines.length;
  const col = lines[lines.length - 1].length + 1;

  bar.querySelector('.we-chars').textContent = `${chars} chars`;
  bar.querySelector('.we-words').textContent = `${words} words`;
  bar.querySelector('.we-cursor').textContent = `${row}:${col}`;
}

function showMessage(editor, msg, isError = false, duration = 3000) {
  const bar = editor._statusBar; // use stored reference
  if (!bar) return;

  const msgEl = bar.querySelector('.we-message');
  msgEl.textContent = msg;
  msgEl.style.color = isError ? 'var(--we-error, #d00)' : 'var(--we-success, #28a745)';

  clearTimeout(editor._msgTimer);
  editor._msgTimer = setTimeout(() => {
    msgEl.textContent = '';
    msgEl.style.color = '';
  }, duration);
}

// ── Fullscreen ─────────────────────────────────────────────────────

function setupFullscreen(editor) {
  editor.toggleFullscreen = () => toggleFullscreen(editor);

  // Update icon when fullscreen state changes
  document.addEventListener('fullscreenchange', () => {
    editor.updateToolbarButtonStates?.();
    updateFullscreenIcon(editor);
  });

  // Initial icon setup
  updateFullscreenIcon(editor);
}

function toggleFullscreen(editor) {
  if (document.fullscreenElement) {
    document.exitFullscreen()
      .then(() => editor.updateToolbarButtonStates?.())
      .catch(err => logger.error('Fullscreen exit failed:', err));
    return;
  }

  let container = document.getElementById('page-edit') ||
    document.getElementById('commentform') ||
    editor.area.closest('form') ||
    editor.area.closest('.wikiedit-split-container') ||
    document.querySelector('.commentform');

  if (container) {
    container.requestFullscreen({ navigationUI: 'hide' })
      .then(() => editor.updateToolbarButtonStates?.())
      .catch(err => logger.error('Fullscreen request failed:', err));
  }
}

function updateFullscreenIcon(editor) {
  if (!editor.fullscreenIcon) {
    const tb = document.getElementById(`tb_${editor.id}`);
    const fsLi = tb ? tb.querySelector('li.we-fullscreen') : null;
    if (fsLi) {
      editor.fullscreenBtn = fsLi.querySelector('button');
      editor.fullscreenIcon = editor.fullscreenBtn?.querySelector('img') || editor.fullscreenBtn?.querySelector('.we-icon');
    }
  }
  if (editor.fullscreenIcon) {
    editor.fullscreenIcon.innerHTML = document.fullscreenElement ? '⛶' : '⛶'; // placeholders
  }
}

// ── Critical Fields (Unsaved Changes Warning) ──────────────────────

function setupCriticalFields(editor) {
  editor.setModified = () => setModified(editor);
  editor.ignoreModified = () => ignoreModified(editor);
  editor.checkCf = () => checkCf(editor);

  // beforeunload handler
  window.addEventListener('beforeunload', (e) => {
    const msg = editor.checkCf();
    if (msg) {
      e.preventDefault();
      e.returnValue = msg; // legacy support
      return msg;
    }
  });
}

function setModified(editor) {
  if (editor.cf_modified) return;
  editor.cf_modified = true;
  editor.area.style.borderColor = '#eecc99';
  editor.area.title = t('ModifiedHint') || 'Modified – unsaved changes';
}

function checkCf(editor) {
  if (editor.cf_modified) {
    return '\n' + (t('NotSavedWarning') || 'You have unsaved changes!') + '\n';
  }
  return null;
}

function ignoreModified(editor) {
  editor.cf_modified = false;
  editor.area.style.borderColor = '';
  editor.area.title = '';
}
