// src/js/editor/features/media-upload.js

import logger from '../../utils/logger.js';

/**
 * Sets up media upload handling (drag & drop, paste, toolbar button).
 * @param {import('../editor/wikiedit.js').WikiEdit} editor
 */
export function setupMediaUpload(editor) {
  if (!editor.canUpload) return;

  editor._mediaUploadAbortController = null;

  // Attach drag/drop listeners
  editor.area.addEventListener('dragover', (e) => handleDragOver(e));
  editor.area.addEventListener('drop', (e) => handleDrop(editor, e));
  editor.area.addEventListener('paste', (e) => handlePaste(editor, e));

  // Define triggerFileUpload for the toolbar button
  editor.triggerFileUpload = () => triggerFileUpload(editor);
  editor.insertAtCursor = (text, pushToUndo = true) => insertAtCursor(editor, text, pushToUndo);

  editor._cleanupMediaUpload = () => cleanup(editor);

  logger.debug('MediaUpload: setup complete with AbortController');
}

/**
 * Cleanup function – aborts any pending upload.
* @param {import('../editor/wikiedit.js').WikiEdit} editor
 */
function cleanup(editor) {
  logger.info('MediaUpload: cleaning up');

  // Abort any in-flight upload
  if (editor._mediaUploadAbortController) {
    editor._mediaUploadAbortController.abort();
    editor._mediaUploadAbortController = null;
  }

  const ta = editor.area;
  if (ta) {
    ta.removeEventListener('drop', editor._mediaDropHandler);
    ta.removeEventListener('paste', editor._mediaPasteHandler);
  }

  delete editor._mediaUploadAbortController;
  delete editor._mediaDropHandler;
  delete editor._mediaPasteHandler;
  delete editor._cleanupMediaUpload;

  logger.debug('MediaUpload: cleanup finished');
}

// ── Event Handlers ─────────────────────────────────────────────────

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
  if (files?.length) uploadMediaFiles(editor, files);
}

function handlePaste(editor, e) {
  const items = e.clipboardData?.items || [];
  const files = Array.from(items)
    .filter(item => item.kind === 'file')
    .map(item => item.getAsFile())
    .filter(Boolean);

  if (files.length) {
    e.preventDefault();
    uploadMediaFiles(editor, files);
  }
}

function triggerFileUpload(editor) {
  const input = document.createElement('input');
  input.type = 'file';
  input.multiple = true;
  input.accept = 'image/*,*/*';
  input.onchange = (e) => {
    if (e.target.files?.length) uploadMediaFiles(editor, e.target.files);
  };
  input.click();
}

// ── Main Upload Function with AbortController ─────────────────────

async function uploadMediaFiles(editor, files) {
  let uploadUrl = window.location.pathname.replace(/\/_edit$/, '/_upload');
  if (!uploadUrl.endsWith('/_upload')) uploadUrl += '/_upload';
  uploadUrl = window.location.origin + uploadUrl;

  for (const file of files) {
    const cursorPos = editor.area.selectionStart;
    const placeholder = `[uploading ${file.name}...]`;

    // Step 1: Insert placeholder without history
    editor.insertAtCursor(placeholder, false);

    // Create new AbortController for this upload
    editor._mediaUploadAbortController = new AbortController();

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
        credentials: 'same-origin',
        signal: editor._mediaUploadAbortController.signal
      });

      const result = response.ok ? await response.json() : {};

      if (response.ok && result.filename) {
        const isImage = file.type.startsWith('image/');
        const finalSyntax = isImage 
          ? `file:${result.filename}` 
          : `((file:${result.filename} ${result.filename}))`;

		// Step 2: Replace placeholder with final syntax
        editor.replaceContent(
          editor.area.value.replace(placeholder, finalSyntax + '\n'),
          true
        );

        editor.showMessage(`✓ ${file.name} uploaded`);

		// Update nonce for subsequent uploads
        if (result.new_nonce) {
          editor.area.dataset.uploadNonce = result.new_nonce;
        }
      } else {
        // Remove placeholder on failure
        editor.replaceContent(editor.area.value.replace(placeholder, ''), false);
        editor.showMessage(`✗ ${file.name}: ${result.error || 'Upload failed'}`, true);
      }
    } catch (err) {
      if (err.name === 'AbortError') {
        logger.debug(`Upload of ${file.name} was aborted`);
      } else {
        logger.error(`Upload error for ${file.name}:`, err);
        editor.replaceContent(editor.area.value.replace(placeholder, ''), false);
        editor.showMessage(`✗ ${file.name} upload error`, true);
      }
    } finally {
      editor._mediaUploadAbortController = null;
    }
  }
}

/**
 * Insert text at cursor position.
 * @param {import('../editor/wikiedit.js').WikiEdit} editor
 * @param {string} text
 * @param {boolean} pushToUndo
 */
function insertAtCursor(editor, text, pushToUndo = true) {
  const ta = editor.area;
  if (!ta) return;

  const start = ta.selectionStart;
  const end = ta.selectionEnd;
  const newValue = ta.value.substring(0, start) + text + ta.value.substring(end);

  editor.replaceContent(newValue, pushToUndo);

  const newCursorPos = start + text.length;
  ta.selectionStart = ta.selectionEnd = newCursorPos;
  ta.focus();
}