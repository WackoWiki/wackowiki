<?php

if (!defined('IN_WACKO'))
{
	exit;
}

########################################################
##   Menu                                             ##
########################################################

$module['content_menu'] = array(
		'order'	=> 15,
		'cat'	=> 'Content',
		'status'=> (RECOVERY_MODE ? false : true),
		'mode'	=> 'content_menu',
		'name'	=> 'Menu',
		'title'	=> 'Add, edit or remove default menu items',
	);

########################################################

function admin_content_menu(&$engine, &$module)
{
?>
	<h1><?php echo $module['title']; ?></h1>
	<br />
<?php
	echo $engine->action('menu', array('system' => 1));
}

?>