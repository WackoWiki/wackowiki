<?php

if (!defined('IN_WACKO'))
{
	exit;
}

########################################################
##   Pages                                            ##
########################################################

$module['content_tags'] = array(
		'order'	=> 3,
		'cat'	=> 'Content',
		'status'=> false,
		'mode'	=> 'content_tags',
		'name'	=> 'Tags',
		'title'	=> 'Manage tags',
	);

########################################################

function admin_content_tags(&$engine, &$module)
{
	$order = '';
	$error = '';
?>
	<h1><?php echo $module['title']; ?></h1>
	<br />


<?php

}

?>