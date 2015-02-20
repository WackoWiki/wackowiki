<?php

if (!defined('IN_WACKO'))
{
	exit;
}

########################################################
##   Welcome screen and site locking                  ##
########################################################

$module['lock'] = array(
		'order'	=> 1,
		'cat'	=> 'Basic functions',
		'mode'	=> 'lock',
		'name'	=> 'Main Menu',
		'title'	=> 'WackoWiki Administration',
		'objs'	=> array(&$init),


	);

########################################################

function admin_lock(&$engine, &$module)
{
	// import passed variables and objects
	$init			= & $module['objs'][0];

	// (un)lock website
	if (isset($_POST['action']) && $_POST['action'] == 'lock')
	{
		$init->lock();

		$engine->set_user($_user, 0);
		$engine->redirect('admin.php');
	}
	// clear cache
	else if (isset($_POST['action']) && $_POST['action'] == 'cache')
	{
		// pages
		$directory	= $engine->config['cache_dir'].CACHE_PAGE_DIR;
		$handle		= opendir(rtrim($directory, '/'));

		while (false !== ($file = readdir($handle)))
		{
			if (!is_dir($directory.$file))
			{
				unlink($directory.$file);
			}
		}

		closedir($handle);
		$engine->sql_query("TRUNCATE {$engine->config['table_prefix']}cache");

		// queries
		$engine->cache->invalidate_sql_cache();

		// config
		$engine->cache->destroy_config_cache();

		// feeds
		$directory	= $engine->config['cache_dir'].CACHE_FEED_DIR;
		$handle		= opendir(rtrim($directory, '/'));

		while (false !== ($file = readdir($handle)))
		{
			if (!is_dir($directory.$file))
			{
				unlink($directory.$file);
			}
		}

		closedir($handle);
	}
	// purge sessions
	else if (isset($_POST['action']) && $_POST['action'] == 'purge_sessions')
	{
		$sql = "TRUNCATE {$engine->config['table_prefix']}session";
		$engine->sql_query($sql);

		// queries
		#$engine->cache->invalidate_sql_cache();

	}
?>
	<h1><?php echo $module['title']; ?></h1>
	<br />
	<p>
		Note: Before the administration of technical activities
		<span class="underline">strongly</span> are encouraged to block access to the site!
	</p>
	<br />
	<form action="admin.php" method="post" name="lock">
		<input type="hidden" name="mode" value="lock" />
		<input type="hidden" name="action" value="lock" />
		<table style="max-width:200px" class="formation">
			<tr>
				<td class="label" style="white-space:nowrap"><?php echo ( $init->is_locked() === true ? '<span class="red">The site is closed</span>' : '<span class="green">The site is open</span>' ); ?></td>
				<td align="center"><input id="submit" type="submit" value="<?php echo ( $init->is_locked() === true ? 'open' : 'close' ); ?>" /></td>
			</tr>
		</table>
	</form>
	<br />
	<form action="admin.php" method="post" name="cache">
		<input type="hidden" name="mode" value="lock" />
		<input type="hidden" name="action" value="cache" />
		<table style="max-width:200px" class="formation">
			<tr>
				<td class="label" style="white-space:nowrap"><?php echo $engine->get_translation('ClearCache');?></td>
				<td align="center"><?php  echo (isset($_POST['action']) && $_POST['action'] == 'cache' ? $engine->get_translation('CacheCleared') : '<input id="submit" type="submit" value="clean" />');?></td>
			</tr>
		</table>
	</form>
		<form action="admin.php" method="post" name="purge_sessions">
		<input type="hidden" name="mode" value="lock" />
		<input type="hidden" name="action" value="purge_sessions" />
		<table style="max-width:200px" class="formation">
			<tr>
				<td class="label" style="white-space:nowrap"><?php echo $engine->get_translation('PurgeSessions');?>
				<br /><?php #echo $engine->get_translation('PurgeSessionsExplain');?></td>
				<td align="center"><?php  echo (isset($_POST['action']) && $_POST['action'] == 'purge_sessions' ? $engine->get_translation('PurgeSessionsDone') : '<input id="submit" type="submit" value="purge" />');?></td>
			</tr>
		</table>
	</form>
	<?php
	# echo $engine->action('admincache'); // TODO: solve redirect issue
	?>

<?php
}

?>