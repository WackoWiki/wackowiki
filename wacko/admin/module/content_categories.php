<?php

if (!defined('IN_WACKO'))
{
	exit;
}

########################################################
##   Pages                                            ##
########################################################
$_module = 'content_categories';

$module[$_module] = [
		'order'	=> 350,
		'cat'	=> 'content',
		'status'=> (RECOVERY_MODE ? false : true),
		'mode'	=> $_module,
		'name'	=> 'Categories',
		'title'	=> 'Manage categories',
	];

########################################################

function admin_content_categories(&$engine, &$module)
{
	$order = '';
	$error = '';
?>
	<h1><?php echo $module['title']; ?></h1>
	<br />


<?php

}

?>