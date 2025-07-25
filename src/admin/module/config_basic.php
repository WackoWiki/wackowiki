<?php

if (!defined('IN_WACKO'))
{
	exit;
}

##########################################################
##	Basic settings										##
##########################################################

$module['config_basic'] = [
		'order'	=> 200,
		'cat'	=> 'preferences',
		'status'=> !RECOVERY_MODE,
	];

##########################################################

function admin_config_basic($engine, $module)
{
?>
	<h1><?php echo $engine->_t($module)['title']; ?></h1>
	<br>
	<?php
	$action = $_POST['_action'] ?? null;

	// update settings
	if ($action == 'basic')
	{
		$site_name		= $engine->sanitize_text_field($_POST['site_name'], true);
		$site_desc		= $engine->sanitize_text_field($_POST['site_desc'], true);
		$admin_name		= $engine->sanitize_username($_POST['admin_name']);
		$language		= $engine->validate_language($_POST['language'], false);

		$config['site_name']					= (string) $site_name;
		$config['site_desc']					= (string) $site_desc;
		$config['admin_name']					= (string) $admin_name;
		$config['language']						= (string) $language;
		$config['multilanguage']				= (int) ($_POST['multilanguage'] ?? 0);

		if (isset($_POST['allowed_languages']) && is_array($_POST['allowed_languages']))
		{
			$allowed_languages = array_map(
				function($lang) use ($engine) {
					return $engine->validate_language($lang, false);
				},
				$_POST['allowed_languages']
			);
			$allowed_languages = array_unique($allowed_languages);

			$config['allowed_languages'] = (string) implode(',', $allowed_languages);
		}
		else
		{
			$config['allowed_languages'] = 0; // why zero?
		}

		$config['default_diff_mode']			= (int) $_POST['default_diff_mode'];

		if (is_array($_POST['diff_modes']))
		{
			$_diff_modes = array_map('intval', $_POST['diff_modes']);

			$config['diff_modes']				= (string) implode(',', $_diff_modes);
		}
		else
		{
			$config['diff_modes']				= '0,1,2,3,4,5,6,7';
		}

		$config['footer_comments']				= (int) $_POST['footer_comments'];
		$config['footer_files']					= (int) $_POST['footer_files'];
		$config['footer_tags']					= (int) $_POST['footer_tags'];
		$config['show_permalink']				= (int) $_POST['show_permalink'];
		$config['hide_toc']						= (int) $_POST['hide_toc'];
		$config['hide_index']					= (int) $_POST['hide_index'];
		$config['tree_level']					= (int) $_POST['tree_level'];
		$config['menu_items']					= (int) $_POST['menu_items'];
		$config['edit_summary']					= (int) $_POST['edit_summary'];
		$config['minor_edit']					= (int) $_POST['minor_edit'];
		$config['section_edit']					= (int) $_POST['section_edit'];
		$config['review']						= (int) $_POST['review'];
		$config['publish_anonymously']			= (int) $_POST['publish_anonymously'];
		$config['default_rename_redirect']		= (int) ($_POST['default_rename_redirect'] ?? 0);
		$config['store_deleted_pages']			= (int) ($_POST['store_deleted_pages'] ?? 0);
		$config['keep_deleted_time']			= (int) $_POST['keep_deleted_time'];
		$config['pages_purge_time']				= (int) $_POST['pages_purge_time'];
		$config['referrers_purge_time']			= (int) $_POST['referrers_purge_time'];
		$config['enable_counters']				= (int) ($_POST['enable_counters'] ?? 0);

		$config['hide_revisions']				= (int) $_POST['hide_revisions'];
		$config['attachments_handler']			= (int) $_POST['attachments_handler'];
		$config['source_handler']				= (int) $_POST['source_handler'];
		$config['export_handler']				= (int) $_POST['export_handler'];

		$config['enable_comments']				= (int) $_POST['enable_comments'];
		$config['comments_offset']				= (int) $_POST['comments_offset'];
		$config['sorting_comments']				= (int) $_POST['sorting_comments'];

		$config['enable_referrers']				= (int) $_POST['enable_referrers'];

		$engine->config->_set($config);

		$engine->log(1, $engine->_t('LogBasicSettingsUpdated', SYSTEM_LANG));
		$engine->set_message($engine->_t('BasicSettingsUpdated'), 'success');
		$engine->http->redirect($engine->href());
	}

	echo $engine->form_open('basic');
?>
		<table class="setting formation">
			<colgroup>
				<col span="1">
				<col span="1">
			</colgroup>
			<tr>
				<th colspan="2">
				<br>
					<?php echo $engine->_t('MainSection');?>
				</th>
			</tr>
			<tr class="hl-setting">
				<td class="label">
					<label for="site_name"><strong><?php echo $engine->_t('SiteName');?></strong><br>
					<small><?php echo $engine->_t('SiteNameInfo');?></small></label>
				</td>
				<td>
					<input type="text" size="50" maxlength="255" id="site_name" name="site_name" value="<?php echo Ut::html($engine->db->site_name);?>">
				</td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl-setting">
				<td class="label">
					<label for="site_desc"><strong><?php echo $engine->_t('SiteDesc');?></strong><br>
					<small><?php echo $engine->_t('SiteDescInfo');?></small></label>
				</td>
				<td>
					<input type="text" size="50" maxlength="255" id="site_desc" name="site_desc" value="<?php echo Ut::html($engine->db->site_desc);?>">
				</td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl-setting">
				<td class="label">
					<label for="admin_name"><strong><?php echo $engine->_t('AdminName');?></strong><br>
					<small><?php echo $engine->_t('AdminNameInfo');?></small></label>
				</td>
				<td>
					<input type="text" size="50" maxlength="25" id="admin_name" name="admin_name" value="<?php echo Ut::html($engine->db->admin_name);?>">
				</td>
			</tr>
			<tr>
				<th colspan="2">
					<br>
					<?php echo $engine->_t('LanguageSection');?>
				</th>
			</tr>
			<tr class="hl-setting">
				<td class="label">
					<label for="language"><strong><?php echo $engine->_t('DefaultLanguage');?></strong><br>
					<small><?php echo $engine->_t('DefaultLanguageInfo');?></small></label>
				</td>
				<td>
					<select id="language" name="language">
					<?php
						$languages	= $engine->_t('LanguageArray');
						$langs		= $engine->http->available_languages();

						foreach ($langs as $lang)
						{
							echo '<option value="' . $lang . '" ' . ($engine->db->language == $lang ? 'selected' : '') . '>' . $languages[$lang] . ' (' . $lang . ')</option>';
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
					<label for="multilanguage"><strong><?php echo $engine->_t('MultiLanguage');?></strong><br>
					<small><?php echo $engine->_t('MultiLanguageInfo');?></small></label>
				</td>
				<td>
					<input type="checkbox" id="multilanguage" name="multilanguage" value="1"<?php echo ($engine->db->multilanguage ? ' checked' : '');?>>
				</td>
			</tr>
			<?php if ($engine->db->multilanguage)
			{?>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl-setting">
				<td class="label">
					<label for=""><strong><?php echo $engine->_t('AllowedLanguages');?></strong><br>
					<small><?php echo $engine->_t('AllowedLanguagesInfo');?></small></label>
				</td>
				<td>
				<?php
					if ($engine->db->multilanguage)
					{
						// subset: false
						$langs = $engine->http->available_languages(false);
					}
					else
					{
						$langs[] = $engine->db->language;
					}

					if (isset($engine->db->allowed_languages))
					{
						$lang_list = explode(',', $engine->db->allowed_languages);
					}
					else
					{
						$lang_list= [];
					}

					$languages = $engine->_t('LanguageArray');
					$n = 1;

					echo "<table>\n\t<tr>\n";

					foreach ($langs as $lang)
					{
						echo	"\t\t<td>\n\t\t\t" .
								'<input type="checkbox" name="allowed_languages[' . $n . ']" id="lang_' . $lang . '" value="' . $lang . '" ' . (in_array($lang, $lang_list) ? ' checked' : ''). '>' . "\n\t\t\t" .
								'<label for="lang_' . $lang . '">' . $languages[$lang] . ' (' . $lang . ')</label>' . "\n\t\t</td>\n";

						// modulus operator: every third loop add a break
						if ($n % 3 == 0)
						{
							echo "\t</tr>\n\t<tr>\n";
						}

						$n++;
					}

					echo "\t</tr>\n</table>";
					?>
				</td>
			</tr>
			<?php } ?>
			<tr>
				<th colspan="2">
					<br>
					<?php echo $engine->_t('CommentSection');?>
				</th>
			</tr>
			<tr class="hl-setting">
				<td class="label">
					<label for=""><strong><?php echo $engine->_t('AllowComments');?></strong><br>
					<small><?php echo $engine->_t('AllowCommentsInfo');?></small></label>
				</td>
				<td>
					<input type="radio" id="enable_comments_on" name="enable_comments" value="1" <?php echo ($engine->db->enable_comments == 1 ? ' checked' : '');?>><label for="enable_comments_on"><?php echo $engine->_t('On');?></label>
					<input type="radio" id="enable_comments_guest" name="enable_comments" value="2" <?php echo ($engine->db->enable_comments == 2 ? ' checked' : '');?>><label for="enable_comments_guest"><?php echo $engine->_t('Registered');?></label>
					<input type="radio" id="enable_comments_off" name="enable_comments" value="0" <?php echo ($engine->db->enable_comments == 0 ? ' checked' : '');?>><label for="enable_comments_off"><?php echo $engine->_t('Off');?></label>
				</td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl-setting">
				<td class="label">
					<label for="comments_offset"><strong><?php echo $engine->_t('CommentsOffset');?></strong><br>
					<small><?php echo $engine->_t('CommentsOffsetInfo');?></small></label>
				</td>
				<td>
					<select id="comments_offset" name="comments_offset">
						<option value="0" <?php echo ($engine->db->comments_offset == 0  ? ' selected' : ''); ?>><?php echo $engine->_t('CommentOffsetFirst');?></option>
						<option value="1" <?php echo ($engine->db->comments_offset == 1  ? ' selected' : ''); ?>><?php echo $engine->_t('CommentOffsetLast');?></option>
					</select>
				</td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl-setting">
				<td class="label">
					<label for="sorting_comments"><strong><?php echo $engine->_t('SortingComments');?></strong><br>
					<small><?php echo $engine->_t('SortingCommentsInfo');?></small></label>
				</td>
				<td>
					<select id="sorting_comments" name="sorting_comments">
						<option value="0" <?php echo ($engine->db->sorting_comments == 0  ? ' selected' : ''); ?>><?php echo $engine->_t('SortCommentAsc');?></option>
						<option value="1" <?php echo ($engine->db->sorting_comments == 1  ? ' selected' : ''); ?>><?php echo $engine->_t('SortCommentDesc');?></option>
					</select>
				</td>
			</tr>
			<tr>
				<th colspan="2">
					<br>
					<?php echo $engine->_t('ToolbarSection');?>
				</th>
			</tr>
			<tr class="hl-setting">
				<td class="label">
					<label for=""><strong><?php echo $engine->_t('CommentsPanel');?></strong><br>
					<small><?php echo $engine->_t('CommentsPanelInfo');?></small></label>
				</td>
				<td>
					<input type="radio" id="footer_comments_on" name="footer_comments" value="1"<?php echo ($engine->db->footer_comments == 1 ? ' checked' : '');?>><label for="footer_comments_on"><?php echo $engine->_t('On');?></label>
					<input type="radio" id="footer_comments_guest" name="footer_comments" value="2"<?php echo ($engine->db->footer_comments == 2 ? ' checked' : '');?>><label for="footer_comments_guest"><?php echo $engine->_t('Registered');?></label>
					<input type="radio" id="footer_comments_off" name="footer_comments" value="0"<?php echo ($engine->db->footer_comments == 0 ? ' checked' : '');?>><label for="footer_comments_off"><?php echo $engine->_t('Off');?></label>
				</td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl-setting">
				<td class="label">
					<label for=""><strong><?php echo $engine->_t('FilePanel');?></strong><br>
					<small><?php echo $engine->_t('FilePanelInfo');?></small></label>
				</td>
				<td>
					<input type="radio" id="footer_files_on" name="footer_files" value="1"<?php echo ($engine->db->footer_files == 1 ? ' checked' : '');?>><label for="footer_files_on"><?php echo $engine->_t('On');?></label>
					<input type="radio" id="footer_files_guest" name="footer_files" value="2"<?php echo ($engine->db->footer_files == 2 ? ' checked' : '');?>><label for="footer_files_guest"><?php echo $engine->_t('Registered');?></label>
					<input type="radio" id="footer_files_off" name="footer_files" value="0"<?php echo ($engine->db->footer_files == 0 ? ' checked' : '');?>><label for="footer_files_off"><?php echo $engine->_t('Off');?></label>
				</td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl-setting">
				<td class="label">
					<label for=""><strong><?php echo $engine->_t('TagsPanel');?></strong><br>
					<small><?php echo $engine->_t('TagsPanelInfo');?></small></label>
				</td>
				<td>
					<input type="radio" id="footer_tags_on" name="footer_tags" value="1"<?php echo ($engine->db->footer_tags == 1 ? ' checked' : '');?>><label for="footer_tags_on"><?php echo $engine->_t('On');?></label>
					<input type="radio" id="footer_tags_guest" name="footer_tags" value="2"<?php echo ($engine->db->footer_tags == 2 ? ' checked' : '');?>><label for="footer_tags_guest"><?php echo $engine->_t('Registered');?></label>
					<input type="radio" id="footer_tags_off" name="footer_tags" value="0"<?php echo ($engine->db->footer_tags == 0 ? ' checked' : '');?>><label for="footer_tags_off"><?php echo $engine->_t('Off');?></label>
				</td>
			</tr>
			<tr>
				<th colspan="2">
					<br>
					<?php echo $engine->_t('NavigationSection');?>
				</th>
			</tr>
			<tr class="hl-setting">
				<td class="label">
					<label for=""><strong><?php echo $engine->_t('ShowPermalink');?></strong><br>
					<small><?php echo $engine->_t('ShowPermalinkInfo');?></small></label>
				</td>
				<td>
					<input type="radio" id="show_permalink_on" name="show_permalink" value="1"<?php echo ($engine->db->show_permalink == 1 ? ' checked' : '');?>><label for="show_permalink_on"><?php echo $engine->_t('On');?></label>
					<input type="radio" id="show_permalink_guest" name="show_permalink" value="2"<?php echo ($engine->db->show_permalink == 2 ? ' checked' : '');?>><label for="show_permalink_guest"><?php echo $engine->_t('Registered');?></label>
					<input type="radio" id="show_permalink_off" name="show_permalink" value="0"<?php echo ($engine->db->show_permalink == 0 ? ' checked' : '');?>><label for="show_permalink_off"><?php echo $engine->_t('Off');?></label>
				</td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl-setting">
				<td class="label">
					<label for=""><strong><?php echo $engine->_t('TocPanel');?></strong><br>
					<small><?php echo $engine->_t('TocPanelInfo');?></small></label>
				</td>
				<td>
					<input type="radio" id="hide_toc_on" name="hide_toc" value="0"<?php echo (!$engine->db->hide_toc ? ' checked' : '');?>><label for="hide_toc_on"><?php echo $engine->_t('On');?></label>
					<input type="radio" id="hide_toc_off" name="hide_toc" value="1"<?php echo ($engine->db->hide_toc ? ' checked' : '');?>><label for="hide_toc_off"><?php echo $engine->_t('Off');?></label>
				</td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl-setting">
				<td class="label">
					<label for=""><strong><?php echo $engine->_t('SectionsPanel');?></strong><br>
					<small><?php echo $engine->_t('SectionsPanelInfo');?></small></label>
				</td>
				<td>
					<input type="radio" id="hide_index_on" name="hide_index" value="0"<?php echo (!$engine->db->hide_index ? ' checked' : '');?>><label for="hide_index_on"><?php echo $engine->_t('On');?></label>
					<input type="radio" id="hide_index_off" name="hide_index" value="1"<?php echo ($engine->db->hide_index ? ' checked' : '');?>><label for="hide_index_off"><?php echo $engine->_t('Off');?></label>
				</td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl-setting">
				<td class="label">
					<label for=""><strong><?php echo $engine->_t('DisplayingSections');?></strong><br>
					<small><?php echo $engine->_t('DisplayingSectionsInfo');?></small></label>
				</td>
				<td>
					<input type="radio" id="full_index" name="tree_level" value="0"<?php echo ($engine->db->tree_level == 0 ? ' checked' : '');?>><label for="full_index"><?php echo $engine->_t('MetaIndexFull');?></label>
					<input type="radio" id="lower_index" name="tree_level" value="1"<?php echo ($engine->db->tree_level == 1 ? ' checked' : '');?>><label for="lower_index"><?php echo $engine->_t('MetaIndexLower');?></label>
					<input type="radio" id="upper_index" name="tree_level" value="2"<?php echo ($engine->db->tree_level == 2 ? ' checked' : '');?>><label for="upper_index"><?php echo $engine->_t('MetaIndexUpper');?></label>
				</td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl-setting">
				<td class="label">
					<label for="menu_items"><strong><?php echo $engine->_t('MenuItems');?></strong><br>
					<small><?php echo $engine->_t('MenuItemsInfo');?></small></label>
				</td>
				<td>
					<input type="number" min="0" max="20" maxlength="4" id="menu_items" name="menu_items" value="<?php echo (int) $engine->db->menu_items;?>">
				</td>
			</tr>
			<tr>
				<th colspan="2">
					<br>
					<?php echo $engine->_t('HandlerSection');?>
				</th>
			</tr>
			<tr class="hl-setting">
				<td class="label">
					<label for=""><strong><?php echo $engine->_t('HideRevisions');?></strong><br>
					<small><?php echo $engine->_t('HideRevisionsInfo');?></small></label>
				</td>
				<td>
					<input type="radio" id="hide_revisions_on" name="hide_revisions" value="2"<?php echo ($engine->db->hide_revisions == 2 ? ' checked' : '');?>><label for="hide_revisions_on"><?php echo $engine->_t('On');?></label>
					<input type="radio" id="hide_revisions_guest" name="hide_revisions" value="1"<?php echo ($engine->db->hide_revisions == 1 ? ' checked' : '');?>><label for="hide_revisions_guest"><?php echo $engine->_t('Registered');?></label>
					<input type="radio" id="hide_revisions_off" name="hide_revisions" value="0"<?php echo ($engine->db->hide_revisions == 0 ? ' checked' : '');?>><label for="hide_revisions_off"><?php echo $engine->_t('Off');?></label>
				</td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl-setting">
				<td class="label">
					<label for=""><strong><?php echo $engine->_t('AttachmentHandler');?></strong><br>
					<small><?php echo $engine->_t('AttachmentHandlerInfo');?></small></label>
				</td>
				<td>
					<input type="radio" id="attachments_handler_on" name="attachments_handler" value="1"<?php echo ($engine->db->attachments_handler == 1 ? ' checked' : '');?>><label for="attachments_handler_on"><?php echo $engine->_t('On');?></label>
					<input type="radio" id="attachments_handler_guest" name="attachments_handler" value="2"<?php echo ($engine->db->attachments_handler == 2 ? ' checked' : '');?>><label for="attachments_handler_guest"><?php echo $engine->_t('Registered');?></label>
					<input type="radio" id="attachments_handler_off" name="attachments_handler" value="0"<?php echo ($engine->db->attachments_handler == 0 ? ' checked' : '');?>><label for="attachments_handler_off"><?php echo $engine->_t('Off');?></label>
				</td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl-setting">
				<td class="label">
					<label for=""><strong><?php echo $engine->_t('SourceHandler');?></strong><br>
					<small><?php echo $engine->_t('SourceHandlerInfo');?></small></label>
				</td>
				<td>
					<input type="radio" id="source_handler_on" name="source_handler" value="1"<?php echo ($engine->db->source_handler == 1 ? ' checked' : '');?>><label for="source_handler_on"><?php echo $engine->_t('On');?></label>
					<input type="radio" id="source_handler_guest" name="source_handler" value="2"<?php echo ($engine->db->source_handler == 2 ? ' checked' : '');?>><label for="source_handler_guest"><?php echo $engine->_t('Registered');?></label>
					<input type="radio" id="source_handler_off" name="source_handler" value="0"<?php echo ($engine->db->source_handler == 0 ? ' checked' : '');?>><label for="source_handler_off"><?php echo $engine->_t('Off');?></label>
				</td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl-setting">
				<td class="label">
					<label for=""><strong><?php echo $engine->_t('ExportHandler');?></strong><br>
					<small><?php echo $engine->_t('ExportHandlerInfo');?></small></label>
				</td>
				<td>
					<input type="radio" id="export_handler_on" name="export_handler" value="1"<?php echo ($engine->db->export_handler == 1 ? ' checked' : '');?>><label for="export_handler_on"><?php echo $engine->_t('On');?></label>
					<input type="radio" id="export_handler_user" name="export_handler" value="2"<?php echo ($engine->db->export_handler == 2 ? ' checked' : '');?>><label for="export_handler_user"><?php echo $engine->_t('Registered');?></label>
					<input type="radio" id="export_handler_off" name="export_handler" value="0"<?php echo ($engine->db->export_handler == 0 ? ' checked' : '');?>><label for="export_handler_off"><?php echo $engine->_t('Off');?></label>
				</td>
			</tr>
			<tr>
				<th colspan="2">
					<br>
					<?php echo $engine->_t('DiffModeSection');?>
				</th>
			</tr>
			<tr class="hl-setting">
				<td class="label">
					<label for="default_diff_mode"><strong><?php echo $engine->_t('DefaultDiffModeSetting');?></strong><br>
					<small><?php echo $engine->_t('DefaultDiffModeSettingInfo');?></small></label>
				</td>
				<td>
					<select id="default_diff_mode" name="default_diff_mode">
					<?php
						$diff_modes = $engine->_t('DiffMode');

						foreach ($diff_modes as $mode => $diff_mode)
						{
							echo '<option value="' . $mode . '" ' . ( (int) $engine->db->default_diff_mode == $mode ? 'selected' : '') . '>' . $diff_mode . ' (' . $mode . ')</option>' . "\n";
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
					<label for=""><strong><?php echo $engine->_t('AllowedDiffMode');?></strong><br>
					<small><?php echo $engine->_t('AllowedDiffModeInfo');?></small></label>
				</td>
				<td>
				<?php
					if (isset($engine->db->diff_modes))
					{
						$diff_mode_list = explode(',', $engine->db->diff_modes);
					}
					else
					{
						$diff_mode_list= [];
					}

					$n = 1;

					echo "<table>\n\t<tr>\n";

					foreach ($diff_modes as $mode => $diff_mode)
					{
						echo	"\t\t<td>\n\t\t\t" .
								'<input type="checkbox" name="diff_modes[' . $n . ']" id="mode_' . $mode . '" value="' . $mode . '" ' . (in_array($mode, $diff_mode_list) ? ' checked' : ''). '>' . "\n\t\t\t" .
								'<label for="mode_' . $mode . '">' . $diff_mode . ' (' . $mode . ')</label>' . "\n\t\t</td>\n";

						// modulus operator: every third loop add a break
						if ($n % 3 == 0)
						{
							echo "\t</tr>\n\t<tr>\n";
						}

						$n++;
					}

					echo "\t</tr>\n</table>";
					?>
				</td>
			</tr>
			<tr>
				<th colspan="2">
					<br>
					<?php echo $engine->_t('EditingSection');?>
				</th>
			</tr>
			<tr class="hl-setting">
				<td class="label">
					<label for=""><strong><?php echo $engine->_t('EditSummary');?></strong><br>
					<small><?php echo $engine->_t('EditSummaryInfo');?></small></label>
				</td>
				<td>
					<input type="radio" id="edit_summary_on" name="edit_summary" value="1"<?php echo ($engine->db->edit_summary == 1 ? ' checked' : '');?>><label for="edit_summary_on"><?php echo $engine->_t('On');?></label>
					<input type="radio" id="edit_summary_mandatory" name="edit_summary" value="2"<?php echo ($engine->db->edit_summary == 2 ? ' checked' : '');?>><label for="edit_summary_mandatory"><?php echo $engine->_t('Mandatory');?></label>
					<input type="radio" id="edit_summary_off" name="edit_summary" value="0"<?php echo (!$engine->db->edit_summary ? ' checked' : '');?>><label for="edit_summary_off"><?php echo $engine->_t('Off');?></label>
				</td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl-setting">
				<td class="label">
					<label for=""><strong><?php echo $engine->_t('MinorEdit');?></strong><br>
					<small><?php echo $engine->_t('MinorEditInfo');?></small></label>
				</td>
				<td>
					<input type="radio" id="minor_edit_on" name="minor_edit" value="1"<?php echo ($engine->db->minor_edit ? ' checked' : '');?>><label for="minor_edit_on"><?php echo $engine->_t('On');?></label>
					<input type="radio" id="minor_edit_off" name="minor_edit" value="0"<?php echo (!$engine->db->minor_edit ? ' checked' : '');?>><label for="minor_edit_off"><?php echo $engine->_t('Off');?></label>
				</td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl-setting">
				<td class="label">
					<label for=""><strong><?php echo $engine->_t('SectionEdit');?></strong><br>
					<small><?php echo $engine->_t('SectionEditInfo');?></small></label>
				</td>
				<td>
					<input type="radio" id="section_edit_on" name="section_edit" value="1"<?php echo ($engine->db->section_edit == 1 ? ' checked' : '');?>><label for="section_edit_on"><?php echo $engine->_t('On');?></label>
					<input type="radio" id="section_edit_off" name="section_edit" value="0"<?php echo (!$engine->db->section_edit ? ' checked' : '');?>><label for="section_edit_off"><?php echo $engine->_t('Off');?></label>
				</td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl-setting">
				<td class="label">
					<label for=""><strong><?php echo $engine->_t('ReviewSettings');?></strong><br>
					<small><?php echo $engine->_t('ReviewSettingsInfo');?></small></label>
				</td>
				<td>
					<input type="radio" id="review_on" name="review" value="1"<?php echo ($engine->db->review ? ' checked' : '');?>><label for="review_on"><?php echo $engine->_t('On');?></label>
					<input type="radio" id="review_off" name="review" value="0"<?php echo (!$engine->db->review ? ' checked' : '');?>><label for="review_off"><?php echo $engine->_t('Off');?></label>
				</td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl-setting">
				<td class="label">
					<label for=""><strong><?php echo $engine->_t('PublishAnonymously');?></strong><br>
					<small><?php echo $engine->_t('PublishAnonymouslyInfo');?></small></label>
				</td>
				<td>
					<input type="radio" id="publish_anonymously_on" name="publish_anonymously" value="1"<?php echo ($engine->db->publish_anonymously ? ' checked' : '');?>><label for="publish_anonymously_on"><?php echo $engine->_t('On');?></label>
					<input type="radio" id="publish_anonymously_off" name="publish_anonymously" value="0"<?php echo (!$engine->db->publish_anonymously ? ' checked' : '');?>><label for="publish_anonymously_off"><?php echo $engine->_t('Off');?></label>
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
					<label for="default_rename_redirect"><strong><?php echo $engine->_t('DefaultRenameRedirect');?></strong><br>
					<small><?php echo $engine->_t('DefaultRenameRedirectInfo');?></small></label>
				</td>
				<td>
					<input type="checkbox" id="default_rename_redirect" name="default_rename_redirect" value="1"<?php echo ($engine->db->default_rename_redirect ? ' checked' : '');?>>
				</td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl-setting">
				<td class="label">
					<label for="store_deleted_pages"><strong><?php echo $engine->_t('StoreDeletedPages');?></strong><br>
					<small><?php echo $engine->_t('StoreDeletedPagesInfo');?></small></label>
				</td>
				<td>
					<input type="checkbox" id="store_deleted_pages" name="store_deleted_pages" value="1"<?php echo ($engine->db->store_deleted_pages ? ' checked' : '');?>>
				</td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl-setting">
				<td class="label">
					<label for="keep_deleted_time"><strong><?php echo $engine->_t('KeepDeletedTime');?></strong><br>
					<small><?php echo $engine->_t('KeepDeletedTimeInfo');?></small></label>
				</td>
				<td>
					<input type="number" min="0" maxlength="4" id="keep_deleted_time" name="keep_deleted_time" value="<?php echo (int) $engine->db->keep_deleted_time;?>">
				</td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl-setting">
				<td class="label">
					<label for="pages_purge_time"><strong><?php echo $engine->_t('PagesPurgeTime');?></strong><br>
					<small><?php echo $engine->_t('PagesPurgeTimeInfo');?></small></label>
				</td>
				<td>
					<input type="number" min="0" maxlength="4" id="pages_purge_time" name="pages_purge_time" value="<?php echo (int) $engine->db->pages_purge_time;?>">
				</td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl-setting">
				<td class="label">
					<label for=""><strong><?php echo $engine->_t('EnableReferrers');?></strong><br>
					<small><?php echo $engine->_t('EnableReferrersInfo');?></small></label>
				</td>
				<td>
					<input type="radio" id="enable_referrer_on" name="enable_referrers" value="1"<?php echo ($engine->db->enable_referrers == 1 ? ' checked' : '');?>><label for="enable_referrer_on"><?php echo $engine->_t('On');?></label>
					<input type="radio" id="enable_referrer_admin" name="enable_referrers" value="2"<?php echo ($engine->db->enable_referrers == 2 ? ' checked' : '');?>><label for="enable_referrer_admin"><?php echo $engine->_t('Admin');?></label>
					<input type="radio" id="enable_referrer_off" name="enable_referrers" value="0"<?php echo ($engine->db->enable_referrers == 0 ? ' checked' : '');?>><label for="enable_referrer_off"><?php echo $engine->_t('Off');?></label>
				</td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl-setting">
				<td class="label">
					<label for="referrers_purge_time"><strong><?php echo $engine->_t('ReferrersPurgeTime');?></strong><br>
					<small><?php echo $engine->_t('ReferrersPurgeTimeInfo');?></small></label>
				</td>
				<td>
					<input type="number" min="0" maxlength="4" id="referrers_purge_time" name="referrers_purge_time" value="<?php echo (int) $engine->db->referrers_purge_time;?>">
				</td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl-setting">
				<td class="label">
					<label for="enable_counters"><strong><?php echo $engine->_t('EnableCounters');?></strong><br>
					<small><?php echo $engine->_t('EnableCountersInfo');?></small></label>
				</td>
				<td>
					<input type="radio" id="enable_counters_on" name="enable_counters" value="1"<?php echo ($engine->db->enable_counters ? ' checked' : '');?>><label for="enable_counters_on"><?php echo $engine->_t('On');?></label>
					<input type="radio" id="enable_counters_off" name="enable_counters" value="0"<?php echo (!$engine->db->enable_counters ? ' checked' : '');?>><label for="enable_counters_off"><?php echo $engine->_t('Off');?></label>
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

