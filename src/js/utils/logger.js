// src/utils/logger.js

/**
 * Environment detection for no-build (browser-only) deployments.
 * Priority:
 *   1. window.WikiEditConfig.debug (host app / PHP)
 *   2. URL flag: ?we_debug=1 (ad-hoc testing)
 *   3. localhost/127.0.0.1 (developer convenience)
 *   4. DEFAULT: false (safe for production)
 */
const getDebugState = () => {
  // 1. Explicit config from host application
  if (window.WikiEditConfig && typeof window.WikiEditConfig.debug === 'boolean') {
    return window.WikiEditConfig.debug;
  }

  // 2. URL override
  try {
    const params = new URLSearchParams(window.location.search);
    if (params.has('we_debug')) {
      return params.get('we_debug') !== '0';
    }
  } catch (e) { /* ignore */ }

  // 3. Localhost heuristic
  try {
    const host = window.location.hostname;
    if (host === 'localhost' || host === '127.0.0.1' || host === '::1') {
      return true;
    }
  } catch (e) { /* ignore */ }

  // 4. Safe default: logging is OFF
  return false;
};

const IS_DEBUG = getDebugState();
const PREFIX = '[WikiEdit]';
const noop = () => {};

/**
 * Build a logger method. In non-debug mode, returns a true no-op
 * (not even a function that checks a flag on every call).
 */
const makeLoggerMethod = (consoleMethod, customFn) => {
  if (!IS_DEBUG) return noop;
  if (typeof customFn === 'function') return customFn;
  return console[consoleMethod].bind(console, PREFIX);
};

const logger = {
  debug:  makeLoggerMethod('debug'),
  log:    makeLoggerMethod('log'),
  info:   makeLoggerMethod('info'),
  warn:   makeLoggerMethod('warn'),
  error:  makeLoggerMethod('error'),

  success: makeLoggerMethod('log', (...args) => {
    console.log('%c✓', 'color:#28a745;font-weight:bold', ...args);
  }),

  // Utility so other code can check mode at runtime
  isDebug: () => IS_DEBUG,
};

// Also expose on window for non-module / legacy usage
if (typeof window !== 'undefined') {
  window.WikiEdit = window.WikiEdit || {};
  window.WikiEdit.logger = logger;
}

export default logger;