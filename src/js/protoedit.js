/*!
 * ProtoEdit v3.0 (ES2023+)
 *
 * Licensed BSD © WackoWiki Team
 */

class ProtoEdit {
  // Public properties (set by child classes)
  imagesPath = '';

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
    // Child classes should now use modern ev.ctrlKey / ev.altKey / ev.shiftKey / ev.key
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

      if (btn.name === 'customhtml') {
        const li = document.createElement('li');
        li.innerHTML = btn.desc; // custom HTML (dropdown, separators, etc.)
        ul.append(li);
        continue;
      }

      const li = document.createElement('li');
      li.className = `we-${btn.name}`;

      const button = document.createElement('button');
      button.type = 'button';
      button.className = 'btn-';
      button.title = btn.desc;
      button.setAttribute('aria-label', btn.desc);

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

    this.charsEl.textContent = `${chars} chars`;
    this.wordsEl.textContent = `${words} words`;
    this.cursorEl.textContent = `Ln ${line}, Col ${col}`;
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
