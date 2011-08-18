<?php

if (!defined('IN_WACKO'))
{
	exit;
}

########################################################
##   Pages                                            ##
########################################################

$module['tags'] = array(
		'order'	=> 4,
		'cat'	=> 'Content',
		'mode'	=> 'tags',
		'name'	=> 'Tags',
		'title'	=> 'Manage tags',
	);

########################################################

function admin_tags(&$engine, &$module)
{
	$order = '';
	$error = '';
?>
	<h1><?php echo $module['title']; ?></h1>
	<br />


<?php

}

?>