<?php

if (!defined('IN_WACKO'))
{
	exit;
}

########################################################
##   Formatter setting                                ##
########################################################

$module['config_formatter'] = array(
		'order'	=> 230,
		'cat'	=> 'Preferences',
		'status'=> (RECOVERY_MODE ? false : true),
		'mode'	=> 'config_formatter',
		'name'	=> 'Formatter',
		'title'	=> 'Formatting options',
	);

########################################################

function admin_config_formatter(&$engine, &$module)
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
		// check form token
		if (!$engine->validate_form_token('formatter'))
		{
			$message = $engine->get_translation('FormInvalid');
			$engine->set_message($message, 'error');
		}
		else
		{
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
			$config['link_target']				= (int)$_POST['link_target'];
			$config['urls_underscores']			= (int)$_POST['urls_underscores'];
			$config['show_spaces']				= (int)$_POST['show_spaces'];
			$config['youarehere_text']			= (string)$_POST['youarehere_text'];
			$config['numerate_links']			= (int)$_POST['numerate_links'];

			$engine->config->_set($config);

			$engine->log(1, 'Updated formatting settings');
			$engine->set_message('Updated formatting settings', 'success');
			$engine->redirect(rawurldecode($engine->href()));
		}
	}

	echo $engine->form_open('formatter', '', 'post', true, '', '');
?>
		<input type="hidden" name="action" value="update" />
		<table class="formation">
			<tr>
				<th colspan="2">
					<br />
					Text Handler
				</th>
			</tr>
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
				<small>Similar to the previous option, but will lead to disconnection of inoperable automatic table of contents: <code>{{toc}}</code>.</small></label></td>
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
				<small>Blocks dangerous HTML-conservation facilities. Turn off the filter to open the site when the support HTML <span class="underline">very</span> undesirable!</small></td>
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
				<small>Extents the available colors for <code>??(color) background??</code> and <code>!!(color) text!!</code> Unsetting slightly speed up the process of adding comments and save the page.</small></label></td>
				<td><input type="checkbox" id="allow_x11colors" name="allow_x11colors" value="1"<?php echo ( $engine->config['allow_x11colors'] ? ' checked="checked"' : '' );?> /></td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl_setting">
				<td class="label"><label for="disable_tikilinks"><strong>Disable Tikilinks:</strong><br />
				<small>Disables linking for <code>Double.CamelCaseWords</code>.</small></label></td>
				<td><input type="checkbox" id="disable_tikilinks" name="disable_tikilinks" value="1"<?php echo ( $engine->config['disable_tikilinks'] ? ' checked="checked"' : '' );?> /></td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl_setting">
				<td class="label"><label for="disable_wikilinks"><strong>Disable Wikilinks:</strong><br />
				<small>Disables linking for <code>CamelCaseWords</code>, your CamelCase Words will no longer be linked directly to a new page </small></label></td>
				<td><input type="checkbox" id="disable_wikilinks" name="disable_wikilinks" value="1"<?php echo ( $engine->config['disable_wikilinks'] ? ' checked="checked"' : '' );?> /></td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl_setting">
				<td class="label"><label for="disable_bracketslinks"><strong>Disable bracketslinks:</strong><br />
				<small>Disables <code>[[link]]</code> and <code>((link))</code> syntax.</small></label></td>
				<td><input type="checkbox" id="disable_bracketslinks" name="disable_bracketslinks" value="1"<?php echo ( $engine->config['disable_bracketslinks'] ? ' checked="checked"' : '' );?> /></td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<!--<tr class="hl_setting">
				<td class="label"><label for="disable_npjlinks"><strong>Disable Npjlinks:</strong><br />
				<small>Disables linking for <code>See::Example</code> and <code>user@node:address</code> links.</small></label></td>
				<td><input type="checkbox" id="disable_npjlinks" name="disable_npjlinks" value="1"<?php echo ( $engine->config['disable_npjlinks'] ? ' checked="checked"' : '' );?> /></td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>-->
			<tr class="hl_setting">
				<td class="label"><label for="disable_formatters"><strong>Disable Formatters:</strong><br />
				<small>Disables <code>%%code%%</code> syntax, used for highlighters.</small></label></td>
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
				<td><input type="text" maxlength="50" style="width:200px;" id="date_format" name="date_format" value="<?php echo htmlspecialchars($engine->config['date_format'], ENT_COMPAT | ENT_HTML401, HTML_ENTITIES_CHARSET);?>" /></td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl_setting">
				<td class="label"><label for="time_format"><strong>The format of time (hour, minute):</strong></label></td>
				<td><input type="text" maxlength="50" style="width:200px;" id="time_format" name="time_format" value="<?php echo htmlspecialchars($engine->config['time_format'], ENT_COMPAT | ENT_HTML401, HTML_ENTITIES_CHARSET);?>" /></td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl_setting">
				<td class="label"><label for="time_format_seconds"><strong>The format of the exact time (hours, minutes, seconds):</strong></label></td>
				<td><input type="text" maxlength="50" style="width:200px;" id="time_format_seconds" name="time_format_seconds" value="<?php echo htmlspecialchars($engine->config['time_format_seconds'], ENT_COMPAT | ENT_HTML401, HTML_ENTITIES_CHARSET);?>" /></td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl_setting">
				<td class="label"><label for="name_date_macro"><strong>The format of a macro (name, time):</strong></label></td>
				<td><input type="text" maxlength="50" style="width:200px;" id="name_date_macro" name="name_date_macro" value="<?php echo htmlspecialchars($engine->config['name_date_macro'], ENT_COMPAT | ENT_HTML401, HTML_ENTITIES_CHARSET);?>" /></td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl_setting">
				<td class="label"><label for="date_macro_format"><strong>Format Date / Time for a macro:</strong></label></td>
				<td><input type="text" maxlength="50" style="width:200px;" id="date_macro_format" name="date_macro_format" value="<?php echo htmlspecialchars($engine->config['date_macro_format'], ENT_COMPAT | ENT_HTML401, HTML_ENTITIES_CHARSET);?>" /></td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl_setting">
				<td class="label"><label for="date_precise_format"><strong>The format of the exact time / date for a macro:</strong></label></td>
				<td><input type="text" maxlength="50" style="width:200px;" id="date_precise_format" name="date_precise_format" value="<?php echo htmlspecialchars($engine->config['date_precise_format'], ENT_COMPAT | ENT_HTML401, HTML_ENTITIES_CHARSET);?>" /></td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl_setting">
				<td class="label" scope="row"><label for="timezone"><strong><?php echo $engine->get_translation('Timezone');?></strong><br />
				<small>Timezone to use for displaying times to users who are not logged in (guests). Logged in users set and can change their timezone it in their user settings.</small></label></td>
				<td class="form_right"><select id="timezone" name="timezone">

		<?php
			$timezones = $engine->get_translation('TzZoneArray');

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
					Miscellaneous
				</th>
			</tr>
			<tr class="hl_setting">
				<td class="label"><label for="enable_link_target"><strong>Where external links open:</strong><br />
				<small>Opens each external link in a new browser window. Adds <code>target="_blank"</code> to the link syntax.</small></label></td>
				<td><input type="checkbox" id="enable_link_target" name="link_target" value="1"<?php echo ( $engine->config['link_target'] ? ' checked="checked"' : '' );?> /></td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl_setting">
				<td class="label"><label for="enable_urls_underscores"><strong>Form addresses (URLs) with underscores:</strong><br />
				<small>For example <code>http://[..]/WackoWiki</code> becames <code>http://[..]/Wacko_Wiki</code> with this option.</small></label></td>
				<td><input type="checkbox" id="enable_urls_underscores" name="urls_underscores" value="1"<?php echo ( $engine->config['urls_underscores'] ? ' checked="checked"' : '' );?> /></td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl_setting">
				<td class="label"><label for="enable_show_spaces"><strong>Show spaces in WikiNames:</strong><br />
				<small>Show spaces in WikiNames, e.g. <code>MyName</code> beeing displayed as <code>My Name</code> with this option.</small></label></td>
				<td><input type="checkbox" id="enable_show_spaces" name="show_spaces" value="1"<?php echo ( $engine->config['show_spaces'] ? ' checked="checked"' : '' );?> /></td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl_setting">
				<td class="label"><label for="enable_numerate_links"><strong>Numerate links in print view:</strong><br />
				<small>Numerates and lists all links at the bottom of the print view with this option.</small></label></td>
				<td><input type="checkbox" id="enable_numerate_links" name="numerate_links" value="1"<?php echo ( $engine->config['numerate_links'] ? ' checked="checked"' : '' );?> /></td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl_setting">
				<td class="label"><label for="enable_youarehere_text"><strong>Disable and visualize self-referencing links:</strong><br />
				<small>Visualizing links to the same page, try to <code>'&lt;b&gt;####&lt;/b&gt;'</code>, all links-to-self became not links, but bold text.</small></label></td>
				<td><input type="text" maxlength="50" style="width:200px;" id="enable_youarehere_text" name="youarehere_text" value="<?php echo htmlspecialchars($engine->config['youarehere_text'], ENT_COMPAT | ENT_HTML401, HTML_ENTITIES_CHARSET);?>" /></td>
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
