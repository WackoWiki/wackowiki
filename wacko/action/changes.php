<?php

if (!defined('IN_WACKO'))
{
	exit;
}

$viewed = '';

if (!isset($root) && isset($for))	$root = $this->unwrap_link($for);
if (!isset($root))		$root = '';
if (!isset($date))		$date = @$_GET['date'];
if (!isset($hide_minor_edit)) $hide_minor_edit = @$_GET['minor_edit'];
if (!isset($noxml))		$noxml = 0;
if (!isset($title))		$title = '';
if (!isset($max))		$max = '';

$user	= $this->get_user();
$max	= $this->get_list_count($max);

// process 'mark read' - reset session time
if (isset($_GET['markread']) && $user)
{
	$this->update_last_mark($user);
	$this->set_user_setting('last_mark', date('Y-m-d H:i:s'));
}

if (list ($pages, $pagination) = $this->load_changed($max, $root, $date, $hide_minor_edit))
{

	if ($user)
	{
		echo '<small><a href="'.$this->href('', '', 'markread=yes').'">'.$this->get_translation('MarkRead').'</a></small>';
	}

	if (!$root && !(int)$noxml)
	{
		echo '<span class="desc_rss_feed"><a href="'.$this->config['base_url'].'xml/changes_'.
			preg_replace('/[^a-zA-Z0-9]/', '', strtolower($this->config['site_name'])).'.xml"><img src="'.
			$this->config['theme_url'].'icon/spacer.png'.'" title="'.$this->get_translation('RecentChangesXMLTip').
			'" alt="XML" class="btn-feed"/></a></span>'."<br /><br />\n";
	}

	$this->print_pagination($pagination);

	echo '<ul class="ul_list">'."\n";

	$curday = '';
	foreach ($pages as $i => $page)
	{
		if (!$this->config['hide_locked'] || $this->has_access('read', $page['page_id']))
		{
			$time_tz = $this->get_time_tz(strtotime($page['modified']));
			$day = date($this->config['date_format'], $time_tz);
			$time = date($this->config['time_format_seconds'], $time_tz);

			if ($day != $curday)
			{
				if ($curday)
				{
					echo "</ul>\n<br /></li>\n";
				}

				echo "<li><strong>" . $day . "</strong>\n<ul>\n";
				$curday = $day;
			}

			$review = $viewed = '';

			// review
			if ($this->config['review'] && $this->is_reviewer() && !$page['reviewed'])
			{
				$review = '<span class="review">['.$this->compose_link_to_page($page['tag'], 'revisions', $this->get_translation('Review'), 0).']</span>';
			}

			// do unicode entities
			$page_lang = ($this->page['page_lang'] != $page['page_lang'])?  $page['page_lang'] : '';

			if (($edit_note = $page['edit_note']))
			{
				if ($page_lang)
				{
					$edit_note = $this->do_unicode_entities($edit_note, $page_lang);
				}

				$edit_note = '<span class="editnote">[' . $edit_note . ']</span>';
			}

			if (isset($user['last_mark']) && $user['last_mark'] &&
					$page['user_name'] != $user['user_name'] && $page['modified'] > $user['last_mark'])
			{
				$viewed = ' viewed';
			}

			// cache page_id for for has_access validation in link function
			$this->page_id_cache[$page['tag']] = $page['page_id'];

			// print entry
			echo '<li class="lined'.$viewed.'"><span class="dt">'.
			(!$this->hide_revisions || $this->is_admin()
				? $this->compose_link_to_page($page['tag'], 'revisions', $time, 0, $this->get_translation('RevisionTip'))." "
				: $time
			).
			"</span> &mdash; ".
			($title == 1
				? $this->link('/'.$page['tag'], '', $page['title'], '', 0, 1, $page_lang, 0)
				: $this->link('/'.$page['tag'], '', $page['tag'], $page['title'], 0, 1, $page_lang, 0)
			).
			" . . . . . . . . . . . . . . . . <small>".
			$this->user_link($page['user_name'], '', true, false).' '.
			$review.' '.
			$edit_note.
			"</small></li>\n";
		}
	}

	echo "</ul>\n</li>\n</ul>\n";

	$this->print_pagination($pagination);
}
else
{
	echo $this->get_translation('NoPagesFound');
}
