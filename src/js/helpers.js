// ==================== WackoWiki Global Helpers ====================
 
// Translation function (positional %1, %2 style - native to WackoWiki)
window.t = (key, ...args) => {
  let str = window.lang?.[key] || key;
 
  args.forEach((arg, index) => {
    str = str.replace(new RegExp(`%${index + 1}`, 'g'), arg);
  });
 
  return str;
};
 
// Optional: Also support named parameters as bonus
window.t_named = (key, params = {}) => {
  let str = window.lang?.[key] || key;
  Object.keys(params).forEach(key => {
    str = str.replace(new RegExp(`\\{\\{?${key}\\}?\\}`, 'g'), params[key]);
  });
  return str;
};


 
// You can add more helpers here later (formatBytes, escapeHtml, etc.)
window.Ut = window.Ut || {};

Ut.formatBytes = (bytes) => {
  if (!bytes) return '0 B';
  const k = 1024;
  const sizes = ['B', 'KB', 'MB', 'GB'];
  const i = Math.floor(Math.log(bytes) / Math.log(k));
  return parseFloat((bytes / Math.pow(k, i)).toFixed(1)) + ' ' + sizes[i];
};

Ut.escapeHtml = (str) => str.replace(/[&<>"']/g, m => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' })[m]);
