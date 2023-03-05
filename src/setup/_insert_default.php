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

$file_path	= Ut::join_path(UPLOAD_GLOBAL_DIR, $config['site_logo']);
$image_size	= @getimagesize($file_path);
$file_size	= filesize($file_path);
$file_hash	= sha1_file($file_path);

// sub-select query for user_id
$q_user_id	= "SELECT user_id FROM {$pref}user WHERE user_name = '" . _q($config['admin_name']) . "' LIMIT 1";

// user 'system' holds all default pages
$insert_user_system =
	"INSERT INTO {$pref}user (
		user_name,
		password,
		email,
		account_type,
		signup_time
	)
	VALUES (
		'System',
		'',
		'',
		1,
		UTC_TIMESTAMP()
	)";

// user 'deleted' holds all pages and attachments from deleted users
$insert_user_deleted =
	"INSERT INTO {$pref}user (
		user_name,
		password,
		email,
		account_type,
		signup_time
	)
	VALUES (
		'Deleted',
		'',
		'',
		1,
		UTC_TIMESTAMP()
	)";

// user 'admin'
$insert_admin =
	"INSERT INTO {$pref}user (
		user_name,
		password,
		email,
		signup_time
	)
	VALUES (
		'" . _q($config['admin_name']) . "',
		'" . _q($password_hashed) . "',
		'" . _q($config['admin_email']) . "',
		UTC_TIMESTAMP()
	)";

$insert_admin_setting =
	"INSERT INTO {$pref}user_setting (
		user_id,
		theme,
		user_lang
	)
	VALUES (
		(" . $q_user_id . "),
		'" . _q($config['theme']) . "',
		'" . _q($config['language']) . "'
	)";

// default groups
$insert_admin_group =
	"INSERT INTO {$pref}usergroup (
		group_name,
		description,
		moderator_id,
		created,
		is_system,
		active
	)
	VALUES (
		'Admins',
		'',
		(" . $q_user_id . "),
		UTC_TIMESTAMP(),
		1,
		1
	)";

$insert_admin_group_member =
	"INSERT INTO {$pref}usergroup_member (
		group_id,
		user_id
	)
	VALUES (
		(SELECT group_id FROM {$pref}usergroup WHERE group_name = 'Admins' LIMIT 1),
		(" . $q_user_id . ")
	)";

$insert_moderator_group =
	"INSERT INTO {$pref}usergroup (
		group_name,
		description,
		moderator_id,
		created,
		is_system,
		active
	)
	VALUES (
		'Moderator',
		'',
		(" . $q_user_id . "),
		UTC_TIMESTAMP(),
		1,
		1
	)";

$insert_reviewer_group =
	"INSERT INTO {$pref}usergroup (
		group_name,
		description,
		moderator_id,
		created,
		is_system,
		active
	)
	VALUES (
		'Reviewer',
		'',
		(" . $q_user_id . "),
		UTC_TIMESTAMP(),
		1,
		1
	)";

$insert_logo_image =
	"INSERT INTO {$pref}file (
		page_id,
		user_id,
		file_name,
		file_lang,
		file_description,
		uploaded_dt,
		modified_dt,
		file_size,
		picture_w,
		picture_h,
		file_ext,
		mime_type,
		file_hash
	)
	VALUES (
		0,
		(" . $q_user_id . "),
		'" . _q($config['site_logo']) . "',
		'" . _q($config['language']) . "',
		'WackoWiki',
		UTC_TIMESTAMP(),
		UTC_TIMESTAMP(),
		'" . (int) $file_size . "',
		'" . (int) $image_size[0] . "',
		'" . (int) $image_size[1] . "',
		'png',
		'image/png',
		'" . _q($file_hash) . "'
	)";
