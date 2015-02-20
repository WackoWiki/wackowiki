<?php

if (!defined('IN_WACKO'))
{
	exit;
}

########################################################
##   Pages                                            ##
########################################################

$module['pages'] = array(
		'order'	=> 3,
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

	TODO:<br />
	filter pages<br />
	all pages<br />
	my pages<br />
	published<br />
	drafts<br />
	with no title<br />
	with no description<br />
	with no keywords<br />
	by date modified<br />
	...

<?php

}

?>