<?php

if (!isset($root)) $root = $this->unwrap_link(isset($vars['for']) ? $vars['for'] : '');
if (!isset($root)) $root = $this->page['tag'];
if (!isset($date)) $date = isset($_GET['date']) ? $_GET['date'] : '';
if (!isset($hide_minor_edit)) $hide_minor_edit = isset($_GET['minor_edit']) ? $_GET['minor_edit'] : '';
if (!isset($noxml)) $noxml = 0;
if (!isset($title))		$title = '';

if ($user = $this->get_user())
{
	$usermax = $user['changes_count'];

	if ($usermax == 0)
	{
		$usermax = 10;
	}
}
else
{
	$usermax = 50;
}

if (!isset($max) || $usermax < $max)
{
	$max = $usermax;
}

$admin	= ( $this->is_admin() ? true : false );

// process 'mark read' - reset session time
if (isset($_GET['markread']) && $user == true)
{
	$this->update_last_mark($user);
	$this->set_user_setting('last_mark', date('Y-m-d H:i:s', time()));
	$user = $this->get_user();
}

if (list ($pages, $pagination) = $this->load_recently_changed((int)$max, $root, $date, $hide_minor_edit))
{
	$count	= 0;
	if ($user == true)
	{
		echo '<small><a href="'.$this->href('', '', 'markread=yes').'">'.$this->get_translation('MarkRead').'</a></small>';
	}
	if ($root == '' && !(int)$noxml)
	{
		echo "<span class=\"desc_rss_feed\"><a href=\"".$this->config['base_url']."xml/changes_".preg_replace('/[^a-zA-Z0-9]/', '', strtolower($this->config['wacko_name'])).".xml\"><img src=\"".$this->config['theme_url']."icons/xml.gif"."\" title=\"".$this->get_translation('RecentChangesXMLTip')."\" alt=\"XML\" /></a></span><br /><br />\n";
	}

	// pagination
	if (isset($pagination['text']))
	{
		echo "<span class=\"pagination\">{$pagination['text']}</span>\n";
	}

	echo "<ul class=\"ul_list\">\n";
	$access = true;

	foreach ($pages as $i => $page)
	{
		if ($this->config['hide_locked'])
		{
			$access = $this->has_access('read', $page['page_id']);
		}
		else
		{
			$access = true;
		}

		if ($access && ($count < $max))
		{
			$count++;

			// day header
			list($day, $time) = explode(' ', $page['modified']);

			if (!isset($curday))
			{
				$curday = '';
			}

			if ($day != $curday)
			{
				if ($curday)
				{
					echo "</ul>\n<br /></li>\n";
				}

				echo "<li><b>".date($this->config['date_format'], strtotime($day)).":</b>\n<ul>\n";
				$curday = $day;
			}

			// review
			if ($this->config['review'] && $this->is_reviewer())
			{
				if ($page['reviewed'] == 0)
				{
					$review = " <span class=\"review\">[".$this->compose_link_to_page($page['tag'], 'revisions', $this->get_translation('Review'), 0)."]</span>";
				}
				else
				{
					$review = '';
				}
			}
			else
			{
				$review = '';
			}

			if ($page['edit_note'])
			{
				$edit_note = " <span class=\"editnote\">[".$page['edit_note']."]</span>";
			}
			else
			{
				$edit_note = '';
			}

			$viewed = ( $user['last_mark'] == true && $page['user'] != $user['user_name'] && $page['modified'] > $user['last_mark'] ? ' class="viewed"' : '' );

			// print entry
			echo "<li ".$viewed."><span class=\"dt\">".date($this->config['time_format_seconds'], strtotime( $time ))."</span> &mdash; (".
			$this->compose_link_to_page($page['tag'], 'revisions', $this->get_translation('History'), 0).") ".
			($title == 1
				? $this->link('/'.$page['tag'], '', $page['title'], '', 0, 1, '', 0)
				: $this->link('/'.$page['tag'], '', $page['tag'], $page['title'])
			).
			" . . . . . . . . . . . . . . . . <small>".
			($page['user']
				? ($this->is_wiki_name($page['user'])
					? $this->link('/'.$page['user'], '', $page['user'])
					: $page['user'])
				: $this->get_translation('Guest')).
			$review.' '.
			$edit_note.
			"</small></li>\n";
		}
	}
	echo "</ul>\n</li>\n</ul>\n";

	// pagination
	if (isset($pagination['text']))
	{
		echo "<br /><span class=\"pagination\">{$pagination['text']}</span>\n";
	}
}
else
{
	echo $this->get_translation('NoPagesFound');
}

?>