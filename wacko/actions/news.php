<?php

// {{news [mode=latest|week|from] [date=YYYY-MM-DD] [max=Number]}}

if (!isset($max)) $max = "";
if (!isset($mode))	$mode = "latest";
if (!isset($noxml)) $noxml = 0;
if ($max) $limit = $max;
if (!isset($limit))	$limit = 10;
else			$limit = (int)$limit;

$pages = "";
$prefix			= $this->config['table_prefix'];
$newscluster	= $this->config["news_cluster"];
$newslevels		= $this->config["news_levels"];

// collect data
// heavy lifting here (watch out for REGEXPs!)
if ($mode == "latest")
{
	$count	= $this->LoadSingle(
			"SELECT COUNT(tag) AS n ".
			"FROM {$prefix}page ".
			"WHERE tag REGEXP '^{$newscluster}{$newslevels}$' ".
				"AND comment_on_id = '0'", 1);

	$pagination = $this->Pagination($count['n'], $limit, 'p', 'mode=latest');

	$pages	= $this->LoadAll(
		"SELECT p.page_id, p.owner_id, p.user_id, p.tag, p.title, p.created, p.comments, u.user_name AS  owner ".
		"FROM {$prefix}page p ".
			"INNER JOIN {$prefix}user u ON (p.owner_id = u.user_id) ".
		"WHERE p.comment_on_id = '0' ".
			"AND p.tag REGEXP '^{$newscluster}{$newslevels}$' ".
		"ORDER BY p.created DESC ".
		"LIMIT {$pagination['offset']}, $limit", 1);
}
else if ($mode == 'week')
{
	$count	= $this->LoadSingle(
		"SELECT COUNT(tag) AS n ".
		"FROM {$prefix}page ".
		"WHERE tag REGEXP '^{$newscluster}{$newslevels}$' ".
			"AND created > DATE_SUB( NOW(), INTERVAL 7 DAY ) ".
			"AND comment_on_id = '0'", 1);

	$pagination = $this->Pagination($count['n'], $limit, 'p', 'mode=week');

	$pages	= $this->LoadAll(
		"SELECT p.page_id, p.owner_id, p.user_id, p.tag, p.title, p.created, p.comments, u.user_name AS owner ".
		"FROM {$prefix}page p ".
			"INNER JOIN {$prefix}user u ON (p.owner_id = u.user_id) ".
		"WHERE p.comment_on_id = '0' ".
			"AND p.tag REGEXP '^{$newscluster}{$newslevels}$' ".
			"AND p.created > DATE_SUB( NOW(), INTERVAL 7 DAY ) ".
		"ORDER BY p.created DESC ".
		"LIMIT {$pagination['offset']}, $limit", 1);
}
else if ($mode == 'from' && $date)
{
	$count	= $this->LoadSingle(
		"SELECT COUNT(tag) AS n ".
		"FROM {$prefix}page ".
		"WHERE tag REGEXP '^{$newscluster}{$newslevels}$' ".
			"AND created > '$date' ".
			"AND comment_on_id = '0'", 1);

	$pagination = $this->Pagination($count['n'], $limit, 'p', 'mode=week');

	$date	= date("Y-m-d H:i:s", strtotime($date));
	$pages	= $this->LoadAll(
		"SELECT p.page_id, p.owner_id, p.user_id, p.tag, p.title, p.created, p.comments, u.user_name AS owner ".
		"FROM {$prefix}page p ".
			"INNER JOIN {$prefix}user u ON (p.owner_id = u.user_id) ".
		"WHERE p.comment_on_id = '0' ".
			"AND p.tag REGEXP '^{$newscluster}{$newslevels}$' ".
			"AND p.created > '$date' ".
		"ORDER BY p.created DESC ".
		"LIMIT {$pagination['offset']}, $limit", 1);
}

// start output
echo "<div class=\"news\">";

// displaying XML icon
if (!(int)$noxml)
	{
		echo "<a href=\"".$this->config["base_url"]."xml/news_".preg_replace("/[^a-zA-Z0-9]/", "", strtolower($this->config["wacko_name"])).".xml\"><img src=\"".$this->config["theme_url"]."icons/xml.gif"."\" title=\"".$this->GetTranslation("RecentNewsXMLTip")."\" alt=\"XML\" /></a>\n";
	}

// displaying articles
if ($pages)
{
	// pagination
	if ((isset($pagination['text'])) && $pagination['text'] == true )
		echo "<br /><span class=\"pagination\">{$pagination['text']}</span>\n";

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
	// pagination
	if ((isset($pagination['text'])) && $pagination['text'] == true )
		echo "<br /><span class=\"pagination\">{$pagination['text']}</span>\n";
}
else
{
	echo "<br /><br />".$this->GetTranslation("NewsNotAvailable");
}

// end output
echo "</div>";

?>