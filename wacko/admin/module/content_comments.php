<?php

if (!defined('IN_WACKO'))
{
	exit;
}

##########################################################
##	Comments											##
##########################################################
$_mode = 'content_comments';

$module[$_mode] = [
		'order'	=> 310,
		'cat'	=> 'content',
		'status'=> (RECOVERY_MODE ? false : true) && (WACKO_ENV < 3),
		'mode'	=> $_mode,
		'name'	=> $engine->_t($_mode)['name'],		// Comments
		'title'	=> $engine->_t($_mode)['title'],	// Manage comments
	];

##########################################################

function admin_content_comments(&$engine, &$module)
{
	$order = '';
	$error = '';
?>
	<h1><?php echo $module['title']; ?></h1>
	<br>
	Nothing here YET<br>
	TODO: add module for comment management

<?php

}
