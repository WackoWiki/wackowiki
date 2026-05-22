// src/utils/time.js

/**
 * Formats a date relative to now, using a translation function `t`.
 * @param {Date} date
 * @param {(key:string) => string} t
 * @returns {string}
 */
export function getRelativeTime(date, t) {
  const now = new Date();
  const diffSec = Math.floor((now - date) / 1000);

  if (diffSec < 60) return t('JustNow') || 'just now';

  const diffMin = Math.floor(diffSec / 60);
  if (diffMin < 60) return formatRelativeTime(diffMin, 'Minute', t);

  const diffHour = Math.floor(diffMin / 60);
  if (diffHour < 24) return formatRelativeTime(diffHour, 'Hour', t);

  const yesterday = new Date(now);
  yesterday.setDate(yesterday.getDate() - 1);
  if (date.toDateString() === yesterday.toDateString()) {
    return t('Yesterday') || 'yesterday';
  }

  const diffDay = Math.floor(diffHour / 24);
  if (diffDay < 30) return formatRelativeTime(diffDay, 'Day', t);

  return date.toLocaleDateString(t('Locale') || undefined);
}

/**
 * @param {number} value
 * @param {string} unit
 * @param {(key:string) => string} t
 * @returns {string}
 */
function formatRelativeTime(value, unit, t) {
  const isSingular = value === 1;
  const key = isSingular ? unit + 'Ago' : unit + 'sAgo';
  const template = t(key);

  if (template) {
    return template
      .replace('%s', value)
      .replace('%1', value)
      .replace('%d', value);
  }

  // Fallback
  if (isSingular) {
    return `1 ${t(unit) || unit.toLowerCase()} ago`;
  } else {
    return `${value} ${t(unit + 's') || unit.toLowerCase() + 's'} ago`;
  }
}
