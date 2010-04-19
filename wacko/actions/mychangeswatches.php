<?php

$max = "";

if ($user_id = $this->GetUserId())
{
	if ($max) $limit = $max;
	else $limit	= 100;
	$pref	= $this->config['table_prefix'];

	echo $this->GetTranslation('MyChangesWatches').
		' (<a href="'.$this->href('', '', 'mode=mychangeswatches&amp;reset=1').'#list">'.
		$this->GetTranslation('ResetChangesWatches').'</a>).<br /><br />';

	$pages = $this->LoadAll(
			"SELECT p.page_id, p.tag, p.modified, w.user_id ".
			"FROM {$pref}pages AS p, {$pref}watches AS w ".
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
			$this->Query(
				"UPDATE {$this->config['table_prefix']}watches ".
				"SET watch_time = NOW() ".
				"WHERE page_id = '".quote($this->dblink, $page['page_id'])."' ".
					"AND user_id = '".quote($this->dblink, $user_id)."'");
		$this->Redirect($this->href('', '', 'mode=mychangeswatches').'#list');
	}

	if ($pages == true)
	{
		foreach ($pages as $page)
			if (!$this->config['hide_locked'] || $this->HasAccess('read', $page['page_id']))
				echo '<small>('.$this->ComposeLinkToPage($page['tag'], 'revisions', $this->GetTimeStringFormatted($page['modified']), 0, $this->GetTranslation("History")).
					')</small> '.$this->ComposeLinkToPage($page['tag'], '', '', 0)."<br />\n";
	}
	else
	{
		echo '<em>'.$this->GetTranslation('NoChangesWatches').'</em>';
	}
}
else
{
	echo '<em>'.$this->GetTranslation('NotLoggedInWatches').'</em>';
}
?>