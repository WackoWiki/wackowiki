<?php

if (!defined('IN_WACKO'))
{
	exit;
}

if (!isset($nomark))	$nomark = false;
if (!isset($for))		$for = '';

if ($for)
{
	$tag		= $this->unwrap_link($for);
	$page_id	= $this->get_page_id($tag);
}
else
{
	$tag		= $this->tag;
	$page_id	= $this->page['page_id'];
}

if ($this->is_owner($page_id))
{
	$watchers = $this->load_all(
		"SELECT w.*, u.user_name ".
		"FROM ".$this->config['table_prefix']."watch w ".
			"LEFT JOIN ".$this->config['table_prefix']."user u ON (w.user_id = u.user_id) ".
		"WHERE w.page_id = '".(int)$page_id."' ".
		"ORDER BY u.user_name ASC");

	if ($watchers)
	{
		$title = Ut::perc_replace($this->get_translation('Watchers'), $this->link('/'.$tag, '', $tag));

		if (!$nomark)
		{
			echo '<div class="layout-box"><p class="layout-box"><span>'.$title.":</span></p>\n";
		}

		echo '<ol class="">'."\n";

		foreach ($watchers as $watcher)
		{
			$user_name = $watcher['user_name'];
			#echo $this->link('user:'.$user_name, '', $user_name)."<br />";
			echo '<li>'.$this->user_link($user_name, '', true, false)."</li>\n";
		}

		echo "</ol>\n";

		if (!$nomark)
		{
			echo "</div>\n";
		}
	}
	else
	{
		if (!$nomark)
		{
			echo Ut::perc_replace($this->get_translation('NoWatchers'), $this->link('/'.$tag, '', $tag));
		}
	}
}
else
{
	if (!$nomark)
	{
		echo Ut::perc_replace($this->get_translation('NotOwnerAndViewWatchers'), $this->link('/'.$tag, '', $tag));
	}
}

?>
