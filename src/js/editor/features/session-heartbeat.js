// src/js/editor/features/session-heartbeat.js

import logger from '../../utils/logger.js';

// Private state storage – keys are editor instances, values are heartbeat state objects
const heartbeatStates = new WeakMap();

function getState(editor) {
  if (!heartbeatStates.has(editor)) {
    heartbeatStates.set(editor, {
      timer: null,
      abortController: null,
      failCount: 0,
      name: ''
    });
  }
  return heartbeatStates.get(editor);
}

function clearState(editor) {
  heartbeatStates.delete(editor);
}

/**
 * Initialises the session heartbeat for the editor.
 * @param {import('../editor/wikiedit.js').WikiEdit} editor
 */
export function setupHeartbeat(editor) {
  const timeoutSec = parseInt(editor.area?.dataset.heartbeatTimeout, 10) || 0;
  const name = editor.area?.dataset.heartbeatName || 'edit';

  if (!timeoutSec || timeoutSec < 60) return;

  const state = getState(editor);
  state.name = name;
  state.timer = null;
  state.abortController = null;
  state.failCount = 0;

  const maxFails = 3;

  const heartbeat = async () => {
    // Abort any previous pending request
    if (state.abortController) {
      state.abortController.abort();
    }

    state.abortController = new AbortController();

    try {
      const url = `${window.location.pathname}?_autocomplete=1&rnd=${Date.now()}`;
      const response = await fetch(url, {
        method: 'GET',
        cache: 'no-cache',
        headers: { 'X-Requested-With': 'XMLHttpRequest' },
        credentials: 'same-origin',
        signal: state.abortController.signal
      });

      if (!response.ok) throw new Error(`HTTP ${response.status}`);

      // Reset failure count on success
      state.failCount = 0;
      logger.debug(`Heartbeat OK for "${name}"`);

    } catch (err) {
      if (err.name === 'AbortError') {
        logger.debug('Heartbeat request aborted');
        return;
      }

      state.failCount++;
      logger.warn(`Heartbeat failed (${state.failCount}/${maxFails}) for "${name}"`);

      if (state.failCount >= maxFails) {
        showSessionExpiredWarning(editor, name);
        stopHeartbeat(editor);
      }
    }
  };

  // Start interval
  state.timer = setInterval(heartbeat, timeoutSec * 1000);
  logger.debug(`Session heartbeat started for "${name}" every ${timeoutSec}s`);

  // Register cleanup
  editor._cleanupHeartbeat = () => cleanup(editor);
}

/**
 * Cleanup function for Session Heartbeat.
 * @param {import('../editor/wikiedit.js').WikiEdit} editor
 */
function cleanup(editor) {
  logger.info('SessionHeartbeat: cleaning up');

  const state = heartbeatStates.get(editor);
  if (!state) {
    logger.debug('SessionHeartbeat: no state to clean up');
    return;
  }

  // Abort any pending fetch
  if (state.abortController) {
    state.abortController.abort();
    state.abortController = null;
  }

  // Clear interval
  if (state.timer) {
    clearInterval(state.timer);
    state.timer = null;
    logger.debug('SessionHeartbeat: interval cleared');
  }

  // Remove state from WeakMap
  clearState(editor);

  // Clean up references on editor (still needed for destroy chain)
  delete editor._cleanupHeartbeat;

  logger.debug('SessionHeartbeat: cleanup finished');
}

/**
 * Stops the heartbeat timer and cleans up.
 * @param {import('../editor/wikiedit.js').WikiEdit} editor
 */
export function stopHeartbeat(editor) {
  const state = heartbeatStates.get(editor);
  if (!state) return;

  if (state.timer) {
    clearInterval(state.timer);
    state.timer = null;
    logger.info(`Session heartbeat stopped for "${state.name || 'unknown'}"`);
  }

  if (state.abortController) {
    state.abortController.abort();
    state.abortController = null;
  }
}

/**
 * Shows a session expired warning if the editor content was modified.
 * @param {import('../editor/wikiedit.js').WikiEdit} editor
 * @param {string} name - heartbeat name (e.g. 'edit')
 */
function showSessionExpiredWarning(editor, name) {
  if (!editor.cf_modified) {
    logger.debug('Session expired, but no changes detected – skipping warning');
    return;
  }

  const msg = t('SessionExpiredEditor') || 'Your session has expired. Please save your changes to avoid losing data.';

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

  const target = document.getElementsByName(name)[0] || editor.area;
  if (target?.parentNode) {
    target.parentNode.insertBefore(div, target);
  }

  // Save Draft button
  div.querySelector('.btn-save-draft').addEventListener('click', () => {
    if (typeof editor.saveDraft === 'function') editor.saveDraft();
    div.remove();
  });

  // Reload Page button
  div.querySelector('.btn-reload').addEventListener('click', () => {
    if (confirm(t('ConfirmReload') || 'Reload page? Unsaved changes will be lost.')) {
      window.location.reload();
    }
  });

  // Dismiss button
  div.querySelector('.btn-dismiss').addEventListener('click', () => div.remove());

  // Also show a browser alert for extra visibility
  alert(msg);

  // Disable main submit buttons
  document.querySelectorAll('button[type="submit"], .btn-primary, .btn-save, .btn-publish').forEach(btn => {
    if (!btn.classList.contains('btn-save-draft')) btn.disabled = true;
  });

  logger.warn('Session expired warning displayed');
}
