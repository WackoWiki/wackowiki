<?php
/*
 Tabs theme.
 Common header file.
*/

// HTTP header with right Charset settings
header("Content-Type: text/html; charset=".$this->get_charset());
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->page['lang'] ?>" lang="<?php echo $this->page['lang'] ?>">
<head>
	<title><?php echo (isset($this->page['title']) ? $this->page['title'] : $this->add_spaces($this->tag)).($this->method != 'show' ? ' ('.$this->method.')' : '');
echo " (@".htmlspecialchars($this->config['wacko_name']).")" ?></title>
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
	<?php if ($this->config['allow_x11colors']) {?>
	<link rel="stylesheet" type="text/css" href="<?php echo $this->config['base_url'] ?>themes/_common/X11colors.css" />
	<?php } ?>
	<link media="print" rel="stylesheet" type="text/css" href="<?php echo $this->config['theme_url'] ?>css/print.css" />
	<link rel="shortcut icon" href="<?php echo $this->config['theme_url'] ?>icons/favicon.ico" type="image/x-icon" />
	<link title="<?php echo $this->config['root_page'];?>" href="<?php echo $this->config['base_url'];?>" rel="start"/>
	<link rel="alternate" type="application/rss+xml" title="<?php echo $this->get_translation('RecentChangesRSS');?>" href="<?php echo $this->config['base_url'];?>xml/changes_<?php echo preg_replace('/[^a-zA-Z0-9]/', '', strtolower($this->config['wacko_name']));?>.xml" />
	<link rel="alternate" type="application/rss+xml" title="<?php echo $this->get_translation('RecentCommentsRSS');?>" href="<?php echo $this->config['base_url'];?>xml/comments_<?php echo preg_replace('/[^a-zA-Z0-9]/', '', strtolower($this->config['wacko_name']));?>.xml" />
	<link rel="alternate" type="application/rss+xml" title="<?php echo $this->get_translation('RecentNewsRSS');?>" href="<?php echo $this->config['base_url'];?>xml/news_<?php echo preg_replace('/[^a-zA-Z0-9]/', '', strtolower($this->config['wacko_name']));?>.xml" />
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
else if ($this->has_access('write'))
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
//	* WikiEdit
//	* Doubleclick editing
//	* Smooth scrolling

?>
<body onload="all_init();">
<div class="Top<?php if (!$this->get_user()) echo "LoggedOut";?>">
  <div class="TopRight"><?php echo $this->form_open('', $this->get_translation('TextSearchPage'), 'get'); ?> <span class="nobr"> <?php echo $this->compose_link_to_page($this->config['root_page']) ?>&nbsp;|&nbsp; <?php echo $this->format($this->format(str_replace("\n", '&nbsp;|&nbsp;', $this->get_default_bookmarks($user['lang']))), 'post_wacko'); ?></span> | <?php echo $this->get_translation('SearchText') ?>
    <input name="phrase" size="15" class="ShSearch" />
    <?php echo $this->form_close(); ?> </div>
  <div class="TopLeft">
    <?php if ($this->get_user()) { ?>
    <img
	src="<?php echo $this->config['theme_url'] ?>icons/role.gif"
	width="9" height="15" alt="" /><span class="nobr"><?php echo $this->get_translation('YouAre')." ".$this->link($this->get_user_name()) ?></span> <small>( <span class="nobr Tune">
    <?php
echo $this->compose_link_to_page($this->get_translation('AccountLink'), "", $this->get_translation('AccountText'), 0); ?>
    | <a
	onclick="return confirm('<?php echo $this->get_translation('LogoutAreYouSure');?>');"
	href="<?php echo $this->href('', 'Login').($this->config['rewrite_mode'] ? "?" : "&amp;");?>action=logout&amp;goback=<?php echo $this->slim_url($this->tag);?>"><?php echo $this->get_translation('LogoutLink'); ?></a></span> )</small>
    <?php } else { ?>
    <table cellspacing="0" cellpadding="0" border="0">
      <tr>
        <td>
			<?php echo $this->form_open('', 'Login', 'post'); ?>
			<input type="hidden" name="action" value="login" />
			<img src="<?php echo $this->config['theme_url'] ?>icons/norole.gif" width="9" height="15" alt="" /></td>
        <td><strong><?php echo $this->get_translation('LoginWelcome') ?>:&nbsp;</strong> </td>
        <td><input type="text" name="name" size="18" /></td>
        <td>&nbsp;&nbsp;&nbsp;<?php echo $this->get_translation('LoginPassword') ?>:&nbsp; </td>
        <td><input type="hidden" name="goback"
			value="<?php echo $this->slim_url($this->tag);?>" />
          <input
			type="password" name="password" size="8" />
          &nbsp;</td>
        <td><input type="submit" value="" />
        </td>
      </tr>
      <?php echo $this->form_close(); ?>
    </table>
    <?php } ?>
  </div>
  <br clear="all" />
  <img src="<?php echo $this->config['base_url'] ?>images/z.gif" width="1" height="1" alt="" /></div>
<div class="TopDiv"><img src="<?php echo $this->config['base_url'];?>images/z.gif" width="1" height="1" alt="" /></div>
<table cellspacing="0" cellpadding="0" border="0" width="100%">
  <tr>
    <td valign="top" class="Bookmarks">&nbsp;&nbsp;<strong><?php echo $this->get_translation('Bookmarks') ?>:</strong>&nbsp;&nbsp;</td>
    <td width="100%" class="Bookmarks"><?php //echo $this->get_bookmarks_formatted(); ?>
      <?php echo $this->format(implode(" | ", $this->get_bookmarks())); ?>&nbsp;&nbsp;</td>
  </tr>
</table>
<div class="TopDiv2"><img src="<?php echo $this->config['base_url'];?>images/z.gif" width="1" height="1" alt="" /></div>
<div class="Wrapper"
<?php if ($this->method == 'edit') echo "style=\"margin-bottom:0;padding-bottom:0\""?>>
<div class="Print">
<?php if ($this->get_user()) { ?>
<?php echo ($this->iswatched === true ?
      "<a href=\"".$this->href('watch')."\">".$this->get_translation('RemoveWatch')."</a>" :
      "<a href=\"".$this->href('watch')."\">".$this->get_translation('SetWatch')."</a>" ) ?> ::
  <?php if (!in_array($this->tag, $this->get_bookmark_links())) {?>
  <a href="<?php echo $this->href('', '', "addbookmark=yes")?>"><img src="<?php echo $this->config['theme_url'] ?>icons/bookmark.gif" width="12" height="12" alt="<?php echo $this->get_translation('AddToBookmarks') ?>" /></a> ::
<?php } else { ?>
  <a
	href="<?php echo $this->href('', '', "removebookmark=yes")?>"><img
	src="<?php echo $this->config['theme_url'] ?>icons/unbookmark.gif"
	width="12" height="12"
	alt="<?php echo $this->get_translation('RemoveFromBookmarks') ?>" /></a> ::
<?php } }
?>
<?php echo"<a href=\"".$this->href('print')."\" target=\"_blank\">" ?><img
	src="<?php echo $this->config['theme_url'] ?>icons/print.gif"
	width="21" height="20"
	alt="<?php echo $this->get_translation('PrintVersion') ?>" /></a> :: <?php echo"<a href=\"".$this->href('msword')."\" target=\"_blank\">" ?><img
	src="<?php echo $this->config['theme_url'] ?>icons/msword.gif"
	width="16" height="16"
	alt="<?php echo $this->get_translation('MsWordVersion') ?>" /></a></div>
<div class="header">
  <h1><span class="Main"><?php echo $this->config['wacko_name'] ?>:</span> <?php echo (isset($this->page['title']) ? $this->page['title'] : $this->get_page_path()); ?> <a class="Search"
	title="<?php echo $this->get_translation('SearchTitleTip')?>"
	href="<?php echo $this->config['base_url'] ?>TextSearch<?php echo ($this->config['rewrite_mode'] ? "?" : "&amp;");?>phrase=<?php echo urlencode($this->tag); ?>">...</a> </h1>
<?php if (($this->method != 'edit') || !$this->has_access('write')) { ?>
  <div style="background-image:url(<?php echo $this->config['theme_url'] ?>icons/shade2.gif);" class="Shade"><img
	src="<?php echo $this->config['theme_url'] ?>icons/shade1.gif"
	width="106" height="6" alt="" /></div>
<?php } ?>
</div>
<?php
// here we show messages
if ($message = $this->get_message()) echo "<div class=\"info\">$message</div>";
?>