// Tiny legacy helper (still used in crit_init)
function undef(param) {
  return param;
}

// Global configuration variables
let wikiedit;   // WikiEdit instance or config
let dbclick = 'page';
var edit;       // URL to open on double-click
var timeout;    // session heartbeat interval in seconds
var ename;      // name of the editor form element

let cf_modified = false;   // track unsaved changes

// Main initializer – called on page load
function all_init() {
  if (wikiedit) we_init(wikiedit);           // we_init is defined by WikiEdit class
  if (dbclick) dclick();
  if (timeout) userSessionHeartbeat(timeout, ename);
}

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

// Double-click to edit
function dclick() {
  const pageShow = document.getElementById('section-content');
  if (!pageShow) return;

  // Skip double-click editing when a form is already present on the page
  if (pageShow.querySelector('#section-content form')) return;

  if (edit) {
    document.addEventListener('dblclick', mouseClick, { capture: true });
  }
}

function mouseClick(event) {
  let op = event.target;
  while (op && op.className !== dbclick && op.tagName !== 'BODY') {
    op = op.parentNode;
  }

  if (op && op.className === dbclick) {
    window.location.href = edit;
  }
}

// Toggle all checkboxes in a form
function invertSelections(eid) {
  const form = document.getElementById(eid);
  if (!form) return;

  for (const el of form.elements) {
    if (el.type === 'checkbox') {
      el.checked = !el.checked;
    }
  }
}

// Session heartbeat (keeps user session alive while editing)
function userSessionHeartbeat(duration, ename) {
  const intervalMs = duration * 1000;

  const sessioncounter = setInterval(async () => {
    try {
      const url = `${window.location.href}?_autocomplete=1&rnd=${Math.random()}`;

      const response = await fetch(url, {
        method: 'GET',
        cache: 'no-cache',
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
      });

      if (!response.ok) throw new Error(`HTTP ${response.status}`);
      // Success → do nothing

    } catch {
      // Session expired or network error
      const div = document.createElement('div');
      div.className = 'msg error';
      div.innerHTML = (lang.SessionExpiredEditor || 'Your session has expired.').replace(/\n/g, '<br>');

      const target = document.getElementsByName(ename)[0];
      if (target) target.prepend(div);

      alert(lang.SessionExpiredEditor || 'Your session has expired.');

      // Disable all save/cancel buttons
      document.querySelectorAll('.btn-ok, .btn-cancel').forEach(btn => {
        btn.disabled = true;
      });

      clearInterval(sessioncounter);
    }
  }, intervalMs);
}


// Auto-initialise everything when the page finishes loading
window.addEventListener('load', all_init);
