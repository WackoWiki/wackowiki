<?php
/*
Samsra theme.
Common header file.
*/

require ('themes/_common/_header.php');

?>
<body onload="all_init();">

<div class="header">
<?php
// Outputs page title
?>
<table align="center" border="0" cellpadding="0" cellspacing="0" width="100%">
	<tr>
  		<td>
<!-- <h1>-->
     <span class="main"><?php echo $this->config['site_name'] ?>:</span>
     <span class="pagetitle"><?php echo $this->get_page_path(); ?></span>
     <a class="Search" title="<?php echo $this->get_translation('SearchTitleTip')?>"
     href="<?php echo $this->config['base_url'].$this->get_translation('TextSearchPage').($this->config['rewrite_mode'] ? "?" : "&amp;");?>phrase=<?php echo urlencode($this->tag); ?>">...</a><br />
<!-- </h1> -->
</td><td>
<?php
/*
Samsra theme.

Commented by Roman Ivanov.
*/

// Opens Search form
echo $this->form_open('', $this->get_translation('TextSearchPage'), 'get'); ?>
<div align="right">
<?php
// Searchbar
?>
  <span><?php echo $this->get_translation('SearchText') ?><input type="text" name="phrase" size="15" style="border: none; border-bottom: 1px solid #CCCCAA; padding: 0px; margin: 0px;" /><input  class="submitinput" type="submit" value="&raquo;" alt="<?php echo $this->get_translation('SearchButtonText'); ?>!" title="<?php echo $this->get_translation('SearchButtonText'); ?>!" /></span>
</div>
<?php

// Search form close
echo $this->form_close();
?>
</td>
	</tr>
</table>
<?php
// Begin Login form
echo $this->form_open('', $this->get_translation('LoginPage'), 'post'); ?>
      <input type="hidden" name="action" value="login" />
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>
      <?php
// Outputs Bookmarks AKA QuickLinks
  // Main page
  echo $this->compose_link_to_page($this->config['root_page']); ?>
|
<?php
  // All user's Bookmarks
  echo $this->format($this->get_bookmarks_formatted(), "post_wacko"); ?>
|
<?php
  // Here Wacko determines what it should show: "add to Bookmarks" or "remove from Bookmarks" icon
if ($this->get_user())
{
 if (!in_array($this->tag, $this->get_bookmark_links()))
 {?>
<a href="<?php echo $this->href('', '', "addbookmark=yes")?>"><img src="<?php echo $this->config['theme_url'] ?>icons/bookmark1.gif" alt="+" title="<?php echo $this->get_translation('AddToBookmarks') ?>" /></a>
<?php
 } else { ?>
<a href="<?php echo $this->href('', '', "removebookmark=yes")?>"><img src="<?php echo $this->config['theme_url'] ?>icons/bookmark2.gif" alt="-" title="<?php echo $this->get_translation('RemoveFromBookmarks') ?>" /></a><?php  }
} ?></td>
    <td align="right"><?php


// If user are logged, Wacko shows "You are UserName"
if ($this->get_user()) { ?>
      <span class="nobr"><?php echo $this->get_translation('YouAre')." ".$this->link($this->config['users_page'].'/'.$this->get_user_name(), '', $this->get_user_name()) ?></span> <small>( <span class="nobr Tune">
      <?php
      echo $this->compose_link_to_page($this->get_translation('AccountLink'), "", $this->get_translation('AccountText'), 0); ?>
| <a onclick="return confirm('<?php echo $this->get_translation('LogoutAreYouSure');?>');" href="<?php echo $this->href('', $this->get_translation('LoginPage')).($this->config['rewrite_mode'] ? "?" : "&amp;");?>action=logout&amp;goback=<?php echo $this->slim_url($this->tag);?>"><?php echo $this->get_translation('LogoutLink'); ?></a></span> )</small>
      <?php
// Else Wacko shows login's controls
} else {
?>
      <span class="nobr">
      <input type="hidden" name="goback" value="<?php echo $this->slim_url($this->tag);?>"
/>
      <strong><?php echo $this->get_translation('LoginWelcome') ?>:&nbsp;</strong>
      <input
type="text" name="name" size="18" class="login" />
      &nbsp;
      <?php
echo $this->get_translation('LoginPassword') ?>
      :&nbsp;
      <input type="password" name="password"
class="login" size="8" />
      &nbsp;
      <input name="image" type="image"
src="<?php echo $this->config['theme_url'] ?>icons/login.gif" alt=">>>" align="top" />
      </span>
      <?php
}
// End if
?></td>
  </tr>
</table>
<?php
// Closing Login form
echo $this->form_close();
?>
</div>
<?php
// here we show messages
if ($message = $this->get_message()) echo "<div class=\"info\">$message</div>";
?>