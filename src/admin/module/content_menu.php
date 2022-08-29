<?php

if (!defined('IN_WACKO'))
{
	exit;
}

##########################################################
##	Menu												##
##########################################################
$_mode = 'content_menu';

$module[$_mode] = [
		'order'	=> 320,
		'cat'	=> 'content',
		'status'=> !RECOVERY_MODE,
		'mode'	=> $_mode,
	];

##########################################################

function admin_content_menu(&$engine, &$module)
{
?>
	<h1><?php echo $engine->_t($module['mode'])['title']; ?></h1>
	<br>
<?php
	echo $engine->action('menu', ['system' => 1]);
}
