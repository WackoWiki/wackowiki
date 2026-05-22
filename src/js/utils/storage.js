// src/utils/storage.js

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
 * Set a value safely.
 * @param {string} key
 * @param {string} value
 * @returns {boolean}
 */
export function safeSetItem(key, value) {
  try {
    localStorage.setItem(key, value);
    return true;
  } catch (err) {
    handleStorageError(err, key);
    return false;
  }
}

/**
 * Get a value safely.
 * @param {string} key
 * @returns {string|null}
 */
export function safeGetItem(key) {
  try {
    return localStorage.getItem(key);
  } catch {
    return null;
  }
}

/**
 * Remove a key safely.
 * @param {string} key
 */
export function safeRemoveItem(key) {
  try {
    localStorage.removeItem(key);
  } catch {}
}

/**
 * Load a preferred numeric value from localStorage, falling back to
 * a data attribute on the element and finally a default.
 *
 * @param {HTMLElement} element
 * @param {string} storageKey
 * @param {string} dataAttr   e.g. 'editorHeight'
 * @param {number} min
 * @param {number} max
 * @param {number} defaultValue
 * @returns {number}
 */
export function loadPreferredNumber(element, storageKey, dataAttr, min, max, defaultValue) {
  try {
    const saved = localStorage.getItem(storageKey);
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
