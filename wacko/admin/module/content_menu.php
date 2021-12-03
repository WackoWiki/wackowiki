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
		'name'	=> $engine->_t($_mode)['name'],		// Menu
		'title'	=> $engine->_t($_mode)['title'],	// Add, edit or remove default menu items
	];

##########################################################

function admin_content_menu(&$engine, &$module)
{
?>
	<h1><?php echo $module['title']; ?></h1>
	<br>
<?php
	echo $engine->action('menu', ['system' => 1]);
}
