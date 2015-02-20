<?php

if (!defined('IN_WACKO'))
{
	exit;
}

########################################################
##   XML Import                                       ##
########################################################

$module['xmlimport'] = array(
		'order'	=> 3,
		'cat'	=> 'Content',
		'mode'	=> 'xmlimport',
		'name'	=> 'Import XML',
		'title'	=> 'Import and restore of the pages of the XML-file',
	);

########################################################

function admin_xmlimport(&$engine, &$module)
{
?>
	<h1><?php echo $module['title']; ?></h1>
	<br />
<?php
	echo $engine->action('import');
}

?>