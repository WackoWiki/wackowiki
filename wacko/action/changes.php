<?php

if (!defined('IN_WACKO'))
{
	exit;
}

$viewed = '';

if (!isset($for))		$for	= ''; // depreciated
if ($for)				$page = $for;

if (!isset($page))		$page = '';
if (!isset($root) && isset($page))	$root = $this->unwrap_link($page);
if (!isset($root))		$root = '';
if (!isset($date))		$date = @$_GET['date'];
if (!isset($hide_minor_edit)) $hide_minor_edit = @$_GET['minor_edit'];
if (!isset($noxml))		$noxml = 0;
if (!isset($title))		$title = '';
if (!isset($max))		$max = null;

$user	= $this->get_user();

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
		echo '<small><a href="'.$this->href('', '', 'markread=yes').'">'.$this->_t('MarkRead').'</a></small>';
	}

	if (!$root && !(int)$noxml)
	{
		echo '<span class="desc_rss_feed"><a href="'.$this->db->base_url.'xml/changes_'.
			preg_replace('/[^a-zA-Z0-9]/', '', strtolower($this->db->site_name)).'.xml"><img src="'.
			$this->db->theme_url.'icon/spacer.png'.'" title="'.$this->_t('RecentChangesXMLTip').
			'" alt="XML" class="btn-feed"/></a></span>'."<br /><br />\n";
	}

	$this->print_pagination($pagination);

	echo '<ul class="ul_list">'."\n";

	$curday = '';
	foreach ($pages as $i => $page)
	{
		if (!$this->db->hide_locked || $this->has_access('read', $page['page_id']))
		{
			$this->sql2datetime($page['modified'], $day, $time);

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
			if ($this->db->review && $this->is_reviewer() && !$page['reviewed'])
			{
				$review = '<span class="review">['.$this->compose_link_to_page($page['tag'], 'revisions', $this->_t('Review'), 0).']</span>';
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
			(!$this->hide_revisions
				? $this->compose_link_to_page($page['tag'], 'revisions', $time, 0, $this->_t('RevisionTip'))." "
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
	echo $this->_t('NoPagesFound');
}
