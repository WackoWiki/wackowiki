<?php

if (!defined('IN_WACKO'))
{
	exit;
}

##########################################################
##	Menu												##
##########################################################

$module['content_menu'] = [
		'order'	=> 320,
		'cat'	=> 'content',
		'status'=> !RECOVERY_MODE,
	];

##########################################################

function admin_content_menu(&$engine, $module)
{
?>
	<h1><?php echo $engine->_t($module)['title']; ?></h1>
	<br>
<?php
	echo $engine->action('menu', ['system' => 1]);
}
