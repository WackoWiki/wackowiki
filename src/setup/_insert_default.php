<?php

// Generic Default Inserts
$pref					= $config['table_prefix'];

$password_hashed		= $config['admin_name'] . $_POST['password'];
$password_hashed		= password_hash(
								base64_encode(
										hash('sha256', $password_hashed, true)
										),
								PASSWORD_DEFAULT
								);

// user 'system' holds all default pages
$insert_user_system			= "INSERT INTO {$pref}user (user_name, password, email, account_type, signup_time) VALUES ('System', '', '', '1', UTC_TIMESTAMP())";

// user 'deleted' holds all pages and attachments from deleted users
$insert_user_deleted		= "INSERT INTO {$pref}user (user_name, password, email, account_type, signup_time) VALUES ('Deleted', '', '', '1', UTC_TIMESTAMP())";

// user 'admin'
$insert_admin				= "INSERT INTO {$pref}user (user_name, password, email, signup_time) VALUES ('" . $config['admin_name'] . "', '" . $password_hashed . "', '" . $config['admin_email'] . "', UTC_TIMESTAMP() )";
$insert_admin_setting		= "INSERT INTO {$pref}user_setting (user_id, theme, user_lang) VALUES ((SELECT user_id FROM {$pref}user WHERE user_name = '" . $config['admin_name'] . "' LIMIT 1), '" . $config['theme'] . "', '" . $config['language'] . "')";

// default groups
$insert_admin_group			= "INSERT INTO {$pref}usergroup (group_name, description, moderator_id, created, is_system, active) VALUES ('Admins', '', (SELECT user_id FROM {$pref}user WHERE user_name = '" . $config['admin_name'] . "' LIMIT 1), UTC_TIMESTAMP(), 1, 1)";
$insert_admin_group_member	= "INSERT INTO {$pref}usergroup_member (group_id, user_id) VALUES ((SELECT group_id FROM {$pref}usergroup WHERE group_name = 'Admins' LIMIT 1), (SELECT user_id FROM {$pref}user WHERE user_name = '" . $config['admin_name'] . "' LIMIT 1))";

$insert_moderator_group		= "INSERT INTO {$pref}usergroup (group_name, description, moderator_id, created, is_system, active) VALUES ('Moderator', '', (SELECT user_id FROM {$pref}user WHERE user_name = '" . $config['admin_name'] . "' LIMIT 1), UTC_TIMESTAMP(), 1, 1)";
$insert_reviewer_group		= "INSERT INTO {$pref}usergroup (group_name, description, moderator_id, created, is_system, active) VALUES ('Reviewer', '', (SELECT user_id FROM {$pref}user WHERE user_name = '" . $config['admin_name'] . "' LIMIT 1), UTC_TIMESTAMP(), 1, 1)";

$insert_logo_image			= "INSERT INTO {$pref}file (page_id, user_id, file_name, file_lang, file_description, created, modified, file_size, picture_w, picture_h, file_ext, mime_type) VALUES ('0', (SELECT user_id FROM {$pref}user WHERE user_name = '" . $config['admin_name'] . "' LIMIT 1), 'wacko_logo.png', '" . $config['language'] . "', 'WackoWiki', UTC_TIMESTAMP(), UTC_TIMESTAMP(), '1580', '108', '50', 'png', 'image/png')";
