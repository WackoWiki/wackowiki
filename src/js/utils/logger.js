// src/utils/logger.js

const isProduction = () => {
  try { return process.env.NODE_ENV === 'production'; } catch { return false; }
};

const noop = () => {};

const logger = {
  debug: isProduction() ? noop : console.debug.bind(console, '[WikiEdit]'),
  log:   isProduction() ? noop : console.log.bind(console, '[WikiEdit]'),
  info:  isProduction() ? noop : console.info.bind(console, '[WikiEdit]'),
  warn:  console.warn.bind(console, '[WikiEdit]'),
  error: console.error.bind(console, '[WikiEdit]'),
  success: (...args) => {
    if (!isProduction()) {
      console.log('%c✓', 'color:#28a745;font-weight:bold', ...args);
    }
  }
};

export default logger;
