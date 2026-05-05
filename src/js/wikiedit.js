/*!
 * WikiEdit v3.26 (ES2023+)
 * https://wackowiki.org/doc/Dev/Projects/WikiEdit
 *
 * Licensed BSD © Roman Ivanov, Evgeny Nedelko, WackoWiki Team
 */

// Safe Log fallback
if (typeof window.Log === 'undefined') {
  window.Log = {
    debug: console.debug.bind(console),
    log: console.log.bind(console),
    info: console.info.bind(console),
    warn: console.warn.bind(console),
    error: console.error.bind(console),
    success: (...args) => console.log('%c✓', 'color:#28a745;font-weight:bold', ...args)
  };
}

class WikiEdit extends ProtoEdit {

  static buttonDefs = {
    'h2': { labelKey: 'Heading2', method: 'insTag', args: ['===', '===', 0, 1] },
    'h3': { labelKey: 'Heading3', method: 'insTag', args: ['====', '====', 0, 1] },
    'h4': { labelKey: 'Heading4', method: 'insTag', args: ['=====', '=====', 0, 1] },
    'h5': { labelKey: 'Heading5', method: 'insTag', args: ['======', '======', 0, 1] },
    'h6': { labelKey: 'Heading6', method: 'insTag', args: ['=======', '=======', 0, 1] },
    'bold': { labelKey: 'Bold', method: 'insTag', args: ['**', '**'] },
    'italic': { labelKey: 'Italic', method: 'insTag', args: ['//', '//'] },
    'underline': { labelKey: 'Underline', method: 'insTag', args: ['__', '__'] },
    'strike': { labelKey: 'Strikethrough', method: 'insTag', args: ['--', '--'] },
    'small': { labelKey: 'Small', method: 'insTag', args: ['++', '++'] },
    'code': { labelKey: 'Code', method: 'insTag', args: ['##', '##'] },
    'ul': { labelKey: 'List', method: 'insTag', args: ['  * ', '', 0, 1, 1] },
    'ol': { labelKey: 'NumberedList', method: 'insTag', args: ['  1. ', '', 0, 1, 1] },
    'center': { labelKey: 'Center', method: 'insBlockWrapper', args: ['%%(wacko wrapper=text wrapper_align=center)'] },
    'right': { labelKey: 'Right', method: 'insBlockWrapper', args: ['%%(wacko wrapper=text wrapper_align=right)'] },
    'justify': { labelKey: 'Justify', method: 'insBlockWrapper', args: ['%%(wacko wrapper=text wrapper_align=justify)'] },
    'outdent': { labelKey: 'Outdent', method: 'unindent', args: [] },
    'indent': { labelKey: 'Indent', method: 'insTag', args: ['  ', '', 0, 1] },
    'quote': { labelKey: 'Quote', method: 'insTag', args: ['<[', ']>', 2] },
    'source': { labelKey: 'CodeWrapper', method: 'insBlockWrapper', args: ['%%'] },
    'action': { labelKey: 'Action', method: 'insTag', args: ['{{', '}}', 2] },
    'textred': { labelKey: 'MarkedText', method: 'insTag', args: ['!!', '!!', 2] },
    'highlight': { labelKey: 'HighlightText', method: 'insTag', args: ['??', '??', 2] },
    'hr': { labelKey: 'HorizontalRule', method: 'insTag', args: ['', '\n----\n', 2] },
    'signature': { labelKey: 'Signature', method: 'insTag', args: ['::@::', ' ', 1] },
    'createlink': { labelKey: 'Hyperlink', method: 'createLink', args: [] },
    'footnote': { labelKey: 'Footnote', method: 'insTag', args: ['[[^ ', ']]', 2] },
    'createtable': { labelKey: 'InsertTable', method: 'createTable', args: [] },
    'upload-media': { labelKey: 'Upload', method: 'triggerFileUpload', condition: 'canUpload' },
    'wacko2md': { label: 'Wacko → MD', method: 'convertToMarkdown', args: [] },
    'md2wacko': { label: 'MD → Wacko', method: 'convertToWacko', args: [] },
    'dark-toggle': { labelKey: 'ToggleDark', method: 'toggleDarkMode', args: [] },
    'syntax': { labelKey: 'SyntaxHighlighting', method: 'toggleSyntaxHighlight', args: [] },
    'livepreview': { labelKey: 'LivePreview', method: 'toggleLivePreview', args: [] },
    'fullscreen': { labelKey: 'Fullscreen', method: 'toggleFullscreen', args: [] },
    'shrink': { labelKey: 'HeightShrink', method: 'changeEditorHeight', args: [-100] },
    'enlarge': { labelKey: 'HeightEnlarge', method: 'changeEditorHeight', args: [100] },
    'undo': { labelKey: 'Undo', method: 'undo', args: [] },
    'redo': { labelKey: 'Redo', method: 'redo', args: [] },
    'search': { labelKey: 'SearchReplace', method: 'showFindReplace', args: [] },
    'about': { labelKey: 'HelpAbout', method: 'showHelpModal', args: [] },
  };

  constructor() {
    super();

    // Session heartbeat
    this.heartbeatTimer = null;
    this.heartbeatName = null;
    this.heartbeatInterval = 0;

    this.manual = 'https://wackowiki.org/doc/';
    this.mark = '##inspoint##';
    this.begin = '##startpoint##';
    this.rbegin = new RegExp(this.begin);
    this.end = '##endpoint##';
    this.rend = new RegExp(this.end);
    this.rendb = new RegExp('^' + this.end);
    this.enterpressed = false;

    // Single-form popups
    this.linkForm = null;
    this.linkContext = null;
    this.tableForm = null;
    this.tableContext = null;

    // Undo/Redo
    this.undoStack = [];
    this.redoStack = [];
    this.maxHistory = 100;

    // Autosave (localStorage draft)
    this.hasDraft = false; // // future flag to dynamically enable/disable the button
    this.draftKey = null;
    this.autosaveTimer = null;
    this.autosaveDelay = 8000; // save 8 seconds after the last change (5–10 s range)
    this.pushTimer = null;

    this.cf_modified = false;

    // Prevent race-condition re-save during actual page submit
    this.isSubmitting = false;

    // UI panels
    this.findForm = null;
    this.helpModal = null;

    // Syntax Highlighting (overlay)
    this.syntaxHighlightEnabled = true;
    this.highlighter = null;
    this.syntaxContainer = null;

    // Editor height
    this.HEIGHT_KEY = 'we_editor_height';
    this.DEFAULT_HEIGHT = 400;
    this.preferredHeight = this.DEFAULT_HEIGHT;

    // Autosave draft
    this.DRAFT_KEY_PREFIX = 'we_draft_';
  }

  // ===================================================================
  // INITIALISATION
  // ===================================================================
  init(id, imgPath) {
    this._init(id);
    this.imagesPath = imgPath || 'image/';

    this.area.wikiEditInstance = this;

    const ta = this.area;

    // ====================== HYBRID EDITOR HEIGHT ======================
    this.preferredHeight = this.loadPreferredHeight(ta);
    ta.style.height = `${this.preferredHeight}px`;

    // Auto dark mode support – ensure the whole editor respects system preference
    document.documentElement.style.setProperty('color-scheme', 'light dark');

    // ====================== FEATURE FLAGS ======================
    this.syntaxHighlighting = ta.dataset.syntaxHighlighting !== '0';
    this.livePreviewDefault = ta.dataset.livePreviewDefault === '1';
    this.canUpload = ta.dataset.canUpload === '1';

    // ====================== CONTEXT DETECTION (EDIT vs COMMENT) ======================
    this.isCommentMode = ta.id === 'addcomment' || ta.name === 'payload';

    const form = ta.closest('form');
    this.ajaxUrl = form
      ? (form.getAttribute('action') || window.location.href)
      : window.location.href;

    // comment form uses <div id="commentform" class="commentform">
    this.isCommentMode = !!document.getElementById('commentform') ||
      (form && form.closest('.commentform')) ||
      ta.name === 'payload' || ta.id === 'payload';

    // ====================== DRAG & DROP + PASTE ======================
    if (this.canUpload) {
      this.area.addEventListener('dragover', this.handleDragOver.bind(this));
      this.area.addEventListener('drop', this.handleDrop.bind(this));
      this.area.addEventListener('paste', this.handlePaste.bind(this));
    }

    // Setup undo/redo
    this.area.addEventListener('beforeinput', this.handleBeforeInput.bind(this));

    // Load and build configurable toolbar instead of hard-coded buttons
	this.loadAndBuildToolbar();

    // Initial post-setup
    if (typeof this.attachSpecialButtons === 'function') {
      this.attachSpecialButtons();
    }

    if (this.autocomplete) {
      setTimeout(() => {
        this.autocomplete.attachDropdown();
      }, 50);
    }

    // ====================== POST-TOOLBAR SETUP ======================
    // All code that depends on the toolbar DOM must run AFTER buildToolbar()
    // must be called after toolbar is built
    // ====================== LIVE PREVIEW ======================
    const savedLivePreview = localStorage.getItem('we_live_preview_enabled');
    const shouldEnableLivePreview = (savedLivePreview !== null)
      ? (savedLivePreview === 'true')
      : this.livePreviewDefault;

    this.enableLivePreview();

    if (shouldEnableLivePreview) {
      setTimeout(() => this.toggleLivePreview(), 100);
    }

    // ====================== DARK MODE PERSISTENCE ======================
    // respect persisted user choice via the toggle button
    // (no server-side default; if never toggled → system preference is used)
    const savedDarkMode = localStorage.getItem('we_dark_mode_enabled');
    if (savedDarkMode !== null) {
      const shouldBeDark = savedDarkMode === 'true';
      const html = document.documentElement;
      html.setAttribute('data-theme', shouldBeDark ? 'dark' : 'light');

      const tb = document.getElementById(`tb_${this.id}`);
      const darkLi = tb ? tb.querySelector('li.we-dark-toggle') : null;
      if (darkLi) darkLi.classList.toggle('active', shouldBeDark);
    }

    // ====================== STATUS BAR ======================
    const statusBar = this.createStatusBar();
    this.area.parentNode.insertBefore(statusBar, this.area.nextSibling);

    this.updateStatus();

    this.area.addEventListener('input', () => this.updateStatus());
    this.area.addEventListener('keyup', () => this.updateStatus());
    this.area.addEventListener('click', () => this.updateStatus());

    // Load saved syntax state from localStorage (overrides data-attribute)
    const savedSyntax = localStorage.getItem('we_syntax_enabled');
    if (savedSyntax !== null) {
      this.syntaxHighlighting = savedSyntax === 'true';
    }

    // Setup overlay
    this.setupSyntaxHighlighting();

    // Apply state
    if (this.syntaxHighlighting) {
      this.enableSyntaxHighlighting();
    } else {
      this.disableSyntaxHighlighting();
    }

    // Live updates
    this.area.addEventListener('input', () => {
      this.updateStatus();
      this.refreshSyntaxHighlight();
    });

    // Scroll sync + resize observer
    this.area.addEventListener('scroll', () => {
      if (this.highlighter) {
        this.highlighter.scrollTop = this.area.scrollTop;
        this.highlighter.scrollLeft = this.area.scrollLeft;
      }
    });

    this.resizeObserver = new ResizeObserver(() => this.syncContentSize());
    this.resizeObserver.observe(this.area);
    this.resizeObserver.observe(this.syntaxContainer || this.area.parentNode);

    // Live updates
    const updateStatusHandler = () => this.updateStatus();
    this.area.addEventListener('input', updateStatusHandler);
    this.area.addEventListener('keyup', updateStatusHandler);
    this.area.addEventListener('click', updateStatusHandler);
    this.area.addEventListener('mouseup', updateStatusHandler);

    // ====================== AUTOSAVE SETUP ======================
    if (this.area.dataset.autosaveDraft !== '0') {
      this.setupAutosave();
      this.loadAutosavedDraft();
    }

    // ====================== SESSION HEARTBEAT ======================
    this.initSessionHeartbeat();

    Log.success(`WikiEdit initialized: ${id}`);
  }

  // ===================================================================
  // Override buildToolbar e.g. Autocomplete
  // ===================================================================
  buildToolbar(configArray) {
    // Let ProtoEdit clear and build the standard buttons from config
    super.buildToolbar.call(this, configArray);

    // NOW re-add the autocomplete custom button (after the array has been processed)
    if (this.autocomplete) {
      this.autocomplete.addButton();

      // Force rebuild of the toolbar DOM so the new customhtml appears
      this.toolbar = this.createToolbar();

      const container = document.getElementById(`tb_${this.id}`);
      if (container) {
        const oldUl = container.querySelector('.we-toolbar');
        if (oldUl) oldUl.remove();
        container.appendChild(this.toolbar);
      }
    }

    // Re-attach special buttons
    if (typeof this.attachSpecialButtons === 'function') {
      this.attachSpecialButtons();
    }

    // Re-attach autocomplete listeners
    if (this.autocomplete) {
      setTimeout(() => {
        this.autocomplete.attachDropdown();
      }, 50);
    }
  }

  loadAndBuildToolbar() {
    let config = [];

    // Only use server-side preference (data-toolbar-buttons)
    const serverJson = this.area.dataset.toolbarButtons;
    if (serverJson) {
      try {
        config = JSON.parse(serverJson);
      } catch (e) {
        Log.warn('Invalid toolbar JSON from server');
      }
    }

    // Ultimate fallback
    if (!config.length) {
      config = this.getDefaultToolbarOrder();
    }

    // IMPORTANT: Build the toolbar from config FIRST
    this.buildToolbar(config);
  }

  getDefaultToolbarOrder() {
    return [
      'h2', 'h3', 'h4', 'h5', 'h6', 'separator',
      'bold', 'italic', 'underline', 'strike', 'small', 'code', 'separator',
      'ul', 'ol', 'separator',
      'center', 'right', 'justify', 'separator',
      'outdent', 'indent', 'separator',
      'quote', 'source', 'action', 'textred', 'highlight', 'separator',
      'hr', 'signature', 'createlink', 'footnote', 'createtable',
      'upload-media', 'separator',
      'draft-restore', 'draft-clear', 'separator',
      'wacko2md', 'md2wacko', 'separator',
      'dark-toggle', 'syntax', 'livepreview', 'fullscreen', 'separator',
      'shrink', 'enlarge', 'separator',
      'undo', 'redo', 'separator', 'search', 'about',
      'dropdown',
    ];
  }
  

  attachSpecialButtons() {
    if (!this.toolbar) return;

    // ====================== FULLSCREEN BUTTON SETUP ======================
    const fsLi = this.toolbar.querySelector('li.we-fullscreen');
    if (fsLi) {
      this.fullscreenBtn = fsLi.querySelector('button');
      this.fullscreenIcon = this.fullscreenBtn?.querySelector('img') || this.fullscreenBtn?.querySelector('.we-icon');
    }

    // Update icon when fullscreen state changes
    const updateFSIcon = () => {
      if (!this.fullscreenIcon) return;
      const isFullscreen = !!document.fullscreenElement;
      this.fullscreenIcon.innerHTML = isFullscreen
        ? '' //this.icons.exitfullscreen
        : ''; //this.icons.fullscreen;
    };

    // Listen for fullscreen change
    document.removeEventListener('fullscreenchange', updateFSIcon);
    document.addEventListener('fullscreenchange', updateFSIcon);

    // Initial update
    updateFSIcon();
  }

  /**
   * Initialize session heartbeat with exponential backoff and proper cleanup
   */
  initSessionHeartbeat() {
    const timeoutSec = parseInt(this.area.dataset.heartbeatTimeout, 10);
    const name = this.area.dataset.heartbeatName || 'edit';

    if (!timeoutSec || timeoutSec < 60) return;

    if (this.heartbeatTimer) {
      clearInterval(this.heartbeatTimer);
    }

    let failCount = 0;
    const maxFails = 3;

    const heartbeat = async () => {
      try {
        const url = `${window.location.pathname}?_autocomplete=1&rnd=${Date.now()}`;

        const response = await fetch(url, {
          method: 'GET',
          cache: 'no-cache',
          headers: { 'X-Requested-With': 'XMLHttpRequest' },
          credentials: 'same-origin'
        });

        if (!response.ok) throw new Error(`HTTP ${response.status}`);

        failCount = 0;                    // reset on success
        Log.debug(`Heartbeat OK for ${name}`);

      } catch (err) {
        failCount++;
        Log.warn(`Heartbeat failed (${failCount}/${maxFails}) for ${name}`);

        if (failCount >= maxFails) {
          this.showSessionExpiredWarning(name);
          this.stopHeartbeat();           // important: stop all further attempts
        }
      }
    };

    // Start the interval
    this.heartbeatTimer = setInterval(heartbeat, timeoutSec * 1000);
    Log.debug(`Session heartbeat started for "${name}" every ${timeoutSec}s`);
  }

  /**
   * Stop heartbeat completely
   */
  stopHeartbeat() {
    if (this.heartbeatTimer) {
      clearInterval(this.heartbeatTimer);
      this.heartbeatTimer = null;
    }
  }

  /**
   * Show session expired warning only if content was modified
   */
  showSessionExpiredWarning(ename) {
    if (!this.cf_modified) {
      Log.debug('Session expired, but no changes detected → skipping warning');
      return;
    }

    const lang = window.lang || {};
    const msg = lang.SessionExpiredEditor
      || 'Your session has expired. Please save your changes to avoid losing data.';

    const div = document.createElement('div');
    div.className = 'msg error session-expired-warning';
    div.innerHTML = `
        <div style="display:flex; align-items:center; justify-content:space-between; gap:12px;">
          <div>
            <strong>${msg}</strong><br>
            <small>Your unsaved changes are still in the editor.</small>
          </div>
          <div style="display:flex; gap:8px;">
            <button type="button" class="btn-save-draft">Save Draft</button>
            <button type="button" class="btn-reload">Reload Page</button>
            <button type="button" class="btn-dismiss">Dismiss</button>
          </div>
        </div>
      `;

    const target = document.getElementsByName(ename)[0] || this.area;
    if (target?.parentNode) {
      target.parentNode.insertBefore(div, target);
    }

    // Save Draft
    div.querySelector('.btn-save-draft').addEventListener('click', () => {
      if (typeof this.saveDraft === 'function') this.saveDraft();
      div.remove();
    });

    // Reload Page
    div.querySelector('.btn-reload').addEventListener('click', () => {
      if (confirm(lang.ConfirmReload || 'Reload page? Unsaved changes will be lost.')) {
        window.location.reload();
      }
    });

    // Dismiss
    div.querySelector('.btn-dismiss').addEventListener('click', () => div.remove());

    alert(msg);

    // Disable main buttons
    document.querySelectorAll('button[type="submit"], .btn-ok, .btn-save, .btn-publish').forEach(btn => {
      if (!btn.classList.contains('btn-save-draft')) btn.disabled = true;
    });

    Log.warn('Session expired warning displayed');
  }

  // ====================== AUTOSAVE (localStorage draft) ======================

  /**
   * Sets up autosave listeners and prepares the storage key.
   */
  setupAutosave() {
    const path = window.location.pathname;
    const section = window.location.search || '';
    const uniqueKey = `${this.id}-${path}${section}`;

    this.draftKey = this.DRAFT_KEY_PREFIX + uniqueKey;

    // Input → mark as modified + debounced autosave
    this.area.addEventListener('input', () => {
      this.setModified();
      this.debounceAutosave.call(this);
    });

    // Blur still saves immediately
    this.area.addEventListener('blur', () => {
      clearTimeout(this.autosaveTimer);
      this.saveDraft();
    });

    // beforeunload save
    window.addEventListener('beforeunload', () => {
      if (!this.isSubmitting) {
        this.saveDraft();
      }
    }, { passive: true });

    // Critical Fields
    window.onbeforeunload = this.checkCf.bind(this);

    // Make legacy weSave() point to our new implementation
    window.weSave = () => this.savePage();

    // Native form submit (backup for direct <input type="submit"> clicks)
    const form = this.area.form || this.area.closest('form');
    if (form) {
      form.addEventListener('submit', () => {
        this.isSubmitting = true;
        this.ignoreModified();
        this.clearDraft();
      });
    }
  }

  /**
   * Saves the current editor content to localStorage.
   * Empty content is not saved (draft is cleared).
   */
  saveDraft() {
    if (!this.cf_modified) {
      Log.info('[WikiEdit] saveDraft skipped – no changes from original');
      return;
    }

    if (!this.draftKey) return;

    const content = this.area.value.trim();
    if (content === '') {
      this.safeRemoveDraft(this.draftKey);
      return;
    }

    const draftData = {
      content: content,
      timestamp: Date.now(),
      title: document.getElementById('page_title')?.value?.trim() || ''
    };

    if (this.safeSetDraft(this.draftKey, JSON.stringify(draftData))) {
      this.showMessage(`✓ ${lang.DraftSaved || 'Draft saved'}`);
    }
  }

  clearDraft() {
    if (!this.draftKey) return;
    this.safeRemoveDraft(this.draftKey);
    Log.info('[WikiEdit] Autosaved draft cleared');
    this.showMessage(`${lang.DraftCleared || 'Draft cleared'}`);
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
   * Debounce pushState aggressively only when the text is very large.
   * This reduces the number of full-string copies and comparisons dramatically
   * while still giving the user a responsive undo stack.
   */
  _debouncePushState() {
    const t = this.area;
    if (!t) return;

    const len = t.value.length;

    if (len < 20000) {
      // small/medium text → instant push
      this.pushState();
      return;
    }

    // very large text → debounce more aggressively
    clearTimeout(this.pushTimer);
    this.pushTimer = setTimeout(() => {
      this.pushState();
      this.pushTimer = null;
    }, 650);   // 650 ms is a good "aggressive" sweet spot
  }

  /**
   * On editor initialisation: if a draft exists and differs from the loaded content,
   * the user is asked whether to restore it (with undo support).
   */
  loadAutosavedDraft() {
	if (!this.draftKey) return;
	const saved = this.safeGetDraft(this.draftKey);

    if (!saved) return;

    let draft;
    try {
      draft = JSON.parse(saved);
    } catch (e) {
      this.safeRemoveDraft(this.draftKey);
      return;
    }

    if (!draft.content) {
      this.safeRemoveDraft(this.draftKey);
      return;
    }

    this.showDraftInfobox(draft);
  }

  showDraftInfobox(draft) {
      const date = new Date(draft.timestamp);
      const timeStr = date.toLocaleString();
      const relativeTime = this.getRelativeTime(date);

      const infoboxHTML = `
        <div id="draft-infobox" class="info-box draft-infobox">
              <strong>${this.lang?.DraftFound || 'Draft found'}</strong> — 
              ${this.lang?.SavedOn || 'saved'} 
              <time datetime="${date.toISOString()}" title="${timeStr}">
                  ${relativeTime}
              </time><br>
			<span class="visuallyhidden">${this.lang?.RecoverDraftQuestion || 'Do you want to recover the draft?'}</span>
          <br>
          <button type="button" class="btn-ok" id="recover-draft-btn">${this.lang?.RecoverDraft || 'Recover Draft'}</button>
          <button type="button" class="btn-cancel" id="discard-draft-btn">${this.lang?.DiscardDraft || 'Discard Draft'}</button>
        </div>
      `;

      const placeholder = document.getElementById('draft-infobox-placeholder');
      if (placeholder) {
        placeholder.innerHTML = infoboxHTML;
      } else {
        // Fallback
        const target = this.area?.parentNode;
        if (target) {
          const div = document.createElement('div');
          div.innerHTML = infoboxHTML;
          target.insertBefore(div, this.area);
        }
      }

      // Handlers
      document.getElementById('recover-draft-btn').onclick = () => {
        this.replaceContent(draft.content);
        this.safeRemoveDraft(this.draftKey);
        document.getElementById('draft-infobox')?.remove();
      };

      document.getElementById('discard-draft-btn').onclick = () => {
        this.safeRemoveDraft(this.draftKey);
        document.getElementById('draft-infobox')?.remove();
      };
    }

  toggleDarkMode() {
    const html = document.documentElement;
    const currentIsDark = html.getAttribute('data-theme') === 'dark';
    const newIsDark = !currentIsDark;

    html.setAttribute('data-theme', newIsDark ? 'dark' : 'light');

    // update toolbar active state (exactly like toggleLivePreview())
    const tb = document.getElementById(`tb_${this.id}`);
    const darkLi = tb ? tb.querySelector('li.we-dark-toggle') : null;
    if (darkLi) darkLi.classList.toggle('active', newIsDark);

    // Force repaint so syntax + toolbar update instantly
    this.area.style.transition = 'background 0.2s';
    setTimeout(() => { this.area.style.transition = ''; }, 300);

    Log.info('[WikiEdit] Manual dark mode toggled');

    localStorage.setItem('we_dark_mode_enabled', newIsDark);
  }

  /**
   * Toggle fullscreen mode ONLY for the editor container (#page-edit).
   * This gives a clean distraction-free editing area while the browser still
   * shows its own chrome (address bar, etc.). Much better for wiki editing.
   */
  toggleFullscreen() {
    if (document.fullscreenElement) {
      document.exitFullscreen().catch(err => Log.error(err));
      return;
    }

    // Support BOTH edit handler (#page-edit) and comment handler (#commentform)
    let container = document.getElementById('page-edit') ||
      document.getElementById('commentform');

    // fallback
    if (!container) {
      container = this.area.closest('form') ||
        this.area.closest('.wikiedit-split-container') ||
        document.querySelector('.commentform');
    }

    if (container) {
      container.requestFullscreen({ navigationUI: 'hide' })
        .catch(err => Log.error('Editor fullscreen request failed:', err));
    } else {
      Log.warn('WikiEdit: Could not find editor container for fullscreen (#page-edit or #commentform)');
    }
  }

  // Optional helper – reset to server default (call from a “Reset height” button if you add one later)
  resetEditorHeight() {
    localStorage.removeItem('we_editor_height');
    window.location.reload(); // reload to pick up server default again
  }

  // ====================== UNDO / REDO STACK ======================

  validateState(state) {
    if (!state || typeof state !== 'object') {
      Log.warn('WikiEdit: undo state is not an object');
      return false;
    }
    if (typeof state.text !== 'string') {
      Log.warn('WikiEdit: undo state.text is not a string');
      return false;
    }
    const len = state.text.length;
    if (typeof state.start !== 'number' || state.start < 0 || state.start > len) {
      Log.warn('WikiEdit: invalid selectionStart', state.start, '(text length =', len, ')');
      return false;
    }
    if (typeof state.end !== 'number' || state.end < state.start || state.end > len) {
      Log.warn('WikiEdit: invalid selectionEnd', state.end, '(start =', state.start, ', length =', len, ')');
      return false;
    }
    if (typeof state.scroll !== 'number' || state.scroll < 0) {
      Log.warn('WikiEdit: invalid scrollTop', state.scroll);
      return false;
    }
    return true;
  }

  pushState() {
    const t = this.area;
    if (!t) return;

    const state = {
      text: t.value,
      start: t.selectionStart,
      end: t.selectionEnd,
      scroll: t.scrollTop
    };

    if (!this.validateState(state)) {
      Log.error('WikiEdit: invalid state – refusing to push to undo stack');
      return;
    }

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
    const current = {
      text: t.value,
      start: t.selectionStart,
      end: t.selectionEnd,
      scroll: t.scrollTop
    };

    // validate current state before saving it to redo
    if (!this.validateState(current)) {
      Log.warn('WikiEdit: current state invalid before undo – still proceeding');
    }

    this.redoStack.push(current);

    const prev = this.undoStack.pop();

    if (!this.validateState(prev)) {
      Log.error('WikiEdit: corrupted undo state popped! Stack sanitized.');
      // aggressive cleanup of the entire undo stack (removes all bad states)
      this.undoStack = this.undoStack.filter(s => this.validateState(s));
      return false;
    }

    this.replaceContent(prev.text, false);

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

    if (!this.validateState(current)) {
      Log.warn('WikiEdit: current state invalid before redo – still proceeding');
    }

    this.undoStack.push(current);

    const next = this.redoStack.pop();

    if (!this.validateState(next)) {
      Log.error('WikiEdit: corrupted redo state popped! Stack sanitized.');
      this.redoStack = this.redoStack.filter(s => this.validateState(s));
      return false;
    }

    //t.value = next.text;
	this.replaceContent(next.text, false);
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

    this._debouncePushState();
  }

  destroy() {
    if (this.heartbeatTimer) {
      clearInterval(this.heartbeatTimer);
      this.heartbeatTimer = null;
    }

    if (this.pushTimer) {
      clearTimeout(this.pushTimer);
    }
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

    for (let i = 0;i < lines.length;i++) {
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

    // === TOGGLE LOGIC (mirrors insTag but accounts for \n after openTag) ===
    const openWithNl = openTag + '\n';
    const closeWithNl = '\n' + closeTag;
    let applied = false;

    if (this.sel &&
      this.sel.length >= openWithNl.length + closeWithNl.length &&
      this.sel.startsWith(openWithNl) &&
      this.sel.endsWith(closeWithNl)) {
      // Case 1: Whole block (including wrappers) is selected.
      const newSel = this.sel.slice(openWithNl.length, -closeWithNl.length);
      const newValue = this.sel1 + newSel + this.sel2;
      const newStart = this.sel1.length;
      const newEnd = newStart + newSel.length;

      this.replaceContent(newValue);
      t.setSelectionRange(newStart, newEnd);
      t.scrollTop = this.scroll;
      applied = true;
    } else if (this.sel1.endsWith(openWithNl) &&
      this.sel2.startsWith(closeWithNl)) {
      // Case 2: Inner content selected, wrappers are outside (common after first wrap).
      const newValue = this.sel1.slice(0, -openWithNl.length) + this.sel + this.sel2.slice(closeWithNl.length);
      const newStart = this.sel1.length - openWithNl.length;
      const newEnd = newStart + this.sel.length;

      this.replaceContent(newValue);
      t.setSelectionRange(newStart, newEnd);
      t.scrollTop = this.scroll;
      applied = true;
    }

    if (applied) {
      return true;
    }

    // not already marked
    const content = this.sel || '';

    const wrapped = `${openTag}\n${content}\n${closeTag}`;

    const newValue = this.sel1 + wrapped + this.sel2;
    this.replaceContent(newValue);

    // Place cursor right after the opening tag (ready to type)
    const cursorPos = this.sel1.length + openTag.length + 1;   // +1 for the newline
    t.setSelectionRange(cursorPos, cursorPos);

    return true;
  }

  insTag(Tag, Tag2, onNewLine, expand, strip) {
    if (onNewLine == null) onNewLine = 0;
    if (expand == null) expand = 0;
    if (strip == null) strip = 0;

    const t = this.area;
    t.focus();
    this.getDefines();

    // Skip toggle logic for indentation and list operations.
    // These use expand=1 which means they work line-by-line with MarkUp().
    // The toggle detection is only meant for simple inline/block tags.
    const isIndentOrListOp = (expand === 1 || strip === 1);

    // Detect if already marked (covers both "tags inside selection" and
    // "tags outside selection" cases – works for single-line, multi-line,
    // and the common case where the editor re-selects the inner content
    // after the first wrap).
    const tagLen = Tag.length;
    const tag2Len = Tag2.length;
    let applied = false;

    if (!isIndentOrListOp && this.sel &&
      this.sel.length >= tagLen + tag2Len &&
      this.sel.startsWith(Tag) &&
      this.sel.endsWith(Tag2)) {
      // Case 1: Tags are inside the current selection (e.g. user selected
      // the whole "**text**" or the editor-selected inner content after wrap).
      const newSel = this.sel.slice(tagLen, -tag2Len);
      const newValue = this.sel1 + newSel + this.sel2;
      const newStart = this.sel1.length;
      const newEnd = newStart + newSel.length;

      this.replaceContent(newValue);
      t.setSelectionRange(newStart, newEnd);
      t.scrollTop = this.scroll;
      applied = true;
    } else if (!isIndentOrListOp && this.sel1.length >= tagLen &&
      this.sel1.endsWith(Tag) &&
      this.sel2.length >= tag2Len &&
      this.sel2.startsWith(Tag2)) {
      // Case 2: Tags surround the current selection (most common after first click).
      const newValue = this.sel1.slice(0, -tagLen) + this.sel + this.sel2.slice(tag2Len);
      const newStart = this.sel1.length - tagLen;
      const newEnd = newStart + this.sel.length;

      this.replaceContent(newValue);
      t.setSelectionRange(newStart, newEnd);
      t.scrollTop = this.scroll;
      applied = true;
    }

    if (applied) {
      return true;
    }

    // === ORIGINAL BEHAVIOR (if not already marked) ===
    const str = this.MarkUp(Tag, this.str, Tag2, onNewLine, expand, strip);
    this.setAreaContent(str);
    return true;
  }

  unindent() {
    const t = this.area;
    t.focus();
    this.getDefines();

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

    // Take autocomplete first
    if (this.autocomplete?.keyDown(e)) {
      res = true;
    }

    // ====================== MODERN KEY HANDLING ======================
    const ctrl = e.ctrlKey;
    const alt = e.altKey;
    const shift = e.shiftKey;
    const key = e.key.toLowerCase();

    if (ctrl && key === 'z') {
      const success = shift ? this.redo() : this.undo();
      if (success) {
        res = true;
        noscroll = true;
      }
    } else if (ctrl && key === 'f') {
      this.showFindReplace();
      res = true;
    } else if (alt && (key === 'u' || key === 'i')) {
        res = shift || (alt && key === 'u')
          ? this.unindent()
          : this.insTag('  ', '', 0, 1);
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
      this.savePage();
      res = true;
    } else if ((ctrl || alt) && key === 'l') {
      if (shift && ctrl) {
        res = this.insTag('  * ', '', 0, 1, 1);
      } else {
        res = this.createLink(alt);
      }
    } else if (ctrl && shift && (key === 'n' || key === 'o')) {
      res = this.insTag('  1. ', '', 0, 1, 1);
    } else if (e.key === 'Enter' && !e.shiftKey) {
      // (Enter auto-list logic)
      const text = t.value.replace(/\r/g, '');
      const sel1 = text.slice(0, t.selectionStart);
      const sel2 = text.slice(t.selectionEnd);

      const re = new RegExp('(^|\n)(( +)((([*-]|([1-9]\d*|[\p{Ll}\p{Lu}])([.]|[)]))( |))|))(' + (this.enterpressed ? '\\s' : '[^\\r\\n]') + '*)' + '$', 'u');
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

        const newValue = sel1 + '\n' + prefix + sel2;
        this.replaceContent(newValue);

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

  savePage() {
    if (!confirm(lang.ReallySave || 'Really save this page?')) {
      return;
    }

    this.isSubmitting = true;
    this.ignoreModified();
    this.clearDraft();

    // Find the edit form (works with both name="edit" and id="edit_page")
    const form = this.area.form ||
      this.area.closest('form') ||
      document.forms.namedItem('edit') ||
      document.querySelector('form[name="edit"], form#edit_page');

    if (!form) {
      Log.warn('[WikiEdit] savePage: could not find form');
      return;
    }

    // This sends name="save" in the POST data so the backend actually saves
    const saveBtn = form.querySelector('input[name="save"], button[name="save"]');
    if (saveBtn) {
      saveBtn.click();
    } else {
      form.submit();
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
    this.replaceContent(str);
    t.setSelectionRange(l, l + l1);
    t.scrollTop = this.scroll;
  }

  // ====================== MODIFICATION METHODS ======================

  createLink(isAlt) {
    const t = this.area;
    t.focus();
    this.getDefines();

    if (!/\n/.test(this.sel)) {
      if (isAlt) {
        const str = this.sel1 + '((' + this.trim(this.sel) + '))' + this.sel2;
        this.replaceContent(str);
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
    const urlInput = document.getElementById(`we-link-url-${this.id}`);
    const textInput = document.getElementById(`we-link-text-${this.id}`);
    const cancelBtn = document.getElementById(`we-link-cancel-${this.id}`);
    const formEl = document.getElementById(`we-link-form-${this.id}`);

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
    let sl = f.textInput.value ?? '';

    let combined = lnk + ' ' + sl;

    if (!combined.trim()) {
      this.hideLinkForm();
      area.focus();
      return;
    }

    const str = sel1 + '((' + combined + '))' + sel2;

	this.replaceContent(str, true, area);
    const start = sel1.length;
    const end = str.length - sel2.length;
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
    const colsInput = document.getElementById(`we-table-cols-${this.id}`);
    const rowsInput = document.getElementById(`we-table-rows-${this.id}`);
    const captionInput = document.getElementById(`we-table-caption-${this.id}`);
    const colHeaderCheck = document.getElementById(`we-table-colheader-${this.id}`);
    const rowHeaderCheck = document.getElementById(`we-table-rowheader-${this.id}`);
    const cancelBtn = document.getElementById(`we-table-cancel-${this.id}`);
    const formEl = document.getElementById(`we-table-form-${this.id}`);

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
      for (let c = 0;c < cols;c++) {
        headerCells.push(`${lang.Header || 'Header'} ${c + 1}`);
      }
      const chRow = '*| ' + headerCells.join(' | ') + ' |*';
      lines.push(chRow);
    }

    // Data rows
    for (let r = 0;r < rows;r++) {
      const rowStart = rowHeader ? '^|' : '||';
      const rowCells = rowHeader ? [`${lang.Header || 'Header'} ${r + 1}`] : [];
      for (let c = 0;c < cols;c++) {
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
    const insertStr = '\n' + tableStr + '\n';
    const newValue = sel1 + insertStr + sel2;

    this.replaceContent(newValue);

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
      </div>
	  <div class="we-modal-header">
          <h3 class="we-modal-title">${lang.KeyboardShortcuts || 'Keyboard Shortcuts'}</h3>
        </div>
        <div class="we-modal-body" style="padding:20px; max-height:50vh; overflow-y:auto;">
          <table class="we-shortcuts-table" style="width:100%; border-collapse:collapse; font-size:13px;">
            <thead>
              <tr>
                <th>${lang.Shortcut || 'Shortcut'}</th>
                <th>${lang.Action || 'Action'}</th>
              </tr>
            </thead>
            <tbody>
              <tr><td><kbd>${lang.Ctrl}</kbd> + <kbd>Z</kbd></td><td>${lang.Undo || 'Undo'}</td></tr>
              <tr><td><kbd>${lang.Ctrl}</kbd> + <kbd>${lang.Shift}</kbd> + <kbd>Z</kbd></td><td>${lang.Redo || 'Redo'}</td></tr>
              <tr><td><kbd>${lang.Ctrl}</kbd> + <kbd>F</kbd></td><td>${lang.SearchReplace || 'Search & Replace'}</td></tr>
              <tr><td><kbd>${lang.Alt}</kbd> + <kbd>I</kbd></td><td>${lang.Indent || 'Indent'}</td></tr>
              <tr><td><kbd>${lang.Alt}</kbd> + <kbd>U</kbd></td><td>${lang.Outdent || 'Outdent'}</td></tr>
              <tr><td><kbd>${lang.Ctrl}</kbd> + <kbd>1</kbd> … <kbd>6</kbd></td><td>${lang.HeadingLevels || 'Heading level 1–6'}</td></tr>
              <tr><td><kbd>${lang.Ctrl}</kbd> + <kbd>B</kbd></td><td>${lang.Bold || 'Bold'}</td></tr>
              <tr><td><kbd>${lang.Ctrl}</kbd> + <kbd>I</kbd></td><td>${lang.Italic || 'Italic'}</td></tr>
              <tr><td><kbd>${lang.Ctrl}</kbd> + <kbd>U</kbd></td><td>${lang.Underline || 'Underline'}</td></tr>
              <tr><td><kbd>${lang.Ctrl}</kbd> + <kbd>=</kbd></td><td>${lang.Small || 'Small'}</td></tr>
              <tr><td><kbd>${lang.Ctrl}</kbd> + <kbd>S</kbd></td><td>${lang.Strikethrough || 'Strike-through'}</td></tr>
              <tr><td><kbd>${lang.Ctrl}</kbd> + <kbd>J</kbd></td><td>${lang.MarkedText || 'Marked text'}</td></tr>
              <tr><td><kbd>${lang.Ctrl}</kbd> + <kbd>H</kbd></td><td>${lang.HighlightText || 'Highlight text'}</td></tr>
              <tr><td><kbd>${lang.Ctrl}</kbd> + <kbd>_</kbd></td><td>${lang.HorizontalRule || 'Horizontal rule'}</td></tr>
              <tr><td><kbd>${lang.Alt}</kbd> + <kbd>S</kbd></td><td>${lang.SavePage || 'Save page'}</td></tr>
              <tr><td><kbd>${lang.Ctrl}</kbd>/<kbd>Alt</kbd> + <kbd>L</kbd></td><td>${lang.Hyperlink || 'Insert link'}</td></tr>
              <tr><td><kbd>${lang.Ctrl}</kbd> + <kbd>${lang.Shift}</kbd> + <kbd>N</kbd>/<kbd>O</kbd></td><td>${lang.NumberedList || 'Numbered list'}</td></tr>
              <tr><td><kbd>Enter</kbd> (inside list)</td><td>${lang.AutoList || 'Continue list automatically'}</td></tr>
			  <tr><td><kbd>${lang.Ctrl}</kbd> + <kbd>${lang.Space}</kbd><td>${lang.AutoList || 'Autocomplete'}</td></tr>
            </tbody>
          </table>
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
    this.helpModal.modal.showModal();
  }

  hideHelpModal() {
    if (this.helpModal) this.helpModal.modal.close();
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
      modal: panel,
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
    t.selectionStart = start;
    t.selectionEnd = t.selectionEnd;

    // Additional safety: approximate scroll position to center the match
    const textBefore = t.value.substring(0, start);
    const lineCount = (textBefore.match(/\n/g) || []).length + 1;

    const lineHeight = parseInt(getComputedStyle(t).lineHeight) || 20;
    const targetScroll = Math.max(0, lineCount * lineHeight - t.clientHeight * 0.4);

    t.scrollTop = targetScroll;
  }

  findNext() {
    try {
      const t = this.area;
      const f = this.findForm;
      if (!f || !f.findInput || !f.findInput.value || !t) return;

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
        this.scrollToSelection();
      }
    } catch (err) {
      Log.error('WikiEdit findNext error:', err);
      alert(lang?.FindReplaceError || 'An error occurred during find operation.');
    }
  }

  replaceCurrent() {
    try {
      const t = this.area;
      const f = this.findForm;
      if (!f || !f.findInput || !t) return;

      if (t.selectionStart === t.selectionEnd) {
        this.findNext();
        return;
      }

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

      const newValue = before + replacement + after;
      this.replaceContent(newValue);
      const newPos = before.length + replacement.length;
      t.setSelectionRange(newPos, newPos);

      this.scrollToSelection();
      this.findNext();
    } catch (err) {
      Log.error('WikiEdit replaceCurrent error:', err);
      alert(lang?.FindReplaceError || 'An error occurred during replace operation.');
      // do NOT call findNext() on generic error – we already pushed undo state
    }
  }

  replaceAll() {
    try {
      const t = this.area;
      const f = this.findForm;
      if (!f || !f.findInput || !t) return;

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
        this.replaceContent(newText);
        t.setSelectionRange(0, 0);
        t.focus();
      }
    } catch (err) {
      Log.error('WikiEdit replaceAll error:', err);
      alert(lang?.FindReplaceError || 'An error occurred during replace-all operation.');
    }
  }

  // ====================== localStorage HELPERS ======================
  loadPreferredHeight(textarea) {
    try {
      const saved = localStorage.getItem(this.HEIGHT_KEY);
      if (saved !== null) {
        return Math.max(300, Math.min(800, parseInt(saved, 10)));
      }
      const dataH = textarea?.dataset.editorHeight;
      if (dataH) {
        return Math.max(300, Math.min(800, parseInt(dataH, 10)));
      }
    } catch (e) {}
    return this.DEFAULT_HEIGHT;
  }

  safeSetHeight(value) {
    try {
      localStorage.setItem(this.HEIGHT_KEY, value);
      return true;
    } catch (err) {
      this._handleStorageError(err, 'editor height');
      return false;
    }
  }

  changeEditorHeight(delta) {
    let newH = this.preferredHeight + delta;
    newH = Math.max(300, Math.min(800, newH));
    this.preferredHeight = newH;

    if (this.splitContainer) {
      this.splitContainer.style.height = `${newH}px`;
      this.splitContainer.style.minHeight = `${Math.max(300, newH)}px`;
    } else {
      this.area.style.height = `${newH}px`;
    }

    this.safeSetHeight(newH);

    if (typeof this.updateStatus === 'function') this.updateStatus();
  }

  clearEditorSettings() {
    try { localStorage.removeItem(this.HEIGHT_KEY); } catch {}
    Log.info('[WikiEdit] Editor height reset to server default');
    window.location.reload();
  }

  // ── Autosave Draft ────────────────────────────────────────────────────────────
  safeSetDraft(key, value) {
    try {
      localStorage.setItem(key, value);
      return true;
    } catch (err) {
      this._handleStorageError(err, 'draft');
      return false;
    }
  }

  safeGetDraft(key) {
    try {
      return localStorage.getItem(key);
    } catch {
      return null;
    }
  }

  safeRemoveDraft(key) {
    try {
      localStorage.removeItem(key);
    } catch {}
  }

  _handleStorageError(err, context) {
    if (err.name === 'QuotaExceededError' ||
      err.name === 'NS_ERROR_DOM_QUOTA_REACHED' ||
      err.code === 22 || err.code === 1014) {
      Log.warn(`[WikiEdit] localStorage quota exceeded – ${context} not saved`);
    } else {
      Log.warn(`[WikiEdit] localStorage unavailable (private mode?) – ${context} skipped`);
    }
  }

  // ===================================================================
  // Critical Fields helpers
  // ===================================================================
  setModified() {
    if (this.cf_modified) return;
    this.cf_modified = true;
    this.area.style.borderColor = '#eecc99';
    this.area.title = lang.ModifiedHint || 'Modified – unsaved changes';
  }

  checkCf() {
    if (this.cf_modified) {
      return '\n' + (lang.NotSavedWarning || 'You have unsaved changes!') + '\n';
    }
    return null;
  }

  ignoreModified() {
    window.onbeforeunload = null;
    this.cf_modified = false;
    this.area.style.borderColor = '';
    this.area.title = '';
  }

  // ====================== LIVE PREVIEW ======================
  /**
   * Sets up side-by-side layout + draggable splitter + FULL bidirectional scroll sync
   * that survives preview updates. Now with proper height forcing so scrolling actually appears.
   */
  enableLivePreview() {
    const wrapper = this.area.parentNode;

    // Use hybrid preferredHeight (already set in init())
    const originalHeight = `${this.preferredHeight}px`;

    // Create split container
    const container = document.createElement('div');
    container.className = 'wikiedit-split-container';
    container.style.cssText = `display:flex; height:${originalHeight}; min-height:300px; gap:8px; box-sizing:border-box;`;

    this.editPane = document.createElement('div');
    this.editPane.style.cssText = 'flex:1 1 50%; min-width:300px; display:flex; flex-direction:column; height:100%;';

    // Move textarea and FORCE it to fill the pane
    this.area.style.cssText += 'flex:1 1 auto; height:100%; width:100%; box-sizing:border-box; resize:none; min-height:0;';
    this.editPane.appendChild(this.area);

    this.splitter = document.createElement('div');
    this.splitter.style.cssText = 'width:6px; background:#ddd; cursor:col-resize; flex-shrink:0; display:none;';

    this.previewPane = document.createElement('div');
    this.previewPane.id = 'wikiedit-live-preview';
    this.previewPane.style.cssText = 'flex:1 1 50%; min-width:300px; overflow:auto; padding:20px; border:1px solid #ccc; display:none; box-sizing:border-box;';

    // Store reference for changeEditorHeight()
    this.splitContainer = container;

    container.append(this.editPane, this.splitter, this.previewPane);
    wrapper.appendChild(container);

    // Draggable splitter
    let isDragging = false;
    this.splitter.addEventListener('mousedown', e => { isDragging = true; e.preventDefault(); });
    document.addEventListener('mousemove', e => {
      if (!isDragging) return;
      const rect = container.getBoundingClientRect();
      let percent = ((e.clientX - rect.left) / rect.width) * 100;
      percent = Math.max(20, Math.min(80, percent));
      this.editPane.style.flex = `1 1 ${percent}%`;
      this.previewPane.style.flex = `1 1 ${100 - percent}%`;
    });
    document.addEventListener('mouseup', () => { isDragging = false; });

    // === BIDIRECTIONAL VERTICAL SCROLL SYNC ===
    let syncing = false;

    this.syncEditorToPreview = () => {
      if (!this.livePreviewEnabled || syncing) return;
      syncing = true;
      const editor = this.area;
      const preview = this.previewPane;
      const percent = (editor.scrollHeight > editor.clientHeight)
        ? editor.scrollTop / (editor.scrollHeight - editor.clientHeight)
        : 0;
      preview.scrollTop = percent * (preview.scrollHeight - preview.clientHeight || 0);
      syncing = false;
    };

    this.syncPreviewToEditor = () => {
      if (!this.livePreviewEnabled || syncing) return;
      syncing = true;
      const editor = this.area;
      const preview = this.previewPane;
      const percent = (preview.scrollHeight > preview.clientHeight)
        ? preview.scrollTop / (preview.scrollHeight - preview.clientHeight)
        : 0;
      editor.scrollTop = percent * (editor.scrollHeight - editor.clientHeight || 0);
      syncing = false;
    };

    this.area.addEventListener('scroll', this.syncEditorToPreview, { passive: true });
    this.previewPane.addEventListener('scroll', this.syncPreviewToEditor, { passive: true });

    // Live preview logic
    this.livePreviewEnabled = false;
    this.previewTimer = null;

    this.updatePreview = async () => {
      const form = this.area.closest('form');
      if (!form) return;

      const fd = new FormData(form);
      fd.set('body', this.area.value);
      fd.set('ajax_preview', '1');

      try {
        const res = await fetch(this.ajaxUrl, {
          method: 'POST',
          body: fd,
          credentials: 'same-origin'
        });
        if (!res.ok) throw new Error();

        const data = await res.json();

        this.previewPane.innerHTML = data.preview_html || '';

        const tokenField = form.querySelector('input[name="_nonce"]');
        if (tokenField && data.new_form_token) {
          tokenField.value = data.new_form_token;
        }

        // Re-sync scroll AFTER browser has painted the new content
        if (this.livePreviewEnabled) {
          requestAnimationFrame(() => {
            this.syncEditorToPreview();
          });
        }
      } catch (e) {
        Log.warn('Live preview failed', e);
      }
    };

    // 100% reliable change detection (unchanged)
    const ta = this.area;
    const self = this;
    const valueDescriptor = Object.getOwnPropertyDescriptor(HTMLTextAreaElement.prototype, 'value');
    const origSetter = valueDescriptor.set;

    Object.defineProperty(ta, 'value', {
      get() { return valueDescriptor.get.call(this); },
      set(newValue) {
        origSetter.call(this, newValue);
        if (self.livePreviewEnabled && self.updatePreview) {
          clearTimeout(self.previewTimer);
          self.previewTimer = setTimeout(() => self.updatePreview(), 80);
        }
      },
      configurable: true
    });

    this.area.addEventListener('input', () => {
      if (this.livePreviewEnabled) {
        clearTimeout(this.previewTimer);
        this.previewTimer = setTimeout(() => this.updatePreview(), 420);
      }
    });
  }

  /**
   * Toggle Live Preview on/off
   */
  toggleLivePreview() {
    this.livePreviewEnabled = !this.livePreviewEnabled;

    const tb = document.getElementById(`tb_${this.id}`);
    const liveLi = tb ? tb.querySelector('li.we-livepreview') : null;
    if (liveLi) liveLi.classList.toggle('active', this.livePreviewEnabled);

    if (this.livePreviewEnabled) {
      this.previewPane.style.display = 'block';
      this.splitter.style.display = 'block';
      this.editPane.style.flex = '1 1 50%';
      this.previewPane.style.flex = '1 1 50%';

      if (this.area.value.trim()) {
        setTimeout(() => this.updatePreview(), 10);
      }
    } else {
      this.previewPane.style.display = 'none';
      this.splitter.style.display = 'none';
      this.editPane.style.flex = '1 1 100%';
    }

    // [b] Persist toggle state (exactly like toggleSyntaxHighlight())
    localStorage.setItem('we_live_preview_enabled', this.livePreviewEnabled);
  }

  // ==================== Markdown ↔ Wacko Converter (added) ====================
  /**
   * Wacko → Markdown (approximate)
   */
  wackoToMarkdown(text) {
    let md = text;

    // Headings (=== H2 → ##, ==== H3 → ### …)
    md = md.replace(/^={2,7}\s+(.*?)\s*={2,}$/gm, (m, title) => {
      const number = m.match(/^=+/)[0].length;
      const marker = '#'.repeat(number - 1);
      return marker + ' ' + title.trim();
    });

    // Bold (already compatible)
    // Italic
    md = md.replace(/\/\/(.*?)\/\//g, '*$1*');
    // Underline (GFM compatible)
    // Strikethrough
    md = md.replace(/--(.*?)--/g, '~~$1~~');
    // Inline code
    md = md.replace(/##(.*?)##/g, '`$1`');
    // Small text
    md = md.replace(/\+\+(.*?)\+\+/g, '<small>$1</small>');
    // Highlight / Marked text
    md = md.replace(/\?\?(.*?)\?\?/g, '**$1**');
    md = md.replace(/!!(.*?)!!/g, '**$1**');
    md = md.replace(/!!\([^)]+\)(.*?)!!/g, '$1'); // strip color

    // Quote <[ … ]>
    md = md.replace(/<\[(.*?)\]>/gs, '> $1');

    // Simple lists ( * → - )
    md = md.replace(/^(\s*)[*-]\s+/gm, '$1- ');

    // Links ((url text)) and [[page]]
    md = md.replace(/\(\(([^)]+?)\s+([^\)]+?)\)\)/g, '[$2]($1)');
    md = md.replace(/\[\[([^\]]+?)\]\]/g, '[$1]($1)');

    // HR
    md = md.replace(/^----$/gm, '---');

    // Code blocks %% … %%
    md = md.replace(/%%(.*?)%%/gs, '```\n$1\n```');

    // ==================== TABLES: Wacko → Markdown ====================
    md = md.replace(/#\|[\s\S]*?\|#/gs, (block) => this._wackoTableToMarkdown(block));
    md = md.replace(/#\|\|[\s\S]*?\|\|#/gs, (block) => this._wackoTableToMarkdown(block)); // no-border variant

    return md;
  }

  /**
     * Helper: single Wacko table block → Markdown table
     */
  _wackoTableToMarkdown(block) {
    const lines = block.split(/\r?\n/).filter(l => l.trim());
    const mdRows = [];

    let isFirstRow = true;

    for (let line of lines) {
      line = line.trim();
      if (!line || line === '#|' || line === '#||' || line === '|#' || line === '||#') continue;

      // Remove row prefix (*| ^| ||) and trailing ||
      let rowContent = line
        .replace(/^\s*(\*|\^|\|)\|?\s*/, '')           // remove prefix
        .replace(/\s*(\|\|?)\s*$/, '');                // remove trailing || or |

      // Strip cell attributes (colspan=, align=, etc.)
      rowContent = rowContent.replace(/\(\s*[^)]+\)\s*/g, '');

      // Escape pipe if it was ""|"" (Wacko escape)
      rowContent = rowContent.replace(/""/g, '\\|');

      const cells = rowContent.split('|').map(c => c.trim());

      if (cells.length < 2) continue; // not a table row

      const mdRow = '| ' + cells.join(' | ') + ' |';

      mdRows.push(mdRow);

      // Add separator after first row (assume it's header)
      if (isFirstRow) {
        const separator = '| ' + cells.map(() => '---').join(' | ') + ' |';
        mdRows.push(separator);
        isFirstRow = false;
      }
    }

    return mdRows.join('\n');
  }

  /**
   * Markdown → Wacko (approximate)
   */
  markdownToWacko(text) {
    let w = text;
    const placeholders = [];

    // Extract ```code blocks``` and replace with %%...%%
    w = w.replace(/```([\s\S]*?)```/g, (match, content) => {
      placeholders.push('%%' + content + '%%');
      return `@@CODEBLOCK_${placeholders.length - 1}@@`;
    });

    // Extract `inline code` and replace with ##...##
    w = w.replace(/`([^`]*)`/g, (match, content) => {
      placeholders.push('##' + content + '##');
      return `@@INLINECODE_${placeholders.length - 1}@@`;
    });

    // Markdown: ---, ***, ___, or any 3+ of them → Wacko: ----
    w = w.replace(/^(?:[-*_]){3,}[ \t]*$/gm, '----');

    // List normalization for WackoWiki syntax
    w = w.replace(
      /^(?!\s*----)(?!\s*\*\*)(\s*)([*+-]|\d+\.|[A-Za-z]\.)([ \t]*)/gm,
      (match, indent, marker, postSpace) => {
        const len = indent.length;
        let newIndent = indent;

        if (len % 4 === 0 && len >= 4) {
          newIndent = ' '.repeat(len / 2 + 2);
        } else if (len < 4) {
          newIndent = '  ';
        }

        return newIndent + marker + postSpace;
      }
    );

    // Headings
    w = w.replace(/^#{1,7}\s+(.*)$/gm, (m, title) => {
      const number = m.match(/^#+/)[0].length;
      const mkr = '='.repeat(number + 1);
      return mkr + ' ' + title + ' ' + mkr;
    });

    // Bold / Italic / Strikethrough / etc.
    w = w.replace(/\_\_(.*?)\_\_/g, '**$1**');
    w = w.replace(/~~(.*?)~~/g, '--$1--');
    w = w.replace(/<small>(.*?)<\/small>/g, '++$1++');

    // Images
    w = w.replace(/!\[([^\]]*)\]\(([^)]+)\)/g, '(($2 $1))');

    // Links
    w = w.replace(/\[([^\]]+)\]\(([^)]+)\)/g, '(($2 $1))');

    // ==================== TABLES ====================
    w = w.replace(/(\|.*\|\n\|[-:\s|]+\|\n(?:\|.*\|\n?)+)/gs, (block) => this._markdownTableToWacko(block));

    // Restore code blocks and inline code
    w = w.replace(/@@CODEBLOCK_(\d+)@@/g, (match, index) => placeholders[index]);
    w = w.replace(/@@INLINECODE_(\d+)@@/g, (match, index) => placeholders[index]);

    return w;
  }

  /**
   * Helper: single Markdown table block → Wacko table
   */
  _markdownTableToWacko(block) {
    const lines = block.trim().split(/\r?\n/);
    if (lines.length < 3) return block; // malformed

    let wacko = '#|\n'; // bordered table (most common)

    // Header row → *| ... |*
    const headerCells = lines[0]
      .split('|')
      .map(c => c.trim())
      .filter(c => c !== '');
    if (headerCells.length) {
      wacko += '*| ' + headerCells.join(' | ') + ' |*\n';
    }

    // Skip separator line (lines[1])

    // Data rows → || ... ||
    for (let i = 2;i < lines.length;i++) {
      const cells = lines[i]
        .split('|')
        .map(c => c.trim())
        .filter(c => c !== '');
      if (cells.length) {
        wacko += '|| ' + cells.join(' | ') + ' ||\n';
      }
    }

    wacko += '|#\n';
    return wacko;
  }

  /** One-click: Wacko → Markdown */
  convertToMarkdown() {
    if (!this.area) return;
    const original = this.area.value;
    const md = this.wackoToMarkdown(original);
	this.replaceContent(md);
    this.showMessage('✓ Wacko → Markdown');
  }

  /** One-click: Markdown → Wacko */
  convertToWacko() {
    if (!this.area) return;
    const original = this.area.value;
    const wacko = this.markdownToWacko(original);
	this.replaceContent(wacko);
    this.showMessage('✓ Markdown → Wacko');
  }

  /* ================================================================
    LIVE SYNTAX HIGHLIGHTING SETUP
    ================================================================ */
  setupSyntaxHighlighting() {
    const ta = this.area;

    if (!this.syntaxContainer) {
      this.syntaxContainer = document.createElement('div');
      this.syntaxContainer.className = 'syntax-container';

      this.highlighter = document.createElement('pre');
      this.highlighter.className = 'syntax-highlighter';

      this.syntaxContainer.appendChild(this.highlighter);
      const parent = ta.parentNode;
      parent.insertBefore(this.syntaxContainer, ta);
      this.syntaxContainer.appendChild(ta);   // textarea stays on top
    }

    // Copy all relevant styles from textarea to highlighter for perfect sync
    const style = getComputedStyle(ta);
    this.highlighter.style.font = style.font;
    this.highlighter.style.lineHeight = style.lineHeight;
    this.highlighter.style.tabSize = style.tabSize || '4';
    this.highlighter.style.letterSpacing = style.letterSpacing;
    this.highlighter.style.wordSpacing = style.wordSpacing;
    this.highlighter.style.padding = style.padding;
  }

  enableSyntaxHighlighting() {
    this.syntaxHighlightEnabled = true;
    this.area.classList.add('syntax-enabled');

    if (!this.syntaxContainer) this.setupSyntaxHighlighting();

    this.area.style.background = 'transparent';
    this.area.style.color = 'transparent';
    this.area.style.caretColor = 'var(--we-textarea-caret, #000)';

    this.highlighter.style.display = 'block';
    this.syncContentSize();
    this.refreshSyntaxHighlight();
  }

  disableSyntaxHighlighting() {
    this.syntaxHighlightEnabled = false;
    this.area.classList.remove('syntax-enabled');

    if (this.highlighter) this.highlighter.style.display = 'none';

    this.area.style.background = 'var(--we-textarea-bg, #fff)';
    this.area.style.color = 'var(--we-textarea-text, #222)';
    this.area.style.caretColor = 'var(--we-textarea-caret, #000)';
  }

  toggleSyntaxHighlight() {
    if (this.syntaxHighlightEnabled) {
      this.disableSyntaxHighlighting();
    } else {
      this.enableSyntaxHighlighting();
    }
    localStorage.setItem('we_syntax_enabled', this.syntaxHighlightEnabled);
  }

  _updateSyntaxHighlight() {
    if (this.syntaxHighlightEnabled) {
      setTimeout(() => this.refreshSyntaxHighlight(), 0);
    }
  }

  refreshSyntaxHighlight() {
    if (!this.syntaxHighlightEnabled || !this.highlighter) return;
    this.highlighter.innerHTML = this.highlightWikiSyntax(this.area.value) + '\n';
  }

  // Scroll synchronization + resize handling
  syncContentSize() {
    if (!this.highlighter || !this.area) return;

    const ta = this.area;
    const style = getComputedStyle(ta);

    const width = ta.clientWidth - parseFloat(style.paddingLeft) - parseFloat(style.paddingRight);
    const height = ta.clientHeight - parseFloat(style.paddingTop) - parseFloat(style.paddingBottom);
    const padding = parseFloat(style.padding) + parseFloat(style.borderTopWidth); // hack: workaround for ignoring border values for <pre>

    this.highlighter.style.width = `${width}px`;
    this.highlighter.style.height = `${height}px`;
    this.highlighter.style.padding = `${padding}px`;
  }

  highlightWikiSyntax(text) {
    if (!text) return '';

    let html = text
      .replace(/&/g, '&amp;')
      .replace(/</g, '&lt;')
      .replace(/>/g, '&gt;');

    // Extract all blocks in document order, prioritizing the first encountered
    const blocks = [];
    // Matches: 1. ""..."" 2. %%...%% 3. ``...`` (non-greedy, multi-line)
    html = html.replace(/(""[\s\S]*?""|%%[\s\S]*?%%|``[\s\S]*?``)/g, (match) => {
      const id = blocks.length;
      // If it starts with "", treat as literal (ignore syntax)
      if (match.startsWith('""')) {
        blocks.push({ type: 'literal', content: match });
      } else {
        // Otherwise, it's a code block to be wrapped
        blocks.push({ type: 'block', content: `<span class="wiki-block">${match}</span>` });
      }
      return `WIKI_TOKEN_${id}`;
    });

    // Apply syntax highlighting to the remaining text (inside "" blocks is protected)
    html = html.replace(/^(={3,7})(.+?)\1/gm, '<span class="wiki-h">$1$2$1</span>');
    html = html.replace(/\*\*(?!\s)(.+?)(?<!\s)\*\*/g, '<span class="wiki-bold">**$1**</span>');
    html = html.replace(/\/\/(?!\s)(.+?)(?<!\s)\/\//g, '<span class="wiki-italic">//$1//</span>');
    html = html.replace(/\+\+(?!\s)(.+?)(?<!\s)\+\+/g, '<span class="wiki-italic">++$1++</span>');
    html = html.replace(/__(?!\s)(.+?)(?<!\s)__/g, '<span class="wiki-underline">__$1__</span>');
    html = html.replace(/--(?!\s)(.+?)(?<!\s)--/g, '<span class="wiki-strike">--$1--</span>');
    html = html.replace(/##(?!\s)(.+?)(?<!\s)##/g, '<span class="wiki-code">##$1##</span>');
    html = html.replace(/\[\[(.+?)\]\]/g, '<span class="wiki-link">[[$1]]</span>');
    html = html.replace(/\(\((.+?)\)\)/g, '<span class="wiki-link">(($1))</span>');
    html = html.replace(/(file:((\.\.|!)\/|\/)?[\p{L}\p{Nd}][\p{L}\p{Nd}\/._-]*\.[\p{L}\p{Nd}]+(\?[a-zA-Z0-9&=]*)?)/ug, '<span class="wiki-link">$1</span>');
    html = html.replace(/(^([ ]{2}|\t)+(([*-]|\d+\.|[a-zA-Z]\.))[ \t]+)/gm, '<span class="wiki-list">$1</span>');
    html = html.replace(/&lt;\[.*?\]&gt;/gs, '<span class="wiki-block">$&</span>');
    html = html.replace(/(\{\{)(.+?)(\}\})/gs, '<span class="wiki-block">$1$2$3</span>');
    html = html.replace(/(\?\?)(?=\S)(.+?)(?<=\S)(\?\?)/gs, '<span class="wiki-block">$1$2$3</span>');
    html = html.replace(/(\!\!)(?=\S)(.+?)(?<=\S)(\!\!)/gs, '<span class="wiki-block">$1$2$3</span>');
    html = html.replace(/^----$/gm, '<span class="wiki-hr">----</span>');

    // Restore all blocks
    html = html.replace(/WIKI_TOKEN_(\d+)/g, (match, id) => {
      return blocks[parseInt(id, 10)].content;
    });

    return html;
  }

  // ====================== DRAG & DROP + PASTE MEDIA UPLOAD ======================
  handleDragOver(e) {
    e.preventDefault();
    e.stopPropagation();
    this.area.classList.add('dragover');           // optional visual feedback (see CSS below)
  }

  handleDrop(e) {
    e.preventDefault();
    e.stopPropagation();
    this.area.classList.remove('dragover');
    const files = e.dataTransfer.files;
    if (files && files.length) this.uploadMediaFiles(files);
  }

  handlePaste(e) {
    const items = e.clipboardData?.items || [];
    const files = [];
    for (let item of items) {
      if (item.kind === 'file') {
        const file = item.getAsFile();
        if (file) files.push(file);
      }
    }
    if (files.length) {
      e.preventDefault();   // prevent plain text paste
      this.uploadMediaFiles(files);
    }
  }

  // Trigger native file dialog (for the new toolbar button)
  triggerFileUpload() {
    const input = document.createElement('input');
    input.type = 'file';
    input.multiple = true;
    input.accept = 'image/*,*/*';   // all files
    input.onchange = (e) => {
      if (e.target.files.length) this.uploadMediaFiles(e.target.files);
    };
    input.click();
  }

  // Core upload function
  // ====================== DRAG & DROP + PASTE MEDIA UPLOAD ======================
  async uploadMediaFiles(files) {
    let uploadUrl = window.location.pathname.replace(/\/edit$/, '/upload');
    if (!uploadUrl.endsWith('/upload')) uploadUrl += '/upload';
    uploadUrl = window.location.origin + uploadUrl;

    for (let file of files) {
      const cursorPos = this.area.selectionStart;
      const placeholder = `[uploading ${file.name}...]`;
      this.insertAtCursor(placeholder);

      const formData = new FormData();
      formData.append('_nonce', this.area.dataset.uploadNonce || '');
      formData.append('_action', 'upload');
      formData.append('upload', '1');
      formData.append('ajax', '1');
      formData.append('upload_to', 'local');
      formData.append('file', file);

      try {
        const response = await fetch(uploadUrl, {
          method: 'POST',
          body: formData,
          credentials: 'same-origin'
        });

        let result = {};
        try { result = await response.json(); } catch (e) {}

        // Remove placeholder
        this.area.value = this.area.value.replace(placeholder, '');
        this.area.selectionStart = this.area.selectionEnd = cursorPos;

        if (response.ok && result.filename) {
          const isImage = file.type.startsWith('image/');
          const syntax = isImage
            ? `file:${result.filename}`
            : `((file:${result.filename} ${result.filename}))`;

          this.insertAtCursor(syntax + '\n');
          this.refreshSyntaxHighlight();
          this.showMessage(`✓ ${file.name} uploaded`);

          // Update nonce for the next file ===
          if (result.new_nonce) {
            this.area.dataset.uploadNonce = result.new_nonce;
          }
        } else {
          Log.error('Upload failed – server response:', result);
          this.showMessage(`✗ ${file.name}: ${result.error || 'Upload failed'}`, true);
        }
      } catch (err) {
        this.area.value = this.area.value.replace(placeholder, '');
        this.area.selectionStart = this.area.selectionEnd = cursorPos;
        this.showMessage(`✗ ${file.name} upload error`, true);
        Log.error(err);
      }
    }
  }

  // Helper: insert text at current cursor position
  insertAtCursor(text) {
    const ta = this.area;
    const start = ta.selectionStart;
    const end = ta.selectionEnd;
    const newValue = ta.value.substring(0, start) + text + ta.value.substring(end);
    this.replaceContent(newValue);
    ta.selectionStart = ta.selectionEnd = start + text.length;
    ta.focus();
  }

  /**
     * Safe content replacement with proper syncing
     * @param {string} newText - New content
     * @param {boolean} pushToUndo - Push current state to undo stack? (default: true)
     * @param {HTMLTextAreaElement} targetArea - Optional: use different textarea (default: this.area)
     */
  replaceContent(newText, pushToUndo = true, targetArea = null) {
    const area = targetArea || this.area;

    if (!area) return;

    if (pushToUndo) {
      this.pushState();
    }

    area.value = newText || '';

	// Core synchronization
    this._updateSyntaxHighlight();
    this.updateStatus();

	// Live preview refresh
    if (this.livePreviewEnabled && typeof this.updatePreview === 'function') {
      setTimeout(() => this.updatePreview(), 20);
    }

    // Trigger input event for other listeners
    area.dispatchEvent(new Event('input', { bubbles: true }));
  }

  /**
   * Returns localized relative time string
   */
  getRelativeTime(date) {
    const now = new Date();
    const diffMs = now - date;
    const diffSec = Math.floor(diffMs / 1000);

    if (diffSec < 60) {
      return this.lang?.JustNow || 'just now';
    }

    const diffMin = Math.floor(diffSec / 60);
    if (diffMin < 60) {
      return this._formatRelativeTime(diffMin, 'Minute');
    }

    const diffHour = Math.floor(diffMin / 60);
    if (diffHour < 24) {
      return this._formatRelativeTime(diffHour, 'Hour');
    }

    const yesterday = new Date(now);
    yesterday.setDate(yesterday.getDate() - 1);

    if (date.toDateString() === yesterday.toDateString()) {
      return this.lang?.Yesterday || 'yesterday';
    }

    const diffDay = Math.floor(diffHour / 24);
    if (diffDay < 30) {
      return this._formatRelativeTime(diffDay, 'Day');
    }

    // Fallback for older drafts
    return date.toLocaleDateString(this.lang?.Locale || undefined);
  }

  /**
   * Internal helper: Uses language templates like "vor %s Stunden" or "%s hours ago"
   */
  _formatRelativeTime(value, unit) {
      const isSingular = value === 1;

      // Try localized template first (e.g. 'vor %s Stunden' or '%s hours ago')
      const key = isSingular ? unit + 'Ago' : unit + 'sAgo';
      let template = this.lang?.[key];

      if (template) {
        return template
          .replace('%s', value)
          .replace('%1', value)
          .replace('%d', value);
      }

      // Fallback: Use singular/plural from language file
      if (isSingular) {
        return `1 ${this.lang?.[unit] || unit.toLowerCase()} ago`;
      } else {
        return `${value} ${this.lang?.[unit + 's'] || unit.toLowerCase() + 's'} ago`;
      }
    }

}
