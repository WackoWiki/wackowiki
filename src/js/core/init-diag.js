// ==================== WackoWiki Diag Console ====================

/**
 * Initialize debug console window
 * Reads log data from data attribute (CSP-compliant)
 * Reuses existing window if already open
 */
(function() {
  function addButtonListeners(win) {
    const closeBtn = win.document.getElementById('debug-close-btn');
    const refreshBtn = win.document.getElementById('debug-refresh-btn');
    
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
        4: '#ff4444'  // Red
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
    <button id="debug-close-btn">✕ Close</button>
    <button id="debug-refresh-btn">↻ Refresh</button>
  </div>
  <h1 class="debug-console-title">🔍 WackoWiki Debug Console</h1>
  <table class="debug-console-table">
    ${tableRows}
  </table>
  <div class="debug-console-count">Total entries: ${logEntries.length}</div>
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
        'height=400,width=600,location=no,menubar=no,status=no,toolbar=no,scrollbars=yes,resizable=yes');
      
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
      
      // Add event listeners
      addButtonListeners(debugConsole);
      
      // Ensure window gets focus
      debugConsole.focus();
      
      // Prevent the window from being garbage collected
      window._debugConsole = debugConsole;

      // Clean up the data element from the main page
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

  // Check for element immediately
  const existingEl = document.getElementById('debug-console-data');
  if (existingEl) {
    initDiagConsole(existingEl);
  } else {
    // Set up MutationObserver for late-loading elements
    const observer = new MutationObserver(function(mutations) {
      for (const mutation of mutations) {
        for (const node of mutation.addedNodes) {
          if (node.id === 'debug-console-data') {
            initDiagConsole(node);
            observer.disconnect();
            return;
          }
          // Also check descendants
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
    
    // Start observing
    observer.observe(document.documentElement, {
      childList: true,
      subtree: true
    });
  }
})();
