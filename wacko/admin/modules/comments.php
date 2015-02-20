<?php

if (!defined('IN_WACKO'))
{
	exit;
}

########################################################
##   Comments                                         ##
########################################################

$module['comments'] = array(
		'order'	=> 3,
		'cat'	=> 'Content',
		'mode'	=> 'comments',
		'name'	=> 'Comments',
		'title'	=> 'Manage comments',
	);

########################################################

function admin_comments(&$engine, &$module)
{
	$order = '';
	$error = '';
?>
	<h1><?php echo $module['title']; ?></h1>
	<br />


<?php

}

?>