/*!
 * ProtoEdit v2.26 (ES2023+)
 *
 * Licensed BSD © WackoWiki Team
 */

class ProtoEdit {
  // Public properties (set by child classes)
  imagesPath = '';
  actionName = '';

  constructor() {
    this.enabled = true;
    this.buttons = [];
  }

  // Initialisation – attaches keyboard handlers to textarea or RTE iframe
  _init(id, rte) {
    this.id = id;
    this.area = document.getElementById(id);
    this.area._owner = this; // back-reference for inline onclick handlers

    const handler = (ev) => this.keyDown(ev);

    if (rte) {
      // Rich Text Editor mode (iframe)
      const frame = document.getElementById(rte)?.contentWindow?.document;
      if (frame) {
        frame.addEventListener('keypress', handler, true);
        frame.addEventListener('keyup', handler, true);
      }
    } else {
      // Normal textarea mode
      this.area.addEventListener('keypress', handler, true);
      this.area.addEventListener('keyup', handler, true);
    }
  }

  enable() {
    this.enabled = true;
  }

  disable() {
    this.enabled = false;
  }

  // Base key handler – overridden by WikiEdit
  keyDown() {
    if (!this.enabled) return;
    return true;
  }

  // Simple inline tag insertion (used by buttons that don't need complex markup)
  insTag(Tag, Tag2) {
    const area = this.area;
    const scrollTop = area.scrollTop;
    const start = area.selectionStart;
    const end = area.selectionEnd;

    const selected = area.value.slice(start, end); // native slice is safe here

    area.setRangeText(`${Tag}${selected}${Tag2}`, start, end, 'select');

    area.scrollTop = scrollTop; // restore scroll
    return true;
  }

  // Build the toolbar HTML from registered buttons
  createToolbar(id) {
    let html = `<ul id="buttons_${id}" class="toolbar">`;

    for (const btn of this.buttons) {
      if (btn.name === ' ') {
        html += ' <li> </li>\n';
      } else if (btn.name === 'customhtml') {
        html += btn.desc;
      } else {
        html += `
          <li class="we-${btn.name}">
            <div id="${btn.name}_${id}"
                 onmouseover="this.className='btn-hover';"
                 onmouseout="this.className='btn-';"
                 class="btn-"
                 onclick="this.className='btn-pressed';${btn.actionName}(${btn.actionParams})">
              <img src="${this.imagesPath}spacer.png"
                   alt="${btn.desc}"
                   title="${btn.desc}">
            </div>
          </li>\n`;
      }
    }

    html += '</ul>\n';
    return html;
  }

  // Register a toolbar button
  addButton(name, desc, actionParams, actionName) {
    if (actionName == null) {
      actionName = this.actionName;
    }

    this.buttons.push({
      name,
      desc,
      actionName,
      actionParams
    });
  }

  // Returns true for keys we want to fully handle ourselves (prevents default browser action)
  checkKey(k) {
    return k === 85 + 4096 || k === 73 + 4096 ||          // Alt+U, Alt+I
           k === 49 + 2048 || k === 50 + 2048 || k === 51 + 2048 ||
           k === 52 + 2048 || k === 53 + 2048 || k === 54 + 2048 || // Ctrl+1..6
           k === 76 + 4096 || k === 76 + 2048 ||                 // Alt+L, Ctrl+L
           k === 78 + 2048 || k === 79 + 2048 ||                 // Ctrl+N, Ctrl+O
           k === 66 + 2048 || k === 83 + 2048 ||                 // Ctrl+B, Ctrl+S
           k === 85 + 2048 || k === 72 + 2048 || k === 73 + 2048 || // Ctrl+U, Ctrl+H, Ctrl+I
           k === 74 + 2048 || k === 84 + 2048 ||                 // Ctrl+J, Ctrl+T
           k === 2109 ||                                         // =
           k === 2124 + 32 || k === 2126 + 32 || k === 2127 + 32 || // Shift+L/N/O
           k === 2114 + 32 || k === 2131 + 32 || k === 2133 + 32 || // Shift+B/S/U
           k === 2121 + 32 || k === 2120 + 32 || k === 2122 + 32;   // Shift+I/H/J
  }

  // Legacy helper (kept for compatibility)
  addEvent(el, evname, func) {
    el.addEventListener(evname, func, true);
  }

  // Trim + remove ALL spaces (used for clean link text in createLink)
  trim(s2) {
    if (typeof s2 !== 'string') return s2;
    return s2.replace(/ /g, ''); // removes every space (leading, trailing, internal)
  }
}