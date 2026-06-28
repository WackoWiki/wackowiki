// src/js/editor/features/live-preview.js

import logger from '../../utils/logger.js';

const PREVIEW_DEBOUNCE_MS = 420;

/**
 * @param {import('../editor/wikiedit.js').WikiEdit} editor
 * @returns {string}
 */
function getPreviewAction(editor) {
  const heartbeat = editor.area?.dataset.heartbeatName;
  return heartbeat === 'add_comment' ? 'add_comment_preview' : 'edit_page_preview';
}

/**
 * Pause live preview scheduling (e.g. before save).
 * @param {import('../editor/wikiedit.js').WikiEdit} editor
 */
export function pauseLivePreview(editor) {
  editor._previewPaused = true;
  clearTimeout(editor.previewTimer);
  editor.previewTimer = null;
}

/**
 * Wait until no preview request is in flight.
 * @param {import('../editor/wikiedit.js').WikiEdit} editor
 * @returns {Promise<void>}
 */
export function awaitPreviewIdle(editor) {
  pauseLivePreview(editor);
  if (!editor._previewInFlight) {
    return Promise.resolve();
  }
  return new Promise(resolve => {
    editor._previewIdleWaiters = editor._previewIdleWaiters || [];
    editor._previewIdleWaiters.push(resolve);
  });
}

/**
 * @param {import('../editor/wikiedit.js').WikiEdit} editor
 */
function notifyPreviewIdle(editor) {
  editor._previewInFlight = false;

  const waiters = editor._previewIdleWaiters;
  if (waiters?.length) {
    editor._previewIdleWaiters = [];
    waiters.forEach(resolve => resolve());
  }

  if (editor._previewNeedsRefresh && !editor._previewPaused && editor.livePreviewEnabled) {
    editor._previewNeedsRefresh = false;
    updatePreview(editor);
  }
}

/**
 * Debounced preview scheduler — one unified entry point for all change detection.
 * @param {import('../editor/wikiedit.js').WikiEdit} editor
 */
function schedulePreview(editor) {
  if (!editor.livePreviewEnabled || editor._previewPaused || editor.isSubmitting) {
    return;
  }

  clearTimeout(editor.previewTimer);
  editor.previewTimer = setTimeout(() => {
    editor.previewTimer = null;
    updatePreview(editor);
  }, PREVIEW_DEBOUNCE_MS);
}

/**
 * Sets up the live preview infrastructure.
 * Must be called AFTER the toolbar is built (so the toggle button exists).
 * @param {import('../editor/wikiedit.js').WikiEdit} editor
 */
export function setupLivePreview(editor) {
  if (!editor.isRegisteredUser) return;

  editor._previewInFlight = false;
  editor._previewNeedsRefresh = false;
  editor._previewPaused = false;
  editor._previewIdleWaiters = [];
  editor._previewSeq = 0;
  editor.schedulePreview = () => schedulePreview(editor);

  // Create the split container and panes (hidden by default)
  createSplitPanes(editor);

  // Determine if we should auto‑enable based on saved preference or server default
  const saved = localStorage.getItem('we_live_preview_enabled');
  const shouldEnable = saved !== null
    ? saved === 'true'
    : editor.livePreviewDefault;

  if (shouldEnable) {
    // Auto‑enable after a short delay to ensure everything is rendered
    setTimeout(() => toggleLivePreview(editor), 100);
  }

  // Listen for manual toggles via the toolbar delegation
  // (the toolbar calls editor.toggleLivePreview, which we bind below)
  editor.toggleLivePreview = () => toggleLivePreview(editor);

  const form = editor.area.closest('form');
  if (form) {
    form.addEventListener('submit', () => pauseLivePreview(editor));
  }

  // Register cleanup
  editor._cleanupLivePreview = () => cleanup(editor);

  logger.debug('LivePreview: setup complete with cleanup registered');
}

/**
 * Cleanup function for Live Preview.
 * @param {import('../editor/wikiedit.js').WikiEdit} editor
 */
function cleanup(editor) {
  logger.info('LivePreview: cleaning up');

  pauseLivePreview(editor);
  editor._previewNeedsRefresh = false;
  editor._previewIdleWaiters = [];

  // Hide and remove preview elements if they exist
  if (editor.previewPane) {
    editor.previewPane.style.display = 'none';
  }
  if (editor.splitter) {
    editor.splitter.style.display = 'none';
  }

  // Clean up references
  delete editor.toggleLivePreview;
  delete editor.livePreviewEnabled;
  delete editor.schedulePreview;
  delete editor._previewInFlight;
  delete editor._previewNeedsRefresh;
  delete editor._previewPaused;
  delete editor._previewIdleWaiters;
  delete editor._cleanupLivePreview;

  logger.debug('LivePreview: cleanup finished');
}

/**
 * Toggles the live preview pane on/off.
 * @param {import('../editor/wikiedit.js').WikiEdit} editor
 */
export function toggleLivePreview(editor) {
  editor.livePreviewEnabled = !editor.livePreviewEnabled;

  const tb = document.getElementById(`tb_${editor.id}`);
  const liveLi = tb ? tb.querySelector('li.we-livepreview') : null;
  if (liveLi) liveLi.classList.toggle('active', editor.livePreviewEnabled);

  if (editor.livePreviewEnabled) {
    editor._previewPaused = false;
    editor.previewPane.style.display = 'block';
    editor.splitter.style.display = 'block';
    editor.editPane.style.flex = '1 1 50%';
    editor.previewPane.style.flex = '1 1 50%';

    if (editor.area.value.trim()) {
      schedulePreview(editor);
    }
  } else {
    pauseLivePreview(editor);
    editor.previewPane.style.display = 'none';
    editor.splitter.style.display = 'none';
    editor.editPane.style.flex = '1 1 100%';
  }

  localStorage.setItem('we_live_preview_enabled', editor.livePreviewEnabled);
  editor.updateToolbarButtonStates();
}

/**
 * Creates the split panes and attaches them to the DOM.
 * This is done once, regardless of whether live preview is initially on.
 * @param {import('../editor/wikiedit.js').WikiEdit} editor
 */
function createSplitPanes(editor) {
  const wrapper = editor.area.parentNode;
  const originalNextSibling = editor.area.nextSibling;
  const originalHeight = `${editor.preferredHeight}px`;

  // Container
  const container = document.createElement('div');
  container.className = 'wikiedit-split-container';
  container.style.cssText = `display:flex; height:${originalHeight}; min-height:300px; gap:8px; box-sizing:border-box;`;

  // Editor pane
  editor.editPane = document.createElement('div');
  editor.editPane.style.cssText = 'flex:1 1 50%; min-width:300px; display:flex; flex-direction:column; height:100%;';
  editor.area.style.cssText += 'flex:1 1 auto; height:100%; width:100%; box-sizing:border-box; resize:none; min-height:0;';
  editor.editPane.appendChild(editor.area);

  // Splitter (draggable)
  editor.splitter = document.createElement('div');
  editor.splitter.style.cssText = 'width:6px; background:#ddd; cursor:col-resize; flex-shrink:0; display:none;';

  // Preview pane
  editor.previewPane = document.createElement('div');
  editor.previewPane.id = 'wikiedit-live-preview';
  editor.previewPane.style.cssText = 'flex:1 1 50%; min-width:300px; overflow:auto; padding:20px; border:1px solid #ccc; display:none; box-sizing:border-box;';

  container.append(editor.editPane, editor.splitter, editor.previewPane);
  wrapper.insertBefore(container, originalNextSibling);

  // Store reference for height adjustments
  editor.splitContainer = container;

  // Draggable splitter logic
  let isDragging = false;
  editor.splitter.addEventListener('mousedown', e => { isDragging = true; e.preventDefault(); });
  document.addEventListener('mousemove', e => {
    if (!isDragging) return;
    const rect = container.getBoundingClientRect();
    let percent = ((e.clientX - rect.left) / rect.width) * 100;
    percent = Math.max(20, Math.min(80, percent));
    editor.editPane.style.flex = `1 1 ${percent}%`;
    editor.previewPane.style.flex = `1 1 ${100 - percent}%`;
  });
  document.addEventListener('mouseup', () => { isDragging = false; });

  // Bidirectional vertical scroll sync
  let syncing = false;

  editor.syncEditorToPreview = () => {
    if (!editor.livePreviewEnabled || syncing) return;
    syncing = true;
    const ed = editor.area;
    const pv = editor.previewPane;
    const percent = (ed.scrollHeight > ed.clientHeight)
      ? ed.scrollTop / (ed.scrollHeight - ed.clientHeight)
      : 0;
    pv.scrollTop = percent * (pv.scrollHeight - pv.clientHeight || 0);
    syncing = false;
  };

  editor.syncPreviewToEditor = () => {
    if (!editor.livePreviewEnabled || syncing) return;
    syncing = true;
    const ed = editor.area;
    const pv = editor.previewPane;
    const percent = (pv.scrollHeight > pv.clientHeight)
      ? pv.scrollTop / (pv.scrollHeight - pv.clientHeight)
      : 0;
    ed.scrollTop = percent * (ed.scrollHeight - ed.clientHeight || 0);
    syncing = false;
  };

  editor.area.addEventListener('scroll', editor.syncEditorToPreview, { passive: true });
  editor.previewPane.addEventListener('scroll', editor.syncPreviewToEditor, { passive: true });

  // Live preview update logic
  editor.livePreviewEnabled = false;
  editor.previewTimer = null;

  // Reliable change detection (override value setter)
  const ta = editor.area;
  const valueDescriptor = Object.getOwnPropertyDescriptor(HTMLTextAreaElement.prototype, 'value');
  const origSetter = valueDescriptor.set;
  Object.defineProperty(ta, 'value', {
    get() { return valueDescriptor.get.call(this); },
    set(newValue) {
      origSetter.call(this, newValue);
      schedulePreview(editor);
    },
    configurable: true
  });

  editor.area.addEventListener('input', () => schedulePreview(editor));
}

/**
 * Build preview FormData using the preview-only nonce chain
 * @param {import('../editor/wikiedit.js').WikiEdit} editor
 * @param {HTMLFormElement} form
 * @returns {FormData|null}
 */
function buildPreviewFormData(editor, form) {
  const previewNonce = editor.area.dataset.previewNonce;
  if (!previewNonce) {
    logger.warn('Preview nonce missing — live preview unavailable');
    return null;
  }

  const fd = new FormData(form);
  fd.delete('_nonce');
  fd.delete('_action');
  fd.set('body', editor.area.value);
  fd.set('ajax_preview', '1');
  fd.set('_action', getPreviewAction(editor));
  fd.set('_nonce', previewNonce);

  return fd;
}

/**
 * Fetches and displays the live preview (serialized — one request at a time).
 * @param {import('../editor/wikiedit.js').WikiEdit} editor
 */
async function updatePreview(editor) {
  if (!editor.livePreviewEnabled || editor._previewPaused || editor.isSubmitting) {
    return;
  }

  if (editor._previewInFlight) {
    editor._previewNeedsRefresh = true;
    return;
  }

  const form = editor.area.closest('form');
  if (!form) return;

  const fd = buildPreviewFormData(editor, form);
  if (!fd) return;

  editor._previewInFlight = true;
  const seq = ++editor._previewSeq;

  try {
    const res = await fetch(editor.ajaxUrl, {
      method: 'POST',
      body: fd,
      credentials: 'same-origin'
    });

    if (!res.ok) throw new Error(`HTTP ${res.status}`);

    const contentType = res.headers.get('Content-Type') || '';
    if (!contentType.includes('application/json')) {
      throw new Error('Expected JSON response from preview endpoint');
    }

    const data = await res.json();

    if (seq !== editor._previewSeq) {
      return;
    }

    editor.previewPane.innerHTML = data.preview_html || '';

    if (data.new_preview_nonce) {
      editor.area.dataset.previewNonce = data.new_preview_nonce;
    }

    // Re‑sync scroll after paint
    if (editor.livePreviewEnabled) {
      requestAnimationFrame(() => {
        editor.syncEditorToPreview?.();
      });
    }
  } catch (e) {
    if (seq === editor._previewSeq) {
      logger.warn('Preview fetch failed', e);
    }
  } finally {
    notifyPreviewIdle(editor);
  }
}
