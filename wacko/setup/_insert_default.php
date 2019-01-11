<?php

// Generic Default Inserts

if (!$config['system_seed'])
{
	$config['system_seed'] = Ut::random_token(20, 3);
}

if (!$config['hashid_seed'])
{
	$config['hashid_seed'] = Ut::random_token(20, 3);
}

$password_hashed		= $config['admin_name'] . $_POST['password'];
$password_hashed		= password_hash(
								base64_encode(
										hash('sha256', $password_hashed, true)
										),
								PASSWORD_DEFAULT
								);

// user 'system' holds all default pages
$insert_user_system			= "INSERT INTO " . $config['table_prefix'] . "user (user_name, account_lang, password, email, account_type, signup_time) VALUES ('System', '" . $config['language'] . "', '', '', '1', UTC_TIMESTAMP())";

// user 'deleted' holds all pages and attachments from deleted users
$insert_user_deleted		= "INSERT INTO " . $config['table_prefix'] . "user (user_name, account_lang, password, email, account_type, signup_time) VALUES ('Deleted', '" . $config['language'] . "', '', '', '1', UTC_TIMESTAMP())";

// user 'admin'
$insert_admin				= "INSERT INTO " . $config['table_prefix'] . "user (user_name, account_lang, password, email, signup_time) VALUES ('" . $config['admin_name'] . "', '" . $config['language'] . "', '" . $password_hashed . "', '" . $config['admin_email'] . "', UTC_TIMESTAMP() )";
$insert_admin_setting		= "INSERT INTO " . $config['table_prefix'] . "user_setting (user_id, theme, user_lang) VALUES ((SELECT user_id FROM " . $config['table_prefix'] . "user WHERE user_name = '" . $config['admin_name'] . "' LIMIT 1), '" . $config['theme'] . "', '" . $config['language'] . "')";

// default groups
$insert_admin_group			= "INSERT INTO " . $config['table_prefix'] . "usergroup (group_name, description, moderator_id, created, is_system, active) VALUES ('Admins', '', (SELECT user_id FROM " . $config['table_prefix'] . "user WHERE user_name = '" . $config['admin_name'] . "' LIMIT 1), UTC_TIMESTAMP(), 1, 1)";
$insert_admin_group_member	= "INSERT INTO " . $config['table_prefix'] . "usergroup_member (group_id, user_id) VALUES ((SELECT group_id FROM " . $config['table_prefix'] . "usergroup WHERE group_name = 'Admins' LIMIT 1), (SELECT user_id FROM " . $config['table_prefix'] . "user WHERE user_name = '" . $config['admin_name'] . "' LIMIT 1))";

$insert_moderator_group		= "INSERT INTO " . $config['table_prefix'] . "usergroup (group_name, description, moderator_id, created, is_system, active) VALUES ('Moderator', '', (SELECT user_id FROM " . $config['table_prefix'] . "user WHERE user_name = '" . $config['admin_name'] . "' LIMIT 1), UTC_TIMESTAMP(), 1, 1)";
$insert_reviewer_group		= "INSERT INTO " . $config['table_prefix'] . "usergroup (group_name, description, moderator_id, created, is_system, active) VALUES ('Reviewer', '', (SELECT user_id FROM " . $config['table_prefix'] . "user WHERE user_name = '" . $config['admin_name'] . "' LIMIT 1), UTC_TIMESTAMP(), 1, 1)";

$insert_logo_image			= "INSERT INTO " . $config['table_prefix'] . "file (page_id, user_id, file_name, file_description, uploaded_dt, modified_dt, file_size, picture_w, picture_h, file_ext, mime_type) VALUES ('0', (SELECT user_id FROM " . $config['table_prefix'] . "user WHERE user_name = '" . $config['admin_name'] . "' LIMIT 1), 'wacko_logo.png', 'WackoWiki', UTC_TIMESTAMP(), UTC_TIMESTAMP(), '1580', '108', '50', 'png', 'image/png')";

?>