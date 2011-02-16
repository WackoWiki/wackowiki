<?php

if (!defined('IN_WACKO'))
{
	exit;
}

########################################################
##   XML Import                                       ##
########################################################

$module['bookmarks'] = array(
		'order'	=> 4,
		'cat'	=> 'Content',
		'mode'	=> 'bookmarks',
		'name'	=> 'Bookmarks',
		'title'	=> 'Add, edit or remove default bookmarks',
	);

########################################################

function admin_bookmarks(&$engine, &$module)
{
?>
	<h1><?php echo $module['title']; ?></h1>
	<br />
<?php
	echo $engine->action('bookmarks', array('system' => 1));
}

?>