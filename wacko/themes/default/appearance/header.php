<?php
/*
 Default theme.
 Common header file.
*/

require ('themes/_common/_header.php');
?>
<body onload="all_init();">
<div id="mainwrapper">
	<div id="header">
		<div id="header-main">
			<div id="header-top">
			<span class="main"><?php echo ($this->page['tag'] == $this->config['root_page'] ? $this->config['site_name'] : "<a href=\"".$this->config['base_url']."\">".$this->config['site_name']."</a>") ?>: </span><?php echo (isset($this->page['title']) ? $this->page['title'] : $this->get_page_path() ); ?>
			<?php #echo ' <a class="Search" title="'.$this->get_translation('SearchTitleTip').'" href="'.$this->config['base_url'].$this->get_translation('TextSearchPage').($this->config['rewrite_mode'] ? "?" : "&amp;").'phrase='.urlencode($this->tag).'">...</a>'; ?>
		</div>
		<div id="login">
<?php
// if user are logged, shows "You are UserName"
if ($this->get_user())
{
	echo '<span class="nobr">'.$this->get_translation('YouAre')." ".$this->link($this->config['users_page'].'/'.$this->get_user_name(), '', $this->get_user_name()).'</span><small> ( <span class="nobr Tune">'.
		$this->compose_link_to_page($this->get_translation('AccountLink'), "", $this->get_translation('AccountText'), 0).
		" | <a onclick=\"return confirm('".$this->get_translation('LogoutAreYouSure')."');\" href=\"".$this->href('', $this->get_translation('LoginPage')).($this->config['rewrite_mode'] ? "?" : "&amp;")."action=logout&amp;goback=".$this->slim_url($this->tag)."\">".$this->get_translation('LogoutLink')."</a></span>)</small>";
// else shows login's controls
}
else
{
	// show Register / Login link
	echo "<ul>\n<li>".$this->compose_link_to_page($this->get_translation('LoginPage').($this->config['rewrite_mode'] ? "?" : "&amp;")."goback=".$this->slim_url($this->tag), "", $this->get_translation('LoginPage'), 0)."</li>\n";
	echo "<li>".$this->compose_link_to_page($this->get_translation('RegistrationPage'), "", $this->get_translation('RegistrationPage'), 0)."</li>\n";
	// echo "<li>".$this->compose_link_to_page($this->get_translation('RegistrationPage'), "", $this->get_translation('Help'), 0)."</li>\n";
	echo "</ul>\n";
}

// End if
?></div>
		</div>
<div id="navigation">
<?php
// outputs bookmarks menu
	echo '<div id="usermenu">';
	echo "<ol>\n";
	// main page
	#echo "<li>".$this->compose_link_to_page($this->config['root_page'])."</li>\n";

	// bookmarks
	foreach ($this->get_menu() as $menu_item)
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

	if ($this->get_user())
	{
		// determines what it should show: "add to menu" or "remove from menu" icon
		if (!in_array($this->page['page_id'], $this->get_menu_links()))
		{
			echo '<li><a href="'. $this->href('', '', 'addbookmark=yes')
				.'"><img src="'. $this->config['theme_url']
				.'icons/bookmark1.gif" alt="+" title="'.
				$this->get_translation('AddToBookmarks') .'"/></a></li>';
		}
		else
		{
			echo '<li><a href="'. $this->href('', '', 'removebookmark=yes')
				.'"><img src="'. $this->config['theme_url']
				.'icons/bookmark2.gif" alt="-" title="'.
				$this->get_translation('RemoveFromBookmarks') .'"/></a></li>';
		}
	}
	echo "\n</ol></div>";
?>
<div id="handler">

<?php
	// defining tabs constructor
	// image - 1 image only, 2 image and text
	function echo_tab($link, $hint, $title, $active = false, $image, $accesskey = '')
	{
		global $engine;

		$_image = '';
		$_title = '';

		if ($title == '')
		{
			return; // no tab;
		}

		if ($image <> 0)
		{
			$_image = 'spacer.gif';
		}
		else
		{
			$_image = $image;
		}

		$method = substr($link, strrpos($link, '/') + 1);

		if ($active)
		{
			if ($image)
			{
				if ($image != 1)
				{
					$_title = $title;
				}

				$tab = "<li class=\"$method active\"><img src=\"".$engine->config['theme_url']."icons/$_image\" alt=\"$title\" />".$_title."</li>\n";
			}
			else
			{
				$tab = "<li class=\"$method active\">$title</li>\n";
			}
		}
		else
		{
			if ($method == 'show') $link = ".";

			if ($image)
			{
				if ($image != 1)
				{
					$_title = ' '.$title;
				}

				$tab = "<li class=\"$method\"><a href=\"$link\" title=\"$hint\" accesskey=\"$accesskey\"><img src=\"".$engine->config['theme_url']."icons/$_image\" alt=\"$title\" />".$_title."</a></li>\n";
			}
			else
			{
				$tab = "<li class=\"$method\"><a href=\"$link\" title=\"$hint\" accesskey=\"$accesskey\">$title</a></li>\n";
			}
		}

		return $tab;
	}

	echo '<ul class="submenu">'."\n";
	// find order of

	// show tab
	echo echo_tab(
		$this->href('show'),
		$this->get_translation('ShowTip'),
		$this->has_access('read') ? $this->get_translation('ShowText') : '',
		$this->method == 'show',
		1,
		'v');

	// edit tab
	echo echo_tab(
		$this->href('edit'),
		$this->get_translation('EditTip'),
		((!$this->page && $this->has_access('create')) || $this->is_admin() ||
			($this->forum === false && $this->has_access('write')) ||
			($this->forum === true && ($this->user_is_owner() || $this->is_moderator()) && (int)$this->page['comments'] == 0))
			? $this->get_translation('EditText') : '',
		$this->method == 'edit',
		1,
		'e');

	// revisions tab
	echo echo_tab(
		$this->href('revisions'),
		$this->get_translation('RevisionTip'),
		($this->forum === false && $this->page && $this->has_access('read') && $this->hide_revisions === false ) ? $this->get_translation('RevisionText') : '',
		$this->method == 'revisions' || $this->method == 'diff',
		1,
		'r');

	// properties tab
	echo echo_tab(
		$this->href('properties'),
		$this->get_translation('PropertiesTip'),
		($this->forum === false && $this->page && ($this->is_admin() || $this->user_is_owner())) ? $this->get_translation('PropertiesText') : '',
		$this->method == 'properties' || $this->method == 'rename' || $this->method == 'purge' || $this->method == 'keywords',
		1,
		's');

	// show more tab

	// display more icon and text
	# echo "<li class='sublist'><a href='#' id='more-icon'><img src=\"".$this->config['theme_url']."icons/more.png\" title=\"".$this->get_translation('PageHandlerMoreTip')."\" alt=\"".$this->get_translation('PageHandlerMoreTip')."\" /> ".$this->get_translation('PageHandlerMoreTip')."</a> \n";
	// only display 'more' text that shows handler list on hover
	echo '<li class=""><a href="#" id="more">'.$this->get_translation('PageHandlerMoreTip').'</a>'." \n";
	echo '<ul class="dropdown_menu">'."\n";

	// print tab
	// TODO: should add 'PrintTip' to the language file
	echo echo_tab(
		$this->href('print'),
		$this->get_translation('PrintVersion'),
		$this->has_access('read') ? $this->get_translation('PrintText') : '',
		$this->method == 'print',
		2,
		'v');

	// create tab
	echo echo_tab(
		$this->href('new'),
		$this->get_translation('CreateNewPageTip'),
		((!$this->page && $this->has_access('create')) || $this->is_admin() ||
			($this->forum === false && $this->has_access('write')) ||
			($this->forum === true && ($this->user_is_owner() || $this->is_moderator()) && (int)$this->page['comments'] == 0))
			? $this->get_translation('CreateNewPageText') : '',
		$this->method == 'new',
		2,
		'n');

	// remove tab
	echo echo_tab(
		$this->href('remove'),
		$this->get_translation('DeleteTip'),
		($this->page && ($this->is_admin() || !$this->config['remove_onlyadmins'] && (
			($this->forum === true && $this->user_is_owner() && (int)$this->page['comments'] == 0) ||
			($this->forum === false && $this->user_is_owner()))))
			? $this->get_translation('DeleteText') : '',
		$this->method == 'remove',
		2,
		'');

	// rename tab
	echo echo_tab(
		$this->href('rename'),
		$this->get_translation('RenameText'),
		($this->page && ($this->is_admin() || $this->user_is_owner() && (
			($this->forum === true && $this->user_is_owner() && (int)$this->page['comments'] == 0) ||
			($this->forum === false && $this->user_is_owner()))))
			? $this->get_translation('RenameText') : '',
		$this->method == 'rename',
		2,
		'');

	// moderation tab
	echo echo_tab(
		$this->href('moderate'),
		$this->get_translation('ModerateTip'),
		($this->is_moderator() && $this->has_access('read')) ? $this->get_translation('ModerateText') : '',
		$this->method == 'moderate',
		2,
		'm');

	// permissions tab
	echo echo_tab(
		$this->href('permissions'),
		$this->get_translation('ACLTip'),
		($this->forum === false && $this->page && ($this->is_admin() || $this->user_is_owner())) ? $this->get_translation('ACLText') : '',
		$this->method == 'permissions',
		2,
		'a');

	// categories tab
	echo echo_tab(
		$this->href('categories'),
		$this->get_translation('CategoriesTip'),
		($this->forum === false && $this->page && ($this->is_admin() || $this->user_is_owner())) ? $this->get_translation('CategoriesText') : '',
		$this->method == 'categories',
		2,
		'c');

	// referrers tab
	echo echo_tab(
		$this->href('referrers'),
		$this->get_translation('ReferrersTip'),
		($this->page && $this->has_access('read') && $this->get_user()) ? $this->get_translation('ReferrersText') : '',
		$this->method == 'referrers' || $this->method == 'referrers_sites',
		2,
		'l');

	// watch tab
	echo echo_tab(
		$this->href('watch'),
		($this->iswatched === true ? $this->get_translation('RemoveWatch') : $this->get_translation('SetWatch')),
		($this->forum === false && $this->page && ($this->is_admin() || $this->user_is_owner())) ? ($this->iswatched === true ? $this->get_translation('UnWatchText') : $this->get_translation('WatchText') ) : '',
		$this->method == 'watch',
		($this->iswatched === true ? 'watch-on.png' : 'watch-off.png'),
		'a');

	// review tab
	echo echo_tab(
		$this->href('review'),
		($this->page['reviewed'] == 1 ? $this->get_translation('RemoveReview') : $this->get_translation('SetReview')),
		($this->forum === false && $this->page && ($this->config['review'] && $this->is_reviewer())) ? $this->get_translation('Review') : '',
		$this->method == 'review',
		($this->page['reviewed'] == 1 ? 'review2.png' : 'review1.png'),
		'z');

	// upload tab
	echo echo_tab(
		$this->href('upload'),
		$this->get_translation('FilesTip'),
		($this->forum === false && $this->page && $this->has_access('upload')) ? $this->get_translation('FilesText') : '',
		$this->method == 'upload',
		2,
		'u');

		// last empty
		echo "<li></li>\n";
		echo "</ul>\n";
		echo "</li>\n";
	#echo "</ul>\n";
?>
<li class="search">
<div id="search">
<?php
// opens search form
echo $this->form_open('', $this->get_translation('TextSearchPage'), 'get');

// searchbar
?>
<span class="search nobr"><label for="phrase"><?php echo $this->get_translation('SearchText'); ?></label>
<input type="text" name="phrase" id="phrase" size="20" />
<input class="submitinput" type="submit" title="<?php echo $this->get_translation('SearchButtonText') ?>" alt="<?php echo $this->get_translation('SearchButtonText') ?>" value="<?php echo $this->get_translation('SearchButtonText') ?>"/>
</span>
<?php

// search form close
echo $this->form_close();
?>
</div>
</li></ul>
</div>
</div>
<div class="breadcrumb">
<?php
// shows breadcrumbs
echo $this->get_page_path($titles = false, $separator = ' &gt; ', $linking = true, true);
?>
</div>
</div>
<div id="content">
<?php
// here we show messages
if ($message = $this->get_message())
{
	echo "<div class=\"info\">$message</div>";
}
?>