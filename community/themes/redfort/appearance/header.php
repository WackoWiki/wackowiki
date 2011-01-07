<?php
/*
Redfort theme.
Common footer file.

by Pavel Fedotov (me@fedotov.org).
*/

// HTTP header with right Charset settings
  header("Content-Type: text/html; charset=".$this->get_charset());
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
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
  <link media="print" rel="stylesheet" type="text/css" href="<?php echo $this->config['theme_url'] ?>css/print.css" />
  <link rel="shortcut icon" href="<?php echo $this->config['theme_url'] ?>icons/favicon.ico" type="image/x-icon" />
  <link title="<?php echo $this->config['root_page'];?>" href="<?php echo $this->config['base_url'];?>" rel="start"/>
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

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr align="left" valign="top" bgcolor="#990000">
    <td height="1"><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td align="left" valign="middle"><div class="header"><h1>
     <span class="main"><?php echo $this->config['wacko_name'] ?>:</span>
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
