// js/utils/storage.js

let appPrefix = null;   // Module-level variable

/**
 * Generate a unique prefix per wiki instance (based on server-provided application root)
 */
export function initStorage(appRoot = '') {
  if (appPrefix) return; // already initialized

  const base = appRoot || '/';

  let hash = 0;
  for (let i = 0;i < base.length;i++) {
    hash = (hash << 5) - hash + base.charCodeAt(i);
    hash |= 0; // Convert to 32-bit integer
  }

  // Use positive hex string, take first 10 chars for a balance of uniqueness and brevity
  appPrefix = 'we_' + Math.abs(hash).toString(36).substring(0, 10) + '_';
  console.log(`[Storage] Using prefix: ${appPrefix} (root: ${base})`);
}

/**
 * @param {Error|DOMException} err
 * @param {string} context
 */
function handleStorageError(err, context) {
  if (
    err.name === 'QuotaExceededError' ||
    err.name === 'NS_ERROR_DOM_QUOTA_REACHED' ||
    err.code === 22 ||
    err.code === 1014
  ) {
    console.warn(`[WikiEdit] localStorage quota exceeded – ${context} not saved`);
  } else {
    console.warn(`[WikiEdit] localStorage unavailable – ${context} skipped`);
  }
}

/**
 * Main Storage API with per-wiki namespace
 */
const Storage = {

  /**
   * Save value (auto JSON + namespaced key)
   */
  set(key, value) {
    try {
      const fullKey = appPrefix + key;
      localStorage.setItem(fullKey, JSON.stringify(value));
      return true;
    } catch (err) {
      handleStorageError(err, key);
      return false;
    }
  },

  /**
   * Retrieve value (auto JSON parse + namespaced key)
   */
  get(key, defaultValue = null) {
    try {
      const fullKey = appPrefix + key;
      const item = localStorage.getItem(fullKey);
      return item !== null ? JSON.parse(item) : defaultValue;
    } catch (err) {
      handleStorageError(err, key);
      return defaultValue;
    }
  },

  /**
   * Remove a key safely.
   * @param {string} key
   */
  remove(key) {
    try {
      const fullKey = appPrefix + key;
      localStorage.removeItem(fullKey);
    } catch (err) {}
  },

  /**
   * Clear only our keys for the current wiki instance
   * @returns {number} Number of keys cleared
   */
  clear() {
    let cleared = 0;
    try {
      if (!appPrefix) {
        initStorage(); // ensure prefix is initialized
      }

      Object.keys(localStorage).forEach(k => {
        if (k.startsWith(appPrefix)) {
          localStorage.removeItem(k);
          cleared++;
        }
      });
    } catch (err) {
      console.warn('[Storage] clear() failed:', err);
    }
    return cleared;
  },

  /**
   * Load a preferred numeric value from localStorage, falling back to
   * a data attribute on the element and finally a default.
   *
   * @param {HTMLElement} element
   * @param {string} storageKey
   * @param {string} dataAttr e.g. 'editorHeight'
   * @param {number} min
   * @param {number} max
   * @param {number} defaultValue
   * @returns {number}
   */
  loadPreferredNumber(element, storageKey, dataAttr, min, max, defaultValue) {
    try {
      const saved = this.get(storageKey);
      if (saved !== null) {
        return Math.max(min, Math.min(max, parseInt(saved, 10)));
      }
      const dataValue = element?.dataset?.[dataAttr];
      if (dataValue) {
        return Math.max(min, Math.min(max, parseInt(dataValue, 10)));
      }
    } catch {}
    return defaultValue;
  }
};

// Attach initStorage to the default export
Storage.initStorage = initStorage;

export default Storage;

