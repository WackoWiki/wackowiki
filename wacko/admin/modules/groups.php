<?php

########################################################
##   User Groups                                      ##
########################################################

$module['groups'] = array(
		'order'	=> 5,
		'cat'	=> 'Users',
		'mode'	=> 'groups',
		'name'	=> 'Groups',
		'title'	=> 'Group management',
	);

########################################################

function admin_groups(&$engine, &$module)
{
?>
	<h1><?php echo $module['title']; ?></h1>
	<br />

<?php
}
?>