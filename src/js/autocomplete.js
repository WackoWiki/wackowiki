/*!
 * AutoComplete for WikiEdit (ES6)
 *
 * Licensed BSD © Kuso Mendokusee, WackoWiki Team
 */

class AutoComplete {
    constructor(wikiedit, handler) {
        this.wikiedit = wikiedit;
        this.handler = handler;

        wikiedit.autocomplete = this;

        this.interval = 500;           // debounce delay
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

        this.#debounceTimer = null;
    }

    // Private debounce timer
    #debounceTimer = null;

    // Add toolbar button (modern template literal)
    addButton() {
        const we = this.wikiedit;
        this.id = `autocomplete_${we.id}`;

        const html = `
            <li id="${this.id}_li" style="display:none;">
                <div style="font:bold 12px Arial; margin:0; padding:3px 3px 4px 4px;" id="${this.id}"
                     class="btn-"
                     onclick="document.getElementById('${we.id}')._owner.autocomplete.insertFound(); return false;"
                     title="Insert Autocomplete">
                    Autocomplete
                </div>
            </li>
            <li id="${this.id}_reset" style="display:none;">
                <div style="font:12px Arial; padding:3px 3px 4px 4px;" class="btn-"
                     onclick="document.getElementById('${we.id}')._owner.autocomplete.reset(); return false;"
                     title="Hide Autocomplete">&times;</div>
            </li>`;

        we.addButton('customhtml', html);
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

        const state = this.visual_state;
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
    // Key handler (called from WikiEdit.keyDown)
    // ─────────────────────────────────────────────────────────────
    keyDown(key, shiftKey) {
        // Arrow / Enter / Escape when a suggestion is active
        if (this.found_pattern !== null) {
            switch (key) {
                case 13: // Enter
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
        if (!this.found_pattern && key === 32 && (event?.ctrlKey || event?.metaKey)) {
            const pattern = this.checkPattern(this.getPattern(), true);
            if (pattern) {
                this.request_pattern = pattern;
                this.magic_mode = true;
                this.tryComplete(true);
            }
            return true;
        }

        // Normal typing of wiki-link characters
        const isLinkChar = (key === 192 || key === 189 || (key >= 48 && key <= 57) || (key >= 65 && key <= 90) || this.request_pattern);

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
        const li = document.getElementById(`${this.id}_li`);
        const reset = document.getElementById(`${this.id}_reset`);
        const ac = document.getElementById(this.id);

        if (!li || !ac) return;

        switch (to) {
            case 'seeking':
                li.style.display = '';
                reset.style.display = '';
                ac.innerHTML = '...';
                ac.style.color = '#888888';
                ac.style.backgroundColor = '';
                break;

            case 'found':
                li.style.display = '';
                reset.style.display = '';
                ac.innerHTML = this.found_pattern;
                ac.style.color = '#ffffff';
                ac.style.backgroundColor = '#00cc00';
                break;

            case '404':
                li.style.display = '';
                reset.style.display = '';
                ac.innerHTML = this.request_pattern;
                ac.style.color = '#ffffff';
                ac.style.backgroundColor = '#FF0000';
                break;

            case 'hidden':
                li.style.display = 'none';
                reset.style.display = 'none';
                break;
        }

        this.visual_state = to;
    }

    // Modern AJAX with fetch
    async requestPattern(pattern) {
        const href = `${this.handler}${
            this.handler.includes('?') ? '&' : '?'
        }q=${encodeURIComponent(pattern)}&ta_id=${encodeURIComponent(this.wikiedit.area.id)}&_autocomplete=1&rnd=${Math.random()}`;

        try {
            const response = await fetch(href);
            if (!response.ok) throw new Error('Network error');

            const text = await response.text();
            const items = text.split('~~~').filter(Boolean);

            const found = items[0] || false;
            const suggestions = items.slice(1);

            // Call finish inside the class (no more global launchFinishComplete)
            this.finishComplete(found, suggestions);
        } catch (err) {
            console.warn('Autocomplete request failed:', err);
            this.finishComplete(false, []);
        }
    }
}