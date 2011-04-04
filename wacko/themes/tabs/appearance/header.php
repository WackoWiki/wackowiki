<?php
/*
 Tabs theme.
 Common header file.
*/

// TODO: isset($meta_title) ... else ... in common _header.php
#$meta_title = (isset($this->page['title']) ? $this->page['title'] : $this->add_spaces($this->tag)).($this->method != 'show' ? ' ('.$this->method.')' : '')." (@".htmlspecialchars($this->config['site_name']).")";

require ('themes/_common/_header.php');

?>
<body onload="all_init();">
<div class="Top<?php if (!$this->get_user()) echo "LoggedOut";?>">
  <div class="TopRight">
<?php echo $this->form_open('', $this->get_translation('TextSearchPage'), 'get'); ?>
  <span class="nobr">
<?php

	echo '<div id="usermenu">';
	echo "<ol>\n";

	echo '<li>'.$this->compose_link_to_page($this->config['root_page'])."</li>\n";

	foreach ($this->get_default_bookmarks($user['lang']) as $_bookmark)
	{
		$formatted_bookmarks = $this->format($_bookmark[1], 'post_wacko');

		if ($this->page['page_id'] == $_bookmark[0])
		{
			echo '<li class="active">';
		}
		else
		{
			echo '<li>';
		}

		echo $formatted_bookmarks."</li>\n";
	}

?>
  </span> <li> <?php echo $this->get_translation('SearchText') ?>
    <input name="phrase" size="15" class="ShSearch" /></li>
<?php
	echo $this->form_close();
	echo "\n</ol></div>";
?> </div>
  <div class="TopLeft">
    <?php if ($this->get_user()) { ?>
    <img src="<?php echo $this->config['theme_url'] ?>icons/role.gif" width="9" height="15" alt="" /><span class="nobr"><?php echo $this->get_translation('YouAre')." ".$this->link($this->config['users_page'].'/'.$this->get_user_name(), '', $this->get_user_name()) ?></span> <small>( <span class="nobr Tune">
    <?php
echo $this->compose_link_to_page($this->get_translation('AccountLink'), "", $this->get_translation('AccountText'), 0); ?>
    | <a onclick="return confirm('<?php echo $this->get_translation('LogoutAreYouSure');?>');" href="<?php echo $this->href('', 'Login').($this->config['rewrite_mode'] ? "?" : "&amp;");?>action=logout&amp;goback=<?php echo $this->slim_url($this->tag);?>"><?php echo $this->get_translation('LogoutLink'); ?></a></span> )</small>
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
        <td><input type="hidden" name="goback" value="<?php echo $this->slim_url($this->tag);?>" />
          <input type="password" name="password" size="8" />
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
    <td width="100%" class="Bookmarks">
<?php
	echo '<div id="usermenu">';
	echo "<ol>\n";

	// bookmarks
	foreach ($this->get_bookmarks() as $_bookmark)
	{
		$formatted_bookmarks = $this->format($_bookmark[1], 'post_wacko');

		if ($this->page['page_id'] == $_bookmark[0])
		{
			echo '<li class="active">';
		}
		else
		{
			echo '<li>';
		}

		echo $formatted_bookmarks."</li>\n";
	}

	echo "\n</ol></div>";
?>
&nbsp;&nbsp;
</td>
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
  <?php if (!in_array($this->page['page_id'], $this->get_bookmark_links())) {?>
  <a href="<?php echo $this->href('', '', "addbookmark=yes")?>"><img src="<?php echo $this->config['theme_url'] ?>icons/bookmark.gif" width="12" height="12" alt="<?php echo $this->get_translation('AddToBookmarks') ?>" /></a> ::
<?php } else { ?>
  <a href="<?php echo $this->href('', '', "removebookmark=yes")?>">
  <img src="<?php echo $this->config['theme_url'] ?>icons/unbookmark.gif" width="12" height="12" alt="<?php echo $this->get_translation('RemoveFromBookmarks') ?>" /></a> ::
<?php } }
?>
<?php echo"<a href=\"".$this->href('print')."\">" ?><img
	src="<?php echo $this->config['theme_url'] ?>icons/print.gif"
	width="21" height="20"
	alt="<?php echo $this->get_translation('PrintVersion') ?>" /></a> :: <?php echo"<a href=\"".$this->href('msword')."\">" ?><img
	src="<?php echo $this->config['theme_url'] ?>icons/msword.gif"
	width="16" height="16"
	alt="<?php echo $this->get_translation('MsWordVersion') ?>" /></a></div>
<div class="header">
  <h1><span class="Main"><?php echo $this->config['site_name'] ?>:</span> <?php echo (isset($this->page['title']) ? $this->page['title'] : $this->get_page_path()); ?> <a class="Search"
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