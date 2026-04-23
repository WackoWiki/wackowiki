/**
 * WackoWiki - Multiple File Upload with Fetch API + Dropzone
 * Drop files, paste from clipboard (Ctrl+V), or click to select multiple files.
 * Uses the same AJAX endpoint and JSON response as WikiEdit.
 * Progressive enhancement: single-file form stays fully functional without JS.
 */

document.addEventListener('DOMContentLoaded', () => {
  const forms = document.querySelectorAll('form[name="upload"]');
  if (!forms.length) return;

  forms.forEach(form => {
    const dropzone = form.querySelector('.upload-dropzone');
    if (!dropzone) return;

    const uploadUrl = form.action;
    const fileInput = form.querySelector('input[type="file"]');
    const nonceInput = form.querySelector('input[name="_nonce"]');
    let currentNonce = nonceInput ? nonceInput.value : '';

    // Read current form options (upload_to, overwrite, etc.)
    const getFormParams = () => {
      const fd = new FormData();
      fd.append('upload', '1');
      fd.append('ajax', '1');
      fd.append('_action', 'upload');

      if (nonceInput) fd.append('_nonce', currentNonce);

      // upload_to (hidden or radio)
      const uploadTo = form.querySelector('input[name="upload_to"]:checked') ||
        form.querySelector('input[name="upload_to"]');
      if (uploadTo) fd.append('upload_to', uploadTo.value);

      // overwrite checkbox
      const overwrite = form.querySelector('input[name="file_overwrite"]');
      if (overwrite && overwrite.checked) fd.append('file_overwrite', '1');

      return fd;
    };

    const uploadFile = async (file) => {
      const formData = getFormParams();
      formData.append('file', file);

      try {
        const response = await fetch(uploadUrl, {
          method: 'POST',
          body: formData,
          credentials: 'same-origin'
        });

        let result = {};
        try { result = await response.json(); } catch (e) {}

        if (response.ok && result.filename) {
          // Update nonce for next upload (CSRF protection)
          if (result.new_nonce) {
            currentNonce = result.new_nonce;
            if (nonceInput) nonceInput.value = currentNonce;
          }
          showSuccess(file.name, result.filename);
        } else {
          showError(file.name, result.error || 'Upload failed');
        }
      } catch (err) {
        showError(file.name, 'Network error');
        console.error(err);
      }
    };

    const uploadFiles = async (files) => {
      for (const file of files) {
        await uploadFile(file);   // sequential = safe with nonce + quota checks
      }
    };

    // ==================== DROPZONE EVENTS ====================
    dropzone.addEventListener('dragover', e => {
      e.preventDefault();
      e.stopPropagation();
      dropzone.classList.add('dragover');
    });

    dropzone.addEventListener('dragleave', e => {
      e.preventDefault();
      e.stopPropagation();
      dropzone.classList.remove('dragover');
    });

    dropzone.addEventListener('drop', e => {
      e.preventDefault();
      e.stopPropagation();
      dropzone.classList.remove('dragover');
      if (e.dataTransfer.files.length) uploadFiles(e.dataTransfer.files);
    });

    // Paste support (paste directly onto the dropzone)
    dropzone.addEventListener('paste', e => {
      const items = e.clipboardData?.items || [];
      const files = [];
      for (let item of items) {
        if (item.kind === 'file') {
          const file = item.getAsFile();
          if (file) files.push(file);
        }
      }
      if (files.length) {
        e.preventDefault();
        uploadFiles(files);
      }
    });

    // Click on dropzone → open multiple file dialog
    dropzone.style.cursor = 'pointer';
    dropzone.addEventListener('click', e => {
      // ignore clicks on links/buttons inside dropzone
      if (e.target.tagName === 'A' || e.target.tagName === 'BUTTON' || e.target.type === 'file') return;

      const input = document.createElement('input');
      input.type = 'file';
      input.multiple = true;
      input.accept = fileInput ? fileInput.getAttribute('accept') : '*/*';
      input.onchange = ev => {
        if (ev.target.files?.length) uploadFiles(ev.target.files);
      };
      input.click();
    });

    // Helper messages (you can style .upload-success / .upload-error in your theme)
    const createMessage = (text, type) => {
      const div = document.createElement('div');
      div.className = `upload-message upload-${type}`;
      div.innerHTML = text;
      dropzone.parentNode.insertBefore(div, dropzone.nextSibling);
      setTimeout(() => div.remove(), 8000);
      return div;
    };

    const showSuccess = (origName, filename) => {
      createMessage(`✅ <strong>${origName}</strong> uploaded as <code>${filename}</code>`, 'success');
    };

    const showError = (origName, msg) => {
      createMessage(`❌ ${origName}: ${msg}`, 'error');
    };

    console.log('Upload dropzone + Fetch API ready (multiple files, drag & drop, paste)');
  });
});