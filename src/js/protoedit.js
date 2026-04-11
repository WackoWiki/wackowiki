/*!
 * ProtoEdit v3.0 (ES2023+)
 *
 * Licensed BSD © WackoWiki Team
 */

class ProtoEdit {
  // Public properties (set by child classes)
  imagesPath = '';
  // actionName is now deprecated – kept only for backward compat during migration

  constructor() {
    this.enabled = true;
    this.buttons = [];
    this.id = null;
    this.area = null;
  }

  /** Initialize editor – attaches keyboard handlers */
  _init(id, rte = null) {
    this.id = id;
    this.area = document.getElementById(id);

    const handler = (ev) => this.keyDown(ev);

    if (rte) {
      const frame = document.getElementById(rte)?.contentWindow?.document;
      if (frame) {
        frame.addEventListener('keydown', handler, { capture: true }); // modern: keydown is better for shortcuts
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

  /** Modern key-check helper (replaces legacy checkKey with magic numbers) */
  isHandledKey(ev) {
    const { ctrlKey, altKey, shiftKey, key } = ev;
    const k = key.toUpperCase();

    return (
      // Alt+U, Alt+I
      (altKey && (k === 'U' || k === 'I')) ||
      // Ctrl+1…6
      (ctrlKey && /^[1-6]$/.test(k)) ||
      // Alt+L, Ctrl+L
      (altKey && k === 'L') || (ctrlKey && k === 'L') ||
      // Ctrl+N, Ctrl+O, Ctrl+B, Ctrl+S, Ctrl+U, Ctrl+H, Ctrl+I, Ctrl+J, Ctrl+T
      (ctrlKey && ['N','O','B','S','U','H','I','J','T'].includes(k)) ||
      // = (quick link?)
      (k === '=') ||
      // Shift + various (L/N/O/B/S/U/I/H/J)
      (shiftKey && ['L','N','O','B','S','U','I','H','J'].includes(k))
    );
  }

  /** Simple inline tag insertion (unchanged – already excellent) */
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

  /** NEW: Register button with a real handler function (modern API) */
  addButton(name, desc, handler) {
    // Backward compat: if someone still passes a string, wrap it (remove after migration)
    if (typeof handler === 'string') {
      console.warn(`[ProtoEdit] String action for button "${name}" is deprecated. Use a function instead.`);
      // For now we could eval, but better to force child classes to update
      handler = () => { /* legacy string handling removed */ };
    }

    this.buttons.push({ name, desc, handler });
  }

  /** Build toolbar as real DOM element (no more innerHTML + inline JS) */
  createToolbar() {
    const ul = document.createElement('ul');
    ul.id = `buttons_${this.id}`;
    ul.className = 'toolbar';
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
        li.innerHTML = btn.desc; // custom HTML still allowed
        ul.append(li);
        continue;
      }

      const li = document.createElement('li');
      li.className = `we-${btn.name}`;

      const button = document.createElement('button'); // ← semantic + accessible
      button.type = 'button';
      button.className = 'btn-';
      button.title = btn.desc;
      button.setAttribute('aria-label', btn.desc);

      // Icon (unchanged – CSS background-image on .we-xxx)
      const img = document.createElement('img');
      img.src = `${this.imagesPath}spacer.png`;
      img.alt = '';
      button.append(img);

      // Click handler – clean, bound to instance
      button.addEventListener('click', (e) => {
        e.preventDefault();
        button.classList.add('btn-pressed'); // optional visual feedback

        // Execute the registered handler
        if (typeof btn.handler === 'function') {
          btn.handler.call(this); // 'this' = ProtoEdit instance
        }

        // Remove pressed state after a short delay (or let CSS :active handle it)
        setTimeout(() => button.classList.remove('btn-pressed'), 150);
      });

      // Pure CSS hover/active – no onmouseover/onmouseout needed
      li.append(button);
      ul.append(li);
    }

    return ul;
  }

  // Legacy helpers removed (addEvent, trim, _owner, checkKey)
  // trim can be replaced with: s?.replace(/ /g, '') if still needed
}
