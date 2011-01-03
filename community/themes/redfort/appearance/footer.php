<?php
/*
Default theme.
Common footer file.

Updated by Pavel Fedotov.
*/
?>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="1" align="left" valign="top" background="<?php echo $this->config['theme_url']."icons/bottom_line.gif"; ?>"><img src="<?php echo $this->config['theme_url']."icons/bottom_line.gif"; ?>" width="61" height="41"></td>
  </tr>
  <tr>
    <td align="left" valign="top" bgcolor="#990000">

<!-- !! -->
<?php
  if ($this->method == 'show') {
?>
<?php
if ($this->has_access('read') && $this->config['hide_files'] != 1)
{
  // store files display in session
  $tag = $this->tag;
  if (!isset($_SESSION['show_files'][$tag]))
    $_SESSION['show_files'][$tag] = ($this->user_wants_files() ? "1" : "0");

  switch($_GET['show_files'])
  {
  case "0":
    $_SESSION['show_files'][$tag] = 0;
    break;
  case "1":
    $_SESSION['show_files'][$tag] = 1;
    break;
  }

  // display files!
  if ($this->page && $_SESSION['show_files'][$tag])
  {
    // display files header
    ?>
    <a name="files"></a>
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td height="29" bgcolor="#6E0000">
    <div id="filesheader">
      <?php echo $this->get_translation('Files_all') ?> [<a href="<?php echo $this->href('', '', 'show_files=0')."\">".$this->get_translation('HideFiles'); ?></a>]
    </div>
	</td>
        </tr>
        <tr>
          <td height="1" align="left" valign="top" background="<?php echo $this->config['theme_url']."icons/border_line.gif"; ?>"><img src="<?php echo $this->config['theme_url']."icons/border_line.gif"; ?>" width="4" height="5"></td>
        </tr>
      </table>
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
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td height="29" bgcolor="#6E0000">
    <div id="filesheader">
    <?php
      if ($this->page['page_id'])
       $files = $this->load_all( "SELECT upload_id FROM ".$this->config['table_prefix']."upload WHERE ".
                             " page_id = '". quote($this->dblink, $this->page['page_id']) ."'");
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
    ?>

    [<a href="<?php echo $this->href('', '', 'show_files=1#files')."\">".$this->get_translation('ShowFiles'); ?></a>]

    </div>	</td>
        </tr>
        <tr>
          <td height="1" align="left" valign="top" background="<?php echo $this->config['theme_url']."icons/border_line.gif"; ?>"><img src="<?php echo $this->config['theme_url']."icons/border_line.gif"; ?>" width="4" height="5"></td>
        </tr>
      </table>
    <?php
  }
}
?>

<?php
if ($this->has_access('read') && $this->config['hide_comments'] != 1)
{
  // load comments for this page
  $comments = $this->load_comments($this->page['page_id']);

  // store comments display in session
  $tag = $this->tag;
  if (!isset($_SESSION['show_comments'][$tag]))
    $_SESSION['show_comments'][$tag] = ($this->user_wants_comments() ? "1" : "0");

  switch($_GET['show_comments'])
  {
  case "0":
    $_SESSION['show_comments'][$tag] = 0;
    break;
  case "1":
    $_SESSION['show_comments'][$tag] = 1;
    break;
  }

  // display comments!
  if ($this->page && $_SESSION['show_comments'][$tag])
  {
    // display comments header
    ?>
    <a name="comments"></a>
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td height="29" bgcolor="#6E0000">    <div id="commentsheader">
      <?php echo $this->get_translation('Comments_all') ?> [<a href="<?php echo $this->href('', '', 'show_comments=0')."\">".$this->get_translation('HideComments'); ?></a>]
    </div></td>
        </tr>
        <tr>
          <td height="1" align="left" valign="top" background="<?php echo $this->config['theme_url']."icons/border_line.gif"; ?>"><img src="<?php echo $this->config['theme_url']."icons/border_line.gif"; ?>" width="4" height="5"></td>
        </tr>
      </table>
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
          "<img src=\"".$this->config['theme_url']."icons/delete.gif\" hspace=4 vspace=4 title=\"".$this->get_translation('DeleteText')."\"  align=\"absmiddle\" border=\"0\" /></a>".
          "</div>");
        print($this->format($comment['body'])."\n");
        print("<div class=\"commentinfo\">\n-- ".($this->is_wiki_name($comment['user']) ? $this->link('/'.$comment['user'], '', $comment['user']) : $comment['user'])." (".$comment['time'].")\n</div>\n");
        print("</div>\n");
      }
    }

    // display comment form
    print("<div class=\"commentform\">\n");
    if ($this->has_access('comment'))
    {
      ?>
        <?php echo $this->get_translation('AddComment'); ?><br />
        <?php echo $this->form_open('addcomment'); ?>
          <textarea name="body" rows="6" style="width: 95%"></textarea><br />
          <input type="submit" value="<?php echo $this->get_translation('AddCommentButton'); ?>" accesskey="s" />
        <?php echo $this->form_close(); ?>
      <?php
    }
    print("</div>\n");
  }
  else
  {
    ?>
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td height="29" bgcolor="#6E0000">    <div id="commentsheader">
    <?php
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
    ?>

    [<a href="<?php echo $this->href('', '', 'show_comments=1#comments')."\">".$this->get_translation('ShowComments'); ?></a>]

    </div></td>
        </tr>
        <tr>
          <td height="1" align="left" valign="top" background="<?php echo $this->config['theme_url']."icons/border_line.gif"; ?>"><img src="<?php echo $this->config['theme_url']."icons/border_line.gif"; ?>" width="4" height="5"></td>
        </tr>
      </table>
    <?php
  }
}
?>

<?php } //end of $this->method==show
?>
<!-- !!! -->
<?php
// Opens Search form
echo $this->form_open('', $this->get_translation('TextSearchPage'), 'get'); ?>
<div class="footer">
<?php

// If User has rights to edit page, show Edit link
echo $this->has_access('write') ? "<a href=\"".$this->href('edit')."\" accesskey=\"E\" title=\"".$this->get_translation('EditTip')."\">".$this->get_translation('EditText')."</a> |\n" : "";

// Revisions link
echo $this->page['modified'] ? "<a href=\"".$this->href('revisions')."\" title=\"".$this->get_translation('RevisionTip')."\">".$this->get_page_time_formatted()."</a> |\n" : "";

// If this page exists
if ($this->page)
{
 // If owner is current user
 if ($this->user_is_owner())
 {
   print($this->get_translation('YouAreOwner'));

   // Rename link
   print(" <a href=\"".$this->href('rename')."\"><img src=\"".$this->config['theme_url']."icons/rename.gif\" title=\"".$this->get_translation('RenameText')."\" alt=\"".$this->get_translation('RenameText')."\" align=\"middle\" border=\"0\" /></a>");
//   if (!$this->config['remove_onlyadmins'] || $this->is_admin()) print(" <a href=\"".$this->href('remove')."\"><img src=\"".$this->config['theme_url']."icons/delete.gif\" title=\"".$this->get_translation('DeleteTip')."\" alt=\"".$this->get_translation('DeleteText')."\" align=\"middle\" border=\"0\" /></a>");

   //Edit ACLs link
   print(" | <a href=\"".$this->href('permissions')."\"".(($this->method=='edit')?" onclick=\"return window.confirm('".$this->get_translation('EditACLConfirm')."');\"":"").">".$this->get_translation('ACLText')."</a>");
 }
 // If owner is NOT current user
 else
 {
   // Show Owner of this page
   if ($owner = $this->get_page_owner())
   {
     print($this->get_translation('Owner').": ".$this->link($owner));
   } else if (!$this->page['comment_on_id']) {
     print($this->get_translation('Nobody').($this->get_user() ? " (<a href=\"".$this->href('claim')."\">".$this->get_translation('TakeOwnership')."</a>)" : ""));
   }
 }

 // Rename link
 if ($this->check_acl($this->get_user_name(),$this->config['rename_globalacl']) && !$this->user_is_owner())
 {
   print(" <a href=\"".$this->href('rename')."\"><img src=\"".$this->config['theme_url']."icons/rename.gif\" title=\"".$this->get_translation('RenameText')."\" alt=\"".$this->get_translation('RenameText')."\" align=\"middle\" border=\"0\" /></a>");
 }

 // Remove link (shows only for Admins)
 if ($this->is_admin())
 {
   print(" <a href=\"".$this->href('remove')."\"><img src=\"".$this->config['theme_url']."icons/delete.gif\" title=\"".$this->get_translation('DeleteTip')."\" alt=\"".$this->get_translation('DeleteText')."\"  align=\"middle\" border=\"0\" /></a>");
 }

 // Page  settings link
 print(" | <a href=\"".$this->href('properties'). "\"".(($this->method=='edit')?" onclick=\"return window.confirm('".$this->get_translation('EditACLConfirm')."');\"":"").">".$this->get_translation('SettingsText')."</a> | ");
// print("<a href=\"".$this->href('referrers')."\"><img src=\"".$this->config['theme_url']."icons/referer.gif\" title=\"".$this->get_translation('ReferrersTip')."\" alt=\"".$this->get_translation('ReferrersText')."\" border=\"0\" align=\"middle\" /></a> |");
}
?>
<?php
// Watch/Unwatch icon
echo ($this->iswatched === true ? "<a href=\"".$this->href('watch')."\"><img src=\"".$this->config['theme_url']."icons/unwatch.gif\" title=\"".$this->get_translation('RemoveWatch')."\" alt=\"".$this->get_translation('RemoveWatch')."\"  align=\"middle\" border=\"0\" /></a>" : "<a href=\"".$this->href('watch')."\"><img src=\"".$this->config['theme_url']."icons/watch.gif\" title=\"".$this->get_translation('SetWatch')."\" alt=\"".$this->get_translation('SetWatch')."\"  align=\"middle\" border=\"0\" /></a>" )
?> |
<?php
// Print icon
echo"<a href=\"".$this->href('print')."\" target=\"_blank\"><img src=\"".$this->config['theme_url']."icons/print.gif\" title=\"".$this->get_translation('PrintVersion')."\" alt=\"".$this->get_translation('PrintVersion')."\"  align=\"middle\" border=\"0\" /></a>";

// Searchbar
?> |
  <span class="searchbar nobr"><?php echo $this->get_translation('SearchText') ?><input type="text" name="phrase" size="15" style="border: none; border-bottom: 1px solid #CCCCAA; padding: 0px; margin: 0px;" /></span>
<?php

// Search form close
echo $this->form_close();
?>
</div>
<div id="credits"><?php
if ($this->get_user()){
	echo $this->get_translation('PoweredBy').' '.$this->link('WackoWiki:HomePage', '', 'WackoWiki '.$this->get_wacko_version());
}
?>
</div>
	  </td>
  </tr>
</table>

<?php

// Don't place final </body></html> here. Wacko closes HTML automatically.
?>