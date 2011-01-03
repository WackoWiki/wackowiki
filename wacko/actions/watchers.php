<?php

if (!isset($nomark)) $nomark = '';

if (isset($vars['for']))
{
	$tag = $this->unwrap_link($vars[0]);
	$page_id = $this->get_page_id($tag);
}
else
{
	$tag = $this->tag;
	$page_id = $this->page['page_id'];
}
if ($this->user_is_owner($page_id))
{
	$watchers = $this->load_all(
		"SELECT w.*, u.user_name ".
		"FROM ".$this->config['table_prefix']."watch w ".
			"LEFT JOIN ".$this->config['table_prefix']."user u ON (w.user_id = u.user_id) ".
		"WHERE w.page_id = '".quote($this->dblink, $page_id)."' ".
		"");

	if ($watchers)
	{
		$title = $this->get_translation('Watchers');
		$title = str_replace('%1', $this->link('/'.$tag, '', $tag),  $title);
		if (!$nomark)
			echo "<div class=\"layout-box\"><p class=\"layout-box\"><span>".$title.":</span></p>\n";

		foreach ($watchers as $watcher)
		{
			$user = $watcher['user_name'];
			echo $this->link('/'.$user, '', $user)."<br />";
		}
		if (!$nomark)
			echo "</div>\n";
	}
	else
	{
		if (!$nomark)
			echo str_replace('%1',  $this->link('/'.$tag, '', $tag), $this->get_translation('NoWatchers'));
	}
}
else
{
	if (!$nomark)
		echo str_replace('%1',  $this->link('/'.$tag, '', $tag), $this->get_translation('NotOwnerAndViewWatchers'));
}

?>