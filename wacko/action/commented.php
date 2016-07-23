<?php

if (!defined('IN_WACKO'))
{
	exit;
}

if (!function_exists('load_commented'))
{
	function load_commented(&$engine, $for = '', $limit = 50, $deleted = 0)
	{
		$_ids		= '';
		$limit		= (int) $limit;
		$comments	= '';
		$pagination	= '';

		// going around the limitations of GROUP BY when used along with ORDER BY
		// http://dev.mysql.com/doc/refman/5.5/en/example-maximum-column-group-row.html
		if ($ids = $engine->db->load_all(
			"SELECT a.page_id ".
			"FROM ".$engine->config['table_prefix']."page a ".
				"LEFT JOIN ".$engine->config['table_prefix']."page a2 ON (a.comment_on_id = a2.comment_on_id AND a.created < a2.created) ".
			($for
				?	"INNER JOIN ".$engine->config['table_prefix']."page b ON (a.comment_on_id = b.page_id) "
				:	"").
			"WHERE ".
			($for
				?	"a2.page_id IS NULL AND b.supertag LIKE " . $engine->db->q($engine->translit($for) . '/%') . " "
				:	"a2.page_id IS NULL AND a.comment_on_id <> '0' ").
			($deleted != 1
				? "AND a.deleted <> '1' "
				: "").
			"ORDER BY a.created DESC"
			, true));
		{
				if ($ids)
				{
					$count		= count($ids);
					$pagination = $engine->pagination($count, $limit);

					foreach ($ids as $key => $id)
					{
						if ($key > 0)
						{
							$_ids .= ", ";
						}

						$_ids .= "'".$id['page_id']."'";
					}

					// load complete comments
					$comments = $engine->db->load_all(
						"SELECT b.tag as comment_on_tag, b.title as page_title, b.page_lang, a.comment_on_id, b.supertag, a.tag AS comment_tag, a.title AS comment_title, a.page_lang AS comment_lang, a.user_id, u.user_name AS comment_user_name, o.user_name as comment_owner_name, a.created AS comment_time ".
						"FROM ".$engine->config['table_prefix']."page a ".
							"INNER JOIN ".$engine->config['table_prefix']."page b ON (a.comment_on_id = b.page_id) ".
							"LEFT JOIN ".$engine->config['table_prefix']."user u ON (a.user_id = u.user_id) ".
							"LEFT JOIN ".$engine->config['table_prefix']."user o ON (a.owner_id = o.user_id) ".
						"WHERE a.page_id IN ( ".$_ids." ) ".
						"ORDER BY comment_time DESC ".
						"LIMIT {$pagination['offset']}, {$limit}");
				}
		}

		return array($comments, $pagination);
	}
}

if (!isset($root))	$root	= $this->unwrap_link(isset($for) ? $for : '');
if (!isset($title)) $title	= 0;
if (!isset($noxml)) $noxml	= 0;
if (!isset($max))		$max = null;

$user	= $this->get_user();
$max	= $this->get_list_count($max);

if ($this->user_allowed_comments())
{
	// process 'mark read' - reset session time
	if (isset($_GET['markread']) && $user == true)
	{
		$this->update_last_mark($user);
		$this->set_user_setting('last_mark', date('Y-m-d H:i:s', time()));
		$user = $this->get_user();
	}

	if (list ($pages, $pagination) = load_commented($this, $root, (int)$max))
	{
		if ($pages)
		{
			if ($user == true)
			{
				echo '<small><a href="'.$this->href('', '', 'markread=yes').'">'.$this->_t('MarkRead').'</a></small>';
			}

			if ($root == '' && !(int)$noxml)
			{
				echo '<span class="desc_rss_feed"><a href="'.$this->config['base_url'].'xml/comments_'.preg_replace('/[^a-zA-Z0-9]/', '', strtolower($this->config['site_name'])).'.xml"><img src="'.$this->config['theme_url'].'icon/spacer.png" title="'.$this->_t('RecentCommentsXMLTip').'" alt="XML" class="btn-feed"/></a></span><br /><br />'."\n";
			}

			$this->print_pagination($pagination);

			echo '<ul class="ul_list">'."\n";

			$curday = '';
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

				if ($access)
				{
					$this->sql2datetime($page['comment_time'], $day, $time);

					if ($day != $curday)
					{
						if ($curday)
						{
							echo "</ul>\n<br /></li>\n";
						}

						echo '<li><strong>' . $day . ":</strong>\n<ul>\n";
						$curday = $day;
					}

					// do unicode entities
					// page lang
					$page_lang = ($this->page['page_lang'] != $page['page_lang'])?  $page['page_lang'] : '';

					// comment lang
					$comment_lang = ($this->page['page_lang'] != $page['comment_lang'])?  $page['comment_lang'] : '';

					$viewed = ( $user['last_mark'] && $page['comment_user_name'] != $user['user_name'] && $page['comment_time'] > $user['last_mark'] ? ' class="viewed"' : '' );

					// print entry
					echo '<li '.$viewed.'><span class="dt">'.$time.'</span> &mdash; '.
					($title
						? $this->link('/'.$page['comment_tag'], '', $page['page_title'], '', 0, 1, $page_lang, 0)
						: $this->link('/'.$page['comment_tag'], '', $page['comment_title'], $page['comment_on_tag'], 0, 0, $comment_lang)
					).
					' . . . . . . . . . . . . . . . . <small>'.$this->_t('LatestCommentBy').' '.
					$this->user_link($page['comment_owner_name'], '', true, false).
					"</small></li>\n";
				}
			}

			echo "</ul>\n</li>\n</ul>\n";

			$this->print_pagination($pagination);
		}
		else
		{
			echo $this->_t('NoRecentlyCommented');
		}
	}
}
else
{
	echo $this->_t('CommentsDisabled');
}

?>
