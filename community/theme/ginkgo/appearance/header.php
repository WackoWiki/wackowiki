<?php
/*
Ginko theme.
Common header file.
*/

require ($this->config['theme_path'].'/_common/_header.php');

?>
<body>
<table style="width:100%;">
	<tr>
		<td style="width:100%; vertical-align:bottom; white-space: nowrap;"><span class="main"><a href="<?php echo $this->config['base_url']?>"class="main"><?php echo $this->config['site_name'] ?></a></span></td>
		<td style="width:100%;"><div style="text-align:right;"><?php
// Opens Search form
echo $this->form_open('search', '', 'get', $this->get_translation('TextSearchPage'));

// Searchbar
?>
<span class="searchbar nobr"><label for="phrase"><?php echo $this->get_translation('SearchText'); ?></label>
<input type="text" name="phrase" id="phrase" size="15" /><input class="submitinput" type="submit" title="<?php echo $this->get_translation('SearchButtonText') ?>" alt="<?php echo $this->get_translation('SearchButtonText') ?>" value="»"/></span>
<?php

// Search form close
echo $this->form_close();
?></div></td>
	</tr>
	<tr>
		<td style="vertical-align:top;"><div class="tagline"><?php echo $this->config['site_desc']; ?></div></td>
		<td style="width:100%">&nbsp;</td>
	</tr>
	<tr>
		<td colspan="2" bgcolor="#5C743D"></td>
	</tr>
	<tr>
		<td colspan="2" bgcolor="#85a43c"></td>
	</tr>
	<tr bgcolor="#85a43c">
		<td colspan="2" style="height:20;"><table style="width:100%;">
	<tr>
		<td><div class="navText">
<?php
// shows breadcrumbs
echo $this->get_page_path($titles = false, $separator = ' &gt; ', $linking = true, true);
?>
			</div></td>
		<td style="text-align:right;"><?php
// If user are logged, Wacko shows "You are UserName"
if ($this->get_user())
{
?>
	<div class="navText"><span class="nobr"><?php echo $this->get_translation('YouAre')." ".$this->link($this->config['users_page'].'/'.$this->get_user_name(), '', $this->get_user_name()) ?></span> <small>( <span class="nobr Tune">
<?php
	echo $this->compose_link_to_page($this->get_translation('AccountLink'), "", $this->get_translation('AccountText'), 0); ?>
		| <a onclick="return confirm('<?php echo $this->get_translation('LogoutAreYouSure');?>');" href="<?php echo $this->href('', $this->get_translation('LoginPage')).($this->config['rewrite_mode'] ? "?" : "&amp;");?>action=logout&amp;goback=<?php echo $this->slim_url($this->tag);?>"><?php echo $this->get_translation('LogoutLink'); ?></a></span> )</small></div>
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
<table style="text-align:center; width:100%;">
<tr>
	<td class="left" style="vertical-align:top; white-space: nowrap; width:185;"><table style="text-align:left; width:185;" >
		<tr style="text-align:left;">
			<td><div>
<?php
echo '<div class="leftNav"><ul class="leftNav">'."\n";

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

if ($this->get_user())
{
	// determines what it should show: "add to bookmarks" or "remove from bookmarks" icon
	if (!in_array($this->page['page_id'], $this->get_menu_links()))
	{
		echo '<li><a href="'. $this->href('', '', 'addbookmark=yes')
			.'"><img src="'. $this->config['theme_url']
			.'icons/bookmark1.png" alt="+" title="'.
			$this->get_translation('AddToBookmarks') .'"/></a></li>';
	}
	else
	{
		echo '<li><a href="'. $this->href('', '', 'removebookmark=yes')
			.'"><img src="'. $this->config['theme_url']
			.'icons/bookmark2.png" alt="-" title="'.
			$this->get_translation('RemoveFromBookmarks') .'"/></a></li>';
	}

	echo "</ul></div>";

	#echo "<hr noshade=\"noshade\" size=\"1\" />";
	#echo "<div class=\"credits\">";
	#echo $this->format( '{{hits}} Aufrufe' );
	#echo "</div>";
}
else
{
	echo "</ul></div>";
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
$this->output_messages();

?>