<div id="page">
<?php

$comment_on_id	= '';
$dontkeep		= '';

// obviously do not allow to remove non-existent pages
if (!$this->page) $this->redirect($this->href());

// check user permissions to delete
// TODO: config->owners_can_remove_comments ?
if ($this->is_admin() ||
(!$this->config['remove_onlyadmins'] &&
((!$this->page['comment_on_id'] && $this->get_page_owner($this->tag) == $this->get_user_name()) ||
($this->page['comment_on_id'] && $this->get_page_owner_from_comment() == $this->get_user_name()))))
{
	if (!$this->page)
	{
		print(str_replace('%1', $this->href('edit'),$this->get_translation('DoesNotExists')));
	}
	else
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

			// Remove page
			if ($this->remove_referrers($this->tag))
			{
				print(str_replace('%1', $this->tag, $this->get_translation('ReferrersRemoved'))."<br />\n");
			}
			if ($this->remove_links($this->tag))
			{
				print(str_replace('%1', $this->tag, $this->get_translation('LinksRemoved'))."<br />\n");
			}
			if ($this->remove_categories($this->tag))
			{
				print($this->get_translation('CategoriesRemoved')."<br />\n");
			}
			if ($this->remove_acls($this->tag))
			{
				print(str_replace('%1', $this->tag, $this->get_translation('AclsRemoved'))."<br />\n");
			}
			if (!$comment_on_id)
			{
				if ($this->remove_bookmarks($this->tag))
				{
					print(str_replace('%1', $this->tag, $this->get_translation('BookmarksRemoved'))."<br />\n");
				}
				if ($this->remove_watches($this->tag))
				{
					print(str_replace('%1', $this->tag, $this->get_translation('WatchesRemoved'))."<br />\n");
				}
				if ($this->remove_ratings($this->tag))
				{
					print($this->get_translation('RatingRemoved')."<br />\n");
				}
				if ($this->remove_comments($this->tag, false, $dontkeep))
				{
					print(str_replace('%1', $this->tag, $this->get_translation('CommentsRemoved'))."<br />\n");
				}
				if ($this->remove_files($this->tag))
				{
					print(str_replace('%1', $this->tag, $this->get_translation('FilesRemoved'))."<br />\n");
				}
			}
			if ($this->remove_page($this->tag, $comment_on_id, $dontkeep))
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

				print(str_replace('%1', $this->tag, $this->get_translation('PageRemoved'))."<br />\n");
			}

			if ($this->is_admin() && (isset($_POST['revisions']) && $_POST['revisions'] == 1) && !$comment_on_id)
			{
				$this->remove_revisions($this->tag);
				echo $this->get_translation('RevisionsRemoved')."<br />\n";
			}

			if ($this->is_admin() && (isset($_POST['cluster']) && $_POST['cluster'] == 1))
			{
				$this->remove_referrers		($this->tag, true);
				$this->remove_links			($this->tag, true);
				$this->remove_categories	($this->tag, true);
				$this->remove_acls			($this->tag, true);
				$this->remove_bookmarks		($this->tag, true);
				$this->remove_watches		($this->tag, true);
				$this->remove_ratings		($this->tag, true);
				$this->remove_comments		($this->tag, true, $dontkeep);
				$this->remove_files			($this->tag, true);

				// get list of pages in the cluster
				if ($list = $this->load_all(
				"SELECT tag ".
				"FROM {$this->config['table_prefix']}page ".
				"WHERE tag LIKE '".quote($this->dblink, $this->tag.'/%')."'"))
				{
					// remove by one page at a time
					foreach ($list as $row)
					{
						$this->remove_page($row['tag'], '', $dontkeep);
					}

					unset($list, $row);
				}

				if ((isset($_POST['revisions']) && $_POST['revisions'] == 1) || $comment_on_id)
				{
					$this->remove_revisions($this->tag, true);
				}

				echo "<em>".$this->get_translation('ClusterRemoved')."</em><br />\n";
			}

			// update user statistics
			if ($owner_id = $this->page['owner_id'])
			{
				$this->query(
					"UPDATE {$this->config['user_table']} ".
					( $comment_on_id
					? "SET total_comments	= total_comments	- 1 "
					: "SET total_pages		= total_pages		- 1 "
					).
					"WHERE user_id = '".quote($this->dblink, $owner_id)."' ".
					"LIMIT 1");
			}

			// log event
			if (!$comment_on_id)
			{
				$this->log(1, str_replace('%2', $this->page['user_name'], str_replace('%1', $this->tag, ( isset($_POST['cluster']) && $_POST['cluster'] == 1 ? $this->get_translation('LogRemovedCluster', $this->config['language']) : $this->get_translation('LogRemovedPage', $this->config['language']) ))));
			}
			else
			{
				$this->log(1, str_replace('%3', $this->get_time_string_formatted($this->page['created']), str_replace('%2', $this->page['user_name'], str_replace('%1', $comment_on_id." ".$this->get_page_title($comment_on_id), $this->get_translation('LogRemovedComment', $this->config['language'])))));
			}

			echo "<br />".$this->get_translation('ThisActionHavenotUndo')."<br />\n";

			// return to commented page
			if ($comment_on_id)
			{
				echo "<br />".$this->compose_link_to_page($this->get_page_tag_by_id($comment_on_id)."#comments", "", "&laquo; ".$this->get_translation('ReturnToCommented'), 0);
			}
		}
		else
		{
			// show warning
			echo "<div class=\"warning\">";

			if ($comment_on_id)
			{
				echo $this->get_translation('ReallyDeleteComment');
			}
			else
			{
				echo $this->get_translation('ReallyDelete');
			}

			echo "</div>";

			echo $this->form_open('remove');

			// admin privileged removal options
			if ($this->is_admin())
			{
				if (!$comment_on_id)
				{
					echo "<input id=\"removerevisions\" type=\"checkbox\" name=\"revisions\" value=\"1\" />";
					echo "<label for=\"removerevisions\">".$this->get_translation('RemoveRevisions')."</label><br />";
					echo "<input id=\"removecluster\" type=\"checkbox\" name=\"cluster\" value=\"1\" />";
					echo "<label for=\"removecluster\">".$this->get_translation('RemoveCluster')."</label><br />";
					echo "<input id=\"dontkeep\" type=\"checkbox\" name=\"dontkeep\" value=\"1\" />";
					echo "<label for=\"dontkeep\">".$this->get_translation('RemoveDontKeep')."</label><br />";
				}
			}

		// show backlinks
		echo "<br />";
		echo $this->action('backlinks', array('nomark' => 0));
?>
		<br /><br />
		<input type="hidden" name="delete" value="1" />
		<input id="submit" name="submit" type="submit" value="<?php echo $this->get_translation('RemoveButton'); ?>" />&nbsp;
		<input id="button" type="button" value="<?php echo str_replace("\n"," ",$this->get_translation('EditCancelButton')); ?>" onclick="document.location='<?php echo addslashes($this->href(''))?>';" />
		<br />
<?php echo $this->form_close();
		}
	}
}
else
{
	echo $this->get_translation('NotOwnerAndCanDelete');
}
?>
</div>