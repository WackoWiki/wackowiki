<?php
/*
Ginko theme.
Common header file.
*/

// HTTP header with right Charset settings
  header("Content-Type: text/html; charset=".$this->get_charset());
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->page['lang'] ?>" lang="<?php echo $this->page['lang'] ?>">
<head>
<title>
<?php
// Echoes Title of the page.
  echo htmlspecialchars($this->config['wacko_name'])." : ".(isset($this->page['title']) ? $this->page['title'] : $this->add_spaces($this->tag)).($this->method != 'show' ? ' ('.$this->method.')' : '');
?>
</title>
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
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="378" valign="bottom" style="white-space: nowrap;"><span class="main"><a href="<?php echo $this->config['base_url']?>"class="main"><?php echo $this->config['wacko_name'] ?></a></span></td>
    <td width="100%"><div align="right"><?php
// Opens Search form
echo $this->form_open('', $this->get_translation('TextSearchPage'), 'get');

// Searchbar
?>
<span class="searchbar nobr"><label for="phrase"><?php echo $this->get_translation('SearchText'); ?></label><input
	type="text" name="phrase" id="phrase" size="15" /><input class="submitinput" type="submit" title="<?php echo $this->get_translation('SearchButtonText') ?>" alt="<?php echo $this->get_translation('SearchButtonText') ?>" value="»"/></span>
<?php

// Search form close
echo $this->form_close();
?></div></td>
  </tr>
  <tr>
    <td valign="top"><div class="tagline"><?php $this->config['wacko_desc']; ?></div></td>
    <td width="100%">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" bgcolor="#5C743D"></td>
  </tr>
  <tr>
    <td colspan="2" bgcolor="#85a43c"></td>
  </tr>
  <tr bgcolor="#85a43c">
    <td height="20" colspan="2"><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td><div class="navText"><strong><?php echo $this->compose_link_to_page($this->config['root_page']);?>:</strong> <?php echo $this->get_page_path(); ?> <a title="<?php echo $this->get_translation('SearchTitleTip')?>"
     href="<?php echo $this->config['base_url'].$this->get_translation('TextSearchPage').($this->config['rewrite_mode'] ? "?" : "&amp;");?>phrase=<?php echo urlencode($this->tag); ?>">...</a></div></td>
          <td align="right"><?php
// If user are logged, Wacko shows "You are UserName"
if ($this->get_user())
{
?>
            <span class="nobr"><?php echo $this->get_translation('YouAre')." ".$this->link($this->get_user_name()) ?></span> <small>( <span class="nobr Tune">
<?php
      echo $this->compose_link_to_page($this->get_translation('AccountLink'), "", $this->get_translation('AccountText'), 0); ?>
            | <a onclick="return confirm('<?php echo $this->get_translation('LogoutAreYouSure');?>');" href="<?php echo $this->href('', $this->get_translation('LoginPage')).($this->config['rewrite_mode'] ? "?" : "&amp;");?>action=logout&amp;goback=<?php echo $this->slim_url($this->tag);?>"><?php echo $this->get_translation('LogoutLink'); ?></a></span> )</small>
<?php
// Else Wacko shows login's controls
}
// End if
?></td>
        </tr>
<?php
// Closing Login form, If user are logged
# if ($this->get_user()) {
# echo $this->form_close();
# }
// End if
?>
      </table></td>
  </tr>
  <tr>
    <td colspan="2" bgcolor="#99CC66"></td>
  </tr>
  <tr>
    <td colspan="2" bgcolor="#5C743D"></td>
  </tr>
</table>
<table align="center" border="0" cellpadding="0" cellspacing="0" width="100%">
<tr>
  <td valign="top" class="left" width="185" style="white-space: nowrap;"><table width="185" border="0" align="left" cellpadding="0" cellspacing="0">
      <tr align="left">
        <td><div>
<?php
echo '<div class="leftNav"><ul class="leftNav"><li>';

// Bookmarks
$formated_bm = $this->format($this->get_bookmarks_formatted(), 'post_wacko');
$formated_bm = str_replace ("<br />", "", $formated_bm);
$formated_bm = str_replace ( "\n", "</li><li>\n", $formated_bm );
echo $formated_bm;
echo "</li></ul></div>";
echo '<br />';
if ($this->get_user())
{
	if (!in_array($this->tag, $this->get_bookmark_links()))
	{?>
<a href="<?php echo $this->href('', '', "addbookmark=yes")?>"> <img src="<?php echo $this->config['theme_url'] ?>icons/bookmark1.gif" border="0" align="bottom" style="vertical-align: middle; "/> <?php echo $this->get_translation('Bookmarks'); ?> </a>
<?php } else { ?>
<a href="<?php echo $this->href('', '', "removebookmark=yes")?>"> <img src="<?php echo $this->config['theme_url'] ?>icons/bookmark2.gif" border="0" align="bottom" style="vertical-align: middle; "/> <?php echo $this->get_translation('Bookmarks');
?> </a>
<?php
}
echo "<hr noshade=\"noshade\" size=\"1\" />";
echo "<div class=\"credits\">";
print $this->format( '{{hits}} Aufrufe' );
echo "</div>";
}
?>
            <div>
            </div>
          </div></td>
      </tr>
      <tr>
        <td></td>
      </tr>
    </table></td>
  <td>
<?php
// here we show messages
if ($message = $this->get_message()) echo "<div class=\"info\">$message</div>";
?>