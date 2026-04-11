/*!
 * AutoComplete for WikiEdit (ES6)
 *
 * Licensed BSD © Kuso Mendokusee, WackoWiki Team
 */

class AutoComplete {
    // Private fields
    #debounceTimer = null;
    #abortController = null;
    #containerLi = null;
    #buttonEl = null;
    #resetLi = null;
    #dropdownEl = null;
    #selectedIndex = -1;

    constructor(wikiedit, handler) {
        this.wikiedit = wikiedit;
        this.handler = handler;

        wikiedit.autocomplete = this;

        this.interval = 500;
        this.request_pattern = null;
        this.found_pattern = null;
        this.found_patterns = [];
        this.magic_mode = false;
        this.strict_linking_mode = false;

        this.regexp_LinkLetter = /[[~\p{Ll}\p{Lu}!\-.(\/\d]/u;
        this.regexp_LinkWhole = /^(([(\[]){2})?((!\/)|[\p{Lu}\/])[\p{Ll}\p{Lu}\-.\/\d]+$/u;
        this.regexp_LinkCamel = /[\p{Ll}.\d]\p{Lu}/u;
        this.regexp_LinkStrict = /^([(\[]){2}.{2,}/;
        this.regexp_LinkSubpage = /^!\/.{2,}/;
    }

    // ─────────────────────────────────────────────────────────────
    // Toolbar + floating dropdown
    // ─────────────────────────────────────────────────────────────
    addButton() {
        const we = this.wikiedit;
        this.id = `autocomplete_${we.id}`;

        const html = `
            <li id="${this.id}_li" style="position:relative; display:none;">
                <div id="${this.id}"
                     class="we-autocomplete-btn"
                     onclick="document.getElementById('${we.id}')._owner.autocomplete.insertFound(); return false;"
                     title="Insert best match">
                    Autocomplete
                </div>
                <ul id="${this.id}_dropdown" class="we-autocomplete-dropdown" style="display:none;"></ul>
            </li>
            <li id="${this.id}_reset" style="display:none;">
                <div class="we-autocomplete-reset-btn"
                     onclick="document.getElementById('${we.id}')._owner.autocomplete.reset(); return false;"
                     title="Hide Autocomplete">&times;</div>
            </li>`;

        we.addButton('customhtml', html);
        // DO NOT capture DOM here anymore – toolbar not built yet
    }

    /** Called by WikiEdit AFTER toolbar is inserted into DOM */
    attachDropdown() {
        this.#containerLi = document.getElementById(`${this.id}_li`);
        this.#buttonEl = document.getElementById(this.id);
        this.#resetLi = document.getElementById(`${this.id}_reset`);
        this.#dropdownEl = document.getElementById(`${this.id}_dropdown`);
    }

    // ─────────────────────────────────────────────────────────────
    // Helpers
    // ─────────────────────────────────────────────────────────────
    reset() {
        this.request_pattern = null;
        this.found_pattern = null;
        this.found_patterns = [];
        this.magic_mode = false;
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

    // ─────────────────────────────────────────────────────────────
    // Dropdown
    // ─────────────────────────────────────────────────────────────

    insertSuggestion(suggestion) {
        this.#insertSuggestion(suggestion);
    }

    #renderDropdown() {
        if (!this.#dropdownEl || this.found_patterns.length === 0) {
            this.#hideDropdown();
            return;
        }

        this.#dropdownEl.innerHTML = '';

        this.found_patterns.forEach((suggestion, index) => {
            const liEl = document.createElement('li');
            liEl.className = 'we-autocomplete-dropdown-item';
            liEl.textContent = suggestion;

            if (index === this.#selectedIndex) {
                liEl.classList.add('selected');
            }

            // Hover for keyboard navigation
            liEl.addEventListener('mouseover', () => {
                this.#selectedIndex = index;
                this.#renderDropdown();
            });

            // Modern click handler (backup)
            liEl.addEventListener('click', (e) => {
                e.preventDefault();
                e.stopImmediatePropagation();
                e.stopPropagation();
                this.insertSuggestion(suggestion);
            });

            // INLINE ONCLICK
            const safeSuggestion = suggestion.replace(/'/g, "\\'");
            const onclickStr = "document.getElementById('" + this.wikiedit.id + "')._owner.autocomplete.insertSuggestion('" + safeSuggestion + "'); return false;";
            liEl.setAttribute('onclick', onclickStr);

            this.#dropdownEl.appendChild(liEl);
        });

        this.#dropdownEl.style.display = 'block';
    }

    #hideDropdown() {
        if (this.#dropdownEl) {
            this.#dropdownEl.style.display = 'none';
        }
        this.#selectedIndex = -1;
    }

    #insertSuggestion(suggestion) {
        this.found_pattern = suggestion;
        this.insertFound(); // reuses existing logic + resets everything
    }

    // ─────────────────────────────────────────────────────────────
    // Key handler
    // ─────────────────────────────────────────────────────────────
    keyDown(e) {
        const key = e.keyCode;
        const shiftKey = e.shiftKey;
        const isDropdownVisible = this.#dropdownEl && this.#dropdownEl.style.display === 'block';

        // Arrow / Enter / Escape when a suggestion is active
        if (this.found_pattern !== null) {
            if (isDropdownVisible) {
                switch (key) {
                    case 38: // Up
                        this.#selectedIndex = Math.max(0, this.#selectedIndex - 1);
                        this.#renderDropdown();
                        return true;
                    case 40: // Down
                        this.#selectedIndex = Math.min(this.found_patterns.length - 1, this.#selectedIndex + 1);
                        this.#renderDropdown();
                        return true;
                    case 13: // Enter
                        if (this.#selectedIndex >= 0) {
                            this.#insertSuggestion(this.found_patterns[this.#selectedIndex]);
                            return true;
                        }
                        break; // fall through to default Enter behavior if nothing selected
                    case 27: // Escape
                        this.reset();
                        return true;
                }
            }

            // Default behavior when no dropdown or no selection in dropdown
            switch (key) {
                case 13: // Enter on best-match button
                    if (shiftKey) {
                        this.reset();
                        return false;
                    }
                    this.insertFound();
                    return true;
                case 27: // Escape
                    this.reset();
                    return true;
                case 38: // Up
                case 40: // Down
                    // No floating list anymore → just ignore arrows (or you could re-add a simple dropdown if needed)
                    return true;
            }
        }

        // Ctrl+Space = magic mode (force autocomplete)
        if (!this.found_pattern && key === 32 && (e.ctrlKey || e.metaKey)) {
            const pattern = this.checkPattern(this.getPattern(), true);
            if (pattern) {
                this.request_pattern = pattern;
                this.magic_mode = true;
                this.tryComplete(true);
            }
            return true;
        }

        // Normal typing of wiki-link characters
        const isLinkChar = (key === 192 || key === 189 ||
                           (key >= 48 && key <= 57) ||
                           (key >= 65 && key <= 90) ||
                           !!this.request_pattern);

        if (isLinkChar) {
            const pattern = this.getPattern();
            const checked = this.checkPattern(pattern, this.magic_mode);

            if (checked) this.request_pattern = checked;

            // Debounce
            clearTimeout(this.#debounceTimer);
            this.#debounceTimer = setTimeout(() => {
                this.tryComplete(this.magic_mode);
            }, this.interval);
        }

        return false;
    }

    // ─────────────────────────────────────────────────────────────
    // Core autocomplete logic
    // ─────────────────────────────────────────────────────────────
    async tryComplete(magic_button_mode) {
        if (!this.request_pattern) {
            this.reset();
            return;
        }

        const pattern = this.checkPattern(this.getPattern(), magic_button_mode);
        if (!pattern) {
            this.reset();
            return;
        }

        this.request_pattern = pattern.length > 2 ? pattern : null;
        if (!this.request_pattern) {
            this.reset();
            return;
        }

        this.visualState('seeking');
        await this.requestPattern(this.request_pattern);
    }

    // Finish after server response
    finishComplete(found_pattern, all_patterns) {
        this.found_pattern = found_pattern || null;
        this.found_patterns = all_patterns || [];

        this.visualState(this.found_pattern ? 'found' : '404');

        // Show floating dropdown ONLY when there are additional suggestions
        if (this.found_pattern && this.found_patterns.length > 0) {
            this.#selectedIndex = 0;
            this.#renderDropdown();
        } else {
            this.#hideDropdown();
        }
    }

    // Check if the current text looks like a WikiName
    checkPattern(pattern, magic_button_mode) {
        this.strict_linking_mode = false;

        if (!this.regexp_LinkWhole.test(pattern)) return false;

        if (this.regexp_LinkStrict.test(pattern)) {
            this.strict_linking_mode = true;
            return pattern.slice(2);
        }

        if (this.regexp_LinkSubpage.test(pattern)) {
            this.strict_linking_mode = true;
            return pattern;
        }

        if (this.regexp_LinkCamel.test(pattern) || magic_button_mode) {
            return pattern;
        }

        return false;
    }

    // Wrap non-CamelCase links with (( ))
    StrictLink(pattern) {
        if (this.strict_linking_mode || this.regexp_LinkCamel.test(pattern)) {
            return pattern;
        }
        return `((${pattern}))`;
    }

    // Extract the current partial wiki link from the caret position
    getPattern() {
        const area = this.wikiedit.area;
        let start = area.selectionStart;
        const end = area.selectionEnd;

        // Walk left until we hit a non-link character
        while (start > 0 && this.regexp_LinkLetter.test(area.value[start - 1])) {
            start--;
        }

        return area.value.slice(start, end);
    }

    // Update toolbar button appearance
    visualState(to) {
        if (!this.#containerLi || !this.#buttonEl) return;

        const li = this.#containerLi;
        const ac = this.#buttonEl;
        const reset = this.#resetLi;

        switch (to) {
            case 'seeking':
                li.style.display = '';
                reset.style.display = '';
                ac.innerHTML = '...';
                ac.className = 'we-autocomplete-btn seeking';
                this.#hideDropdown();
                break;

            case 'found':
                li.style.display = '';
                reset.style.display = '';
                ac.innerHTML = this.found_pattern;
                ac.className = 'we-autocomplete-btn found';
                break;

            case '404':
                li.style.display = '';
                reset.style.display = '';
                ac.innerHTML = this.request_pattern;
                ac.className = 'we-autocomplete-btn notfound';
                this.#hideDropdown();
                break;

            case 'hidden':
                li.style.display = 'none';
                reset.style.display = 'none';
                this.#hideDropdown();
                ac.className = 'we-autocomplete-btn';
                break;
        }

        this.visual_state = to;
    }

    // Modern AJAX with fetch + AbortController
    async requestPattern(pattern) {
        // Cancel any previous pending request
        this.#abortController?.abort();
        this.#abortController = new AbortController();
        const signal = this.#abortController.signal;

        const href = `${this.handler}${
            this.handler.includes('?') ? '&' : '?'
        }q=${encodeURIComponent(pattern)}&ta_id=${encodeURIComponent(this.wikiedit.area.id)}&_autocomplete=1&rnd=${Math.random()}`;

        try {
            const response = await fetch(href, { signal });

            if (!response.ok) throw new Error('Network error');

            const text = await response.text();
            const rawItems = text.split('~~~').map(i => i.trim()).filter(Boolean);

            let bestMatch = null;
            let suggestions = [];

            if (rawItems.length > 0) {
                if (rawItems[0] === 'postText') {
                    bestMatch = rawItems[1] || null;
                    suggestions = rawItems.slice(2);
                } else {
                    bestMatch = rawItems[0];
                    suggestions = rawItems.slice(1);
                }
            }

            this.finishComplete(bestMatch, suggestions);
        } catch (err) {
            if (err.name === 'AbortError') return;
            console.warn('Autocomplete request failed:', err);
            this.finishComplete(null, []);
        }
    }
}
