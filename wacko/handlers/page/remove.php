<div id="page">
<?php

// obviously do not allow to remove non-existent pages
if (!$this->page) $this->Redirect($this->href());

// check user permissions to delete
// ToDo: config->owners_can_remove_comments ?
if ($this->IsAdmin() ||
(!$this->GetConfigValue("remove_onlyadmins") &&
($this->GetPageOwner($this->tag) == $this->GetUserName() ||
$this->GetPageOwnerFromComment() == $this->GetUserName())))
{
	if (!$this->page)
	{
		print(str_replace("%1",$this->href("edit"),$this->GetTranslation("DoesNotExists")));
	}
	else
	{
		if ($_POST["delete"] == 1)
		{
			if ($this->page["comment_on_id"])
				$comment_on = $this->page["comment_on_id"];

			// Remove page
			if ($this->RemoveReferrers($this->tag))
			{
				print(str_replace("%1", $this->tag, $this->GetTranslation("ReferrersRemoved"))."<br />\n");
			}
			if ($this->RemoveLinks($this->tag))
			{
				print(str_replace("%1", $this->tag, $this->GetTranslation("LinksRemoved"))."<br />\n");
			}
			if ($this->RemoveAcls($this->tag))
			{
				print(str_replace("%1", $this->tag, $this->GetTranslation("AclsRemoved"))."<br />\n");
			}
			if ($this->RemoveWatches($this->tag))
			{
				print(str_replace("%1", $this->tag, $this->GetTranslation("WatchesRemoved"))."<br />\n");
			}
			if ($this->RemoveComments($this->tag))
			{
				$this->WriteRecentCommentsXML();
				print(str_replace("%1", $this->tag, $this->GetTranslation("CommentsRemoved"))."<br />\n");
			}
			if ($this->RemoveFiles($this->tag))
			{
				print(str_replace("%1", $this->tag, $this->GetTranslation("FilesRemoved"))."<br />\n");
			}
			if ($this->RemovePage($this->tag))
			{
				$this->WriteRecentChangesXML();
				$this->WriteRecentCommentsXML();
				print(str_replace("%1", $this->tag, $this->GetTranslation("PageRemoved"))."<br />\n");
			}
			if ($this->IsAdmin() && $_POST["revisions"] == 1 && !$comment_on)
			{
				$this->RemoveRevisions($this->tag);
				echo $this->GetTranslation("RevisionsRemoved")."<br />\n";
			}
			if ($this->IsAdmin() && $_POST["cluster"] == 1)
			{
				$this->RemoveReferrers	($this->tag, true);
				$this->RemoveLinks		($this->tag, true);
				$this->RemoveAcls		($this->tag, true);
				$this->RemoveWatches	($this->tag, true);
				$this->RemoveComments	($this->tag, true, $dontkeep);
				$this->RemoveFiles		($this->tag, true);

				// get list of pages in the cluster
				if ($list = $this->LoadAll(
				"SELECT tag ".
				"FROM {$this->config['table_prefix']}pages ".
				"WHERE tag LIKE '".quote($this->dblink, $this->tag.'/%')."'"))
				{
					// remove by one page at a time
					foreach ($list as $row) $this->RemovePage($row["tag"], "", $dontkeep);
					unset($list, $row);
				}

				if ($_POST["revisions"] == 1 || $comment_on)
					$this->RemoveRevisions($this->tag, true);

				echo "<em>".$this->GetTranslation("ClusterRemoved")."</em><br />\n";
			}

			// log event
			if (!$comment_on)
			{
				$this->Log(1, str_replace("%2", $this->page["user"], str_replace("%1", $this->tag, ( $_POST["cluster"] == 1 ? $this->GetTranslation("LogRemovedCluster") : $this->GetTranslation("LogRemovedPage") ))));
			}
			else
			{
				$this->Log(1, str_replace("%3", $this->GetTimeStringFormatted($this->page["created"]), str_replace("%2", $this->page["user"], str_replace("%1", $comment_on." ".$this->GetPageTitle($comment_on), $this->GetTranslation("LogRemovedComment")))));
			}

			echo "<br />".$this->GetTranslation("ThisActionHavenotUndo")."<br />\n";

			// return to commented page
			if ($comment_on)
			{
				echo "<br />&laquo; ".$this->ComposeLinkToPage($this->GetCommentOnTag($comment_on)."#comments", "", $this->GetTranslation("ReturnToCommented"), 0);
			}
		}
		else
		{
			echo "<div class=\"warning\">".$this->GetTranslation("ReallyDelete".
				($this->page["comment_on_id"] ? "Comment" : ""))."</div>";
			echo $this->FormOpen("remove");

			// admin privileged removal options
			if ($this->IsAdmin())
			{
				if (!$this->page["comment_on_id"])
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
		if ($pages = $this->LoadPagesLinkingTo($this->getPageTag()))
		{
			print("<br /><div class=\"layout-box\"><p class=\"layout-box\"><span>".$this->GetTranslation("AlertReferringPages").":</span></p>\n");
			foreach ($pages as $page)
			{
				if ($page["tag"])
				{
					if ($this->config["hide_locked"]) $access = $this->HasAccess("read",$page["tag"]);
					else $access = true;
					if ($access)
					{
						echo($this->ComposeLinkToPage($page["tag"])."<br />\n");
					}
				}
			}
			echo "</div>\n";
		}

?>
  <br />
  <br />
  <input type="hidden" name="delete" value="1" />
  <input name="submit" type="submit" value="<?php echo $this->GetTranslation("RemoveButton"); ?>" />
  &nbsp;
  <input
	type="button"
	value="<?php echo str_replace("\n"," ",$this->GetTranslation("EditCancelButton")); ?>"
	onclick="document.location='<?php echo addslashes($this->href(""))?>';" />
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