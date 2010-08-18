<?php

if (!isset($root)) $root = $this->unwrap_link(isset($vars['for']) ? $vars['for'] : "");
if (!isset($root)) $root = $this->page['tag'];
if (!isset($date)) $date = isset($_GET["date"]) ? $_GET["date"] :"";
if (!isset($hide_minor_edit)) $hide_minor_edit = isset($_GET['minor_edit']) ? $_GET['minor_edit'] :"";
if (!isset($noxml)) $noxml = 0;

if ($user = $this->get_user())
{
	$usermax = $user["changes_count"];
	if ($usermax == 0) $usermax = 10;
}
else
	$usermax = 50;
if (!isset($max) || $usermax < $max)
	$max = $usermax;

$admin	= ( $this->is_admin() ? true : false );

// process 'mark read' - reset session time
if (isset($_GET['markread']) && $user == true)
{
	$this->update_session_time($user);
	$this->set_user_setting('session_time', date('Y-m-d H:i:s', time()));
	$user = $this->get_user();
}

if (list ($pages, $pagination) = $this->load_recently_changed((int)$max, $root, $date, $hide_minor_edit))
{
	$count	= 0;
	if ($user == true)
	{
		echo '<small><small><a href="?markread=yes">'.$this->get_translation('ForumMarkRead').'</a></small></small>';
	}
	if ($root == "" && !(int)$noxml)
	{
		echo "<a href=\"".$this->config['base_url']."xml/changes_".preg_replace("/[^a-zA-Z0-9]/", "", strtolower($this->config['wacko_name'])).".xml\"><img src=\"".$this->config['theme_url']."icons/xml.gif"."\" title=\"".$this->get_translation("RecentChangesXMLTip")."\" alt=\"XML\" /></a><br /><br />\n";
	}

	// pagination
	if (isset($pagination['text']))
		echo "<span class=\"pagination\">{$pagination['text']}</span>\n";
	echo "<ul class=\"ul_list\">\n";
	$access = true;

	foreach ($pages as $i => $page)
	{
		if ($this->config['hide_locked'])
			$access = $this->has_access("read", $page['page_id']);
		else
			$access = true;

		if ($access && ($count < $max))
		{
			$count++;

			// day header
			list($day, $time) = explode(" ", $page['modified']);
			if (!isset($curday)) $curday = "";

			if ($day != $curday)
			{
				if ($curday)
				{
					print("</ul>\n<br /></li>\n");
				}

				print("<li><b>".date($this->config['date_format'],strtotime($day)).":</b>\n<ul>\n");
				$curday = $day;
			}

			if ($page['edit_note'])
			{
				$edit_note = " <span class=\"editnote\">[".$page['edit_note']."]</span>";
			}
			else
			{
				$edit_note = "";
			}

			// print entry
			print("<li><span class=\"dt\">".date($this->config['time_format_seconds'], strtotime( $time ))."</span> &mdash; (".
			$this->compose_link_to_page($page['tag'], "revisions", $this->get_translation("History"), 0).") ".
			$this->link( "/".$page['tag'], "", $page['tag'] )." . . . . . . . . . . . . . . . . <small>".
			($page['user']
				? ($this->is_wiki_name($page['user'])
					? $this->link("/".$page['user'], "", $page['user'])
					: $page['user'])
				: $this->get_translation("Guest")).
			$edit_note.
			"</small></li>\n");
		}
	}
	echo "</ul>\n</li>\n</ul>\n";

	// pagination
	if (isset($pagination['text']))
		echo "<br /><span class=\"pagination\">{$pagination['text']}</span>\n";
}
else
{
	echo $this->get_translation("NoPagesFound");
}

?>