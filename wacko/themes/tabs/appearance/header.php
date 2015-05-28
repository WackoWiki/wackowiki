<?php
/*
 Tabs theme.
 Common header file.
*/

// TODO: isset($meta_title) ... else ... in common _header.php
#$meta_title = (isset($this->page['title']) ? $this->page['title'] : $this->add_spaces($this->tag)).($this->method != 'show' ? ' ('.$this->method.')' : '')." (@".htmlspecialchars($this->config['site_name'], ENT_COMPAT | ENT_HTML401, HTML_ENTITIES_CHARSET).")";

require ('themes/_common/_header.php');

?>
<body onload="all_init();">
<div class="Top<?php if (!$this->get_user()) echo "LoggedOut";?>">
	<div class="TopRight">
<?php echo $this->form_open('search', '', 'get', false, $this->get_translation('TextSearchPage')); ?>
	<span class="nobr">
<?php

	echo '<div id="usermenu">';
	echo "<ol>\n";

	echo '<li>'.$this->compose_link_to_page($this->config['root_page'])."</li>\n";

	// default menu
	if ($menu = $this->get_default_menu($user['lang']))
	{
		foreach ($menu as $menu_item)
		{
			$formatted_menu = $this->format($this->format($menu_item[1]), 'post_wacko');

			if ($this->page['page_id'] == $menu_item[0])
			{
				echo '<li class="active">';
			}
			else
			{
				echo '<li>';
			}

			echo $formatted_menu."</li>\n";
		}
	}

?>
	</span> <li> <?php echo $this->get_translation('SearchText') ?>
		<input name="phrase" size="15" class="ShSearch" /></li>
<?php
	echo $this->form_close();
	echo "\n</ol></div>";
?>
	</div>
	<div class="TopLeft">
		<?php if ($this->get_user()) { ?>
		<img src="<?php echo $this->config['theme_url'] ?>icons/role.png" width="9" height="15" alt="" /><span class="nobr"><?php echo $this->get_translation('YouAre')." ".$this->link($this->config['users_page'].'/'.$this->get_user_name(), '', $this->get_user_name()) ?></span> <small>( <span class="nobr Tune">
		<?php
echo $this->compose_link_to_page($this->get_translation('AccountLink'), "", $this->get_translation('AccountText'), 0); ?>
		| <a onclick="return confirm('<?php echo $this->get_translation('LogoutAreYouSure');?>');" href="<?php echo $this->href('', 'Login').($this->config['rewrite_mode'] ? "?" : "&amp;");?>action=logout&amp;goback=<?php echo $this->slim_url($this->tag);?>"><?php echo $this->get_translation('LogoutLink'); ?></a></span> )</small>
		<?php } else { ?>
		<table >
			<tr>
				<td>
			<?php echo $this->form_open('login', '', 'post', false, 'Login'); ?>
			<input type="hidden" name="action" value="login" />
			<img src="<?php echo $this->config['theme_url'] ?>icons/norole.png" width="9" height="15" alt="" /></td>
				<td><strong><?php echo $this->get_translation('LoginWelcome') ?>:&nbsp;</strong> </td>
				<td><input type="text" name="name" size="18" /></td>
				<td>&nbsp;&nbsp;&nbsp;<?php echo $this->get_translation('LoginPassword') ?>:&nbsp; </td>
				<td>
					<input type="hidden" name="goback" value="<?php echo $this->slim_url($this->tag);?>" />
					<input type="password" name="password" size="8" />&nbsp;
				</td>
				<td><input class="OkBtn_Top" type="submit" value="&nbsp;&nbsp;&raquo;&nbsp;&nbsp;" /></td>
			</tr>
		<?php echo $this->form_close(); ?>
		</table>
		<?php } ?>
	</div>
	<br clear="all" />
	<img src="<?php echo $this->config['base_url'] ?>images/z.png" width="1" height="1" alt="" /></div>
<div class="TopDiv"><img src="<?php echo $this->config['base_url'];?>images/z.png" width="1" height="1" alt="" /></div>
<table style="width:100%;">
	<tr>
		<td style="vertical-align:top;" class="Bookmarks">&nbsp;&nbsp;<strong><?php echo $this->get_translation('Bookmarks') ?>:</strong>&nbsp;&nbsp;</td>
		<td style="width:100%;" class="Bookmarks">
<?php
	echo '<div id="usermenu">';
	echo "<ol>\n";

	// menu
	if ($menu = $this->get_menu())
	{
		foreach ($menu as $menu_item)
		{
			$formatted_menu = $this->format($menu_item[1], 'post_wacko');

			if ($this->page['page_id'] == $menu_item[0])
			{
				echo '<li class="active">';
			}
			else
			{
				echo '<li>';
			}

			echo $formatted_menu."</li>\n";
		}
	}

	echo "\n</ol></div>";
?>
&nbsp;&nbsp;
		</td>
	</tr>
</table>
<div class="TopDiv2"><img src="<?php echo $this->config['base_url'];?>images/z.png" width="1" height="1" alt="" /></div>
<div class="Wrapper"
<?php if ($this->method == 'edit') echo "style=\"margin-bottom:0;padding-bottom:0\""?>>
<div class="Print">
<?php if ($this->get_user()) { ?>
<?php echo ($this->is_watched === true ?
			"<a href=\"".$this->href('watch')."\">".$this->get_translation('RemoveWatch')."</a>" :
			"<a href=\"".$this->href('watch')."\">".$this->get_translation('SetWatch')."</a>" ) ?> ::
	<?php if (!in_array($this->page['page_id'], $this->get_menu_links())) {?>
	<a href="<?php echo $this->href('', '', "addbookmark=yes")?>"><img src="<?php echo $this->config['theme_url'] ?>icons/bookmark.png" width="12" height="12" alt="<?php echo $this->get_translation('AddToBookmarks') ?>" /></a> ::
<?php } else { ?>
	<a href="<?php echo $this->href('', '', "removebookmark=yes")?>">
	<img src="<?php echo $this->config['theme_url'] ?>icons/unbookmark.png" width="12" height="12" alt="<?php echo $this->get_translation('RemoveFromBookmarks') ?>" /></a> ::
<?php } }
?>
<?php echo"<a href=\"".$this->href('print')."\">" ?><img
	src="<?php echo $this->config['theme_url'] ?>icons/print.png"
	width="21" height="20"
	alt="<?php echo $this->get_translation('PrintVersion') ?>" /></a> :: <?php echo"<a href=\"".$this->href('wordprocessor')."\">" ?><img
	src="<?php echo $this->config['theme_url'] ?>icons/wordprocessor.png"
	width="16" height="16"
	alt="<?php echo $this->get_translation('WordprocessorVersion') ?>" /></a></div>
<div class="header">
	<h1><span class="Main"><?php echo $this->config['site_name'] ?>:</span> <?php echo (isset($this->page['title']) ? $this->page['title'] : $this->get_page_path()); ?> </h1>
<?php if (($this->method != 'edit') || !$this->has_access('write')) { ?>
	<div style="background-image:url(<?php echo $this->config['theme_url'] ?>icons/shade2.png);" class="Shade"><img
	src="<?php echo $this->config['theme_url'] ?>icons/shade1.png"
	width="106" height="6" alt="" /></div>
<?php } ?>
</div>
<?php
// here we show messages
$this->output_messages();
?>