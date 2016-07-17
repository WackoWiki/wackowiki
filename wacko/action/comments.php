<?php

if (!defined('IN_WACKO'))
{
	exit;
}

if (!function_exists('load_recent_comments'))
{
	function load_recent_comments(&$wacko, $for = '', $limit = 50, $deleted = 0)
	{
		$limit		= (int) $limit;
		$pagination	= '';

		// count pages
		if ($count_pages = $wacko->load_all(
			"SELECT a.page_id ".
			"FROM ".$wacko->config['table_prefix']."page a ".
				"INNER JOIN ".$wacko->config['table_prefix']."page b ON (a.comment_on_id = b.page_id) ".
			"WHERE ".
			($for
				? "b.supertag LIKE '".quote($wacko->dblink, $wacko->translit($for))."/%' "
				: "a.comment_on_id <> '0' ").
			($deleted != 1
				? "AND a.deleted <> '1' "
				: "")
			, true));

		if ($count_pages)
		{
			$count		= count($count_pages);
			$pagination = $wacko->pagination($count, $limit);

			$comments = $wacko->load_all(
				"SELECT b.tag as comment_on_tag, b.title as page_title, b.page_lang, a.tag AS comment_tag, a.title AS comment_title, b.supertag, u.user_name AS comment_user, a.modified AS comment_time, a.comment_on_id ".
				"FROM ".$wacko->config['table_prefix']."page a ".
					"INNER JOIN ".$wacko->config['table_prefix']."page b ON (a.comment_on_id = b.page_id) ".
					"LEFT JOIN ".$wacko->config['table_prefix']."user u ON (a.user_id = u.user_id) ".
				"WHERE ".
				($for
					? "b.supertag LIKE '".quote($wacko->dblink, $wacko->translit($for))."/%' "
					: "a.comment_on_id <> '0' ").
				($deleted != 1
					? "AND a.deleted <> '1' "
					: "").
				"ORDER BY a.modified DESC ".
				"LIMIT {$pagination['offset']}, {$limit}");

			return array($comments, $pagination);
		}

	}
}

if (!isset($root) && isset($for)) $root = $this->unwrap_link($for);
if (!isset($root))		$root = '';
if (!isset($title))		$title	= 0;
if (!isset($noxml)) 	$noxml	= 0;
if (!isset($max))		$max = null;

$user	= $this->get_user();
$max	= $this->get_list_count($max);

if ($this->user_allowed_comments())
{
	if (list ($comments, $pagination) = load_recent_comments($this, $root, (int)$max))
	{
		// process 'mark read' - reset session time
		if (isset($_GET['markread']) && $user == true)
		{
			$this->update_last_mark($user);
			$this->set_user_setting('last_mark', date('Y-m-d H:i:s', time()));
			$user = $this->get_user();
		}

		if ($user == true)
		{
			echo '<small><a href="'.$this->href('', '', 'markread=yes').'">'.$this->get_translation('MarkRead').'</a></small>';
		}

		if ($root == '' && !(int)$noxml)
		{
			echo '<span class="desc_rss_feed"><a href="'.$this->config['base_url'].'xml/comments_'.preg_replace('/[^a-zA-Z0-9]/', '', strtolower($this->config['site_name'])).'.xml"><img src="'.$this->config['theme_url'].'icon/spacer.png'.'" title="'.$this->get_translation('RecentCommentsXMLTip').'" alt="XML" class="btn-feed"/></a></span>'."<br /><br />\n";
		}

		$this->print_pagination($pagination);

		echo '<ul class="ul_list">'."\n";

		$curday = '';

		foreach ($comments as $page)
		{
			if ($this->config['hide_locked'])
			{
				$access = $this->has_access('read', $page['comment_on_id']);
			}
			else
			{
				$access = true;
			}

			if ($access && $this->user_allowed_comments())
			{
				$this->sql2datetime($page['comment_time'], $day, $time);

				if ($day != $curday)
				{
					if ($curday)
					{
						echo "</ul>\n<br /></li>\n";
					}

					echo "<li><strong>$day:</strong><ul>\n";
					$curday = $day;
				}

				$viewed = ( $user['last_mark'] == true && $page['comment_user'] != $user['user_name'] && $page['comment_time'] > $user['last_mark'] ? ' class="viewed"' : '' );

				// do unicode entities
				// page lang
				if ($this->page['page_lang'] != $page['page_lang'])
				{
					$page_lang = $page['page_lang'];
				}
				else
				{
					$page_lang = '';
				}


				// print entry
				echo '<li '.$viewed.'><span class="dt">'.$time."</span> &mdash; ".
				($title == 1
					? $this->link('/'.$page['comment_tag'], '', $page['comment_title'], $page['page_title'], 0, 1, $page_lang, 0)
					: $this->link('/'.$page['comment_tag'], '', $page['comment_on_tag'], $page['page_title'], 0, 1, $page_lang, 0)
				).
				" . . . . . . . . . . . . . . . . <small>"./*$this->get_translation('LatestCommentBy').*/" ".
				$this->user_link($page['comment_user'], '', true, false).
				"</small></li>\n";
			}
		}

		echo "</ul>\n</li>\n</ul>\n";

		$this->print_pagination($pagination);
	}
	else
	{
		echo $this->get_translation('NoRecentComments');
	}
}
else
{
	echo $this->get_translation('CommentsDisabled');
}

?>
