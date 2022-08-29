<?php

if (!defined('IN_WACKO'))
{
	exit;
}

##########################################################
##	Maintenance setting									##
##########################################################
$_mode = 'config_system';

$module[$_mode] = [
		'order'	=> 210,
		'cat'	=> 'preferences',
		'status'=> !RECOVERY_MODE,
	];

##########################################################

function admin_config_system(&$engine, $module)
{
?>
	<h1><?php echo $engine->_t($module)['title']; ?></h1>
	<br>
	<p>
			<?php echo $engine->_t('SystemSettingsInfo');?>
	</p>
	<br>
<?php
	// update settings

	if (isset($_POST['action']) && $_POST['action'] == 'update')
	{
		$config['debug']					= (int) $_POST['debug'];
		$config['debug_sql_threshold']		= (float)$_POST['debug_sql_threshold'];
		$config['debug_admin_only']			= (int) ($_POST['debug_admin_only'] ?? 0);
		$config['cache']					= (int) ($_POST['cache'] ?? 0);
		$config['cache_ttl']				= (int) $_POST['cache_ttl'];
		$config['cache_sql']				= (int) ($_POST['cache_sql'] ?? 0);
		$config['cache_sql_ttl']			= (int) $_POST['cache_sql_ttl'];
		$config['log_level']				= (int) $_POST['log_level'];
		$config['log_default_show']			= (int) $_POST['log_default_show'];
		$config['log_purge_time']			= (int) $_POST['log_purge_time'];
		$config['anonymize_ip']				= (int) $_POST['anonymize_ip'];
		$config['session_notice']			= (int) $_POST['session_notice'];
		$config['session_store']			= (int) $_POST['session_store'];
		$config['rewrite_mode']				= (int) ($_POST['rewrite_mode'] ?? 0);
		$config['reverse_proxy']			= (int) ($_POST['reverse_proxy'] ?? 0);
		$config['reverse_proxy_header']		= (string) $_POST['reverse_proxy_header'];
		$config['reverse_proxy_addresses']	= (string) $_POST['reverse_proxy_addresses'];

		$engine->config->_set($config);

		$engine->log(1, $engine->_t('SystemSettingsUpdated', SYSTEM_LANG));
		$engine->set_message($engine->_t('SystemSettingsUpdated'), 'success');
		$engine->http->redirect($engine->href());
	}

	echo $engine->form_open('system');
?>
		<input type="hidden" name="action" value="update">
		<table class="setting formation">
			<colgroup>
				<col span="1">
				<col span="1">
			</colgroup>
			<tr>
				<th colspan="2"><?php echo $engine->_t('DebugModeSection');?></th>
			</tr>
			<tr class="hl-setting">
				<td class="label">
					<label for="debug_mode"><strong><?php echo $engine->_t('DebugMode');?></strong><br>
					<small><?php echo $engine->_t('DebugModeInfo');?></small></label>
				</td>
				<td>
					<select id="debug_mode" name="debug">
					<?php
						$debug_modes = $engine->_t('DebugModes');

						foreach ($debug_modes as $mode => $debug_mode)
						{
							echo '<option value="' . $mode . '" ' . ( (int) $engine->db->debug === $mode ? 'selected' : '') . '>' . $mode . ': ' . $debug_mode . '</option>' . "\n";
						}
					?>
					</select>
				</td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl-setting">
				<td class="label">
					<label for="debug_sql_threshold"><strong><?php echo $engine->_t('DebugSqlThreshold');?></strong><br>
					<small><?php echo $engine->_t('DebugSqlThresholdInfo');?></small></label></td>
				<td>
					<input type="number" min="0" maxlength="10" id="debug_sql_threshold" name="debug_sql_threshold" value="<?php echo (int) $engine->db->debug_sql_threshold;?>">
				</td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl-setting">
				<td class="label">
					<label for="debug_admin_only"><strong><?php echo $engine->_t('DebugAdminOnly');?></strong><br>
					<small><?php echo $engine->_t('DebugAdminOnlyInfo');?></small></label>
				</td>
				<td>
					<input type="checkbox" id="debug_admin_only" name="debug_admin_only" value="1"<?php echo ($engine->db->debug_admin_only ? ' checked' : '');?>>
				</td>
			</tr>
			<tr>
				<th colspan="2">
					<br>
					<?php echo $engine->_t('CachingSection');?>
				</th>
			</tr>
			<tr class="hl-setting">
				<td class="label">
					<label for="cache"><strong><?php echo $engine->_t('Cache');?></strong><br>
					<small><?php echo $engine->_t('CacheInfo');?></small></label>
				</td>
				<td>
					<input type="checkbox" id="cache" name="cache" value="1"<?php echo ($engine->db->cache ? ' checked' : '');?>>
				</td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl-setting">
				<td class="label">
					<label for="cache_ttl"><strong><?php echo $engine->_t('CacheTtl');?></strong><br>
					<small><?php echo $engine->_t('CacheTtlInfo');?></small></label>
				</td>
				<td>
					<input type="number" min="0" maxlength="5" id="cache_ttl" name="cache_ttl" value="<?php echo (int) $engine->db->cache_ttl;?>">
				</td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl-setting">
				<td class="label">
					<label for="cache_sql"><strong><?php echo $engine->_t('CacheSql');?></strong><br>
					<small><?php echo $engine->_t('CacheSqlInfo');?></small></label>
				</td>
				<td>
					<input type="checkbox" id="cache_sql" name="cache_sql" value="1"<?php echo ($engine->db->cache_sql ? ' checked' : '');?>>
				</td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl-setting">
				<td class="label">
					<label for="cache_sql_ttl"><strong><?php echo $engine->_t('CacheSqlTtl');?></strong><br>
					<small><?php echo $engine->_t('CacheSqlTtlInfo');?></small></label>
				</td>
				<td>
					<input type="number" min="0" maxlength="5" id="cache_sql_ttl" name="cache_sql_ttl" value="<?php echo (int) $engine->db->cache_sql_ttl;?>">
				</td>
			</tr>
			<tr>
				<th colspan="2">
					<br>
					<?php echo $engine->_t('LogSection');?>
				</th>
			</tr>
			<tr class="hl-setting">
				<td class="label">
					<label for="log_level"><strong><?php echo $engine->_t('LogLevelUsage');?></strong><br>
					<small><?php echo $engine->_t('LogLevelUsageInfo');?></small></label>
				</td>
				<td>
					<select id="log_level" name="log_level">
					<?php
						$log_thresholds = $engine->_t('LogThresholds');

						foreach ($log_thresholds as $mode => $log_threshold)
						{
							echo '<option value="' . $mode . '" ' . ( (int) $engine->db->log_level === $mode ? 'selected' : '') . '>' . $mode . ': ' . $log_threshold . '</option>' . "\n";
						}
					?>
					</select>
				</td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl-setting">
				<td class="label">
					<label for="log_default_show"><strong><?php echo $engine->_t('LogDefaultShow');?></strong><br>
					<small><?php echo $engine->_t('LogDefaultShowInfo');?></small></label>
				</td>
				<td>
					<select id="log_default_show" name="log_default_show">
					<?php
						$log_modes = $engine->_t('LogModes');

						foreach ($log_modes as $mode => $log_mode)
						{
							echo '<option value="' . $mode . '" ' . ( (int) $engine->db->log_default_show === $mode ? 'selected' : '') . '>' . $mode . ': ' . $log_mode . '</option>' . "\n";
						}
					?>
					</select>
				</td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl-setting">
				<td class="label">
					<label for="log_purge_time"><strong><?php echo $engine->_t('LogPurgeTime');?></strong><br>
					<small><?php echo $engine->_t('LogPurgeTimeInfo');?></small></label>
				</td>
				<td>
					<input type="number" min="0" maxlength="4" id="log_purge_time" name="log_purge_time" value="<?php echo (int) $engine->db->log_purge_time;?>">
				</td>
			</tr>
			<tr>
				<th colspan="2">
					<br>
					<?php echo $engine->_t('PrivacySection');?>
				</th>
			</tr>
			<tr class="hl-setting">
				<td class="label">
					<label for="approve_new_user"><strong><?php echo $engine->_t('AnonymizeIp');?></strong><br>
					<small><?php echo $engine->_t('AnonymizeIpInfo');?></small></label>
				</td>
				<td>
					<input type="radio" id="anonymize_ip_on" name="anonymize_ip" value="1"<?php echo ($engine->db->anonymize_ip == 1 ? ' checked' : '');?>><label for="anonymize_ip_on"><?php echo $engine->_t('On');?></label>
					<input type="radio" id="anonymize_ip_off" name="anonymize_ip" value="0"<?php echo ($engine->db->anonymize_ip == 0 ? ' checked' : '');?>><label for="anonymize_ip_off"><?php echo $engine->_t('Off');?></label>
				</td>
			</tr>
			<tr>
				<th colspan="2">
					<br>
					<?php echo $engine->_t('ReverseProxySection');?>
				</th>
			</tr>
			<tr class="hl-setting">
				<td class="label">
					<label for="reverse_proxy"><strong><?php echo $engine->_t('ReverseProxy');?></strong><br>
					<small><?php echo $engine->_t('ReverseProxyInfo');?></small></label>
				</td>
				<td>
					<input type="checkbox" id="reverse_proxy" name="reverse_proxy" value="1"<?php echo ($engine->db->reverse_proxy == 1 ? ' checked' : '');?>>
				</td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl-setting">
				<td class="label">
					<label for="reverse_proxy_header"><strong><?php echo $engine->_t('ReverseProxyHeader');?></strong><br>
					<small><?php echo $engine->_t('ReverseProxyHeaderInfo');?></small></label>
				</td>
				<td>
					<input type="text" size="50" maxlength="50" id="reverse_proxy_header" name="reverse_proxy_header" value="<?php echo Ut::html($engine->db->reverse_proxy_header);?>">
				</td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl-setting">
				<td class="label">
					<label for="reverse_proxy_addresses"><strong><?php echo $engine->_t('ReverseProxyAddresses');?></strong><br>
					<small><?php echo $engine->_t('ReverseProxyAddressesInfo');?></small></label>
				</td>
				<td>
					<input type="text" size="50" maxlength="50" id="reverse_proxy_addresses" name="reverse_proxy_addresses" value="<?php echo Ut::html($engine->db->reverse_proxy_addresses);?>">
				</td>
			</tr>
			<tr>
				<th colspan="2">
					<br>
					<?php echo $engine->_t('SessionSection');?>
				</th>
			</tr>
			<tr class="hl-setting">
				<td class="label">
					<label for="session_store"><strong><?php echo $engine->_t('SessionStorage');?></strong><br>
					<small><?php echo $engine->_t('SessionStorageInfo');?></small></label>
				</td>
				<td>
					<select id="session_store" name="session_store">
					<?php
						$store_modes = $engine->_t('SessionModes');

						foreach ($store_modes as $mode => $store_mode)
						{
							echo '<option value="' . $mode . '" ' . ( (int) $engine->db->session_store === $mode ? 'selected' : '') . '>' . $mode . ': ' . $store_mode . '</option>' . "\n";
						}
					?>
					</select>
				</td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl-setting">
				<td class="label">
					<label for="session_notice"><strong><?php echo $engine->_t('SessionNotice');?></strong><br>
					<small><?php echo $engine->_t('SessionNoticeInfo');?></small></label>
				</td>
				<td>
					<input type="radio" id="session_notice_off" name="session_notice" value="0"<?php echo ($engine->db->session_notice == 0 ? ' checked' : '');?>><label for="session_notice_off"><?php echo $engine->_t('Off');?></label>
					<input type="radio" id="session_notice_on" name="session_notice" value="1"<?php echo ($engine->db->session_notice == 1 ? ' checked' : '');?>><label for="session_notice_on"><?php echo $engine->_t('On');?></label>
					<input type="radio" id="session_notice_admin" name="session_notice" value="2"<?php echo ($engine->db->session_notice == 2 ? ' checked' : '');?>><label for="session_notice_admin"><?php echo $engine->_t('Admin');?></label>
				</td>
			</tr>
			<tr>
				<th colspan="2">
					<br>
					<?php echo $engine->_t('MiscellaneousSection');?>
				</th>
			</tr>
			<tr class="hl-setting">
				<td class="label">
					<label for="rewrite_mode"><strong><?php echo $engine->_t('RewriteMode');?></strong><br>
					<small><?php echo $engine->_t('RewriteModeInfo');?></small></label>
				</td>
				<td>
					<input type="checkbox" id="rewrite_mode" name="rewrite_mode" value="1" <?php echo ($engine->db->rewrite_mode == 1 ? ' checked' : '');?>>
				</td>
			</tr>
		</table>
		<br>
		<div class="center">
			<button type="submit" id="submit"><?php echo $engine->_t('SaveButton');?></button>
			<button type="reset" id="button"><?php echo $engine->_t('ResetButton');?></button>
		</div>
<?php
	echo $engine->form_close();
}

