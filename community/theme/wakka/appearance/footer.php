<?php

/*
 Default theme.
 Common footer file.
 */

?>
</div>
<div id="footer">
<div class="footer">
<div class="footerlist">
<ul>
<?php
// If User has rights to edit page, show Edit link
echo ($this->has_access('write') && ($this->method != 'edit')) ? '<li><a href="' . $this->href('edit') . '" accesskey="E" title="' . $this->_t('EditTip') . '">' . $this->_t('EditText') . "</a></li>\n" : '';

// If this page exists
if ($this->page)
{
	if ($this->has_access('read'))
	{
		// Revisions link
		echo (( $this->hide_revisions === false || $this->is_admin() )
				? "<li><a href=\"" . $this->href('revisions') . "\" title=\"" . $this->_t('RevisionTip') . "\">" . $this->get_time_formatted($this->page['modified']) . "</a></li>\n"
				: "<li>" . $this->get_time_formatted($this->page['modified']) . "</li>\n"
			);
		// If owner is current user
		if ($this->is_owner())
		{
			echo "<li>" . $this->_t('YouAreOwner') . "</li>\n";

			// Add page link
			(($this->method == 'new')
				? ""
				: print("<li><a href=\"" . $this->href('new') . "\"><img src=\"" . $this->db->theme_url."icon/add_page.png\" title=\"" . $this->_t('CreateNewPageTip') . "\" alt=\"" . $this->_t('CreateNewPageTip') . "\" /></a></li>\n")
			);

			// Rename link
			print("<li><a href=\"" . $this->href('rename') . "\"><img src=\"" . $this->db->theme_url."icon/rename.png\" title=\"" . $this->_t('RenameText') . "\" alt=\"" . $this->_t('RenameText') . "\" /></a></li>\n");

			// Remove link (shows only for page owner if allowed)
			if (!$this->db->remove_onlyadmins) print("<li><a href=\"" . $this->href('remove') . "\"><img src=\"" . $this->db->theme_url."icon/delete_page.png\" title=\"" . $this->_t('DeleteTip') . "\" alt=\"" . $this->_t('DeleteText') . "\" /></a></li>\n");

			//Edit ACLs link
			print("<li><a href=\"" . $this->href('permissions') . "\"" . (($this->method=='edit')?" onclick=\"return window.confirm('" . $this->_t('EditACLConfirm') . "');\"":"") . ">" . $this->_t('ACLText') . "</a></li>\n");
		}
		// If owner is NOT current user
		else
		{
			// Show Owner of this page
			if ($owner = $this->get_page_owner())
			{
				if ($owner == 'System')
				{
					echo "<li>" . $this->_t('Owner') . ": " . $owner . "</li>\n";
				}
				else
				{
					echo "<li>" . $this->_t('Owner') . ": " . $this->user_link($owner, $lang = '', true, false) . "</li>\n";
				}
			}
			else if (!$this->page['comment_on_id'])
			{
				print("<li>" . $this->_t('Nobody').($this->get_user() ? " (<a href=\"" . $this->href('claim') . "\">" . $this->_t('TakeOwnership') . "</a></li>\n)" : ""));
			}

			// Add page link
			(($this->method == 'new')
				? ""
				: print("<li><a href=\"" . $this->href('new') . "\"><img src=\"" . $this->db->theme_url."icon/add_page.png\" title=\"" . $this->_t('CreateNewPageTip') . "\" alt=\"" . $this->_t('CreateNewPageTip') . "\" /></a></li>\n")
			);
		}

		// Rename link
		if ($this->check_acl($this->get_user_name(),$this->db->rename_globalacl) && !$this->is_owner())
		{
			print("<li><a href=\"" . $this->href('rename') . "\"><img src=\"" . $this->db->theme_url."icon/rename.png\" title=\"" . $this->_t('RenameText') . "\" alt=\"" . $this->_t('RenameText') . "\" /></a></li>\n");
		}
		// Remove link (shows only for Admins)
		if ($this->is_admin() && !$this->is_owner())
		{
			print("<li><a href=\"" . $this->href('remove') . "\"><img src=\"" . $this->db->theme_url."icon/delete_page.png\" title=\"" . $this->_t('DeleteTip') . "\" alt=\"" . $this->_t('DeleteText') . "\" /></a></li>\n");

			// Edit ACLs link (shows also for Admins)
			print("<li><a href=\"" . $this->href('permissions') . "\"" . (($this->method=='edit')?" onclick=\"return window.confirm('" . $this->_t('EditACLConfirm') . "');\"":"") . ">" . $this->_t('ACLText') . "</a></li>\n");
		}

		if($this->has_access('write') && $this->get_user() || $this->is_admin())
		{
			// Page  settings link
			print("<li><a href=\"" . $this->href('properties'). "\"" . (($this->method=='edit')?" onclick=\"return window.confirm('" . $this->_t('EditPropertiesConfirm') . "');\"":"") . ">" . $this->_t('PropertiesText') . "</a></li>\n");

			// referrers icon
			print("<li><a href=\"" . $this->href('referrers') . "\"><img src=\"" . $this->db->theme_url."icon/referrer.png\" title=\"" . $this->_t('ReferrersTip') . "\" alt=\"" . $this->_t('ReferrersText') . "\" /></a></li>\n");
		}

		if ($this->get_user())
		{
			// Watch/Unwatch icon
			echo ($this->is_watched === true ? "<li><a href=\"" . $this->href('watch') . "\"><img src=\"" . $this->db->theme_url."icon/unwatch.png\" title=\"" . $this->_t('RemoveWatch') . "\" alt=\"" . $this->_t('RemoveWatch') . "\"  /></a></li>\n" : "<li><a href=\"" . $this->href('watch') . "\"><img src=\"" . $this->db->theme_url."icon/watch.png\" title=\"" . $this->_t('SetWatch') . "\" alt=\"" . $this->_t('SetWatch') . "\" /></a></li>\n");
		}

		// Print icon
		echo"<li><a href=\"" . $this->href('print') . "\"><img src=\"" . $this->db->theme_url."icon/print.png\" title=\"" . $this->_t('PrintVersion') . "\" alt=\"" . $this->_t('PrintVersion') . "\" /></a></li>\n";
	}
}

?>
</ul>
</div>
</div>
<div id="credits"><?php
if ($this->get_user())
{
	echo $this->_t('PoweredBy') . ' ' . $this->link('WackoWiki:HomePage', '', 'WackoWiki');
}
?></div>
</div>
</div>
<?php

// Don't place final </body></html> here. Wacko closes HTML automatically.
?>