/*!
 * AutoComplete for WikiEdit (ES6)
 *
 * Licensed BSD © Kuso Mendokusee, WackoWiki Team
 */

class AutoComplete {
  // ─── private fields ──────────────────────────────────────────────
  #debounceTimer = null;
  #abortController = null;

  #containerLi = null;
  #buttonEl    = null;
  #resetLi     = null;
  #dropdownEl  = null;
  #selectedIndex = -1;

  // bound handler references – created once in the constructor so that
  // the *exact same* function objects can be added **and** removed.
  #boundButtonClick       = null;
  #boundResetClick        = null;
  #boundDropdownClick     = null;
  #boundDropdownMouseover = null;

  // ─── constructor ────────────────────────────────────────────────
  constructor(wikiedit, handler) {
    this.wikiedit = wikiedit;
    this.handler  = handler;

    wikiedit.autocomplete = this;

    this.interval = 500;
    this.request_pattern = null;
    this.found_pattern   = null;
    this.found_patterns  = [];
    this.magic_mode      = false;
    this.strict_linking_mode = false;

    this.regexp_LinkLetter   = /[[~\p{Ll}\p{Lu}!\-.(\/\d]/u;
    this.regexp_LinkWhole    = /^(([(\[]){2})?((!\/)|[\p{Lu}\/])[\p{Ll}\p{Lu}\-.\/\d]+$/u;
    this.regexp_LinkCamel    = /[\p{Ll}.\d]\p{Lu}/u;
    this.regexp_LinkStrict   = /^([(\[]){2}.{2,}/;
    this.regexp_LinkSubpage  = /^!\/.{2,}/;

    // create the bound versions once
    this.#boundButtonClick       = this.#onButtonClick.bind(this);
    this.#boundResetClick        = this.#onResetClick.bind(this);
    this.#boundDropdownClick     = this.#handleDropdownClick.bind(this);
    this.#boundDropdownMouseover = this.#handleDropdownMouseover.bind(this);
  }

  // ─── public API ──────────────────────────────────────────────────
  /** Called by WikiEdit after the toolbar has been injected into the DOM */
  attachDropdown() {
    this.#containerLi = document.getElementById(`${this.id}_li`);
    this.#buttonEl    = document.getElementById(this.id);
    this.#resetLi     = document.getElementById(`${this.id}_reset`);
    this.#dropdownEl  = document.getElementById(`${this.id}_dropdown`);

    // Force initial muted state
    if (this.#containerLi) this.#containerLi.style.display = 'none';

    if (this.#buttonEl) {
      this.#buttonEl.addEventListener('click', this.#boundButtonClick);
    }

    if (this.#resetLi) {
      this.#resetLi.addEventListener('click', this.#boundResetClick);
    }
    if (this.#dropdownEl) {
      this.#dropdownEl.addEventListener('click',     this.#boundDropdownClick);
      this.#dropdownEl.addEventListener('mouseover', this.#boundDropdownMouseover);
    }
  }

  /** Complete teardown – called from WikiEdit.destroy() */
  destroy() {
    clearTimeout(this.#debounceTimer);
    this.#debounceTimer = null;

    this.#abortController?.abort();
    this.#abortController = null;

    if (this.#dropdownEl) {
      this.#dropdownEl.removeEventListener('click',     this.#boundDropdownClick);
      this.#dropdownEl.removeEventListener('mouseover', this.#boundDropdownMouseover);
    }
    if (this.#resetLi) {
      this.#resetLi.removeEventListener('click', this.#boundResetClick);
    }
    if (this.#buttonEl) {
      this.#buttonEl.removeEventListener('click', this.#boundButtonClick);
    }

    // drop references to DOM nodes – helps the GC
    this.#containerLi = this.#buttonEl = this.#resetLi = this.#dropdownEl = null;
    this.#selectedIndex = -1;
  }

  // ─── toolbar button markup ───────────────────────────────────────
  addButton() {
    const we = this.wikiedit;
    this.id = `autocomplete_${we.id}`;

    const html = `
      <li id="${this.id}_li" class="we-autocomplete-container" style="display:none;">
        <button id="${this.id}"
                class="we-autocomplete-btn"
                title="${t('AcHelp') || 'Autocomplete (Ctrl+Space)'}"
                aria-label="${t('AcHelp') || 'Trigger autocomplete'}">${t('Autocomplete') || 'Autocomplete'}</button>
        <button id="${this.id}_reset"
                class="we-autocomplete-reset"
                title="${t('AcReset') || 'Reset autocomplete'}"
                aria-label="${t('AcReset') || 'Reset autocomplete'}">×</button>
        <ul id="${this.id}_dropdown"
            class="we-autocomplete-dropdown"
            role="listbox"
            aria-label="${t('AcSuggestions') || 'Autocomplete suggestions'}"></ul>
      </li>`;

    we.addButton('customhtml', html);
  }

  // ─── small helpers ──────────────────────────────────────────────
  reset() {
    this.request_pattern = null;
    this.found_pattern   = null;
    this.found_patterns  = [];
    this.magic_mode      = false;
    this.visualState('hidden');
  }

  // Insert the found suggestion into the textarea
  insertFound() {
    if (!this.request_pattern) return;

    this.visualState('hidden');

    this.wikiedit.area.focus();
    this.wikiedit.getDefines();

    let str = this.wikiedit.str;
    const itempos = this.wikiedit.sel1.lastIndexOf(this.request_pattern);

    if (itempos >= 0) {
      const replacement = this.StrictLink(this.found_pattern ?? this.request_pattern);

      str = this.wikiedit.sel1.slice(0, itempos) +
            replacement +
            this.wikiedit.sel1.slice(itempos + this.request_pattern.length) +
            this.wikiedit.begin + this.wikiedit.sel + this.wikiedit.end +
            this.wikiedit.sel2;
    }

    this.wikiedit.setAreaContent(str);
    this.reset();
  }

  #insertSuggestion(suggestion) {
    this.found_pattern = suggestion;
    this.insertFound();
  }

  #renderDropdown() {
    if (!this.#dropdownEl || this.found_patterns.length === 0) {
      this.#hideDropdown();
      return;
    }

    this.#dropdownEl.innerHTML = '';

    this.found_patterns.forEach((suggestion, index) => {
      const li = document.createElement('li');
      li.className = 'we-autocomplete-dropdown-item';
      li.textContent = suggestion;
      li.setAttribute('role', 'option');
      li.setAttribute('aria-selected', index === this.#selectedIndex);
      if (index === this.#selectedIndex) li.classList.add('selected');
      this.#dropdownEl.appendChild(li);
    });
    this.#dropdownEl.style.display = 'block';
  }

  #hideDropdown() {
    if (this.#dropdownEl) this.#dropdownEl.style.display = 'none';
    this.#selectedIndex = -1;
  }

  // ─── bound event handlers (used for add/remove) ──────────────────
  #onButtonClick() {
    if (this.request_pattern) this.insertFound();
  }

  #onResetClick(e) {
    e.preventDefault();
    this.reset();
  }

  #handleDropdownClick(e) {
    const item = e.target.closest('.we-autocomplete-dropdown-item');
    if (!item) return;
    e.preventDefault();
    e.stopImmediatePropagation();
    this.#insertSuggestion(item.textContent.trim());
  }

  #handleDropdownMouseover(e) {
    const item = e.target.closest('.we-autocomplete-dropdown-item');
    if (!item || !this.#dropdownEl) return;
    const items = Array.from(this.#dropdownEl.children);
    const idx = items.indexOf(item);
    if (idx >= 0 && idx !== this.#selectedIndex) {
      this.#selectedIndex = idx;
      this.#renderDropdown();
    }
  }

  // ─── keyboard handling ───────────────────────────────────────────
  keyDown(e) {
    const key = e.key;
    const shift = e.shiftKey;
    const dropdownVisible = this.#dropdownEl?.style.display === 'block';

    // Arrow / Enter / Escape when a suggestion is active
    if (this.found_pattern !== null) {
      if (dropdownVisible) {
        switch (key) {
          case 'ArrowUp':
            this.#selectedIndex = Math.max(0, this.#selectedIndex - 1);
            this.#renderDropdown(); return true;
          case 'ArrowDown':
            this.#selectedIndex = Math.min(this.found_patterns.length - 1, this.#selectedIndex + 1);
            this.#renderDropdown(); return true;
          case 'Enter':
            if (this.#selectedIndex >= 0) {
              this.#insertSuggestion(this.found_patterns[this.#selectedIndex]);
              return true;
            }
            break;
          case 'Escape':
            this.reset(); return true;
        }
      }

      // Default behavior when no dropdown or no selection
      switch (key) {
        case 'Enter':
          if (shift) { this.reset(); return false; }
          this.insertFound(); return true;
        case 'Escape':
          this.reset(); return true;
        case 'ArrowUp':
        case 'ArrowDown':
          return true;
      }
    }

    // Ctrl+Space → forced autocomplete
    if (!this.found_pattern && key === ' ' && (e.ctrlKey || e.metaKey)) {
      const pat = this.checkPattern(this.getPattern(), true);
      if (pat) { this.request_pattern = pat; this.magic_mode = true; this.tryComplete(true); }
      return true;
    }

    // Normal typing of wiki-link characters (modernised condition)
    const isLinkKey = !!this.request_pattern ||
                      (key.length === 1 && this.regexp_LinkLetter.test(key));
    if (isLinkKey) {
      const pat = this.checkPattern(this.getPattern(), this.magic_mode);
      if (pat) this.request_pattern = pat;
      clearTimeout(this.#debounceTimer);
      this.#debounceTimer = setTimeout(() => this.tryComplete(this.magic_mode), this.interval);
    }

    return false;
  }

  // ─── core autocomplete logic ─────────────────────────────────────
  async tryComplete(magic) {
    if (!this.request_pattern) { this.reset(); return; }
    const pat = this.checkPattern(this.getPattern(), magic);
    if (!pat) { this.reset(); return; }
    this.request_pattern = pat.length > 2 ? pat : null;
    if (!this.request_pattern) { this.reset(); return; }
    this.visualState('seeking');
    await this.requestPattern(this.request_pattern);
  }

  async requestPattern(pattern) {
    // Cancel any previous pending request
    this.#abortController?.abort();
    this.#abortController = new AbortController();
    const sep = this.handler.includes('?') ? '&' : '?';
    const href = `${this.handler}${sep}q=${encodeURIComponent(pattern)}&ta_id=${encodeURIComponent(this.wikiedit.area.id)}&_autocomplete=1&rnd=${Math.random()}`;

    try {
      const resp = await fetch(href, { signal: this.#abortController.signal });
      if (!resp.ok) throw new Error('Network error');
      const txt = await resp.text();
      const raw = txt.split('~~~').map(s => s.trim()).filter(Boolean);
      let best = null, suggestions = [];
      if (raw.length) {
        if (raw[0] === 'postText') { best = raw[1] || null; suggestions = raw.slice(2); }
        else { best = raw[0]; suggestions = raw.slice(1); }
      }
      this.finishComplete(best, suggestions);
    } catch (err) {
      if (err.name === 'AbortError') return;
      Log.warn('Autocomplete request failed:', err);
      this.finishComplete(null, []);
    }
  }

  finishComplete(best, all) {
    this.found_pattern = best || null;
    this.found_patterns = all || [];
    this.visualState(this.found_pattern ? 'found' : '404');
    if (this.found_pattern && this.found_patterns.length) {
      this.#selectedIndex = 0;
      this.#renderDropdown();
    } else this.#hideDropdown();
  }

  checkPattern(pat, magic) {
    this.strict_linking_mode = false;
    if (!this.regexp_LinkWhole.test(pat)) return false;
    if (this.regexp_LinkStrict.test(pat)) { this.strict_linking_mode = true; return pat.slice(2); }
    if (this.regexp_LinkSubpage.test(pat)) { this.strict_linking_mode = true; return pat; }
    if (this.regexp_LinkCamel.test(pat) || magic) return pat;
    return false;
  }

  // Extract the current partial wiki link from the caret position
  getPattern() {
    const ta = this.wikiedit.area;
    let start = ta.selectionStart, end = ta.selectionEnd;
    while (start > 0 && this.regexp_LinkLetter.test(ta.value[start - 1])) start--;
    return ta.value.slice(start, end);
  }

  StrictLink(pat) {
    if (this.strict_linking_mode || this.regexp_LinkCamel.test(pat)) return pat;
    return `((${pat}))`;
  }

  visualState(state) {
    if (!this.#containerLi || !this.#buttonEl) return;
    const li = this.#containerLi, btn = this.#buttonEl, rst = this.#resetLi;
    switch (state) {
      case 'seeking':
        li.style.display = ''; rst.style.display = '';
        btn.innerHTML = '…'; btn.className = 'we-autocomplete-btn seeking';
        this.#hideDropdown(); break;
      case 'found':
        li.style.display = ''; rst.style.display = '';
        btn.innerHTML = this.found_pattern; btn.className = 'we-autocomplete-btn found'; break;
      case '404':
        li.style.display = ''; rst.style.display = '';
        btn.innerHTML = this.request_pattern; btn.className = 'we-autocomplete-btn notfound';
        this.#hideDropdown(); break;
      case 'hidden':
        li.style.display = 'none'; rst.style.display = 'none';
        this.#hideDropdown(); btn.className = 'we-autocomplete-btn'; break;
    }
  }
}
