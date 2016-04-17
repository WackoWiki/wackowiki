<?php
/*
 Default theme.
 Common header file.
*/

require ($this->config['theme_path'].'/_common/_header.php');
?>
<body>
<div id="mainwrapper">
	<header>
		<div id="header-main">
			<div id="header-top">
			<h1><span class="main">
				<?php echo (isset($this->page['tag']) && $this->page['tag'] == $this->config['root_page']
					? $this->config['site_name']
					: '<a href="'.$this->config['base_url'].'">'.$this->config['site_name'].'</a>')
			?>: </span>
				<?php echo (isset($this->page['title']) && $this->has_access('read')
					? $this->page['title']
					: $this->get_page_path() );
		?></h1>
		</div>
		<div id="login_box">
<?php
// if user are logged, shows "You are UserName"
if ($this->get_user())
{
	echo '<span class="nobr">'.$this->get_translation('YouAre').' '.$this->link($this->config['users_page'].'/'.$this->get_user_name(), '', $this->get_user_name()).'</span>'.
		 '<small> ( <span class="nobr Tune">'.$this->compose_link_to_page($this->get_translation('AccountLink'), '', $this->get_translation('AccountText'), 0).
		' | <a onclick="return confirm(\''.$this->get_translation('LogoutAreYouSure').'\');" href="'.$this->href('', $this->get_translation('LoginPage'), 'action=logout&amp;goback='.$this->slim_url($this->tag)).'">'.$this->get_translation('LogoutLink').'</a></span> )</small>';
// else shows login's controls
}
else
{
	// show Register / Login link
	echo "<ul>\n<li>".$this->compose_link_to_page($this->get_translation('LoginPage'), '', $this->get_translation('LoginPage'), 0, '', "goback=".$this->slim_url($this->tag))."</li>\n";

	if ($this->config['allow_registration'] == true)
	{
		echo "<li>".$this->compose_link_to_page($this->get_translation('RegistrationPage'), '', $this->get_translation('RegistrationPage'), 0)."</li>\n";
	}
	// Show Help link
	# echo "<li>".$this->compose_link_to_page($this->get_translation('HelpPage'), "", $this->get_translation('Help'), 0)."</li>\n";
	echo "</ul>\n";
}

// End if
?>
		</div>
	</div>
	<nav class="menu-main">
<?php
	// outputs bookmarks menu
	echo '<div id="usermenu">';
	echo "<ol>\n";
	// main page
	#echo "<li>".$this->compose_link_to_page($this->config['root_page'])."</li>\n";

	$menu = $this->get_menu();

	// menu
	if ($menu)
	{
		$fmi		= array(); // formatted_menu_item
		$level		= 'menu';
		$max_items	= 5;
		$i			= 1;

		foreach ($menu as $menu_item)
		{
			if ($i > $max_items)
			{
				$level = 'submenu';
			}

			if ( ! isset($fmi[$level]))
			{
				$fmi[$level] = null;
			}

			if ($this->page['page_id'] == $menu_item[0])
			{
				$fmi[$level] .= '<li class="active"><span>';
				$fmi[$level] .= $menu_item[1];
				$fmi[$level] .= "</span></li>\n";
			}
			else
			{
				$fmi[$level] .= '<li>';
				$fmi[$level] .= $this->format($menu_item[2], 'post_wacko');
				$fmi[$level] .= "</li>\n";
			}

			$i++;
		}

		echo $fmi['menu'];

		if (isset($fmi['submenu']))
		{
			// dropdown
			echo '<li class="dropdown"><a href="#" id="more">
					<img src="'. $this->config['theme_url'].'icon/spacer.png" alt="-" title="'.
					$this->get_translation('RemoveFromBookmarks') .'" class="btn-menu"/></a>';
			echo '<ul class="dropdown_menu">'."\n";
			echo $fmi['submenu'];
			echo "</ul>\n</li>\n";
		}
	}

	if ($this->get_user())
	{
		// determines what it should show: "add to menu" or "remove from menu" icon
		if (!in_array($this->page['page_id'], (array)$this->get_menu_links()))
		{
			echo '<li><a href="'. $this->href('', '', 'addbookmark=yes')
				.'"><img src="'. $this->config['theme_url']
				.'icon/spacer.png" alt="+" title="'.
				$this->get_translation('AddToBookmarks') .'" class="btn-addbookmark"/></a></li>';
		}
		else
		{
			echo '<li><a href="'. $this->href('', '', 'removebookmark=yes')
				.'"><img src="'. $this->config['theme_url']
				.'icon/spacer.png" alt="-" title="'.
				$this->get_translation('RemoveFromBookmarks') .'" class="btn-removebookmark"/></a></li>';
		}
	}
	echo "\n</ol></div>";
?>
<div id="handler">

<?php
	// defining tabs constructor
	//		$image - 0 text only, 1 image only, 2 image and text
	function echo_tab($link, $hint, $title, $active = false, $image, $tab_class = '', $access_key = '')
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
			$_image = 'spacer.png';
		}

		$method = substr($link, strrpos($link, '/') + 1);

		if (!$tab_class)
		{
			$tab_class = 'm-'.$method;
		}

		if ($active)
		{
			if ($image)
			{
				if ($image != 1)
				{
					$_title = $title;
				}

				$tab =	'<li class="'.$tab_class.' active">'.
							'<span><img src="'.$engine->config['theme_url'].'icon/'.$_image.'" alt="'.$title.'" />'.' '.$_title.'</span>'.
						'</li>'."\n";
			}
			else
			{
				$tab =	'<li class="'.$tab_class.' active">'.
							'<span>'.' '.$title.'</span>'.
						'</li>'."\n";
			}
		}
		else
		{
			if ($method == 'show') $link = '.';

			if ($image)
			{
				if ($image != 1)
				{
					$_title = ' '.$title;
				}

				$tab =	'<li class="'.$tab_class.'">'.
							'<a href="'.$link.'" title="'.$hint.'" accesskey="'.$access_key.'"><img src="'.$engine->config['theme_url'].'icon/'.$_image.'" alt="'.$title.'" />'.$_title.'</a>'.
						'</li>'."\n";
			}
			else
			{
				$tab =	'<li class="'.$tab_class.'">'.
							'<a href="'.$link.'" title="'.$hint.'" accesskey="'.$access_key.'">'.$title.'</a>'.
						'</li>'."\n";
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
		$this->has_access('read')
			? $this->get_translation('ShowText') : '',
		$this->method == 'show',
		1,
		'',
		'v');

	// edit tab
	echo echo_tab(
		$this->href('edit'),
		$this->get_translation('EditTip'),
		((!$this->page && $this->has_access('create')) || $this->is_admin() ||
			($this->forum === false && $this->has_access('write')) ||
			($this->forum === true && ($this->is_owner() || $this->is_moderator()) && (int)$this->page['comments'] == 0))
			? $this->get_translation('EditText') : '',
		$this->method == 'edit',
		1,
		'',
		'e');

	// revisions tab
	echo echo_tab(
		$this->href('revisions'),
		$this->get_translation('RevisionTip'),
		($this->forum === false && $this->page && $this->has_access('read') && $this->hide_revisions === false )
			? $this->get_translation('RevisionText') : '',
		$this->method == 'revisions',
		1,
		'',
		'r');

	// properties tab
	echo echo_tab(
		$this->href('properties'),
		$this->get_translation('PropertiesTip'),
		($this->forum === false && $this->page && ($this->is_owner()) || $this->is_admin())
			? $this->get_translation('PropertiesText') : '',
		$this->method == 'properties',
		1,
		'',
		's');

	// show more tab

	// display more icon and text
	# echo '<li class="sublist"><a href="#" id="more-icon"><img src="'.$this->config['theme_url'].'icon/more.png" title="'.$this->get_translation('PageHandlerMoreTip').'" alt="'.$this->get_translation('PageHandlerMoreTip').'" /> '.$this->get_translation('PageHandlerMoreTip')."</a> \n";
	// only display 'more' text that shows handler list on hover

	if ($this->has_access('read'))
	{
		echo '<li class="dropdown"><a href="#" id="more">'.$this->get_translation('PageHandlerMoreTip').'<span class="dropdown_arrow">&#9660;</span></a>'." \n";
		echo '<ul class="dropdown_menu">'."\n";

		// print tab
		// TODO: should add 'PrintTip' to the language file
		echo echo_tab(
			$this->href('print'),
			$this->get_translation('PrintVersion'),
			$this->has_access('read')
				? $this->get_translation('PrintText') : '',
			$this->method == 'print',
			2,
			'',
			'v');

		// create tab
		echo echo_tab(
			$this->href('new'),
			$this->get_translation('CreateNewPageTip'),
			((!$this->page && $this->has_access('create')) || $this->is_admin() ||
				($this->forum === false && $this->has_access('write')) ||
				($this->forum === true && ($this->is_owner() || $this->is_moderator()) && (int)$this->page['comments'] == 0))
				? $this->get_translation('CreateNewPageText') : '',
			$this->method == 'new',
			2,
			'',
			'n');

		// remove tab
		echo echo_tab(
			$this->href('remove'),
			$this->get_translation('DeleteTip'),
			($this->page && ($this->is_admin() || !$this->config['remove_onlyadmins'] && (
				($this->forum === true && $this->is_owner() && (int)$this->page['comments'] == 0) ||
				($this->forum === false && $this->is_owner()))))
				? $this->get_translation('DeleteText') : '',
			$this->method == 'remove',
			2,
			'',
			'');

		// rename tab
		echo echo_tab(
			$this->href('rename'),
			$this->get_translation('RenameTip'),
			($this->page && ($this->is_admin() || $this->is_owner() && (
				($this->forum === true && $this->is_owner() && (int)$this->page['comments'] == 0) ||
				($this->forum === false && $this->is_owner()))))
				? $this->get_translation('RenameText') : '',
			$this->method == 'rename',
			2,
			'',
			'');

		// moderation tab
		echo echo_tab(
			$this->href('moderate'),
			$this->get_translation('ModerateTip'),
			($this->is_moderator() && $this->has_access('read'))
				? $this->get_translation('ModerateText') : '',
			$this->method == 'moderate',
			2,
			'',
			'm');

		// permissions tab
		echo echo_tab(
			$this->href('permissions'),
			$this->get_translation('ACLTip'),
			($this->forum === false && $this->page && ($this->is_admin() || $this->is_owner()))
				? $this->get_translation('ACLText') : '',
			$this->method == 'permissions',
			2,
			'',
			'a');

		// categories tab
		echo echo_tab(
			$this->href('categories'),
			$this->get_translation('CategoriesTip'),
			($this->page && ($this->is_admin() || $this->is_owner()))
				? $this->get_translation('CategoriesText') : '',
			$this->method == 'categories',
			2,
			'',
			'c');

		// referrers tab
		echo echo_tab(
			$this->href('referrers'),
			$this->get_translation('ReferrersTip'),
			($this->page && $this->has_access('read') && $this->get_user())
				? $this->get_translation('ReferrersText') : '',
			$this->method == 'referrers' || $this->method == 'referrers_sites',
			2,
			'',
			'l');

		// watch tab
		echo echo_tab(
			$this->href('watch'),
			($this->is_watched === true ? $this->get_translation('RemoveWatch') : $this->get_translation('SetWatch')),
			#($this->forum === false && $this->page && ($this->is_admin() || $this->is_owner())) ? ($this->is_watched === true ? $this->get_translation('UnWatchText') : $this->get_translation('WatchText') ) : '',
			($this->page && ($this->get_user()))
				? ($this->is_watched === true
						? $this->get_translation('UnWatchText')
						: $this->get_translation('WatchText') )
				: '',
			$this->method == 'watch',
			2,
			($this->is_watched === true ? 'watch-off' : 'watch-on'),
			'w');

		// review tab
		echo echo_tab(
			$this->href('review'),
			($this->page['reviewed'] == 1 ? $this->get_translation('RemoveReview') : $this->get_translation('SetReview')),
			($this->forum === false && $this->page && ($this->config['review'] && $this->is_reviewer()))
				? ($this->page['reviewed'] == 1
						? $this->get_translation('Reviewed')
						: $this->get_translation('Review'))
				: '',
			$this->method == 'review',
			2,
			($this->page['reviewed'] == 1 ? 'review2' : 'review1'),
			'z');

		// upload tab
		echo echo_tab(
			$this->href('upload'),
			$this->get_translation('FilesTip'),
			($this->forum === false && $this->page && $this->has_access('upload'))
				? $this->get_translation('FilesText') : '',
			$this->method == 'upload',
			2,
			'',
			'u');

			// last empty
			echo "<li></li>\n";
			echo "</ul>\n";
			echo "</li>\n";
	}
			#echo "</ul>\n"; // list continues with search
?>
			<li class="search">
				<div id="search_box">
<?php
				// opens search form
				echo $this->form_open('search', '', 'get', false, $this->get_translation('TextSearchPage'));

				// searchbar
?>
				<span class="search nobr"><label for="phrase"><?php echo $this->get_translation('SearchText'); ?></label>
				<input type="search" name="phrase" id="phrase" size="20" />
				<input type="submit" class="submitinput" title="<?php echo $this->get_translation('SearchButtonText') ?>" value="<?php echo $this->get_translation('SearchButtonText') ?>"/>
				</span>
<?php

				// search form close
				echo $this->form_close();
?>
				</div>
			</li></ul>
		</div>
		</nav>
		<nav class="breadcrumb">
<?php
		// shows breadcrumbs
		echo $this->get_page_path($titles = false, $separator = ' &gt; ', $linking = true, true);
		#echo '<br />'.$this->get_user_trail($titles = true, $separator = ' &gt; ', $linking = true, $size = 8);
?>
		</nav>
	</header>
	<main>
<?php
// here we show messages
$this->output_messages();
?>