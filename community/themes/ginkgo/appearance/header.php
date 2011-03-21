<?php
/*
Ginko theme.
Common header file.
*/

require ('themes/_common/_header.php');

?>
<body onload="all_init();">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="378" valign="bottom" style="white-space: nowrap;"><span class="main"><a href="<?php echo $this->config['base_url']?>"class="main"><?php echo $this->config['site_name'] ?></a></span></td>
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
    <td valign="top"><div class="tagline"><?php echo $this->config['site_desc']; ?></div></td>
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
          <td><div class="navText"><?php echo $this->compose_link_to_page($this->config['root_page']);?> &gt; <?php echo $this->get_page_path(); ?></div></td>
          <td align="right"><?php
// If user are logged, Wacko shows "You are UserName"
if ($this->get_user())
{
?>
            <span class="nobr"><?php echo $this->get_translation('YouAre')." ".$this->link($this->config['users_page'].'/'.$this->get_user_name(), '', $this->get_user_name()) ?></span> <small>( <span class="nobr Tune">
<?php
      echo $this->compose_link_to_page($this->get_translation('AccountLink'), "", $this->get_translation('AccountText'), 0); ?>
            | <a onclick="return confirm('<?php echo $this->get_translation('LogoutAreYouSure');?>');" href="<?php echo $this->href('', $this->get_translation('LoginPage')).($this->config['rewrite_mode'] ? "?" : "&amp;");?>action=logout&amp;goback=<?php echo $this->slim_url($this->tag);?>"><?php echo $this->get_translation('LogoutLink'); ?></a></span> )</small>
<?php
// Else Wacko shows login's controls
}
else
{
	echo '<h1 class="navText" style="padding-right:10px;">'.$this->page['title'].'</h1>';
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
$formatted_bookmarks = $this->format($this->get_bookmarks_formatted(), 'post_wacko');
$formatted_bookmarks = str_replace ("<br />", "", $formatted_bookmarks);
$formatted_bookmarks = str_replace ( "\n", "</li><li>\n", $formatted_bookmarks );
echo $formatted_bookmarks;
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