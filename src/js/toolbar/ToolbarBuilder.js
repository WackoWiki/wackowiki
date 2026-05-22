// src/toolbar/ToolbarBuilder.js

import { getDefaultToolbarOrder } from './ToolbarConfig.js';
import logger from '../utils/logger.js';

/**
 * Load toolbar config (server JSON or default) and build the toolbar.
 * @param {import('../core/WikiEdit.js').WikiEdit} editor
 */
export function loadAndBuildToolbar(editor) {
  let config = [];

  const serverJson = editor.area.dataset.toolbarButtons;
  if (serverJson) {
    try {
      config = JSON.parse(serverJson);
    } catch (e) {
      logger.warn('Invalid toolbar JSON from server');
    }
  }

  if (!config.length) {
    config = getDefaultToolbarOrder();
  }

  buildToolbar(editor, config);
}

/**
 * Build the toolbar DOM from the given config array.
 * This calls ProtoEdit's buildToolbar for standard buttons, then adds
 * the autocomplete button and rebuilds the toolbar DOM if needed.
 * @param {import('../core/WikiEdit.js').WikiEdit} editor
 * @param {string[]} configArray
 */
function buildToolbar(editor, configArray) {
  // Let ProtoEdit process the standard buttons (sets internal definitions)
  editor._protoBuildToolbar(configArray);

  // Add the autocomplete custom button
  if (editor.autocomplete) {
    editor.autocomplete.addButton();

    // Force a fresh toolbar DOM because the custom HTML has changed
    editor.toolbar = editor.createToolbar();

    const container = document.getElementById(`tb_${editor.id}`);
    if (container) {
      const oldUl = container.querySelector('.we-toolbar');
      if (oldUl) oldUl.remove();
      container.appendChild(editor.toolbar);
    }
  }

  // Attach special buttons (fullscreen icon, etc.)
  attachSpecialButtons(editor);

  // Re-attach autocomplete dropdown listeners
  if (editor.autocomplete) {
    setTimeout(() => {
      editor.autocomplete.attachDropdown();
    }, 50);
  }
}

/**
 * Attach fullscreen icon update logic and any other special button setup.
 * @param {import('../core/WikiEdit.js').WikiEdit} editor
 */
export function attachSpecialButtons(editor) {
  if (!editor.toolbar) return;

  // Fullscreen button icon swap
  const fsLi = editor.toolbar.querySelector('li.we-fullscreen');
  if (fsLi) {
    editor.fullscreenBtn = fsLi.querySelector('button');
    editor.fullscreenIcon = editor.fullscreenBtn?.querySelector('img') || editor.fullscreenBtn?.querySelector('.we-icon');
  }

  const updateFSIcon = () => {
    if (!editor.fullscreenIcon) return;
    const isFullscreen = !!document.fullscreenElement;
    editor.fullscreenIcon.innerHTML = isFullscreen
      ? '' // editor.icons.exitfullscreen (if available)
      : ''; // editor.icons.fullscreen
  };

  // Clean previous listener and attach fresh one
  document.removeEventListener('fullscreenchange', updateFSIcon);
  document.addEventListener('fullscreenchange', updateFSIcon);
  updateFSIcon();
}
