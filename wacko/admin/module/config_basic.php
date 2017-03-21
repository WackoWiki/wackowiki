<?php

if (!defined('IN_WACKO'))
{
	exit;
}

########################################################
##   Basic settings                                   ##
########################################################
$_mode = 'config_basic';

$module[$_mode] = [
		'order'	=> 200,
		'cat'	=> 'preferences',
		'status'=> (RECOVERY_MODE ? false : true),
		'mode'	=> $_mode,
		'name'	=> $engine->_t($_mode)['name'],		// Basic
		'title'	=> $engine->_t($_mode)['title'],	// Basic parameters
	];

########################################################

function admin_config_basic(&$engine, &$module)
{
?>
	<h1><?php echo $module['title']; ?></h1>
	<br />
<?php
	// update settings
	if (isset($_POST['action']) && $_POST['action'] == 'update')
	{
		#$engine->debug_print_r($_POST);
		$config['site_name']				= (string) $_POST['site_name'];
		$config['site_desc']				= (string) $_POST['site_desc'];
		$config['meta_description']			= (string) $_POST['meta_description'];
		$config['meta_keywords']			= (string) $_POST['meta_keywords'];
		$config['admin_name']				= (string) $_POST['admin_name'];
		$config['language']					= (string) $_POST['language'];
		$config['multilanguage']			= (int) $_POST['multilanguage'];

		if (is_array($_POST['allowed_languages']))
		{
			$config['allowed_languages'] = (string) implode(',', $_POST['allowed_languages']);
		}
		else
		{
			$config['allowed_languages'] = 0;
		}

		$config['default_diff_mode']		= (int) $_POST['default_diff_mode'];

		if (is_array($_POST['diff_modes']))
		{
			$config['diff_modes'] = (string) implode(',', $_POST['diff_modes']);
		}
		else
		{
			$config['diff_modes'] = '0,1,2,3,4,5,6';
		}

		$config['footer_comments']			= (int) $_POST['footer_comments'];
		$config['footer_files']				= (int) $_POST['footer_files'];
		$config['footer_rating']			= (int) $_POST['footer_rating'];
		$config['footer_tags']				= (int) $_POST['footer_tags'];
		$config['hide_revisions']			= (int) $_POST['hide_revisions'];
		$config['hide_toc']					= (int) $_POST['hide_toc'];
		$config['hide_index']				= (int) $_POST['hide_index'];
		$config['tree_level']				= (int) $_POST['tree_level'];
		$config['menu_items']				= (int) $_POST['menu_items'];
		$config['edit_summary']				= (int) $_POST['edit_summary'];
		$config['minor_edit']				= (int) $_POST['minor_edit'];
		$config['review']					= (int) $_POST['review'];
		$config['publish_anonymously']		= (int) $_POST['publish_anonymously'];
		$config['disable_autosubscribe']	= (int) $_POST['disable_autosubscribe'];
		$config['default_rename_redirect']	= (int) $_POST['default_rename_redirect'];
		$config['store_deleted_pages']		= (int) $_POST['store_deleted_pages'];
		$config['keep_deleted_time']		= (int) $_POST['keep_deleted_time'];
		$config['pages_purge_time']			= (int) $_POST['pages_purge_time'];
		$config['referrers_purge_time']		= (int) $_POST['referrers_purge_time'];
		$config['noindex']					= (int) $_POST['noindex'];
		$config['xml_sitemap']				= (int) $_POST['xml_sitemap'];
		$config['xml_sitemap_time']			= (int) $_POST['xml_sitemap_time'];
		$config['enable_feeds']				= (int) $_POST['enable_feeds'];
		$config['enable_referrers']			= (int) $_POST['enable_referrers'];
		$config['enable_comments']			= (int) $_POST['enable_comments'];
		$config['sorting_comments']			= (int) $_POST['sorting_comments'];

		$engine->config->_set($config);

		$engine->log(1, 'Updated basic settings');
		$engine->set_message('Updated basic settings', 'success');
		$engine->http->redirect(rawurldecode($engine->href()));
	}

	echo $engine->form_open('basic');
?>
		<input type="hidden" name="action" value="update" />
		<table class="formation">
			<colgroup>
				<col span="1" style="width:50%;">
				<col span="1" style="width:50%;">
			</colgroup>
			<tr>
				<th colspan="2">Basic parameters</th>
			</tr>
			<tr class="hl_setting">
				<td class="label"><label for="site_name"><strong>Site Name:</strong><br />
					<small>The title of this site, appears on browser title, theme header, email-notification, etc.</small></label></td>
				<td><input type="text" maxlength="255" id="site_name" name="site_name" value="<?php echo htmlspecialchars($engine->db->site_name, ENT_COMPAT | ENT_HTML401, HTML_ENTITIES_CHARSET);?>" /></td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl_setting">
				<td class="label"><label for="site_desc"><strong>Site Description:</strong><br />
					<small>Supplement to the title of the site that appears in the pages header to explain in a few words, what this site is about.</small></label></td>
				<td><input type="text" maxlength="255" id="site_desc" name="site_desc" value="<?php echo htmlspecialchars($engine->db->site_desc, ENT_COMPAT | ENT_HTML401, HTML_ENTITIES_CHARSET);?>" /></td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl_setting">
				<td class="label"><label for="meta_description"><strong>Description of the document by default:</strong><br />
					<small>The text used by default for meta-tags <code>description</code> (maximum of 255 characters).</small></label></td>
				<td><textarea style="width:200px; height:100px;" id="meta_description" name="meta_description"><?php echo htmlspecialchars($engine->db->meta_description, ENT_COMPAT | ENT_HTML401, HTML_ENTITIES_CHARSET);?></textarea></td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl_setting">
				<td class="label"><label for="meta_keywords"><strong>Keywords page default:</strong><br />
					<small>Key words used by default for meta-tags <code>keywords</code> (maximum of 255 characters).</small></label></td>
				<td><textarea style="width:200px; height:100px;" id="meta_keywords" name="meta_keywords"><?php echo htmlspecialchars($engine->db->meta_keywords, ENT_COMPAT | ENT_HTML401, HTML_ENTITIES_CHARSET);?></textarea></td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl_setting">
				<td class="label"><label for="admin_name"><strong>Admin of Site:</strong><br />
					<small>User name, which is responsible for overall support of the site. This name is not used to determine access rights, but it is desirable to conform to the name of the chief administrator of the site.</small></label></td>
				<td>
					<input type="text" maxlength="25" id="admin_name" name="admin_name" value="<?php echo htmlspecialchars($engine->db->admin_name, ENT_COMPAT | ENT_HTML401, HTML_ENTITIES_CHARSET);?>" />
				</td>
			</tr>
			<tr>
				<th colspan="2">
					<br />
					Language
				</th>
			</tr>
			<tr class="hl_setting">
				<td class="label"><label for="language"><strong>Default language:</strong><br />
					<small>Specifies the language for mapping unregistered guests, as well as the locale settings and the rules of transliteration of addresses of pages.</small></label></td>
				<td>
					<select id="language" name="language">
					<?php
						$languages = $engine->_t('LanguageArray');
						$langs = $engine->available_languages();

						foreach ($langs as $lang)
						{
							echo '<option value="' . $lang . '" '.($engine->db->language == $lang ? 'selected' : '') . '>' . $languages[$lang] . ' (' . $lang . ')</option>';
						}
					?>
					</select>
				</td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl_setting">
				<td class="label"><label for="multilanguage"><strong>Multilanguage support:</strong><br />
					<small>Include a choice of language on the page by page basis.</small></label></td>
				<td>
					<input type="checkbox" id="multilanguage" name="multilanguage" value="1"<?php echo ( $engine->db->multilanguage ? ' checked' : '' );?> />
				</td>
			</tr>
			<?php if ($engine->db->multilanguage)
			{?>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl_setting">
				<td class="label"><label for=""><strong>Allowed languages:</strong><br />
					<small>It is recomended to select only the set of languages you want to use, other wise all languages are selected.</small></label></td>
				<td>
				<?php
					if ($engine->db->multilanguage)
					{
						// subset: false
						$langs = $engine->available_languages(false);
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
						echo	"\t\t<td>\n\t\t\t" . '<input type="checkbox" name="allowed_languages[' . $n . ']" id="lang_' . $lang . '" value="' . $lang . '" '. (in_array($lang, $lang_list) ? ' checked' : ''). ' />' . "\n\t\t\t" .
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
					<br />
					Comments
				</th>
			</tr>
			<tr class="hl_setting">
				<td class="label"><strong>Allow comments:</strong><br />
					<small>Enable comments for guest or registered users only or disable them on the entire site.</small></td>
				<td>
					<input type="radio" id="enable_comments" name="enable_comments" value="1" <?php echo ($engine->db->enable_comments == 1 ? ' checked' : '');?> /><label for="enable_comments_on"><?php echo $engine->_t('On');?></label>
					<input type="radio" id="enable_comments_guest" name="enable_comments" value="2" <?php echo ($engine->db->enable_comments == 2 ? ' checked' : '');?> /><label for="enable_comments_guest"><?php echo $engine->_t('MetaRegistered');?></label>
					<input type="radio" id="enable_comments_off" name="enable_comments" value="0" <?php echo ($engine->db->enable_comments == 0 ? ' checked' : '');?> /><label for="enable_comments_off"><?php echo $engine->_t('Off');?></label>
				</td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl_setting">
				<td class="label"><label for="sorting_comments"><strong>Sorting comments:</strong><br />
					<small>Changes the order the page comments are presented, either with the most recent OR the oldest comment at the top.</small></label></td>
				<td>
					<select id="sorting_comments" name="sorting_comments">
						<option value="0" <?php echo ($engine->db->sorting_comments  == 0  ? ' selected' : ''); ?>><?php echo $engine->_t('SortCommentAsc');?></option>
						<option value="1" <?php echo ($engine->db->sorting_comments  == 1  ? ' selected' : ''); ?>><?php echo $engine->_t('SortCommentDesc');?></option>
					</select>
				</td>
			</tr>
			<tr>
				<th colspan="2">
					<br />
					Toolbar
				</th>
			</tr>
			<tr class="hl_setting">
				<td class="label"><strong>Comments panel:</strong><br />
					<small>The default display of comments in the bottom of the page.</small></td>
				<td>
					<input type="radio" id="footer_comments_on" name="footer_comments" value="1"<?php echo ($engine->db->footer_comments == 1 ? ' checked' : '');?> /><label for="footer_comments_on"><?php echo $engine->_t('On');?></label>
					<input type="radio" id="footer_comments_guest" name="footer_comments" value="2"<?php echo ($engine->db->footer_comments == 2 ? ' checked' : '');?> /><label for="footer_comments_guest"><?php echo $engine->_t('MetaRegistered');?></label>
					<input type="radio" id="footer_comments_off" name="footer_comments" value="0"<?php echo ($engine->db->footer_comments == 0 ? ' checked' : '');?> /><label for="footer_comments_off"><?php echo $engine->_t('Off');?></label>
				</td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl_setting">
				<td class="label"><strong>File panel:</strong><br />
					<small>The default display of attachments in the bottom of the page .</small></td>
				<td>
					<input type="radio" id="footer_files_on" name="footer_files" value="1"<?php echo ($engine->db->footer_files == 1 ? ' checked' : '');?> /><label for="footer_files_on"><?php echo $engine->_t('On');?></label>
					<input type="radio" id="footer_files_guest" name="footer_files" value="2"<?php echo ($engine->db->footer_files == 2 ? ' checked' : '');?> /><label for="footer_files_guest"><?php echo $engine->_t('MetaRegistered');?></label>
					<input type="radio" id="footer_files_off" name="footer_files" value="0"<?php echo ($engine->db->footer_files == 0 ? ' checked' : '');?> /><label for="footer_files_off"><?php echo $engine->_t('Off');?></label>
				</td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl_setting">
				<td class="label"><strong>Rating panel :</strong><br />
					<small>The default display of the rating panel in the bottom of the page.</small></td>
				<td>
					<input type="radio" id="footer_rating_on" name="footer_rating" value="1"<?php echo ($engine->db->footer_rating == 1 ? ' checked' : '');?> /><label for="footer_rating_on"><?php echo $engine->_t('On');?></label>
					<input type="radio" id="footer_rating_guest" name="footer_rating" value="2"<?php echo ($engine->db->footer_rating == 2 ? ' checked' : '');?> /><label for="footer_rating_guest"><?php echo $engine->_t('MetaRegistered');?></label>
					<input type="radio" id="footer_rating_off" name="footer_rating" value="0"<?php echo ($engine->db->footer_rating == 0 ? ' checked' : '');?> /><label for="footer_rating_off"><?php echo $engine->_t('Off');?></label>
				</td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl_setting">
				<td class="label"><strong>Tags panel :</strong><br />
					<small>The default display of the tags panel in the bottom of the page.</small></td>
				<td>
					<input type="radio" id="footer_tags_on" name="footer_tags" value="1"<?php echo ($engine->db->footer_tags == 1 ? ' checked' : '');?> /><label for="footer_tags_on"><?php echo $engine->_t('On');?></label>
					<input type="radio" id="footer_tags_guest" name="footer_tags" value="2"<?php echo ($engine->db->footer_tags == 2 ? ' checked' : '');?> /><label for="footer_tags_guest"><?php echo $engine->_t('MetaRegistered');?></label>
					<input type="radio" id="footer_tags_off" name="footer_tags" value="0"<?php echo ($engine->db->footer_tags == 0 ? ' checked' : '');?> /><label for="footer_tags_off"><?php echo $engine->_t('Off');?></label>
				</td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl_setting">
				<td class="label"><strong>Hide Revisions:</strong><br />
					<small>The default display of revisions of the page.</small></td>
				<td>
					<input type="radio" id="hide_revisions_on" name="hide_revisions" value="2"<?php echo ($engine->db->hide_revisions == 2 ? ' checked' : '');?> /><label for="hide_revisions_on"><?php echo $engine->_t('On');?></label>
					<input type="radio" id="hide_revisions_guest" name="hide_revisions" value="1"<?php echo ($engine->db->hide_revisions == 1 ? ' checked' : '');?> /><label for="hide_revisions_guest"><?php echo $engine->_t('MetaRegistered');?></label>
					<input type="radio" id="hide_revisions_off" name="hide_revisions" value="0"<?php echo ($engine->db->hide_revisions == 0 ? ' checked' : '');?> /><label for="hide_revisions_off"><?php echo $engine->_t('Off');?></label>
				</td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl_setting">
				<td class="label"><strong>Table of contents panel :</strong><br />
					<small>The default display table of contents panel of a page (may need support in the templates).</small></td>
				<td>
					<input type="radio" id="hide_toc_on" name="hide_toc" value="0"<?php echo (!$engine->db->hide_toc ? ' checked' : '');?> /><label for="hide_toc_on"><?php echo $engine->_t('On');?></label>
					<input type="radio" id="hide_toc_off" name="hide_toc" value="1"<?php echo ($engine->db->hide_toc ? ' checked' : '');?> /><label for="hide_toc_off"><?php echo $engine->_t('Off');?></label>
				</td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl_setting">
				<td class="label"><strong>Sections panel :</strong><br />
					<small>By default display the panel of adjacent pages (requires support in the templates).</small></td>
				<td>
					<input type="radio" id="hide_index_on" name="hide_index" value="0"<?php echo (!$engine->db->hide_index ? ' checked' : '');?> /><label for="hide_index_on"><?php echo $engine->_t('On');?></label>
					<input type="radio" id="hide_index_off" name="hide_index" value="1"<?php echo ($engine->db->hide_index ? ' checked' : '');?> /><label for="hide_index_off"><?php echo $engine->_t('Off');?></label>
				</td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl_setting">
				<td class="label"><strong>Displaying sections:</strong><br />
					<small>When the previous options, whether to display only subpages of page (<em>lower</em>), only neighbor (<em>top</em>) or both, and other (<em>tree</em>).</small></td>
				<td>
					<input type="radio" id="full_index" name="tree_level" value="0"<?php echo ($engine->db->tree_level == 0 ? ' checked' : '');?> /><label for="full_index"><?php echo $engine->_t('MetaIndexFull');?></label>
					<input type="radio" id="lower_index" name="tree_level" value="1"<?php echo ($engine->db->tree_level == 1 ? ' checked' : '');?> /><label for="lower_index"><?php echo $engine->_t('MetaIndexLower');?></label>
					<input type="radio" id="upper_index" name="tree_level" value="2"<?php echo ($engine->db->tree_level == 2 ? ' checked' : '');?> /><label for="upper_index"><?php echo $engine->_t('MetaIndexUpper');?></label>
				</td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl_setting">
				<td class="label"><label for="menu_items"><strong>Menu items:</strong><br />
					<small>Default number of shown menu items (may need support in the templates).</small></label></td>
				<td><input type="number" min="0" max="20" maxlength="4" id="menu_items" name="menu_items" value="<?php echo (int) $engine->db->menu_items;?>" /></td>
			</tr>
			<tr>
				<th colspan="2">
					<br />
					Feeds
				</th>
			</tr>
			<tr class="hl_setting">
				<td class="label"><label for="enable_feeds"><strong>Enable Feeds:</strong><br />
					<small>Turns on or off RSS feeds for the entire wiki.</small></label></td>
				<td><input type="checkbox" id="enable_feeds" name="enable_feeds" value="1"<?php echo ($engine->db->enable_feeds ? ' checked' : '');?> /></td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl_setting">
				<td class="label"><label for="xml_sitemap"><strong>XML Sitemap:</strong><br />
					<small>Create an XML file called "sitemap-wackowiki.xml" inside the xml folder. Generate a Sitemaps XML format compatible XML file. You might want to change the path to output it in your root folder as that is one of the requirements i.e. that the XML file is in the root folder.</small></label></td>
				<td><input type="checkbox" id="xml_sitemap" name="xml_sitemap" value="1"<?php echo ($engine->db->xml_sitemap ? ' checked' : '');?> /></td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl_setting">
				<td class="label"><label for="xml_sitemap_time"><strong>XML Sitemap generation time:</strong><br />
					<small>Generate a Sitemaps only once in this number of days, zero means on every page change.</small></label></td>
				<td><input type="number" min="0" maxlength="4" id="xml_sitemap_time" name="xml_sitemap_time" value="<?php echo (int) $engine->db->xml_sitemap_time;?>" /></td>
			</tr>
			<tr>
				<th colspan="2">
					<br />
					Miscellaneous
				</th>
			</tr>
			<tr class="hl_setting">
				<td class="label"><strong>Edit summary:</strong><br />
					<small>Shows change summary in the edit mode.</small></td>
				<td>
					<input type="radio" id="edit_summary_on" name="edit_summary" value="1"<?php echo ($engine->db->edit_summary == 1 ? ' checked' : '');?> /><label for="edit_summary_on"><?php echo $engine->_t('On');?></label>
					<input type="radio" id="edit_summary_mandatory" name="edit_summary" value="2"<?php echo ($engine->db->edit_summary == 2 ? ' checked' : '');?> /><label for="edit_summary_mandatory"><?php echo $engine->_t('Mandatory');?></label>
					<input type="radio" id="edit_summary_off" name="edit_summary" value="0"<?php echo (!$engine->db->edit_summary ? ' checked' : '');?> /><label for="edit_summary_off"><?php echo $engine->_t('Off');?></label>
				</td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl_setting">
				<td class="label"><strong>Minor edit:</strong><br />
					<small>Enables minor edit option in the edit mode.</small></td>
				<td>
					<input type="radio" id="minor_edit_on" name="minor_edit" value="1"<?php echo ($engine->db->minor_edit ? ' checked' : '');?> /><label for="minor_edit_on"><?php echo $engine->_t('On');?></label>
					<input type="radio" id="minor_edit_off" name="minor_edit" value="0"<?php echo (!$engine->db->minor_edit ? ' checked' : '');?> /><label for="minor_edit_off"><?php echo $engine->_t('Off');?></label>
				</td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl_setting">
				<td class="label"><strong>Review:</strong><br />
					<small>Enables review option in the edit mode.</small></td>
				<td>
					<input type="radio" id="review_on" name="review" value="1"<?php echo ($engine->db->review ? ' checked' : '');?> /><label for="review_on"><?php echo $engine->_t('On');?></label>
					<input type="radio" id="review_off" name="review" value="0"<?php echo (!$engine->db->review ? ' checked' : '');?> /><label for="review_off"><?php echo $engine->_t('Off');?></label>
				</td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl_setting">
				<td class="label"><label for="default_diff_mode"><strong>Default diff mode:</strong><br />
					<small>Preselected diff mode.</small></label></td>
				<td>
					<select id="language" name="default_diff_mode">
					<?php
						$diff_modes = $engine->_t('DiffMode');

						foreach ($engine->_t('DiffMode') as $mode => $diff_mode)
						{
							echo '<option value="' . $mode . '" '.($engine->db->default_diff_mode == $mode ? 'selected' : '') . '>' . $diff_mode . ' (' . $mode . ')</option>';
						}
					?>
					</select>
				</td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl_setting">
				<td class="label"><label for=""><strong>Allowed Diff modes:</strong><br />
					<small>It is recomended to select only the set of diff modes you want to use, other wise all diff modes are selected.</small></label></td>
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
						echo	"\t\t<td>\n\t\t\t" . '<input type="checkbox" name="diff_modes[' . $n . ']" id="mode_' . $mode . '" value="' . $mode . '" '. (in_array($mode, $diff_mode_list) ? ' checked' : ''). ' />' . "\n\t\t\t" .
								'<label for="mode_' . $mode . '">' . $diff_modes[$mode] . ' (' . $mode . ')</label>' . "\n\t\t</td>\n";

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
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl_setting">
				<td class="label"><strong>Autosubscribe:</strong><br />
					<small>Automatically sign a new page in the owner's notice of its changes.</small></td>
				<td>
					<input type="radio" id="disable_autosubscribe_on" name="disable_autosubscribe" value="0"<?php echo (!$engine->db->disable_autosubscribe ? ' checked' : '');?> /><label for="disable_autosubscribe_on"><?php echo $engine->_t('On');?></label>
					<input type="radio" id="disable_autosubscribe_off" name="disable_autosubscribe" value="1"<?php echo ($engine->db->disable_autosubscribe ? ' checked' : '');?> /><label for="disable_autosubscribe_off"><?php echo $engine->_t('Off');?></label>
				</td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl_setting">
				<td class="label"><strong>Allow anonymous publishing:</strong><br />
					<small>Allow users to published preferably anonymously (to hide the name).</small></td>
				<td>
					<input type="radio" id="publish_anonymously_on" name="publish_anonymously" value="1"<?php echo ($engine->db->publish_anonymously ? ' checked' : '');?> /><label for="publish_anonymously_on"><?php echo $engine->_t('On');?></label>
					<input type="radio" id="publish_anonymously_off" name="publish_anonymously" value="0"<?php echo (!$engine->db->publish_anonymously ? ' checked' : '');?> /><label for="publish_anonymously_off"><?php echo $engine->_t('Off');?></label>
				</td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl_setting">
				<td class="label"><label for="default_rename_redirect"><strong>When renaming put redirection:</strong><br />
					<small>By default, propose to redirect the old address pereimenuemoy page.</small></label></td>
				<td><input type="checkbox" id="default_rename_redirect" name="default_rename_redirect" value="1"<?php echo ($engine->db->default_rename_redirect ? ' checked' : '');?> /></td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl_setting">
				<td class="label"><label for="store_deleted_pages"><strong>Keep deleted pages:</strong><br />
					<small>When you delete a page (the comment) put her in a special section where she had some time (below) will be available for viewing and recovery.</small></label></td>
				<td><input type="checkbox" id="store_deleted_pages" name="store_deleted_pages" value="1"<?php echo ($engine->db->store_deleted_pages ? ' checked' : '');?> /></td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl_setting">
				<td class="label"><label for="keep_deleted_time"><strong>Storage time of deleted pages:</strong><br />
					<small>The period in days. It makes sense only if the previous option. Zero indicates the eternal possession (in this case the administrator can clear the "cart" manually).</small></label></td>
				<td><input type="number" min="0" maxlength="4" id="keep_deleted_time" name="keep_deleted_time" value="<?php echo (int) $engine->db->keep_deleted_time;?>" /></td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl_setting">
				<td class="label"><label for="pages_purge_time"><strong>Storage time of page revisions:</strong><br />
					<small>Automatically delete the older edition of the number of days. If you enter zero, the old edition will not be removed.</small></label></td>
				<td><input type="number" min="0" maxlength="4" id="pages_purge_time" name="pages_purge_time" value="<?php echo (int) $engine->db->pages_purge_time;?>" /></td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl_setting">
				<td class="label"><strong>Enable Referrers:</strong><br />
					<small>Allows to store and show external referrers.</small></td>
				<td>
					<input type="radio" id="enable_referrer_on" name="enable_referrers" value="1"<?php echo ($engine->db->enable_referrers == 1 ? ' checked' : '');?> /><label for="enable_referrer_on"><?php echo $engine->_t('On');?></label>
					<input type="radio" id="enable_referrer_admin" name="enable_referrers" value="2"<?php echo ($engine->db->enable_referrers == 2 ? ' checked' : '');?> /><label for="enable_referrer_admin"><?php echo $engine->_t('Admin');?></label>
					<input type="radio" id="enable_referrer_off" name="enable_referrers" value="0"<?php echo ($engine->db->enable_referrers == 0? ' checked' : '');?> /><label for="enable_referrer_off"><?php echo $engine->_t('Off');?></label>
				</td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl_setting">
				<td class="label"><label for="referrers_purge_time"><strong>Storage time of referrers:</strong><br />
					<small>Keep history of invoking external pages no more than this number of days. Zero means the perpetual possession, but to actively visit the site this could lead to overcrowding in the database.</small></label></td>
				<td><input type="number" min="0" maxlength="4" id="referrers_purge_time" name="referrers_purge_time" value="<?php echo (int) $engine->db->referrers_purge_time;?>" /></td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl_setting">
				<td class="label"><label for="noindex"><strong>Block search engines (Search Engine Visibility):</strong><br />
					<small>Block search engines, but allow normal visitors. Overrides page settings. <br />Discourage search engines from indexing this site, It is up to search engines to honor this request.</small></label></td>
				<td><input type="checkbox" id="noindex" name="noindex" value="1"<?php echo ($engine->db->noindex ? ' checked' : '');?> /></td>
			</tr>
		</table>
		<br />
		<div class="center">
			<input type="submit" id="submit" value="<?php echo $engine->_t('FormSave');?>" />
			<input type="reset" id="button" value="<?php echo $engine->_t('FormReset');?>" />
		</div>
<?php
	echo $engine->form_close();
}

?>