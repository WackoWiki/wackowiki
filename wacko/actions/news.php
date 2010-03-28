<?php

if (!isset($mode))	$mode = "latest";
if (!isset($noxml)) $noxml = 0;

if (!isset($limit))	$limit = 10;
else			$limit = (int)$limit;

$newscluster	= $this->config["news_cluster"];
$newslevels		= $this->config["news_levels"];

// collect data
// heavy lifting here (watch out for REGEXPs!)
if ($mode == "latest")
{
	$pages	= $this->LoadAll(
		"SELECT p.page_id, p.owner_id, p.user_id, p.tag, p.title, p.created, p.comments, u.user_name AS  owner ".
		"FROM {$this->config['table_prefix']}pages p ".
			"INNER JOIN {$this->config['table_prefix']}users u ON (p.owner_id = u.user_id) ".
		"WHERE p.comment_on_id = '0' ".
			"AND p.tag REGEXP '^{$newscluster}{$newslevels}$' ".
		"ORDER BY p.created DESC ".
		"LIMIT $limit", 1);
}
else if ($mode == 'week')
{
	$pages	= $this->LoadAll(
		"SELECT p.page_id, p.owner_id, p.user_id, p.tag, p.title, p.created, p.comments, u.user_name AS owner ".
		"FROM {$this->config['table_prefix']}pages p ".
			"INNER JOIN {$this->config['table_prefix']}users u ON (p.owner_id = u.user_id) ".
		"WHERE p.comment_on_id = '0' ".
			"AND p.tag REGEXP '^{$newscluster}{$newslevels}$' ".
			"AND p.created > DATE_SUB( NOW(), INTERVAL 7 DAY ) ".
		"ORDER BY p.created DESC", 1);
}
else if ($mode == 'from' && $date)
{
	$date	= date("Y-m-d H:i:s", strtotime($date));
	$pages	= $this->LoadAll(
		"SELECT p.page_id, p.owner_id, p.user_id, p.tag, p.title, p.created, p.comments, u.user_name AS owner ".
		"FROM {$this->config['table_prefix']}pages p ".
			"INNER JOIN {$this->config['table_prefix']}users u ON (p.owner_id = u.user_id) ".
		"WHERE p.comment_on_id = '0' ".
			"AND p.tag REGEXP '^{$newscluster}{$newslevels}$' ".
			"AND p.created > '$date' ".
		"ORDER BY p.created DESC", 1);
}

// start output
echo "<div class=\"news\">";

// displaying XML icon
if (!(int)$noxml)
	{
		echo "<a href=\"".$this->config["base_url"]."xml/news_".preg_replace("/[^a-zA-Z0-9]/", "", strtolower($this->config["wacko_name"])).".xml\"><img src=\"".$this->config["theme_url"]."icons/xml.gif"."\" title=\"".$this->GetTranslation("RecentNewsXMLTip")."\" alt=\"XML\" /></a>\n";
	}

// displaying articles
if ($pages != 0)
{
	foreach ($pages as $page)
	{
		echo "<div class=\"newsarticle\">";
		echo '<h2 class="newstitle"><a href="'.$this->href('', $page['tag'], '').'">'.$page['title']."</a></h2>\n";
		echo "<div class=\"newsinfo\"><span>".$this->GetTimeStringFormatted($page['created']).' '.$this->GetTranslation("By").' '.( $page['owner'] == '' ? '<em>'.$this->GetTranslation('Guest').'</em>' : '<a href="'.$this->href('', $this->config['users_page'], 'profile='.$page['owner']).'">'.$page['owner'].'</a>' )."</span></div>\n";
		echo "<div class=\"newscontent\">".$this->Action('include', array('page' => '/'.$page['tag'], 'notoc' => 0, 'nomark' => 1), 1)."</div>\n";
		echo "<div class=\"newsmeta\">".($this->HasAccess("write",$page["page_id"]) ? $this->ComposeLinkToPage($page["tag"], "edit", $this->GetTranslation("EditText"), 0)." | " : "")."  ".
			'<a href="'.$this->href('', $page['tag'], 'show_comments=1').'#comments" title="'.$this->GetTranslation("NewsDiscuss").' '.$page['title'].'">'.(int)$page["comments"]." ".$this->GetTranslation("Comments_all")." &raquo "."</a></div>\n";
		echo "</div>";
	}
}
else
{
	echo $this->GetTranslation("NewsNotAvailable");
}

// TODO: show link to news page "news_cluster" OR (is news page) Previous Entries -> Pagination

// end output
echo "</div>";

?>