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
	while (ob_get_level() > 0) {
		ob_end_clean();
	}

	$token_name = match($_GET['token_name'])
	{
		'add_comment'	=> 'add_comment',
		default			=> 'edit_page'
	};

	$new_nonce = $this->sess->create_nonce($token_name, max(30, $this->db->form_token_time));

	header('Content-Type: application/json; charset=utf-8');
	header('Cache-Control: no-cache, no-store, must-revalidate');

	echo json_encode([
		'new_nonce' => $new_nonce,
		'status'    => 'ok'
	], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

	exit;
}

// Fallback
header('Content-Type: application/json; charset=utf-8');
http_response_code(400);
echo json_encode([
	'status'  => 'error',
	'message' => 'Invalid request'
]);
exit;