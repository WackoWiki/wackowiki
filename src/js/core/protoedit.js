/*!
 * ProtoEdit v3.0 (ES2023+)
 *
 * Licensed BSD © WackoWiki Team
 */

export class ProtoEdit {
  // Public properties (set by child classes)
  imagesPath = '';
  buttons = [];
  id = null;
  area = null;

  // Button registry for plugins (future-proof)
  static buttonRegistry = new Map();

  static registerButton(id, definition) {
    ProtoEdit.buttonRegistry.set(id, definition);
  }

  constructor() {
    this.enabled = true;
    this.buttons = [];
    this.id = null;
    this.area = null;

    this.statusBar = null;
    this.charsEl = null;
    this.wordsEl = null;
    this.cursorEl = null;
    this.messageEl = null;
    this.messageTimer = null;
  }

  /** Initialize editor – attaches keyboard handlers */
  _init(id, rte = null) {
    this.id = id;
    this.area = document.getElementById(id);
    if (!this.area) return;

    const handler = (ev) => this.keyDown(ev);

    if (rte) {
      const frame = document.getElementById(rte)?.contentWindow?.document;
      if (frame) {
        frame.addEventListener('keydown', handler, { capture: true });
        frame.addEventListener('keyup', handler, { capture: true });
      }
    } else {
      this.area.addEventListener('keydown', handler, { capture: true });
      this.area.addEventListener('keyup', handler, { capture: true });
    }
  }

  enable() { this.enabled = true; }
  disable() { this.enabled = false; }

  /** Base key handler – overridden by WikiEdit */
  keyDown(ev) {
    if (!this.enabled) return true;
    return true;
  }

  /** Simple inline tag insertion */
  insTag(open, close, newLine = 0, expand = 0) {
    const area = this.area;
    if (!area) return false;

    const scrollTop = area.scrollTop;
    let start = area.selectionStart;
    let end = area.selectionEnd;

    let selected = area.value.slice(start, end);

    // Optional new-line / expand logic can be kept from your WikiEdit override
    if (newLine) {
      // … (your existing logic here)
    }

    area.setRangeText(`${open}${selected}${close}`, start, end, 'select');
    area.scrollTop = scrollTop;
    return true;
  }

  /** Register button with a real handler function (modern API) */
  addButton(name, desc, handler) {
    this.buttons.push({ name, desc, handler });
  }

  // ==================== ABSTRACT TOOLBAR BUILDING ====================
  buildToolbar(configArray) {
    this.buttons = [];

    for (let id of configArray) {
      if (id === 'separator') {
        this.addButton('customhtml', '<li class="btn-separator"></li>');
        continue;
      }

      if (id === 'dropdown') {
        this.addButton('customhtml', this.getDropdownHTML());
        continue;
      }

      let def = (typeof WikiEdit !== 'undefined' && WikiEdit.buttonDefs?.[id]) ||
                ProtoEdit.buttonRegistry.get(id);

      if (!def) continue;

      // Bind condition to instance
	  if (def.condition) {
	    if (typeof def.condition === 'function' && !def.condition.call(this)) continue;
	    if (typeof def.condition === 'string' && !this[def.condition]) continue;
	  }

      const label = def.labelKey ? (t(def.labelKey) || id) : (def.label || id);

      // Create handler bound to instance, using method/args if defined
      const handler = def.method 
        ? () => this[def.method](...(def.args || []))
        : typeof def.handler === 'function' 
          ? def.handler.bind(this) 
          : null;

      this.addButton(id, label, handler);
    }

    // Rebuild DOM
    const oldContainer = document.getElementById(`tb_${this.id}`);
    if (oldContainer) {
      // Reuse existing container instead of removing + recreating
      const oldUl = oldContainer.querySelector('.we-toolbar');
      if (oldUl) oldUl.remove();
    } else {
      const container = document.createElement('div');
      container.id = `tb_${this.id}`;
      container.className = 'we-toolbar-container';
      if (this.area && this.area.parentNode) {
        this.area.parentNode.insertBefore(container, this.area);
      }
    }

    this.toolbar = this.createToolbar();
    const currentContainer = document.getElementById(`tb_${this.id}`);
    if (currentContainer) {
      currentContainer.appendChild(this.toolbar);
    }

    // Re-attach any special button references after rebuild
    this.attachSpecialButtons();
  }

  attachSpecialButtons() {
    // This can be overridden or extended in WikiEdit
    // For now it's empty — WikiEdit will override it
  }

  getDropdownHTML() {
    return ''; /*`<li class="we-dropdown">
       <button type="button" class="btn-" title="${t('ToolsHelp') || 'Tools'}">▼</button>
       <ul class="we-dropdown-menu">
          <li class="we-about">
	              <a href="${this.manual || 'https://wackowiki.org/doc/'}" target="_blank">ℹ️ ${t('About') || 'About WikiEdit'}</a>
         </li>
		 <!-- Add any other permanent dropdown items here -->
       </ul>
     </li>`;*/
  }

  /** Build toolbar as real DOM element */
  createToolbar() {
    const ul = document.createElement('ul');
    ul.id = `buttons_${this.id}`;
    ul.className = 'we-toolbar';
    ul.setAttribute('role', 'toolbar');
    ul.setAttribute('aria-label', 'Editor toolbar');

    for (const btn of this.buttons) {
      if (btn.name === ' ') {
        const spacer = document.createElement('li');
        spacer.innerHTML = ' ';
        ul.append(spacer);
        continue;
      }
      //Log.success(`createToolbar item: ${btn.name}`);
      if (btn.name === 'customhtml') {
        const temp = document.createElement('div');
        temp.innerHTML = btn.desc.trim();

        // Move every top-level node from the temp container into the toolbar <ul>
        while (temp.firstChild) {
          ul.appendChild(temp.firstChild);
        }
        continue;
      }

      const li = document.createElement('li');
      li.className = `we-${btn.name}`;
      li.dataset.action = btn.name;

      const button = document.createElement('button');
      button.type = 'button';
      button.className = 'btn-';
      button.title = btn.desc;
      button.setAttribute('aria-label', btn.desc);

      if (btn.name) {
        button.id = 'tb_' + btn.name;           // consistent ID pattern: tb_zenmode
      }

      // Icon (CSS background-image)
      const img = document.createElement('img');
      img.src = `${this.imagesPath}spacer.png`;
      img.alt = '';
      button.append(img);

      // Click handler
      button.addEventListener('click', (e) => {
        e.preventDefault();
        button.classList.add('btn-pressed');

        if (typeof btn.handler === 'function') {
          btn.handler.call(this);
        }

        setTimeout(() => button.classList.remove('btn-pressed'), 150);
      });

      li.append(button);
      ul.append(li);
    }

    return ul;
  }

  /** Create status bar below the textarea */
  createStatusBar() {
    const bar = document.createElement('div');
    bar.className = 'we-statusbar';

    // Stats (left side)
    const stats = document.createElement('div');
    stats.style.cssText = 'display:flex; align-items:center; gap:12px;';

    this.charsEl = document.createElement('span');
    this.charsEl.className = 'we-chars';
    this.wordsEl = document.createElement('span');
    this.wordsEl.className = 'we-words';
    this.cursorEl = document.createElement('span');
    this.cursorEl.className = 'we-cursor';

    stats.append(
      this.charsEl,
      document.createTextNode(' • '),
      this.wordsEl,
      document.createTextNode(' • '),
      this.cursorEl
    );

    bar.append(stats);

    // Message area (right side – Draft saved)
    this.messageEl = document.createElement('span');
    this.messageEl.className = 'we-message';
    bar.append(this.messageEl);

    this.statusBar = bar;
    return bar;
  }

  /** Update character/word counts and cursor position */
  updateStatus() {
    if (!this.area || !this.statusBar) return;

    const text = this.area.value;
    const chars = text.length;
    const words = text.trim() === '' ? 0 : text.trim().split(/\s+/).length;

    // Cursor position (line/column based on selectionStart)
    let line = 1;
    let col = 1;
    const pos = this.area.selectionStart ?? 0;
    const before = text.substring(0, pos);
    const lines = before.split('\n');
    line = lines.length;
    col = lines[lines.length - 1].length + 1;

    this.charsEl.textContent = `${chars} ${t('Chars') || 'chars'}`;
    this.wordsEl.textContent = `${words} ${t('Words') || 'words'}`;
    this.cursorEl.textContent = `${line}:${col}`;
  }

  /** Show temporary status message (e.g. “✓ Draft saved”) */
  showMessage(text, timeout = 3000) {
    if (!this.messageEl) return;
    this.messageEl.textContent = text;
    this.messageEl.style.cssText = 'color:#28a745;font-weight:500;opacity:1;transition:opacity .3s;';

    clearTimeout(this.messageTimer);
    this.messageTimer = setTimeout(() => {
      this.messageEl.style.opacity = '0';
      setTimeout(() => {
        if (this.messageEl.textContent === text) this.messageEl.textContent = '';
      }, 300);
    }, timeout);
  }
}
