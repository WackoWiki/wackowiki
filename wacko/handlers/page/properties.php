<?php

if (!defined('IN_WACKO'))
{
	exit;
}

?>
<div id="page">

<h3><?php echo str_replace('%1', $this->compose_link_to_page($this->tag, '', '', 0), $this->get_translation('PropertiesFor')); ?></h3>

<?php

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

if ($this->user_is_owner() || $this->is_admin() || $this->has_access('write', $this->page['page_id']))
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
				?	"footer_comments	= '".quote($this->dblink, (int)$_POST['footer_comments'])."', ".
					"footer_files		= '".quote($this->dblink, (int)$_POST['footer_files'])."', ".
					($this->config['footer_rating'] != 0
						? "footer_rating	= '".quote($this->dblink, (int)$_POST['footer_rating'])."', "
						: "").
					"hide_toc			= '".quote($this->dblink, (int)$_POST['hide_toc'])."', ".
					"hide_index			= '".quote($this->dblink, (int)$_POST['hide_index'])."', ".
					"tree_level			= '".quote($this->dblink, (int)$_POST['tree_level'])."', ".
					"allow_rawhtml		= '".quote($this->dblink, $allow_rawhtml)."', ".
					"disable_safehtml	= '".quote($this->dblink, $disable_safehtml)."', ".
					"noindex			= '".quote($this->dblink, (int)$_POST['noindex'])."' "
				: 	"lang				= '".quote($this->dblink, $_POST['lang'])."', ".
					"theme				= '".quote($this->dblink, (isset($_POST['theme']) ? $_POST['theme'] : ''))."', ".
					"menu_tag			= '".quote($this->dblink, htmlspecialchars(trim($_POST['menu_tag'])))."', ".
					"title				= '".quote($this->dblink, htmlspecialchars(trim($_POST['title'])))."', ".
					"keywords			= '".quote($this->dblink, htmlspecialchars(trim($_POST['keywords'])))."', ".
					"description		= '".quote($this->dblink, htmlspecialchars(trim($_POST['description'])))."' "
				).
			"WHERE page_id = '".quote($this->dblink, $this->page['page_id'])."' ".
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
		"WHERE page_id = '".quote($this->dblink, $this->page['page_id'])."' ".
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
		echo "<ul class=\"menu\"><li><a href=\"".$this->href('properties', '', '')."\">".$this->get_translation('UserSettingsGeneral')."</a></li><li class=\"menu\">".$this->get_translation('UserSettingsExtended')."</li></ul><br /><br />\n";

		echo "<div class=\"page_settings\">";

		echo $this->form_open('properties'); // , '', '', '', '', "extended"
		echo "<input type=\"hidden\" name=\"extended\" value=\"yes\" />";
		echo "\n<table class=\"form_tbl\">\n";


		// load settings (shows only if owner is current user or Admin)
		if ($this->user_is_owner() || $this->is_admin())
		{
			echo "<tr class=\"lined\">";
			echo "<th class=\"form_left\" scope=\"row\">".$this->get_translation('MetaComments')."</th>";
			echo "<td class=\"form_right\">";
			echo "<input type=\"radio\" id=\"commentsOn\"		name=\"footer_comments\" value=\"1\" ".( $this->config['footer_comments'] == 1 ? "checked=\"checked\"" : "" )."/><label for=\"commentsOn\">".$this->get_translation('MetaOn')."</label>";
			echo "<input type=\"radio\" id=\"commentsGuest\"	name=\"footer_comments\" value=\"2\" ".( $this->config['footer_comments'] == 2 ? "checked=\"checked\"" : "" )."/><label for=\"commentsGuest\">".$this->get_translation('MetaRegistered')."</label>";
			echo "<input type=\"radio\" id=\"commentsOff\"		name=\"footer_comments\" value=\"0\" ".( $this->config['footer_comments'] == 0 ? "checked=\"checked\"" : "" )."/><label for=\"commentsOff\">".$this->get_translation('MetaOff')."</label>";

			echo "</td>";
			echo "</tr>\n";
			echo "<tr class=\"lined\">";
			echo "<th class=\"form_left\" scope=\"row\">".$this->get_translation('MetaFiles')."</th>";
			echo "<td class=\"form_right\">";
			echo "<input type=\"radio\" id=\"filesOn\" name=\"footer_files\" value=\"1\" ".( $this->config['footer_files'] == 1 ? "checked=\"checked\"" : "" )."/><label for=\"filesOn\">".$this->get_translation('MetaOn')."</label>";
			echo "<input type=\"radio\" id=\"filesGuest\" name=\"footer_files\" value=\"2\" ".( $this->config['footer_files'] == 2 ? "checked=\"checked\"" : "" )."/><label for=\"filesGuest\">".$this->get_translation('MetaRegistered')."</label>";
			echo "<input type=\"radio\" id=\"filesOff\" name=\"footer_files\" value=\"0\" ".( $this->config['footer_files'] == 0 ? "checked=\"checked\"" : "" )."/><label for=\"filesOff\">".$this->get_translation('MetaOff')."</label>";
			echo "</td>";
			echo "</tr>\n";

			if ($this->config['footer_rating'] != 0)
			{
				echo "<tr class=\"lined\">";
				echo "<th class=\"form_left\" scope=\"row\">".$this->get_translation('MetaRating')."</th>";
				echo "<td class=\"form_right\">";
				echo "<input type=\"radio\" id=\"ratingOn\" name=\"footer_rating\" value=\"1\" ".( $this->config['footer_rating'] == 1 ? "checked=\"checked\"" : "" )."/><label for=\"ratingOn\">".$this->get_translation('MetaOn')."</label>";
				echo "<input type=\"radio\" id=\"ratingGuest\" name=\"footer_rating\" value=\"2\" ".( $this->config['footer_rating'] == 2 ? "checked=\"checked\"" : "" )."/><label for=\"ratingGuest\">".$this->get_translation('MetaRegistered')."</label>";
				echo "<input type=\"radio\" id=\"ratingOff\" name=\"footer_rating\" value=\"0\" ".( $this->config['footer_rating'] == 0 ? "checked=\"checked\"" : "" )."/><label for=\"ratingOff\">".$this->get_translation('MetaOff')."</label>";
				echo "</td>";
				echo "</tr>\n";
			}

			echo "<tr class=\"lined\">";
			echo "<th class=\"form_left\" scope=\"row\">".$this->get_translation('MetaToc')."</th>";
			echo "<td class=\"form_right\">";
			echo "<input type=\"radio\" id=\"tocOn\" name=\"hide_toc\" value=\"0\" ".( !$this->config['hide_toc'] ? "checked=\"checked\"" : "" )."/><label for=\"tocOn\">".$this->get_translation('MetaOn')."</label>";
			echo "<input type=\"radio\" id=\"tocOff\" name=\"hide_toc\" value=\"1\" ".( $this->config['hide_toc'] ? "checked=\"checked\"" : "" )."/><label for=\"tocOff\">".$this->get_translation('MetaOff')."</label>";
			echo "</td>";
			echo "</tr>\n";
			echo "<tr class=\"lined\">";
			echo "<th class=\"form_left\" scope=\"row\">".$this->get_translation('MetaIndex')."</th>";
			echo "<td class=\"form_right\">";
			echo "<input type=\"radio\" id=\"indexOn\" name=\"hide_index\" value=\"0\" ".( !$this->config['hide_index'] ? "checked=\"checked\"" : "" )."/><label for=\"indexOn\">".$this->get_translation('MetaOn')."</label>";
			echo "<input type=\"radio\" id=\"indexOff\" name=\"hide_index\" value=\"1\" ".( $this->config['hide_index'] ? "checked=\"checked\"" : "" )."/><label for=\"indexOff\">".$this->get_translation('MetaOff')."</label>";
			echo "</td>";
			echo "</tr>\n";
			echo "<tr class=\"lined\">";
			echo "<th class=\"form_left\" scope=\"row\">".$this->get_translation('MetaIndexMode')."</th>";
			echo "<td class=\"form_right\">";
			echo "<input type=\"radio\" id=\"indexmodeF\" name=\"tree_level\" value=\"0\" ".( $this->config['tree_level'] == 0 ? "checked=\"checked\"" : "" )."/><label for=\"indexmodeF\">".$this->get_translation('MetaIndexFull')."</label>";
			echo "<input type=\"radio\" id=\"indexmodeL\" name=\"tree_level\" value=\"1\" ".( $this->config['tree_level'] == 1 ? "checked=\"checked\"" : "" )."/><label for=\"indexmodeL\">".$this->get_translation('MetaIndexLower')."</label>";
			echo "<input type=\"radio\" id=\"indexmodeU\" name=\"tree_level\" value=\"2\" ".( $this->config['tree_level'] == 2 ? "checked=\"checked\"" : "" )."/><label for=\"indexmodeU\">".$this->get_translation('MetaIndexUpper')."</label>";
			echo "</td>";
			echo "</tr>\n";

			if ($this->is_admin())
			{
				echo "<tr class=\"lined\">";
				echo "<th class=\"form_left\" scope=\"row\">".$this->get_translation('MetaHtml')."</th>";
				echo "<td class=\"form_right\">";
				echo "<input type=\"radio\" id=\"htmlOn\" name=\"allow_rawhtml\" value=\"1\" ".( $this->config['allow_rawhtml'] ? "checked=\"checked\"" : "" )."/><label for=\"htmlOn\">".$this->get_translation('MetaOn')."</label>";
				echo "<input type=\"radio\" id=\"htmlOff\" name=\"allow_rawhtml\" value=\"0\" ".( !$this->config['allow_rawhtml'] ? "checked=\"checked\"" : "" )."/><label for=\"htmlOff\">".$this->get_translation('MetaOff')."</label>";
				echo "</td>";
				echo "</tr>\n";
				echo "<tr class=\"lined\">";
				echo "<th class=\"form_left\" scope=\"row\">".$this->get_translation('MetaSafeHtml')."</th>";
				echo "<td class=\"form_right\">";
				echo "<input type=\"radio\" id=\"safehtmlOn\" name=\"disable_safehtml\" value=\"0\" ".( !$this->config['disable_safehtml'] ? "checked=\"checked\"" : '' )."/><label for=\"safehtmlOn\">".$this->get_translation('MetaOn')."</label>";
				echo "<input type=\"radio\" id=\"safehtmlOff\" name=\"disable_safehtml\" value=\"1\" ".( $this->config['disable_safehtml'] ? "checked=\"checked\"" : '' )."/><label for=\"safehtmlOff\">".$this->get_translation('MetaOff')."</label>";
				echo "</td>";
				echo "</tr>\n";
			}

			echo "<tr class=\"lined\">";
			echo "<th class=\"form_left\" scope=\"row\">".$this->get_translation('MetaNoIndex')."</th>";
			echo "<td class=\"form_right\">";
			echo "<input type=\"radio\" id=\"noindexOn\" name=\"noindex\" value=\"1\" ".( $this->page['noindex'] ? "checked=\"checked\"" : '' )."/><label for=\"noindexOn\">".$this->get_translation('MetaOn')."</label>";
			echo "<input type=\"radio\" id=\"noindexOff\" name=\"noindex\" value=\"0\" ".( !$this->page['noindex'] ? "checked=\"checked\"" : '' )."/><label for=\"noindexOff\">".$this->get_translation('MetaOff')."</label>";
			echo "</td>";
			echo "</tr>\n";
			echo "<tr>";

			echo '<th class="form_left"></th>';
			echo '<td class="form_right">';
			echo '	<input type="submit" name="extended" value="'.$this->get_translation('MetaStoreButton').'" style="width: 120px" accesskey="s" /> &nbsp; <input type="button" value="'.$this->get_translation('MetaCancelButton').'" onclick="history.back();" style="width: 120px" />';
			echo '</td>';

			echo "</tr>\n</table>";
			echo $this->form_close();
			echo "</div>";
		}
	}
	// GENERAL
	else
	{
		echo "<ul class=\"menu\"><li class=\"menu\">".$this->get_translation('UserSettingsGeneral')."</li><li><a href=\"".$this->href('properties', '', 'extended')."\">".$this->get_translation('UserSettingsExtended')."</a></li></ul><br /><br />\n";
		echo "<div class=\"page_settings\">";
		echo $this->form_open('properties');
		echo "<table class=\"form_tbl\">";

		// show form
		// load settings (shows only if owner is current user or Admin)
		if ($this->user_is_owner() || $this->is_admin())
		{
			echo '<tr class="lined">';
			echo '<th class="form_left" scope="row"><label for="title">'.$this->get_translation('MetaTitle').'</label></th>';
			echo '<td class="form_right"><input id="title" name="title" value="'.$this->page['title'].'" size="60" maxlength="100" /></td>';

			echo "</tr>\n".'<tr class="lined">';
			echo '<th class="form_left" scope="row"><label for="keywords">'.$this->get_translation('MetaKeywords').'</label></th>';
			echo '<td class="form_right"><textarea id="keywords" name="keywords" rows="4" cols="51">'.$this->page['keywords'].'</textarea></td>';

			echo "</tr>\n<tr class=\"lined\">";
			echo '<th class="form_left" scope="row"><label for="description">'.$this->get_translation('MetaDescription').'</label></th>';
			echo '<td class="form_right"><textarea id="description" name="description" rows="4" cols="51">'.$this->page['description'].'</textarea></td>';

			echo '<tr class="lined">';
			echo '<th class="form_left" scope="row"><label for="menu_tag">'.$this->get_translation('SetMenuLabel').'</label></th>';
			echo '<td class="form_right"><input id="menu_tag" name="menu_tag" value="'.(isset($this->page['menu_tag']) ? $this->page['menu_tag'] : '').'" size="60" maxlength="100" /></td>';

			echo "</tr>\n<tr class=\"lined\">";
			echo '<th class="form_left" scope="row"><label for="lang">'.$this->get_translation('SetLang').'</label></th>';
			echo '<td class="form_right"><select id="lang" name="lang">';

			if (!($clang = $this->page['lang']))
			{
				$clang = $this->config['language'];
			}

			if ($langs = $this->available_languages())
			{
				foreach ($langs as $lang)
				{
					echo "<option value=\"".$lang."\" ".($clang==$lang ? "selected=\"selected\"" : "").">".$lang."</option>\n";
				}
			}

			echo "</select>\n";

			echo '<div class="BewareChangeLang">'.$this->get_translation('BewareChangeLang').'</div>';
			echo "</td>\n";
			echo "</tr>\n";

			if ($this->config['allow_themes_per_page'] == true)
			{
				echo "<tr class=\"lined\">\n";
				echo "<th class=\"form_left\" scope=\"row\"><label for=\"theme\">".$this->get_translation('ChooseTheme')."</label></th>\n";
				echo "<td class=\"form_right\"><select id=\"theme\" name=\"theme\">\n";

				echo '<option value="">--</option>';
				$themes = $this->available_themes();

				for ($i = 0; $i < count($themes); $i++)
				{
					echo '<option value="'.$themes[$i].'" '.
						(isset($this->page['theme']) && $this->page['theme'] == $themes[$i]
							? "selected=\"selected\""
							: ""
						).">".$themes[$i]."</option>\n";
				}

				echo "</select></td>\n";
				echo "</tr>\n";
			}

			echo "<tr>\n";
			echo '<th class="form_left"></th>';
			echo '<td class="form_right">';
			echo '<input type="submit" value="'.$this->get_translation('MetaStoreButton').'" style="width: 120px" accesskey="s" /> &nbsp; <input type="button" value="'.$this->get_translation('MetaCancelButton').'" onclick="history.back();" style="width: 120px" />';
			echo '</td>';
		}
		else
		{
			echo "<tr class=\"lined\">";
			echo "<th class=\"form_left\" scope=\"row\">".$this->get_translation('MetaTitle')."</th>";
			echo "<td class=\"form_right\">".$this->page['title']."</td>";
			echo "</tr>\n<tr class=\"lined\">";
			echo "<th class=\"form_left\" scope=\"row\">".$this->get_translation('MetaKeywords')."</th>";
			echo "<td class=\"form_right\">".$this->page['keywords']."</td>";
			echo "</tr>\n<tr class=\"lined\">";
			echo "<th class=\"form_left\" scope=\"row\">".$this->get_translation('MetaDescription')."</th>";
			echo "<td class=\"form_right\">".$this->page['description']."</td>";
			echo "</tr>\n<tr class=\"lined\">";
			echo "<th class=\"form_left\" scope=\"row\">".$this->get_translation('SetLang')."</th>";
			echo "<td class=\"form_right\">".$this->page['lang']."</td>";
		}

		echo "</tr>\n</table>";
		echo $this->form_close();
		echo "</div>";
	}

	echo "<div class=\"page_tools\">";
	echo "<table class=\"form_tbl\">";
	echo "<tr class=\"lined\">";
	echo "<th class=\"form_left\" scope=\"row\">".$this->get_translation('SettingsID')."</th>";
	echo "<td class=\"form_right\">".$this->page['page_id']."</td>";
	echo "</tr>\n<tr class=\"lined\">";
	echo "<th class=\"form_left\" scope=\"row\">".$this->get_translation('Owner')."</th>";
	echo "<td class=\"form_right\">"."<a href=\"".$this->href('', $this->config['users_page'], "profile=".$this->page['owner_name'])."\">".$this->page['owner_name']."</a>"."</td>";
	echo "</tr>\n<tr class=\"lined\">";
	echo "<th class=\"form_left\" scope=\"row\">".$this->get_translation('SettingsCreated')."</th>";
	echo "<td class=\"form_right\">".$this->get_time_string_formatted($this->page['created'])."</td>";
	echo "</tr>\n<tr class=\"lined\">";
	echo "<th class=\"form_left\" scope=\"row\">".$this->get_translation('SettingsCurrent')."</th>";
	echo "<td class=\"form_right\">".$this->get_time_string_formatted($this->page['modified'])."</td>";
	echo "</tr>\n<tr class=\"lined\">";
	echo "<th class=\"form_left\" scope=\"row\">".$this->get_translation('SettingsSize')."&nbsp;&nbsp;</th>";
	echo "<td class=\"form_right\" title=\"".$this->get_translation('SettingsSizeTip')."\">".ceil(strlen($this->page['body']) / 1000).' kB / '.ceil(strlen($this->page['body_r']) / 1000)." kB"."</td>";
	echo "</tr>\n<tr class=\"lined\">";
	echo "<th class=\"form_left\" scope=\"row\">".$this->get_translation('SettingsTotalRevs')."</th>";
	echo "<td class=\"form_right\"><a href=\"".$this->href('revisions')."\" title=\"".$this->get_translation('RevisionTip')."\">".(int)$revs['total']."</a></td>";
	unset($revs);
	echo "</tr>\n<tr class=\"lined\">";
	echo "<th class=\"form_left\" scope=\"row\">".$this->get_translation('SettingsTotalComs')."</th>";
	echo "<td class=\"form_right\"><a href=\"".$this->href('', '', 'show_comments=1#commentsheader')."\" title=\"".$this->get_translation('ShowComments')."\">".$this->page['comments']."</a></td>";
	echo "</tr>\n<tr class=\"lined\">";
	echo "<th class=\"form_left\" scope=\"row\">".$this->get_translation('SettingsHits')."</th>";
	echo "<td class=\"form_right\">".number_format($this->page['hits'], 0, ',', '.')."</td>";
	echo "</tr>\n";

	if ($this->config['footer_rating'] != 0)
	{
		echo "<tr class=\"lined\">";
		echo "<th class=\"form_left\" scope=\"row\">".$this->get_translation('SettingsRating')."</th>";
		echo "<td class=\"form_right\">".$rating['ratio'].' ('.$this->get_translation('RatingVoters').': '.(int)$rating['voters'].')'."</td>";
		unset($rating);
		echo "</tr>\n";
	}

	echo "</tr>\n</table>";

	echo "<br />";

	echo "<ul>";
	echo '<li><a href="'.$this->href('edit').'">'.$this->get_translation('SettingsEdit').'</a></li>';
	echo '<li><a href="'.$this->href('revisions').'">'.$this->get_translation('SettingsRevisions').'</a></li>';
	echo '<li><a href="'.$this->href('clone').'">'.$this->get_translation('SettingsClone').'</a></li>';

	// Rename link (shows only if owner is current user or Admin)
	if ($this->user_is_owner() || $this->is_admin())
	{
		echo "<li><a href=\"".$this->href('rename')."\">".$this->get_translation('SettingsRename')."</a></li>";
	}

	// Remove link (shows only for page owner if allowed)
	if ($this->user_is_owner() && !$this->config['remove_onlyadmins'] || $this->is_admin())
	{
		echo "<li><a href=\"".$this->href('remove')."\">".$this->get_translation('SettingsRemove')."</a></li>\n";
		echo "<li><a href=\"".$this->href('purge')."\">".$this->get_translation('SettingsPurge')."</a></li>\n";
	}

	// Moderate link (shows only if current user is Moderator or Admin)
	if ($this->is_moderator() || $this->is_admin())
	{
		echo "<li><a href=\"".$this->href('moderate')."\">".$this->get_translation('SettingsModerate')."</a></li>\n";
	}

	// ACL link (shows only if owner is current user or Admin)
	if ($this->user_is_owner() || $this->is_admin())
	{
		echo "<li><a href=\"".$this->href('permissions')."\">".$this->get_translation('SettingsPermissions')."</a></li>\n";
	}

	echo '<li><a href="'.$this->href('categories').'">'.$this->get_translation('SettingsCategories').'</a></li>';
	echo '<li><a href="'.$this->href('upload').'">'.$this->get_translation('SettingsUpload').'</a></li>';
	echo '<li><a href="'.$this->href('referrers').'">'.$this->get_translation('SettingsReferrers').'</a></li>';
	echo '<li><a href="'.$this->href('watch').'">'.($this->iswatched === true ? $this->get_translation('RemoveWatch') : $this->get_translation('SetWatch')).'</a></li>';
	echo '<li><a href="'.$this->href('print').'">'.$this->get_translation('SettingsPrint').'</a></li>';
	# echo '<li><a href="'.$this->href('msword').'">'.$this->get_translation('SettingsMsword').'</a></li>';
	# echo '<li><a href="'.$this->href('latex').'">'.$this->get_translation('SettingsLatex').'</a></li>';
	echo '<li><a href="'.$this->href('export.xml').'">'.$this->get_translation('SettingsXML').'</a></li>';

	echo '</ul>';
	echo '</div>';
}

else
{
	echo $this->get_translation('ReadAccessDenied');
}
?>
<br style="clear: both;" />
</div>
