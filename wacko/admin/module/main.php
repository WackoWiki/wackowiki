<?php

if (!defined('IN_WACKO'))
{
	exit;
}

########################################################
##   Welcome screen and site locking                  ##
########################################################

$module['lock'] = array(
		'order'	=> 100,
		'cat'	=> 'Basic functions',
		'status'=> true,
		'mode'	=> 'lock',
		'name'	=> 'Main Menu',
		'title'	=> 'WackoWiki Administration',
		'objs'	=> array(&$config),


	);

########################################################

function admin_lock(&$engine, &$module)
{
	// import passed variables and objects
	$config			= & $module['objs'][0];

	// (un)lock website
	if (isset($_POST['action']) && $_POST['action'] == 'lock')
	{
		$engine->config->lock();

		// $engine->set_user($_user, 0);
		$engine->redirect('admin.php');
	}
	// clear cache
	else if (isset($_POST['action']) && $_POST['action'] == 'cache')
	{
		purge_directory(CACHE_PAGE_DIR);
		$engine->sql_query("TRUNCATE {$engine->config['table_prefix']}cache");

		purge_directory(CACHE_SQL_DIR);

		purge_directory(CACHE_CONFIG_DIR);

		purge_directory(CACHE_FEED_DIR);
	}
	// purge sessions
	else if (isset($_POST['action']) && $_POST['action'] == 'purge_sessions')
	{
		#$sql = "TRUNCATE {$engine->config['table_prefix']}auth_token";
		#$engine->sql_query($sql);
		$engine->delete_cookie_token('', false);
		// queries
		#$engine->config->invalidate_sql_cache();

	}
?>
	<h1><?php echo $module['title']; ?></h1>
	<br />
	<p>
		<?php echo $engine->get_translation('MainNote');?>
	</p>
	<br />
	<table style="max-width:200px" class="formation">
<?php
	echo $engine->form_open('lock', '', 'post', true, 'admin.php', '', '');
?>
		<input type="hidden" name="action" value="lock" />
			<tr class="hl_setting">
				<td class="label" style="white-space:nowrap"><?php echo ( $config->is_locked() === true ? '<span class="red">The site is closed</span>' : '<span class="green">The site is open</span>' ); ?></td>
				<td style="text-align:center;"><input type="submit" id="submit" value="<?php echo ( $config->is_locked() === true ? 'open' : 'close' ); ?>" /></td>
			</tr>
	<br />
<?php
	echo $engine->form_close();
	echo '<br />';
	// $form_name = '', $page_method = '', $form_method = 'post', $form_token = false, $tag = '', $form_more = '', $href_param = ''
	echo $engine->form_open('cache', '', 'post', true, 'admin.php', '');
?>
		<input type="hidden" name="action" value="cache" />
			<tr class="hl_setting">
				<td class="label" style="white-space:nowrap"><?php echo $engine->get_translation('ClearCache');?></td>
				<td style="text-align:center;"><?php  echo (isset($_POST['action']) && $_POST['action'] == 'cache' ? $engine->get_translation('CacheCleared') : '<input type="submit" id="submit" value="clean" />');?></td>
			</tr>
<?php
	echo $engine->form_close();

	echo $engine->form_open('purge_sessions', '', 'post', true, 'admin.php', '');
?>
		<form action="admin.php" method="post" name="">
		<input type="hidden" name="mode" value="lock" />
		<input type="hidden" name="action" value="purge_sessions" />
			<tr class="hl_setting">
				<td class="label" style="white-space:nowrap"><?php echo $engine->get_translation('PurgeSessions');?>
				<br /><?php #echo $engine->get_translation('PurgeSessionsExplain');?></td>
				<td><?php  echo (isset($_POST['action']) && $_POST['action'] == 'purge_sessions' ? $engine->get_translation('PurgeSessionsDone') : '<input type="submit" id="submit" value="purge" />');?></td>
			</tr>
		</table>
<?php
	echo $engine->form_close();
	# echo $engine->action('admincache'); // TODO: solve redirect issue

}

?>
