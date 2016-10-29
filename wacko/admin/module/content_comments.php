<?php

if (!defined('IN_WACKO'))
{
	exit;
}

########################################################
##   Comments                                         ##
########################################################
$_module = 'content_comments';

$module[$_module] = [
		'order'	=> 310,
		'cat'	=> 'content',
		'status'=> (RECOVERY_MODE ? false : true),
		'mode'	=> $_module,
		'name'	=> 'Comments',
		'title'	=> 'Manage comments',
	];

########################################################

function admin_content_comments(&$engine, &$module)
{
	$order = '';
	$error = '';
?>
	<h1><?php echo $module['title']; ?></h1>
	<br />


<?php

}

?>