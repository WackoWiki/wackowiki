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
	if (!$selected) echo "<div class='TabSelected$bonus' style='background-image:url(".$engine->config['theme_url']."icons/tabbg.gif);' >";
	else echo "<div class='Tab$bonus' style='background-image:url(".$engine->config['theme_url']."icons/tabbg".($bonus=="2a" ? "del" : "1").".gif);'>";
	$bonus2 = $bonus=="2a"?"del":"";

	echo '<table cellspacing="0" cellpadding="0" border="0" ><tr>';
	echo "<td><img src='".
	$engine->config['theme_url'].
		"icons/tabr$selected".$bonus2.".gif' width='$xsize' align='top' hspace='0' vspace='0' height='$ysize' alt='' border='0' /></td>";
	if (!$selected) echo "<td>"; else echo "<td valign='top'>";
	echo "<div class='TabText'>".$text."</div>";
	echo "</td>";
	echo "<td><img src='".
	$engine->config['theme_url'].
		"icons/tabl$selected".$bonus2.".gif' width='$xsize' align='top' hspace='0' vspace='0' height='$ysize' alt='' border='0' /></td>";
	echo '</tr></table>';
	echo "</div>";
}
/*
 Coming out of the function we can continue using "$this->" because we return to the main object context.

 Elar9000 (2009.08.16)
 */

?>
<div class="Footer"><img
	src="<?php echo $this->config['base_url'];?>images/z.gif"
	width="5" height="1" alt="" align="left" border="0" /><img
	src="<?php echo $this->config['base_url'];?>images/z.gif"
	width="5" height="1" alt="" align="right" border="0" /> <?php echo_tab( $this->href('show'),  $this->get_translation('ShowTip'),
	$this->has_access('read') ? $this->get_translation('ShowText') : "",
	$this->method != 'show'
	) ?> <?php echo_tab( $this->href('edit'),  $this->get_translation('EditTip'),
	$this->has_access('write') ? $this->get_translation('EditText') : "",
	$this->method != 'edit'
	) ?> <?php echo_tab( $this->href('revisions'),  $this->get_translation('RevisionTip'),
	$this->page['modified'] ? $this->get_page_time_formatted() : "",
	$this->method != 'revisions'
	) ?> <?php
	// if this page exists
	if ($this->page)
	{
		if($this->has_access('write') && $this->get_user() || $this->is_admin())
		{
			echo_tab( $this->href('properties'),  $this->get_translation('SettingsTip'),
			$this->get_translation('PropertiesText'),
			$this->method != 'properties'
			);
		}

		// if owner is current user
		if ($this->user_is_owner())
		{
			echo_tab( $this->href('permissions'),  "".(($this->method=='edit')?"' onclick='return window.confirm(\"".$this->get_translation('EditACLConfirm')."\");":""),
			$this->get_translation('ACLText'),
			$this->method != 'permissions'
			);
		}
		if ($this->is_admin() || (!$this->config['remove_onlyadmins'] && $this->user_is_owner()))
		{
			echo_tab( $this->href('remove'),  $this->get_translation('DeleteTip')."",
				'<img src="'.$this->config['theme_url'].'icons/del'.($this->method != 'remove' ? '' : '_').'.gif" width="14" height="15" alt="" />'.$this->get_translation('DeleteText'),
			$this->method != 'remove',
				"2a"
				);
		}
	}
	?>
	<?php
	if ($this->get_user())
	{
		echo_tab( $this->href('new'), $this->get_translation('CreateNewPage'),
		$this->has_access('write') ? $this->get_translation('CreateNewPage') : "",
		$this->method != 'new',
		"2"
		);
	} ?>
	<?php
	if ($this->get_user())
	{
		echo_tab( $this->href('referrers'), $this->get_translation('ReferrersTip'),
		$this->get_translation('ReferrersText'),
		$this->method != 'referrers',
		"2"
		);
	} ?>
<div class="TabSpace">
<div class="TabText" style="padding-left: 10px"><?php
// if this page exists
if ($this->page)
{
	// if owner is current user
	if ($this->user_is_owner())
	print($this->get_translation('YouAreOwner'));
	else
	if ($owner = $this->get_page_owner())
	print($this->get_translation('Owner').": ".$this->link($owner));
	else if (!$this->page['comment_on_id'])
	print($this->get_translation('Nobody').($this->get_user() ? " (<a href=\"".$this->href('claim')."\">".$this->get_translation('TakeOwnership')."</a>)" : ""));
}
?></div>
</div>
</div>
</div>
<!-- !! -->
<?php
if ($this->method == 'show') {


	// files code starts
	if ($this->has_access('read') && $this->config['hide_files'] != 1 && ($this->config['hide_files'] != 2 || $this->get_user()))
	{
		// store files display in session
		$tag = $this->tag;
		if (!isset($_SESSION[$this->config['session_prefix'].'_'."show_files"][$tag]))
		$_SESSION[$this->config['session_prefix'].'_'."show_files"][$tag] = ($this->user_wants_files() ? "1" : "0");

		switch(isset($_GET['show_files']))
		{
			case "0":
				$_SESSION[$this->config['session_prefix'].'_'."show_files"][$tag] = 0;
				break;
			case "1":
				$_SESSION[$this->config['session_prefix'].'_'."show_files"][$tag] = 1;
				break;
		}

		// display files!
		if ($this->page && $_SESSION[$this->config['session_prefix'].'_'."show_files"][$tag])
		{
			// display files header
			?>
<a name="files"></a>
<div id="filesheader"><?php echo $this->get_translation('Files_all') ?> <?php echo "[<a href=\"".$this->href('', '', 'show_files=0')."\">".$this->get_translation('HideFiles')."</a>]"; ?>
</div>
			<?php

			echo "<div class=\"files\">";
			echo $this->action('files', array('nomark' => 1));
			echo "</div>";
			// display form
			print("<div class=\"filesform\">\n");
			if ($user = $this->get_user())
			{
				$user = strtolower($this->get_user_name());
				$registered = true;
			}
			else
			$user = GUEST;

			if ($registered
			&&
			(
			($this->config['upload'] === true) || ($this->config['upload'] == 1) ||
			($this->check_acl($user,$this->config['upload']))
			)
			)
			echo $this->action('upload', array('nomark' => 1));
			print("</div>\n");
		}
		else
		{
			?>
<div id="filesheader"><?php
if ($this->page['page_id'])
$files = $this->load_all(
		"SELECT upload_id ".
		"FROM ".$this->config['table_prefix']."upload ".
		"WHERE page_id = '". quote($this->dblink, $this->page['page_id']) ."'");
else $files = array();

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
?> <?php echo "[<a href=\"".$this->href('', '', 'show_files=1#files')."\">".$this->get_translation('ShowFiles')."</a>]"; ?>

</div>
<?php
		}
	}
	// end files
	// comments code starts
	if ($this->has_access('read') && $this->config['hide_comments'] != 1 && ($this->config['hide_comments'] != 2 || $this->get_user()))
	{
		// load comments for this page
		$comments = $this->load_comments($this->page['page_id']);

		// store comments display in session
		$tag = $this->tag;
		if (!isset($_SESSION[$this->config['session_prefix'].'_'."show_comments"][$tag]))
		$_SESSION[$this->config['session_prefix'].'_'."show_comments"][$tag] = ($this->user_wants_comments() ? "1" : "0");

		switch(isset($_GET['show_comments']))
		{
			case "0":
				$_SESSION[$this->config['session_prefix'].'_'."show_comments"][$tag] = 0;
				break;
			case "1":
				$_SESSION[$this->config['session_prefix'].'_'."show_comments"][$tag] = 1;
				break;
		}

		// display comments!
		if ($this->page && $_SESSION[$this->config['session_prefix'].'_'."show_comments"][$tag])
		{
			// display comments header
			?>
<a name="comments"></a>
<div id="commentsheader"><?php echo $this->get_translation('Comments_all') ?>
			<?php echo "[<a href=\"".$this->href('', '', 'show_comments=0')."\">".$this->get_translation('HideComments')."</a>]"; ?>
</div>
			<?php

			// display comments themselves
			if ($comments)
			{
				foreach ($comments as $comment)
				{
					print("<a name=\"".$comment['tag']."\"></a>\n");
					print("<div class=\"comment\">\n");
					$del = '';
					if ($this->is_admin() || $this->user_is_owner($comment['page_id']) || ($this->config['owners_can_remove_comments'] && $this->user_is_owner($this->page['page_id'])))
					print("<div style=\"float:right;\" style='background:#ffcfa8; border: solid 1px; border-color:#cccccc'>".
				"<a href=\"".$this->href('remove', $comment['tag'])."\" title=\"".$this->get_translation('DeleteTip')."\">".
				"<img src=\"".$this->config['theme_url']."icons/delete.gif\" hspace=4 vspace=4 title=\"".$this->get_translation('DeleteText')."\" /></a>".
				"</div>");
					print($this->format($comment['body'])."\n");
					print("<div class=\"commentinfo\">\n-- ".($this->is_wiki_name($comment['user']) ? $this->link('/'.$comment['user'], '', $comment['user']) : $comment['user'])." (".$comment['modified'].")\n</div>\n");
					print("</div>\n");
				}
			}

			// display comment form
			if ($this->has_access('comment'))
			{
				print("<div class=\"commentform\">\n");

				echo $this->get_translation('AddComment'); ?>
<br />
				<?php echo $this->form_open('addcomment'); ?>
<textarea name="body" rows="6" cols="7" style="width: 100%"><?php echo $_SESSION[$this->config['session_prefix'].'_'.'freecap_old_comment']; ?></textarea>
				<?php
				// captcha code starts

				// Only show captcha if the admin enabled it in the config file
				if ($this->config['captcha_new_comment'])
				{
					// Don't load the captcha at all if the GD extension isn't enabled
					if (extension_loaded('gd'))
					{
						#if(strpos($this->get_user_name(), '.'))
						if ($this->get_user_name()== false)
						{
							?>
<label for="captcha"><?php echo $this->get_translation('Captcha');?>:</label>
<br />
<img
	src="<?php echo $this->config['base_url'];?>lib/captcha/freecap.php"
	id="freecap" alt="<?php echo $this->get_translation('Captcha');?>" />
<a href="" onclick="this.blur(); new_freecap(); return false;"
	title="<?php echo $this->get_translation('CaptchaReload'); ?>"><img
	src="<?php echo $this->config['base_url'];?>images/reload.png"
	width="18" height="17"
	alt="<?php echo $this->get_translation('CaptchaReload'); ?>" /></a>
<br />
<input id="captcha" type="text" name="word"
	maxlength="6" style="width: 273px;" />
<br />
<br />
							<?php
						}
					}
				}
				// end captcha
				?>
<input type="submit"
	value="<?php echo $this->get_translation('AddCommentButton'); ?>"
	accesskey="s" />
				<?php echo $this->form_close(); ?>
				<?php
				print("</div>\n");
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
		print($this->get_translation('Comments_0'));
		break;
	case 1:
		print($this->get_translation('Comments_1'));
		break;
	default:
		print(str_replace('%1',count($comments), $this->get_translation('Comments_n')));
}
?> <?php echo "[<a href=\"".$this->href('', '', 'show_comments=1#comments')."\">".$this->get_translation('ShowComments')."</a>]"; ?>

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
	echo $this->get_translation('PoweredBy').' '.$this->link('WackoWiki:HomePage', '', 'WackoWiki '.$this->get_wacko_version())." :: Redesign by Mendokusee";
}
?></div>
<?php

// don't place final </body></html> here. Wacko closes HTML automatically.

?>