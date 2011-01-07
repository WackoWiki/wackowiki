<?php
/*
Samsra theme.
Common header file.
*/

// HTTP header with right Charset settings
  header("Content-Type: text/html; charset=".$this->get_charset());
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->page['lang'] ?>" lang="<?php echo $this->page['lang'] ?>">
<head>
  <title><?php
// Echoes Title of the page.
  echo htmlspecialchars($this->config['wacko_name'])." : ".(isset($this->page['title']) ? $this->page['title'] : $this->add_spaces($this->tag)).($this->method != 'show' ? ' ('.$this->method.')' : '');
?></title>
<?php
// We don't need search robots to index subordinate pages, if indexing is disabled globally or per page
if ($this->method != 'show' || $this->page['latest'] == 0 || $this->config['noindex'] == 1 || $this->page['noindex'] == 1)
	echo "	<meta name=\"robots\" content=\"noindex, nofollow\" />\n";
?>
  <meta name="keywords" content="<?php echo $this->get_keywords(); ?>" />
  <meta name="description" content="<?php echo $this->get_description(); ?>" />
  <meta name="language" content="<?php echo $this->page['lang'] ?>" />
  <meta http-equiv="content-type" content="text/html; charset=<?php echo $this->get_charset(); ?>" />
  <link rel="stylesheet" type="text/css" href="<?php echo $this->config['theme_url'] ?>css/default.css" />
  <?php if ($this->config['allow_x11colors']) {?><link rel="stylesheet" type="text/css" href="<?php echo $this->config['base_url'] ?>themes/_common/X11colors.css" /><?php } ?>
  <link rel="shortcut icon" href="<?php echo $this->config['theme_url'] ?>icons/favicon.ico" type="image/x-icon" />
  <link rel="alternate" type="application/rss+xml" title="<?php echo $this->get_translation('RecentChangesRSS');?>" href="<?php echo $this->config['base_url'];?>xml/changes_<?php echo preg_replace('/[^a-zA-Z0-9]/', '', strtolower($this->config['wacko_name']));?>.xml" />
  <link rel="alternate" type="application/rss+xml" title="<?php echo $this->get_translation('RecentCommentsRSS');?>" href="<?php echo $this->config['base_url'];?>xml/comments_<?php echo preg_replace('/[^a-zA-Z0-9]/', '', strtolower($this->config['wacko_name']));?>.xml" />
  <link rel="alternate" type="application/rss+xml" title="<?php echo $this->get_translation('HistoryRevisionsRSS');?><?php echo $this->tag; ?>" href="<?php echo $this->href('revisions.xml');?>" />
<?php
// JS files.
// default.js contains common procedures and should be included everywhere
?>
  <script type="text/javascript" src="<?php echo $this->config['base_url'];?>js/default.js"></script>
<?php
// load swfobject with flash action (e.g. $this->config['allow_swfobject'] = 1), by default it is set off
if ($this->config['allow_swfobject'])
{
	echo "  <script type=\"text/javascript\" src=\"".$this->config['base_url']."js/swfobject.js\"></script>\n";
}
// autocomplete.js, protoedit & wikiedit2.js contain classes for WikiEdit editor. We may include them only on method==edit pages.
if ($this->method == 'edit')
{
	echo "  <script type=\"text/javascript\" src=\"".$this->config['base_url']."js/protoedit.js\"></script>\n";
	echo "  <script type=\"text/javascript\" src=\"".$this->config['base_url']."js/wikiedit2.js\"></script>\n";
	echo "  <script type=\"text/javascript\" src=\"".$this->config['base_url']."js/autocomplete.js\"></script>\n";
}
?>
	<script type="text/javascript" src="<?php echo $this->config['base_url'];?>js/captcha.js"></script>
<?php
// Doubleclick edit feature.
// Enabled only for registered users who don't swith it off (requires class=page in show handler).
if ($user = $this->get_user())
   {
      if ($user['doubleclick_edit'] == 1)
         {
?>
  <script type="text/javascript">
   var edit = "<?php echo $this->href('edit');?>";
  </script>
<?php
         }
   }
else if($this->has_access('write'))
   {
?>

      <script type="text/javascript">
      var edit = "<?php echo $this->href('edit');?>";
     </script>
<?php
   }
?>
</head>

<?php
// all_init() initializes all js features:
//   * WikiEdit
//   * Doubleclick editing
//   * Smooth scrolling

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
     <span class="main"><?php echo $this->config['wacko_name'] ?>:</span>
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
      <span class="nobr"><?php echo $this->get_translation('YouAre')." ".$this->link($this->get_user_name()) ?></span> <small>( <span class="nobr Tune">
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