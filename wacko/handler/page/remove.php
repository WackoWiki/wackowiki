<?php

if (!defined('IN_WACKO'))
{
	exit;
}

$comment_on_id	= 0;
$message		= null;

// obviously do not allow to remove non-existent pages
if (!$this->page)
{
	$this->http->redirect($this->href());
}

$title		= $this->page['comment_on_id'] ? 'RemoveComment' : 'RemovePage';
$tpl->page	= $this->_t($title) . ' ' . $this->compose_link_to_page($this->tag, '', '');

// check user permissions to delete
if ($this->is_admin()
	|| (!$this->db->remove_onlyadmins
		&& (($this->get_page_owner_id($this->page['page_id']) == $this->get_user_id())
		|| ($this->db->owners_can_remove_comments
			&& $this->page['comment_on_id']
			&& $this->get_page_owner_id($this->page['comment_on_id']) == $this->get_user_id())
		)
	)
)
{
	if ($this->page['comment_on_id'])
	{
		$comment_on_id	= $this->page['comment_on_id'];
		$comment_on		= $this->load_page('', $this->page['comment_on_id'], '', '', LOAD_META);
	}

	if (@$_POST['_action'] === 'remove_page')
	{
		$dontkeep = (isset($_POST['dontkeep']) && $this->is_admin());

		$tpl->r_tag = $this->tag;

		// remove SINGLE page or comment
		if ($this->remove_referrers($this->tag))
		{
			$message[] = $this->_t('ReferrersRemoved');
		}

		if ($this->remove_links($this->tag))
		{
			$message[] = $this->_t('LinksRemoved');
		}

		if ($this->remove_page_categories($this->tag))
		{
			$message[] = $this->_t('CategoriesRemoved');
		}

		if ($this->remove_acls($this->tag))
		{
			$message[] = $this->_t('AclsRemoved');
		}

		if (!$comment_on_id)
		{
			if ($this->remove_menu_items($this->tag))
			{
				$message[] = $this->_t('BookmarksRemoved');
			}

			if ($this->remove_watches($this->tag))
			{
				$message[] = $this->_t('WatchesRemoved');
			}

			if ($this->remove_ratings($this->tag))
			{
				$message[] = $this->_t('RatingRemoved');
			}

			if ($this->remove_comments($this->tag, false, $dontkeep))
			{
				$message[] = $this->_t('CommentsRemoved');
			}

			if ($this->remove_files_perpage($this->tag, false, $dontkeep))
			{
				$message[] = $this->_t('FilesRemoved');
			}

			// done with remove_page()
			#if ($this->remove_revisions($this->tag))
			#{
			#	$message[] = $this->_t('RevisionsRemoved');
			#}
		}

		// purge related page cache
		if ($this->http->invalidate_page($comment_on_id ? $comment_on['tag'] : $this->tag))
		{
			$message[] = $this->_t('PageCachePurged');
		}

		if ($this->remove_page($this->page['page_id'], $comment_on_id, $dontkeep))
		{
			if ($this->db->enable_feeds)
			{
				$xml = new Feed($this);
				$xml->comments();

				if (!$comment_on_id)
				{
					$xml->changes();
				}

				if (preg_match('/' . $this->db->news_cluster . '\/.+?\/.+/u', $this->tag))
				{
					$xml->feed();
				}
			}

			$message[] = $this->_t('PageRemoved');
		}

		// remove ENTIRE cluster
		if ($this->is_admin() && isset($_POST['cluster']))
		{
			$this->remove_referrers				($this->tag, true);
			$this->remove_links					($this->tag, true);
			$this->remove_category_assigments	($this->tag, true);
			$this->remove_acls					($this->tag, true);
			$this->remove_menu_items			($this->tag, true);
			$this->remove_watches				($this->tag, true);
			$this->remove_ratings				($this->tag, true);
			$this->remove_comments				($this->tag, true, $dontkeep);
			$this->remove_files_perpage			($this->tag, true);
			// done with remove_page()
			# $this->remove_revisions				($this->tag, true);

			// get list of pages in the cluster
			if ($list = $this->db->load_all(
			"SELECT page_id " .
			"FROM " . $this->db->table_prefix . "page " .
			"WHERE tag LIKE " . $this->db->q($this->tag . '/%') . " "))
			{
				// remove by one page at a time
				foreach ($list as $row)
				{
					$this->remove_page($row['page_id'], '', $dontkeep);
				}

				unset($list, $row);
			}

			$message[] = $this->_t('ClusterRemoved');
		}

		// update user statistics
		if ($owner_id = $this->page['owner_id'])
		{
			$this->db->sql_query(
				"UPDATE " . $this->db->user_table . " " .
				($comment_on_id
					? "SET total_comments	= total_comments	- 1 "
					: "SET total_pages		= total_pages		- 1 "
				) .
				"WHERE user_id = " . (int) $owner_id . " " .
				"LIMIT 1");
		}

		// purge SQL queries cache
		$this->db->invalidate_sql_cache();

		// update user menu
		$this->set_menu(MENU_USER, true);

		// update sitemap
		$this->update_sitemap();

		// log event
		if (!$comment_on_id)
		{
			$mode = (isset($_POST['cluster'])? 'LogRemovedCluster' : 'LogRemovedPage');
			$this->log(1, Ut::perc_replace($this->_t($mode, SYSTEM_LANG), $this->tag, $this->page['user_name']));
		}
		else
		{
			$this->log(1, Ut::perc_replace($this->_t('LogRemovedComment', SYSTEM_LANG),
				($comment_on['tag'] . ' ' . $comment_on['title']),
				$this->page['user_name'],
				$this->get_time_formatted($this->page['created'])));
		}

		foreach ($message as $notice)
		{
			$tpl->r_l_notice = $notice;
		}

		// return to commented page
		if ($comment_on_id)
		{
			$tpl->r_return = $this->compose_link_to_page($comment_on['tag'], '', '« ' . $this->_t('ReturnToCommented'), '', false, ['#' => 'header-comments']);
		}
	}
	else
	{
		$tpl->enter('f_');

		// show warning
		if ($comment_on_id)
		{
			$message = $this->msg_is_comment_on(
				$comment_on['tag'],
				$comment_on['title'],
				$this->page['user_name'],
				$this->page['modified']);

			$tpl->preview_meta	= $this->show_message($message, 'comment-info', false);
			$tpl->preview_text	= $this->format(mb_substr($this->page['body'], 0, 500), 'cleanwacko');
			$tpl->preview_title	= $this->page['title'];

			$message = $this->_t('ReallyDeleteComment');
		}
		else
		{
			$message = $this->_t('ReallyDelete');
		}

		$tpl->warning	= $this->show_message($message, 'warning', false);
		$tpl->backlinks	= $this->action('backlinks', ['nomark' => 0]);

		// any sub-pages
		if (!$this->page['comment_on_id'])
		{
			$tpl->tree_subpages	= $this->action('tree', ['depth' => 3]);
		}

		// admin privileged removal options
		if ($this->is_admin())
		{
			if (!$comment_on_id)
			{
				// remove cluster
				$tpl->admin_p = true;

				if ($this->db->store_deleted_pages)
				{
					$tpl->admin_p_dontkeep = true;
				}
			}
			else
			{
				if ($this->db->store_deleted_pages)
				{
					$tpl->admin_c_dontkeep = true;
				}
			}
		}

		$tpl->leave();	// f_
	}
}
else
{
	$tpl->denied = true;
}
