// src/features/DarkZenMode.js

import logger from '../utils/logger.js';

/**
 * Sets up dark mode and zen mode on the editor.
 * Call once during init, after the toolbar is built.
 * @param {import('../core/WikiEdit.js').WikiEdit} editor
 */
export function setupDarkZenMode(editor) {
  // Attach toggle methods so toolbar delegation can use them
  editor.toggleDarkMode = () => toggleDarkMode(editor);
  editor.toggleZenMode  = () => toggleZenMode(editor);

  // Provide a helper to update all toggle button states
  editor.updateToolbarButtonStates = () => updateToolbarButtonStates(editor);

  // Initialise states
  initDarkMode(editor);
  initZenMode(editor);
}

// ── Dark Mode ──────────────────────────────────────────────────────

function initDarkMode(editor) {
  const saved = localStorage.getItem('we_dark_mode_enabled');
  if (saved !== null) {
    const shouldBeDark = saved === 'true';
    applyDarkMode(shouldBeDark);
    // Reflect in toolbar
    const tb = document.getElementById(`tb_${editor.id}`);
    const darkLi = tb ? tb.querySelector('li.we-dark-toggle') : null;
    if (darkLi) darkLi.classList.toggle('active', shouldBeDark);
  }
  // If no saved preference, system preference is used via CSS (color-scheme)
}

function toggleDarkMode(editor) {
  const html = document.documentElement;
  const currentIsDark = html.getAttribute('data-theme') === 'dark';
  const newIsDark = !currentIsDark;

  applyDarkMode(newIsDark);

  // Toolbar button active state
  const tb = document.getElementById(`tb_${editor.id}`);
  const darkLi = tb ? tb.querySelector('li.we-dark-toggle') : null;
  if (darkLi) darkLi.classList.toggle('active', newIsDark);

  // Force repaint for smooth transition
  editor.area.style.transition = 'background 0.2s';
  setTimeout(() => { editor.area.style.transition = ''; }, 300);

  localStorage.setItem('we_dark_mode_enabled', newIsDark);
  logger.info('Dark mode toggled:', newIsDark ? 'dark' : 'light');
  updateToolbarButtonStates(editor);
}

function applyDarkMode(isDark) {
  document.documentElement.setAttribute('data-theme', isDark ? 'dark' : 'light');
}

// ── Zen Mode ───────────────────────────────────────────────────────

function isEditPage() {
  return !!(
    document.body.classList.contains('page-edit') ||
    document.getElementById('postText') ||
    window.location.href.includes('/_edit') ||
    document.querySelector('form[name="edit"]')
  );
}

function initZenMode(editor) {
  const isEdit = isEditPage();
  const prefix = isEdit ? '' : '_comment';

  const lsZen = localStorage.getItem(`we_zenmode${prefix}`);
  const lsWidescreen = localStorage.getItem(`we_widescreen${prefix}`);

  const userZen = document.documentElement.dataset.zenmode === '1';
  const userWidescreen = document.documentElement.dataset.widescreen === '1';

  const zenActive = lsZen !== null ? (lsZen === '1') : userZen;
  const widescreenActive = lsWidescreen !== null ? (lsWidescreen === '1') : userWidescreen;

  if (zenActive) document.body.classList.add('zenmode');
  if (widescreenActive) document.body.classList.add('widescreen');

  logger.log(`ZenMode init (${isEdit ? 'EDIT' : 'COMMENT'}): ${zenActive} | Widescreen: ${widescreenActive}`);
}

function toggleZenMode(editor) {
  const isEdit = isEditPage();
  const prefix = isEdit ? '' : '_comment';
  const body = document.body;
  const isCurrentlyZen = body.classList.contains('zenmode');

  if (!isCurrentlyZen) {
    body.classList.add('zenmode', 'widescreen');
    localStorage.setItem(`we_zenmode${prefix}`, '1');
    localStorage.setItem(`we_widescreen${prefix}`, '1');
    editor.showMessage('Zen mode enabled', 'success', 1600);
  } else {
    body.classList.remove('zenmode', 'widescreen');
    localStorage.setItem(`we_zenmode${prefix}`, '0');
    localStorage.setItem(`we_widescreen${prefix}`, '0');
    editor.showMessage('Zen mode disabled', 'info', 1600);
  }

  updateToolbarButtonStates(editor);
}

// ── Toolbar Button State Helper ────────────────────────────────────

function updateToolbarButtonStates(editor) {
  const tb = document.getElementById(`tb_${editor.id}`);
  if (!tb) return;

  const setActive = (selector, isActive) => {
    const li = tb.querySelector(selector);
    if (!li) return;
    const button = li.querySelector('button');
    const target = button || li;
    target.classList.toggle('active', !!isActive);
  };

  setActive('li.we-zenmode', document.body.classList.contains('zenmode'));
  setActive('li.we-livepreview', editor.livePreviewEnabled === true);
  setActive('li.we-syntax', editor.syntaxHighlightEnabled === true);
  setActive('li.we-dark-toggle', document.documentElement.getAttribute('data-theme') === 'dark');
  setActive('li.we-fullscreen', !!document.fullscreenElement);
}
