<?php

if ($user_id = $this->GetUserId())
{
	if ($_GET['unwatch'] != '')
		$this->ClearWatch($user_id, $_GET['unwatch']);
	else if ($_GET['setwatch'] != '')
		$this->SetWatch($user_id, $_GET['setwatch']);

	if ($max) $limit = $max;
	else $limit	= 100;
	$prefix = $this->config["table_prefix"];

	if ($_GET['unwatched'] == 1)
	{
		$count	= $this->LoadSingle(
			"SELECT COUNT(p.tag) AS n ".
			"FROM {$prefix}pages AS p ".
			"LEFT JOIN {$prefix}watches AS w ".
				"ON (p.id = w.page_id ".
					"AND w.user_id = '".quote($this->dblink, $user_id)."') ".
			"WHERE p.comment_on_id = '0' ".
				"AND w.user_id IS NULL", 1);
		
		$pagination = $this->Pagination($count['n'], $limit, 'p', 'mode=mywatches&amp;unwatched=1#list');
		
		echo $this->GetTranslation('UnwatchedPages').' (<a href="'.
			$this->href('', '', 'mode='.$_GET['mode']).'#list">'.
			$this->GetTranslation('ViewWatchedPages').'</a>).<br /><br />';
	
		$cnt = 0;
		if ($pages = $this->LoadAll(
			"SELECT p.tag AS pagetag, p.id AS page_id ".
			"FROM {$prefix}pages AS p ".
			"LEFT JOIN {$prefix}watches AS w ".
				"ON (p.id = w.page_id ".
					"AND w.user_id = '".quote($this->dblink, $user_id)."') ".
			"WHERE p.comment_on_id = '0' ".
				"AND w.user_id IS NULL ".
			"ORDER BY pagetag ASC ".
			"LIMIT {$pagination['offset']}, ".($limit * 2)))
		{
			foreach ($pages as $page)
			{
				if (!$this->config['hide_locked'] || $this->HasAccess('read', $page['pagetag']))
				{
					$firstChar = strtoupper($page['pagetag'][0]);
					if (!preg_match('/'.$this->language['ALPHA'].'/', $firstChar))
						$firstChar = '#';
					
					if ($firstChar != $curChar)
					{
						if ($curChar) echo "<br />\n";
						echo "<strong>$firstChar</strong><br />\n";
						$curChar = $firstChar;
					}
			
					echo '<a href="'.$this->href('', '', (isset($_GET['p']) ? 'p='.$_GET['p'].'&amp;' : '').'mode=mywatches&amp;unwatched=1&amp;setwatch='.$page['page_id']).'#list">'.
						"<img src=\"".$this->GetConfigValue("theme_url")."icons/watch.gif\" title=\"".$this->GetTranslation("SetWatch")."\" alt=\"".$this->GetTranslation("SetWatch")."\"  />".'</a> '.$this->ComposeLinkToPage($page['pagetag'], '', '', 0)."<br />\n";
					$cnt++;
				}
				if ($cnt >= $limit) break;
			}
			
			// pagination
			echo "<br /><small>{$pagination['text']}</small>\n";
		}
		else
		{
			echo '<em>'.$this->GetTranslation('NoUnwatchedPages').'</em>';
		}
	}
	else
	{
		$count	= $this->LoadSingle(
			"SELECT COUNT( DISTINCT page_id ) as n ".
			"FROM {$prefix}watches ".
			"WHERE user_id = '".quote($this->dblink, $user_id)."'", 1);

		$pagination = $this->Pagination($count['n'], $limit, 'p', 'mode=mywatches#list');

		echo $this->GetTranslation('WatchedPages').' (<a href="'.
			$this->href('', '', 'mode='.$_GET['mode'].'&amp;unwatched=1').'#list">'.
			$this->GetTranslation('ViewUnwatchedPages').'</a>).<br /><br />';
	
		$cnt = 0;
		if ($pages = $this->LoadAll(
			"SELECT w.page_id, p.tag as tag ".
			"FROM {$prefix}watches AS w ".
			"LEFT JOIN {$prefix}pages AS p ".
				"ON (p.id = w.page_id) ".
			"WHERE w.user_id = '".quote($this->dblink, $user_id)."' ".
			"GROUP BY tag ".
			"LIMIT {$pagination['offset']}, $limit"))
		{
			foreach ($pages as $page)
			{
				if (!$this->config['hide_locked'] || $this->HasAccess('read', $page['tag']))
				{
					$firstChar = strtoupper($page['tag'][0]);
					if (!preg_match('/'.$this->language['ALPHA'].'/', $firstChar))
						$firstChar = '#';
					
					if ($firstChar != $curChar)
					{
						if ($curChar) echo "<br />\n";
						echo "<strong>$firstChar</strong><br />\n";
						$curChar = $firstChar;
					}
			
					echo '<a href="'.$this->href('', '', (isset($_GET['p']) ? 'p='.$_GET['p'].'&amp;' : '').'mode=mywatches&amp;unwatch='.$page['page_id']).'#list">'.
						"<img src=\"".$this->GetConfigValue("theme_url")."icons/unwatch.gif\" title=\"".$this->GetTranslation("RemoveWatch")."\" alt=\"".$this->GetTranslation("RemoveWatch")."\"  />".'</a> '.$this->ComposeLinkToPage($page['tag'], '', '', 0)."<br />\n";
					$cnt++;
				}
				if ($cnt >= $limit) break;
			}
			
			// pagination
			echo "<br /><small>{$pagination['text']}</small>\n";
		}
		else
		{
			echo '<em>'.$this->GetTranslation('NoWatchedPages').'</em>';
		}
	}
}
else
{
	echo '<em>'.$this->GetTranslation('NotLoggedInWatches').'</em>';
}

?>