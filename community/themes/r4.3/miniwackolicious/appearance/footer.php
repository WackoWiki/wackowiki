<?php $base_url = $this->config["base_url"]; ?>

		<?php /* show page info only for pages */ if ($this->method == 'show') { ?>
		<hr class="onlyAural"/>

		<div class="sitesuffix">
			<div class="pageinfo">
				<h2><dfn><?php echo $this->GetTranslation("SiteInformation"); ?></dfn></h2>
				<p>
					<?php /* User is page owner */ echo ($this->page && $this->GetUser() && $this->UserIsOwner()) ? $this->GetTranslation("YouAreOwner") :''; ?>
					<?php
						/* show page owner */
						if ($this->page && $this->GetUser() && !$this->UserIsOwner()) {
							if ($owner = $this->GetPageOwner())
								print($this->GetTranslation("Owner").": ".$this->Link($owner));
							else if (!$this->page["comment_on_id"])
								print($this->GetTranslation("Nobody").($this->GetUser() ? " (<a href=\"".$this->href("claim")."\">".$this->GetTranslation("TakeOwnership")."</a>)" : ""));
						}
					?>
					<?php /* show last edit info */ echo ($this->HasAccess("read") && $this->page["modified"]) ? $this->GetTranslation("LastModification").': <a href="'.$this->href("revisions").'" title="'.$this->GetTranslation("RevisionTip").'" id="page_diff"><span class="backendbutton"></span><img class="contexticon" src="'.$this->config["theme_url"].'icons/page_diff.png" alt="" />'.$this->GetPageTimeFormatted().'</a> '.$this->GetTranslation("by").' '.$this->Link($this->GetPageLastWriter()).".\n" : ''; ?>
				</p>
				<?php if ($this->GetUser()) { ?>
				<ul>
					<?php /* Referer link */ echo '<li id="page_link"><a href="'.$this->href("referrers").'" title="'.$this->GetTranslation("ReferrersText").'"><span class="backendbutton"></span><img class="contexticon" src="'.$this->config["theme_url"].'icons/page_link.png" alt="" />'.$this->GetTranslation("ReferrersText").'</a><span class="sep">,</span></li>'."\n"; ?>
					<?php /* Show uploads link*/ echo ($this->page && $this->GetUser() && !$_SESSION["show_files"][$this->tag]) ? '<li id="page_attach"><a href="'.$this->href("", "", "show_files=1#files") .'"><span class="backendbutton" title="'.$this->GetTranslation("ShowFiles").'"></span><img class="contexticon" src="'.$this->config["theme_url"].'icons/page_attach.png" alt="" />'.$this->GetTranslation("ShowFiles").'</a></li>'."\n":''; ?>
					<?php /* Hide uploads link*/ echo ($this->page && $this->GetUser() && $_SESSION["show_files"][$this->tag]) ? '<li><a href="'.$this->href("", "", "show_files=0") .'">'.$this->GetTranslation("HideFiles").'</a></li>'."\n":''; ?>
				</ul>
				<?php } ?>
			</div> <!-- /pageinfo -->

			<div class="pagetools">
				<h2><dfn><?php echo $this->GetTranslation("SiteTools") ; ?></dfn></h2>
				<ul>
					<?php /* Edit link */ echo ($this->HasAccess("write")) ? '<li id="page_edit"><a href="'.$this->href("edit").'" title="'.$this->GetTranslation("EditTip").'"><span class="backendbutton"></span><img class="contexticon" src="'.$this->config["theme_url"].'icons/page_edit.png" alt="" />'.$this->GetTranslation("EditText").'</a><span class="sep">,</span></li>'."\n" : ''; ?>
					<?php /* Rename link */ echo ($this->page && $this->GetUser() && $this->UserIsOwner()) ? '<li id="page_rename"><a href="'.$this->href("rename").'" title="'.$this->GetTranslation("RenameText").'"><span class="backendbutton"></span><img class="contexticon" src="'.$this->config["theme_url"].'icons/page_copy.png" alt="" />'.$this->GetTranslation("RenameText").'</a><span class="sep">,</span></li>'."\n" : ''; ?>
					<?php /* Page settings link */ if ($this->GetUser()) {print '<li id="page_settings"><a href="'.$this->href("settings").'"'.(($this->method=='edit')?" onclick=\"return window.confirm('".$this->GetTranslation("EditACLConfirm")."');\"":"").' title="'.$this->GetTranslation("SettingsTip").'"><span class="backendbutton"></span><img class="contexticon" src="'.$this->config["theme_url"].'icons/page_gear.png" alt="" />'.$this->GetTranslation("SettingsText").'</a><span class="sep">,</span></li>'."\n";} ?>
					<?php /* Edit ACLs link */ echo ($this->page && $this->GetUser() && $this->UserIsOwner()) ? '<li id="page_acls"><a href="'.$this->href("acls").'"'.(($this->method=='edit')?" onclick=\"return window.confirm('".$this->GetTranslation("EditACLConfirm")."');\"":"").' title="'.$this->GetTranslation("ACLText").'"><span class="backendbutton"></span><img class="contexticon" src="'.$this->config["theme_url"].'icons/page_key.png" alt="" />'.$this->GetTranslation("ACLText").'</a><span class="sep">,</span></li>'."\n" : ''; ?>
					<?php /* New page link */ echo ($this->HasAccess("write")) ? '<li id="page_new"><a href="'.$this->href("new").'" title="'.$this->GetTranslation("CreateNewPageTip").'"><span class="backendbutton"></span><img class="contexticon" src="'.$this->config["theme_url"].'icons/page_new.png" alt="" />'.$this->GetTranslation("CreateNewPage").'</a><span class="sep">,</span></li>'."\n" : ''; ?>
					<?php /* Remove link (shows only for Admins) */ if ($this->IsAdmin()) print '<li id="page_remove"><a href="'.$this->href("remove").'" title="'.$this->GetTranslation("DeleteTip").'"><span class="backendbutton"></span><img class="contexticon" src="'.$this->config["theme_url"].'icons/page_delete.png" alt="" />'.$this->GetTranslation("DeleteTip").'</a><span class="sep">,</span></li>'."\n"; ?>
					<?php /* Bookmark on/off */ if ($this->GetUser()) {echo (in_array($this->tag, $this->GetBookmarkLinks())) ?  '<li id="page_bookmarkoff"><a href="'.$this->Href('', '', "removebookmark=yes").'" title="'.$this->GetTranslation("RemoveFromBookmarks") .'"><span class="backendbutton"></span><img class="contexticon" src="'.$this->config["theme_url"].'icons/link_delete.png" alt="" />'.$this->GetTranslation("Bookmarks").' [-]</a><span class="sep">,</span></li>' : '<li id="page_bookmarkon"><a href="'.$this->Href('', '', "addbookmark=yes").'" title="'.$this->GetTranslation("AddToBookmarks") .'"><span class="backendbutton"></span><img class="contexticon" src="'.$this->config["theme_url"].'icons/link_add.png" alt="" />'.$this->GetTranslation("Bookmarks").' [+]</a><span class="sep">,</span></li>'; echo "\n";} ?>
					<?php /* Watch/Unwatch icon */ if ($this->GetUser()) {echo ($this->iswatched === true ? '<li id="page_unwatch"><a href="'.$this->href("watch").'" title="'.$this->GetTranslation("RemoveWatch").'"><span class="backendbutton"></span><img class="contexticon" src="'.$this->config["theme_url"].'icons/transmit_delete.png" alt="" />'.$this->GetTranslation("RemoveWatch").'</a><span class="sep">,</span></li>' : '<li id="page_watch"><a href="'.$this->href("watch").'" title="'.$this->GetTranslation("SetWatch").'"><span class="backendbutton"></span><img class="contexticon" src="'.$this->config["theme_url"].'icons/transmit_add.png" alt="" />'.$this->GetTranslation("SetWatch").'</a><span class="sep">,</span></li>')."\n";} ?>
					<?php /* Print icon */ echo '<li id="page_print"><a href="'.$this->href("print").'" title="'.$this->GetTranslation("PrintVersion").'"><span class="backendbutton"></span><img class="contexticon" src="'.$this->config["theme_url"].'icons/printer.png" alt="" />'.$this->GetTranslation("PrintVersion").'</a></li>'."\n"; ?>
				</ul>
			</div> <!-- /pagetools -->

		</div> <!-- /sitesuffix -->
		<?php } ?>

		</div> <!-- /content -->

		<?php
		if ($this->GetUser())
		{
            echo '<hr class="onlyAural"/>';
			echo '<div class="bookmarks">';
				echo '<h1>'.$this->GetTranslation("Bookmarks").'</h1>';
				echo '<ol id="usermenu" class="normal">';
				echo '<!-- li><a href="'.$base_url.'Intern">Intern</a></li -->';
				// Bookmarks
				$BMs = $this->GetBookmarks();
				$formatedBMs =  $this->Format($this->Format(implode("| ", $BMs), "wacko"), "post_wacko");
				$formatedBMs = str_replace ( "\n", "</li>\n<li>", $formatedBMs );
				echo '<li>'.$formatedBMs.'</li>';
				echo "</ol>";
			echo '</div> <!-- /bookmarks -->';
		}
		?>

		<hr class="onlyAural"/>

        <div class="footer">
            <p><?php
if ($this->GetUser()){
	echo $this->GetTranslation("PoweredBy")." ".$this->Link("WackoWiki:HomePage", "", "WackoWiki ".$this->GetWackoVersion());
	echo " &amp; <a href=\"http://eye48.com/go/miniwackolicious\">MiniWackoLicious Theme</a> | ";

	/*show user name and preferences*/
	echo $this->GetTranslation("YouAre")." <span id=\"user_page\">".$this->ComposeLinkToPage($this->GetUserName(), "", "<span class=\"backendbutton\"></span>".$this->AddSpaces($this->GetUserName()), 0, $this->AddSpaces($this->GetUserName()))."</span> | <span id=\"user_preferences\">".$this->ComposeLinkToPage($this->GetTranslation("YouArePanelLink"),'',"<span class=\"backendbutton\"></span>".$this->AddSpaces($this->GetTranslation("YouArePanelLink")), 0, $this->AddSpaces($this->GetTranslation("YouArePanelLink")))."</span> | ";
} ?>
              <span id="system_logout"><?php /* login/logout */ echo ($this->GetUser()) ? '<a href="'.$this->Href("",$this->GetTranslation("LoginPage")).($this->config["rewrite_mode"] ? "?" : "&amp;").'action=logout&amp;goback='.$this->SlimUrl($this->tag).'"><span class="backendbutton" title="'.$this->GetTranslation("LogoutLink").'"></span>'.$this->GetTranslation("LogoutLink").'</a>' : $this->ComposeLinkToPage($this->GetTranslation("LoginPage").($this->config["rewrite_mode"] ? "?" : "&amp;")."goback=".$this->SlimUrl($this->tag), "", $this->GetTranslation("LoginPage"), 0); ?></span>
            </p>
        </div> <!-- /footer -->

</div> <!-- /sitewrapper -->
