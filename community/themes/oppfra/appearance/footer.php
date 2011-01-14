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
echo ($this->has_access('write') && ($this->method != 'edit')) ? "<li><a href=\"".$this->href('edit')."\" accesskey=\"E\" title=\"".$this->get_translation('EditTip')."\">".$this->get_translation('EditText')."</a></li>\n" : "";

// If this page exists
if ($this->page)
{
	// Revisions link
	echo $this->page['modified'] ? "<li><a href=\"".$this->href('revisions')."\" title=\"".$this->get_translation('RevisionTip')."\">".$this->get_time_string_formatted($this->page['modified'])."</a></li>\n" : "";

	// If owner is current user
	if ($this->user_is_owner())
	{
		echo "<li>".$this->get_translation('YouAreOwner')."</li>\n";

		// Add page link
		(($this->method == 'new')
			? ""
			: print("<li><a href=\"".$this->href('new')."\"><img src=\"".$this->config['theme_url']."icons/add_page.gif\" title=\"".$this->get_translation('CreateNewPageTip')."\" alt=\"".$this->get_translation('CreateNewPage')."\" /></a></li>\n")
		);

		// Rename link
		print("<li><a href=\"".$this->href('rename')."\"><img src=\"".$this->config['theme_url']."icons/rename.gif\" title=\"".$this->get_translation('RenameText')."\" alt=\"".$this->get_translation('RenameText')."\" /></a></li>\n");

		// Remove link (shows only for page owner if allowed)
		if (!$this->config['remove_onlyadmins']) print("<li><a href=\"".$this->href('remove')."\"><img src=\"".$this->config['theme_url']."icons/delete.gif\" title=\"".$this->get_translation('DeleteTip')."\" alt=\"".$this->get_translation('DeleteText')."\" /></a></li>\n");

		// Edit ACLs link
		print("<li><a href=\"".$this->href('permissions')."\"".(($this->method=='edit') ? " onclick=\"return window.confirm('".$this->get_translation('EditACLConfirm')."');\"" : "").">".$this->get_translation('ACLText')."</a></li>\n");
	}
	// If owner is NOT current user
	else
	{
		// Show Owner of this page
		if ($owner = $this->get_page_owner())
		{
			if ($owner == 'System')
				print("<li>".$this->get_translation('Owner').": ".$owner."</li>\n");
			else
				print("<li>".$this->get_translation('Owner').": ".$this->link($owner)."</li>\n");
		}
		else if (!$this->page['comment_on_id'])
		{
			print("<li>".$this->get_translation('Nobody').($this->get_user() ? " (<a href=\"".$this->href('claim')."\">".$this->get_translation('TakeOwnership')."</a></li>\n)" : ""));
		}

		// Add page link
		(($this->method == 'new')
			? ""
			: print("<li><a href=\"".$this->href('new')."\"><img src=\"".$this->config['theme_url']."icons/add_page.gif\" title=\"".$this->get_translation('CreateNewPageTip')."\" alt=\"".$this->get_translation('CreateNewPage')."\" /></a></li>\n")
		);
	}

	// Rename link
	if ($this->check_acl($this->get_user_name(),$this->config['rename_globalacl']) && !$this->user_is_owner())
	{
		print("<li><a href=\"".$this->href('rename')."\"><img src=\"".$this->config['theme_url']."icons/rename.gif\" title=\"".$this->get_translation('RenameText')."\" alt=\"".$this->get_translation('RenameText')."\" /></a></li>\n");
	}
	// Remove link (shows only for Admins)
	if ($this->is_admin() && !$this->user_is_owner())
	{
		print("<li><a href=\"".$this->href('remove')."\"><img src=\"".$this->config['theme_url']."icons/delete.gif\" title=\"".$this->get_translation('DeleteTip')."\" alt=\"".$this->get_translation('DeleteText')."\" /></a></li>\n");

		// Edit ACLs link (shows also for Admins)
		print("<li><a href=\"".$this->href('permissions')."\"".(($this->method=='edit')?" onclick=\"return window.confirm('".$this->get_translation('EditACLConfirm')."');\"":"").">".$this->get_translation('ACLText')."</a></li>\n");
	}

	if($this->has_access('write') && $this->get_user() || $this->is_admin())
	{
		// Page  settings link
		print("<li><a href=\"".$this->href('properties'). "\"".(($this->method=='edit')?" onclick=\"return window.confirm('".$this->get_translation('EditPropertiesConfirm')."');\"":"").">".$this->get_translation('PropertiesText')."</a></li>\n");

		if ($this->user_is_owner() || $this->is_admin())
		{
			// Add Categories link (shows only for page owner if allowed)
			print("<li><a href=\"".$this->href('categories')."\"".(($this->method=='categories') ? " onclick=\"return window.confirm('".$this->get_translation('EditACLConfirm')."');\"" : "")."><img src=\"".$this->config['theme_url']."icons/add_tag.png\" title=\"".$this->get_translation('CategoriesTip')."\" alt=\"".$this->get_translation('CategoriesTip')."\" /></a></li>\n");
		}

		// referrers icon
		print("<li><a href=\"".$this->href('referrers')."\"><img src=\"".$this->config['theme_url']."icons/referer.gif\" title=\"".$this->get_translation('ReferrersTip')."\" alt=\"".$this->get_translation('ReferrersText')."\" /></a></li>\n");
	}

	if ($this->get_user())
	{
		// Watch/Unwatch icon
		echo ($this->iswatched === true ? "<li><a href=\"".$this->href('watch')."\"><img src=\"".$this->config['theme_url']."icons/unwatch.gif\" title=\"".$this->get_translation('RemoveWatch')."\" alt=\"".$this->get_translation('RemoveWatch')."\"  /></a></li>\n" : "<li><a href=\"".$this->href('watch')."\"><img src=\"".$this->config['theme_url']."icons/watch.gif\" title=\"".$this->get_translation('SetWatch')."\" alt=\"".$this->get_translation('SetWatch')."\" /></a></li>\n");
	}

	// Print icon
	echo"<li><a href=\"".$this->href('print')."\" target=\"_blank\"><img src=\"".$this->config['theme_url']."icons/print.gif\" title=\"".$this->get_translation('PrintVersion')."\" alt=\"".$this->get_translation('PrintVersion')."\" /></a></li>\n";
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
echo $this->form_open('', $this->get_translation('TextSearchPage'), 'get'); ?>
<div>
<?php
// Searchbar
?>
  <?php echo $this->get_translation('SearchText') ?><input type="text" name="phrase" size="15" style="border: none; border-bottom: 1px solid #CCCCAA; padding: 0px; margin: 0px;" />
</div>
<?php

// Search form close
echo $this->form_close();
?>

<?php
// Begin Login form
echo $this->form_open('', $this->get_translation('LoginPage'), 'post'); ?>
	<input type="hidden" name="action" value="login" />
<?php


// If user are logged, Wacko shows "You are UserName"
if ($this->get_user())
{ ?>
	<span class="nobr"><?php echo $this->get_translation('YouAre')." ".$this->link($this->get_user_name()) ?></span><br /><small>( <span class="nobr Tune">
<?php
	echo $this->compose_link_to_page($this->get_translation('AccountLink'), "", $this->get_translation('AccountText'), 0); ?>
| <a onclick="return confirm('<?php echo $this->get_translation('LogoutAreYouSure');?>');" href="<?php echo $this->href('', $this->get_translation('LoginPage')).($this->config['rewrite_mode'] ? "?" : "&amp;");?>action=logout&amp;goback=<?php echo $this->slim_url($this->tag);?>"><?php echo $this->get_translation('LogoutLink'); ?></a></span> )</small>
<?php
// Else Wacko shows login's controls
}
else
{
?>
	<span>
		<input type="hidden" name="goback" value="<?php echo $this->slim_url($this->tag);?>"/>
		<strong><?php echo $this->get_translation('LoginWelcome') ?>:&nbsp;</strong>
		<input type="text" name="name" size="18" class="login" />
		&nbsp;
<?php
echo $this->get_translation('LoginPassword') ?>
		:&nbsp;
		<input type="password" name="password" class="login" size="8" />
		&nbsp;
		<input name="image" type="image" src="<?php echo $this->config['theme_url'] ?>icons/login.gif" alt=">>>" align="top" />
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
// Bookmarks
		// Main page
		#echo "<li>".$this->compose_link_to_page($this->config['root_page'])."</li>\n";
		echo "<li>";

$formated_bm = $this->format($this->get_bookmarks_formatted(), 'post_wacko');
$formated_bm = str_replace ("<br />", "", $formated_bm);
$formated_bm = str_replace ("\n", "</li>\n<li>", $formated_bm);
echo $formated_bm;
echo "</li>\n";
		if ($this->get_user())
		{
			// Here Wacko determines what it should show: "add to Bookmarks" or "remove from Bookmarks" icon
			if (!in_array($this->tag, $this->get_bookmark_links()))
				echo '<li><a href="'. $this->href('', '', 'addbookmark=yes')
					.'"><img src="'. $this->config['theme_url']
					.'icons/bookmark1.gif" alt="+" title="'.
					$this->get_translation('AddToBookmarks') .'"/></a></li>';
			else
				echo '<li><a href="'. $this->href('', '', 'removebookmark=yes')
					.'"><img src="'. $this->config['theme_url']
					.'icons/bookmark2.gif" alt="-" title="'.
					$this->get_translation('RemoveFromBookmarks') .'"/></a></li>';
			}
echo "</ul></div>";
echo '<br />';

?>

	<div>
<?php
			// toc
			if (!$this->config['hide_toc'])
			{
				// show table of content
				echo $this->action('toc', array('from' => 'h2', 'to' => 'h3', 'numerate' => 1, 'nomark' => 0));
			}

			// categories
			echo $this->action('category', array('list' => 1));

			// tag cloud
			# echo $this->action('tagcloud');

			// tree
			if ($this->config['tree_level'] == 1)
			{
				// lower index
				echo $this->action('tree', array('page' => $this->tag, 'depth' => 1, 'nomark' => 0));
			}
			else if ($this->config['tree_level'] == 2)
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
if ($this->config['policy_page']) echo '<a href="'.htmlspecialchars($this->href('', $this->config['policy_page'])).'">'.$this->get_translation('TermsOfUse').'</a><br />';

if ($this->get_user())
{
	echo $this->get_translation('PoweredBy').' '.$this->link('WackoWiki:HomePage', '', 'WackoWiki '.$this->get_wacko_version());
}
?></div>
</div>
</div>
	</div>
<!--ENDE: LEISTE-->
<?php

// Revisions link
echo $this->page['modified'] ? $this->get_translation('LastModification') .": <a href=\"".$this->href('revisions')."\" title=\"".$this->get_translation('RevisionTip')."\">".$this->page['modified']."</a> ".$this->get_translation('By')." ".$this->link($this->page['user_name'])."\n" : "";

// Don't place final </body></html> here. Wacko closes HTML automatically.
?>
</div>
<!--ENDE: SEITE-->
<!--BEGINN: FUSS-->
<div id="footer2"></div>
<!--ENDE: FUSS-->