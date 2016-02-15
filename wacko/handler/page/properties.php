<?php

if (!defined('IN_WACKO'))
{
	exit;
}

// redirect to show method if page don't exists
if (!$this->page)
{
	$this->redirect($this->href('show'));
}

// deny for comment
if ($this->page['comment_on_id'])
{
	$this->redirect($this->href('', $this->get_page_tag($this->page['comment_on_id']), 'show_comments=1').'#'.$this->page['tag']);
}
// and for forum page
else if ($this->forum === true && !$this->is_admin())
{
	$this->redirect($this->href());
}

?>
<div id="page">

<h3><?php echo str_replace('%1', $this->compose_link_to_page($this->tag, '', '', 0), $this->get_translation('PropertiesFor')); ?></h3>

<?php

if ($this->is_owner() || $this->is_admin() || $this->has_access('write', $this->page['page_id']))
{
	if ($_POST)
	{
		if ($this->is_admin() && isset($_POST['extended']))
		{
			$allow_rawhtml		= (int)$_POST['allow_rawhtml'];
			$disable_safehtml	= (int)$_POST['disable_safehtml'];
		}

		// update page metadata
		$this->sql_query(
			"UPDATE ".$this->config['table_prefix']."page SET ".
				(isset($_POST['extended'])
				?	"footer_comments	= '".(int)$_POST['footer_comments']."', ".
					"footer_files		= '".(int)$_POST['footer_files']."', ".
					($this->config['footer_rating'] != 0
						? "footer_rating	= '".(int)$_POST['footer_rating']."', "
						: "").
					"hide_toc			= '".(int)$_POST['hide_toc']."', ".
					"hide_index			= '".(int)$_POST['hide_index']."', ".
					"tree_level			= '".(int)$_POST['tree_level']."', ".
					"allow_rawhtml		= '".(int)$allow_rawhtml."', ".
					"disable_safehtml	= '".(int)$disable_safehtml."', ".
					"noindex			= '".(int)$_POST['noindex']."' "
				: 	"page_lang			= '".quote($this->dblink, $_POST['page_lang'])."', ".
					"theme				= '".quote($this->dblink, (isset($_POST['theme']) ? $_POST['theme'] : ''))."', ".
					"menu_tag			= '".quote($this->dblink, htmlspecialchars(trim($_POST['menu_tag']), ENT_COMPAT | ENT_HTML401, HTML_ENTITIES_CHARSET))."', ".
					"show_menu_tag		= '".quote($this->dblink, (int)$_POST['show_menu_tag'])."', ".
					"title				= '".quote($this->dblink, htmlspecialchars(trim($_POST['title']), ENT_COMPAT | ENT_HTML401, HTML_ENTITIES_CHARSET))."', ".
					"keywords			= '".quote($this->dblink, htmlspecialchars(trim($_POST['keywords']), ENT_COMPAT | ENT_HTML401, HTML_ENTITIES_CHARSET))."', ".
					"description		= '".quote($this->dblink, htmlspecialchars(trim($_POST['description']), ENT_COMPAT | ENT_HTML401, HTML_ENTITIES_CHARSET))."' "
				).
			"WHERE page_id = '".$this->page['page_id']."' ".
			"LIMIT 1");

		// log event
		$this->log(4, str_replace('%1', $this->tag.' '.(isset($_POST['title']) ? $_POST['title'] : ''), $this->get_translation('LogPageMetaUpdated', $this->config['language'])));

		// reload page
		$this->set_message($this->get_translation('MetaUpdated')."!");
		$this->redirect((isset($_POST['extended']) ? $this->href('properties', '', 'extended') : $this->href('properties')));
	}

	// load settings
	$revs = $this->load_single(
		"SELECT COUNT(revision_id) AS total ".
		"FROM {$this->config['table_prefix']}revision ".
		"WHERE page_id = '".$this->page['page_id']."' ".
		"GROUP BY tag ".
		"LIMIT 1");

	$rating = $this->load_single(
		"SELECT page_id, value, voters ".
		"FROM {$this->config['table_prefix']}rating ".
		"WHERE page_id = {$this->page['page_id']} ".
		"LIMIT 1");

	if ($rating['voters'] > 0)			$rating['ratio'] = $rating['value'] / $rating['voters'];
	if (is_float($rating['ratio']))		$rating['ratio'] = round($rating['ratio'], 2);
	if ($rating['ratio'] > 0)			$rating['ratio'] = '+'.$rating['ratio'];
	// show form

	// EXTENDED
	if (isset($_GET['extended']) || isset($_POST['extended']))
	{
		echo '<ul class="menu">
				<li><a href="'.$this->href('properties', '', '').'">'.$this->get_translation('UserSettingsGeneral').'</a></li>
				<li class="active">'.$this->get_translation('UserSettingsExtended')."</li>
			</ul><br /><br />\n";

		echo '<div class="page_settings">';

		echo $this->form_open('extended_properties', 'properties'); // , '', '', '', '', "extended"
		echo '<input type="hidden" name="extended" value="yes" />';
		echo "\n".'<table class="form_tbl">'."\n";


		// load settings (shows only if owner is current user or Admin)
		if ($this->is_owner() || $this->is_admin())
		{
			echo	'<tr class="lined">'.
						'<th class="form_left" scope="row">'.$this->get_translation('MetaComments')."</th>".
						'<td class="form_right">'.
							'<input type="radio" id="commentsOn"		name="footer_comments" value="1" '.( $this->config['footer_comments'] == 1 ? 'checked="checked" ' : '' ).'/><label for="commentsOn">'.$this->get_translation('MetaOn')."</label>".
							'<input type="radio" id="commentsGuest"	name="footer_comments" value="2" '.( $this->config['footer_comments'] == 2 ? 'checked="checked" ' : '' ).'/><label for="commentsGuest">'.$this->get_translation('MetaRegistered')."</label>".
							'<input type="radio" id="commentsOff"		name="footer_comments" value="0" '.( $this->config['footer_comments'] == 0 ? 'checked="checked" ' : '' ).'/><label for="commentsOff">'.$this->get_translation('MetaOff')."</label>".
						"</td>".
					"</tr>\n".
					'<tr class="lined">'.
						'<th class="form_left" scope="row">'.$this->get_translation('MetaFiles')."</th>".
						'<td class="form_right">'.
							'<input type="radio" id="filesOn" name="footer_files" value="1" '.( $this->config['footer_files'] == 1 ? 'checked="checked" ' : '' ).'/><label for="filesOn">'.$this->get_translation('MetaOn')."</label>".
							'<input type="radio" id="filesGuest" name="footer_files" value="2" '.( $this->config['footer_files'] == 2 ? 'checked="checked" ' : '' ).'/><label for="filesGuest">'.$this->get_translation('MetaRegistered')."</label>".
							'<input type="radio" id="filesOff" name="footer_files" value="0" '.( $this->config['footer_files'] == 0 ? 'checked="checked" ' : '' ).'/><label for="filesOff">'.$this->get_translation('MetaOff')."</label>".
						'</td>'.
					"</tr>\n";

			if ($this->config['footer_rating'] != 0)
			{
				echo	'<tr class="lined">'.
							'<th class="form_left" scope="row">'.$this->get_translation('MetaRating')."</th>".
							'<td class="form_right">'.
								'<input type="radio" id="ratingOn" name="footer_rating" value="1" '.( $this->config['footer_rating'] == 1 ? 'checked="checked" ' : '' ).'/><label for="ratingOn">'.$this->get_translation('MetaOn')."</label>".
								'<input type="radio" id="ratingGuest" name="footer_rating" value="2" '.( $this->config['footer_rating'] == 2 ? 'checked="checked" ' : '' ).'/><label for="ratingGuest">'.$this->get_translation('MetaRegistered')."</label>".
								'<input type="radio" id="ratingOff" name="footer_rating" value="0" '.( $this->config['footer_rating'] == 0 ? 'checked="checked" ' : '' ).'/><label for="ratingOff">'.$this->get_translation('MetaOff')."</label>".
							'</td>'.
						"</tr>\n";
			}

			echo	'<tr class="lined">'.
						'<th class="form_left" scope="row">'.$this->get_translation('MetaToc')."</th>".
						'<td class="form_right">'.
							'<input type="radio" id="tocOn" name="hide_toc" value="0" '.( !$this->config['hide_toc'] ? 'checked="checked" ' : '' ).'/><label for="tocOn">'.$this->get_translation('MetaOn')."</label>".
							'<input type="radio" id="tocOff" name="hide_toc" value="1" '.( $this->config['hide_toc'] ? 'checked="checked" ' : '' ).'/><label for="tocOff">'.$this->get_translation('MetaOff')."</label>".
						"</td>".
					"</tr>\n".
					'<tr class="lined">';
						'<th class="form_left" scope="row">'.$this->get_translation('MetaIndex')."</th>".
						'<td class="form_right">';
							'<input type="radio" id="indexOn" name="hide_index" value="0" '.( !$this->config['hide_index'] ? 'checked="checked" ' : '' ).'/><label for="indexOn">'.$this->get_translation('MetaOn')."</label>".
							'<input type="radio" id="indexOff" name="hide_index" value="1" '.( $this->config['hide_index'] ? 'checked="checked" ' : '' ).'/><label for="indexOff">'.$this->get_translation('MetaOff')."</label>".
						"</td>".
					"</tr>\n".
					'<tr class="lined">'.
						'<th class="form_left" scope="row">'.$this->get_translation('MetaIndexMode')."</th>".
						'<td class="form_right">'.
							'<input type="radio" id="indexmodeF" name="tree_level" value="0" '.( $this->config['tree_level'] == 0 ? 'checked="checked" ' : '' ).'/><label for="indexmodeF">'.$this->get_translation('MetaIndexFull')."</label>".
							'<input type="radio" id="indexmodeL" name="tree_level" value="1" '.( $this->config['tree_level'] == 1 ? 'checked="checked" ' : '' ).'/><label for="indexmodeL">'.$this->get_translation('MetaIndexLower')."</label>".
							'<input type="radio" id="indexmodeU" name="tree_level" value="2" '.( $this->config['tree_level'] == 2 ? 'checked="checked" ' : '' ).'/><label for="indexmodeU">'.$this->get_translation('MetaIndexUpper')."</label>".
						"</td>".
					"</tr>\n";

			if ($this->is_admin())
			{
				echo	'<tr class="lined">'.
							'<th class="form_left" scope="row">'.$this->get_translation('MetaHtml')."</th>".
							'<td class="form_right">'.
								'<input type="radio" id="htmlOn" name="allow_rawhtml" value="1" '.( $this->config['allow_rawhtml'] ? 'checked="checked" ' : '' ).'/><label for="htmlOn">'.$this->get_translation('MetaOn')."</label>".
								'<input type="radio" id="htmlOff" name="allow_rawhtml" value="0" '.( !$this->config['allow_rawhtml'] ? 'checked="checked" ' : '' ).'/><label for="htmlOff">'.$this->get_translation('MetaOff')."</label>".
							"</td>".
						"</tr>\n".
						'<tr class="lined">'.
							'<th class="form_left" scope="row">'.$this->get_translation('MetaSafeHtml')."</th>".
							'<td class="form_right">'.
								'<input type="radio" id="safehtmlOn" name="disable_safehtml" value="0" '.( !$this->config['disable_safehtml'] ? 'checked="checked" ' : '' ).'/><label for="safehtmlOn">'.$this->get_translation('MetaOn')."</label>".
								'<input type="radio" id="safehtmlOff" name="disable_safehtml" value="1" '.( $this->config['disable_safehtml'] ? 'checked="checked" ' : '' ).'/><label for="safehtmlOff">'.$this->get_translation('MetaOff')."</label>".
							"</td>".
						"</tr>\n";
			}

			echo	'<tr class="lined">'.
						'<th class="form_left" scope="row">'.$this->get_translation('MetaNoIndex')."</th>".
						'<td class="form_right">'.
							'<input type="radio" id="noindexOn" name="noindex" value="1" '.( $this->page['noindex'] ? 'checked="checked" ' : '' ).'/><label for="noindexOn">'.$this->get_translation('MetaOn')."</label>".
							'<input type="radio" id="noindexOff" name="noindex" value="0" '.( !$this->page['noindex'] ? 'checked="checked" ' : '' ).'/><label for="noindexOff">'.$this->get_translation('MetaOff')."</label>".
						"</td>".
					"</tr>\n".
					"<tr>".
						'<th class="form_left"></th>'.
						'<td class="form_right">'.
							'<input type="submit" class="OkBtn" name="extended" value="'.$this->get_translation('MetaStoreButton').'" style="width: 120px" accesskey="s" /> &nbsp;'.
							'<a href="'.$this->href('properties').'" style="text-decoration: none;"><input type="button" class="CancelBtn" value="'.$this->get_translation('MetaCancelButton').'" style="width: 120px" /></a>'.
						'</td>'.
					"</tr>\n</table>";

			echo $this->form_close();
			echo "</div>";
		}
	}
	// GENERAL
	else
	{
		echo '<ul class="menu">
				<li class="active">'.$this->get_translation('UserSettingsGeneral').'</li>
				<li><a href="'.$this->href('properties', '', 'extended').'">'.$this->get_translation('UserSettingsExtended')."</a></li>
			</ul><br /><br />\n";
		echo '<div class="page_settings">';
		echo $this->form_open('general_properties', 'properties');
		echo '<table class="form_tbl">';

		// show form
		// load settings (shows only if owner is current user or Admin)
		if ($this->is_owner() || $this->is_admin())
		{
			echo	'<tr class="lined">'.
						'<th class="form_left" scope="row">
							<label for="title">'.$this->get_translation('MetaTitle').'</label>
						</th>'.
						'<td class="form_right">
							<input type="text" id="title" name="title" value="'.$this->page['title'].'" size="60" maxlength="100" />
						</td>'.
					"</tr>\n".
					'<tr class="lined">'.
						'<th class="form_left" scope="row">
							<label for="keywords">'.$this->get_translation('MetaKeywords').'</label>
						</th>'.
						'<td class="form_right">
							<textarea id="keywords" name="keywords" rows="4" cols="51">'.$this->page['keywords']."</textarea>\n";

							if ($categories = $this->action('categories', array('page' => '/'.$this->page['tag'], 'list' => 0, 'nomark' => 1, 'label' => 0), 1))
							{
								echo $categories;
							}

			echo		'</td>'.
					"</tr>\n";

			echo	'<tr class="lined">'.
						'<th class="form_left" scope="row">
							<label for="description">'.$this->get_translation('MetaDescription').'</label>
						</th>'.
						'<td class="form_right">
							<textarea id="description" name="description" rows="4" cols="51">'.$this->page['description'].'</textarea>
						</td>'.
					"</tr>\n".
					'<tr class="lined">'.
						'<th class="form_left" scope="row">
							<label for="menu_tag">'.$this->get_translation('SetMenuLabel').'</label>
						</th>'.
						'<td class="form_right">
							<input type="text" id="menu_tag" name="menu_tag" value="'.(isset($this->page['menu_tag']) ? $this->page['menu_tag'] : '').'" size="60" maxlength="100" />
						</td>'.

			/*		"</tr>\n".'<tr class="lined">'.
						'<th class="form_left" scope="row">
							<label for="show_menu_tag">'.$this->get_translation('SetShowMenuLabel').'</label>
						</th>'.
						'<td class="form_right">'.
							'<input type="radio" id="menu_tag_on" name="show_menu_tag" value="1" '.( $this->page['show_menu_tag'] ? 'checked="checked" ' : '' ).'/><label for="menu_tag_on">'.$this->get_translation('MetaOn')."</label>".
							'<input type="radio" id="menu_tag_off" name="show_menu_tag" value="0" '.( !$this->page['show_menu_tag'] ? 'checked="checked" ' : '' ).'/><label for="menu_tag_off">'.$this->get_translation('MetaOff')."</label>".
						"</td>". */

					"</tr>\n".'<tr class="lined">'.
						'<th class="form_left" scope="row">
							<label for="page_lang">'.$this->get_translation('SetLang').'</label>
						</th>'.
						'<td class="form_right">'.
							'<select id="page_lang" name="page_lang">';

			if (!($clang = $this->page['page_lang']))
			{
				$clang = $this->config['language'];
			}

			$languages = $this->get_translation('Languages');

			if ($langs = $this->available_languages())
			{
				foreach ($langs as $lang)
				{
					echo '<option value="'.$lang.'" '.($clang == $lang ? 'selected="selected" ' : '').'>'.$languages[$lang].' ('.$lang.")</option>\n";
				}
			}

			echo "</select>\n";

			echo '<div class="hint">'.$this->get_translation('BewareChangeLang').'</div>';
			echo "</td>\n";
			echo "</tr>\n";

			if ($this->config['allow_themes_per_page'] == true)
			{
				echo	'<tr class="lined">'."\n".
							'<th class="form_left" scope="row">'.
								'<label for="theme">'.$this->get_translation('ChooseTheme')."</label>".
							"</th>\n".
							'<td class="form_right">'.
								'<select id="theme" name="theme">'."\n".
									'<option value="">--</option>';

				$themes = $this->available_themes();

				foreach ($themes as $theme)
				{
					echo '<option value="'.$theme.'" '.
						(isset($this->page['theme']) && $this->page['theme'] == $theme
							? 'selected="selected" '
							: ''
						).'>'.$theme."</option>\n";
				}

				echo 		"</select></td>\n".
						"</tr>\n";
			}

			echo	"<tr>\n".
						'<th class="form_left"></th>'.
						'<td class="form_right">'.
							'<input type="submit" class="OkBtn" value="'.$this->get_translation('MetaStoreButton').'" style="width: 120px" accesskey="s" /> &nbsp;'.
							'<a href="'.$this->href().'" style="text-decoration: none;"><input type="button" class="CancelBtn" value="'.$this->get_translation('MetaCancelButton').'" style="width: 120px" /></a>'.
						'</td>';
		}
		else
		{
			echo	'<tr class="lined">'.
						'<th class="form_left" scope="row">'.$this->get_translation('MetaTitle')."</th>";
						'<td class="form_right">'.$this->page['title']."</td>";
					"</tr>\n".
					'<tr class="lined">';
						'<th class="form_left" scope="row">'.$this->get_translation('MetaKeywords')."</th>";
						'<td class="form_right">'.$this->page['keywords']."</td>";
					"</tr>\n".
					'<tr class="lined">';
						'<th class="form_left" scope="row">'.$this->get_translation('MetaDescription')."</th>";
						'<td class="form_right">'.$this->page['description']."</td>";
					"</tr>\n".
					'<tr class="lined">';
						'<th class="form_left" scope="row">'.$this->get_translation('SetLang')."</th>";
						'<td class="form_right">'.$this->page['page_lang']."</td>";
		}

		echo "</tr>\n</table>\n";
		echo $this->form_close();
		echo "</div>\n";
	}

	echo '<aside class="page_tools">'."\n".
			'<table class="form_tbl">'."\n".
				'<tr class="lined">'.
					'<th class="form_left" scope="row">'.$this->get_translation('SettingsID')."</th>".
					'<td class="form_right">'.$this->page['page_id']."</td>".
				"</tr>\n".
				'<tr class="lined">'.
					'<th class="form_left" scope="row">'.$this->get_translation('Owner')."</th>".
					'<td class="form_right">'.$this->user_link($this->page['owner_name'], $lang = '', true, false)."</td>".
				"</tr>\n".
				'<tr class="lined">'.
					'<th class="form_left" scope="row">'.$this->get_translation('SettingsCreated')."</th>".
					'<td class="form_right">'.$this->get_time_formatted($this->page['created'])."</td>".
				"</tr>\n".
				'<tr class="lined">'.
					'<th class="form_left" scope="row">'.$this->get_translation('SettingsCurrent')."</th>".
					'<td class="form_right">'.$this->get_time_formatted($this->page['modified'])."</td>".
				"</tr>\n".
				'<tr class="lined">'.
					'<th class="form_left" scope="row">'.$this->get_translation('SettingsSize')."&nbsp;&nbsp;</th>".
					'<td class="form_right" title="'.$this->get_translation('SettingsSizeTip').'">'.$this->binary_multiples(strlen($this->page['body']), false, true, true).' / '.$this->binary_multiples(strlen($this->page['body_r']), false, true, true)."</td>".
				"</tr>\n".
				'<tr class="lined">'.
					'<th class="form_left" scope="row">'.$this->get_translation('SettingsTotalRevs')."</th>".
					'<td class="form_right"><a href="'.$this->href('revisions').'" title="'.$this->get_translation('RevisionTip').'">'.(int)$revs['total']."</a></td>".
				"</tr>\n".
				'<tr class="lined">'.
					'<th class="form_left" scope="row">'.$this->get_translation('SettingsTotalComs')."</th>".
					'<td class="form_right"><a href="'.$this->href('', '', 'show_comments=1#commentsheader').'" title="'.$this->get_translation('ShowComments').'">'.$this->page['comments'].'</a></td>'.
				"</tr>\n".
				'<tr class="lined">'.
					'<th class="form_left" scope="row">'.$this->get_translation('SettingsHits')."</th>".
					'<td class="form_right">'.number_format($this->page['hits'], 0, ',', '.')."</td>".
				"</tr>\n";

	unset($revs);

	if ($this->config['footer_rating'] != 0)
	{
		echo	'<tr class="lined">'.
					'<th class="form_left" scope="row">'.$this->get_translation('SettingsRating')."'</th>\n".
					'<td class="form_right">'.$rating['ratio'].' ('.$this->get_translation('RatingVoters').': '.(int)$rating['voters'].')'."</td>\n".
				"</tr>\n";
		unset($rating);
	}

	echo "</table>\n";

	echo "<br />\n";

	$icon ='<img src="'. $this->config['theme_url'].'icon/spacer.png"/>';

	echo '<ul class="page_handler">'."\n".
			'<li class="m-edit"><a href="'.$this->href('edit').'">'.$icon.$this->get_translation('SettingsEdit')."</a></li>\n".
			'<li class="m-revisions"><a href="'.$this->href('revisions').'">'.$icon.$this->get_translation('SettingsRevisions')."</a></li>\n".
			'<li class="m-clone"><a href="'.$this->href('clone').'">'.$icon.$this->get_translation('SettingsClone')."</a></li>\n";

	// Rename link (shows only if owner is current user or Admin)
	if ($this->is_owner() || $this->is_admin())
	{
		echo '<li class="m-edit"><a href="'.$this->href('rename').'">'.$icon.$this->get_translation('SettingsRename')."</a></li>\n";
	}

	// Remove link (shows only for page owner if allowed)
	if ($this->is_owner() && !$this->config['remove_onlyadmins'] || $this->is_admin())
	{
		echo '<li class="m-remove"><a href="'.$this->href('remove').'">'.$icon.$this->get_translation('SettingsRemove')."</a></li>\n";
		echo '<li class="m-purge"><a href="'.$this->href('purge').'">'.$icon.$this->get_translation('SettingsPurge')."</a></li>\n";
	}

	// Moderate link (shows only if current user is Moderator or Admin)
	if ($this->is_moderator() || $this->is_admin())
	{
		echo '<li class="m-moderate"><a href="'.$this->href('moderate').'">'.$icon.$this->get_translation('SettingsModerate')."</a></li>\n";
	}

	// ACL link (shows only if owner is current user or Admin)
	if ($this->is_owner() || $this->is_admin())
	{
		echo '<li class="m-permissions"><a href="'.$this->href('permissions').'">'.$icon.$this->get_translation('SettingsPermissions')."</a></li>\n";
	}

	echo	'<li class="m-categories"><a href="'.$this->href('categories').'">'.$icon.$this->get_translation('SettingsCategories')."</a></li>\n".
			'<li class="m-upload"><a href="'.$this->href('upload').'">'.$icon.$this->get_translation('SettingsUpload')."</a></li>\n".
			'<li class="m-referrers"><a href="'.$this->href('referrers').'">'.$icon.$this->get_translation('SettingsReferrers')."</a></li>\n".
			'<li class="'.($this->is_watched === true ? 'watch-off' : 'watch-on').'"><a href="'.$this->href('watch').'">'.$icon.($this->is_watched === true ? $this->get_translation('RemoveWatch') : $this->get_translation('SetWatch'))."</a></li>\n".
			'<li class="m-print"><a href="'.$this->href('print').'">'.$icon.$this->get_translation('SettingsPrint')."</a></li>\n".
	#		'<li class="m-word"><a href="'.$this->href('wordprocessor').'">'.$icon.$this->get_translation('SettingsWordprocessor')."</a></li>\n".
	#		'<li class="m-latex"><a href="'.$this->href('latex').'">'.$icon.$this->get_translation('SettingsLatex')."</a></li>\n".
	#		'<li class="m-xml"><a href="'.$this->href('export.xml').'">'.$icon.$this->get_translation('SettingsXML')."</a></li>\n".
		"</ul>\n".
	"</aside>\n";
}

else
{
	$message = $this->get_translation('ReadAccessDenied');
	$this->show_message($message, 'info');
}
?>

</div>