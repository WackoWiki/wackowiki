<?php $base_url = $this->config['base_url']; ?>

		<?php /* show page info only for pages */ if ($this->method == 'show') { ?>
		<hr class="onlyAural"/>

		<div class="sitesuffix">
			<div class="pageinfo">
				<h2><dfn><?php echo $this->get_translation('SiteInformation'); ?></dfn></h2>
				<p>
					<?php /* User is page owner */ echo ($this->page && $this->get_user() && $this->user_is_owner()) ? $this->get_translation('YouAreOwner') :''; ?>
					<?php
						/* show page owner */
						if ($this->page && $this->get_user() && !$this->user_is_owner()) {
							if ($owner = $this->get_page_owner())
								print($this->get_translation('Owner').": ".$this->link($owner));
							else if (!$this->page['comment_on_id'])
								print($this->get_translation('Nobody').($this->get_user() ? " (<a href=\"".$this->href('claim')."\">".$this->get_translation('TakeOwnership')."</a>)" : ""));
						}
					?>
					<?php /* show last edit info */ echo ($this->has_access('read') && $this->page['modified']) ? $this->get_translation('LastModification').': <a href="'.$this->href('revisions').'" title="'.$this->get_translation('RevisionTip').'" id="page_diff"><span class="backendbutton"></span><img class="contexticon" src="'.$this->config['theme_url'].'icons/page_diff.png" alt="" />'.$this->get_page_time_formatted().'</a> '.$this->get_translation('By').' '.$this->link($this->page['user_name']).".\n" : ''; ?>
				</p>
				<?php if ($this->get_user()) { ?>
				<ul>
					<?php /* Referer link */ echo '<li id="page_link"><a href="'.$this->href('referrers').'" title="'.$this->get_translation('ReferrersText').'"><span class="backendbutton"></span><img class="contexticon" src="'.$this->config['theme_url'].'icons/page_link.png" alt="" />'.$this->get_translation('ReferrersText').'</a><span class="sep">,</span></li>'."\n"; ?>
					<?php /* Show uploads link*/ echo ($this->page && $this->get_user() && !isset($_SESSION['show_files'][$this->tag])) ? '<li id="page_attach"><a href="'.$this->href('', '', 'show_files=1#files') .'"><span class="backendbutton" title="'.$this->get_translation('ShowFiles').'"></span><img class="contexticon" src="'.$this->config['theme_url'].'icons/page_attach.png" alt="" />'.$this->get_translation('ShowFiles').'</a></li>'."\n":''; ?>
					<?php /* Hide uploads link*/ echo ($this->page && $this->get_user() && isset($_SESSION['show_files'][$this->tag])) ? '<li><a href="'.$this->href('', '', 'show_files=0') .'">'.$this->get_translation('HideFiles').'</a></li>'."\n":''; ?>
				</ul>
				<?php } ?>
			</div> <!-- /pageinfo -->

			<div class="pagetools">
				<h2><dfn><?php echo $this->get_translation('SiteTools') ; ?></dfn></h2>
				<ul>
					<?php /* Edit link */ echo ($this->has_access('write')) ? '<li id="page_edit"><a href="'.$this->href('edit').'" title="'.$this->get_translation('EditTip').'"><span class="backendbutton"></span><img class="contexticon" src="'.$this->config['theme_url'].'icons/page_edit.png" alt="" />'.$this->get_translation('EditText').'</a><span class="sep">,</span></li>'."\n" : ''; ?>
					<?php /* Rename link */ echo ($this->page && $this->get_user() && $this->user_is_owner()) ? '<li id="page_rename"><a href="'.$this->href('rename').'" title="'.$this->get_translation('RenameText').'"><span class="backendbutton"></span><img class="contexticon" src="'.$this->config['theme_url'].'icons/page_copy.png" alt="" />'.$this->get_translation('RenameText').'</a><span class="sep">,</span></li>'."\n" : ''; ?>
					<?php /* Page properties link */ if ($this->get_user()) {print '<li id="page_properties"><a href="'.$this->href('properties').'"'.(($this->method=='edit')?" onclick=\"return window.confirm('".$this->get_translation('EditACLConfirm')."');\"":"").' title="'.$this->get_translation('PropertiesTip').'"><span class="backendbutton"></span><img class="contexticon" src="'.$this->config['theme_url'].'icons/page_gear.png" alt="" />'.$this->get_translation('PropertiesText').'</a><span class="sep">,</span></li>'."\n";} ?>
					<?php /* Edit ACLs link */ echo ($this->page && $this->get_user() && $this->user_is_owner()) ? '<li id="page_acls"><a href="'.$this->href('permissions').'"'.(($this->method=='edit')?" onclick=\"return window.confirm('".$this->get_translation('EditACLConfirm')."');\"":"").' title="'.$this->get_translation('ACLText').'"><span class="backendbutton"></span><img class="contexticon" src="'.$this->config['theme_url'].'icons/page_key.png" alt="" />'.$this->get_translation('ACLText').'</a><span class="sep">,</span></li>'."\n" : ''; ?>
					<?php /* New page link */ echo ($this->has_access('write')) ? '<li id="page_new"><a href="'.$this->href('new').'" title="'.$this->get_translation('CreateNewPageTip').'"><span class="backendbutton"></span><img class="contexticon" src="'.$this->config['theme_url'].'icons/page_new.png" alt="" />'.$this->get_translation('CreateNewPage').'</a><span class="sep">,</span></li>'."\n" : ''; ?>
					<?php /* Remove link (shows only for Admins) */ if ($this->is_admin()) print '<li id="page_remove"><a href="'.$this->href('remove').'" title="'.$this->get_translation('DeleteTip').'"><span class="backendbutton"></span><img class="contexticon" src="'.$this->config['theme_url'].'icons/page_delete.png" alt="" />'.$this->get_translation('DeleteTip').'</a><span class="sep">,</span></li>'."\n"; ?>
					<?php /* Bookmark on/off */ if ($this->get_user()) {echo (in_array($this->tag, $this->get_bookmark_links())) ?  '<li id="page_bookmarkoff"><a href="'.$this->href('', '', "removebookmark=yes").'" title="'.$this->get_translation('RemoveFromBookmarks') .'"><span class="backendbutton"></span><img class="contexticon" src="'.$this->config['theme_url'].'icons/link_delete.png" alt="" />'.$this->get_translation('Bookmarks').' [-]</a><span class="sep">,</span></li>' : '<li id="page_bookmarkon"><a href="'.$this->href('', '', "addbookmark=yes").'" title="'.$this->get_translation('AddToBookmarks') .'"><span class="backendbutton"></span><img class="contexticon" src="'.$this->config['theme_url'].'icons/link_add.png" alt="" />'.$this->get_translation('Bookmarks').' [+]</a><span class="sep">,</span></li>'; echo "\n";} ?>
					<?php /* Watch/Unwatch icon */ if ($this->get_user()) {echo ($this->iswatched === true ? '<li id="page_unwatch"><a href="'.$this->href('watch').'" title="'.$this->get_translation('RemoveWatch').'"><span class="backendbutton"></span><img class="contexticon" src="'.$this->config['theme_url'].'icons/transmit_delete.png" alt="" />'.$this->get_translation('RemoveWatch').'</a><span class="sep">,</span></li>' : '<li id="page_watch"><a href="'.$this->href('watch').'" title="'.$this->get_translation('SetWatch').'"><span class="backendbutton"></span><img class="contexticon" src="'.$this->config['theme_url'].'icons/transmit_add.png" alt="" />'.$this->get_translation('SetWatch').'</a><span class="sep">,</span></li>')."\n";} ?>
					<?php /* Print icon */ echo '<li id="page_print"><a href="'.$this->href('print').'" title="'.$this->get_translation('PrintVersion').'"><span class="backendbutton"></span><img class="contexticon" src="'.$this->config['theme_url'].'icons/printer.png" alt="" />'.$this->get_translation('PrintVersion').'</a></li>'."\n"; ?>
				</ul>
			</div> <!-- /pagetools -->

		</div> <!-- /sitesuffix -->
		<?php } ?>

		</div> <!-- /content -->

		<?php
		if ($this->get_user())
		{
			echo '<hr class="onlyAural"/>';
			echo '<div class="bookmarks">';
				echo '<h1>'.$this->get_translation('Bookmarks').'</h1>';
				echo '<ol id="usermenu" class="normal">';
				echo '<!-- li><a href="'.$base_url.'Intern">Intern</a></li -->';
				// Bookmarks
				$formated_bm = $this->format($this->get_bookmarks_formatted(), 'post_wacko');
				$formated_bm = str_replace ("<br />", "", $formated_bm);
				$formated_bm = str_replace ( "\n", "</li><li>\n", $formated_bm );
				echo '<li>'.$formated_bm.'</li>';
				echo "</ol>";
			echo '</div> <!-- /bookmarks -->';
		}
		?>

		<hr class="onlyAural"/>

        <div class="footer">
            <p><?php
if ($this->get_user()){
	echo $this->get_translation('PoweredBy').' '.$this->link('WackoWiki:HomePage', '', 'WackoWiki '.$this->get_wacko_version());
	echo " &amp; <a href=\"http://eye48.com/go/miniwackolicious\">MiniWackoLicious Theme</a> | ";

	/*show user name and preferences*/
	echo $this->get_translation('YouAre')." <span id=\"user_page\">".$this->compose_link_to_page($this->get_user_name(), "", "<span class=\"backendbutton\"></span>".$this->add_spaces($this->get_user_name()), 0, $this->add_spaces($this->get_user_name()))."</span> | <span id=\"user_preferences\">".$this->compose_link_to_page($this->get_translation('AccountLink'),'',"<span class=\"backendbutton\"></span>".$this->add_spaces($this->get_translation('AccountLink')), 0, $this->add_spaces($this->get_translation('AccountText')))."</span> | ";
} ?>
              <span id="system_logout"><?php /* login/logout */ echo ($this->get_user()) ? '<a href="'.$this->href('', $this->get_translation('LoginPage')).($this->config['rewrite_mode'] ? "?" : "&amp;").'action=logout&amp;goback='.$this->slim_url($this->tag).'"><span class="backendbutton" title="'.$this->get_translation('LogoutLink').'"></span>'.$this->get_translation('LogoutLink').'</a>' : $this->compose_link_to_page($this->get_translation('LoginPage').($this->config['rewrite_mode'] ? "?" : "&amp;")."goback=".$this->slim_url($this->tag), "", $this->get_translation('LoginPage'), 0); ?></span>
            </p>
        </div> <!-- /footer -->

</div> <!-- /sitewrapper -->
