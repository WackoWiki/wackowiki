<div id="page">

<h3><?php echo str_replace('%1', $this->link('/'.$this->tag), $this->get_translation('PropertiesFor')); ?></h3>

<?php

// redirect to show method if page don't exists
if (!$this->page)
{
	$this->redirect($this->href('show'));
}

// deny for comment
if ($this->page['comment_on_id'])
{
	$this->redirect($this->href('', $this->get_page_tag_by_id($this->page['comment_on_id']), 'show_comments=1').'#'.$this->page['tag']);
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
		$this->query(
			"UPDATE ".$this->config['table_prefix']."page SET ".
				(isset($_POST['extended'])
				?	"hide_comments		= '".quote($this->dblink, (int)$_POST['hide_comments'])."', ".
					"hide_files			= '".quote($this->dblink, (int)$_POST['hide_files'])."', ".
					($this->config['hide_rating'] != 1
						? "hide_rating		= '".quote($this->dblink, (int)$_POST['hide_rating'])."', "
						: "").
					"hide_toc			= '".quote($this->dblink, (int)$_POST['hide_toc'])."', ".
					"hide_index			= '".quote($this->dblink, (int)$_POST['hide_index'])."', ".
					"tree_level			= '".quote($this->dblink, (int)$_POST['tree_level'])."', ".
					"allow_rawhtml		= '".quote($this->dblink, $allow_rawhtml)."', ".
					"disable_safehtml	= '".quote($this->dblink, $disable_safehtml)."', ".
					"noindex			= '".quote($this->dblink, (int)$_POST['noindex'])."' "
				: 	"lang				= '".quote($this->dblink, $_POST['lang'])."', ".
					"theme				= '".quote($this->dblink, (isset($_POST['theme']) ? $_POST['theme'] : ''))."', ".
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
		"SELECT COUNT(tag) AS total ".
		"FROM {$this->config['table_prefix']}revision ".
		"WHERE tag = '".quote($this->dblink, $this->tag)."' ".
		"GROUP BY tag");

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
			echo "<input type=\"radio\" id=\"commentsOn\" name=\"hide_comments\" value=\"0\" ".( !$this->config['hide_comments'] ? "checked=\"checked\"" : "" )."/><label for=\"commentsOn\">".$this->get_translation('MetaOn')."</label>";
			echo "<input type=\"radio\" id=\"commentsGuest\" name=\"hide_comments\" value=\"2\" ".( $this->config['hide_comments'] == 2 ? "checked=\"checked\"" : "" )."/><label for=\"commentsGuest\">".$this->get_translation('MetaRegistered')."</label>";
			echo "<input type=\"radio\" id=\"commentsOff\" name=\"hide_comments\" value=\"1\" ".( $this->config['hide_comments'] == 1 ? "checked=\"checked\"" : "" )."/><label for=\"commentsOff\">".$this->get_translation('MetaOff')."</label>";
			echo "</td>";
			echo "</tr>\n";
			echo "<tr class=\"lined\">";
			echo "<th class=\"form_left\" scope=\"row\">".$this->get_translation('MetaFiles')."</th>";
			echo "<td class=\"form_right\">";
			echo "<input type=\"radio\" id=\"filesOn\" name=\"hide_files\" value=\"0\" ".( !$this->config['hide_files'] ? "checked=\"checked\"" : "" )."/><label for=\"filesOn\">".$this->get_translation('MetaOn')."</label>";
			echo "<input type=\"radio\" id=\"filesGuest\" name=\"hide_files\" value=\"2\" ".( $this->config['hide_files'] == 2 ? "checked=\"checked\"" : "" )."/><label for=\"filesGuest\">".$this->get_translation('MetaRegistered')."</label>";
			echo "<input type=\"radio\" id=\"filesOff\" name=\"hide_files\" value=\"1\" ".( $this->config['hide_files'] == 1 ? "checked=\"checked\"" : "" )."/><label for=\"filesOff\">".$this->get_translation('MetaOff')."</label>";
			echo "</td>";
			echo "</tr>\n";
			if ($this->config['hide_rating'] != 1)
			{
				echo "<tr class=\"lined\">";
				echo "<th class=\"form_left\" scope=\"row\">".$this->get_translation('MetaRating')."</th>";
				echo "<td class=\"form_right\">";
				echo "<input type=\"radio\" id=\"ratingOn\" name=\"hide_rating\" value=\"0\" ".( !$this->config['hide_rating'] ? "checked=\"checked\"" : "" )."/><label for=\"ratingOn\">".$this->get_translation('MetaOn')."</label>";
				echo "<input type=\"radio\" id=\"ratingGuest\" name=\"hide_rating\" value=\"2\" ".( $this->config['hide_rating'] == 2 ? "checked=\"checked\"" : "" )."/><label for=\"ratingGuest\">".$this->get_translation('MetaRegistered')."</label>";
				echo "<input type=\"radio\" id=\"ratingOff\" name=\"hide_rating\" value=\"1\" ".( $this->config['hide_rating'] == 1 ? "checked=\"checked\"" : "" )."/><label for=\"ratingOff\">".$this->get_translation('MetaOff')."</label>";
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
			echo "<input type=\"radio\" id=\"indexmodeF\" name=\"index_mode\" value=\"0\" ".( $this->config['tree_level'] == 0 ? "checked=\"checked\"" : "" )."/><label for=\"indexmodeF\">".$this->get_translation('MetaIndexFull')."</label>";
			echo "<input type=\"radio\" id=\"indexmodeL\" name=\"index_mode\" value=\"1\" ".( $this->config['tree_level'] == 1 ? "checked=\"checked\"" : "" )."/><label for=\"indexmodeL\">".$this->get_translation('MetaIndexLower')."</label>";
			echo "<input type=\"radio\" id=\"indexmodeU\" name=\"index_mode\" value=\"2\" ".( $this->config['tree_level'] == 2 ? "checked=\"checked\"" : "" )."/><label for=\"indexmodeU\">".$this->get_translation('MetaIndexUpper')."</label>";
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
?>
<th class="form_left"></th>
<td class="form_right"><input type="submit" name="extended"
	value="<?php echo $this->get_translation('MetaStoreButton'); ?>"
	style="width: 120px" accesskey="s" /> &nbsp; <input type="button"
	value="<?php echo $this->get_translation('MetaCancelButton'); ?>"
	onclick="history.back();" style="width: 120px" /></td>
			<?php
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
			?> <?php echo "<tr class=\"lined\">"; ?>
<th class="form_left" scope="row"><label for="title"><?php echo $this->get_translation('MetaTitle'); ?></label></th>
<td class="form_right"><input id="title" name="title"
	value="<?php echo $this->page['title'] ?>" size="60" maxlength="100" /></td>

			<?php echo "</tr>\n<tr class=\"lined\">"; ?>
<th class="form_left" scope="row"><label for="keywords"><?php echo $this->get_translation('MetaKeywords'); ?></label></th>
<td class="form_right"><textarea id="keywords" name="keywords" rows="4"
	cols="51"><?php echo $this->page['keywords'] ?></textarea></td>

			<?php echo "</tr>\n<tr class=\"lined\">"; ?>
<th class="form_left" scope="row"><label for="description"><?php echo $this->get_translation('MetaDescription'); ?></label></th>
<td class="form_right"><textarea id="description" name="description"
	rows="4" cols="51"><?php echo $this->page['description'] ?></textarea></td>

			<?php echo "</tr>\n<tr class=\"lined\">"; ?>
<th class="form_left" scope="row"><label for="lang"><?php echo $this->get_translation('SetLang'); ?></label></th>
<td class="form_right"><select id="lang" name="lang">
<?php
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
?>
</select>

<div class="BewareChangeLang"><?php echo $this->get_translation('BewareChangeLang'); ?></div>
</td>
</tr>
<?php
if (isset($this->config['allow_themes_per_page']))
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
?>
<th class="form_left"></th>
<td class="form_right"><input type="submit"
	value="<?php echo $this->get_translation('MetaStoreButton'); ?>"
	style="width: 120px" accesskey="s" /> &nbsp; <input type="button"
	value="<?php echo $this->get_translation('MetaCancelButton'); ?>"
	onclick="history.back();" style="width: 120px" /></td>

<?php
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
	echo "<td class=\"form_right\">".$this->page['comments']."</td>";
	echo "</tr>\n<tr class=\"lined\">";
	echo "<th class=\"form_left\" scope=\"row\">".$this->get_translation('SettingsHits')."</th>";
	echo "<td class=\"form_right\">".$this->page['hits']."</td>";
	echo "</tr>\n";
	if ($this->config['hide_rating'] != 1)
	{
		echo "<tr class=\"lined\">";
		echo "<th class=\"form_left\" scope=\"row\">".$this->get_translation('SettingsRating')."</th>";
		echo "<td class=\"form_right\">".$rating['ratio'].' ('.$this->get_translation('RatingVoters').': '.(int)$rating['voters'].')'."</td>";
		unset($rating);
		echo "</tr>\n";
	}
	echo "</tr>\n</table>";

	?>
	<br />

<ul>
	<li><a href="<?php echo $this->href('edit');?>"><?php echo $this->get_translation('SettingsEdit'); ?></a></li>
	<li><a href="<?php echo $this->href('revisions');?>"><?php echo $this->get_translation('SettingsRevisions'); ?></a></li>
	<li><a href="<?php echo $this->href('clone');?>"><?php echo $this->get_translation('SettingsClone'); ?></a></li>
	<?php
	// Rename link (shows only if owner is current user or Admin)
	if ($this->user_is_owner() || $this->is_admin())
	{
		echo("<li><a href=\"".$this->href('rename')."\">".$this->get_translation('SettingsRename')."</a>
	</li>");
	}
	?>
	<?php // Remove link (shows only for page owner if allowed)
	if ($this->user_is_owner() && !$this->config['remove_onlyadmins'] || $this->is_admin())
	{
		echo("<li><a href=\"".$this->href('remove')."\">".$this->get_translation('SettingsRemove')."</a></li>\n");
		echo("<li><a href=\"".$this->href('purge')."\">".$this->get_translation('SettingsPurge')."</a></li>\n");
	}
	?>
	<?php
	// ACL link (shows only if owner is current user or Admin)
	if ($this->user_is_owner() || $this->is_admin())
	{
		echo("<li><a href=\"".$this->href('permissions')."\">".$this->get_translation('SettingsPermissions')."</a></li>\n");
	}
	?>
	<li><a href="<?php echo $this->href('categories'); ?>"><?php echo $this->get_translation('SettingsCategories'); ?></a></li>
	<li><a href="<?php echo $this->href('upload'); ?>"><?php echo $this->get_translation('SettingsUpload'); ?></a></li>
	<li><a href="<?php echo $this->href('referrers'); ?>"><?php echo $this->get_translation('SettingsReferrers'); ?></a></li>
	<li><a href="<?php echo $this->href('watch'); ?>"><?php echo ($this->iswatched === true ? $this->get_translation('RemoveWatch') : $this->get_translation('SetWatch')); ?></a></li>
	<li><a href="<?php echo $this->href('print');?>"><?php echo $this->get_translation('SettingsPrint'); ?></a></li>
	<li><a href="<?php echo $this->href('msword');?>"><?php echo $this->get_translation('SettingsMsword'); ?></a></li>
	<li><a href="<?php echo $this->href('latex');?>"><?php echo $this->get_translation('SettingsLatex'); ?></a></li>
	<li><a href="<?php echo $this->href('export.xml');?>"><?php echo $this->get_translation('SettingsXML'); ?></a></li>
</ul>


</div>
	<?php
}

else
{
	echo $this->get_translation('ReadAccessDenied');
}
?>
<br style="clear: both;" />
</div>
