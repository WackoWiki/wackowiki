<?php

// tabbed theme output routine
function echo_tab( $link, $hint, $text, $selected = false, $bonus = "" )
{
	/*
	 To avoid creation of new classes we remember that we've created
	 $this->engine = new Wacko($this->config, $this->dblink); -- at line 571 of init.php
	 "$this" - was for class Init and its context
	 for other functions declared outside class Init the class Wacko comes as var $engine
	 so we can try to use it.

	 Elar9000 (2009.08.16)
	 */
	global $engine;

	$xsize = $selected ? 7 : 8;
	$ysize = $selected ? 25 : 30;

	if ($text == '') return; // no tab;
	if ($selected) $text = "<a href=\"$link\" title=\"$hint\">".$text."</a>";

	if (!$selected)
	{
		echo "<div class='TabSelected$bonus' style='background-image:url(".$engine->config['theme_url']."icons/tabbg.png);' >";
	}
	else
	{
		echo "<div class='Tab$bonus' style='background-image:url(".$engine->config['theme_url']."icons/tabbg".($bonus=="2a" ? "del" : "1").".png);'>";
	}

	$bonus2 = $bonus=="2a"?"del":"";

	echo '<table ><tr>';
	echo "<td><img src='".$engine->config['theme_url']."icons/tabr$selected".$bonus2.".png' width='$xsize' align='top' height='$ysize' alt='' /></td>";

	if (!$selected)
	{
		echo "<td>";
	}
	else
	{
		echo "<td valign='top'>";
	}

	echo "<div class='TabText'>".$text."</div>";
	echo "</td>";
	echo "<td><img src='".$engine->config['theme_url']."icons/tabl$selected".$bonus2.".png' width='$xsize' align='top' height='$ysize' alt='' /></td>";
	echo '</tr></table>';
	echo "</div>";
}

?>
<div class="Footer">
<img src="<?php echo $this->config['base_url'];?>images/z.png" width="5" height="1" alt="" align="left" />
<img src="<?php echo $this->config['base_url'];?>images/z.png" width="5" height="1" alt="" align="right" />
<?php
	echo_tab(
	$this->href('show'),
	$this->get_translation('ShowTip'),
	$this->has_access('read') ? $this->get_translation('ShowText') : "",
	$this->method != 'show'
	);

	echo_tab(
	$this->href('edit'),
	$this->get_translation('EditTip'),
	$this->has_access('write') ? $this->get_translation('EditText') : "",
	$this->method != 'edit'
	);

	echo_tab(
	$this->href('revisions'),
	$this->get_translation('RevisionTip'),
	$this->page['modified'] ? $this->get_page_time_formatted() : "",
	$this->method != 'revisions'
	);

	// if this page exists
	if ($this->page)
	{
		if($this->has_access('write') && $this->get_user() || $this->is_admin())
		{
			echo_tab(
			$this->href('properties'),
			$this->get_translation('SettingsTip'),
			$this->get_translation('PropertiesText'),
			$this->method != 'properties'
			);
		}

		// if owner is current user
		if ($this->user_is_owner())
		{
			echo_tab(
			$this->href('permissions'),
			(($this->method=='edit')
				? "' onclick='return window.confirm(\"".$this->get_translation('EditACLConfirm')."\");"
				: ""),
			$this->get_translation('ACLText'),
			$this->method != 'permissions'
			);
		}

		if ($this->is_admin() || (!$this->config['remove_onlyadmins'] && $this->user_is_owner()))
		{
			echo_tab(
			$this->href('remove'),
			$this->get_translation('DeleteTip'),
			'<img src="'.$this->config['theme_url'].'icons/del'.($this->method != 'remove' ? '' : '_').'.png" width="14" height="15" alt="" />'.$this->get_translation('DeleteText'),
			$this->method != 'remove',
			"2a"
			);
		}
	}

	if ($this->get_user())
	{
		echo_tab(
		$this->href('new'),
		$this->get_translation('CreateNewPage'),
		$this->has_access('write') ? $this->get_translation('CreateNewPage') : "",
		$this->method != 'new',
		"2"
		);
	}

	if ($this->get_user())
	{
		echo_tab(
		$this->href('referrers'),
		$this->get_translation('ReferrersTip'),
		$this->get_translation('ReferrersText'),
		$this->method != 'referrers',
		"2"
		);
	} ?>
<div class="TabSpace">
<div class="TabText" style="padding-left: 10px">
<?php
// if this page exists
if ($this->page)
{
	// if owner is current user
	if ($this->user_is_owner())
	{
		echo $this->get_translation('YouAreOwner');
	}
	else
	{
		if ($owner = $this->get_page_owner())
		{
			if ($owner == 'System')
			{
				echo $this->get_translation('Owner').": ".$owner."\n";
			}
			else
			{
				echo $this->get_translation('Owner').": "."<a href=\"".$this->href('', $this->config['users_page'], 'profile='.$owner)."\">".$owner."</a>"."\n";
			}
		}
		else if (!$this->page['comment_on_id'])
		{
			print($this->get_translation('Nobody').($this->get_user() ? " (<a href=\"".$this->href('claim')."\">".$this->get_translation('TakeOwnership')."</a>)" : ""));
		}
	}
}
?></div>
</div>
</div>
</div>
<!-- !! -->
<?php
if ($this->method == 'show')
{
	// files code starts
	if ($this->has_access('read') && $this->config['footer_files'] == 1 || ($this->config['footer_files'] == 2 && $this->get_user()))
	{
		require_once('handlers/page/_files.php');
	}

	// comments form output  starts
	if ($this->has_access('read') && ($this->config['footer_comments'] == 1 || ($this->config['footer_comments'] == 2 && $this->get_user()) ) && $this->user_allowed_comments())
	{
		require_once('handlers/page/_comments.php');
	}

	// rating form output begins
	if ($this->has_access('read') && $this->page && $this->config['footer_rating'] == 1 || ($this->config['footer_rating'] == 2 && $this->get_user()))
	{
		require_once('handlers/page/_rating.php');
	}

} //end of $this->method==show
?>
<!-- !!! -->

<div id="credits"><?php
if ($this->get_user())
{
	echo $this->get_translation('PoweredBy').' '.$this->link('WackoWiki:HomePage', '', 'WackoWiki');
}
?></div>
<?php

// don't place final </body></html> here. Wacko closes HTML automatically.

?>