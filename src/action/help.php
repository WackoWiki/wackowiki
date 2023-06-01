<?php

if (!defined('IN_WACKO'))
{
	exit;
}

// set defaults
$info	??= 'No help text available.';
$action	??= 'help';

// check for translated version
$lang		= $this->get_user_language();
$help		= [];
$lang_file	= Ut::join_path('action/lang', 'help.' . $lang . '.php');

if (@file_exists($lang_file))
{
	include $lang_file;
}

if (isset($help[$action]))
{
	$info = $help[$action];
}

$tpl->help_text = $info;
