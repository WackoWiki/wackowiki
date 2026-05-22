// src/js/features/MediaUpload.js

import logger from '../utils/logger.js';

/**
 * Sets up media upload handling (drag & drop, paste, toolbar button).
 * @param {import('../core/WikiEdit.js').WikiEdit} editor
 */
export function setupMediaUpload(editor) {
  if (!editor.canUpload) return;

  // Attach drag/drop listeners
  editor.area.addEventListener('dragover', (e) => handleDragOver(e));
  editor.area.addEventListener('drop', (e) => handleDrop(editor, e));
  editor.area.addEventListener('paste', (e) => handlePaste(editor, e));

  // Define triggerFileUpload for the toolbar button
  editor.triggerFileUpload = () => triggerFileUpload(editor);

  // Define insertAtCursor helper (if not already present)
  editor.insertAtCursor = (text) => insertAtCursor(editor, text);

  editor._cleanupMediaUpload = () => cleanup(editor);

  logger.debug('MediaUpload: setup complete with cleanup registered');
}

/**
 * Cleanup function for Media Upload.
 * @param {import('../core/WikiEdit.js').WikiEdit} editor
 */
function cleanup(editor) {
  logger.info('MediaUpload: cleaning up');

  const ta = editor.area;
  if (ta) {
    if (typeof editor._mediaDropHandler === 'function') {
      ta.removeEventListener('drop', editor._mediaDropHandler);
    }
    if (typeof editor._mediaPasteHandler === 'function') {
      ta.removeEventListener('paste', editor._mediaPasteHandler);
    }
  }

  delete editor._mediaDropHandler;
  delete editor._mediaPasteHandler;
  delete editor._cleanupMediaUpload;

  logger.debug('MediaUpload: cleanup finished');
}

// ── Event handlers ────────────────────────────────────────────────

function handleDragOver(e) {
  e.preventDefault();
  e.stopPropagation();
  e.currentTarget.classList.add('dragover');
}

function handleDrop(editor, e) {
  e.preventDefault();
  e.stopPropagation();
  editor.area.classList.remove('dragover');
  const files = e.dataTransfer?.files;
  if (files && files.length) uploadMediaFiles(editor, files);
}

function handlePaste(editor, e) {
  const items = e.clipboardData?.items || [];
  const files = [];
  for (const item of items) {
    if (item.kind === 'file') {
      const file = item.getAsFile();
      if (file) files.push(file);
    }
  }
  if (files.length) {
    e.preventDefault();   // prevent plain text paste
    uploadMediaFiles(editor, files);
  }
}

function triggerFileUpload(editor) {
  const input = document.createElement('input');
  input.type = 'file';
  input.multiple = true;
  input.accept = 'image/*,*/*';
  input.onchange = (e) => {
    if (e.target.files.length) uploadMediaFiles(editor, e.target.files);
  };
  input.click();
}

// ── Core upload logic ──────────────────────────────────────────────

async function uploadMediaFiles(editor, files) {
  let uploadUrl = window.location.pathname.replace(/\/_edit$/, '/_upload');
  if (!uploadUrl.endsWith('/_upload')) uploadUrl += '/_upload';
  uploadUrl = window.location.origin + uploadUrl;

  for (const file of files) {
    const cursorPos = editor.area.selectionStart;
    const placeholder = `[uploading ${file.name}...]`;
    editor.insertAtCursor(placeholder);

    const formData = new FormData();
    formData.append('_nonce', editor.area.dataset.uploadNonce || '');
    formData.append('_action', 'upload');
    formData.append('upload', '1');
    formData.append('ajax', '1');
    formData.append('upload_to', 'local');
    formData.append('file', file);

    try {
      const response = await fetch(uploadUrl, {
        method: 'POST',
        body: formData,
        credentials: 'same-origin'
      });

      let result = {};
      try { result = await response.json(); } catch (e) { /* ignore */ }

      // Remove placeholder
      editor.area.value = editor.area.value.replace(placeholder, '');
      editor.area.selectionStart = editor.area.selectionEnd = cursorPos;

      if (response.ok && result.filename) {
        const isImage = file.type.startsWith('image/');
        const syntax = isImage
          ? `file:${result.filename}`
          : `((file:${result.filename} ${result.filename}))`;

        editor.insertAtCursor(syntax + '\n');
        editor.refreshSyntaxHighlight();
        editor.showMessage(`✓ ${file.name} uploaded`);

        // Update nonce for subsequent uploads
        if (result.new_nonce) {
          editor.area.dataset.uploadNonce = result.new_nonce;
        }
      } else {
        logger.error('Upload failed – server response:', result);
        editor.showMessage(`✗ ${file.name}: ${result.error || 'Upload failed'}`, true);
      }
    } catch (err) {
      // Remove placeholder on error
      editor.area.value = editor.area.value.replace(placeholder, '');
      editor.area.selectionStart = editor.area.selectionEnd = cursorPos;
      editor.showMessage(`✗ ${file.name} upload error`, true);
      logger.error(err);
    }
  }
}

/**
 * Insert text at the current cursor position.
 * @param {import('../core/WikiEdit.js').WikiEdit} editor
 * @param {string} text
 */
function insertAtCursor(editor, text) {
  const ta = editor.area;
  const start = ta.selectionStart;
  const end = ta.selectionEnd;
  const newValue = ta.value.substring(0, start) + text + ta.value.substring(end);
  editor.replaceContent(newValue);
  ta.selectionStart = ta.selectionEnd = start + text.length;
  ta.focus();
}
