<?php

if (!defined('IN_WACKO'))
{
	exit;
}

########################################################
##   XML Import                                       ##
########################################################

$module['menu'] = array(
		'order'	=> 4,
		'cat'	=> 'Content',
		'mode'	=> 'menu',
		'name'	=> 'menu',
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