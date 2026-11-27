<?php

if (!defined('IN_WACKO'))
{
	exit;
}

/**
 * Dedicated CSRF / Nonce Refresh Handler
 * Uses GET + _csrf=1 to bypass normal POST token validation (like _autocomplete)
 */
if (isset($_GET['_csrf']) && $_GET['_csrf'] === '1')
{
	// The JSON publisher discards any partial response before writing the
	// response. The shutdown finalizer will flush it.

	$token_name = match($_GET['token_name'])
	{
		'add_comment'	=> 'add_comment',
		default			=> 'edit_page'
	};

	$new_nonce = $this->sess->create_nonce($token_name, max(30, $this->db->form_token_time));

	$this->http->json_response([
		'new_nonce' => $new_nonce,
		'status'    => 'ok'
	]);

	exit;
}

// Fallback
$this->http->json_response([
	'status'  => 'error',
	'message' => 'Invalid request'
], 400);
exit;