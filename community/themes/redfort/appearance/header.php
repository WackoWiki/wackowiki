<?php
/*
Redfort theme.
Common footer file.

by Pavel Fedotov (me@fedotov.org).
*/

require ('themes/_common/_header.php');

?>
<body onload="all_init();">

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr align="left" valign="top" bgcolor="#990000">
    <td height="1"><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td align="left" valign="middle"><div class="header"><h1>
     <span class="main"><?php echo $this->config['site_name'] ?>:</span>
     <?php echo $this->get_page_path(); ?>
     <a class="Search" title="<?php echo $this->config['search_title_help']?>"
     href="<?php echo $this->config['base_url'].$this->get_translation('TextSearchPage').($this->config['rewrite_mode'] ? "?" : "&amp;");?>phrase=<?php echo urlencode($this->tag); ?>">...</a>
  </h1></div>
</td>
        </tr>
      </table></td>
  </tr>
  <tr align="left" valign="top" bgcolor="#990000">
    <td height="1" bgcolor="#6E0000"><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td align="left" valign="top" height="29"><div class="menu-top">
<?php
  echo $this->form_open('', $this->get_translation('LoginPage'), 'post'); ?>
<input type="hidden" name="action" value="login" />
  <?php
// Outputs Bookmarks AKA QuickLinks
  // Main page

  echo $this->compose_link_to_page($this->config['root_page']); ?> |
  <?php
  // All user's Bookmarks
  echo $this->format($this->get_bookmarks_formatted(), "post_wacko"); ?> |
<?php
  // Here Wacko determines what it should show: "add to Bookmarks" or "remove from Bookmarks" icon
if ($this->get_user())
{
 if (!in_array($this->tag, $this->get_bookmark_links()))
 {?>
  <a href="<?php echo $this->href('', '', "addbookmark=yes")?>"><img src="<?php echo $this->config['theme_url'] ?>icons/bookmark1.gif" alt="+" title="<?php echo $this->get_translation('AddToBookmarks') ?>" border="0" align="middle" /></a> |
  <?php
 } else { ?>
  <a href="<?php echo $this->href('', '', "removebookmark=yes")?>"><img src="<?php echo $this->config['theme_url'] ?>icons/bookmark2.gif" alt="-" title="<?php echo $this->get_translation('RemoveFromBookmarks') ?>" border="0" align="middle" /></a> |
  <?php
 }
}

// If user are logged, Wacko shows "You are UserName"
if ($this->get_user()) { ?>
   <span class="nobr"><?php echo $this->get_translation('YouAre')." ".$this->link($this->get_user_name()) ?></span>
   <small>( <span class="nobr Tune"><?php
      echo $this->compose_link_to_page($this->get_translation('AccountLink'), "", $this->get_translation('AccountText'), 0); ?> |
      <a onclick="return confirm('<?php echo $this->get_translation('LogoutAreYouSure');?>');" href="<?php echo $this->href('', $this->get_translation('LoginPage')).($this->config['rewrite_mode'] ? "?" : "&amp;");?>action=logout&amp;goback=<?php echo $this->slim_url($this->tag);?>"><?php echo $this->get_translation('LogoutLink'); ?></a></span> )</small>
<?php
// Else Wacko shows login's controls
} else {
?>
<span class="nobr"><input type="hidden" name="goback" value="<?php echo $this->slim_url($this->tag);?>"
/><strong><?php echo $this->get_translation('LoginWelcome') ?>:&nbsp;</strong><input
type="text" name="name" size="18" class="login" />&nbsp;<?php
echo $this->get_translation('LoginPassword') ?>:&nbsp;<input type="password" name="password"
class="login" size="8" />&nbsp;<input type="image"
src="<?php echo $this->config['theme_url'] ?>icons/login.gif" alt=">>>" align="top" /></span>
<?php
}
// End if
?>
</div>
<?php
// Closing Login form
echo $this->form_close();
?>

			</div>
			</td>
        </tr>
      </table>
    </td>
  </tr>
  <tr align="left" valign="top" bgcolor="#990000">
    <td height="1" background="<?php echo $this->config['theme_url']."icons/border_line.gif"; ?>"><img src="<?php echo $this->config['theme_url']."icons/border_line.gif"; ?>" width="4" height="5"></td>
  </tr>
  <tr align="left" valign="top" bgcolor="#990000">
    <td height="1" background="<?php echo $this->config['theme_url']."icons/top_line.gif"; ?>"><img src="<?php echo $this->config['theme_url']."icons/top_line.gif"; ?>" width="61" height="41"></td>
  </tr>
</table>
<?php
// here we show messages
if ($message = $this->get_message()) echo "<div class=\"info\">$message</div>";
?>
