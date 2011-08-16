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
		echo "<div class='TabSelected$bonus' style='background-image:url(".$engine->config['theme_url']."icons/tabbg.gif);' >";
	}
	else
	{
		echo "<div class='Tab$bonus' style='background-image:url(".$engine->config['theme_url']."icons/tabbg".($bonus=="2a" ? "del" : "1").".gif);'>";
	}

	$bonus2 = $bonus=="2a"?"del":"";

	echo '<table cellspacing="0" cellpadding="0" border="0" ><tr>';
	echo "<td><img src='".$engine->config['theme_url']."icons/tabr$selected".$bonus2.".gif' width='$xsize' align='top' hspace='0' vspace='0' height='$ysize' alt='' border='0' /></td>";

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
	echo "<td><img src='".$engine->config['theme_url']."icons/tabl$selected".$bonus2.".gif' width='$xsize' align='top' hspace='0' vspace='0' height='$ysize' alt='' border='0' /></td>";
	echo '</tr></table>';
	echo "</div>";
}

?>
<div class="Footer">
<img src="<?php echo $this->config['base_url'];?>images/z.gif" width="5" height="1" alt="" align="left" border="0" />
<img src="<?php echo $this->config['base_url'];?>images/z.gif" width="5" height="1" alt="" align="right" border="0" />
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
			'<img src="'.$this->config['theme_url'].'icons/del'.($this->method != 'remove' ? '' : '_').'.gif" width="14" height="15" alt="" />'.$this->get_translation('DeleteText'),
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
				echo "<li>".$this->get_translation('Owner').": ".$owner."</li>\n";
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
	if ($this->has_access('read') && $this->config['footer_files'] == 1 && ($this->config['footer_files'] == 2 || $this->get_user()))
	{
		// store files display in session
		if (!isset($_SESSION[$this->config['session_prefix'].'_'.'show_files'][$this->page['page_id']]))
		{
			$_SESSION[$this->config['session_prefix'].'_'."show_files"][$this->page['page_id']] = ($this->user_wants_files() ? "1" : "0");
		}

		if(isset($_GET['show_files']))
		{
			switch($_GET['show_files'])
			{
				case "0":
					$_SESSION[$this->config['session_prefix'].'_'.'show_files'][$this->page['page_id']] = 0;
					break;
				case "1":
					$_SESSION[$this->config['session_prefix'].'_'.'show_files'][$this->page['page_id']] = 1;
					break;
			}
		}

		// display files!
		if ($this->page && $_SESSION[$this->config['session_prefix'].'_'.'show_files'][$this->page['page_id']])
		{
			// display files header
			?>
<div id="filesheader"><?php echo $this->get_translation('Files_all') ?> <?php echo "[<a href=\"".$this->href('', '', 'show_files=0')."\">".$this->get_translation('HideFiles')."</a>]"; ?>
</div>
			<?php

			echo "<div class=\"files\">";
			echo $this->action('files', array('nomark' => 1));
			echo "</div>";
			// display form
			echo "<div class=\"filesform\">\n";

			if ($user = $this->get_user())
			{
				$user_name	= strtolower($this->get_user_name());
				$registered	= true;
			}
			else
			{
				$user_name = GUEST;
			}

			if ($registered
				&&
				(
				($this->config['upload'] === true) || ($this->config['upload'] == 1) ||
				($this->check_acl($user_name, $this->config['upload']))
				)
			)
			{
				echo $this->action('upload', array('nomark' => 1));
			}

			echo "</div>\n";
		}
		else
		{
?>
<div id="filesheader">
<?php
if ($this->page['page_id'])
{
	$files = $this->load_all(
		"SELECT upload_id ".
		"FROM ".$this->config['table_prefix']."upload ".
		"WHERE page_id = '". quote($this->dblink, $this->page['page_id']) ."'");
}
else
{
	$files = array();
}

switch (count($files))
{
	case 0:
		echo $this->get_translation('Files_0');
		break;
	case 1:
		echo $this->get_translation('Files_1');
		break;
	default:
		print(str_replace('%1',count($files), $this->get_translation('Files_n')));
}

echo "[<a href=\"".$this->href('', '', 'show_files=1#filesheader')."\">".$this->get_translation('ShowFiles')."</a>]"; ?>

</div>
<?php
		}
	}
	// end files
	// comments code starts
	if ($this->has_access('read') && ( $this->config['footer_comments'] == 1 && ($this->config['footer_comments'] == 2 || $this->get_user()) ) && $this->user_allowed_comments() )
	{
		// load comments for this page
		$comments = $this->load_comments($this->page['page_id']);

		// store comments display in session
		if (!isset($_SESSION[$this->config['session_prefix'].'_'.'show_comments'][$this->page['page_id']]))
		{
			$_SESSION[$this->config['session_prefix'].'_'.'show_comments'][$this->page['page_id']] = ($this->user_wants_comments() ? "1" : "0");
		}

		switch(isset($_GET['show_comments']))
		{
			case "0":
				$_SESSION[$this->config['session_prefix'].'_'.'show_comments'][$this->page['page_id']] = 0;
				break;
			case "1":
				$_SESSION[$this->config['session_prefix'].'_'.'show_comments'][$this->page['page_id']] = 1;
				break;
		}

		// display comments!
		if ($this->page && $_SESSION[$this->config['session_prefix'].'_'.'show_comments'][$this->page['page_id']])
		{
			// display comments header
			?>
<div id="commentsheader"><?php echo $this->get_translation('Comments_all') ?>
			<?php echo "[<a href=\"".$this->href('', '', 'show_comments=0')."\">".$this->get_translation('HideComments')."</a>]"; ?>
</div>
			<?php

			// display comments themselves
			if ($comments)
			{
				foreach ($comments as $comment)
				{
					echo "<a name=\"".$comment['tag']."\"></a>\n";
					echo "<div class=\"comment\">\n";
					$del = '';

					if ($this->is_admin() || $this->user_is_owner($comment['page_id']) || ($this->config['owners_can_remove_comments'] && $this->user_is_owner($this->page['page_id'])))
					{
						echo "<div style=\"float:right;\" style='background:#ffcfa8; border: solid 1px; border-color:#cccccc'>".
							"<a href=\"".$this->href('remove', $comment['tag'])."\" title=\"".$this->get_translation('DeleteTip')."\">".
							"<img src=\"".$this->config['theme_url']."icons/delete.gif\" hspace=4 vspace=4 title=\"".$this->get_translation('DeleteText')."\" /></a>".
							"</div>";
					}

					echo $this->format($comment['body'])."\n";
					echo "<div class=\"commentinfo\">\n-- <a href=\"".$this->href('', $this->config['users_page'], 'profile='.$comment['user_name'])."\">".$comment['user_name']."</a> (".$comment['modified'].")\n</div>\n";
					echo "</div>\n";
				}
			}

			// display comment form
			if ($this->has_access('comment'))
			{
				echo "<div class=\"commentform\">\n";

				echo $this->get_translation('AddComment'); ?>
<br />
				<?php echo $this->form_open('addcomment'); ?>
<textarea name="body" rows="6" cols="7" style="width: 100%"><?php echo (isset($_SESSION[$this->config['session_prefix'].'_'.'freecap_old_comment']) ? $_SESSION[$this->config['session_prefix'].'_'.'freecap_old_comment'] : ''); ?></textarea>
				<?php
				// captcha code starts

				// Only show captcha if the admin enabled it in the config file
				if ($this->config['captcha_new_comment'])
				{
					$this->show_captcha(false);
				}
				// end captcha
				?>
<input type="submit" value="<?php echo $this->get_translation('AddCommentButton'); ?>" accesskey="s" />
				<?php echo $this->form_close();

				echo "</div>\n";
			}
			// end comment form
		}
		else
		{
			?>
<div id="commentsheader"><?php
switch (count($comments))
{
	case 0:
		echo $this->get_translation('Comments_0');
		break;
	case 1:
		echo $this->get_translation('Comments_1');
		break;
	default:
		echo str_replace('%1',count($comments), $this->get_translation('Comments_n'));
}

echo "[<a href=\"".$this->href('', '', 'show_comments=1#commentsheader')."\">".$this->get_translation('ShowComments')."</a>]"; ?>

</div>
<?php
		}
	}
	// comments end

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