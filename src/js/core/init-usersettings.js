// js/core/init-usersettings.js
import Storage from '../utils/storage.js';

(function() {

  Log.log('%cUserSettings initializer loaded', 'color:#0066cc');

  // Toolbar Button
  function attachToolbarButton() {
    const btn = document.getElementById('btn-customize-toolbar');
    if (!btn || btn._listenerAttached) return;

    btn.addEventListener('click', function(e) {
      e.preventDefault();
      const config = this.dataset.toolbar || '[]';
      if (typeof ToolbarCustomizer !== 'undefined') {
        ToolbarCustomizer.open(config);
      }
    });

    btn._listenerAttached = true;
    Log.log('Toolbar customize button initialized');
  }

  // Clear LocalStorage Button
  function attachClearCacheButton() {
    const clearBtn = document.getElementById('clear_we_localstorage');
    if (!clearBtn || clearBtn._listenerAttached) return;

    clearBtn.addEventListener('click', function() {
      const statusEl = document.getElementById('we_localstorage_status');
      if (!statusEl) return;

      // Initialize Storage with appRoot from data attribute
      const appRoot = this.dataset.appRoot || '/';
      Storage.initStorage(appRoot);   // ensure correct prefix

      const cleared = Storage.clear();

      statusEl.style.color = 'green';
      statusEl.textContent = t('WeCacheCleared', cleared) ||
        `WeCacheCleared (${cleared} keys removed)`;

      setTimeout(() => {
        statusEl.textContent = '';
      }, 4000);
    });

    clearBtn._listenerAttached = true;
    Log.log('Clear cache button initialized');
  }

  function init() {
    attachToolbarButton();
    attachClearCacheButton();
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init);
  } else {
    init();
  }

  window.addEventListener('load', init);

})();