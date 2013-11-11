<?php

if (!defined('IN_WACKO'))
{
	exit;
}

########################################################
##   Maintaince setting                               ##
########################################################

$module['configsystem'] = array(
		'order'	=> 2,
		'cat'	=> 'Preferences',
		'mode'	=> 'configsystem',
		'name'	=> 'System',
		'title'	=> 'System options',
	);

########################################################

function admin_configsystem(&$engine, &$module)
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
		$config['allow_x11colors']			= (int)$_POST['allow_x11colors'];
		$config['default_typografica']		= (int)$_POST['default_typografica'];
		$config['paragrafica']				= (int)$_POST['paragrafica'];
		$config['allow_rawhtml']			= (int)$_POST['allow_rawhtml'];
		$config['disable_safehtml']			= (int)$_POST['disable_safehtml'];
		$config['disable_tikilinks']		= (int)$_POST['disable_tikilinks'];
		$config['disable_bracketslinks']	= (int)$_POST['disable_bracketslinks'];
		$config['disable_wikilinks']		= (int)$_POST['disable_wikilinks'];
		$config['disable_formatters']		= (int)$_POST['disable_formatters'];
		$config['date_format']				= (string)$_POST['date_format'];
		$config['time_format']				= (string)$_POST['time_format'];
		$config['time_format_seconds']		= (string)$_POST['time_format_seconds'];
		$config['name_date_macro']			= (string)$_POST['name_date_macro'];
		$config['date_macro_format']		= (string)$_POST['date_macro_format'];
		$config['date_precise_format']		= (string)$_POST['date_precise_format'];
		$config['timezone']					= (float)$_POST['timezone'];
		$config['dst']						= (int)$_POST['dst'];
		$config['cookie_prefix']			= (string)$_POST['cookie_prefix'];
		$config['session_prefix']			= (string)$_POST['session_prefix'];
		$config['rewrite_mode']				= (int)$_POST['rewrite_mode'];
		$config['reverse_proxy']			= (int)$_POST['reverse_proxy'];
		$config['reverse_proxy_header']		= (int)$_POST['reverse_proxy_header'];
		$config['reverse_proxy_addresses']	= (int)$_POST['reverse_proxy_addresses'];

		foreach($config as $key => $value)
		{
			$engine->set_config($key, $value);
		}

		$engine->destroy_config_cache();
		$engine->log(1, 'Updated config parameters');
		$engine->redirect(rawurldecode($engine->href()));
	}
?>
	<form action="admin.php" method="post" name="system">
		<input type="hidden" name="mode" value="configsystem" />
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
						<option value="0"<?php echo ( (int)$engine->config['debug'] === 0 ? ' selected="selected"' : '' );?>>0: debugging is off</option>
						<option value="1"<?php echo ( (int)$engine->config['debug'] === 1 ? ' selected="selected"' : '' );?>>1: only the total execution time</option>
						<option value="2"<?php echo ( (int)$engine->config['debug'] === 2 ? ' selected="selected"' : '' );?>>2: full-time</option>
						<option value="3"<?php echo ( (int)$engine->config['debug'] === 3 ? ' selected="selected"' : '' );?>>3: full detail (DBMS, cache, etc.)</option>
					</select>
				</td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl_setting">
				<td class="label"><label for="debug_sql_threshold"><strong>Threshold performance RDBMS:</strong><br />
				<small>In the detailed debug mode to record only the queries take longer than the number of seconds.</small></label></td>
				<td><input maxlength="10" style="width:200px;" id="debug_sql_threshold" name="debug_sql_threshold" value="<?php echo htmlspecialchars($engine->config['debug_sql_threshold'], ENT_COMPAT | ENT_HTML401, $engine->charset);?>" /></td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl_setting">
				<td class="label"><label for="debug_admin_only"><strong>Closed diagnosis:</strong><br />
				<small>Show debug data of the program (and DBMS) only for the administrator.</small></label></td>
				<td><input type="checkbox" id="debug_admin_only" name="debug_admin_only" value="1"<?php echo ( $engine->config['debug_admin_only'] ? ' checked="checked"' : '' );?> /></td>
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
				<td><input type="checkbox" id="cache" name="cache" value="1"<?php echo ( $engine->config['cache'] ? ' checked="checked"' : '' );?> /></td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl_setting">
				<td class="label"><label for="cache_ttl"><strong>Term relevance cached pages:</strong><br />
				<small>Cache pages no more than a specified number of seconds.</small></label></td>
				<td><input maxlength="5" style="width:200px;" id="cache_ttl" name="cache_ttl" value="<?php echo htmlspecialchars($engine->config['cache_ttl'], ENT_COMPAT | ENT_HTML401, $engine->charset);?>" /></td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl_setting">
				<td class="label"><label for="cache_sql"><strong>Cache DBMS queries:</strong><br />
				<small>Maintain a local cache the results of certain resource-SQL-queries.</small></label></td>
				<td><input type="checkbox" id="cache_sql" name="cache_sql" value="1"<?php echo ( $engine->config['cache_sql'] ? ' checked="checked"' : '' );?> /></td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl_setting">
				<td class="label"><label for="cache_sql_ttl"><strong>Term relevance Cache Database:</strong><br />
				<small>Cache results of SQL-queries for no more than the specified number of seconds. Using the values of more than 1200 is not desirable.</small></label></td>
				<td><input maxlength="5" style="width:200px;" id="cache_sql_ttl" name="cache_sql_ttl" value="<?php echo htmlspecialchars($engine->config['cache_sql_ttl'], ENT_COMPAT | ENT_HTML401, $engine->charset);?>" /></td>
			</tr>
			<tr>
				<th colspan="2">
					<br />
					Text Handler
				</th>
			</tr>
			<!--<tr class="hl_setting">
				<td class="label"><label for="bbcode"><strong>Parser BBCode:</strong></label></td>
				<td><input type="checkbox" id="bbcode" name="bbcode" value="1" <?php #echo ( $engine->config['bbcode'] ? ' checked="checked"' : '' );?> /></td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>-->
			<tr class="hl_setting">
				<td class="label"><label for="default_typografica"><strong>Typographical Proofreader:</strong><br />
				<small>Unsetting slightly speed up the process of adding comments and save the page.</small></label></td>
				<td><input type="checkbox" id="default_typografica" name="default_typografica" value="1"<?php echo ( $engine->config['default_typografica'] ? ' checked="checked"' : '' );?> /></td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl_setting">
				<td class="label"><label for="paragrafica"><strong>Paragrafica markings:</strong><br />
				<small>Similar to the previous option, but will lead to disconnection of inoperable automatic table of contents: <tt>{{toc}}</tt>.</small></label></td>
				<td><input type="checkbox" id="paragrafica" name="paragrafica" value="1"<?php echo ( $engine->config['paragrafica'] ? ' checked="checked"' : '' );?> /></td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl_setting">
				<td class="label"><label for="allow_rawhtml"><strong>Global HTML Support:</strong><br />
				<small>Use this option to open a potentially unsafe site.</small></label></td>
				<td><input type="checkbox" id="allow_rawhtml" name="allow_rawhtml" value="1"<?php echo ( $engine->config['allow_rawhtml'] ? ' checked="checked"' : '' );?> /></td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl_setting">
				<td class="label"><strong>Filtering HTML:</strong><br />
				<small>Blocks dangerous HTML-conservation facilities. Turn off the filter to open the site when the support HTML <u>very</u> undesirable!</small></td>
				<td>
					<input type="radio" id="disable_safehtml_on" name="disable_safehtml" value="0"<?php echo ( !$engine->config['disable_safehtml'] ? ' checked="checked"' : '' );?> /><label for="disable_safehtml_on">On.</label>
					<input type="radio" id="disable_safehtml_off" name="disable_safehtml" value="1"<?php echo ( $engine->config['disable_safehtml'] ? ' checked="checked"' : '' );?> /><label for="disable_safehtml_off">Off.</label>
				</td>
			</tr>
			<tr>
				<th colspan="2">
					<br />
					Wiki Text Formatter (Wacko Formatter)
				</th>
			</tr>
			<tr class="hl_setting">
				<td class="label"><label for="allow_x11colors"><strong>X11 Colors Usage:</strong><br />
				<small>Extents the available colors for <tt>??(color) background??</tt> and <tt>!!(color) text!!</tt> Unsetting slightly speed up the process of adding comments and save the page.</small></label></td>
				<td><input type="checkbox" id="allow_x11colors" name="allow_x11colors" value="1"<?php echo ( $engine->config['allow_x11colors'] ? ' checked="checked"' : '' );?> /></td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl_setting">
				<td class="label"><label for="disable_tikilinks"><strong>Disable Tikilinks:</strong><br />
				<small>Disables linking for <tt>Double.CamelCaseWords</tt>.</small></label></td>
				<td><input type="checkbox" id="disable_tikilinks" name="disable_tikilinks" value="1"<?php echo ( $engine->config['disable_tikilinks'] ? ' checked="checked"' : '' );?> /></td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl_setting">
				<td class="label"><label for="disable_wikilinks"><strong>Disable Wikilinks:</strong><br />
				<small>Disables linking for <tt>CamelCaseWords</tt>, your CamelCase Words will no longer be linked directly to a new page </small></label></td>
				<td><input type="checkbox" id="disable_wikilinks" name="disable_wikilinks" value="1"<?php echo ( $engine->config['disable_wikilinks'] ? ' checked="checked"' : '' );?> /></td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl_setting">
				<td class="label"><label for="disable_bracketslinks"><strong>Disable bracketslinks:</strong><br />
				<small>Disables <tt>[[link]]</tt> and <tt>((link))</tt> syntax.</small></label></td>
				<td><input type="checkbox" id="disable_bracketslinks" name="disable_bracketslinks" value="1"<?php echo ( $engine->config['disable_bracketslinks'] ? ' checked="checked"' : '' );?> /></td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<!--<tr class="hl_setting">
				<td class="label"><label for="disable_npjlinks"><strong>Disable Npjlinks:</strong><br />
				<small>Disables linking for <tt>See::Example</tt> and <tt>user@node:address</tt> links.</small></label></td>
				<td><input type="checkbox" id="disable_npjlinks" name="disable_npjlinks" value="1"<?php echo ( $engine->config['disable_npjlinks'] ? ' checked="checked"' : '' );?> /></td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>-->
			<tr class="hl_setting">
				<td class="label"><label for="disable_formatters"><strong>Disable Formatters:</strong><br />
				<small>Disables <tt>%%code%%</tt> syntax, used for highlighters.</small></label></td>
				<td><input type="checkbox" id="disable_formatters" name="disable_formatters" value="1"<?php echo ( $engine->config['disable_formatters'] ? ' checked="checked"' : '' );?> /></td>
			</tr>
			<tr>
				<th colspan="2">
					<br />
					Date Formats
				</th>
			</tr>
			<tr class="hl_setting">
				<td class="label"><label for="date_format"><strong>The format of the date (day, month, year):</strong></label></td>
				<td><input maxlength="50" style="width:200px;" id="date_format" name="date_format" value="<?php echo htmlspecialchars($engine->config['date_format'], ENT_COMPAT | ENT_HTML401, $engine->charset);?>" /></td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl_setting">
				<td class="label"><label for="time_format"><strong>The format of time (hour, minute):</strong></label></td>
				<td><input maxlength="50" style="width:200px;" id="time_format" name="time_format" value="<?php echo htmlspecialchars($engine->config['time_format'], ENT_COMPAT | ENT_HTML401, $engine->charset);?>" /></td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl_setting">
				<td class="label"><label for="time_format_seconds"><strong>The format of the exact time (hours, minutes, seconds):</strong></label></td>
				<td><input maxlength="50" style="width:200px;" id="time_format_seconds" name="time_format_seconds" value="<?php echo htmlspecialchars($engine->config['time_format_seconds'], ENT_COMPAT | ENT_HTML401, $engine->charset);?>" /></td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl_setting">
				<td class="label"><label for="name_date_macro"><strong>The format of a macro (name, time):</strong></label></td>
				<td><input maxlength="50" style="width:200px;" id="name_date_macro" name="name_date_macro" value="<?php echo htmlspecialchars($engine->config['name_date_macro'], ENT_COMPAT | ENT_HTML401, $engine->charset);?>" /></td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl_setting">
				<td class="label"><label for="date_macro_format"><strong>Format Date / Time for a macro:</strong></label></td>
				<td><input maxlength="50" style="width:200px;" id="date_macro_format" name="date_macro_format" value="<?php echo htmlspecialchars($engine->config['date_macro_format'], ENT_COMPAT | ENT_HTML401, $engine->charset);?>" /></td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl_setting">
				<td class="label"><label for="date_precise_format"><strong>The format of the exact time / date for a macro:</strong></label></td>
				<td><input maxlength="50" style="width:200px;" id="date_precise_format" name="date_precise_format" value="<?php echo htmlspecialchars($engine->config['date_precise_format'], ENT_COMPAT | ENT_HTML401, $engine->charset);?>" /></td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl_setting">
				<td class="label" scope="row"><label for="timezone"><strong><?php echo $engine->get_translation('Timezone');?></strong><br />
				<small>Timezone to use for displaying times to users who are not logged in (guests). Logged in users set and can change their timezone it in their user settings.</small></label></td>
				<td class="form_right"><select id="timezone" name="timezone">

		<?php
			$timezones = $engine->get_translation('TzZones');

			foreach ($timezones as $offset => $timezone)
			{
				if (strlen($timezone) > 50)
				{
					$timezone = substr($timezone, 0, 45 ).'...';
				}

				echo '<option value="'.$offset.'" '.
					($engine->config['timezone'] == $offset
						? "selected=\"selected\""
						: ""
					).">".$timezone."</option>\n";
			}
			?>
				</select></td>
			</tr>

			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl_setting">
				<td class="label"><strong>Enable Summer Time/DST:</strong><br />
				<small></small></td>
				<td>
					<input type="radio" id="dst_off" name="dst" value="0"<?php echo ( $engine->config['dst'] == 0 ? ' checked="checked"' : '' );?> /><label for="dst_off">Off.</label>
					<input type="radio" id="dst_on" name="dst" value="1"<?php echo ( $engine->config['dst'] == 1 ? ' checked="checked"' : '' );?> /><label for="dst_on">On.</label>
				</td>
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
				<td><input type="checkbox" id="reverse_proxy" name="reverse_proxy" value="1"<?php echo ( $engine->config['reverse_proxy'] == 1 ? ' checked="checked"' : '' );?> /></td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl_setting">
				<td class="label"><label for="reverse_proxy_header"><strong>Reverse proxy header:</strong><br />
				<small>Set this value if your proxy server sends the client IP in a header
				 other than X-Forwarded-For. The "X-Forwarded-For" header is a comma+space separated list of IP
				 addresses, only the last one (the left-most) will be used.</small></label></td>
				<td><input maxlength="50" style="width:200px;" id="reverse_proxy_header" name="reverse_proxy_header" value="<?php echo htmlspecialchars($engine->config['reverse_proxy_header'], ENT_COMPAT | ENT_HTML401, $engine->charset);?>" /></td>
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
				<td><input maxlength="50" style="width:200px;" id="reverse_proxy_addresses" name="reverse_proxy_addresses" value="<?php echo htmlspecialchars($engine->config['reverse_proxy_addresses'], ENT_COMPAT | ENT_HTML401, $engine->charset);?>" /></td>
			</tr>
			<tr>
				<th colspan="2">
					<br />
					Miscellaneous
				</th>
			</tr>
			<tr class="hl_setting">
				<td class="label"><label for="cookie_prefix"><strong>The prefix for the names of cookies:</strong><br />
				<small>Special prefix used for all the cookies platform.</small></label></td>
				<td><input maxlength="50" style="width:200px;" id="cookie_prefix" name="cookie_prefix" value="<?php echo htmlspecialchars($engine->config['cookie_prefix'], ENT_COMPAT | ENT_HTML401, $engine->charset);?>" /></td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl_setting">
				<td class="label"><label for="session_prefix"><strong>The prefix for the names of session:</strong><br />
				<small>Special prefix used for all the session platform.</small></label></td>
				<td><input maxlength="50" style="width:200px;" id="session_prefix" name="session_prefix" value="<?php echo htmlspecialchars($engine->config['session_prefix'], ENT_COMPAT | ENT_HTML401, $engine->charset);?>" /></td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl_setting">
				<td class="label"><label for="rewrite_mode"><strong>Use <tt>mod_rewrite</tt>:</strong><br />
				<small>If your web server supports this feature, turn to get "beautiful" the addresses of pages.</small></label></td>
				<td><input type="checkbox" id="rewrite_mode" name="rewrite_mode" value="1"<?php echo ( $engine->config['rewrite_mode'] == 1 ? ' checked="checked"' : '' );?> /></td>
			</tr>
		</table>
		<br />
		<div class="center">
			<input id="submit" type="submit" value="save" />
			<input id="button" type="reset" value="reset" />
		</div>
	</form>
<?php
}

?>
