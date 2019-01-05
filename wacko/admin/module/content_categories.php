<?php

if (!defined('IN_WACKO'))
{
	exit;
}

##########################################################
##	Pages												##
##########################################################
$_mode = 'content_categories';

$module[$_mode] = [
		'order'	=> 350,
		'cat'	=> 'content',
		'status'=> (RECOVERY_MODE ? false : true) && (WACKO_ENV < 3),
		'mode'	=> $_mode,
		'name'	=> $engine->_t($_mode)['name'],		// Categories
		'title'	=> $engine->_t($_mode)['title'],	// Manage categories
	];

##########################################################

function admin_content_categories(&$engine, &$module)
{
	$order = '';
	$error = '';
?>
	<h1><?php echo $module['title']; ?></h1>
	<br>
	Nothing here YET<br>
	TODO: add module for category management

<?php

}

?>