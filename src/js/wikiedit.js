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
    this.tab            = false;
    this.enterpressed   = false;

    // Single-form popups
    this.linkForm       = null;
    this.linkContext    = null;
    this.tableForm      = null;
    this.tableContext   = null;

    // Full undo/redo stack
    this.undoStack      = [];
    this.redoStack      = [];
    this.maxHistory     = 100;

    // Autosave (localStorage draft)
    this.draftKey       = null;
    this.autosaveTimer  = null;
    this.autosaveDelay  = 2000; // save 2 seconds after the last change

    // Find/Replace panel
    this.findForm = null;

    // Unified Help modal
    this.helpModal = null;
  }

  // Initialisation
  init(id, imgPath) {
    this._init(id);

    this.imagesPath = imgPath || 'image/';

    // Setup undo/redo
    this.area.addEventListener('beforeinput', this.handleBeforeInput.bind(this));

    const separator = '<div class="btn-separator"></div>';

    // Toolbar buttons
    this.addButton('h2', lang.Heading2, () => this.insTag('===', '===', 0, 1));
    this.addButton('h3', lang.Heading3, () => this.insTag('====', '====', 0, 1));
    this.addButton('h4', lang.Heading4, () => this.insTag('=====', '=====', 0, 1));
    this.addButton('h5', lang.Heading5, () => this.insTag('======', '======', 0, 1));
    this.addButton('h6', lang.Heading6, () => this.insTag('=======', '=======', 0, 1));
    this.addButton('customhtml', separator);

    this.addButton('bold', lang.Bold, () => this.insTag('**', '**'));
    this.addButton('italic', lang.Italic, () => this.insTag('//', '//'));
    this.addButton('underline', lang.Underline, () => this.insTag('__', '__'));
    this.addButton('strike', lang.Strikethrough, () => this.insTag('--', '--'));
    this.addButton('small', lang.Small, () => this.insTag('++', '++'));
    this.addButton('code', lang.Code, () => this.insTag('##', '##'));
    this.addButton('customhtml', separator);

    this.addButton('ul', lang.List, () => this.insTag('  * ', '', 0, 1, 1));
    this.addButton('ol', lang.NumberedList, () => this.insTag('  1. ', '', 0, 1, 1));
    this.addButton('customhtml', separator);

    this.addButton('center', lang.Center, () => this.insBlockWrapper('%%(wacko wrapper=text wrapper_align=center)'));
    this.addButton('right', lang.Right, () => this.insBlockWrapper('%%(wacko wrapper=text wrapper_align=right)'));
    this.addButton('justify', lang.Justify, () => this.insBlockWrapper('%%(wacko wrapper=text wrapper_align=justify)'));
    this.addButton('customhtml', separator);

    this.addButton('outdent', lang.Outdent, () => this.unindent());
    this.addButton('indent', lang.Indent, () => this.insTag('  ', '', 0, 1));
    this.addButton('customhtml', separator);

    this.addButton('quote', lang.Quote, () => this.insTag('<[', ']>', 2));
    this.addButton('source', lang.CodeWrapper, () => this.insBlockWrapper('%%'));
    this.addButton('action', lang.Action, () => this.insTag('{{', '}}', 2));
    this.addButton('textred', lang.MarkedText, () => this.insTag('!!', '!!', 2));
    this.addButton('highlight', lang.HighlightText, () => this.insTag('??', '??', 2));
    this.addButton('customhtml', separator);

    this.addButton('hr', lang.Line, () => this.insTag('', '\n----\n', 2));
    this.addButton('signature', lang.Signature, () => this.insTag('::@::', ' ', 1));
    this.addButton('createlink', lang.Hyperlink, () => this.createLink());

    if (this.autocomplete) this.autocomplete.addButton();

    this.addButton('footnote', lang.Footnote, () => this.insTag('[[^ ', ']]', 2));
    this.addButton('createtable', lang.InsertTable, () => this.createTable());
	this.addButton('customhtml', separator);
	this.addButton('fullscreen', lang.Fullscreen, () => this.toggleFullscreen());

    // Dropdown (custom HTML)
    const dropdownHTML = `<li class="we-dropdown">
      <button type="button" class="btn-" title="${lang.ToolsHelp || 'Tools &amp; Help'}">
        <img src="${this.imagesPath}spacer.png" alt="▼">
      </button>
      <ul class="we-dropdown-menu">
        <li class="we-search">
          <img src="${this.imagesPath}spacer.png" alt="🔎" title="${lang.SearchReplace}" style="margin-right:6px;">
        </li>
        <li class="we-about">
          <img src="${this.imagesPath}spacer.png" alt="?" title="${lang.HelpAbout}" style="margin-right:6px;">
        </li>
      </ul>
    </li>`;

    this.addButton('customhtml', dropdownHTML);

    // Build toolbar
    const toolbarContainer = document.createElement('div');
    toolbarContainer.id = `tb_${this.id}`;
    this.area.parentNode.insertBefore(toolbarContainer, this.area);

    const toolbar = this.createToolbar();           // new ProtoEdit returns real DOM <ul>
    toolbarContainer.appendChild(toolbar);

	toolbarContainer.className = 'we-toolbar-container';

	// ====================== FULLSCREEN BUTTON SETUP (editor-only) ======================
	const fsLi = toolbar.querySelector('li.we-fullscreen');
	if (fsLi) {
	  this.fullscreenBtn = fsLi.querySelector('button');
	  this.fullscreenIcon = this.fullscreenBtn?.querySelector('.we-icon');
	}

	// Update icon when fullscreen state changes (handles Esc key too)
	const updateFSIcon = () => {
	  if (!this.fullscreenIcon) return;
	  const isFullscreen = !!document.fullscreenElement;
	  this.fullscreenIcon.innerHTML = isFullscreen
	    ? this.icons.exitfullscreen
	    : this.icons.fullscreen;
	};

	document.addEventListener('fullscreenchange', updateFSIcon);

	// Initial state
	updateFSIcon();

    // Attach click listeners to dropdown items (no more inline onclick / _owner)
    const dropdown = toolbar.querySelector('.we-dropdown');
    if (dropdown) {
      const searchItem = dropdown.querySelector('.we-search');
      const aboutItem  = dropdown.querySelector('.we-about');
      if (searchItem) searchItem.addEventListener('click', () => this.showFindReplace());
      if (aboutItem)  aboutItem.addEventListener('click', () => this.showHelpModal());
    }
	
	// ====================== STATUS BAR ======================
	const statusBar = this.createStatusBar();
	this.area.parentNode.insertBefore(statusBar, this.area.nextSibling);

	// Initial display
	this.updateStatus();

	// Live updates
	const updateStatusHandler = () => this.updateStatus();
	this.area.addEventListener('input', updateStatusHandler);
	this.area.addEventListener('keyup', updateStatusHandler);
	this.area.addEventListener('click', updateStatusHandler);
	this.area.addEventListener('mouseup', updateStatusHandler);

    if (this.autocomplete) {
      this.autocomplete.attachDropdown();
    }

    // ====================== AUTOSAVE SETUP ======================
    this.setupAutosave();
    this.loadAutosavedDraft();
  }

  // ====================== AUTOSAVE (localStorage draft) ======================

  /**
   * Sets up autosave listeners and prepares the storage key.
   */
  
  setupAutosave() {
	const path = window.location.pathname;
	const section = window.location.search || ''; // e.g., ?section=2
	const uniqueKey = `${this.id}-${path}${section}`;

    this.draftKey = uniqueKey;

    // Save on every user edit (debounced)
    this.area.addEventListener('input', this.debounceAutosave.bind(this));

    // Immediate save when focus is lost
    this.area.addEventListener('blur', () => {
      clearTimeout(this.autosaveTimer);
      this.saveDraft();
    });

    // Final save before the page is closed/reloaded
    window.addEventListener('beforeunload', this.saveDraft.bind(this), { passive: true });
  }

  /**
   * Debounced autosave – fires only after the user stops typing for `autosaveDelay` ms.
   */
  debounceAutosave() {
    clearTimeout(this.autosaveTimer);
    this.autosaveTimer = setTimeout(() => {
      this.saveDraft();
    }, this.autosaveDelay);
  }

  /**
   * Saves the current editor content to localStorage.
   * Empty content is not saved (draft is cleared).
   */
  saveDraft() {
    if (!this.draftKey) return;

    const content = this.area.value;
    if (content.trim() === '') {
      localStorage.removeItem(this.draftKey);
      return;
    }
    localStorage.setItem(this.draftKey, content);

    // === Show draft-saved indicator ===
    this.showMessage(`✓ ${lang.DraftSaved || 'Draft saved'}`);
  }

  /**
   * On editor initialisation: if a draft exists and differs from the loaded content,
   * the user is asked whether to restore it (with undo support).
   */
  loadAutosavedDraft() {
    if (!this.draftKey) return;

    const saved = localStorage.getItem(this.draftKey);
    if (saved !== null && saved !== this.area.value) {
      const msg = lang?.AutosaveRestore
        || 'An autosaved draft from a previous session was found.\n\nRestore it?';

      if (confirm(msg)) {
        this.pushState();                 // allow Ctrl+Z to revert the restore
        this.area.value = saved;
        this.area.setSelectionRange(saved.length, saved.length);
        this.area.focus();

        // === Show restored message + update status ===
        this.showMessage(`✓ ${lang.DraftRestored || 'Draft restored'}`);
        this.updateStatus();
      } else {
        localStorage.removeItem(this.draftKey);
      }
    }
  }

  /**
   * Toggle fullscreen mode ONLY for the editor container (#page-edit).
   * This gives a clean distraction-free editing area while the browser still
   * shows its own chrome (address bar, etc.). Much better for wiki editing.
   */
  toggleFullscreen() {
    const container = document.getElementById('page-edit');
    if (!container) {
      console.warn('WikiEdit: Could not find #page-edit container for fullscreen');
      return;
    }

    if (document.fullscreenElement) {
      // Exit fullscreen (works regardless of which element is fullscreen)
      document.exitFullscreen().catch(err => console.error(err));
    } else {
      // Enter fullscreen on the editor container only
      container.requestFullscreen({ navigationUI: 'hide' }).catch(err => {
        console.error('Editor fullscreen request failed:', err);
      });
    }
  }

  // ====================== UNDO / REDO STACK ======================

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
    if (this.undoStack.length > this.maxHistory) this.undoStack.shift();
    this.redoStack = [];
  }

  /**
   * Undo the last change (Ctrl+Z).
   */
  undo() {
    if (this.undoStack.length === 0) return false;

    const t = this.area;
    const current = { text: t.value, start: t.selectionStart, end: t.selectionEnd, scroll: t.scrollTop };
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

  /**
   * Universal block wrapper for %%...%% style tags.
   * Always produces:
   *   %%(parameters)
   *   content
   *   %%
   * Works for: cursor only, single line, multiple lines.
   */
  insBlockWrapper(openTag, closeTag = '%%') {
    const t = this.area;
    t.focus();
    this.getDefines();
    this.pushState();                    // undo/redo support

    const content = this.sel || '';

    const wrapped = `${openTag}\n${content}\n${closeTag}`;

    const newValue = this.sel1 + wrapped + this.sel2;
    t.value = newValue;

    // Place cursor right after the opening tag (ready to type)
    const cursorPos = this.sel1.length + openTag.length + 1;   // +1 for the newline
    t.setSelectionRange(cursorPos, cursorPos);

    return true;
  }

  // ====================== EVENT HANDLING ======================

  keyDown(e) {
    if (!this.enabled) return true;

    const t = this.area;
    let res = false;
    let justenter = false;
    let noscroll = false;

	// ─────────────────────────────────────────────────────────────
	// 1. Early exit for keyup events
	//    (we only want to run shortcut logic on keydown)
	// ─────────────────────────────────────────────────────────────
	if (e.type === 'keyup') {
	  if (e.key === 'Tab' || e.key === 'Enter') return false;
	    return;                     // skip the rest of the function on keyup
	}

	// From here on we are guaranteed to be in a keydown event
	const scroll = t.scrollTop;

	// Refresh current selection state so "this.sel" checks are accurate
	// (this fixes stale-selection bugs that existed even in the original code)
	this.getDefines();

    if (e.type === 'keyup' && (e.key === 'Tab' || e.key === 'Enter')) return false;

    // Take autocomplete first
    if (this.autocomplete?.keyDown(e)) {
      res = true;
    }

    // ====================== MODERN KEY HANDLING ======================
    const ctrl = e.ctrlKey;
    const alt  = e.altKey;
    const shift = e.shiftKey;
    const key   = e.key.toLowerCase();

    if (ctrl && key === 'z') {
      const success = shift ? this.redo() : this.undo();
      if (success) {
        res = true;
        noscroll = true;
      }
    } else if (ctrl && key === 'f') {
      this.showFindReplace();
      res = true;
    } else if (e.key === 'Tab' || (alt && (key === 'u' || key === 'i'))) {
      if (this.tab || e.key !== 'Tab') {
        res = shift || (alt && key === 'u')
          ? this.unindent()
          : this.insTag(' ', '', 0, 1);
      }
    } else if (ctrl && /^[1-6]$/.test(key)) {
      const level = parseInt(key);
      const tag = '='.repeat(level + 1);
      res = this.insTag(tag, tag, 0, 1);
    } else if (key === '=' && this.sel) {
      res = this.insTag('++', '++');
    } else if (key === '_' && ctrl) {
      res = this.insTag('', '\n----\n', 2);
    } else if (ctrl && this.sel) {
      if (key === 'b') res = this.insTag('**', '**');
      else if (key === 's') res = this.insTag('--', '--');
      else if (key === 'u') res = this.insTag('__', '__');
      else if (key === 'i') res = this.insTag('//', '//');
      else if (key === 'j') res = this.insTag('!!', '!!', 2);
      else if (key === 'h') res = this.insTag('??', '??', 2);
    } else if (alt && key === 's') {
      try { if (typeof weSave === 'function') weSave(); } catch {}
    } else if ((ctrl || alt) && key === 'l') {
      if (shift && ctrl) {
        res = this.insTag(' * ', '', 0, 1, 1);
      } else {
        res = this.createLink(alt);
      }
    } else if (ctrl && shift && (key === 'n' || key === 'o')) {
      res = this.insTag(' 1. ', '', 0, 1, 1);
    } else if (e.key === 'Enter' && !e.shiftKey) {
      // (Enter auto-list logic – unchanged, only the key detection is modernized)
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

        this.pushState();
        t.value = sel1 + '\n' + prefix + sel2;
        const newSel = sel1.length + 1 + prefix.length;
        t.setSelectionRange(newSel, newSel);

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

  // ====================== MODIFICATION METHODS ======================

  insTag(Tag, Tag2, onNewLine, expand, strip) {
    if (onNewLine == null) onNewLine = 0;
    if (expand == null) expand = 0;
    if (strip == null) strip = 0;

    const t = this.area;
    t.focus();
    this.getDefines();
    this.pushState();

    const str = this.MarkUp(Tag, this.str, Tag2, onNewLine, expand, strip);
    this.setAreaContent(str);
    return true;
  }

  unindent() {
    const t = this.area;
    t.focus();
    this.getDefines();
    this.pushState();

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
        this.pushState();
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

  // ====================== LINK & TABLE FORMS ======================

  createLinkForm() {
    const modal = document.createElement('dialog');
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
            <label class="we-form-label" for="we-link-url-${this.id}">${(lang.Link || 'Link') + ':'}</label>
            <input type="text" id="we-link-url-${this.id}" class="we-form-input">
          </div>

          <div class="we-form-group">
            <label class="we-form-label" for="we-link-text-${this.id}">${(lang.TextForLinking || 'Text for linking') + ':'}</label>
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

    this.linkContext = {
      sel1: this.sel1,
      sel2: this.sel2,
      area: this.area
    };

    f.modal.showModal();
    f.urlInput.focus();
    f.urlInput.select();
  }

  hideLinkForm() {
    if (this.linkForm) {
      this.linkForm.modal.close();
      this.linkContext = null;
    }
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

    this.pushState();
    const str = sel1 + '((' + combined + '))' + sel2;

    area.value = str;
    const start = sel1.length;
    const end   = str.length - sel2.length;
    area.setSelectionRange(start, end);
    area.focus();

    this.hideLinkForm();
  }

  createTable() {
    const t = this.area;
    t.focus();
    this.getDefines();

    this.showTableForm();
    return true;
  }

  createTableForm() {
    const modal = document.createElement('dialog');
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
            <label class="we-form-label" for="we-table-caption-${this.id}">${lang.TableCaption || 'Table caption (optional):'}</label>
            <input type="text" id="we-table-caption-${this.id}" class="we-form-input">
          </div>

          <div class="we-form-grid">
            <div class="we-form-group">
              <label class="we-form-label" for="we-table-cols-${this.id}">${lang.NumberColumns || 'Number of columns:'}</label>
              <input type="number" id="we-table-cols-${this.id}" value="4" min="1" class="we-form-input">
            </div>
            <div class="we-form-group">
              <label class="we-form-label" for="we-table-rows-${this.id}">${lang.NumberRows || 'Number of rows:'}</label>
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

    f.colsInput.value = '4';
    f.rowsInput.value = '3';
    f.captionInput.value = '';
    f.colHeaderCheck.checked = false;
    f.rowHeaderCheck.checked = false;

    this.tableContext = {
      sel1: this.sel1,
      sel2: this.sel2,
      area: this.area
    };

    f.modal.showModal();
    f.colsInput.focus();
    f.colsInput.select();
  }

  hideTableForm() {
    if (this.tableForm) {
      this.tableForm.modal.close();
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
    this.pushState();
    const insertStr = '\n' + tableStr + '\n';
    const newValue = sel1 + insertStr + sel2;

    area.value = newValue;

    // Place cursor after the inserted table (ready for more editing)
    const cursorPos = sel1.length + insertStr.length;
    area.setSelectionRange(cursorPos, cursorPos);
    area.focus();

    this.hideTableForm();
  }

  // ====================== HELP MODAL ======================

  createHelpModal() {
    const modal = document.createElement('dialog');
    modal.className = 'we-modal';

    const dialog = document.createElement('div');
    dialog.className = 'we-modal-dialog';

    dialog.innerHTML = `
      <div class="we-modal-header">
        <h3 class="we-modal-title">WikiEdit</h3>
      </div>
      <div class="we-modal-body">
        <a href="${this.manual}${lang.HelpFormattingPage || 'Formatting'}" target="_blank">${lang.HelpFormattingTip}</a><br>
        <a href="${this.manual}" target="_blank">Full Documentation</a><br>
        <a href="https://wackowiki.org/doc/Dev/Projects/WikiEdit" target="_blank">Project Page</a>
        <hr style="margin:15px 0;border:none;border-top:1px solid #ddd;">
        <pre style="white-space:pre-wrap;font-size:0.95em;line-height:1.4;">${lang.HelpAboutTip || ''}</pre>
      </div>
      <div class="we-modal-footer">
        <button type="button" class="we-btn">Close</button>
      </div>
    `;

    modal.appendChild(dialog);
    document.body.appendChild(modal);

    this.helpModal = { modal };

    const closeBtn = dialog.querySelector('button');
    if (closeBtn) {
      closeBtn.addEventListener('click', () => this.hideHelpModal());
    }
  }

  showHelpModal() {
    if (!this.helpModal) this.createHelpModal();
    this.helpModal.modal.showModal();   // ← native
  }

  hideHelpModal() {
    if (this.helpModal) this.helpModal.modal.close();   // ← native
  }

  // ====================== FIND / REPLACE FEATURE ======================

  showFindReplace() {
    if (!this.findForm) this.createFindReplaceForm();

    const f = this.findForm;
    this.getDefines();

    // Prefill with currently selected text (if any)
    f.findInput.value = this.sel || '';

    f.replaceInput.value = '';
    f.modal.classList.add('show');

    // Focus the find field
    f.findInput.focus();
    f.findInput.select();
  }

  hideFindReplace() {
    if (this.findForm) {
      this.findForm.modal.classList.remove('show');
    }
  }

  createFindReplaceForm() {
    const panel = document.createElement('div');
    panel.className = 'we-find-panel';

    panel.innerHTML = `
      <div class="we-panel-header">
        <h3 class="we-panel-title">${lang.SearchReplace || 'Search and Replace'}</h3>
        <button type="button" id="we-find-close-${this.id}" class="we-panel-close">✕</button>
      </div>
      <div class="we-panel-body">
        <div class="we-form-group">
          <label class="we-form-label" for="we-search-for-${this.id}">${lang.SearchFor || 'Search for:'}</label>
          <input type="text" id="we-search-for-${this.id}" class="we-form-input">
        </div>

        <div class="we-form-group">
          <label class="we-form-label" for="we-replace-with-${this.id}">${lang.ReplaceWith || 'Replace with:'}</label>
          <input type="text" id="we-replace-with-${this.id}" class="we-form-input">
        </div>

        <div class="we-form-options">
          <label class="we-checkbox-label">
            <input type="checkbox" id="we-find-case-${this.id}" checked>
            ${lang.MatchCase || 'Match case'}
          </label>
          <label class="we-checkbox-label">
            <input type="checkbox" id="we-find-whole-${this.id}">
            ${lang.WholeWords || 'Whole words only'}
          </label>
          <label class="we-checkbox-label">
            <input type="checkbox" id="we-find-regex-${this.id}">
            ${lang.UseRegex || 'Regular expression'}
          </label>
        </div>

        <div class="we-panel-actions">
          <button type="button" id="we-find-next-${this.id}" class="we-btn we-btn-primary">${lang.FindNext || 'Find Next'}</button>
          <button type="button" id="we-replace-btn-${this.id}" class="we-btn">${lang.Replace || 'Replace'}</button>
          <button type="button" id="we-replace-all-${this.id}" class="we-btn">${lang.ReplaceAll || 'Replace All'}</button>
        </div>
      </div>
    `;

    document.body.appendChild(panel);

    this.findForm = {
      modal: panel, // reused name for consistency
      findInput: document.getElementById(`we-search-for-${this.id}`),
      replaceInput: document.getElementById(`we-replace-with-${this.id}`),
      matchCaseCheck: document.getElementById(`we-find-case-${this.id}`),
      wholeWordCheck: document.getElementById(`we-find-whole-${this.id}`),
      regexCheck: document.getElementById(`we-find-regex-${this.id}`),
      btnNext: document.getElementById(`we-find-next-${this.id}`),
      btnReplace: document.getElementById(`we-replace-btn-${this.id}`),
      btnReplaceAll: document.getElementById(`we-replace-all-${this.id}`),
      btnClose: document.getElementById(`we-find-close-${this.id}`)
    };

    // Event listeners
    this.findForm.btnNext.addEventListener('click', () => this.findNext());
    this.findForm.btnReplace.addEventListener('click', () => this.replaceCurrent());
    this.findForm.btnReplaceAll.addEventListener('click', () => this.replaceAll());
    this.findForm.btnClose.addEventListener('click', () => this.hideFindReplace());

    // Enter in find field = Find Next
    this.findForm.findInput.addEventListener('keydown', (e) => {
      if (e.key === 'Enter') {
        e.preventDefault();
        this.findNext();
      }
    });
  }

  /**
   * Scroll the textarea so the current selection is clearly visible.
   * Called after every successful find or replace.
   */
  scrollToSelection() {
    const t = this.area;
    if (!t) return;

    t.focus();

    // Force browser to scroll the caret into view (very reliable in modern browsers)
    const start = t.selectionStart;
    t.selectionStart = start;   // re-setting triggers scroll
    t.selectionEnd = t.selectionEnd;

    // Additional safety: approximate scroll position to center the match
    const textBefore = t.value.substring(0, start);
    const lineCount = (textBefore.match(/\n/g) || []).length + 1;

    const lineHeight = parseInt(getComputedStyle(t).lineHeight) || 20;
    const targetScroll = Math.max(0, lineCount * lineHeight - t.clientHeight * 0.4);

    t.scrollTop = targetScroll;
  }

  findNext() {
    const t = this.area;
    const f = this.findForm;
    if (!f || !f.findInput.value) return;

    const term = f.findInput.value;
    const matchCase = f.matchCaseCheck.checked;
    const wholeWord = f.wholeWordCheck.checked;
    const useRegex = f.regexCheck.checked;
    const text = t.value;

    let re;

    if (useRegex) {
      try {
        const flags = matchCase ? 'g' : 'gi';
        re = new RegExp(term, flags);
      } catch (err) {
        alert(lang?.InvalidRegex || 'Invalid regular expression.');
        return;
      }
    } else {
      let escaped = term.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
      const pattern = wholeWord ? '\\b' + escaped + '\\b' : escaped;
      const flags = matchCase ? 'g' : 'gi';
      re = new RegExp(pattern, flags);
    }

    let pos = t.selectionEnd;
    re.lastIndex = pos;

    let match = re.exec(text);

    if (!match) {
      re.lastIndex = 0;
      match = re.exec(text);
    }

    if (match) {
      t.setSelectionRange(match.index, match.index + match[0].length);
      this.scrollToSelection();   // ← guaranteed visible
    }
  }

  replaceCurrent() {
    const t = this.area;
    const f = this.findForm;
    if (!f || !f.findInput.value) return;

    if (t.selectionStart === t.selectionEnd) {
      this.findNext();
      return;
    }

    this.pushState(); // capture state before any change

    const term = f.findInput.value;
    const matchCase = f.matchCaseCheck.checked;
    const useRegex = f.regexCheck.checked;
    const selected = t.value.substring(t.selectionStart, t.selectionEnd);

    let matches = false;

    if (useRegex) {
      try {
        const flags = matchCase ? '' : 'i';
        const re = new RegExp('^' + term + '$', flags);
        matches = re.test(selected);
      } catch (e) {
        this.findNext();
        return;
      }
    } else {
      matches = matchCase
        ? selected === term
        : selected.toLowerCase() === term.toLowerCase();
    }

    if (!matches) {
      this.findNext();
      return;
    }

    const replacement = f.replaceInput.value ?? '';
    const before = t.value.substring(0, t.selectionStart);
    const after = t.value.substring(t.selectionEnd);

    t.value = before + replacement + after;
    const newPos = before.length + replacement.length;
    t.setSelectionRange(newPos, newPos);

    this.scrollToSelection();   // ← new text is visible
    this.findNext();
  }

  replaceAll() {
    const t = this.area;
    const f = this.findForm;
    if (!f || !f.findInput.value) return;

    this.pushState(); // capture state before bulk replace

    const term = f.findInput.value;
    const matchCase = f.matchCaseCheck.checked;
    const wholeWord = f.wholeWordCheck.checked;
    const useRegex = f.regexCheck.checked;
    const replacement = f.replaceInput.value ?? '';

    let re;

    if (useRegex) {
      try {
        const flags = matchCase ? 'g' : 'gi';
        re = new RegExp(term, flags);
      } catch (err) {
        alert(lang?.InvalidRegex || 'Invalid regular expression.');
        return;
      }
    } else {
      let escaped = term.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
      const pattern = wholeWord ? '\\b' + escaped + '\\b' : escaped;
      const flags = matchCase ? 'g' : 'gi';
      re = new RegExp(pattern, flags);
    }

    const newText = t.value.replace(re, replacement);

    if (newText !== t.value) {
      t.value = newText;
      t.setSelectionRange(0, 0);
      t.focus();
    }
  }

}
