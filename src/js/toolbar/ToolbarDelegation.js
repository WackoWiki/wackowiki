// src/toolbar/ToolbarDelegation.js

import logger from '../utils/logger.js';

/**
 * Sets up event delegation on the toolbar container.
 * Handles special toggle buttons (zenmode, livepreview, etc.) locally,
 * and lets normal buttons bubble to the original WikiEdit handler.
 *
 * @param {import('../core/WikiEdit.js').WikiEdit} editor
 */
export function setupToolbarDelegation(editor) {
  const tb = document.getElementById(`tb_${editor.id}`);
  if (!tb) return;

  // Remove any previous listener (safe for re-inits)
  tb.removeEventListener('click', delegationHandler);

  tb.addEventListener('click', delegationHandler, { capture: true });

  function delegationHandler(e) {
    const li = e.target.closest('li');
    if (!li) return;

    const action = li.dataset.action;
    if (!action) return;

    logger.debug(`Toolbar action: ${action}`);

    // Handle toggle buttons that need custom logic
    switch (action) {
      case 'zenmode':
        e.stopImmediatePropagation();
        editor.toggleZenMode();
        return;

      case 'livepreview':
        e.stopImmediatePropagation();
        editor.toggleLivePreview();
        return;

      case 'fullscreen':
        e.stopImmediatePropagation();
        editor.toggleFullscreen();
        return;

      case 'dark-toggle':
      case 'darkmode':
        e.stopImmediatePropagation();
        editor.toggleDarkMode();
        return;

      case 'syntax':
        e.stopImmediatePropagation();
        editor.toggleSyntaxHighlight();
        return;

      default:
        // Let the event bubble to ProtoEdit's generic handler
        break;
    }
  }
}
