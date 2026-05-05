/*!
 * WackoWiki Toolbar Customizer - Standalone (for User Settings)
 */

class ToolbarCustomizer {

  static defaultOrder = [
    'h2', 'h3', 'h4', 'h5', 'h6', 'separator',
    'bold', 'italic', 'underline', 'strike', 'small', 'code', 'separator',
    'ul', 'ol', 'separator',
    'center', 'right', 'justify', 'separator',
    'outdent', 'indent', 'separator',
    'quote', 'source', 'action', 'textred', 'highlight', 'separator',
    'hr', 'signature', 'createlink', 'footnote', 'createtable',
    'upload-media', 'separator',
    'wacko2md', 'md2wacko', 'separator',
    'dark-toggle', 'syntax', 'livepreview', 'fullscreen', 'separator',
    'shrink', 'enlarge', 'separator',
    'undo', 'redo', 'separator', 'search', 'about',
    'dropdown'
  ];

  static buttonDefs = {
    'h2': { labelKey: 'Heading2' },
    'h3': { labelKey: 'Heading3' },
    'h4': { labelKey: 'Heading4' },
    'h5': { labelKey: 'Heading5' },
    'h6': { labelKey: 'Heading6' },
    'bold': { labelKey: 'Bold' },
    'italic': { labelKey: 'Italic' },
    'underline': { labelKey: 'Underline' },
    'strike': { labelKey: 'Strikethrough' },
    'small': { labelKey: 'Small' },
    'code': { labelKey: 'Code' },
    'ul': { labelKey: 'List' },
    'ol': { labelKey: 'NumberedList' },
    'center': { labelKey: 'Center' },
    'right': { labelKey: 'Right' },
    'justify': { labelKey: 'Justify' },
    'outdent': { labelKey: 'Outdent' },
    'indent': { labelKey: 'Indent' },
    'quote': { labelKey: 'Quote' },
    'source': { labelKey: 'CodeWrapper' },
    'action': { labelKey: 'Action' },
    'textred': { labelKey: 'MarkedText' },
    'highlight': { labelKey: 'HighlightText' },
    'hr': { labelKey: 'Line' },
    'signature': { labelKey: 'Signature' },
    'createlink': { labelKey: 'Hyperlink' },
    'footnote': { labelKey: 'Footnote' },
    'createtable': { labelKey: 'InsertTable' },
    'upload-media': { labelKey: 'Upload' },
    'wacko2md': { label: 'Wacko → MD' },
    'md2wacko': { label: 'MD → Wacko' },
    'dark-toggle': { labelKey: 'ToggleDark' },
    'syntax': { labelKey: 'SyntaxHighlighting' },
    'livepreview': { labelKey: 'LivePreview' },
    'fullscreen': { labelKey: 'Fullscreen' },
    'shrink': { labelKey: 'HeightShrink' },
    'enlarge': { labelKey: 'HeightEnlarge' },
    'undo': { labelKey: 'Undo' },
    'redo': { labelKey: 'Redo' },
    'search': { labelKey: 'SearchReplace' },
    'about': { labelKey: 'HelpAbout' },
  };

  static open(currentOrderJson = '[]') {
    let currentOrder = [];
    try {
      currentOrder = JSON.parse(currentOrderJson || '[]');
    } catch (e) {}

    if (!currentOrder || currentOrder.length === 0) {
      currentOrder = [...this.defaultOrder];
    }

    const html = `
              <div id="we-toolbar-modal" style="position:fixed;inset:0;background:rgba(0,0,0,0.75);display:flex;align-items:center;justify-content:center;z-index:10000;">
                  <div style="background:var(--ww-bg-secondary);width:680px;max-width:96%;max-height:92vh;border-radius:8px;overflow:hidden;box-shadow:0 10px 40px rgba(0,0,0,0.5);">
                      <div style="padding:16px 20px;var(--ww-bg-accent);border-bottom:1px solid #ddd;">
                          <h3 style="margin:0;">${t('CustomizeToolbar') || 'Customize WikiEdit Toolbar'}</h3>
                          <p style="margin:4px 0 0;var(--ww-text-tertiary);">${t('DragToReorder') || 'Drag to reorder • Uncheck to hide buttons'}</p>
                      </div>
                      <div id="we-modal-content" style="padding:20px;max-height:62vh;overflow:auto;">
                      </div>
                      <div style="padding:12px 20px;background:var(--ww-bg-accent);border-top:1px solid #ddd;text-align:right;">
                          <button type="button" onclick="ToolbarCustomizer.save()" style="background:#007acc;color:white;">${t('SaveChanges') || 'Save Changes'}</button>
                          <button type="button" onclick="ToolbarCustomizer.resetToDefault()" style="margin-left:8px;">${t('ResetToDefault') || 'Reset to Default'}</button>
                          <button type="button" onclick="ToolbarCustomizer.close()" style="margin-left:8px;">${t('Cancel') || 'Cancel'}</button>
                      </div>
                  </div>
              </div>`;

    const wrapper = document.createElement('div');
    wrapper.innerHTML = html;
    const modal = wrapper.firstElementChild;

    document.body.appendChild(modal);
    this.currentModal = modal;

    this.renderList(currentOrder);
  }

  static renderList(currentOrder) {
    const container = this.currentModal.querySelector('#we-modal-content');
    let html = '<div class="we-customizer-list">';

    this.defaultOrder.forEach(id => {
      if (id === 'dropdown') return;
      if (id === 'separator') {
        html += `<div class="we-separator-item" style="margin:12px 0;border-top:1px dashed #ccc;"></div>`;
        return;
      }

      const def = this.buttonDefs[id] || {};
      const label = def.labelKey
        ? (t(def.labelKey) || id)
        : (def.label || id);

      const isChecked = currentOrder.includes(id) ? 'checked' : '';

      html += `
                  <div class="we-customizer-item" draggable="true" data-id="${id}">
                      <label style="display:flex;align-items:center;gap:8px;cursor:grab;">
                          <input type="checkbox" data-id="${id}" ${isChecked}>
                          <span>${label}</span>
                      </label>
                  </div>`;
    });

    html += '</div>';
    container.innerHTML = html;
    this.makeDraggable(container);
  }

  static makeDraggable(container) {
    const items = container.querySelectorAll('.we-customizer-item');
    items.forEach(item => {
      item.addEventListener('dragstart', e => {
        e.dataTransfer.setData('text/plain', item.dataset.id);
        item.classList.add('dragging');
      });
      item.addEventListener('dragend', () => item.classList.remove('dragging'));

      item.addEventListener('dragover', e => {
        e.preventDefault();
        const dragging = container.querySelector('.dragging');
        if (dragging && dragging !== item) {
          const rect = item.getBoundingClientRect();
          if (e.clientY > rect.top + rect.height / 2) item.after(dragging);
          else item.before(dragging);
        }
      });
    });
  }

  static save() {
    const modal = this.currentModal;
    if (!modal) return;

    const checkedIds = Array.from(modal.querySelectorAll('input[type="checkbox"]:checked'))
      .map(el => el.dataset.id);

    const newOrder = this.defaultOrder.filter(id =>
      id === 'separator' || id === 'dropdown' || checkedIds.includes(id)
    );

    const hiddenField = document.getElementById('wikiedit_toolbar_hidden');
    if (hiddenField) {
      hiddenField.value = JSON.stringify(newOrder);
    }

    this.close();

    // Show persistent message (no auto-hide)
    this.showSystemMessage(
      t('ToolbarConfigUpdated') ||
      'Toolbar configuration updated.<br><br>Please click <strong>Save Settings</strong> at the bottom of the page to store it on the server.'
    );
  }

  static resetToDefault() {
    if (!confirm(t('ResetToolbarConfirm') || 'Reset to default toolbar configuration?')) return;

    const hiddenField = document.getElementById('wikiedit_toolbar_hidden');
    if (hiddenField) hiddenField.value = '';

    this.close();

    this.showSystemMessage(
      t('ToolbarResetToDefault') ||
      'Toolbar has been reset to default.<br><br>Please save the settings form to apply the change.'
    );
  }

  /**
   * Show message persistently in #output_messages (no auto-remove)
   */
  static showSystemMessage(text) {
    let output = document.getElementById('output_messages');

    if (!output) {
      output = document.createElement('div');
      output.id = 'output_messages';
      output.style.margin = '15px 0';

      const main = document.querySelector('main') || document.querySelector('article') || document.body;
      if (main) main.insertBefore(output, main.firstChild);
      else document.body.prepend(output);
    }

    const div = document.createElement('div');
    div.className = 'msg hint';
    div.innerHTML = text;
    output.appendChild(div);

    // No auto-remove — message stays until user saves or reloads the page
  }

  static close() {
    if (this.currentModal) {
      this.currentModal.remove();
      this.currentModal = null;
    }
  }
}

// Global access
window.ToolbarCustomizer = ToolbarCustomizer;