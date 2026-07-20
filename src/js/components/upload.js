// components/upload.js

document.addEventListener('DOMContentLoaded', () => {
  const forms = document.querySelectorAll('form[name="upload"]');
  if (!forms.length) return;

  forms.forEach(form => {
    const dropzone = form.querySelector('.upload-dropzone');
    const statusList = form.querySelector('.upload-status-list');
    const tabAjax = document.getElementById('tab-ajax');
    const tabClassic = document.getElementById('tab-classic');
    const tabs = form.querySelectorAll('.tab-btn');

    if (!dropzone || !tabAjax || !tabClassic) return;

    const uploadUrl = form.action;
    const nonceInput = form.querySelector('input[name="_nonce"]');
    let currentNonce = nonceInput ? nonceInput.value : '';

    function initUploadForForm() {
      const switchTab = (tabName) => {
        tabs.forEach(t => t.classList.remove('active'));
        const activeBtn = document.querySelector(`.tab-btn[data-tab="${tabName}"]`);
        if (activeBtn) activeBtn.classList.add('active');

        if (tabName === 'ajax') {
          tabAjax.classList.remove('hidden');
          tabClassic.classList.add('hidden');
        } else {
          tabAjax.classList.add('hidden');
          tabClassic.classList.remove('hidden');
        }
      };

      switchTab('ajax');   // JS enabled → show AJAX tab

      tabs.forEach(tab => tab.addEventListener('click', () => switchTab(tab.dataset.tab)));

      const getFormParams = () => {
        const fd = new FormData();
        fd.append('upload', '1');
        fd.append('ajax', '1');
        fd.append('_action', 'upload');
        if (nonceInput) fd.append('_nonce', currentNonce);

        const uploadTo = form.querySelector('input[name="upload_to"]:checked');
        if (uploadTo) fd.append('upload_to', uploadTo.value);

        const overwrite = form.querySelector('input[name="file_overwrite"]');
        if (overwrite && overwrite.checked) fd.append('file_overwrite', '1');

        return fd;
      };

      const createFileItem = (file) => {
        const item = document.createElement('div');
        item.className = 'upload-file-item';
        item.innerHTML = `
          <div class="upload-file-info">
            <span class="upload-file-name">${Ut.escapeHtml(file.name)}</span>
            <span class="upload-file-size">(${Ut.formatBytes(file.size)})</span>
            <span class="upload-file-status">Preparing...</span>
          </div>
          <div class="upload-progress-container">
            <div class="upload-progress-bar">
              <div class="upload-progress-fill" style="width:0%"></div>
            </div>
          </div>
          <button type="button" class="upload-file-remove" title="Remove">×</button>
        `;
        statusList.appendChild(item);
        item.querySelector('.upload-file-remove').addEventListener('click', () => item.remove());
        return item;
      };

      const updateItem = (item, html, progress = null, type = '') => {
        const infoEl = item.querySelector('.upload-file-info');

        if (type === 'success') {
          infoEl.innerHTML = html;
        } else {
          const statusEl = item.querySelector('.upload-file-status');
          statusEl.innerHTML = html;
        }

        if (type) {
          const statusEl = item.querySelector('.upload-file-status') || infoEl;
          statusEl.className = `upload-file-status upload-${type}`;
        }

        if (progress !== null) {
          const fill = item.querySelector('.upload-progress-fill');
          if (fill) fill.style.width = `${Math.min(100, progress)}%`;
        }
      };

      const uploadFile = async (file) => {
        const item = createFileItem(file);
        updateItem(item, 'Uploading...', 0);

        const formData = getFormParams();
        formData.append('file', file);

        try {
          const response = await fetch(uploadUrl, {
            method: 'POST',
            body: formData,
            credentials: 'same-origin'
          });

          let result = {};
          try { result = await response.json(); } catch(e) {}

          if (response.ok && result.filename) {
            let successHtml = `${Ut.escapeHtml(result.filename)} (${Ut.formatBytes(result.file_size || file.size)})`;

            if (result.file_id) {
              const metaLink = `${form.dataset.basePath || ''}/_filemeta?m=show&file_id=${result.file_id}`;
              const editText = t('EditMetadata') || 'edit metadata';
              successHtml += ` <a href="${metaLink}" target="_blank" class="filemeta-link">(${editText})</a>`;
            }

            updateItem(item, successHtml, 100, 'success');

            if (result.new_nonce) {
              currentNonce = result.new_nonce;
              if (nonceInput) nonceInput.value = currentNonce;
            }
          } else {
            updateItem(item, result.error || 'Upload failed', null, 'error');
          }
        } catch (err) {
          updateItem(item, 'Network error', null, 'error');
        }
      };

      const showSummary = (successCount, total, isGlobal) => {
        const summary = document.createElement('div');
        summary.className = 'upload-summary success-box';
        const link = isGlobal ? '_attachments?files=global&order=time&dir=desc' : '_attachments?files=local&order=time&dir=desc';
        summary.innerHTML = `
          <strong>${t('UploadSuccess', successCount, total)}</strong><br>
          <a href="${form.dataset.basePath || ''}/${link}">
            → ${t('ManageAttachments') || 'View and manage attachments'}
          </a>`;
        dropzone.parentNode.appendChild(summary);
      };

      const uploadFiles = async (files) => {
        statusList.innerHTML = '';
        let successCount = 0;
        const isGlobal = form.querySelector('input[name="upload_to"]:checked')?.value === 'global';

        for (const file of files) {
          await uploadFile(file);
          if (statusList.lastElementChild?.querySelector('.upload-success')) successCount++;
        }

        if (successCount > 0) showSummary(successCount, files.length, isGlobal);
      };

      // ==================== EVENT HANDLERS (named for later removal) ====================
      const onDragOver = e => { e.preventDefault(); dropzone.classList.add('dragover'); };
      const onDragLeave = () => dropzone.classList.remove('dragover');
      const onDrop = e => {
        e.preventDefault(); dropzone.classList.remove('dragover');
        if (e.dataTransfer.files.length) uploadFiles(e.dataTransfer.files);
      };

      const onPaste = (e) => {
        const dz = document.querySelector('.upload-dropzone:not(.hidden)');
        if (!dz) return;

        // Optional: ignore if paste happened inside an input/textarea
        if (e.target.closest('input, textarea, [contenteditable]')) return;

        let files = [];
        if (e.clipboardData.items) {
          files = Array.from(e.clipboardData.items)
            .filter(item => item.kind === 'file')
            .map(item => item.getAsFile());
        } else if (e.clipboardData.files) {
          files = Array.from(e.clipboardData.files);
        }

        if (files.length) {
          e.preventDefault();
          uploadFiles(files);
        }
      };

      const selectBtn = dropzone.querySelector('.btn-select-files');
      const onSelectClick = (e) => {
        e.stopImmediatePropagation();
        const input = document.createElement('input');
        input.type = 'file'; input.multiple = true;
        input.onchange = ev => ev.target.files?.length && uploadFiles(ev.target.files);
        input.click();
      };

      const onDropzoneClick = e => {
        if (e.target.closest('.btn-select-files') ||
            e.target.closest('.upload-location') ||
            e.target.closest('input[type="radio"]')) {
          return;
        }
        selectBtn?.click();
      };

      // -----------------------------------------------------------------
      // Attach listeners
      // -----------------------------------------------------------------
      dropzone.addEventListener('dragover', onDragOver);
      dropzone.addEventListener('dragleave', onDragLeave);
      dropzone.addEventListener('drop', onDrop);
      document.addEventListener('paste', onPaste);
      if (selectBtn) selectBtn.addEventListener('click', onSelectClick);
      dropzone.addEventListener('click', onDropzoneClick);

      // -----------------------------------------------------------------
      // RETURN a destroy() that cleanly removes everything
      // -----------------------------------------------------------------
      return function destroyUpload() {
        dropzone.removeEventListener('dragover', onDragOver);
        dropzone.removeEventListener('dragleave', onDragLeave);
        dropzone.removeEventListener('drop', onDrop);
        document.removeEventListener('paste', onPaste);
        if (selectBtn) selectBtn.removeEventListener('click', onSelectClick);
        dropzone.removeEventListener('click', onDropzoneClick);
        // Remove any summary boxes we may have added
        document.querySelectorAll('.upload-summary').forEach(el => el.remove());
      };
    }

    // Initialise *and* keep the destroy function for later (e.g. SPA unmount)
    const destroyUpload = initUploadForForm();

    // Expose on the form element in case the host wants to call it explicitly
    form._destroyUpload = destroyUpload;

    Log.log('Upload.js - loaded');
  });
});
