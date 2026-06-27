// src/js/editor/features/nonce-refresh.js

const NONCE_REFRESH_INTERVAL = 1 * 60 * 1000; // 8 minutes

export async function refreshMainNonce(editor) {
    const form = editor?.area?.closest('form');
    if (!form) return null;

    try {
        const tokenName = form.querySelector('input[name="_nonce"]')?.dataset?.tokenName 
                       || (form.getAttribute('action')?.includes('_addcomment') ? 'add_comment' : 'edit_page');

        // Build URL like autocomplete pattern
        let base = window.location.pathname.split('?')[0];
        base = base.replace(/\/_[^/]+$/, '');   // remove _edit, _addcomment etc.

        const handlerUrl = base.replace(/\/$/, '') + '/_csrf?_csrf=1&token_name=' 
                        + encodeURIComponent(tokenName) 
                        + '&rnd=' + Date.now();   // cache buster

        Log.debug('[NonceRefresh] Calling:', handlerUrl);

        const res = await fetch(handlerUrl, {
            method: 'GET',
            credentials: 'same-origin'
        });

        const text = await res.text();
        Log.debug('[NonceRefresh] Raw response:', text.substring(0, 300));

        if (!res.ok) throw new Error(`HTTP ${res.status}`);

        const data = JSON.parse(text);

        if (data.status === 'ok' && data.new_nonce) {
            const tokenField = form.querySelector('input[name="_nonce"]');
            if (tokenField) {
                tokenField.value = data.new_nonce;
                Log.debug('[NonceRefresh] ✓ Success');
                return data.new_nonce;
            }
        }
    } catch (e) {
        Log.warn('[NonceRefresh] Failed', e);
    }
    return null;
}

export function startPeriodicNonceRefresh(editor) {
    if (editor._nonceRefreshInterval) return;

    editor._nonceRefreshInterval = setInterval(() => {
        refreshMainNonce(editor);
    }, NONCE_REFRESH_INTERVAL);

    Log.debug('[NonceRefresh] Periodic refresh started (every 8 min)');
}

export function stopPeriodicNonceRefresh(editor) {
    if (editor._nonceRefreshInterval) {
        clearInterval(editor._nonceRefreshInterval);
        delete editor._nonceRefreshInterval;
    }
}