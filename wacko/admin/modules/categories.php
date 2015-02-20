<?php

if (!defined('IN_WACKO'))
{
	exit;
}

########################################################
##   Pages                                            ##
########################################################

$module['categories'] = array(
		'order'	=> 3,
		'cat'	=> 'Content',
		'mode'	=> 'categories',
		'name'	=> 'Categories',
		'title'	=> 'Manage categories',
	);

########################################################

function admin_categories(&$engine, &$module)
{
	$order = '';
	$error = '';
?>
	<h1><?php echo $module['title']; ?></h1>
	<br />


<?php

}

?>