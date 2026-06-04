// src/js/editor/features/live-preview.js

import logger from '../../utils/logger.js';

/**
 * Sets up the live preview infrastructure.
 * Must be called AFTER the toolbar is built (so the toggle button exists).
 * @param {import('../editor/wikiedit.js').WikiEdit} editor
 */
export function setupLivePreview(editor) {
  editor._previewAbortController = null;

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

  if (editor._previewAbortController) {
      editor._previewAbortController.abort();
      editor._previewAbortController = null;
    }

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
  delete editor._previewAbortController;
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
    editor.previewPane.style.display = 'block';
    editor.splitter.style.display = 'block';
    editor.editPane.style.flex = '1 1 50%';
    editor.previewPane.style.flex = '1 1 50%';

    if (editor.area.value.trim()) {
      setTimeout(() => updatePreview(editor), 10);
    }
  } else {
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
      if (editor.livePreviewEnabled) {
        clearTimeout(editor.previewTimer);
        editor.previewTimer = setTimeout(() => updatePreview(editor), 80);
      }
    },
    configurable: true
  });

  // Input event as fallback
  editor.area.addEventListener('input', () => {
    if (editor.livePreviewEnabled) {
      clearTimeout(editor.previewTimer);
      editor.previewTimer = setTimeout(() => updatePreview(editor), 420);
    }
  });
}

/**
 * Fetches and displays the live preview.
 * @param {import('../editor/wikiedit.js').WikiEdit} editor
 */
async function updatePreview(editor) {
	if (editor._previewAbortController) {
	    editor._previewAbortController.abort();
	  }
	  editor._previewAbortController = new AbortController();

  const form = editor.area.closest('form');
  if (!form) return;

  const fd = new FormData(form);
  fd.set('body', editor.area.value);
  fd.set('ajax_preview', '1');

  try {
    const res = await fetch(editor.ajaxUrl, {
      method: 'POST',
      body: fd,
      credentials: 'same-origin',
	  signal: editor._previewAbortController.signal
    });
    if (!res.ok) throw new Error(`HTTP ${res.status}`);

    const data = await res.json();
    editor.previewPane.innerHTML = data.preview_html || '';

    // Update CSRF token if provided
    const tokenField = form.querySelector('input[name="_nonce"]');
    if (tokenField && data.new_form_token) {
      tokenField.value = data.new_form_token;
    }

    // Re‑sync scroll after paint
    if (editor.livePreviewEnabled) {
      requestAnimationFrame(() => {
        editor.syncEditorToPreview?.();
      });
    }
  } catch (e) {
    logger.warn('Preview fetch failed', e);
  }
}
