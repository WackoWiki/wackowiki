// src/js/core/init-diag.js

// ==================== WackoWiki Diag Console ====================

/**
 * Initialize debug console window
 * Reads log data from data attribute (CSP‑compliant)
 * Reuses existing window if already open
 */
(function() {
  // Local clipboard function
  async function copyToClipboard(text, targetWindow = window) {
    if (!text) return false;
    try {
      // Use the target window's navigator/document
      const nav = targetWindow.navigator;
      const isSecure = targetWindow.isSecureContext;

      // Skip Clipboard API in popups (where opener exists)
      if (nav.clipboard && isSecure && !targetWindow.opener) {
        await nav.clipboard.writeText(text);
        return true;
      }

      // Fallback for popups (works without focus)
      const doc = targetWindow.document;
      const textarea = doc.createElement('textarea');
      textarea.value = text;
      textarea.style.position = 'fixed';
      textarea.style.opacity = '0';
      doc.body.appendChild(textarea);
      textarea.select();
      const success = doc.execCommand('copy');
      doc.body.removeChild(textarea);
      return success;
    } catch (err) {
      console.error('Clipboard copy failed:', err);
      return false;
    }
  }

  function addButtonListeners(win) {
    const closeBtn = win.document.getElementById('debug-close-btn');
    const refreshBtn = win.document.getElementById('debug-refresh-btn');
    const copyBtn = win.document.getElementById('debug-copy-btn');

    if (closeBtn) {
      closeBtn.addEventListener('click', function() {
        win.close();
      });
    }

    if (refreshBtn) {
      refreshBtn.addEventListener('click', function() {
        win.location.reload();
      });
    }

    // === Copy Button with logging ===
    if (copyBtn) {
      copyBtn.addEventListener('click', async function() {
        win.focus(); // Ensure popup is focused (required for fallback)
        console.log('[Debug Console] Copy button clicked');

        const logContent = win.document.getElementById('debug-log-content');
        if (!logContent) {
          console.warn('[Debug Console] Copy failed: log content element not found');
          return;
        }

        const timestamp = new Date().toLocaleString('en-US', {
          year: 'numeric', month: '2-digit', day: '2-digit',
          hour: '2-digit', minute: '2-digit', second: '2-digit'
        });
        const fullLog = `=== WackoWiki Debug Log ===\n` +
          `Generated: ${timestamp}\n` +
          `================================\n\n` +
          logContent.textContent;

        console.log(`[Debug Console] Copying log with ${logContent.textContent.length} characters`);

        // Pass `win` to ensure clipboard operations use the popup's context
        const success = await copyToClipboard(fullLog, win);

        console.log(`[Debug Console] Copy operation result: ${success ? 'SUCCESS' : 'FAILED'}`);
        const originalText = copyBtn.textContent;
        copyBtn.textContent = success ? '✓ Copied!' : '✗ Failed';
        setTimeout(() => { copyBtn.textContent = originalText; }, 2000);
      });
    }
  }

  function getDebugConsoleCSSContent() {
    // Try to fetch the CSS content from the already-loaded stylesheet
    const cssLinks = document.querySelectorAll('link[rel="stylesheet"]');
    for (const link of cssLinks) {
      if (link.href && link.href.includes('debug-console.css')) {
        try {
          const styleSheet = link.sheet;
          if (styleSheet) {
            let cssText = '';
            const rules = styleSheet.cssRules || styleSheet.rules;
            for (const rule of rules) {
              cssText += rule.cssText + '\n';
            }
            return cssText;
          }
        } catch (e) {
          // CORS might prevent access
          console.warn('Cannot access stylesheet rules directly');
        }
        break;
      }
    }
    return null;
  }

  function buildPopupContent(logEntries, cssContent) {
    // Build table rows with properly escaped content
    const tableRows = logEntries.map(entry => {
      const escapedTime = Ut.escapeHtml(entry.time);
      const escapedLabel = Ut.escapeHtml(entry.label);
      const escapedMessage = Ut.escapeHtml(entry.message);

      // Color mapping for log levels
      const colors = {
        0: '#cccccc', // Default
        1: '#6666ff', // Blue
        2: '#ffd700', // Gold
        3: '#ff8c00', // Orange
        4: '#ff4444', // Red
        5: '#008000', // Green
        6: '#00FFFF', // Cyan
        7: '#800080', // Purple
        8: '#FFFF00'  // Yellow
      };
      const color = colors[entry.type] || '#cccccc';

      return `<tr>
        <td class="debug-console-timestamp">${escapedTime}</td>
        <td class="debug-console-label" style="color: ${color}"><code>${escapedLabel}</code></td>
        <td class="debug-console-message">${escapedMessage}</td>
      </tr>`;
    }).join('');

    // Embed CSS directly in the page
    const styleTag = cssContent ? `<style>\n${cssContent}\n</style>` : '';

    return `<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>WackoWiki Debug Console</title>
  ${styleTag}
</head>
<body class="debug-console-body">
  <div class="debug-console-controls">
    <button id="debug-copy-btn">📋 Copy</button>
    <button id="debug-refresh-btn">↻ Refresh</button>
    <button id="debug-close-btn">✕ Close</button>
  </div>
  <h1 class="debug-console-title">🔍 WackoWiki Debug Console</h1>
  <div id="debug-log-content">
    <table class="debug-console-table">
      ${tableRows}
    </table>
    <div class="debug-console-count">Total entries: ${logEntries.length}</div>
  </div>
</body>
</html>`;
  }

  function initDiagConsole(debugDataEl) {
    const logDataStr = debugDataEl.getAttribute('data-log');
    if (!logDataStr) return;

    try {
      const logEntries = JSON.parse(logDataStr);

      if (!logEntries || logEntries.length === 0) {
        return;
      }

      // Get CSS from loaded stylesheet
      const cssContent = getDebugConsoleCSSContent();

      // Use fixed window name to reuse existing window
      const windowName = 'WackoWikiConsoleWindow';

      // Check if window already exists and is open
      let debugConsole = window.open('', windowName,
        'height=500,width=800,location=no,menubar=no,status=no,toolbar=no,scrollbars=yes,resizable=yes');

      if (!debugConsole) {
        console.warn('Debug console popup was blocked. Please allow popups for this site.');

        // Fallback: Show debug data in main console
        console.group('📊 WackoWiki Debug Console (Popup Blocked - Showing in DevTools)');
        console.table(logEntries);
        console.groupEnd();

        return;
      }

      const doc = debugConsole.document;
      const html = buildPopupContent(logEntries, cssContent);

      // Parse the HTML and replace the document content
      const parser = new DOMParser();
      const newDoc = parser.parseFromString(html, 'text/html');

      doc.replaceChild(
        doc.importNode(newDoc.documentElement, true),
        doc.documentElement
      );

      // Add event listeners with small delay for popup DOM readiness
      setTimeout(() => {
        addButtonListeners(debugConsole);
      }, 150);

      // Ensure window gets focus
      debugConsole.focus();

      // ----‑‑‑‑‑‑‑‑‑‑‑‑‑‑‑‑‑‑‑‑‑‑‑‑‑‑‑‑‑‑‑‑‑‑‑‑‑‑‑‑‑‑‑‑‑‑‑‑‑‑‑‑‑‑‑‑‑‑-
      // Keep a reference only while the popup lives – remove it on close.
      // -----------------------------------------------------------------
      window._debugConsole = debugConsole;

      // Clean the data element from the main page
      debugDataEl.remove();

    } catch (e) {
      console.error('Failed to initialize debug console:', e);

      // Fallback: Show error and raw data in main console
      console.group('❌ Debug Console Error');
      console.error('Error:', e);
      console.log('Raw data:', logDataStr?.substring(0, 500));
      console.groupEnd();
    }
  }

  // -----------------------------------------------------------------
  // 1.  GLOBAL CLEAN‑UP – runs on hard navigation / page unload
  // -----------------------------------------------------------------
  const observer = new MutationObserver(function(mutations) {
    for (const mutation of mutations) {
      for (const node of mutation.addedNodes) {
        if (node.id === 'debug-console-data') {
          initDiagConsole(node);
          observer.disconnect();          // stop observing once we have it
          return;
        }
        if (node.querySelector) {
          const found = node.querySelector('#debug-console-data');
          if (found) {
            initDiagConsole(found);
            observer.disconnect();
            return;
          }
        }
      }
    }
  });

  observer.observe(document.documentElement, {
    childList: true,
    subtree: true
  });

  // -----------------------------------------------------------------
  // 2.  Ensure the popup reference and observer are released on unload
  // -----------------------------------------------------------------
  window.addEventListener('beforeunload', () => {
    if (window._debugConsole) {
      window._debugConsole.close();   // forces the popup to close
      delete window._debugConsole;    // drop the global reference
    }
    observer.disconnect();            // stop the MutationObserver for good
  });

  // -----------------------------------------------------------------
  // Immediate check – the element may already be in the DOM
  // -----------------------------------------------------------------
  const existingEl = document.getElementById('debug-console-data');
  if (existingEl) {
    initDiagConsole(existingEl);
  }
})();
