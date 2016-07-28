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
		echo "<div class='TabSelected$bonus' style='background-image:url(".$engine->db->theme_url."icon/tabbg.png);' >";
	}
	else
	{
		echo "<div class='Tab$bonus' style='background-image:url(".$engine->db->theme_url."icon/tabbg".($bonus=="2a" ? "del" : "1").".png);'>";
	}

	$bonus2 = $bonus=="2a"?"del":"";

	echo '<table ><tr>';
	echo "<td><img src='".$engine->db->theme_url."icon/tabr$selected".$bonus2.".png' width='$xsize' align='top' height='$ysize' alt='' /></td>";

	if (!$selected)
	{
		echo "<td>";
	}
	else
	{
		echo '<td style="vertical-align:top;">';
	}

	echo "<div class='TabText'>".$text."</div>";
	echo "</td>";
	echo "<td><img src='".$engine->db->theme_url."icon/tabl$selected".$bonus2.".png' width='$xsize' align='top' height='$ysize' alt='' /></td>";
	echo '</tr></table>';
	echo "</div>";
}

?>
<div class="Footer">
<img src="<?php echo $this->db->base_url;?>image/spacer.png" width="5" height="1" alt="" align="left" />
<img src="<?php echo $this->db->base_url;?>image/spacer.png" width="5" height="1" alt="" align="right" />
<?php

// if this page exists
if ($this->page)
{
	if ($this->has_access('read'))
	{
		echo_tab(
		$this->href('show'),
		$this->_t('ShowTip'),
		$this->has_access('read') ? $this->_t('ShowText') : "",
		$this->method != 'show'
		);

		echo_tab(
		$this->href('edit'),
		$this->_t('EditTip'),
		$this->has_access('write') ? $this->_t('EditText') : "",
		$this->method != 'edit'
		);

		echo_tab(
		$this->href('revisions'),
		$this->_t('RevisionTip'),
		$this->page['modified'] ? $this->get_time_formatted($this->page['modified']) : "",
		$this->method != 'revisions'
		);

		if($this->has_access('write') && $this->get_user() || $this->is_admin())
		{
			echo_tab(
			$this->href('properties'),
			$this->_t('SettingsTip'),
			$this->_t('PropertiesText'),
			$this->method != 'properties'
			);
		}

		// if owner is current user
		if ($this->is_owner())
		{
			echo_tab(
			$this->href('permissions'),
			(($this->method=='edit')
				? "' onclick='return window.confirm(\"".$this->_t('EditACLConfirm')."\");"
				: ""),
			$this->_t('ACLText'),
			$this->method != 'permissions'
			);
		}

		if ($this->is_admin() || (!$this->db->remove_onlyadmins && $this->is_owner()))
		{
			echo_tab(
			$this->href('remove'),
			$this->_t('DeleteTip'),
			'<img src="'.$this->db->theme_url.'icon/del'.($this->method != 'remove' ? '' : '_').'.png" width="14" height="15" alt="" />'.$this->_t('DeleteText'),
			$this->method != 'remove',
			"2a"
			);
		}
	}

	if ($this->get_user())
	{
		echo_tab(
		$this->href('new'),
		$this->_t('CreateNewPage'),
		$this->has_access('write') ? $this->_t('CreateNewPage') : "",
		$this->method != 'new',
		"2"
		);
	}

	if ($this->get_user())
	{
		echo_tab(
		$this->href('referrers'),
		$this->_t('ReferrersTip'),
		$this->_t('ReferrersText'),
		$this->method != 'referrers',
		"2"
		);
	}
} ?>
<div class="TabSpace">
<div class="TabText" style="padding-left: 10px">
<?php
// if this page exists
if ($this->page)
{
	if ($this->has_access('read'))
	{
		// if owner is current user
		if ($this->is_owner())
		{
			echo $this->_t('YouAreOwner');
		}
		else
		{
			if ($owner = $this->get_page_owner())
			{
				if ($owner == 'System')
				{
					echo $this->_t('Owner').": ".$owner."\n";
				}
				else
				{
					echo $this->_t('Owner').": ".$this->user_link($owner, $lang = '', true, false)."\n";
				}
			}
			else if (!$this->page['comment_on_id'])
			{
				print($this->_t('Nobody').($this->get_user() ? " (<a href=\"".$this->href('claim')."\">".$this->_t('TakeOwnership')."</a>)" : ""));
			}
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
	if ($this->has_access('read') && $this->db->footer_files == 1 || ($this->db->footer_files == 2 && $this->get_user()))
	{
		require_once('handler/page/_files.php'); // TODO: HANDLER_DIR
	}

	// comments form output  starts
	if ($this->has_access('read') && ($this->db->footer_comments == 1 || ($this->db->footer_comments == 2 && $this->get_user()) ) && $this->user_allowed_comments())
	{
		require_once('handler/page/_comments.php'); // TODO
	}

	// rating form output begins
	if ($this->has_access('read') && $this->page && $this->db->footer_rating == 1 || ($this->db->footer_rating == 2 && $this->get_user()))
	{
		require_once('handler/page/_rating.php'); // TODO
	}

} //end of $this->method==show
?>
<!-- !!! -->

<div id="credits"><?php
if ($this->get_user())
{
	echo $this->_t('PoweredBy').' '.$this->link('WackoWiki:HomePage', '', 'WackoWiki');
}
?></div>
<?php

// don't place final </body></html> here. Wacko closes HTML automatically.

?>
