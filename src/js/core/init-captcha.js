(function() {

  Log.log('%cCaptcha initializer loaded', 'color:#0066cc');

  function initCaptchaReload() {
    const reloadBtn = document.getElementById('reload-captcha');
    if (!reloadBtn || reloadBtn._listenerAttached) return;

    reloadBtn.addEventListener('click', function(e) {
      e.preventDefault();
      this.blur();                    // same as before
      new_freecap();                  // existing function
    });

    reloadBtn._listenerAttached = true;
    Log.log('Captcha reload button initialized');
  }

  // Run on DOM ready + safety net
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initCaptchaReload);
  } else {
    initCaptchaReload();
  }

  window.addEventListener('load', initCaptchaReload);

})();

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