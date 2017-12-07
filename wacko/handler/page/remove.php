<?php

if (!defined('IN_WACKO'))
{
	exit;
}

$comment_on_id	= '';
$message		= '';

// obviously do not allow to remove non-existent pages
if (!$this->page)
{
	$this->http->redirect($this->href());
}

$title = $this->page['comment_on_id']?  'RemoveComment' : 'RemovePage';
echo '<h3>' . $this->_t($title) . ' ' . $this->compose_link_to_page($this->tag, '', '') . "</h3>\n<br>\n";

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
		$comment_on_id = $this->page['comment_on_id'];
	}

	if (@$_POST['_action'] === 'remove_page')
	{
		$dontkeep = (isset($_POST['dontkeep']) && $this->is_admin());

		$message .= '<strong><code>' . $this->tag . "</code></strong>\n";
		$message .= "<ol>\n";

		// remove SINGLE page or comment
		if ($this->remove_referrers($this->tag))
		{
			$message .= '<li>' . $this->_t('ReferrersRemoved') . "</li>\n";
		}

		if ($this->remove_links($this->tag))
		{
			$message .= '<li>' . $this->_t('LinksRemoved') . "</li>\n";
		}

		if ($this->remove_page_categories($this->tag))
		{
			$message .= '<li>' . $this->_t('CategoriesRemoved') . "</li>\n";
		}

		if ($this->remove_acls($this->tag))
		{
			$message .= '<li>' . $this->_t('AclsRemoved') . "</li>\n";
		}

		if (!$comment_on_id)
		{
			if ($this->remove_menu_items($this->tag))
			{
				$message .= '<li>' . $this->_t('BookmarksRemoved') . "</li>\n";
			}

			if ($this->remove_watches($this->tag))
			{
				$message .= '<li>' . $this->_t('WatchesRemoved') . "</li>\n";
			}

			if ($this->remove_ratings($this->tag))
			{
				$message .= '<li>' . $this->_t('RatingRemoved') . "</li>\n";
			}

			if ($this->remove_comments($this->tag, false, $dontkeep))
			{
				$message .= '<li>' . $this->_t('CommentsRemoved') . "</li>\n";
			}

			if ($this->remove_files_perpage($this->tag, false, $dontkeep))
			{
				$message .= '<li>' . $this->_t('FilesRemoved') . "</li>\n";
			}

			// done with remove_page()
			#if ($this->remove_revisions($this->tag))
			#{
			#	$message .= '<li>' . $this->_t('RevisionsRemoved') . "</li>\n";
			#}
		}

		// purge related page cache
		if ($this->http->invalidate_page($comment_on_id ? $this->get_page_tag($comment_on_id) : $this->supertag))
		{
			$message .= '<li>' . $this->_t('PageCachePurged') . "</li>\n";
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

				if (preg_match('/' . $this->db->news_cluster . '\/.+?\/.+/', $this->tag))
				{
					$xml->feed();
				}
			}

			$message .= '<li>' . $this->_t('PageRemoved') . "</li>\n";
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
			#$this->remove_revisions				($this->tag, true);

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

			$message .= "<li>" . $this->_t('ClusterRemoved') . "</li>\n";
		}

		$message .= "</ol>\n";

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
				($this->get_page_tag($comment_on_id) . " " . $this->get_page_title('', $comment_on_id)),
				$this->page['user_name'],
				$this->get_time_formatted($this->page['created'])));
		}

		$message .= "<br>" . $this->_t('ThisActionHavenotUndo') . "<br>\n";

		$this->show_message($message, 'success');

		// return to commented page
		if ($comment_on_id)
		{
			echo '<br>' . $this->compose_link_to_page($this->get_page_tag($comment_on_id) . '#header-comments', '', '&laquo; ' . $this->_t('ReturnToCommented'));
		}
	}
	else
	{
		// show warning
		if ($comment_on_id)
		{
			// TODO: add function for
			echo '<div class="preview">';

			$message = $this->_t('ThisIsCommentOn') . ' ' .
				$this->compose_link_to_page($this->get_page_tag($this->page['comment_on_id']), '', $this->get_page_title('', $this->page['comment_on_id']), $this->get_page_tag($this->page['comment_on_id'])) . ', ' .
				$this->_t('PostedBy') . ' ' .
				$this->user_link($this->page['user_name'], '', true, false) . ' ' .
				$this->_t('At') . ' ' . $this->get_time_formatted($this->page['modified']);
			$this->show_message($message, 'comment-info');

			$desc = $this->format(substr($this->page['body'], 0, 500), 'cleanwacko');
			$desc = (strlen($desc) > 240 ? substr($desc, 0, 240) . '[..]' : $desc . ' [..]');

			echo '<div class="comment-title"><h2>' . $this->page['title'] . '</h2></div>';
			echo htmlspecialchars($desc, ENT_COMPAT | ENT_HTML5, HTML_ENTITIES_CHARSET);
			echo '</div><br>';

			$message = $this->_t('ReallyDeleteComment');
		}
		else
		{
			$message = $this->_t('ReallyDelete');
		}

		// show backlinks
		echo $this->action('backlinks', ['nomark' => 0]);
		echo '<br>';

		$this->show_message($message, 'warning');

		echo $this->form_open('remove_page', ['page_method' => 'remove']);

		// admin privileged removal options
		if ($this->is_admin())
		{
			if (!$comment_on_id)
			{
				echo '<input type="checkbox" id="removecluster" name="cluster">';
				echo '<label for="removecluster">' . $this->_t('RemoveCluster') . '</label><br>';

				if ($this->db->store_deleted_pages)
				{
					echo '<input type="checkbox" id="dontkeep" name="dontkeep">';
					echo '<label for="dontkeep">' . $this->_t('RemoveDontKeep') . '</label><br>';
				}
			}
			else
			{
				if ($this->db->store_deleted_pages)
				{
					echo '<input type="checkbox" id="dontkeep" name="dontkeep">';
					echo '<label for="dontkeep">' . $this->_t('RemoveDontKeepComment') . '</label><br>';
				}
			}
		}
?>
		<br>
		<input type="submit" class="OkBtn" id="submit" name="submit" value="<?php echo $this->_t('RemoveButton'); ?>">&nbsp;
		<a href="<?php echo $this->href();?>" class="btn_link"><input type="button" class="CancelBtn" id="button" value="<?php echo str_replace("\n", " ", $this->_t('EditCancelButton')); ?>"></a>
		<br>
<?php
		echo $this->form_close();
	}
}
else
{
	$this->show_message($this->_t('NotOwnerAndCanDelete'), 'error');
}
