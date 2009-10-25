<?php

if (!isset($mode))		$mode = 'latest';

if (!isset($limit))	$limit = 10;
else			$limit = (int)$limit;

$newscluster	= $this->config['news_cluster'];
$newslevels		= $this->config['news_levels'];

// collect data
// heavy lifting here (watch out for REGEXPs!)
if ($mode == 'latest')
{
	$pages	= $this->LoadAll(
		"SELECT tag, title, owner, user, created ".
		"FROM {$this->config['table_prefix']}pages ".
		"WHERE comment_on_id = '0' ".
			"AND tag REGEXP '^{$newscluster}{$newslevels}$' ".
		"ORDER BY created DESC ".
		"LIMIT $limit", 1);
}
else if ($mode == 'week')
{
	$pages	= $this->LoadAll(
		"SELECT tag, title, owner, user, created ".
		"FROM {$this->config['table_prefix']}pages ".
		"WHERE comment_on_id = '0' ".
			"AND tag REGEXP '^{$newscluster}{$newslevels}$' ".
			"AND created > DATE_SUB( NOW(), INTERVAL 7 DAY ) ".
		"ORDER BY created DESC", 1);
}
else if ($mode == 'from' && $date)
{
	$date	= date('Y-m-d H:i:s', strtotime($date));
	$pages	= $this->LoadAll(
		"SELECT tag, title, owner, user, created ".
		"FROM {$this->config['table_prefix']}pages ".
		"WHERE comment_on_id = '0' ".
			"AND tag REGEXP '^{$newscluster}{$newslevels}$' ".
			"AND created > '$date' ".
		"ORDER BY created DESC", 1);
}

// displaying articles
if ($pages != 0)
{
	foreach ($pages as $page)
	{
		echo '<h2><a href="'.$this->href('', $page['tag'], '').'">'.$page['title'].'</a></h2>'.$page['created'].' '.$this->GetTranslation("By").' '.( $page['owner'] == '' ? '<em>'.$this->GetTranslation('Guest').'</em>' : '<a href="'.$this->href('', $this->config['users_page'], 'profile='.$page['owner']).'">'.$page['owner'].'</a>' ).'';
		echo $this->Action('include', array('page' => '/'.$page['tag'], 'notoc' => 0, 'nomark' => 1), 1);
		echo '<span class="newsinfo">'.$this->GetTranslation('Comments_all').': '.(int)$page['comments'].' | '.
			'<a href="'.$this->href('', $page['tag'], 'show_comments=1').'#comments">'.$this->GetTranslation("NewsDiscuss").'</a></span>';
	}
}
else
{
	echo $this->GetTranslation("NewsNotAvailable");
}

?>