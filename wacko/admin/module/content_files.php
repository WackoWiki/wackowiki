<?php

if (!defined('IN_WACKO'))
{
	exit;
}

########################################################
##   Uploaded Files                                   ##
########################################################
$_mode = 'content_files';

$module[$_mode] = [
		'order'	=> 360,
		'cat'	=> 'content',
		'status'=> (RECOVERY_MODE ? false : true),
		'mode'	=> $_mode,
		'name'	=> $engine->_t($_mode)['name'],		// Files
		'title'	=> $engine->_t($_mode)['title'],	// Manage uploaded files
];

########################################################

function admin_content_files(&$engine, &$module)
{

?>
	<h1><?php echo $module['title']; ?></h1>
	<br>
<?php


}

?>
