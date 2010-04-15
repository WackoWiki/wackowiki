<div id="page"><?php

// redirect to show method if page don't exists
if (!$this->page) $this->Redirect($this->href("show"));

// deny for comment
if ($this->page["comment_on_id"])
$this->Redirect($this->href('', $this->GetCommentOnTag($this->page["comment_on_id"]), 'show_comments=1').'#'.$this->page['tag']);
// and for forum page
else if ($this->forum === true && !$this->IsAdmin())
	$this->Redirect($this->href());

if ($this->UserIsOwner() || $this->IsAdmin())
{
	if ($_POST)
	{
		// acls for page or entire cluster
		$need_massacls = 0;
		if ($_POST["massacls"] == "on") $need_massacls = 1;

		// acls page
		if ($need_massacls == 0)
		{
			// store lists
			$this->SaveAcl($this->GetPageId(), "read", $_POST["read_acl"]);
			$this->SaveAcl($this->GetPageId(), "write", $_POST["write_acl"]);
			$this->SaveAcl($this->GetPageId(), "comment", $_POST["comment_acl"]);

			// log event
			$this->Log(2, str_replace("%1", $this->page["tag"]." ".$this->page["title"], $this->GetTranslation("LogACLUpdated")));

			$message = $this->GetTranslation("ACLUpdated");

			// change owner?
			if ($newowner = $_POST["newowner"])
			{
				// check user exists
				$exists = $this->LoadSingle(
						"SELECT user_name ".
						"FROM {$this->config['user_table']} ".
						"WHERE user_name = '".quote($this->dblink, $newowner)."' ".
						"LIMIT 1");

				if ($exists == true)
				{
					$newowner = $exists['user_name'];
					$newowner_id = $this->GetUserIdByName($newowner);
					$this->SetPageOwner($this->GetPageId(), $newowner_id);

					$User = $this->LoadSingle(
							"SELECT email, more, email_confirm ".
							"FROM {$this->config['user_table']} ".
							"WHERE user_name = '".quote($this->dblink, $newowner)."'");

					$User['options'] = $this->DecomposeOptions($User['more']);

					if ($User['email_confirm'] == '')
					{
						$subject = $this->config['wacko_name'].'. '.$this->GetTranslation('NewPageOwnership');
						$email  = $this->GetTranslation('EmailHello').$newowner.".\n\n";
						$email .= str_replace('%2', $this->config['wacko_name'], str_replace('%1', $this->GetUserName(), $this->GetTranslation('YouAreNewOwner')))."\n";
						$email .= $this->Href('', $this->tag, '')."\n\n";
						$email .= $this->GetTranslation('PageOwnershipInfo')."\n";
						//$email .= $this->Href('', '', '')."\n\n";
						$email .= $this->GetTranslation('EmailGoodbye')."\n".$this->config['wacko_name']."\n".$this->config['base_url'];
						$this->SendMail($User['email'], $subject, $email);
					}

					// log event
					$this->Log(2, str_replace("%2", $newowner, str_replace("%1", $this->page["tag"]." ".$this->page["title"], $this->GetTranslation("LogOwnershipChanged"))));

					$message .= $this->GetTranslation("ACLGaveOwnership").$newowner;
				}
				else
				{
					// new owner doesn't exists
					$message .= str_replace('%1', $newowner, $this->GetTranslation('ACLNoNewOwner'));
					$this->SetMessage($message);
					$this->Redirect($this->Href('acls'));
				}
			}

			// Change permissions for all comments on this page
			$comments = $this->LoadAll(
					"SELECT page_id FROM ".$this->config["table_prefix"]."pages WHERE comment_on_id = '".$this->GetPageId()."' AND owner_id='".quote($this->dblink, $this->GetUserId())."'");
			foreach ($comments as $num=>$page)
			{
				$this->SaveAcl($page["page_id"], "read", $_POST["read_acl"]);
				$this->SaveAcl($page["page_id"], "write", $_POST["write_acl"]);
				$this->SaveAcl($page["page_id"], "comment", $_POST["comment_acl"]);

				// change owner?
				if ($newowner = $_POST["newowner"])
				$newowner_id = $this->GetUserIdByName($newowner);
				$this->SetPageOwner($page["page_id"], $newowner_id);
			}
		}

		// acls for entire cluster
		if ($need_massacls == 1)
		{
			$pages = $this->LoadAll("
				SELECT p.page_id, p.tag, p.title ".
				"FROM ".$this->config["table_prefix"]."pages p ".
					"LEFT JOIN ".$this->config["table_prefix"]."pages c ON (p.comment_on_id = c.page_id) ".
				"WHERE (p.supertag = '".quote($this->dblink, $this->supertag)."'".
				" OR p.supertag LIKE '".quote($this->dblink, $this->supertag."/%")."'".
				" OR p.comment_on_id = '".quote($this->dblink, $this->GetPageId())."'".
				" OR c.supertag LIKE '".quote($this->dblink, $this->supertag."/%")."'".
					") ".
				($this->IsAdmin()
					? ""
					: "AND p.owner_id = '".quote($this->dblink, $this->GetUserId())."'"));

			foreach ($pages as $num=>$page)
			{
				// store lists
				$this->SaveAcl($page["page_id"], "read", $_POST["read_acl"]);
				$this->SaveAcl($page["page_id"], "write", $_POST["write_acl"]);
				$this->SaveAcl($page["page_id"], "comment", $_POST["comment_acl"]);

				// log event
				$this->Log(2, str_replace("%1", $page["tag"]." ".$page["title"], $this->GetTranslation("LogACLUpdated")));

				// change owner?
				if ($newowner = $_POST["newowner"])
				{
					$newowner_id = $this->GetUserIdByName($newowner);
					$this->SetPageOwner($page["page_id"], $newowner_id);
					$ownedpages .= $this->Href("", $page["tag"])."\n";

					// log event
					$this->Log(2, str_replace("%2", $exists["user_name"], str_replace("%1", $page["tag"]." ".$page["title"], $this->GetTranslation("LogOwnershipChanged"))));
				}
			}

			$message = $this->GetTranslation("ACLUpdated");

			if ($newowner = $_POST["newowner"])
			{
				$message .= $this->GetTranslation("ACLGaveOwnership").$newowner;

				$User = $this->LoadSingle(
					"SELECT email, more, email_confirm ".
					"FROM {$this->config['user_table']} ".
					"WHERE user_name = '".quote($newowner)."'");

				$User['options'] = $this->DecomposeOptions($User['more']);

				if ($User['email_confirm'] == '')
				{
					$subject = $this->config['wacko_name'].'. '.$this->GetTranslation('NewPageOwnership');
					$email  = $this->GetRes('EmailHello').$newowner.".\n\n";
					$email .= str_replace('%2', $this->config['wacko_name'], str_replace('%1', $this->GetUserName(), $this->GetTranslation('YouAreNewOwner')))."\n";
					$email .= $ownedpages."\n";
					$email .= $this->GetTranslation('PageOwnershipInfo')."\n";
					//$email .= $this->Href('', '', '')."\n\n";
					$email .= $this->GetTranslation('EmailGoodbye')."\n".$this->config['wacko_name']."\n".$this->config['base_url'];
					$this->SendMail($User['email'], $subject, $email);
				}
			}
		}

		// redirect back to page
		$this->SetMessage($message."!");
		$this->Redirect($this->href());
	}
	else
	{
		// load acls
		$readACL = $this->LoadAcl($this->GetPageId(), "read");
		$writeACL = $this->LoadAcl($this->GetPageId(), "write");
		$commentACL = $this->LoadAcl($this->GetPageId(), "comment");

		// show form
		?>
<h3><?php echo str_replace("%1",$this->Link("/".$this->tag),$this->GetTranslation("ACLFor")); ?></h3>
<?php echo $this->FormOpen("acls") ?> <?php echo "<input type=\"checkbox\" id=\"massacls\" name=\"massacls\" "; echo " /> <label for=\"massacls\">".$this->GetTranslation("SettingsMassAcls")."</label>"; ?>
<br />
<div class="cssform">
<p><label for="read_acl"><?php echo $this->GetTranslation("ACLRead"); ?></label>
<textarea id="read_acl" name="read_acl" rows="4" cols="20"><?php echo $readACL["list"] ?></textarea>
</p>
<p><label for="write_acl"><?php echo $this->GetTranslation("ACLWrite"); ?></label>
<textarea id="write_acl" name="write_acl" rows="4" cols="20"><?php echo $writeACL["list"] ?></textarea>
</p>
<p><label for="comment_acl"><?php echo $this->GetTranslation("ACLComment"); ?></label>
<textarea id="comment_acl" name="comment_acl" rows="4" cols="20"><?php echo $commentACL["list"] ?></textarea>
</p>
<p><label for="newowner"><?php echo $this->GetTranslation("SetOwner"); ?></label>
<select id="newowner" name="newowner">
	<option value=""><?php echo $this->GetTranslation("OwnerDontChange"); ?></option>
	<?php
	if ($users = $this->LoadUsers())
	{
		foreach($users as $user)
		{
			print("<option value=\"".htmlspecialchars($user["user_name"])."\">".$user["user_name"]."</option>\n");
		}
	}
	?>
</select></p>
<p><input id="submit" type="submit"
	value="<?php echo $this->GetTranslation("ACLStoreButton"); ?>"
	accesskey="s" /> &nbsp; <input id="button" type="button"
	value="<?php echo $this->GetTranslation("ACLCancelButton"); ?>"
	onclick="document.location='<?php echo addslashes($this->href(""))?>';" />
</p>
</div>
	<?php
	print($this->FormClose());
	}
}
else
{
	print($this->GetTranslation("ACLAccessDenied"));
}

?></div>
