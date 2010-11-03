<?php

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
		$config['debug']				= (int)$_POST['debug'];
		$config['debug_sql_threshold']			= (float)$_POST['debug_sql_threshold'];
		$config['debug_admin_only']			= (int)$_POST['debug_admin_only'];
		$config['cache']				= (int)$_POST['cache'];
		$config['cache_ttl']			= (int)$_POST['cache_ttl'];
		$config['cache_sql']			= (int)$_POST['cache_sql'];
		$config['cache_sql_ttl']			= (int)$_POST['cache_sql_ttl'];
		// $config['bbcode']			= (int)$_POST['bbcode'];
		$config['allow_x11colors']			= (int)$_POST['allow_x11colors'];
		$config['default_typografica']			= (int)$_POST['default_typografica'];
		$config['paragrafica']			= (int)$_POST['paragrafica'];
		$config['allow_rawhtml']			= (int)$_POST['allow_rawhtml'];
		$config['disable_safehtml']			= (int)$_POST['disable_safehtml'];
		$config['date_format']			= (string)$_POST['date_format'];
		$config['time_format']			= (string)$_POST['time_format'];
		$config['time_format_seconds']			= (string)$_POST['time_format_seconds'];
		$config['name_date_macro']			= (string)$_POST['name_date_macro'];
		$config['date_macro_format']			= (string)$_POST['date_macro_format'];
		$config['date_precise_format']			= (string)$_POST['date_precise_format'];
		$config['cookie_prefix']			= (string)$_POST['cookie_prefix'];
		$config['session_prefix']			= (string)$_POST['session_prefix'];
		$config['rewrite_mode']			= (int)$_POST['rewrite_mode'];

		foreach($config as $key => $value)
		{
			$engine->query(
				"UPDATE {$engine->config['table_prefix']}config SET value = '$value' WHERE config_name = '$key'");
		}
		$engine->log(1, 'Updated config parameters');
		$engine->redirect(rawurldecode($engine->href()));
	}
?>
	<form action="admin.php" method="post" name="system">
		<input type="hidden" name="mode" value="configsystem" />
		<input type="hidden" name="action" value="update" />
		<table cellspacing="3" class="formation">
			<tr>
				<th colspan="2">Debug mode</th>
			</tr>
			<tr>
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
			<tr>
				<td class="label"><label for="debug_sql_threshold"><strong>Threshold performance RDBMS:</strong><br />
				<small>In the detailed debug mode to record only the queries take longer than the number of seconds.</small></label></td>
				<td><input maxlength="10" style="width:200px;" id="debug_sql_threshold" name="debug_sql_threshold" value="<?php echo htmlspecialchars($engine->config['debug_sql_threshold']);?>" /></td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr>
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
			<tr>
				<td class="label"><label for="cache"><strong>Cache rendered pages:</strong><br />
				<small>Save rendered pages in the local cache to speed up the subsequent boot. Valid only for unregistered visitors.</small></label></td>
				<td><input type="checkbox" id="cache" name="cache" value="1"<?php echo ( $engine->config['cache'] ? ' checked="checked"' : '' );?> /></td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr>
				<td class="label"><label for="cache_ttl"><strong>Term relevance cached pages:</strong><br />
				<small>Cache pages no more than a specified number of seconds.</small></label></td>
				<td><input maxlength="5" style="width:200px;" id="cache_ttl" name="cache_ttl" value="<?php echo htmlspecialchars($engine->config['cache_ttl']);?>" /></td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr>
				<td class="label"><label for="cache_sql"><strong>Cache DBMS queries:</strong><br />
				<small>Maintain a local cache the results of certain resource-SQL-queries.</small></label></td>
				<td><input type="checkbox" id="cache_sql" name="cache_sql" value="1"<?php echo ( $engine->config['cache_sql'] ? ' checked="checked"' : '' );?> /></td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr>
				<td class="label"><label for="cache_sql_ttl"><strong>Term relevance Cache Database:</strong><br />
				<small>Cache results of SQL-queries for no more than the specified number of seconds. Using the values of more than 1200 is not desirable.</small></label></td>
				<td><input maxlength="5" style="width:200px;" id="cache_sql_ttl" name="cache_sql_ttl" value="<?php echo htmlspecialchars($engine->config['cache_sql_ttl']);?>" /></td>
			</tr>
			<tr>
				<th colspan="2">
					<br />
					Text Handler
				</th>
			</tr>
			<!--<tr>
				<td class="label"><label for="bbcode"><strong>Parser BBCode:</strong></label></td>
				<td><input type="checkbox" id="bbcode" name="bbcode" value="1"<?php echo ( $engine->config['bbcode'] ? ' checked="checked"' : '' );?> /></td>
			</tr>-->
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr>
				<td class="label"><label for="allow_x11colors"><strong>X11 Colors Usage:</strong><br />
				<small>Extents the available colors for <tt>??(color) background??</tt> and <tt>!!(color) text!!</tt> Unsetting slightly speed up the process of adding comments and save the page.</small></label></td>
				<td><input type="checkbox" id="allow_x11colors" name="allow_x11colors" value="1"<?php echo ( $engine->config['allow_x11colors'] ? ' checked="checked"' : '' );?> /></td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr>
				<td class="label"><label for="default_typografica"><strong>Typographical Proofreader:</strong><br />
				<small>Unsetting slightly speed up the process of adding comments and save the page.</small></label></td>
				<td><input type="checkbox" id="default_typografica" name="default_typografica" value="1"<?php echo ( $engine->config['default_typografica'] ? ' checked="checked"' : '' );?> /></td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr>
				<td class="label"><label for="paragrafica"><strong>Paragrafica markings:</strong><br />
				<small>Similar to the previous option, but will lead to disconnection of inoperable automatic table of contents: <tt>{{toc}}</tt>.</small></label></td>
				<td><input type="checkbox" id="paragrafica" name="paragrafica" value="1"<?php echo ( $engine->config['paragrafica'] ? ' checked="checked"' : '' );?> /></td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr>
				<td class="label"><label for="allow_rawhtml"><strong>Global HTML Support:</strong><br />
				<small>Use this option to open a potentially unsafe site.</small></label></td>
				<td><input type="checkbox" id="allow_rawhtml" name="allow_rawhtml" value="1"<?php echo ( $engine->config['allow_rawhtml'] ? ' checked="checked"' : '' );?> /></td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr>
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
					Date Formats
				</th>
			</tr>
			<tr>
				<td class="label"><label for="date_format"><strong>The format of the date (day, month, year):</strong></label></td>
				<td><input maxlength="50" style="width:200px;" id="date_format" name="date_format" value="<?php echo htmlspecialchars($engine->config['date_format']);?>" /></td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr>
				<td class="label"><label for="time_format"><strong>The format of time (hour, minute):</strong></label></td>
				<td><input maxlength="50" style="width:200px;" id="time_format" name="time_format" value="<?php echo htmlspecialchars($engine->config['time_format']);?>" /></td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr>
				<td class="label"><label for="time_format_seconds"><strong>The format of the exact time (hours, minutes, seconds):</strong></label></td>
				<td><input maxlength="50" style="width:200px;" id="time_format_seconds" name="time_format_seconds" value="<?php echo htmlspecialchars($engine->config['time_format_seconds']);?>" /></td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr>
				<td class="label"><label for="name_date_macro"><strong>The format of a macro (name, time):</strong></label></td>
				<td><input maxlength="50" style="width:200px;" id="name_date_macro" name="name_date_macro" value="<?php echo htmlspecialchars($engine->config['name_date_macro']);?>" /></td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr>
				<td class="label"><label for="date_macro_format"><strong>Format Date / Time for a macro:</strong></label></td>
				<td><input maxlength="50" style="width:200px;" id="date_macro_format" name="date_macro_format" value="<?php echo htmlspecialchars($engine->config['date_macro_format']);?>" /></td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr>
				<td class="label"><label for="date_precise_format"><strong>The format of the exact time / date for a macro:</strong></label></td>
				<td><input maxlength="50" style="width:200px;" id="date_precise_format" name="date_precise_format" value="<?php echo htmlspecialchars($engine->config['date_precise_format']);?>" /></td>
			</tr>
			<tr>
				<th colspan="2">
					<br />
					Miscellaneous
				</th>
			</tr>
			<tr>
				<td class="label"><label for="cookie_prefix"><strong>The prefix for the names of cookies:</strong><br />
				<small>Special prefix used for all the cookies platform.</small></label></td>
				<td><input maxlength="50" style="width:200px;" id="cookie_prefix" name="cookie_prefix" value="<?php echo htmlspecialchars($engine->config['cookie_prefix']);?>" /></td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr>
				<td class="label"><label for="session_prefix"><strong>The prefix for the names of session:</strong><br />
				<small>Special prefix used for all the session platform.</small></label></td>
				<td><input maxlength="50" style="width:200px;" id="session_prefix" name="session_prefix" value="<?php echo htmlspecialchars($engine->config['session_prefix']);?>" /></td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr>
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
