/**
 * Shared Logging Helper for WackoWiki
 * - DEBUG_MODE can be controlled globally
 * - Errors are always shown
 * - Debug/info/success messages can be muted in production
 */
window.Log = (function() {
  const isDebug = () => window.DEBUG_MODE === true;

  return {
    debug: (...args) => { if (isDebug()) console.debug(...args); },
    log: (...args) => { if (isDebug()) console.log(...args); },
    info: (...args) => { if (isDebug()) console.info(...args); },
    warn: (...args) => { if (isDebug()) console.warn(...args); },
    error: (...args) => { console.error(...args); },           // always visible
    success: (...args) => { if (isDebug()) console.log('%c✓', 'color:#28a745;font-weight:bold', ...args); }
  };
})();

// Default setting: Enable debug on localhost / when ?debug=1 is in URL
window.DEBUG_MODE = window.DEBUG_MODE ??
  (location.hostname === 'localhost' ||
    location.hostname === '127.0.0.1' ||
    new URLSearchParams(location.search).has('debug'));

// Global configuration variables
let wikiedit;   // WikiEdit instance or config

// Main initializer – called on page load
function all_init() {
  if (wikiedit) we_init(wikiedit);           // we_init is defined by WikiEdit class
}

// Refresh FreeCap (CAPTCHA) image
function new_freecap() {
  const img = document.getElementById('freecap');
  if (!img) return;

  let src = img.src;
  const separator = src.includes('?page=') ? '&' : '?';

  // Remove previous freecap parameter if present
  if (src.includes('freecap' + separator)) {
    src = src.substring(0, src.lastIndexOf(separator));
  }

  // Append random number 
  img.src = src + separator + Math.round(Math.random() * 100000);
}

/**
 * Double-click to edit - Supports main page + root-level comments
 */
(function() {
  let editBaseUrl = null;

  function initDoubleClick() {
    // Read from data attribute set by template
    editBaseUrl = document.documentElement.dataset.editUrl;

    if (!editBaseUrl) {
      Log.debug('Double-click to edit: disabled (no editUrl)');
      return;
    }

    const contentArea = document.getElementById('section-content');
    if (!contentArea) return;

    // Skip on edit pages
    if (contentArea.querySelector('form[name="edit"], form.edit')) return;

    document.addEventListener('dblclick', handleDoubleClick, { capture: true });
    Log.info('Double-click to edit enabled');
  }

  function handleDoubleClick(e) {
    let el = e.target;

    while (el && el !== document.body) {
      if (el.classList && el.classList.contains('dbclick')) {
        let targetUrl;

        if (el.id && el.id.startsWith('Comment')) {
          // Comment case: always root-level comment page
          const commentTag = el.id;                    // "Comment4554"

          // Build correct URL using base_path + comment tag
          const base = document.documentElement.dataset.basePath || '';
          targetUrl = base + commentTag + '/edit';
        } else {
          // Main page case
          targetUrl = editBaseUrl;
        }

        Log.success('Double-click → ' + targetUrl);
        window.location.href = targetUrl;
        return;
      }
      el = el.parentNode;
    }
  }

  // Initialize
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initDoubleClick);
  } else {
    initDoubleClick();
  }
})();

// Toggle all checkboxes in a form
function invertSelections(eid) {
  const form = document.getElementById(eid);
  if (!form) return;

  for (const el of form.elements) {
    if (el.type === 'checkbox') {
      el.checked = !el.checked;
    }
  }
}

// Auto-initialise everything when the page finishes loading
window.addEventListener('load', all_init);
