<?php

/*

*/

?>
</div>
<div id="footer">
<div class="footer">
<div class="footerlist">
<ul>
<?php
// If User has rights to edit page, show Edit link
echo ($this->has_access('write') && ($this->method != 'edit')) ? "<li><a href=\"" . $this->href('edit') . "\" accesskey=\"E\" title=\"" . $this->_t('EditTip') . "\">" . $this->_t('EditText') . "</a></li>\n" : "";

// If this page exists
if ($this->page)
{
	// Revisions link
	echo (( $this->db->hide_revisions == false || ($this->db->hide_revisions == 1 && $this->get_user()) || ($this->db->hide_revisions == 2 && $this->is_owner()) || $this->is_admin() )
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
			: print("<li><a href=\"" . $this->href('new') . "\"><img src=\"" . $this->db->theme_url."icon/add_page.png\" title=\"" . $this->_t('CreateNewPageTip') . "\" alt=\"" . $this->_t('CreateNewPage') . "\" /></a></li>\n")
		);

		// Rename link
		print("<li><a href=\"" . $this->href('rename') . "\"><img src=\"" . $this->db->theme_url."icon/rename.png\" title=\"" . $this->_t('RenameText') . "\" alt=\"" . $this->_t('RenameText') . "\" /></a></li>\n");

		// Remove link (shows only for page owner if allowed)
		if (!$this->db->remove_onlyadmins) print("<li><a href=\"" . $this->href('remove') . "\"><img src=\"" . $this->db->theme_url."icon/delete.png\" title=\"" . $this->_t('DeleteTip') . "\" alt=\"" . $this->_t('DeleteText') . "\" /></a></li>\n");

		// Edit ACLs link
		print("<li><a href=\"" . $this->href('permissions') . "\"" . (($this->method=='edit') ? " onclick=\"return window.confirm('" . $this->_t('EditACLConfirm') . "');\"" : "") . ">" . $this->_t('ACLText') . "</a></li>\n");
	}
	// If owner is NOT current user
	else
	{
		// Show Owner of this page
		if ($owner = $this->get_page_owner())
		{
			if ($owner == 'System')
				print("<li>" . $this->_t('Owner') . ": " . $owner . "</li>\n");
			else
				print("<li>" . $this->_t('Owner') . ": " . $this->link($owner) . "</li>\n");
		}
		else if (!$this->page['comment_on_id'])
		{
			print("<li>" . $this->_t('Nobody').($this->get_user() ? " (<a href=\"" . $this->href('claim') . "\">" . $this->_t('TakeOwnership') . "</a></li>\n)" : ""));
		}

		// Add page link
		(($this->method == 'new')
			? ""
			: print("<li><a href=\"" . $this->href('new') . "\"><img src=\"" . $this->db->theme_url."icon/add_page.png\" title=\"" . $this->_t('CreateNewPageTip') . "\" alt=\"" . $this->_t('CreateNewPage') . "\" /></a></li>\n")
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
		print("<li><a href=\"" . $this->href('remove') . "\"><img src=\"" . $this->db->theme_url."icon/delete.png\" title=\"" . $this->_t('DeleteTip') . "\" alt=\"" . $this->_t('DeleteText') . "\" /></a></li>\n");

		// Edit ACLs link (shows also for Admins)
		print("<li><a href=\"" . $this->href('permissions') . "\"" . (($this->method=='edit')?" onclick=\"return window.confirm('" . $this->_t('EditACLConfirm') . "');\"":"") . ">" . $this->_t('ACLText') . "</a></li>\n");
	}

	if($this->has_access('write') && $this->get_user() || $this->is_admin())
	{
		// Page  settings link
		print("<li><a href=\"" . $this->href('properties'). "\"" . (($this->method=='edit')?" onclick=\"return window.confirm('" . $this->_t('EditPropertiesConfirm') . "');\"":"") . ">" . $this->_t('PropertiesText') . "</a></li>\n");

		if ($this->is_owner() || $this->is_admin())
		{
			// Add Categories link (shows only for page owner if allowed)
			print("<li><a href=\"" . $this->href('categories') . "\"" . (($this->method=='categories') ? " onclick=\"return window.confirm('" . $this->_t('EditACLConfirm') . "');\"" : "") . "><img src=\"" . $this->db->theme_url."icon/add_tag.png\" title=\"" . $this->_t('CategoriesTip') . "\" alt=\"" . $this->_t('CategoriesTip') . "\" /></a></li>\n");
		}

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

?>
</ul>
</div></div>
</div>
</div>
<!--ENDE: INHALT-->
<!--BEGINN: LEISTE -->
<div id="sub-section">
<div class="navText">

<?php
// Opens Search form
echo $this->form_open('search', '', 'get', $this->_t('TextSearchPage')); ?>
<div>
<?php
// Searchbar
?>
  <?php echo $this->_t('SearchText') ?><input type="search" name="phrase" size="15" style="border: none; border-bottom: 1px solid #CCCCAA; padding: 0px; margin: 0px;" />
</div>
<?php

// Search form close
echo $this->form_close();
?>

<?php
// Begin Login form
echo $this->form_open('login', '', 'post', $this->_t('LoginPage')); ?>
	<input type="hidden" name="action" value="login" />
<?php


// If user are logged, Wacko shows "You are UserName"
if ($this->get_user())
{ ?>
	<span class="nobr"><?php echo $this->_t('YouAre') . " " . $this->link($this->db->users_page . '/' . $this->get_user_name(), '', $this->get_user_name()) ?></span><br /><small>( <span class="nobr Tune">
<?php
	echo $this->compose_link_to_page($this->_t('AccountLink'), "", $this->_t('AccountText'), 0); ?>
| <a onclick="return confirm('<?php echo $this->_t('LogoutAreYouSure');?>');" href="<?php echo $this->href('', $this->_t('LoginPage'), 'action=logout&amp;goback=' . $this->slim_url($this->tag));?>"><?php echo $this->_t('LogoutLink'); ?></a></span> )</small>
<?php
// Else Wacko shows login's controls
}
else
{
?>
	<span>
		<input type="hidden" name="goback" value="<?php echo $this->slim_url($this->tag);?>"/>
		<strong><?php echo $this->_t('LoginWelcome') ?>:&nbsp;</strong>
		<input type="text" name="name" size="18" class="login" />
		&nbsp;
<?php
echo $this->_t('LoginPassword') ?>
		:&nbsp;
		<input type="password" name="password" class="login" size="8" />
		&nbsp;
		<input type="image" name="image" src="<?php echo $this->db->theme_url ?>icon/login.png" alt=">>>" align="top" />
	</span>
<?php
}
// End if
?>
<?php
// Closing Login form
echo $this->form_close();
?>

<?php

echo '<div class="newsNav"><ul class="newsNav">';

	// Main page
	#echo "<li>" . $this->compose_link_to_page($this->db->root_page) . "</li>\n";
	// menu
	if ($menu = $this->get_menu())
	{
		foreach ($menu as $menu_item)
		{
			$formatted_menu = $this->format($menu_item[2], 'post_wacko');

			if ($this->page['page_id'] == $menu_item[0])
			{
				echo '<li class="active">';
			}
			else
			{
				echo '<li>';
			}

			echo $formatted_menu . "</li>\n";
		}
	}

	if ($this->get_user())
	{
		// determines what it should show: "add to bookmarks" or "remove from bookmarks" icon
		if (!in_array($this->page['page_id'], $this->get_menu_links()))
		{
			echo '<li><a href="' .  $this->href('', '', 'addbookmark=yes')
				 . '"><img src="' .  $this->db->theme_url
				. 'icon/bookmark1.png" alt="+" title="' .
				$this->_t('AddToBookmarks')  . '"/></a></li>';
		}
		else
		{
			echo '<li><a href="' .  $this->href('', '', 'removebookmark=yes')
				 . '"><img src="' .  $this->db->theme_url
				. 'icon/bookmark2.png" alt="-" title="' .
				$this->_t('RemoveFromBookmarks')  . '"/></a></li>';
		}
	}
echo "</ul></div>";
echo '<br />';

?>

	<div>
<?php
			// toc
			if (!$this->db->hide_toc)
			{
				// show table of content
				echo $this->action('toc', array('from' => 'h2', 'to' => 'h3', 'numerate' => 0, 'nomark' => 0));
			}

			// categories
			echo $this->action('categories', array('list' => 1));

			// tag cloud
			# echo $this->action('tagcloud');

			// tree
			if ($this->db->tree_level == 1)
			{
				// lower index
				echo $this->action('tree', array('page' => $this->tag, 'depth' => 1, 'nomark' => 0));
			}
			else if ($this->db->tree_level == 2)
			{
				// upper index
				$page = '/'.substr($this->tag, 0, ( strrpos($this->tag, '/') ? strrpos($this->tag, '/') : strlen($this->tag) ));
				echo $this->action('tree', array('page' => $page, 'depth' => 1, 'nomark' => 0));
			}
			else
			{
				// default index
				$page = '/'.substr($this->tag, 0, ( strrpos($this->tag, '/') ? strrpos($this->tag, '/') : strlen($this->tag) ));
				echo $this->action('tree', array('page' => $page, 'depth' => 2, 'nomark' => 0));
			}


			?>

<div class="credits">
<?php
# print $this->format( '{{hits}} Aufrufe' );
?>
<div id="credits"><?php

// comment this out for not showing website policy link at the bottom of your pages
if ($this->db->policy_page) echo '<a href="' . htmlspecialchars($this->href('', $this->db->policy_page), ENT_COMPAT | ENT_HTML401, HTML_ENTITIES_CHARSET) . '">' . $this->_t('TermsOfUse') . '</a><br />';

if ($this->get_user())
{
	echo $this->_t('PoweredBy') . ' ' . $this->link('WackoWiki:HomePage', '', 'WackoWiki');
}
?></div>
</div>
</div>
	</div>
<!--ENDE: LEISTE-->
<?php

// Revisions link
echo $this->page['modified'] ? $this->_t('LastModification') . ": <a href=\"" . $this->href('revisions') . "\" title=\"" . $this->_t('RevisionTip') . "\">" . $this->page['modified'] . "</a> " . $this->_t('By') . " " . $this->link($this->page['user_name']) . "\n" : "";

// Don't place final </body></html> here. Wacko closes HTML automatically.
?>
</div>
<!--ENDE: SEITE-->
<!--BEGINN: FUSS-->
<div id="footer2"></div>
<!--ENDE: FUSS-->