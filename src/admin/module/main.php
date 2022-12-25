<?php

if (!defined('IN_WACKO'))
{
	exit;
}

##########################################################
##	Welcome screen and site locking						##
##########################################################

$module['main'] = [
		'order'	=> 100,
		'cat'	=> 'basics',
		'status'=> true,
	];

##########################################################

function admin_main($engine, $module)
{
	$action = $_POST['_action'] ?? null;

	// (un)lock website
	if ($action == 'lock')
	{
		$engine->config->lock();

		$engine->http->redirect($engine->href());
	}
	// purge sessions
	else if ($action == 'purge_sessions')
	{
		# $sql = "TRUNCATE " . $engine->prefix . "auth_token";
		# $engine->db->sql_query($sql);
		$engine->sess->delete_cookie(AUTH_TOKEN);
		// queries
		# $engine->config->invalidate_sql_cache();
	}
?>
	<h1><?php echo $engine->_t($module)['title']; ?></h1>
	<br>
	<p><?php echo $engine->_t('MainNote');?></p>
	<br>
	<?php
	echo $engine->form_open('lock');
	?>
	<table style="max-width: 200px;" class="formation">
		<tr class="hl-setting">
			<td class="label" style="white-space: nowrap;">
				<?php echo ($engine->db->is_locked()
					? '<span class="red">' . $engine->_t('SiteClosedTip') . '</span>'
					: '<span class="green">' . $engine->_t('SiteOpenedTip') . '</span>'); ?>
			</td>
			<td class="t-center">
				<button type="submit" id="submit"><?php echo ($engine->db->is_locked() ? $engine->_t('SiteOpen') : $engine->_t('SiteClose')); ?></button>
			</td>
		</tr>
	</table>
<?php
	echo $engine->form_close();

	echo $engine->form_open('purge_sessions');
?>
		<input type="hidden" name="mode" value="main">
		<table style="max-width: 200px;" class="formation">
			<tr class="hl-setting">
				<td class="label nowrap">
					<?php echo $engine->_t('PurgeSessionsTip');?>
					<br><?php #echo $engine->_t('PurgeSessionsExplain');?></td>
				<td class="t-center">
					<?php echo ($action == 'purge_sessions' ? $engine->_t('PurgeSessionsDone') : '<button type="submit" id="submit">' . $engine->_t('PurgeSessions') . '</button>');?>
				</td>
			</tr>
		</table>
<?php
	echo $engine->form_close();
	echo '<br><br>';
	echo $engine->action('admincache');
}
