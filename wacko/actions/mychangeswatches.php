<?php

if (!isset($max)) $max = '';

if ($user_id = $this->get_user_id())
{
	if ($max) $limit = $max;
	else $limit	= 100;
	$pref	= $this->config['table_prefix'];

	echo $this->get_translation('MyChangesWatches').
		' (<a href="'.$this->href('', '', 'mode=mychangeswatches&amp;reset=1').'#list">'.
		$this->get_translation('ResetChangesWatches').'</a>).<br /><br />';

	$pages = $this->load_all(
			"SELECT p.page_id, p.tag, p.modified, w.user_id ".
			"FROM {$pref}pages AS p, {$pref}watch AS w ".
			"WHERE p.page_id = w.page_id ".
				"AND p.modified > w.watch_time ".
				"AND w.user_id = '".quote($this->dblink, $user_id)."' ".
				"AND p.user_id <> '".quote($this->dblink, $user_id)."' ".
			"GROUP BY p.tag ".
			"ORDER BY p.modified DESC, p.tag ASC ".
			"LIMIT $limit");

	if ((isset($_GET['reset']) && $_GET['reset'] == 1) && $pages == true)
	{
		foreach ($pages as $page)
			$this->query(
				"UPDATE {$this->config['table_prefix']}watch ".
				"SET watch_time = NOW() ".
				"WHERE page_id = '".quote($this->dblink, $page['page_id'])."' ".
					"AND user_id = '".quote($this->dblink, $user_id)."'");
		$this->redirect($this->href('', '', 'mode=mychangeswatches').'#list');
	}

	if ($pages == true)
	{
		foreach ($pages as $page)
			if (!$this->config['hide_locked'] || $this->has_access('read', $page['page_id']))
				echo '<small>('.$this->compose_link_to_page($page['tag'], 'revisions', $this->get_time_string_formatted($page['modified']), 0, $this->get_translation('History')).
					')</small> '.$this->compose_link_to_page($page['tag'], '', '', 0)."<br />\n";
	}
	else
	{
		echo '<em>'.$this->get_translation('NoChangesWatches').'</em>';
	}
}
else
{
	echo '<em>'.$this->get_translation('NotLoggedInWatches').'</em>';
}
?>