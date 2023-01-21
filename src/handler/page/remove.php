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

$revision_id	= (int) ($_GET['revision_id'] ?? ($_POST['revision_id'] ?? null));
$title			= $this->page['comment_on_id']
					? 'RemoveComment'
					: ($revision_id
						? 'RemoveRevision'
						: 'RemovePage');
$tpl->page		= $this->_t($title) . ' ' . $this->compose_link_to_page($this->tag, '', '');

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
	$action			= (string) ($_POST['_action'] ?? null);
	$dontkeep		= (isset($_POST['dontkeep']) && $this->is_admin());
	$cluster		= (bool) ($_POST['cluster'] ?? false);

	if ($revision_id)
	{
		$revision		= $this->load_page('', $this->page['page_id'], $revision_id);
	}

	if ($this->page['comment_on_id'])
	{
		$comment_on_id	= $this->page['comment_on_id'];
		$comment_on		= $this->load_page('', $this->page['comment_on_id'], null, null, LOAD_META);
	}

	if ($action === 'remove_revision')
	{
		// remove SINGLE revision
		if ($this->remove_revision($this->page['page_id'], $revision_id, $dontkeep))
		{
			$tpl->r_noundo		= $dontkeep;
			$tpl->r_tag			= $this->tag;
			$tpl->r_l_notice	= Ut::perc_replace($this->_t('RevisionRemoved'), '<code>' . $revision['version_id'] . '</code>');
			$tpl->r_return		= $this->compose_link_to_page('', 'revisions', '« ' . $this->_t('CancelReturnButton'), '', false);

			// log event
			$this->log(1, Ut::perc_replace(
				$this->_t('LogRemovedRevision', SYSTEM_LANG),
				$this->tag,
				$revision['user_name'],
				$revision['version_id']));
		}
	}
	else if ($action === 'remove_page')
	{
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
			$message[] = $this->_t('PageRemoved');

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

				$this->set_language($this->user_lang, true);
			}
		}

		// remove ENTIRE cluster
		if ($this->is_admin() && $cluster)
		{
			$this->remove_referrers				($this->tag, true);
			$this->remove_links					($this->tag, true);
			$this->remove_category_assignments	($this->tag, true);
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
			"FROM " . $this->prefix . "page " .
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
				"UPDATE " . $this->prefix . "user " .
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
			$mode = ($cluster? 'LogRemovedCluster' : 'LogRemovedPage');
			$this->log(1, Ut::perc_replace(
				$this->_t($mode, SYSTEM_LANG),
				$this->tag,
				$this->page['user_name']));
		}
		else
		{
			$this->log(1, Ut::perc_replace(
				$this->_t('LogRemovedComment', SYSTEM_LANG),
				($comment_on['tag'] . ' ' . $comment_on['title']),
				$this->page['user_name'],
				$this->sql_time_formatted($this->page['created'])));
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

		if ($revision_id)
		{
			$tpl->enter('revision_');

			$message = Ut::perc_replace($this->_t('RevisionHint'),
				$this->href(),
				$this->tag,
				$this->sql_time_formatted($revision['modified']),
				$this->user_link($revision['user_name'], true, false));

			$tpl->meta			= $this->show_message($message, 'revision-info', false);
			$tpl->warning		= $this->show_message($this->_t('ReallyDeleteRevision'), 'warning', false);
			$tpl->revisionid	= $revision_id;

			if ($this->is_admin())
			{
				if ($this->db->store_deleted_pages)
				{
					$tpl->dontkeep = true;
				}
			}

			$tpl->leave();	// revision_
		}
		else
		{
			$tpl->enter('page_');

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
				$message = $this->_t('ReallyDeletePage');
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
				$tpl->enter('admin_');

				if (!$comment_on_id)
				{
					// remove cluster
					$tpl->p = true;

					if ($this->db->store_deleted_pages)
					{
						$tpl->p_dontkeep = true;
					}
				}
				else
				{
					if ($this->db->store_deleted_pages)
					{
						$tpl->c_dontkeep = true;
					}
				}

				$tpl->leave();	// admin_
			}

			$tpl->leave();	// page_
		}

		$tpl->leave();	// f_
	}
}
else
{
	$tpl->denied = true;
}
