<?php

if (!defined('IN_WACKO'))
{
	exit;
}

$viewed = '';

if (!isset($root))		$root = $this->unwrap_link(isset($vars['for']) ? $vars['for'] : '');
if (!isset($root))		$root = $this->page['tag'];
if (!isset($date))		$date = isset($_GET['date']) ? $_GET['date'] : '';
if (!isset($hide_minor_edit)) $hide_minor_edit = isset($_GET['minor_edit']) ? $_GET['minor_edit'] : '';
if (!isset($noxml))		$noxml = 0;
if (!isset($title))		$title = '';
if (!isset($max))		$max = null;

$user	= $this->get_user();
$max	= $this->get_list_count($max);

$admin	= ($this->is_admin() ? true : false);

// process 'mark read' - reset session time
if (isset($_GET['markread']) && $user == true)
{
	$this->update_last_mark($user);
	$this->set_user_setting('last_mark', date('Y-m-d H:i:s', time()));
	$user = $this->get_user();
}

if (list ($pages, $pagination) = $this->load_changed((int)$max, $root, $date, $hide_minor_edit))
{
	$count	= 0;

	if ($user == true)
	{
		echo '<small><a href="'.$this->href('', '', 'markread=yes').'">'.$this->get_translation('MarkRead').'</a></small>';
	}

	if ($root == '' && !(int)$noxml)
	{
		echo '<span class="desc_rss_feed"><a href="'.$this->config['base_url'].'xml/changes_'.preg_replace('/[^a-zA-Z0-9]/', '', strtolower($this->config['site_name'])).'.xml"><img src="'.$this->config['theme_url'].'icon/spacer.png'.'" title="'.$this->get_translation('RecentChangesXMLTip').'" alt="XML" class="btn-feed"/></a></span>'."<br /><br />\n";
	}

	$show_pagination = $this->show_pagination(isset($pagination['text']) ? $pagination['text'] : '');

	// pagination
	echo $show_pagination;

	echo '<ul class="ul_list">'."\n";
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

			// tz offset
			$time_tz = $this->get_time_tz( strtotime($page['modified']) );
			$time_tz = date('Y-m-d H:i:s', $time_tz);

			// day header
			list($day, $time) = explode(' ', $time_tz);

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

				echo "<li><strong>".date($this->config['date_format'], strtotime($day))."</strong>\n<ul>\n";
				$curday = $day;
			}

			// review
			if ($this->config['review'] && $this->is_reviewer())
			{
				if ($page['reviewed'] == 0)
				{
					$review = '<span class="review">['.$this->compose_link_to_page($page['tag'], 'revisions', $this->get_translation('Review'), 0).']</span>';
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

			// do unicode entities
			if ($this->page['page_lang'] != $page['page_lang'])
			{
				$page_lang = $page['page_lang'];
			}
			else
			{
				$page_lang = '';
			}

			if ($page['edit_note'])
			{
				if ($page_lang)
				{
					$page['edit_note'] = $this->do_unicode_entities($page['edit_note'], $page_lang);
				}

				$edit_note = '<span class="editnote">['.$page['edit_note'].']</span>';
			}
			else
			{
				$edit_note = '';
			}

			if(isset($user['last_mark']))
			{
				$viewed = ($user['last_mark'] == true && $page['user_name'] != $user['user_name'] && $page['modified'] > $user['last_mark'] ? ' viewed' : '');
			}

			// cache page_id for for has_access validation in link function
			$this->page_id_cache[$page['tag']] = $page['page_id'];

			// print entry
			echo '<li class="lined'.$viewed.'"><span class="dt">'.
			($this->hide_revisions === false || $this->is_admin()
				? "".$this->compose_link_to_page($page['tag'], 'revisions', date($this->config['time_format_seconds'], strtotime( $time )), 0, $this->get_translation('RevisionTip'))." "
				: date($this->config['time_format_seconds'], strtotime( $time ))
			).
			"</span> &mdash; ".
			($title == 1
				? $this->link('/'.$page['tag'], '', $page['title'], '', 0, 1, $page_lang, 0)
				: $this->link('/'.$page['tag'], '', $page['tag'], $page['title'], 0, 1, $page_lang, 0)
			).
			" . . . . . . . . . . . . . . . . <small>".
			$this->user_link($page['user_name'], $lang = '', true, false).' '.
			$review.' '.
			$edit_note.
			"</small></li>\n";
		}
	}

	echo "</ul>\n</li>\n</ul>\n";

	// pagination
	echo $show_pagination;
}
else
{
	echo $this->get_translation('NoPagesFound');
}

?>