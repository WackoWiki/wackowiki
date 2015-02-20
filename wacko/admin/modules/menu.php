<?php

if (!defined('IN_WACKO'))
{
	exit;
}

########################################################
##   Menu                                             ##
########################################################

$module['menu'] = array(
		'order'	=> 3,
		'cat'	=> 'Content',
		'mode'	=> 'menu',
		'name'	=> 'Menu',
		'title'	=> 'Add, edit or remove default menu items',
	);

########################################################

function admin_menu(&$engine, &$module)
{
?>
	<h1><?php echo $module['title']; ?></h1>
	<br />
<?php
	echo $engine->action('menu', array('system' => 1));
}

?>