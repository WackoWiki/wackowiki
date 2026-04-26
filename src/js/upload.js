document.addEventListener('DOMContentLoaded', () => {
  const forms = document.querySelectorAll('form[name="upload"]');
  if (!forms.length) return;

  forms.forEach(form => {
    const dropzone      = form.querySelector('.upload-dropzone');
    const statusList    = form.querySelector('.upload-status-list');
    const tabAjax       = document.getElementById('tab-ajax');
    const tabClassic    = document.getElementById('tab-classic');
    const tabs          = form.querySelectorAll('.tab-btn');

    if (!dropzone || !tabAjax || !tabClassic) return;

    const uploadUrl     = form.action;
    const nonceInput    = form.querySelector('input[name="_nonce"]');
    let currentNonce    = nonceInput ? nonceInput.value : '';

    // Tab handling
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

    // Helpers
    const Ut = window.Ut || {};
    Ut.escapeHtml = (str) => str.replace(/[&<>"']/g, m => ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'})[m]);
    Ut.formatBytes = (bytes) => {
      if (!bytes) return '0 B';
      const k = 1024;
      const sizes = ['B','KB','MB','GB'];
      const i = Math.floor(Math.log(bytes) / Math.log(k));
      return parseFloat((bytes / Math.pow(k, i)).toFixed(1)) + ' ' + sizes[i];
    };

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

    const updateItem = (item, text, progress = null, type = '') => {
      const statusEl = item.querySelector('.upload-file-status');
      statusEl.textContent = text;
      if (type) statusEl.className = `upload-file-status upload-${type}`;

      if (progress !== null) {
        const fill = item.querySelector('.upload-progress-fill');
        if (fill) fill.style.width = `${Math.min(100, progress)}%`;
      }
    };

    const showSummary = (successCount, total, isGlobal) => {
      const summary = document.createElement('div');
      summary.className = 'upload-summary success-box';
      const link = isGlobal ? 'attachments?files=global&order=time&dir=desc' : 'attachments?files=local&order=time&dir=desc';
      summary.innerHTML = `
        <strong>${successCount} of ${total} file(s) uploaded successfully.</strong><br>
        <a href="${form.dataset.basePath || ''}${link}">
          → View and manage attachments
        </a>`;
      dropzone.parentNode.appendChild(summary);
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
          const isGlobal = form.querySelector('input[name="upload_to"]:checked')?.value === 'global';
          updateItem(item, `✓ ${result.filename} (${Ut.formatBytes(result.file_size || file.size)})`, 100, 'success');
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

    // ==================== EVENTS ====================
    dropzone.addEventListener('dragover', e => { e.preventDefault(); dropzone.classList.add('dragover'); });
    dropzone.addEventListener('dragleave', () => dropzone.classList.remove('dragover'));
    dropzone.addEventListener('drop', e => {
      e.preventDefault(); dropzone.classList.remove('dragover');
      if (e.dataTransfer.files.length) uploadFiles(e.dataTransfer.files);
    });

    dropzone.addEventListener('paste', e => {
      const files = Array.from(e.clipboardData.items)
        .filter(item => item.kind === 'file')
        .map(item => item.getAsFile());
      if (files.length) uploadFiles(files);
    });

    const selectBtn = dropzone.querySelector('.btn-select-files');
    if (selectBtn) {
      selectBtn.addEventListener('click', (e) => {
        e.stopImmediatePropagation();
        const input = document.createElement('input');
        input.type = 'file'; input.multiple = true;
        input.onchange = ev => ev.target.files?.length && uploadFiles(ev.target.files);
        input.click();
      });
    }

    // FIXED: Do not trigger file dialog when clicking on upload-location radios
    dropzone.addEventListener('click', e => {
      if (e.target.closest('.btn-select-files') ||
          e.target.closest('.upload-location') ||
          e.target.closest('input[type="radio"]')) {
        return;
      }
      selectBtn?.click();
    });

    console.log('Upload.js - Progress bar + radio click fix + dynamic summary link loaded');
  });
});