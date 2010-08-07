<div id="page">
<?php

$comment_on_id = "";
$dontkeep = "";

// obviously do not allow to remove non-existent pages
if (!$this->page) $this->Redirect($this->href());

// check user permissions to delete
// ToDo: config->owners_can_remove_comments ?
if ($this->IsAdmin() ||
(!$this->config["remove_onlyadmins"] &&
($this->GetPageOwner($this->tag) == $this->GetUserName() ||
$this->GetPageOwnerFromComment() == $this->GetUserName())))
{
	if (!$this->page)
	{
		print(str_replace("%1",$this->href("edit"),$this->GetTranslation("DoesNotExists")));
	}
	else
	{
		if ($this->page["comment_on_id"])
			$comment_on_id = $this->page["comment_on_id"];

		if (isset($_POST["delete"]) && $_POST["delete"] == 1)
		{
			if ($this->page["comment_on_id"])
				$comment_on_id = $this->page["comment_on_id"];

			if (isset($_POST["dontkeep"]) && $this->IsAdmin())
				$dontkeep = 1;

			// Remove page
			if ($this->RemoveReferrers($this->tag))
			{
				print(str_replace("%1", $this->tag, $this->GetTranslation("ReferrersRemoved"))."<br />\n");
			}
			if ($this->RemoveLinks($this->tag))
			{
				print(str_replace("%1", $this->tag, $this->GetTranslation("LinksRemoved"))."<br />\n");
			}
			if ($this->RemoveCategories($this->tag))
			{
				print($this->GetTranslation("CategoriesRemoved")."<br />\n");
			}
			if ($this->RemoveAcls($this->tag))
			{
				print(str_replace("%1", $this->tag, $this->GetTranslation("AclsRemoved"))."<br />\n");
			}
			if (!$comment_on_id)
			{
				if ($this->RemoveBookmarks($this->tag))
				{
					print(str_replace("%1", $this->tag, $this->GetTranslation("BookmarksRemoved"))."<br />\n");
				}
				if ($this->RemoveWatches($this->tag))
				{
					print(str_replace("%1", $this->tag, $this->GetTranslation("WatchesRemoved"))."<br />\n");
				}
				if ($this->RemoveRatings($this->tag))
				{
					print($this->GetTranslation("RatingRemoved")."<br />\n");
				}
				if ($this->RemoveComments($this->tag, false, $dontkeep))
				{
					print(str_replace("%1", $this->tag, $this->GetTranslation("CommentsRemoved"))."<br />\n");
				}
				if ($this->RemoveFiles($this->tag))
				{
					print(str_replace("%1", $this->tag, $this->GetTranslation("FilesRemoved"))."<br />\n");
				}
			}
			if ($this->RemovePage($this->tag, $comment_on_id, $dontkeep))
			{
				$this->UseClass('rss');
				$xml = new RSS($this);
				$xml->Comments();
				if (!$comment_on_id)
				{
					$xml->Changes();
				}
				print(str_replace("%1", $this->tag, $this->GetTranslation("PageRemoved"))."<br />\n");
			}

			if ($this->IsAdmin() && (isset($_POST["revisions"]) && $_POST["revisions"] == 1) && !$comment_on_id)
			{
				$this->RemoveRevisions($this->tag);
				echo $this->GetTranslation("RevisionsRemoved")."<br />\n";
			}
			if ($this->IsAdmin() && (isset($_POST["cluster"]) && $_POST["cluster"] == 1))
			{
				$this->RemoveReferrers	($this->tag, true);
				$this->RemoveLinks		($this->tag, true);
				$this->RemoveCategories	($this->tag, true);
				$this->RemoveAcls		($this->tag, true);
				$this->RemoveBookmarks	($this->tag, true);
				$this->RemoveWatches	($this->tag, true);
				$this->RemoveRatings	($this->tag, true);
				$this->RemoveComments	($this->tag, true, $dontkeep);
				$this->RemoveFiles		($this->tag, true);

				// get list of pages in the cluster
				if ($list = $this->LoadAll(
				"SELECT tag ".
				"FROM {$this->config['table_prefix']}page ".
				"WHERE tag LIKE '".quote($this->dblink, $this->tag.'/%')."'"))
				{
					// remove by one page at a time
					foreach ($list as $row) $this->RemovePage($row["tag"], "", $dontkeep);
					unset($list, $row);
				}

				if ((isset($_POST["revisions"]) && $_POST["revisions"] == 1) || $comment_on_id)
					$this->RemoveRevisions($this->tag, true);

				echo "<em>".$this->GetTranslation("ClusterRemoved")."</em><br />\n";
			}

			// update user statistics
			if ($owner_id = $this->page["owner_id"])
			{
				$this->Query(
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
				$this->Log(1, str_replace("%2", $this->page["user_name"], str_replace("%1", $this->tag, ( isset($_POST["cluster"]) && $_POST["cluster"] == 1 ? $this->GetTranslation("LogRemovedCluster", $this->config["language"]) : $this->GetTranslation("LogRemovedPage", $this->config["language"]) ))));
			}
			else
			{
				$this->Log(1, str_replace("%3", $this->GetTimeStringFormatted($this->page["created"]), str_replace("%2", $this->page["user_name"], str_replace("%1", $comment_on_id." ".$this->GetPageTitle($comment_on_id), $this->GetTranslation("LogRemovedComment", $this->config["language"])))));
			}

			echo "<br />".$this->GetTranslation("ThisActionHavenotUndo")."<br />\n";

			// return to commented page
			if ($comment_on_id)
			{
				echo "<br />".$this->ComposeLinkToPage($this->GetCommentOnTag($comment_on_id)."#comments", "", "&laquo; ".$this->GetTranslation("ReturnToCommented"), 0);
			}
		}
		else
		{
			// show warning
			echo "<div class=\"warning\">";

			if ($comment_on_id)
			{
				echo $this->GetTranslation("ReallyDeleteComment");
			}
			else
			{
				echo $this->GetTranslation("ReallyDelete");
			}

			echo "</div>";

			echo $this->FormOpen("remove");

			// admin privileged removal options
			if ($this->IsAdmin())
			{
				if (!$comment_on_id)
				{
					echo "<input id=\"removerevisions\" type=\"checkbox\" name=\"revisions\" value=\"1\" />";
					echo "<label for=\"removerevisions\">".$this->GetTranslation("RemoveRevisions")."</label><br />";
					echo "<input id=\"removecluster\" type=\"checkbox\" name=\"cluster\" value=\"1\" />";
					echo "<label for=\"removecluster\">".$this->GetTranslation("RemoveCluster")."</label><br />";
					echo "<input id=\"dontkeep\" type=\"checkbox\" name=\"dontkeep\" value=\"1\" />";
					echo "<label for=\"dontkeep\">".$this->GetTranslation("RemoveDontKeep")."</label><br />";
				}
			}

		// show backlinks
		echo "<br />";
		echo $this->Action("backlinks", array("nomark" => 0));
?>
		<br /><br />
		<input type="hidden" name="delete" value="1" />
		<input id="submit" name="submit" type="submit" value="<?php echo $this->GetTranslation("RemoveButton"); ?>" />&nbsp;
		<input id="button" type="button" value="<?php echo str_replace("\n"," ",$this->GetTranslation("EditCancelButton")); ?>" onclick="document.location='<?php echo addslashes($this->href(""))?>';" />
		<br />
<?php echo $this->FormClose();
		}
	}
}
else
{
	print($this->GetTranslation("NotOwnerAndCanDelete"));
}
?>
</div>