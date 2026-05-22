// src/js/features/Modals.js

import logger from '../utils/logger.js';

/**
 * Sets up modal dialogs used by the editor.
 * @param {import('../core/WikiEdit.js').WikiEdit} editor
 */
export function setupModals(editor) {
  setupLinkModal(editor);
  setupTableModal(editor);
  setupFindReplaceModal(editor);
  setupHelpModal(editor);

  editor._cleanupModals = () => cleanup(editor);

  logger.debug('Modals: setup complete with cleanup registered');
}

/**
 * Cleanup function for Modals.
 * @param {import('../core/WikiEdit.js').WikiEdit} editor
 */
function cleanup(editor) {
  logger.info('Modals: cleaning up');

  // Close all open modals
  document.querySelectorAll('.modal, .overlay').forEach(modal => {
    modal.remove();
  });

  delete editor.showHelpModal;
  // delete other modal methods...

  delete editor._cleanupModals;

  logger.debug('Modals: cleanup finished');
}

// ── Link Modal ─────────────────────────────────────────────────────

function setupLinkModal(editor) {
  editor.showLinkForm = () => showLinkForm(editor);
  editor.hideLinkForm = () => hideLinkForm(editor);
  editor.insertLinkFromForm = () => insertLinkFromForm(editor);
  editor.createLink = (isAlt) => createLink(editor, isAlt);
}

function createLinkForm(editor) {
  const modal = document.createElement('dialog');
  modal.className = 'we-modal';

  const dialog = document.createElement('div');
  dialog.className = 'we-modal-dialog';
  dialog.innerHTML = `
    <div class="we-modal-header">
      <h3 class="we-modal-title">${t('Hyperlink') || 'Hyperlink'}</h3>
    </div>
    <div class="we-modal-body">
      <form id="we-link-form-${editor.id}">
        <div class="we-form-group">
          <label class="we-form-label" for="we-link-url-${editor.id}">${(t('Link') || 'Link') + ':'}</label>
          <input type="text" id="we-link-url-${editor.id}" class="we-form-input">
        </div>
        <div class="we-form-group">
          <label class="we-form-label" for="we-link-text-${editor.id}">${(t('TextForLinking') || 'Text for linking') + ':'}</label>
          <input type="text" id="we-link-text-${editor.id}" class="we-form-input">
        </div>
        <div class="we-modal-footer">
          <button type="submit" id="we-link-insert-${editor.id}" class="btn btn-primary">${t('Insert') || 'Insert'}</button>
          <button type="button" id="we-link-cancel-${editor.id}" class="btn btn-cancel">${t('Cancel') || 'Cancel'}</button>
        </div>
      </form>
    </div>
  `;

  modal.appendChild(dialog);
  document.body.appendChild(modal);

  const urlInput = document.getElementById(`we-link-url-${editor.id}`);
  const textInput = document.getElementById(`we-link-text-${editor.id}`);
  const cancelBtn = document.getElementById(`we-link-cancel-${editor.id}`);
  const formEl = document.getElementById(`we-link-form-${editor.id}`);

  editor.linkForm = { modal, urlInput, textInput, form: formEl };

  cancelBtn.addEventListener('click', () => {
    editor.hideLinkForm();
    editor.area.focus();
  });

  formEl.addEventListener('submit', (e) => {
    e.preventDefault();
    editor.insertLinkFromForm();
  });
}

function showLinkForm(editor) {
  if (!editor.linkForm) createLinkForm(editor);
  const f = editor.linkForm;
  const defaultValue = editor.sel || '';

  f.urlInput.value = defaultValue;
  f.textInput.value = defaultValue;

  editor.linkContext = {
    sel1: editor.sel1,
    sel2: editor.sel2,
    area: editor.area
  };

  f.modal.showModal();
  f.urlInput.focus();
  f.urlInput.select();
}

function hideLinkForm(editor) {
  if (editor.linkForm) {
    editor.linkForm.modal.close();
    editor.linkContext = null;
  }
}

function insertLinkFromForm(editor) {
  if (!editor.linkContext) return;
  const { sel1, sel2, area } = editor.linkContext;
  const f = editor.linkForm;

  let lnk = f.urlInput.value ?? '';
  let sl = f.textInput.value ?? '';
  let combined = lnk + ' ' + sl;

  if (!combined.trim()) {
    editor.hideLinkForm();
    area.focus();
    return;
  }

  const str = sel1 + '((' + combined + '))' + sel2;
  editor.replaceContent(str, true, area);
  const start = sel1.length;
  const end = str.length - sel2.length;
  area.setSelectionRange(start, end);
  area.focus();
  editor.hideLinkForm();
}

function createLink(editor, isAlt) {
  const t = editor.area;
  t.focus();
  editor.getDefines();

  if (!/\n/.test(editor.sel)) {
    if (isAlt) {
      const str = editor.sel1 + '((' + editor.sel.trim() + '))' + editor.sel2;
      editor.replaceContent(str);
      t.setSelectionRange(editor.sel1.length, str.length - editor.sel2.length);
      return true;
    }
    editor.showLinkForm();
    return true;
  }
  return false;
}

// ── Table Modal ────────────────────────────────────────────────────

function setupTableModal(editor) {
  editor.createTable = () => createTable(editor);
  editor.showTableForm = () => showTableForm(editor);
  editor.hideTableForm = () => hideTableForm(editor);
  editor.insertTableFromForm = () => insertTableFromForm(editor);
}

function createTableForm(editor) {
  const modal = document.createElement('dialog');
  modal.className = 'we-modal';

  const dialog = document.createElement('div');
  dialog.className = 'we-modal-dialog';
  dialog.innerHTML = `
    <div class="we-modal-header">
      <h3 class="we-modal-title">${t('InsertTable') || 'Insert Table'}</h3>
    </div>
    <div class="we-modal-body">
      <form id="we-table-form-${editor.id}">
        <div class="we-form-group">
          <label class="we-form-label" for="we-table-caption-${editor.id}">${t('TableCaption') || 'Table caption (optional):'}</label>
          <input type="text" id="we-table-caption-${editor.id}" class="we-form-input">
        </div>
        <div class="we-form-grid">
          <div class="we-form-group">
            <label class="we-form-label" for="we-table-cols-${editor.id}">${t('NumberColumns') || 'Number of columns:'}</label>
            <input type="number" id="we-table-cols-${editor.id}" value="4" min="1" class="we-form-input">
          </div>
          <div class="we-form-group">
            <label class="we-form-label" for="we-table-rows-${editor.id}">${t('NumberRows') || 'Number of rows:'}</label>
            <input type="number" id="we-table-rows-${editor.id}" value="3" min="1" class="we-form-input">
          </div>
        </div>
        <div class="we-form-checkboxes">
          <label class="we-checkbox-label">
            <input type="checkbox" id="we-table-colheader-${editor.id}">
            ${t('UseColumnHeaders') || 'Use column headers'}
          </label>
          <label class="we-checkbox-label">
            <input type="checkbox" id="we-table-rowheader-${editor.id}">
            ${t('UseRowHeaders') || 'Use row headers'}
          </label>
        </div>
        <div class="we-modal-footer">
          <button type="submit" id="we-table-insert-${editor.id}" class="btn btn-primary">${t('InsertTable') || 'Insert Table'}</button>
          <button type="button" id="we-table-cancel-${editor.id}" class="btn btn-cancel">${t('Cancel') || 'Cancel'}</button>
        </div>
      </form>
    </div>
  `;

  modal.appendChild(dialog);
  document.body.appendChild(modal);

  const colsInput = document.getElementById(`we-table-cols-${editor.id}`);
  const rowsInput = document.getElementById(`we-table-rows-${editor.id}`);
  const captionInput = document.getElementById(`we-table-caption-${editor.id}`);
  const colHeaderCheck = document.getElementById(`we-table-colheader-${editor.id}`);
  const rowHeaderCheck = document.getElementById(`we-table-rowheader-${editor.id}`);
  const cancelBtn = document.getElementById(`we-table-cancel-${editor.id}`);
  const formEl = document.getElementById(`we-table-form-${editor.id}`);

  editor.tableForm = { modal, colsInput, rowsInput, captionInput, colHeaderCheck, rowHeaderCheck, form: formEl };

  cancelBtn.addEventListener('click', () => {
    editor.hideTableForm();
    editor.area.focus();
  });

  formEl.addEventListener('submit', (e) => {
    e.preventDefault();
    editor.insertTableFromForm();
  });
}

function createTable(editor) {
  const t = editor.area;
  t.focus();
  editor.getDefines();
  editor.showTableForm();
  return true;
}

function showTableForm(editor) {
  if (!editor.tableForm) createTableForm(editor);
  const f = editor.tableForm;

  f.colsInput.value = '4';
  f.rowsInput.value = '3';
  f.captionInput.value = '';
  f.colHeaderCheck.checked = false;
  f.rowHeaderCheck.checked = false;

  editor.tableContext = {
    sel1: editor.sel1,
    sel2: editor.sel2,
    area: editor.area
  };

  f.modal.showModal();
  f.colsInput.focus();
  f.colsInput.select();
}

function hideTableForm(editor) {
  if (editor.tableForm) {
    editor.tableForm.modal.close();
    editor.tableContext = null;
  }
}

function buildWikiTable(cols, rows, caption, colHeader, rowHeader) {
  cols = Math.max(1, parseInt(cols) || 1);
  rows = Math.max(1, parseInt(rows) || 1);

  const lines = ['#|'];

  if (caption && caption.trim()) {
    lines.push(`?| ${caption.trim()} |?`);
  }

  if (colHeader) {
    const headerCells = rowHeader ? [''] : [];
    for (let c = 0; c < cols; c++) {
      headerCells.push(`${t('Header') || 'Header'} ${c + 1}`);
    }
    const chRow = '*| ' + headerCells.join(' | ') + ' |*';
    lines.push(chRow);
  }

  for (let r = 0; r < rows; r++) {
    const rowStart = rowHeader ? '^|' : '||';
    const rowCells = rowHeader ? [`${t('Header') || 'Header'} ${r + 1}`] : [];
    for (let c = 0; c < cols; c++) {
      rowCells.push(`${t('Cell') || 'Cell'}`);
    }
    const rowStr = rowStart + ' ' + rowCells.join(' | ') + ' ||';
    lines.push(rowStr);
  }

  lines.push('|#');
  return lines.join('\n');
}

function insertTableFromForm(editor) {
  if (!editor.tableContext) return;
  const { sel1, sel2, area } = editor.tableContext;
  const f = editor.tableForm;

  const cols = f.colsInput.value;
  const rows = f.rowsInput.value;
  const caption = f.captionInput.value;
  const colHeader = f.colHeaderCheck.checked;
  const rowHeader = f.rowHeaderCheck.checked;

  const tableStr = buildWikiTable(cols, rows, caption, colHeader, rowHeader);
  const insertStr = '\n' + tableStr + '\n';
  const newValue = sel1 + insertStr + sel2;

  editor.replaceContent(newValue);
  const cursorPos = sel1.length + insertStr.length;
  area.setSelectionRange(cursorPos, cursorPos);
  area.focus();

  editor.hideTableForm();
}

// ── Find/Replace Modal ─────────────────────────────────────────────

function setupFindReplaceModal(editor) {
  editor.showFindReplace = () => showFindReplace(editor);
  editor.hideFindReplace = () => hideFindReplace(editor);
  editor.findNext = () => findNext(editor);
  editor.replaceCurrent = () => replaceCurrent(editor);
  editor.replaceAll = () => replaceAll(editor);
}

function createFindReplaceForm(editor) {
  const panel = document.createElement('div');
  panel.className = 'we-find-panel';
  panel.innerHTML = `
    <div class="we-panel-header">
      <h3 class="we-panel-title">${t('SearchReplace') || 'Search and Replace'}</h3>
      <button type="button" id="we-find-close-${editor.id}" class="we-panel-close">✕</button>
    </div>
    <div class="we-panel-body">
      <div class="we-form-group">
        <label class="we-form-label" for="we-search-for-${editor.id}">${t('SearchFor') || 'Search for:'}</label>
        <input type="text" id="we-search-for-${editor.id}" class="we-form-input">
      </div>
      <div class="we-form-group">
        <label class="we-form-label" for="we-replace-with-${editor.id}">${t('ReplaceWith') || 'Replace with:'}</label>
        <input type="text" id="we-replace-with-${editor.id}" class="we-form-input">
      </div>
      <div class="we-form-options">
        <label class="we-checkbox-label">
          <input type="checkbox" id="we-find-case-${editor.id}" checked>
          ${t('MatchCase') || 'Match case'}
        </label>
        <label class="we-checkbox-label">
          <input type="checkbox" id="we-find-whole-${editor.id}">
          ${t('WholeWords') || 'Whole words only'}
        </label>
        <label class="we-checkbox-label">
          <input type="checkbox" id="we-find-regex-${editor.id}">
          ${t('UseRegex') || 'Regular expression'}
        </label>
      </div>
      <div class="we-panel-actions">
        <button type="button" id="we-find-next-${editor.id}" class="btn btn-primary">${t('FindNext') || 'Find Next'}</button>
        <button type="button" id="we-replace-btn-${editor.id}" class="btn">${t('Replace') || 'Replace'}</button>
        <button type="button" id="we-replace-all-${editor.id}" class="btn">${t('ReplaceAll') || 'Replace All'}</button>
      </div>
    </div>
  `;

  document.body.appendChild(panel);

  editor.findForm = {
    modal: panel,
    findInput: document.getElementById(`we-search-for-${editor.id}`),
    replaceInput: document.getElementById(`we-replace-with-${editor.id}`),
    matchCaseCheck: document.getElementById(`we-find-case-${editor.id}`),
    wholeWordCheck: document.getElementById(`we-find-whole-${editor.id}`),
    regexCheck: document.getElementById(`we-find-regex-${editor.id}`),
    btnNext: document.getElementById(`we-find-next-${editor.id}`),
    btnReplace: document.getElementById(`we-replace-btn-${editor.id}`),
    btnReplaceAll: document.getElementById(`we-replace-all-${editor.id}`),
    btnClose: document.getElementById(`we-find-close-${editor.id}`)
  };

  editor.findForm.btnNext.addEventListener('click', () => editor.findNext());
  editor.findForm.btnReplace.addEventListener('click', () => editor.replaceCurrent());
  editor.findForm.btnReplaceAll.addEventListener('click', () => editor.replaceAll());
  editor.findForm.btnClose.addEventListener('click', () => editor.hideFindReplace());

  editor.findForm.findInput.addEventListener('keydown', (e) => {
    if (e.key === 'Enter') {
      e.preventDefault();
      editor.findNext();
    }
  });
}

function showFindReplace(editor) {
  if (!editor.findForm) createFindReplaceForm(editor);
  const f = editor.findForm;
  editor.getDefines();
  f.findInput.value = editor.sel || '';
  f.replaceInput.value = '';
  f.modal.classList.add('show');
  f.findInput.focus();
  f.findInput.select();
}

function hideFindReplace(editor) {
  if (editor.findForm) {
    editor.findForm.modal.classList.remove('show');
  }
}

function scrollToSelection(editor) {
  const t = editor.area;
  if (!t) return;
  t.focus();
  const start = t.selectionStart;
  t.selectionStart = start;
  t.selectionEnd = t.selectionEnd;
  const textBefore = t.value.substring(0, start);
  const lineCount = (textBefore.match(/\n/g) || []).length + 1;
  const lineHeight = parseInt(getComputedStyle(t).lineHeight) || 20;
  const targetScroll = Math.max(0, lineCount * lineHeight - t.clientHeight * 0.4);
  t.scrollTop = targetScroll;
}

function findNext(editor) {
  try {
    const t = editor.area;
    const f = editor.findForm;
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
        alert(t('InvalidRegex') || 'Invalid regular expression.');
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
      scrollToSelection(editor);
    }
  } catch (err) {
    logger.error('WikiEdit findNext error:', err);
    alert(t('FindReplaceError') || 'An error occurred during find operation.');
  }
}

function replaceCurrent(editor) {
  try {
    const t = editor.area;
    const f = editor.findForm;
    if (!f || !f.findInput || !t) return;

    if (t.selectionStart === t.selectionEnd) {
      editor.findNext();
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
        editor.findNext();
        return;
      }
    } else {
      matches = matchCase
        ? selected === term
        : selected.toLowerCase() === term.toLowerCase();
    }

    if (!matches) {
      editor.findNext();
      return;
    }

    const replacement = f.replaceInput.value ?? '';
    const before = t.value.substring(0, t.selectionStart);
    const after = t.value.substring(t.selectionEnd);

    const newValue = before + replacement + after;
    editor.replaceContent(newValue);
    const newPos = before.length + replacement.length;
    t.setSelectionRange(newPos, newPos);

    scrollToSelection(editor);
    editor.findNext();
  } catch (err) {
    logger.error('WikiEdit replaceCurrent error:', err);
    alert(t('FindReplaceError') || 'An error occurred during replace operation.');
  }
}

function replaceAll(editor) {
  try {
    const t = editor.area;
    const f = editor.findForm;
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
        alert(t('InvalidRegex') || 'Invalid regular expression.');
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
      editor.replaceContent(newText);
      t.setSelectionRange(0, 0);
      t.focus();
    }
  } catch (err) {
    logger.error('WikiEdit replaceAll error:', err);
    alert(t('FindReplaceError') || 'An error occurred during replace-all operation.');
  }
}

// ── Help Modal ─────────────────────────────────────────────────────

function setupHelpModal(editor) {
  editor.showHelpModal = () => showHelpModal(editor);
  editor.hideHelpModal = () => hideHelpModal(editor);
}

function createHelpModal(editor) {
  const modal = document.createElement('dialog');
  modal.className = 'we-modal';

  const dialog = document.createElement('div');
  dialog.className = 'we-modal-dialog';
  dialog.innerHTML = `
    <div class="we-modal-header">
      <h3 class="we-modal-title">WikiEdit</h3>
    </div>
    <div class="we-modal-body">
      <a href="${editor.manual}${t('HelpFormattingPage') || 'Formatting'}" target="_blank">${t('HelpFormattingTip')}</a><br>
      <a href="${editor.manual}" target="_blank">Full Documentation</a><br>
      <a href="https://wackowiki.org/doc/Dev/Projects/WikiEdit" target="_blank">Project Page</a>
    </div>
    <div class="we-modal-header">
      <h3 class="we-modal-title">${t('KeyboardShortcuts') || 'Keyboard Shortcuts'}</h3>
    </div>
    <div class="we-modal-body" style="padding:20px; max-height:50vh; overflow-y:auto;">
      <table class="we-shortcuts-table" style="width:100%; border-collapse:collapse; font-size:13px;">
        <thead>
          <tr><th>${t('Shortcut') || 'Shortcut'}</th><th>${t('Action') || 'Action'}</th></tr>
        </thead>
        <tbody>
          <tr><td><kbd>${t('Ctrl')}</kbd> + <kbd>Z</kbd></td><td>${t('Undo') || 'Undo'}</td></tr>
          <tr><td><kbd>${t('Ctrl')}</kbd> + <kbd>${t('Shift')}</kbd> + <kbd>Z</kbd></td><td>${t('Redo') || 'Redo'}</td></tr>
          <tr><td><kbd>${t('Ctrl')}</kbd> + <kbd>F</kbd></td><td>${t('SearchReplace') || 'Search & Replace'}</td></tr>
          <tr><td><kbd>${t('Alt')}</kbd> + <kbd>I</kbd></td><td>${t('Indent') || 'Indent'}</td></tr>
          <tr><td><kbd>${t('Alt')}</kbd> + <kbd>U</kbd></td><td>${t('Outdent') || 'Outdent'}</td></tr>
          <tr><td><kbd>${t('Ctrl')}</kbd> + <kbd>1</kbd> … <kbd>6</kbd></td><td>${t('HeadingLevels') || 'Heading level 1–6'}</td></tr>
          <tr><td><kbd>${t('Ctrl')}</kbd> + <kbd>B</kbd></td><td>${t('Bold') || 'Bold'}</td></tr>
          <tr><td><kbd>${t('Ctrl')}</kbd> + <kbd>I</kbd></td><td>${t('Italic') || 'Italic'}</td></tr>
          <tr><td><kbd>${t('Ctrl')}</kbd> + <kbd>U</kbd></td><td>${t('Underline') || 'Underline'}</td></tr>
          <tr><td><kbd>${t('Ctrl')}</kbd> + <kbd>=</kbd></td><td>${t('Small') || 'Small'}</td></tr>
          <tr><td><kbd>${t('Ctrl')}</kbd> + <kbd>S</kbd></td><td>${t('Strikethrough') || 'Strike-through'}</td></tr>
          <tr><td><kbd>${t('Ctrl')}</kbd> + <kbd>J</kbd></td><td>${t('MarkedText') || 'Marked text'}</td></tr>
          <tr><td><kbd>${t('Ctrl')}</kbd> + <kbd>H</kbd></td><td>${t('HighlightText') || 'Highlight text'}</td></tr>
          <tr><td><kbd>${t('Ctrl')}</kbd> + <kbd>_</kbd></td><td>${t('HorizontalRule') || 'Horizontal rule'}</td></tr>
          <tr><td><kbd>${t('Alt')}</kbd> + <kbd>S</kbd></td><td>${t('SavePage') || 'Save page'}</td></tr>
          <tr><td><kbd>${t('Ctrl')}</kbd>/<kbd>Alt</kbd> + <kbd>L</kbd></td><td>${t('Hyperlink') || 'Insert link'}</td></tr>
          <tr><td><kbd>${t('Ctrl')}</kbd> + <kbd>${t('Shift')}</kbd> + <kbd>N</kbd>/<kbd>O</kbd></td><td>${t('NumberedList') || 'Numbered list'}</td></tr>
          <tr><td><kbd>Enter</kbd> (inside list)</td><td>${t('AutoList') || 'Continue list automatically'}</td></tr>
          <tr><td><kbd>${t('Ctrl')}</kbd> + <kbd>${t('Space')}</kbd></td><td>${t('Autocomplete') || 'Autocomplete'}</td></tr>
          <tr><td><kbd>${t('Ctrl')}</kbd> + <kbd>${t('Alt')}</kbd> + <kbd>Z</kbd></td><td>${t('ZenMode') || 'Zen mode'}</td></tr>
        </tbody>
      </table>
    </div>
    <div class="we-modal-footer">
      <button type="button" class="btn btn-primary">${t('Close') || 'Close'}</button>
    </div>
  `;

  modal.appendChild(dialog);
  document.body.appendChild(modal);

  editor.helpModal = { modal };

  const closeBtn = dialog.querySelector('button');
  if (closeBtn) {
    closeBtn.addEventListener('click', () => editor.hideHelpModal());
  }
}

function showHelpModal(editor) {
  if (!editor.helpModal) createHelpModal(editor);
  editor.helpModal.modal.showModal();
}

function hideHelpModal(editor) {
  if (editor.helpModal) editor.helpModal.modal.close();
}
