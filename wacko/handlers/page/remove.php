<?php

if (!defined('IN_WACKO'))
{
	exit;
}

?>
<div id="page">
<?php

$comment_on_id	= '';
$dontkeep		= '';
$message		= '';

// obviously do not allow to remove non-existent pages
if (!$this->page)
{
	$this->redirect($this->href());
}

// check user permissions to delete
if ($this->is_admin() ||
(!$this->config['remove_onlyadmins'] &&
(($this->get_page_owner_id($this->page['page_id']) == $this->get_user_id()) ||
($this->config['owners_can_remove_comments'] && $this->page['comment_on_id'] && $this->get_page_owner_id($this->page['comment_on_id']) == $this->get_user_id()))))
{
	if ($this->page['comment_on_id'])
	{
		$comment_on_id = $this->page['comment_on_id'];
	}

	if (isset($_POST['delete']) && $_POST['delete'] == 1)
	{
		if (isset($_POST['dontkeep']) && $this->is_admin())
		{
			$dontkeep = 1;
		}

		$message .= '<b>'.$this->tag."</b>\n";
		$message .= '<ol>';

		// Remove page
		if ($this->remove_referrers($this->tag))
		{
			$message .= "<li>".str_replace('%1', $this->tag, $this->get_translation('ReferrersRemoved'))."</li>\n";
		}

		if ($this->remove_links($this->tag))
		{
			$message .= "<li>".str_replace('%1', $this->tag, $this->get_translation('LinksRemoved'))."</li>\n";
		}

		if ($this->remove_categories($this->tag))
		{
			$message .= "<li>".$this->get_translation('CategoriesRemoved')."</li>\n";
		}

		if ($this->remove_acls($this->tag))
		{
			$message .= "<li>".str_replace('%1', $this->tag, $this->get_translation('AclsRemoved'))."</li>\n";
		}

		if (!$comment_on_id)
		{
			if ($this->remove_menu_items($this->tag))
			{
				$message .= "<li>".str_replace('%1', $this->tag, $this->get_translation('BookmarksRemoved'))."</li>\n";
			}

			if ($this->remove_watches($this->tag))
			{
				$message .= "<li>".str_replace('%1', $this->tag, $this->get_translation('WatchesRemoved'))."</li>\n";
			}

			if ($this->remove_ratings($this->tag))
			{
				$message .= "<li>".$this->get_translation('RatingRemoved')."</li>\n";
			}

			if ($this->remove_comments($this->tag, false, $dontkeep))
			{
				$message .= "<li>".str_replace('%1', $this->tag, $this->get_translation('CommentsRemoved'))."</li>\n";
			}

			if ($this->remove_files($this->tag))
			{
				$message .= "<li>".str_replace('%1', $this->tag, $this->get_translation('FilesRemoved'))."</li>\n";
			}
		}

		if ($this->remove_page($this->page['page_id'], $comment_on_id, $dontkeep))
		{
			if ($this->config['enable_feeds'])
			{
				$this->use_class('rss');
				$xml = new rss($this);
				$xml->comments();

				if (!$comment_on_id)
				{
					$xml->changes();
				}

				if (preg_match('/'.$this->config['news_cluster'].'\/.+?\/.+/', $this->tag))
				{
					$xml->news();
				}
			}

			$message .= "<li>".str_replace('%1', $this->tag, $this->get_translation('PageRemoved'))."</li>\n";
		}

		if ($this->is_admin() && (isset($_POST['revisions']) && $_POST['revisions'] == 1) && !$comment_on_id)
		{
			$this->remove_revisions($this->tag);
			$message .= "<li>".str_replace('%1', $this->tag, $this->get_translation('RevisionsRemoved'))."</li>\n";
		}

		if ($this->is_admin() && (isset($_POST['cluster']) && $_POST['cluster'] == 1))
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

			if ((isset($_POST['revisions']) && $_POST['revisions'] == 1) || $comment_on_id)
			{
				$this->remove_revisions($this->tag, true);
			}

			$message .= "<li>".$this->get_translation('ClusterRemoved')."</li>\n";
		}

		$message .= "</ol>\n";

		// update user statistics
		if ($owner_id = $this->page['owner_id'])
		{
			$this->sql_query(
				"UPDATE {$this->config['user_table']} ".
				( $comment_on_id
					? "SET total_comments	= total_comments	- 1 "
					: "SET total_pages		= total_pages		- 1 "
				).
				"WHERE user_id = '".quote($this->dblink, $owner_id)."' ".
				"LIMIT 1");
		}

		// purge SQL queries cache
		if ($this->config['cache_sql'])
		{
			$this->cache->invalidate_sql_cache();
		}

		// log event
		if (!$comment_on_id)
		{
			$this->log(1, str_replace('%2', $this->page['user_name'], str_replace('%1', $this->tag, ( isset($_POST['cluster']) && $_POST['cluster'] == 1 ? $this->get_translation('LogRemovedCluster', $this->config['language']) : $this->get_translation('LogRemovedPage', $this->config['language']) ))));
		}
		else
		{
			$this->log(1, str_replace('%3', $this->get_time_string_formatted($this->page['created']), str_replace('%2', $this->page['user_name'], str_replace('%1', $this->get_page_tag($comment_on_id)." ".$this->get_page_title('', $comment_on_id), $this->get_translation('LogRemovedComment', $this->config['language'])))));
		}

		$message .= "<br />".$this->get_translation('ThisActionHavenotUndo')."<br />\n";

		$this->show_message($message, 'info');

		// return to commented page
		if ($comment_on_id)
		{
			echo '<br />'.$this->compose_link_to_page($this->get_page_tag($comment_on_id).'#commentsheader', '', '&laquo; '.$this->get_translation('ReturnToCommented'), 0);
		}
	}
	else
	{
		// show warning
		if ($comment_on_id)
		{
			$message = $this->get_translation('ReallyDeleteComment');
		}
		else
		{
			$message = $this->get_translation('ReallyDelete');
		}

		$this->show_message($message, 'warning');

		echo $this->form_open('remove');

		// admin privileged removal options
		if ($this->is_admin())
		{
			if (!$comment_on_id)
			{
				echo '<input id="removerevisions" type="checkbox" name="revisions" value="1" />';
				echo '<label for="removerevisions">'.$this->get_translation('RemoveRevisions').'</label><br />';
				echo '<input id="removecluster" type="checkbox" name="cluster" value="1" />';
				echo '<label for="removecluster">'.$this->get_translation('RemoveCluster').'</label><br />';
				echo '<input id="dontkeep" type="checkbox" name="dontkeep" value="1" />';
				echo '<label for="dontkeep">'.$this->get_translation('RemoveDontKeep').'</label><br />';
			}
		}

		// show backlinks
		echo '<br />';
		echo $this->action('backlinks', array('nomark' => 0));
?>
		<br /><br />
		<input type="hidden" name="delete" value="1" />
		<input class="OkBtn" id="submit" name="submit" type="submit" value="<?php echo $this->get_translation('RemoveButton'); ?>" />&nbsp;
		<input class="CancelBtn" id="button" type="button" value="<?php echo str_replace("\n"," ",$this->get_translation('EditCancelButton')); ?>" onclick="document.location='<?php echo addslashes($this->href(''))?>';" />
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