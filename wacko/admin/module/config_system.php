<?php

if (!defined('IN_WACKO'))
{
	exit;
}

########################################################
##   Maintaince setting                               ##
########################################################
$_mode = 'config_system';

$module[$_mode] = [
		'order'	=> 210,
		'cat'	=> 'preferences',
		'status'=> (RECOVERY_MODE ? false : true),
		'mode'	=> $_mode,
		'name'	=> $engine->_t($_mode)['name'],		// System
		'title'	=> $engine->_t($_mode)['title'],	// System options
	];

########################################################

function admin_config_system(&$engine, &$module)
{
?>
	<h1><?php echo $module['title']; ?></h1>
	<br />
	<p>
			Group of parameters responsible for the fine tuning platform. Do not change them unless you are confident in their actions.
	</p>
	<br />
<?php
	// update settings

	if (isset($_POST['action']) && $_POST['action'] == 'update')
	{
		$config['debug']					= (int)$_POST['debug'];
		$config['debug_sql_threshold']		= (float)$_POST['debug_sql_threshold'];
		$config['debug_admin_only']			= (int)$_POST['debug_admin_only'];
		$config['cache']					= (int)$_POST['cache'];
		$config['cache_ttl']				= (int)$_POST['cache_ttl'];
		$config['cache_sql']				= (int)$_POST['cache_sql'];
		$config['cache_sql_ttl']			= (int)$_POST['cache_sql_ttl'];
		$config['rewrite_mode']				= (int)$_POST['rewrite_mode'];
		$config['reverse_proxy']			= (int)$_POST['reverse_proxy'];
		$config['reverse_proxy_header']		= $_POST['reverse_proxy_header'];
		$config['reverse_proxy_addresses']	= $_POST['reverse_proxy_addresses'];

		$engine->config->_set($config);

		$engine->log(1, 'Updated system settings');
		$engine->set_message('Updated system settings', 'success');
		$engine->http->redirect(rawurldecode($engine->href()));
	}

	echo $engine->form_open('system');
?>
		<input type="hidden" name="action" value="update" />
		<table class="formation">
			<tr>
				<th colspan="2">Debug mode</th>
			</tr>
			<tr class="hl_setting">
				<td class="label"><label for="debug_mode"><strong>Debug mode:</strong><br />
				<small>Fixation and the withdrawal of telemetry data on the time of the program. Note: the full detail of the regime imposes high demands on available memory, especially in demanding operations such as backup and restore the database.</small></label></td>
				<td style="width:40%;">
					<select style="width:200px;" id="debug_mode" name="debug">
						<option value="0"<?php echo ( (int)$engine->db->debug === 0 ? ' selected="selected"' : '' );?>>0: debugging is off</option>
						<option value="1"<?php echo ( (int)$engine->db->debug === 1 ? ' selected="selected"' : '' );?>>1: only the total execution time</option>
						<option value="2"<?php echo ( (int)$engine->db->debug === 2 ? ' selected="selected"' : '' );?>>2: full-time</option>
						<option value="3"<?php echo ( (int)$engine->db->debug === 3 ? ' selected="selected"' : '' );?>>3: full detail (DBMS, cache, etc.)</option>
					</select>
				</td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl_setting">
				<td class="label"><label for="debug_sql_threshold"><strong>Threshold performance RDBMS:</strong><br />
				<small>In the detailed debug mode to record only the queries take longer than the number of seconds.</small></label></td>
				<td><input type="number" min="0" maxlength="10" style="width:200px;" id="debug_sql_threshold" name="debug_sql_threshold" value="<?php echo htmlspecialchars($engine->db->debug_sql_threshold, ENT_COMPAT | ENT_HTML401, HTML_ENTITIES_CHARSET);?>" /></td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl_setting">
				<td class="label"><label for="debug_admin_only"><strong>Closed diagnosis:</strong><br />
				<small>Show debug data of the program (and DBMS) only for the administrator.</small></label></td>
				<td><input type="checkbox" id="debug_admin_only" name="debug_admin_only" value="1"<?php echo ( $engine->db->debug_admin_only ? ' checked="checked"' : '' );?> /></td>
			</tr>
			<tr>
				<th colspan="2">
					<br />
					Caching Options
				</th>
			</tr>
			<tr class="hl_setting">
				<td class="label"><label for="cache"><strong>Cache rendered pages:</strong><br />
				<small>Save rendered pages in the local cache to speed up the subsequent boot. Valid only for unregistered visitors.</small></label></td>
				<td><input type="checkbox" id="cache" name="cache" value="1"<?php echo ( $engine->db->cache ? ' checked="checked"' : '' );?> /></td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl_setting">
				<td class="label"><label for="cache_ttl"><strong>Term relevance cached pages:</strong><br />
				<small>Cache pages no more than a specified number of seconds.</small></label></td>
				<td><input type="number" min="0" maxlength="5" style="width:200px;" id="cache_ttl" name="cache_ttl" value="<?php echo htmlspecialchars($engine->db->cache_ttl, ENT_COMPAT | ENT_HTML401, HTML_ENTITIES_CHARSET);?>" /></td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl_setting">
				<td class="label"><label for="cache_sql"><strong>Cache DBMS queries:</strong><br />
				<small>Maintain a local cache the results of certain resource-SQL-queries.</small></label></td>
				<td><input type="checkbox" id="cache_sql" name="cache_sql" value="1"<?php echo ( $engine->db->cache_sql ? ' checked="checked"' : '' );?> /></td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl_setting">
				<td class="label"><label for="cache_sql_ttl"><strong>Term relevance Cache Database:</strong><br />
				<small>Cache results of SQL-queries for no more than the specified number of seconds. Using the values of more than 1200 is not desirable.</small></label></td>
				<td><input type="number" min="0" maxlength="5" style="width:200px;" id="cache_sql_ttl" name="cache_sql_ttl" value="<?php echo htmlspecialchars($engine->db->cache_sql_ttl, ENT_COMPAT | ENT_HTML401, HTML_ENTITIES_CHARSET);?>" /></td>
			</tr>
			<tr>
				<th colspan="2">
					<br />
					Reverse Proxy
				</th>
			</tr>
			<tr class="hl_setting">
				<td class="label"><label for="reverse_proxy"><strong>Use Reverse proxy:</strong><br />
				<small>Enable this setting to determine the correct IP address of the remote
				 client by examining information stored in the X-Forwarded-For headers.
				 X-Forwarded-For headers are a standard mechanism for identifying client
				 systems connecting through a reverse proxy server, such as Squid or
				 Pound. Reverse proxy servers are often used to enhance the performance
				 of heavily visited sites and may also provide other site caching,
				 security or encryption benefits. If this WackoWiki installation operates
				 behind a reverse proxy, this setting should be enabled so that correct
				 IP address information is captured in WackoWiki's session management,
				 logging, statistics and access management systems; if you are unsure
				 about this setting, do not have a reverse proxy, or WackoWiki operates in
				 a shared hosting environment, this setting should remain disabled.</small></label></td>
				<td><input type="checkbox" id="reverse_proxy" name="reverse_proxy" value="1"<?php echo ( $engine->db->reverse_proxy == 1 ? ' checked="checked"' : '' );?> /></td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl_setting">
				<td class="label"><label for="reverse_proxy_header"><strong>Reverse proxy header:</strong><br />
				<small>Set this value if your proxy server sends the client IP in a header
				 other than X-Forwarded-For. The "X-Forwarded-For" header is a comma+space separated list of IP
				 addresses, only the last one (the left-most) will be used.</small></label></td>
				<td><input type="text" maxlength="50" style="width:200px;" id="reverse_proxy_header" name="reverse_proxy_header" value="<?php echo htmlspecialchars($engine->db->reverse_proxy_header, ENT_COMPAT | ENT_HTML401, HTML_ENTITIES_CHARSET);?>" /></td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl_setting">
				<td class="label"><label for="reverse_proxy_addresses"><strong>reverse_proxy accepts an array of IP addresses:</strong><br />
				<small>Each element of this array is the IP address of any of your reverse
				 proxies. Filling this array WackoWiki will trust the information stored
				 in the X-Forwarded-For headers only if Remote IP address is one of
				 these, that is the request reaches the web server from one of your
				 reverse proxies. Otherwise, the client could directly connect to
				 your web server spoofing the X-Forwarded-For headers.</small></label></td>
				<td><input type="text" maxlength="50" style="width:200px;" id="reverse_proxy_addresses" name="reverse_proxy_addresses" value="<?php echo htmlspecialchars($engine->db->reverse_proxy_addresses, ENT_COMPAT | ENT_HTML401, HTML_ENTITIES_CHARSET);?>" /></td>
			</tr>
			<tr>
				<th colspan="2">
					<br />
					Miscellaneous
				</th>
			</tr>
			<tr class="hl_setting">
				<td class="label"><label for="rewrite_mode"><strong>Use <code>mod_rewrite</code>:</strong><br />
				<small>If your web server supports this feature, turn to get "beautiful" the addresses of pages.</small></label></td>
				<td><input type="checkbox" id="rewrite_mode" name="rewrite_mode" value="1"<?php echo ( $engine->db->rewrite_mode == 1 ? ' checked="checked"' : '' );?> /></td>
			</tr>
		</table>
		<br />
		<div class="center">
			<input type="submit" id="submit" value="save" />
			<input type="reset" id="button" value="reset" />
		</div>
<?php
	echo $engine->form_close();
}

?>
