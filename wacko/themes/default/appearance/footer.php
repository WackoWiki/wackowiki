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
echo ($this->has_access('write') && ($this->method != 'edit')) ? "<li><a href=\"".$this->href('edit')."\" accesskey=\"E\" title=\"".$this->get_translation('EditTip')."\">".$this->get_translation('EditText')."</a></li>\n" : "";

// If this page exists
if ($this->page)
{
	// Revisions link
	echo (( $this->hide_revisions === false || $this->is_admin() )
			? "<li><a href=\"".$this->href('revisions')."\" title=\"".$this->get_translation('RevisionTip')."\">".$this->get_time_string_formatted($this->page['modified'])."</a></li>\n"
			: "<li>".$this->get_time_string_formatted($this->page['modified'])."</li>\n"
		);

	// Show Owner of this page
	if ($owner = $this->get_page_owner())
	{
		if ($owner == 'System')
		{
			echo "<li>".$this->get_translation('Owner').": ".$owner."</li>\n";
		}
		else
		{
			echo "<li>".$this->get_translation('Owner').": "."<a href=\"".$this->href('', $this->config['users_page'], 'profile='.$owner)."\">".$owner."</a>"."</li>\n";
		}
	}
	else if (!$this->page['comment_on_id'])
	{
		echo "<li>".$this->get_translation('Nobody').($this->get_user() ? " (<a href=\"".$this->href('claim')."\">".$this->get_translation('TakeOwnership')."</a>)</li>\n" : "");
	}

	#if($this->has_access('write') && $this->get_user() || $this->is_admin())
	#{
		// referrers icon
	#	echo "<li><a href=\"".$this->href('referrers')."\"><img src=\"".$this->config['theme_url']."icons/referer.gif\" title=\"".$this->get_translation('ReferrersTip')."\" alt=\"".$this->get_translation('ReferrersText')."\" /></a></li>\n";
	#}

	#if ($this->get_user())
	#{
		// Watch/Unwatch icon
		#echo ($this->iswatched === true ? "<li><a href=\"".$this->href('watch')."\"><img src=\"".$this->config['theme_url']."icons/unwatch.gif\" title=\"".$this->get_translation('RemoveWatch')."\" alt=\"".$this->get_translation('RemoveWatch')."\"  /></a></li>\n" : "<li><a href=\"".$this->href('watch')."\"><img src=\"".$this->config['theme_url']."icons/watch.gif\" title=\"".$this->get_translation('SetWatch')."\" alt=\"".$this->get_translation('SetWatch')."\" /></a></li>\n");
	#}

	// Print icon
	# echo "<li><a href=\"".$this->href('print')."\"><img src=\"".$this->config['theme_url']."icons/print.gif\" title=\"".$this->get_translation('PrintVersion')."\" alt=\"".$this->get_translation('PrintVersion')."\" /></a></li>\n";

	// Permalink
	echo "<li>".$this->action('permalink')."</li>\n";
}

?>
</ul>
</div>
</div>
<div id="credits"><?php

if ($this->get_user())
{
	echo $this->get_translation('PoweredBy').' '.$this->link('WackoWiki:HomePage', '', 'WackoWiki').'<br />';
}

// comment this out for not showing website policy link at the bottom of your pages
if ($this->config['policy_page'])
{
	echo '<a href="'.htmlspecialchars($this->href('', $this->config['policy_page'])).'">'.$this->get_translation('TermsOfUse').'</a><br />';
}

?></div>
</div>
</div>
<?php

// Don't place final </body></html> here. Wacko closes HTML automatically.
?>