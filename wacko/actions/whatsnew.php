<?php

$max = "";
$noxml = "";
$printed = "";
$curday = "";

if (!$max || $max > 100) $max = 100;

$admin	= $this->IsAdmin();
$user	= $this->GetUser();

// process 'mark read' - reset session time
if (isset($_GET['markread']) && $user == true)
{
	$this->UpdateSessionTime($user);
	$this->SetUserSetting('session_time', date('Y-m-d H:i:s', time()));
	$user = $this->GetUser();
}

// loading new pages/comments
$pages1 = $this->LoadAll(
	"SELECT p.page_id, p.tag, p.created, p.modified, p.title, p.comment_on_id, p.ip, p.created AS date, c.tag as comment_on_page, user_name ".
	"FROM {$this->config['table_prefix']}pages p ".
		"LEFT JOIN {$this->config['table_prefix']}pages c ON (p.comment_on_id = c.page_id) ".
		"LEFT JOIN {$this->config['table_prefix']}users u ON (p.user_id = u.user_id) ".
	"ORDER BY p.created DESC ".
	"LIMIT ".($max * 2), 1);
// loading revisions
$pages2 = $this->LoadAll(
	"SELECT p.page_id, p.tag, p.created, p.modified, p.title, p.comment_on_id, p.ip, p.modified AS date, c.tag as comment_on_page, user_name ".
	"FROM {$this->config['table_prefix']}pages p ".
		"LEFT JOIN {$this->config['table_prefix']}pages c ON (p.comment_on_id = c.page_id) ".
		"LEFT JOIN {$this->config['table_prefix']}users u ON (p.user_id = u.user_id) ".
	"WHERE p.comment_on_id = '' ".
	"ORDER BY modified DESC ".
	"LIMIT ".($max * 2), 1);

if ($pages = array_merge($pages1, $pages2))
{
	// sort by dates
	$sort_dates = create_function(
		'$a, $b',	// func params
		'if ($a["date"] == $b["date"]) '.
			'return 0;'.
		'return ($a["date"] < $b["date"] ? 1 : -1);');
	usort($pages, $sort_dates);

	$count	= 0;

	if ($user == true)
	{
		echo '<small><small><a href="?markread=yes">'.$this->GetTranslation('ForumMarkRead').'</a></small></small>';
	}

	if (!(int)$noxml)
	{
		echo "<a href=\"".$this->config["base_url"]."xml/changes_".preg_replace("/[^a-zA-Z0-9]/", "", strtolower($this->config["wacko_name"])).".xml\"><img src=\"".$this->config["theme_url"]."icons/xml.gif"."\" title=\"".$this->GetTranslation("RecentChangesXMLTip")."\" alt=\"XML\" /></a><br /><br />\n";
	}

	echo "<ul class=\"ul_list\">\n";

	foreach ($pages as $page)
	{
		if ($this->config['hide_locked'])
			$access = ( $page['comment_on_id'] ? $this->HasAccess('read', $page['comment_on_id']) : $this->HasAccess('read', $page['page_id']) );
		else
			$access = true;

		if ($access && isset($page['tag']) && ($printed[$page['tag']] != $page['date']) && ($count++ < $max))
		{
			$printed[$page['tag']] = $page['date'];	// ignore duplicates

			// day header
			list($day, $time) = explode(' ', $page['date']);

			if ($day != $curday)
			{
				if ($curday) print("</ul>\n<br /></li>\n");
				echo '<li><strong>'.date($this->config['date_format'],strtotime($day)).":</strong>\n<ul>\n";
				$curday = $day;
			}

			// print entry
			$separator = " . . . . . . . . . . . . . . . . ";
			$author = ( $page['user_name'] == GUEST ? '<em title="'.( $admin ? $page['ip'] : '' ).'">'.$this->GetTranslation('Guest').'</em>' : '<a href="'.$this->href('', $this->config['users_page'], 'profile='.$page['user_name']).'" title="'.( $admin ? $page['ip'] : '' ).'">'.$page['user_name'].'</a>' );
			$viewed = ( $user['session_time'] == true && $page['user_name'] != $user['user_name'] && $page['date'] > $user['session_time'] ? ' style="font-weight:600;"' : '' );
			echo '<li'.$viewed.'><span class=\"dt\">'.date($this->config['time_format_seconds'], strtotime($time)).'&nbsp;&nbsp;</span>';

			// new comment
			if ($page['comment_on_id'])
			{
				preg_match('/^[^\/]+/', $page['comment_on_page'], $subtag);
				echo "<img src=\"".$this->config["theme_url"]."icons/comment.png"."\" title=\"".$this->GetTranslation("NewCommentAdded")."\" alt=\"[comment]\" /> ".''.$this->Link('/'.$page['tag'], '', $this->GetTranslation("Comment"), 0, 1).' '.$this->GetTranslation("To").' '.$this->Link('/'.$page['comment_on_page'], '', $this->GetPageTitle("" , $page['comment_on_id']), 1).' &nbsp;&nbsp;&rarr; '.$this->GetTranslation("Cluster").' '.$subtag[0].$separator.$author.'';
			}
			// new page
			else if ($page['created'] == $page['modified'])
			{
				preg_match('/^[^\/]+/', $page['tag'], $subtag);
				echo "<img src=\"".$this->config["theme_url"]."icons/add.gif"."\" title=\"".$this->GetTranslation("NewPageCreated")."\" alt=\"[new]\" /> ".''.$this->Link('/'.$page['tag'], '', $page['title'], 0, 1).' &nbsp;&nbsp;&rarr; '.$this->GetTranslation("Cluster").' '.$subtag[0].$separator.$author.'';
			}
			// new revision
			else
			{
				preg_match('/^[^\/]+/', $page['tag'], $subtag);
				echo "<img src=\"".$this->config["theme_url"]."icons/edit.gif"."\" title=\"".$this->GetTranslation("NewRevisionAdded")."\" alt=\"[changed]\" /> ".''.$this->Link('/'.$page['tag'], '', $page['title'], 0, 1).' ('.$this->Link('/'.$page['tag'], 'revisions', $this->GetTranslation("History"), 0, 1).') &nbsp;&nbsp;&rarr; '.$this->GetTranslation("Cluster").' '.$subtag[0].$separator.$author.'';
			}

			echo "</li>\n";
		}
	}
	echo "</ul>\n</li>\n</ul>\n";
}

?>