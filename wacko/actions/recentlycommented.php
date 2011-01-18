<?php

if (!function_exists('load_recently_commented'))
{
	function load_recently_commented(&$wacko, $for = '', $limit = 50)
	{
		$_ids		= '';
		$limit		= (int) $limit;
		$comments	= '';
		$pagination	= '';

		// NOTE: this is really stupid. Maybe my SQL-Fu is too weak, but apparently there is no easier way
		if ($ids = $wacko->load_all(
			"SELECT a.page_id ".
			"FROM ".$wacko->config['table_prefix']."page a ".
			($for
				? 	"INNER JOIN ".$wacko->config['table_prefix']."page b ON (a.comment_on_id = b.page_id) ".
					"WHERE ".
						"b.supertag LIKE '".quote($wacko->dblink, $wacko->npj_translit($for))."/%' "
				: 	"WHERE a.comment_on_id <> '0' ").
			($for
				? 	"GROUP BY a.comment_on_id ORDER BY a.created DESC"
				:	"GROUP BY a.comment_on_id ORDER BY a.created DESC")
			, 1));
		{
				if ($ids)
				{
					$count		= count($ids);
					$pagination = $wacko->pagination($count, $limit);

					foreach ($ids as $key => $id)
					{
						if ($key > 0)
						{
							$_ids .= ", ";
						}

						$_ids .= "'".$id['page_id']."'";
					}

					// load complete comments
					$comments = $wacko->load_all(
						"SELECT b.tag as comment_on_tag, b.title as page_title, a.comment_on_id, b.supertag, a.tag AS comment_tag, a.user_id, u.user_name AS comment_user, a.modified AS comment_time ".
						"FROM ".$wacko->config['table_prefix']."page a ".
							"INNER JOIN ".$wacko->config['table_prefix']."page b ON (a.comment_on_id = b.page_id) ".
							"LEFT OUTER JOIN ".$wacko->config['table_prefix']."user u ON (a.user_id = u.user_id) ".
						"WHERE a.page_id IN ( ".$_ids." ) ".
						"ORDER BY comment_time DESC ".
						"LIMIT {$pagination['offset']}, {$limit}");
				}
		}

		return array($comments, $pagination);
	}
}

if (!isset($root))	$root	= $this->unwrap_link(isset($vars['for']) ? $vars['for'] : '');
if (!isset($root))	$root	= $this->page['tag'];
if (!isset($title)) $title	= 0;
if (!isset($noxml)) $noxml	= 0;

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

if ($max > 100)
{
	$max	= 100;
}

// process 'mark read' - reset session time
if (isset($_GET['markread']) && $user == true)
{
	$this->update_last_mark($user);
	$this->set_user_setting('last_mark', date('Y-m-d H:i:s', time()));
	$user = $this->get_user();
}

if (list ($pages, $pagination) = load_recently_commented($this, $root, (int)$max))
{
	if ($user == true)
	{
		echo '<small><a href="'.$this->href('', '', 'markread=yes').'">'.$this->get_translation('MarkRead').'</a></small>';
	}

	if ($root == '' && !(int)$noxml)
	{
		echo "<span class=\"desc_rss_feed\"><a href=\"".$this->config['base_url']."xml/comments_".preg_replace('/[^a-zA-Z0-9]/', '', strtolower($this->config['wacko_name'])).".xml\"><img src=\"".$this->config['theme_url']."icons/xml.gif"."\" title=\"".$this->get_translation('RecentCommentsXMLTip')."\" alt=\"XML\" /></a></span><br /><br />\n";
	}

	// pagination
	if (isset($pagination['text']))
	{
		echo "<span class=\"pagination\">{$pagination['text']}</span>\n";
	}

	echo "<ul class=\"ul_list\">\n";

	if ($pages)
	{
		foreach ($pages as $page)
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
				// day header
				list($day, $time) = explode(' ', $page['comment_time']);

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

				$viewed = ( $user['last_mark'] == true && $page['comment_user'] != $user['user_name'] && $page['comment_time'] > $user['last_mark'] ? ' class="viewed"' : '' );

				// print entry
				echo "<li ".$viewed."><span class=\"dt\">".date($this->config['time_format_seconds'], strtotime( $time ))."</span> &mdash; (".
				($title == 1
					? $this->link('/'.$page['comment_tag'], '', $page['page_title'], '', 0, 1, '', 0)
					: $this->link('/'.$page['comment_tag'], '', $page['comment_on_tag'], $page['page_title'])
				).
				") . . . . . . . . . . . . . . . . <small>".$this->get_translation('LatestCommentBy')." ".
				($page['comment_user']
					? ($this->is_wiki_name($page['comment_user'])
						? $this->link('/'.$page['comment_user'], '', $page['comment_user'] )
						: $page['comment_user'])
					: $this->get_translation('Guest')).
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
		echo $this->get_translation('NoRecentlyCommented');
	}
}

?>