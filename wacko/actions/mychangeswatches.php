<?php

if ($user_id = $this->GetUserId())
{
	if ($max) $limit = $max;
	else $limit	= 100;
	$pref	= $this->config['table_prefix'];

	echo $this->GetTranslation('MyChangesWatches').
		' (<a href="'.$this->href('', '', 'mode=mychangeswatches&amp;reset=1').'#list">'.
		$this->GetTranslation('ResetChangesWatches').'</a>).<br /><br />';

	$pages = $this->LoadAll(
			"SELECT p.id, p.tag, p.time, w.user_id ".
			"FROM {$pref}pages AS p, {$pref}watches AS w ".
			"WHERE p.id = w.page_id ".
				"AND p.time  > w.time ".
				"AND w.user_id  = '".quote($this->dblink, $user_id)."' ".
				"AND p.user_id <> '".quote($this->dblink, $user_id)."' ".
			"GROUP BY p.tag ".
			"ORDER BY p.time DESC, p.tag ASC ".
			"LIMIT $limit");

	if ($_GET['reset'] == 1 && $pages == true)
	{
		foreach ($pages as $page)
			$this->Query(
				"UPDATE {$this->config['table_prefix']}watches ".
				"SET time = NOW() ".
				"WHERE page_id = '".quote($this->dblink, $page['id'])."' ".
					"AND user_id = '".quote($this->dblink, $user_id)."'");
		$this->Redirect($this->href('', '', 'mode=mychangeswatches').'#list');
	}

	if ($pages == true)
	{
		foreach ($pages as $page)
			if (!$this->config['hide_locked'] || $this->HasAccess('read', $page['id']))
				echo '<small>('.$this->ComposeLinkToPage($page['tag'], 'revisions', $this->GetTimeStringFormatted($page['time']), 0, $this->GetTranslation("History")).
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