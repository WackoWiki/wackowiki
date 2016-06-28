<?php

// Generic Default Inserts

if (!$config['system_seed'])
{
	$config['system_seed'] = random_password(20);
}

$salt_user_form			= random_password(10);
$password_hashed		= $config['admin_name'].$_POST['password'];
$password_hashed		= password_hash(
								base64_encode(
										hash('sha256', $password_hashed, true)
										),
								PASSWORD_DEFAULT
								);

// user 'system' holds all default pages
$insert_system				= "INSERT INTO ".$config['table_prefix']."user (user_name, account_lang, password, email, account_type, signup_time) VALUES ('System', '".$config['language']."', '', '', '1', UTC_TIMESTAMP())";
$insert_admin				= "INSERT INTO ".$config['table_prefix']."user (user_name, account_lang, password, email, signup_time, user_form_salt) VALUES ('".$config['admin_name']."', '".$config['language']."', '".$password_hashed."', '".$config['admin_email']."', UTC_TIMESTAMP(), '".$salt_user_form."')";
$insert_admin_setting		= "INSERT INTO ".$config['table_prefix']."user_setting (user_id, theme, user_lang) VALUES ((SELECT user_id FROM ".$config['table_prefix']."user WHERE user_name = '".$config['admin_name']."' LIMIT 1), '".$config['theme']."', '".$config['language']."')";

// TODO: for Upgrade insert other aliases also in usergroup table
// $config['aliases'] = array('Admins' => $config['admin_name']);

// default groups
$insert_admin_group			= "INSERT INTO ".$config['table_prefix']."usergroup (group_name, description, moderator_id, created) VALUES ('Admins', '', (SELECT user_id FROM ".$config['table_prefix']."user WHERE user_name = '".$config['admin_name']."' LIMIT 1), UTC_TIMESTAMP())";
$insert_admin_group_member	= "INSERT INTO ".$config['table_prefix']."usergroup_member (group_id, user_id) VALUES ((SELECT group_id FROM ".$config['table_prefix']."usergroup WHERE group_name = 'Admins' LIMIT 1), (SELECT user_id FROM ".$config['table_prefix']."user WHERE user_name = '".$config['admin_name']."' LIMIT 1))";

$insert_everybody_group		= "INSERT INTO ".$config['table_prefix']."usergroup (group_name, description, moderator_id, created) VALUES ('Everybody', '', (SELECT user_id FROM ".$config['table_prefix']."user WHERE user_name = '".$config['admin_name']."' LIMIT 1), UTC_TIMESTAMP())";
$insert_registered_group	= "INSERT INTO ".$config['table_prefix']."usergroup (group_name, description, moderator_id, created) VALUES ('Registered', '', (SELECT user_id FROM ".$config['table_prefix']."user WHERE user_name = '".$config['admin_name']."' LIMIT 1), UTC_TIMESTAMP())";
$insert_moderator_group		= "INSERT INTO ".$config['table_prefix']."usergroup (group_name, description, moderator_id, created) VALUES ('Moderator', '', (SELECT user_id FROM ".$config['table_prefix']."user WHERE user_name = '".$config['admin_name']."' LIMIT 1), UTC_TIMESTAMP())";
$insert_reviewer_group		= "INSERT INTO ".$config['table_prefix']."usergroup (group_name, description, moderator_id, created) VALUES ('Reviewer', '', (SELECT user_id FROM ".$config['table_prefix']."user WHERE user_name = '".$config['admin_name']."' LIMIT 1), UTC_TIMESTAMP())";

$insert_logo_image			= "INSERT INTO ".$config['table_prefix']."upload (page_id, user_id, file_name, file_description, uploaded_dt, file_size, picture_w, picture_h, file_ext) VALUES ('0', (SELECT user_id FROM ".$config['table_prefix']."user WHERE user_name = '".$config['admin_name']."' LIMIT 1),'wacko_logo.png', 'WackoWiki', UTC_TIMESTAMP(), '1580', '108', '50', 'png')";


?>
