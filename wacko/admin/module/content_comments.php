<?php

if (!defined('IN_WACKO'))
{
	exit;
}

########################################################
##   Comments                                         ##
########################################################

$module['content_comments'] = array(
		'order'	=> 12,
		'cat'	=> 'Content',
		'status'=> (RECOVERY_MODE ? false : true),
		'mode'	=> 'content_comments',
		'name'	=> 'Comments',
		'title'	=> 'Manage comments',
	);

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