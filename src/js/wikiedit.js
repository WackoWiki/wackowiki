/*!
 * WikiEdit v3.26 (ES2023+)
 * https://wackowiki.org/doc/Dev/Projects/WikiEdit
 *
 * Licensed BSD © Roman Ivanov, Evgeny Nedelko, WackoWiki Team
 */

class WikiEdit extends ProtoEdit {
  constructor() {
    super();

    this.manual         = 'https://wackowiki.org/doc/';
    this.mark           = '##inspoint##';
    this.begin          = '##startpoint##';
    this.rbegin         = new RegExp(this.begin);
    this.end            = '##endpoint##';
    this.rend           = new RegExp(this.end);
    this.rendb          = new RegExp('^' + this.end);
    this.enabled        = true;
    this.tab            = false;
    this.enterpressed   = false;
    this.buttons        = [];

    // Single-form popups
    this.linkForm       = null;
    this.linkContext    = null;
    this.tableForm      = null;
    this.tableContext   = null;

    // Full undo/redo stack (replaces the old single-level undo)
    this.undoStack      = [];
    this.redoStack      = [];
    this.maxHistory     = 100;
  }

  // Initialisation
  init(id, imgPath) {
    this._init(id);

    this.imagesPath = imgPath || 'image/';
    this.actionName = `document.getElementById('${this.id}')._owner.insTag`;

    // Setup undo/redo – beforeinput fires BEFORE any native change (typing, paste, delete…)
    this.area.addEventListener('beforeinput', this.handleBeforeInput.bind(this));

    const separator = '<li><div class="btn-separator"></div></li>';

    // Toolbar buttons
    this.addButton('h2', lang.Heading2, "'===', '===', 0, 1");
    this.addButton('h3', lang.Heading3, "'====', '====', 0, 1");
    this.addButton('h4', lang.Heading4, "'=====', '=====', 0, 1");
    this.addButton('h5', lang.Heading5, "'======', '======', 0, 1");
    this.addButton('h6', lang.Heading6, "'=======', '=======', 0, 1");
    this.addButton('customhtml', separator);

    this.addButton('bold',       lang.Bold,          "'**', '**'");
    this.addButton('italic',     lang.Italic,        "'//', '//'");
    this.addButton('underline',  lang.Underline,     "'__', '__'");
    this.addButton('strike',     lang.Strikethrough, "'--', '--'");
    this.addButton('small',      lang.Small,         "'++', '++'");
    this.addButton('code',       lang.Code,          "'##', '##'");
    this.addButton('customhtml', separator);

    this.addButton('ul', lang.List,         "'  * ', '', 0, 1, 1");
    this.addButton('ol', lang.NumberedList, "'  1. ', '', 0, 1, 1");
    this.addButton('customhtml', separator);

    this.addButton('center',  lang.Center,  "'%%(wacko wrapper=text wrapper_align=center)', '%%', 2");
    this.addButton('right',   lang.Right,   "'%%(wacko wrapper=text wrapper_align=right)', '%%', 2");
    this.addButton('justify', lang.Justify, "'%%(wacko wrapper=text wrapper_align=justify)', '%%', 2");
    this.addButton('customhtml', separator);

    this.addButton('outdent', lang.Outdent, '', `document.getElementById('${this.id}')._owner.unindent`);
    this.addButton('indent',  lang.Indent,  "'  ', '', 0, 1");
    this.addButton('customhtml', separator);

    this.addButton('quote',   lang.Quote,       "'<[', ']>', 2");
    this.addButton('source',  lang.CodeWrapper, "'%%\\n', '\\n%%', 2");
    this.addButton('action',  lang.Action,      "'{{', '}}', 2");
    this.addButton('textred', lang.MarkedText,  "'!!', '!!', 2");
    this.addButton('highlight', lang.HighlightText, "'??', '??', 2");
    this.addButton('customhtml', separator);

    this.addButton('hr',        lang.Line,       "'', '\\n----\\n', 2");
    this.addButton('signature', lang.Signature,  "'::@::', ' ', 1");
    this.addButton('createlink', lang.Hyperlink, '', `document.getElementById('${this.id}')._owner.createLink`);

    if (this.autocomplete) this.autocomplete.addButton();

    this.addButton('footnote',   lang.Footnote,    "'[[^ ', ']]', 2");
    this.addButton('createtable', lang.InsertTable, '', `document.getElementById('${this.id}')._owner.createTable`);
    this.addButton('customhtml', separator);

    // Help button
    const helpBtn = `<li class="we-help">
      <div id="hilfe_${this.id}"
           onmouseover="this.className='btn-hover';"
           onmouseout="this.className='btn-';"
           class="btn-"
           onclick="this.className='btn-pressed';window.open('${this.manual}${lang.HelpFormattingPage}');"
           title="${lang.HelpFormattingTip}">
        <img src="${this.imagesPath}spacer.png"
             alt="${lang.HelpFormatting}"
             title="${lang.HelpFormattingTip}">
      </div>
    </li>`;
    this.addButton('customhtml', helpBtn);

    this.addButton('about', lang.HelpAbout, '', `document.getElementById('${this.id}')._owner.help`);

    // Build toolbar
    try {
      const toolbar = document.createElement('div');
      toolbar.id = `tb_${this.id}`;
      this.area.parentNode.insertBefore(toolbar, this.area);
      document.getElementById(`tb_${this.id}`).innerHTML = this.createToolbar(1);
    } catch {}
  }

  // ====================== UNDO / REDO STACK ======================

  /**
   * Push current editor state (text + selection + scroll) to the undo stack.
   * Called automatically before every native change via beforeinput and
   * manually before every programmatic change (buttons, forms, list continuation).
   */
  pushState() {
    const t = this.area;
    const state = {
      text: t.value,
      start: t.selectionStart,
      end: t.selectionEnd,
      scroll: t.scrollTop
    };

    // Avoid pushing identical consecutive states
    const last = this.undoStack[this.undoStack.length - 1];
    if (last &&
        last.text === state.text &&
        last.start === state.start &&
        last.end === state.end &&
        last.scroll === state.scroll) {
      return;
    }

    this.undoStack.push(state);
    if (this.undoStack.length > this.maxHistory) {
      this.undoStack.shift();
    }
    this.redoStack = []; // new change clears redo stack
  }

  /**
   * Undo the last change (Ctrl+Z).
   */
  undo() {
    if (this.undoStack.length === 0) return false;

    const t = this.area;
    const current = {
      text: t.value,
      start: t.selectionStart,
      end: t.selectionEnd,
      scroll: t.scrollTop
    };
    this.redoStack.push(current);

    const prev = this.undoStack.pop();
    t.value = prev.text;
    t.setSelectionRange(prev.start, prev.end);
    t.scrollTop = prev.scroll ?? 0;
    t.focus();
    return true;
  }

  /**
   * Redo the last undone change (Ctrl+Shift+Z).
   */
  redo() {
    if (this.redoStack.length === 0) return false;

    const t = this.area;
    const current = {
      text: t.value,
      start: t.selectionStart,
      end: t.selectionEnd,
      scroll: t.scrollTop
    };
    this.undoStack.push(current);

    const next = this.redoStack.pop();
    t.value = next.text;
    t.setSelectionRange(next.start, next.end);
    t.scrollTop = next.scroll ?? 0;
    t.focus();
    return true;
  }

  /**
   * Fires BEFORE any native change (typing, paste, delete, etc.).
   * Pushes the current state so it can be restored on undo.
   */
  handleBeforeInput(e) {
    // Never interfere with the browser’s own history undo/redo
    if (e.inputType === 'historyUndo' || e.inputType === 'historyRedo') {
      return;
    }
    this.pushState();
  }

  // Toggle TAB key interception
  switchTab() {
    this.tab = !this.tab;
  }

  // ====================== INTERNAL HELPERS ======================

  _LSum(Tag, Text, Skip) {
    if (Skip) {
      let q = Text.match(/^([ ]*)([*][*])(.*)$/);
      if (q) return q[1] + Tag + q[2] + q[3];

      q = Text.match(/^([ ]*)(([*]|([1-9]\d*|[\p{Ll}\p{Lu}])([.]|[)]))( |))(.*)$/u);
      if (q) return q[1] + q[2] + Tag + q[7];
    }

    const q = Text.match(/^([ ]*)(.*)$/);
    return q[1] + Tag + q[2];
  }

  _RSum(Text, Tag) {
    const q = Text.match(/^(.*)([ ]*)$/);
    return q[1] + Tag + q[2];
  }

  _TSum(Text, Tag, Tag2, Skip) {
    let q = Text.match(new RegExp('^([ ]*)' + this.begin + '([ ]*)([*][*])(.*)$'));
    if (q) {
      Text = q[1] + this.begin + q[2] + Tag + q[3] + q[4];
    } else {
      q = Text.match(new RegExp('^([ ]*)' + this.begin + '([ ]*)(([*]|([1-9]\d*|[\p{Ll}\p{Lu}])([.]|[)]))( |))(.*)$', 'u'));
      if (Skip && q) {
        Text = q[1] + this.begin + q[2] + q[3] + Tag + q[8];
      } else {
        q = Text.match(new RegExp('^(.*)' + this.begin + '([ ]*)(.*)$'));
        if (q) Text = q[1] + this.begin + q[2] + Tag + q[3];
      }
    }

    // Right-hand tag – simplified native trim of trailing spaces
    q = Text.match(new RegExp('([ ]*)' + this.end + '(.*)$'));
    if (q) {
      const q1 = Text.match(new RegExp('^(.*)' + this.end));
      if (q1) {
        let s = q1[1];
        let ch = s.slice(-1);
        while (ch === ' ') {
          s = s.slice(0, -1);
          ch = s.slice(-1);
        }
        Text = s + Tag2 + q[1] + this.end + q[2];
      }
    }
    return Text;
  }

  MarkUp(Tag, Text, Tag2, onNewLine = 0, expand = 0, strip = 0) {
    let skip = expand === 0 ? 1 : 0;
    let r = '';
    let fIn = false;
    let fOut = false;
    let add = 0;
    let f = false;

    const listRe = /^ {2}( *)(([*]|([1-9]\d*|[\p{Ll}\p{Lu}])([.]|[)]))( |))/u;

    Text = Text.replace(/\r/g, '');
    const lines = Text.split('\n');

    for (let i = 0; i < lines.length; i++) {
      const line = lines[i];

      if (this.rbegin.test(line)) fIn = true;
      if (this.rendb.test(line)) fIn = false;
      if (this.rend.test(line)) fOut = true;
      if (this.rendb.test(lines[i + 1] ?? '')) {
        fOut = true;
        lines[i + 1] = lines[i + 1].replace(this.rend, '');
        lines[i] += this.end;
      }

      if (r) r += '\n';

      // Strip list markers inside selection when requested
      if (fIn && strip === 1) {
        f = this.rbegin.test(line);
        lines[i] = lines[i].replace(this.rbegin, '');
        lines[i] = lines[i].replace(listRe, '$1');
        if (f) lines[i] = this.begin + lines[i];
      }

      // Apply tags only inside the marked selection
      if (fIn && (onNewLine === 0 || (onNewLine === 1 && add === 0) || (onNewLine === 2 && (add === 0 || fOut)))) {
        if (expand === 1) {
          let l = lines[i];
          if (add === 0) l = this._LSum(Tag, l, skip);
          if (fOut) l = this._RSum(l, Tag2);
          if (add !== 0 && onNewLine !== 2) l = this._LSum(Tag, l, skip);
          if (!fOut && onNewLine !== 2) l = this._RSum(l, Tag2);
          r += l;
        } else {
          let l = this._TSum(lines[i], Tag, Tag2, skip);
          if (add !== 0 && onNewLine !== 2) l = this._LSum(Tag, l, skip);
          if (!fOut && onNewLine !== 2) l = this._RSum(l, Tag2);
          r += l;
        }
        add++;
      } else {
        r += lines[i];
      }

      if (fOut) fIn = false;
    }
    return r;
  }

  // ====================== EVENT HANDLING ======================

  keyDown(e) {
    if (!this.enabled) return;

    if (!e) e = window.event;

    const t = this.area;
    let res = false;
    let justenter = false;
    let noscroll = false;

    let Key = e.keyCode || e.key;

    if (e.altKey && !e.ctrlKey) Key += 4096;
    if (e.ctrlKey) Key += 2048;

    // Prevent default for our own hotkeys on keypress
    if (e.type === 'keypress' && this.checkKey?.(Key)) {
      e.preventDefault();
      return false;
    }

    if (e.type === 'keyup' && (Key === 9 || Key === 13)) return false;

    const scroll = t.scrollTop;

    // Take autocomplete first
    if (this.autocomplete?.keyDown(Key, e.shiftKey)) {
      res = true;
      Key = -1;
    }

    switch (Key) {
      case 2138: // Ctrl+Z (Undo) / Ctrl+Shift+Z (Redo)
        const success = e.shiftKey ? this.redo() : this.undo();
        if (success) {
          res = true;
          noscroll = true; // undo/redo already restored scroll – prevent overwrite
        }
        break;

      case 9: // Tab
      case 4181: // Alt+U
      case 4169: // Alt+I
        if (this.tab || Key !== 9) {
          res = e.shiftKey || Key === 4181
            ? this.unindent()
            : this.insTag('  ', '', 0, 1);
        }
        break;

      case 2097: res = this.insTag('==', '==', 0, 1); break;     // 1
      case 2098: res = this.insTag('===', '===', 0, 1); break;   // 2
      case 2099: res = this.insTag('====', '====', 0, 1); break; // 3
      case 2100: res = this.insTag('=====', '=====', 0, 1); break;// 4
      case 2101: res = this.insTag('======', '======', 0, 1); break;// 5

      case 2109: if (this.sel) res = this.insTag('++', '++'); break; // =
      case 2143: res = this.insTag('', '\n----\n', 2); break;        // _
      case 2114: if (this.sel) res = this.insTag('**', '**'); break; // B
      case 2131: if (this.sel) res = this.insTag('--', '--'); break; // S
      case 2133: if (this.sel) res = this.insTag('__', '__'); break; // U
      case 2121: if (this.sel) res = this.insTag('//', '//'); break; // I
      case 2122: if (this.sel) res = this.insTag('!!', '!!', 2); break; // J
      case 2120: if (this.sel) res = this.insTag('??', '??', 2); break; // H

      case 4179: // Alt+S
        try { if (typeof weSave === 'function') weSave(); } catch {}
        break;

      case 2124: // L / Ctrl+Alt+L
      case 4172:
        if (e.shiftKey && e.ctrlKey) {
          res = this.insTag('  * ', '', 0, 1, 1);
        } else if (e.altKey || e.ctrlKey) {
          res = this.createLink(e.altKey);
        }
        break;

      case 2127: // O
      case 2126: // N
        if (e.ctrlKey && e.shiftKey) res = this.insTag('  1. ', '', 0, 1, 1);
        break;

      case 13: // Enter
      case 2061:
      case 4109:
        if (e.ctrlKey) {
          try { if (typeof weSave === 'function') weSave(); } catch {}
        } else if (!e.shiftKey) {
          const text = t.value.replace(/\r/g, '');
          const sel1 = text.slice(0, t.selectionStart);
          const sel2 = text.slice(t.selectionEnd);

          const re = new RegExp('(^|\n)(( +)((([*]|([1-9]\d*|[\p{Ll}\p{Lu}])([.]|[)]))( |))|))(' + (this.enterpressed ? '\\s' : '[^\\r\\n]') + '*)' + '$', 'u');
          const q = sel1.match(re);

          if (q) {
            let prefix = q[2];
            if (!this.enterpressed) {
              if (q[3].length % 2 === 1) {
                prefix = '';
              } else {
                const numRe = /([1-9]\d*)([.]|[)])/;
                const q2 = q[2].match(numRe);
                if (q2) prefix = q[2].replace(numRe, String(Number(q2[1]) + 1) + q2[2]);
              }
            }

            this.pushState(); // ← capture state before list-continuation change
            t.value = sel1 + '\n' + prefix + sel2;
            const newSel = sel1.length + 1 + prefix.length;
            t.setSelectionRange(newSel, newSel);

            // Scroll adjustment
            const lines = text.slice(0, newSel).split('\n').length - 1;
            const total = t.value.split('\n').length - 1;
            if (scroll + t.offsetHeight + 25 > Math.floor((t.scrollHeight / (total + 1)) * lines)) {
              t.scrollTop = Math.floor((t.scrollHeight / (total + 1)) * lines) - t.offsetHeight + 20;
              noscroll = true;
            }
            res = true;
          }
          justenter = true;
        }
        break;
    }

    this.enterpressed = justenter;

    if (res) {
      e.preventDefault();
      if (!noscroll) t.scrollTop = scroll;
      return false;
    }
  }

  // ====================== SELECTION HELPERS ======================

  getDefines() {
    const t = this.area;
    const text = t.value;

    this.ss = t.selectionStart;
    this.se = t.selectionEnd;
    this.sel1 = text.slice(0, this.ss);
    this.sel2 = text.slice(this.se);
    this.sel = text.slice(this.ss, this.se);
    this.str = this.sel1 + this.begin + this.sel + this.end + this.sel2;

    this.scroll = t.scrollTop;
  }

  setAreaContent(str) {
    const t = this.area;

    const beginMatch = str.match(new RegExp('((.|\n)*)' + this.begin));
    const endMatch = str.match(new RegExp(this.begin + '((.|\n)*)' + this.end));

    const l = beginMatch ? beginMatch[1].length : 0;
    const l1 = endMatch ? endMatch[1].length : 0;

    str = str.replace(this.rbegin, '').replace(this.rend, '');
    t.value = str;
    t.setSelectionRange(l, l + l1);
    t.scrollTop = this.scroll;
  }

  // ====================== MODIFICATION METHODS (now push state before change) ======================

  insTag(Tag, Tag2, onNewLine, expand, strip) {
    if (onNewLine == null) onNewLine = 0;
    if (expand == null) expand = 0;
    if (strip == null) strip = 0;

    const t = this.area;
    t.focus();
    this.getDefines();
    this.pushState();               // ← capture state before modification

    const str = this.MarkUp(Tag, this.str, Tag2, onNewLine, expand, strip);
    this.setAreaContent(str);
    return true;
  }

  unindent() {
    const t = this.area;
    t.focus();
    this.getDefines();
    this.pushState();               // ← capture state before modification

    let r = '';
    let fIn = false;
    const lines = this.str.split('\n');

    for (let line of lines) {
      if (this.rbegin.test(line)) {
        fIn = true;
        line = line.replace(new RegExp('^' + this.begin + '([ ]*)'), '$1' + this.begin);
      }
      if (this.rendb.test(line)) fIn = false;

      if (r) r += '\n';

      r += fIn ? line.replace(/^(( {2})|\t)/, '') : line;

      if (this.rend.test(line)) fIn = false;
    }

    this.setAreaContent(r);
    return true;
  }

  createLink(isAlt) {
    const t = this.area;
    t.focus();
    this.getDefines();

    if (!/\n/.test(this.sel)) {
      if (isAlt) {
        this.pushState();           // ← capture state before quick-wrap
        const str = this.sel1 + '((' + this.trim(this.sel) + '))' + this.sel2;
        t.value = str;
        t.setSelectionRange(this.sel1.length, str.length - this.sel2.length);
        return true;
      }

      this.showLinkForm();
      return true;
    }
    return false;
  }

  /**
   * Lazily creates the modal form (single popup) once per editor instance.
   */
  createLinkForm() {
    const modal = document.createElement('div');
    modal.className = 'we-modal';

    const dialog = document.createElement('div');
    dialog.className = 'we-modal-dialog';

    dialog.innerHTML = `
      <div class="we-modal-header">
        <h3 class="we-modal-title">${lang.Hyperlink || 'Hyperlink'}</h3>
      </div>
      <div class="we-modal-body">
        <form id="we-link-form-${this.id}">
          <div class="we-form-group">
            <label class="we-form-label">${(lang.Link || 'Link') + ':'}</label>
            <input type="text" id="we-link-url-${this.id}" class="we-form-input">
          </div>

          <div class="we-form-group">
            <label class="we-form-label">${(lang.TextForLinking || 'Text for linking') + ':'}</label>
            <input type="text" id="we-link-text-${this.id}" class="we-form-input">
          </div>

          <div class="we-modal-footer">
            <button type="submit" id="we-link-insert-${this.id}" class="we-btn we-btn-primary">${lang.Insert || 'Insert'}</button>
            <button type="button" id="we-link-cancel-${this.id}" class="we-btn">${lang.Cancel || 'Cancel'}</button>
          </div>
        </form>
      </div>
    `;

    modal.appendChild(dialog);
    document.body.appendChild(modal);

    // Cache DOM references
    const urlInput   = document.getElementById(`we-link-url-${this.id}`);
    const textInput  = document.getElementById(`we-link-text-${this.id}`);
    const cancelBtn  = document.getElementById(`we-link-cancel-${this.id}`);
    const formEl     = document.getElementById(`we-link-form-${this.id}`);

    this.linkForm = {
      modal: modal,
      urlInput: urlInput,
      textInput: textInput,
      form: formEl
    };

    // Event listeners
    cancelBtn.addEventListener('click', () => {
      this.hideLinkForm();
      this.area.focus();
    });

    formEl.addEventListener('submit', (e) => {
      e.preventDefault();
      this.insertLinkFromForm();
    });
  }

  /**
   * Shows the single link form popup (prefilled with current selection).
   */
  showLinkForm() {
    if (!this.linkForm) this.createLinkForm();

    const f = this.linkForm;
    const defaultValue = this.sel || '';

    f.urlInput.value = defaultValue;
    f.textInput.value = defaultValue;

    // Store context so we can safely insert after the modal closes
    this.linkContext = {
      sel1: this.sel1,
      sel2: this.sel2,
      area: this.area
    };

    f.modal.classList.add('show');
    f.urlInput.focus();
    f.urlInput.select();
  }

  hideLinkForm() {
    if (this.linkForm) {
      this.linkForm.modal.classList.remove('show');
      this.linkContext = null;
    }
  }

  // ====================== TABLE POPUP FORM ======================

  createTable() {
    const t = this.area;
    t.focus();
    this.getDefines();

    this.showTableForm();
    return true;
  }

  createTableForm() {
    const modal = document.createElement('div');
    modal.className = 'we-modal';

    const dialog = document.createElement('div');
    dialog.className = 'we-modal-dialog';

    dialog.innerHTML = `
      <div class="we-modal-header">
        <h3 class="we-modal-title">${lang.InsertTable || 'Insert Table'}</h3>
      </div>
      <div class="we-modal-body">
        <form id="we-table-form-${this.id}">
			<div class="we-form-group">
				<label class="we-form-label">${lang.TableCaption || 'Table caption (optional):'}</label>
				<input type="text" id="we-table-caption-${this.id}" class="we-form-input">
			</div>

          <div class="we-form-grid">
            <div class="we-form-group">
              <label class="we-form-label">${lang.NumberColumns || 'Number of columns:'}</label>
              <input type="number" id="we-table-cols-${this.id}" value="4" min="1" class="we-form-input">
            </div>
            <div class="we-form-group">
              <label class="we-form-label">${lang.NumberRows || 'Number of rows:'}</label>
              <input type="number" id="we-table-rows-${this.id}" value="3" min="1" class="we-form-input">
            </div>
          </div>

          <div class="we-form-checkboxes">
            <label class="we-checkbox-label">
              <input type="checkbox" id="we-table-colheader-${this.id}">
              ${lang.UseColumnHeaders || 'Use column headers'}
            </label>
            <label class="we-checkbox-label">
              <input type="checkbox" id="we-table-rowheader-${this.id}">
              ${lang.UseRowHeaders || 'Use row headers'}
            </label>
          </div>

          <div class="we-modal-footer">
            <button type="submit" id="we-table-insert-${this.id}" class="we-btn we-btn-primary">${lang.InsertTable || 'Insert Table'}</button>
            <button type="button" id="we-table-cancel-${this.id}" class="we-btn">${lang.Cancel || 'Cancel'}</button>
          </div>
        </form>
      </div>
    `;

    modal.appendChild(dialog);
    document.body.appendChild(modal);

    // Cache DOM references
    const colsInput     = document.getElementById(`we-table-cols-${this.id}`);
    const rowsInput     = document.getElementById(`we-table-rows-${this.id}`);
    const captionInput  = document.getElementById(`we-table-caption-${this.id}`);
    const colHeaderCheck = document.getElementById(`we-table-colheader-${this.id}`);
    const rowHeaderCheck = document.getElementById(`we-table-rowheader-${this.id}`);
    const cancelBtn     = document.getElementById(`we-table-cancel-${this.id}`);
    const formEl        = document.getElementById(`we-table-form-${this.id}`);

    this.tableForm = {
      modal: modal,
      colsInput: colsInput,
      rowsInput: rowsInput,
      captionInput: captionInput,
      colHeaderCheck: colHeaderCheck,
      rowHeaderCheck: rowHeaderCheck,
      form: formEl
    };

    cancelBtn.addEventListener('click', () => {
      this.hideTableForm();
      this.area.focus();
    });

    formEl.addEventListener('submit', (e) => {
      e.preventDefault();
      this.insertTableFromForm();
    });
  }

  /**
   * Shows the table configuration popup (defaults: 4 columns, 3 rows, no headers, no caption).
   */
  showTableForm() {
    if (!this.tableForm) this.createTableForm();

    const f = this.tableForm;

    // Reset to sensible defaults
    f.colsInput.value = '4';
    f.rowsInput.value = '3';
    f.captionInput.value = '';
    f.colHeaderCheck.checked = false;
    f.rowHeaderCheck.checked = false;

    // Store current selection context for safe insertion
    this.tableContext = {
      sel1: this.sel1,
      sel2: this.sel2,
      area: this.area
    };

    f.modal.classList.add('show');
    f.colsInput.focus();
    f.colsInput.select();
  }

  hideTableForm() {
    if (this.tableForm) {
      this.tableForm.modal.classList.remove('show');
      this.tableContext = null;
    }
  }

  buildWikiTable(cols, rows, caption, colHeader, rowHeader) {
    cols = Math.max(1, parseInt(cols) || 1);
    rows = Math.max(1, parseInt(rows) || 1);

    const lines = ['#|'];

    // Optional caption
    if (caption && caption.trim()) {
      lines.push(`?| ${caption.trim()} |?`);
    }

    // Column header row (if requested)
    if (colHeader) {
      const headerCells = rowHeader ? [''] : [];
      for (let c = 0; c < cols; c++) {
        headerCells.push(`${lang.Header || 'Header'} ${c+1}`);
      }
      const chRow = '*| ' + headerCells.join(' | ') + ' |*';
      lines.push(chRow);
    }

    // Data rows
    for (let r = 0; r < rows; r++) {
      const rowStart = rowHeader ? '^|' : '||';
      const rowCells = rowHeader ? [`${lang.Header || 'Header'} ${r+1}`] : [];
      for (let c = 0; c < cols; c++) {
        rowCells.push(`${lang.Cell || 'Cell'}`);
      }
      const rowStr = rowStart + ' ' + rowCells.join(' | ') + ' ||';
      lines.push(rowStr);
    }

    lines.push('|#');
    return lines.join('\n');
  }

  /**
   * Called when user clicks "Insert Table" in the form.
   * Builds the wiki table and inserts it at the current cursor/selection.
   */
  insertTableFromForm() {
    if (!this.tableContext) return;

    const { sel1, sel2, area } = this.tableContext;
    const f = this.tableForm;

    const cols = f.colsInput.value;
    const rows = f.rowsInput.value;
    const caption = f.captionInput.value;
    const colHeader = f.colHeaderCheck.checked;
    const rowHeader = f.rowHeaderCheck.checked;

    const tableStr = this.buildWikiTable(cols, rows, caption, colHeader, rowHeader);

    // Insert as a clean block with surrounding newlines
    this.pushState();               // ← capture state before insert
    const insertStr = '\n' + tableStr + '\n';
    const newValue = sel1 + insertStr + sel2;

    area.value = newValue;

    // Place cursor after the inserted table (ready for more editing)
    const cursorPos = sel1.length + insertStr.length;
    area.setSelectionRange(cursorPos, cursorPos);
    area.focus();

    this.hideTableForm();
  }

  insertLinkFromForm() {
    if (!this.linkContext) return;

    const { sel1, sel2, area } = this.linkContext;
    const f = this.linkForm;

    let lnk = f.urlInput.value ?? '';
    let sl  = f.textInput.value ?? '';

    let combined = lnk + ' ' + sl;

    if (!combined.trim()) {
      this.hideLinkForm();
      area.focus();
      return;
    }

    this.pushState();               // ← capture state before insert
    const str = sel1 + '((' + combined + '))' + sel2;

    area.value = str;
    const start = sel1.length;
    const end   = str.length - sel2.length;
    area.setSelectionRange(start, end);
    area.focus();

    this.hideLinkForm();
  }

  help() {
    const s = `WikiEdit 3.26
© Roman Ivanov, WackoWiki Team 2003-2026
https://wackowiki.org/doc/Dev/Projects/WikiEdit

${lang.HelpAboutTip}`;
    alert(s);
  }
}
