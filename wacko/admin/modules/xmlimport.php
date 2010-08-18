<?php

########################################################
##   XML Import                                       ##
########################################################

$module['xmlimport'] = array(
		'order'	=> 4,
		'cat'	=> 'Content',
		'mode'	=> 'xmlimport',
		'name'	=> 'Import XML',
		'title'	=> 'Import and re-establishment of the pages of the XML-document',
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