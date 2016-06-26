<?php

if (!defined('IN_WACKO'))
{
	exit;
}

$comment_on_id	= '';
$dontkeep		= '';
$message		= '';

// obviously do not allow to remove non-existent pages
if (!$this->page)
{
	$this->redirect($this->href());
}

?>
<div id="page">
<h3>
<?php

if ($this->page['comment_on_id'])
{
	echo $this->get_translation('RemoveComment').' '.$this->compose_link_to_page($this->tag, '', '', 0);
}
else
{
	echo $this->get_translation('RemovePage').' '.$this->compose_link_to_page($this->tag, '', '', 0);
}
?>
</h3>
<br />
<?php

// check user permissions to delete
if ($this->is_admin()
	|| (!$this->config['remove_onlyadmins']
		&& (($this->get_page_owner_id($this->page['page_id']) == $this->get_user_id())
		|| ($this->config['owners_can_remove_comments']
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

	if (isset($_POST['delete']) && $_POST['delete'] == 1)
	{
		// check form token
		if (!$this->validate_form_token('remove_page'))
		{
			$this->set_message($this->get_translation('FormInvalid'), 'error');

			$this->redirect($this->href());
		}

		if (isset($_POST['dontkeep']) && $this->is_admin())
		{
			$dontkeep = 1;
		}

		$message .= '<strong><code>'.$this->tag."</code></strong>\n";
		$message .= "<ol>\n";

		// remove SINGLE page or comment
		if ($this->remove_referrers($this->tag))
		{
			$message .= '<li>'.$this->get_translation('ReferrersRemoved')."</li>\n";
		}

		if ($this->remove_links($this->tag))
		{
			$message .= '<li>'.$this->get_translation('LinksRemoved')."</li>\n";
		}

		if ($this->remove_categories($this->tag))
		{
			$message .= '<li>'.$this->get_translation('CategoriesRemoved')."</li>\n";
		}

		if ($this->remove_acls($this->tag))
		{
			$message .= '<li>'.$this->get_translation('AclsRemoved')."</li>\n";
		}

		if (!$comment_on_id)
		{
			if ($this->remove_menu_items($this->tag))
			{
				$message .= '<li>'.$this->get_translation('BookmarksRemoved')."</li>\n";
			}

			if ($this->remove_watches($this->tag))
			{
				$message .= '<li>'.$this->get_translation('WatchesRemoved')."</li>\n";
			}

			if ($this->remove_ratings($this->tag))
			{
				$message .= '<li>'.$this->get_translation('RatingRemoved')."</li>\n";
			}

			if ($this->remove_comments($this->tag, false, $dontkeep))
			{
				$message .= '<li>'.$this->get_translation('CommentsRemoved')."</li>\n";
			}

			if ($this->remove_files($this->tag))
			{
				$message .= '<li>'.$this->get_translation('FilesRemoved')."</li>\n";
			}

			if ($this->remove_revisions($this->tag))
			{
				$message .= '<li>'.$this->get_translation('RevisionsRemoved')."</li>\n";
			}
		}

		// purge related page cache
		if ($this->config['cache'])
		{
			if ($comment_on_id)
			{
				$this->cache->invalidate_page_cache($this->get_page_tag($comment_on_id));
			}
			else
			{
				$this->cache->invalidate_page_cache($this->supertag);
			}

			$message .= '<li>'.$this->get_translation('PageCachePurged')."</li>\n";
		}


		if ($this->remove_page($this->page['page_id'], $comment_on_id, $dontkeep))
		{
			if ($this->config['enable_feeds'])
			{
				$this->use_class('feed');
				$xml = new feed($this);
				$xml->comments();

				if (!$comment_on_id)
				{
					$xml->changes();
				}

				if (preg_match('/'.$this->config['news_cluster'].'\/.+?\/.+/', $this->tag))
				{
					$xml->feed();
				}
			}

			$message .= '<li>'.$this->get_translation('PageRemoved')."</li>\n";
		}

		// remove ENTIRE cluster
		if ($this->is_admin()
			&& (isset($_POST['cluster']) && $_POST['cluster'] == 1))
		{
			$this->remove_referrers		($this->tag, true);
			$this->remove_links			($this->tag, true);
			$this->remove_categories	($this->tag, true);
			$this->remove_acls			($this->tag, true);
			$this->remove_menu_items	($this->tag, true);
			$this->remove_watches		($this->tag, true);
			$this->remove_ratings		($this->tag, true);
			$this->remove_comments		($this->tag, true, $dontkeep);
			$this->remove_files			($this->tag, true);
			$this->remove_revisions		($this->tag, true);

			// get list of pages in the cluster
			if ($list = $this->load_all(
			"SELECT page_id ".
			"FROM {$this->config['table_prefix']}page ".
			"WHERE tag LIKE '".quote($this->dblink, $this->tag.'/%')."'"))
			{
				// remove by one page at a time
				foreach ($list as $row)
				{
					$this->remove_page($row['page_id'], '', $dontkeep);
				}

				unset($list, $row);
			}

			$message .= "<li>".$this->get_translation('ClusterRemoved')."</li>\n";
		}

		$message .= "</ol>\n";

		// update user statistics
		if ($owner_id = $this->page['owner_id'])
		{
			$this->sql_query(
				"UPDATE {$this->config['user_table']} ".
				($comment_on_id
					? "SET total_comments	= total_comments	- 1 "
					: "SET total_pages		= total_pages		- 1 "
				).
				"WHERE user_id = '".(int)$owner_id."' ".
				"LIMIT 1");
		}

		// purge SQL queries cache
		if ($this->config['cache_sql'])
		{
			$this->cache->invalidate_sql_cache();
		}

		// update user menu
		$this->set_menu(MENU_USER, 1);

		// update sitemap
		$this->update_sitemap();

		// log event
		if (!$comment_on_id)
		{
			$this->log(1, str_replace('%2', $this->page['user_name'], str_replace('%1', $this->tag, ( isset($_POST['cluster']) && $_POST['cluster'] == 1 ? $this->get_translation('LogRemovedCluster', $this->config['language']) : $this->get_translation('LogRemovedPage', $this->config['language']) ))));
		}
		else
		{
			$this->log(1, str_replace('%3', $this->get_time_formatted($this->page['created']), str_replace('%2', $this->page['user_name'], str_replace('%1', $this->get_page_tag($comment_on_id)." ".$this->get_page_title('', $comment_on_id), $this->get_translation('LogRemovedComment', $this->config['language'])))));
		}

		$message .= "<br />".$this->get_translation('ThisActionHavenotUndo')."<br />\n";

		$this->show_message($message, 'success');

		// return to commented page
		if ($comment_on_id)
		{
			echo '<br />'.$this->compose_link_to_page($this->get_page_tag($comment_on_id).'#header-comments', '', '&laquo; '.$this->get_translation('ReturnToCommented'), 0);
		}
	}
	else
	{
		// show warning
		if ($comment_on_id)
		{
			// TODO: add function for
			echo '<div class="preview">';

			$message = $this->get_translation('ThisIsCommentOn').' '.$this->compose_link_to_page($this->get_page_tag($this->page['comment_on_id']), '', $this->get_page_title('', $this->page['comment_on_id']), 0, $this->get_page_tag($this->page['comment_on_id'])).', '.$this->get_translation('PostedBy').' '.$this->user_link($this->page['user_name'], '', true, false).' '.$this->get_translation('At').' '.$this->get_time_formatted($this->page['modified']);
			$this->show_message($message, 'comment-info');

			$desc = $this->format(substr($this->page['body'], 0, 500), 'cleanwacko');
			$desc = (strlen($desc) > 240 ? substr($desc, 0, 240).'[..]' : $desc.' [..]');

			echo '<div class="comment-title"><h2>'.$this->page['title'].'</h2></div>';
			echo htmlspecialchars($desc, ENT_COMPAT | ENT_HTML401, HTML_ENTITIES_CHARSET);
			echo '</div><br />';

			$message = $this->get_translation('ReallyDeleteComment');
		}
		else
		{
			$message = $this->get_translation('ReallyDelete');
		}

		// show backlinks
		echo $this->action('backlinks', array('nomark' => 0));
		echo '<br />';

		$this->show_message($message, 'warning');

		echo $this->form_open('remove_page', 'remove', '', true);

		// admin privileged removal options
		if ($this->is_admin())
		{
			if (!$comment_on_id)
			{
				echo '<input type="checkbox" id="removecluster" name="cluster" value="1" />';
				echo '<label for="removecluster">'.$this->get_translation('RemoveCluster').'</label><br />';

				if ($this->config['store_deleted_pages'])
				{
					echo '<input type="checkbox" id="dontkeep" name="dontkeep" value="1" />';
					echo '<label for="dontkeep">'.$this->get_translation('RemoveDontKeep').'</label><br />';
				}
			}
			else
			{
				if ($this->config['store_deleted_pages'])
				{
					echo '<input type="checkbox" id="dontkeep" name="dontkeep" value="1" />';
					echo '<label for="dontkeep">'.$this->get_translation('RemoveDontKeepComment').'</label><br />';
				}
			}
		}
?>
		<br />
		<input type="hidden" name="delete" value="1" />
		<input type="submit" class="OkBtn" id="submit" name="submit" value="<?php echo $this->get_translation('RemoveButton'); ?>" />&nbsp;
		<a href="<?php echo $this->href();?>" style="text-decoration: none;"><input type="button" class="CancelBtn" id="button" value="<?php echo str_replace("\n", " ", $this->get_translation('EditCancelButton')); ?>"/></a>
		<br />
<?php
		echo $this->form_close();
	}
}
else
{
	$message = $this->get_translation('NotOwnerAndCanDelete');
	$this->show_message($message, 'info');
}
?>
</div>
