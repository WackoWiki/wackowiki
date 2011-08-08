<?php

if (!defined('IN_WACKO'))
{
	exit;
}

########################################################
##   Pages                                            ##
########################################################

$module['pages'] = array(
		'order'	=> 4,
		'cat'	=> 'Content',
		'mode'	=> 'pages',
		'name'	=> 'Pages',
		'title'	=> 'Manage pages',
	);

########################################################

function admin_pages(&$engine, &$module)
{
	$order = '';
	$error = '';
?>
	<h1><?php echo $module['title']; ?></h1>
	<br />


<?php

}

?>