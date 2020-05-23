<?php

if (!defined('IN_WACKO'))
{
	exit;
}

##########################################################
##	Formatter setting									##
##########################################################
$_mode = 'config_formatter';

$module[$_mode] = [
		'order'	=> 230,
		'cat'	=> 'preferences',
		'status'=> (RECOVERY_MODE ? false : true),
		'mode'	=> $_mode,
		'name'	=> $engine->_t($_mode)['name'],		// Formatter
		'title'	=> $engine->_t($_mode)['title'],	// Formatting options
	];

##########################################################

function admin_config_formatter(&$engine, &$module)
{
?>
	<h1><?php echo $module['title']; ?></h1>
	<br>
	<p>
		<?php echo $engine->_t('FormatterSettingsInfo');?>
	</p>
	<br>
<?php
	// update settings

	if (isset($_POST['action']) && $_POST['action'] == 'update')
	{
		$config['allow_x11colors']			= (int) ($_POST['allow_x11colors'] ?? 0);
		$config['default_typografica']		= (int) ($_POST['default_typografica'] ?? 0);
		$config['paragrafica']				= (int) ($_POST['paragrafica'] ?? 0);
		$config['allow_rawhtml']			= (int) ($_POST['allow_rawhtml'] ?? 0);
		$config['disable_safehtml']			= (int) $_POST['disable_safehtml'];
		$config['disable_bracketslinks']	= (int) ($_POST['disable_bracketslinks'] ?? 0);
		$config['disable_wikilinks']		= (int) ($_POST['disable_wikilinks'] ?? 0);
		$config['disable_formatters']		= (int) ($_POST['disable_formatters'] ?? 0);
		$config['date_format']				= (string) $_POST['date_format'];
		$config['time_format']				= (string) $_POST['time_format'];
		$config['time_format_seconds']		= (string) $_POST['time_format_seconds'];
		$config['name_date_macro']			= (string) $_POST['name_date_macro'];
		$config['timezone']					= (float)$_POST['timezone'];
		$config['dst']						= (int) $_POST['dst'];
		$config['link_target']				= (int) ($_POST['link_target'] ?? 0);
		$config['noreferrer']				= (int) ($_POST['noreferrer'] ?? 0);
		$config['nofollow']					= (int) ($_POST['nofollow'] ?? 0);
		$config['urls_underscores']			= (int) ($_POST['urls_underscores'] ?? 0);
		$config['show_spaces']				= (int) ($_POST['show_spaces'] ?? 0);
		$config['youarehere_text']			= (string) $_POST['youarehere_text'];
		$config['numerate_links']			= (int) ($_POST['numerate_links'] ?? 0);
		$config['canonical']				= (int) ($_POST['canonical'] ?? 0);

		$engine->config->_set($config);

		$engine->log(1, $engine->_t('FormatterSettingsUpdated', SYSTEM_LANG));
		$engine->set_message($engine->_t('FormatterSettingsUpdated'), 'success');
		$engine->http->redirect(rawurldecode($engine->href()));
	}

	echo $engine->form_open('formatter');
?>
		<input type="hidden" name="action" value="update">
		<table class="formation">
			<colgroup>
				<col span="1" style="width:50%;">
				<col span="1" style="width:50%;">
			</colgroup>
			<tr>
				<th colspan="2">
					<br>
					<?php echo $engine->_t('TextHandlerSection');?>
				</th>
			</tr>
			<tr class="hl-setting">
				<td class="label">
					<label for="default_typografica"><strong><?php echo $engine->_t('Typografica');?>:</strong><br>
					<small><?php echo $engine->_t('TypograficaInfo');?></small></label>
				</td>
				<td>
					<input type="checkbox" id="default_typografica" name="default_typografica" value="1"<?php echo ($engine->db->default_typografica ? ' checked' : '');?>>
				</td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl-setting">
				<td class="label">
					<label for="paragrafica"><strong><?php echo $engine->_t('Paragrafica');?>:</strong><br>
					<small><?php echo $engine->_t('ParagraficaInfo');?></small></label>
				</td>
				<td>
					<input type="checkbox" id="paragrafica" name="paragrafica" value="1"<?php echo ($engine->db->paragrafica ? ' checked' : '');?>>
				</td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl-setting">
				<td class="label">
					<label for="allow_rawhtml"><strong><?php echo $engine->_t('AllowRawhtml');?>:</strong><br>
					<small><?php echo $engine->_t('AllowRawhtmlInfo');?></small></label>
				</td>
				<td>
					<input type="checkbox" id="allow_rawhtml" name="allow_rawhtml" value="1"<?php echo ($engine->db->allow_rawhtml ? ' checked' : '');?>>
				</td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl-setting">
				<td class="label">
					<strong><?php echo $engine->_t('SafeHtml');?>:</strong><br>
					<small><?php echo $engine->_t('SafeHtmlInfo');?></small>
				</td>
				<td>
					<input type="radio" id="disable_safehtml_on" name="disable_safehtml" value="0"<?php echo ( !$engine->db->disable_safehtml ? ' checked' : '');?>><label for="disable_safehtml_on"><?php echo $engine->_t('On');?></label>
					<input type="radio" id="disable_safehtml_off" name="disable_safehtml" value="1"<?php echo ($engine->db->disable_safehtml ? ' checked' : '');?>><label for="disable_safehtml_off"><?php echo $engine->_t('Off');?></label>
				</td>
			</tr>
			<tr>
				<th colspan="2">
					<br>
					<?php echo $engine->_t('WackoFormatterSection');?>
				</th>
			</tr>
			<tr class="hl-setting">
				<td class="label">
					<label for="allow_x11colors"><strong><?php echo $engine->_t('X11colors');?>:</strong><br>
					<small><?php echo $engine->_t('X11colorsInfo');?></small></label>
				</td>
				<td>
					<input type="checkbox" id="allow_x11colors" name="allow_x11colors" value="1"<?php echo ($engine->db->allow_x11colors ? ' checked' : '');?>>
				</td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl-setting">
				<td class="label">
					<label for="disable_wikilinks"><strong><?php echo $engine->_t('WikiLinks');?>:</strong><br>
					<small><?php echo $engine->_t('WikiLinksInfo');?></small></label>
				</td>
				<td>
					<input type="checkbox" id="disable_wikilinks" name="disable_wikilinks" value="1"<?php echo ($engine->db->disable_wikilinks ? ' checked' : '');?>>
				</td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl-setting">
				<td class="label">
					<label for="disable_bracketslinks"><strong><?php echo $engine->_t('BracketsLinks');?>:</strong><br>
					<small><?php echo $engine->_t('BracketsLinksInfo');?></small></label>
				</td>
				<td>
					<input type="checkbox" id="disable_bracketslinks" name="disable_bracketslinks" value="1"<?php echo ($engine->db->disable_bracketslinks ? ' checked' : '');?>>
				</td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl-setting">
				<td class="label">
					<label for="disable_formatters"><strong><?php echo $engine->_t('Formatters');?>:</strong><br>
					<small><?php echo $engine->_t('FormattersInfo');?></small></label>
			</td>
				<td>
					<input type="checkbox" id="disable_formatters" name="disable_formatters" value="1"<?php echo ($engine->db->disable_formatters ? ' checked' : '');?>>
				</td>
			</tr>
			<tr>
				<th colspan="2">
					<br>
					<?php echo $engine->_t('DateFormatsSection');?>
				</th>
			</tr>
			<tr class="hl-setting">
				<td class="label">
					<label for="date_format"><strong><?php echo $engine->_t('DateFormat');?>:</strong><br>
					<small><?php echo $engine->_t('DateFormatInfo');?></small></label>
				</td>
				<td>
					<input type="text" maxlength="50" id="date_format" name="date_format" value="<?php echo Ut::html($engine->db->date_format);?>">
				</td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl-setting">
				<td class="label">
					<label for="time_format"><strong><?php echo $engine->_t('TimeFormat');?>:</strong><br>
					<small><?php echo $engine->_t('TimeFormatInfo');?></small></label>
				</td>
				<td>
					<input type="text" maxlength="50" id="time_format" name="time_format" value="<?php echo Ut::html($engine->db->time_format);?>">
				</td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl-setting">
				<td class="label">
					<label for="time_format_seconds"><strong><?php echo $engine->_t('TimeFormatSeconds');?>:</strong><br>
					<small><?php echo $engine->_t('TimeFormatSecondsinfo');?></small></label>
				</td>
				<td>
					<input type="text" maxlength="50" id="time_format_seconds" name="time_format_seconds" value="<?php echo Ut::html($engine->db->time_format_seconds);?>">
				</td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl-setting">
				<td class="label">
					<label for="name_date_macro"><strong><?php echo $engine->_t('NameDateMacro');?>:</strong><br>
					<small><?php echo $engine->_t('NameDateMacroInfo');?></small></label>
				</td>
				<td>
					<input type="text" maxlength="50" id="name_date_macro" name="name_date_macro" value="<?php echo Ut::html($engine->db->name_date_macro);?>">
				</td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl-setting">
				<td class="label" scope="row">
					<label for="timezone"><strong><?php echo $engine->_t('Timezone');?></strong><br>
					<small><?php echo $engine->_t('TimezoneInfo');?></small></label>
				</td>
				<td>
					<select id="timezone" name="timezone">
					<?php
					$timezones = $engine->_t('TzZoneArray');

					foreach ($timezones as $offset => $timezone)
					{
						if (mb_strlen($timezone) > 50)
						{
							$timezone = mb_substr($timezone, 0, 45 ) . '...';
						}

						echo '<option value="' . $offset . '" ' .
							($engine->db->timezone == $offset
								? 'selected="selected"'
								: ''
							) . ">" . $timezone . "</option>\n";
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
					<strong><?php echo $engine->_t('EnableDst');?>:</strong><br>
					<small><?php echo $engine->_t('EnableDstInfo');?></small>
				</td>
				<td>
					<input type="radio" id="dst_off" name="dst" value="0"<?php echo ($engine->db->dst == 0 ? ' checked' : '');?>><label for="dst_off"><?php echo $engine->_t('Off');?></label>
					<input type="radio" id="dst_on" name="dst" value="1"<?php echo ($engine->db->dst == 1 ? ' checked' : '');?>><label for="dst_on"><?php echo $engine->_t('On');?></label>
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
					<strong><?php echo $engine->_t('Canonical');?>:</strong><br>
					<small><?php echo Ut::perc_replace(
									$engine->_t('CanonicalInfo'),
									'<code>http://host/path</code>',
									'<code>/path</code>');?></small>
				</td>
				<td>
					<input type="radio" id="canonical_on" name="canonical" value="1"<?php echo ($engine->db->canonical ? ' checked' : '');?>><label for="canonical_on"><?php echo $engine->_t('On');?></label>
					<input type="radio" id="canonical_off" name="canonical" value="0"<?php echo (!$engine->db->canonical ? ' checked' : '');?>><label for="canonical_off"><?php echo $engine->_t('Off');?></label>
				</td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl-setting">
				<td class="label">
					<label for="enable_link_target"><strong><?php echo $engine->_t('LinkTarget');?>:</strong><br>
					<small><?php echo $engine->_t('LinkTargetInfo');?></small></label>
				</td>
				<td>
					<input type="checkbox" id="enable_link_target" name="link_target" value="1"<?php echo ($engine->db->link_target ? ' checked' : '');?>>
				</td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl-setting">
				<td class="label">
					<label for="enable_noreferrer"><strong><?php echo $engine->_t('Noreferrer');?>:</strong><br>
					<small><?php echo $engine->_t('NoreferrerInfo');?></small></label>
				</td>
				<td>
					<input type="checkbox" id="enable_noreferrer" name="noreferrer" value="1"<?php echo ($engine->db->noreferrer ? ' checked' : '');?>>
				</td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl-setting">
				<td class="label">
					<label for="enable_nofollow"><strong><?php echo $engine->_t('Nofollow');?>:</strong><br>
					<small><?php echo $engine->_t('NofollowInfo');?></small></label>
				</td>
				<td>
					<input type="checkbox" id="enable_nofollow" name="nofollow" value="1"<?php echo ($engine->db->nofollow ? ' checked' : '');?>>
				</td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl-setting">
				<td class="label">
					<label for="enable_urls_underscores"><strong><?php echo $engine->_t('UrlsUnderscores');?>:</strong><br>
					<small><?php echo Ut::perc_replace(
									$engine->_t('UrlsUnderscoresInfo'),
									'<code>http://[...]/WackoWiki</code>',
									'<code>http://[...]/Wacko_Wiki</code>');?></small></label>
				</td>
				<td>
					<input type="checkbox" id="enable_urls_underscores" name="urls_underscores" value="1"<?php echo ($engine->db->urls_underscores ? ' checked' : '');?>>
				</td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl-setting">
				<td class="label">
					<label for="enable_show_spaces"><strong><?php echo $engine->_t('ShowSpaces');?>:</strong><br>
					<small><?php echo $engine->_t('ShowSpacesInfo');?></small></label>
				</td>
				<td>
					<input type="checkbox" id="enable_show_spaces" name="show_spaces" value="1"<?php echo ($engine->db->show_spaces ? ' checked' : '');?>>
				</td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl-setting">
				<td class="label">
					<label for="enable_numerate_links"><strong><?php echo $engine->_t('NumerateLinks');?>:</strong><br>
					<small><?php echo $engine->_t('NumerateLinksInfo');?></small></label>
				</td>
				<td>
					<input type="checkbox" id="enable_numerate_links" name="numerate_links" value="1"<?php echo ($engine->db->numerate_links ? ' checked' : '');?>>
				</td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl-setting">
				<td class="label">
					<label for="enable_youarehere_text"><strong><?php echo $engine->_t('YouareHereText');?>:</strong><br>
					<small><?php echo $engine->_t('YouareHereTextInfo');?></small></label>
				</td>
				<td>
					<input type="text" maxlength="50" id="enable_youarehere_text" name="youarehere_text" value="<?php echo Ut::html($engine->db->youarehere_text);?>">
				</td>
			</tr>
		</table>
		<br>
		<div class="center">
			<input type="submit" id="submit" value="<?php echo $engine->_t('FormSave');?>">
			<input type="reset" id="button" value="<?php echo $engine->_t('FormReset');?>">
		</div>
<?php
	echo $engine->form_close();
}

