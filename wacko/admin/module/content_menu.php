<?php

if (!defined('IN_WACKO'))
{
	exit;
}

########################################################
##   Menu                                             ##
########################################################
$_module = 'content_menu';

$module[$_module] = [
		'order'	=> 320,
		'cat'	=> 'content',
		'status'=> (RECOVERY_MODE ? false : true),
		'mode'	=> $_module,
		'name'	=> 'Menu',
		'title'	=> 'Add, edit or remove default menu items',
	];

########################################################

function admin_content_menu(&$engine, &$module)
{
?>
	<h1><?php echo $module['title']; ?></h1>
	<br />
<?php
	echo $engine->action('menu', ['system' => 1]);
}

?>