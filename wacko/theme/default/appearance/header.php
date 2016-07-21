<?php
/*
 Default theme.
 Common header file.
*/

require Ut::join_path(THEME_DIR, '_common/_header.php');
?>
<body>
<div id="mainwrapper">
	<header>
		<div id="header-main">
			<div id="header-top">
				<h1>
			<?php
				echo (isset($this->page['tag']) && $this->page['tag'] == $this->config['root_page']
					? $this->config['site_name']
					: '<a href="'.$this->config['base_url'].'" title="'.$this->config['site_desc'].'">'.$this->config['site_name'].'</a>');

				/* echo ': '.(isset($this->page['title']) && $this->has_access('read')
					? $this->page['title']
					: $this->get_page_path() ); */
		?>
				</h1>
		<?php // echo $this->config['site_desc'];
		?>
			</div>
			<div id="login-box">
<?php
// if user are logged, shows "You are UserName"
if (($logged_in = $this->get_user()))
{
	echo '<span class="nobr">'.$this->_t('YouAre').' '.$this->link($this->config['users_page'].'/'.$this->get_user_name(), '', $this->get_user_name()).'</span>'.
		 '<small> ( <span class="nobr Tune">'.$this->compose_link_to_page($this->_t('AccountLink'), '', $this->_t('AccountText'), 0).
		' | <a onclick="return confirm(\''.$this->_t('LogoutAreYouSure').'\');" href="'.$this->href('', $this->_t('LoginPage'), 'action=logout&amp;goback='.$this->slim_url($this->tag)).'">'.$this->_t('LogoutLink').'</a></span> )</small>';
}
// else shows login's controls
else
{
	// show Register / Login link
	echo "<ul>\n";
	echo '<li>'.$this->compose_link_to_page($this->_t('LoginPage'), '', $this->_t('LoginPage'), 0, '', "goback=".$this->slim_url($this->tag))."</li>\n";

	if ($this->db->allow_registration)
	{
		echo '<li>'.$this->compose_link_to_page($this->_t('RegistrationPage'), '', $this->_t('RegistrationPage'), 0)."</li>\n";
	}
	// Show Help link
	//  echo "<li>".$this->compose_link_to_page($this->_t('HelpPage'), "", $this->_t('Help'), 0)."</li>\n";
	echo "</ul>\n";
}

// End if
?>
		</div>
	</div>
	<nav class="menu-main">

	<div id="menu-user">
	<ol>
<?php
	// outputs bookmarks menu
	// main page
	// echo "<li>".$this->compose_link_to_page($this->config['root_page'])."</li>\n";

	$max_items = $logged_in ? $logged_in['menu_items'] : $this->db->menu_items;
	$i = 0;

	foreach ((array)$this->get_menu() as $menu_item)
	{
		if ($i++ == $max_items)
		{
			// start dropdown menu for bookmarks over max_items
			echo '<li class="dropdown"><a href="#" id="more">
					<img src="'. $this->config['theme_url'].'icon/spacer.png" alt="-" title="'.
					$this->_t('Bookmarks') .'" class="btn-menu"/></a>';
			echo '<ul class="dropdown_menu">'."\n";
		}

		if ($this->page['page_id'] == $menu_item[0])
		{
			echo '<li class="active"><span>' . $menu_item[1] . "</span></li>\n";
		}
		else
		{
			echo '<li>' . $this->format($menu_item[2], 'post_wacko') . "</li>\n";
		}
	}

	if ($i > $max_items)
	{
		// finish dropdown menu
		echo "</ul>\n</li>\n";
	}

	if ($logged_in)
	{
		// determines what it should show: "add to menu" or "remove from menu" icon
		if (!in_array($this->page['page_id'], (array)$this->get_menu_links()))
		{
			echo '<li><a href="'. $this->href('', '', 'addbookmark=yes')
				.'"><img src="'. $this->config['theme_url']
				.'icon/spacer.png" alt="+" title="'.
				$this->_t('AddToBookmarks') .'" class="btn-addbookmark"/></a></li>';
		}
		else if (!$this->get_menu_default())
		{
			echo '<li><a href="'. $this->href('', '', 'removebookmark=yes')
				.'"><img src="'. $this->config['theme_url']
				.'icon/spacer.png" alt="-" title="'.
				$this->_t('RemoveFromBookmarks') .'" class="btn-removebookmark"/></a></li>';
		}
	}
?>
</ol></div>

<div id="handler">

<?php
	// defining tabs constructor
	//		$image = 0 text only, 1 image only, 2 image and text
	$echo_tab = function ($method, $hint, $title, $image, $tab_class = '', $access_key = '', $params = '')
	{
		$title = $this->_t($title);

		if ($image)
		{
			$title = '<img src="' . $this->config['theme_url'] . 'icon/spacer.png" alt="' . $title . '" />'.
					($image == 2 ?  ' ' . $title : '');
		}

		$tab = '<li class="' . ($tab_class? $tab_class : 'm-' . $method);

		if (substr($this->method, 0, strlen($method)) == $method)
		{
			$tab .= ' active"><span>' . $title .  '</span>';
		}
		else
		{
			$tab .= '"><a href="' . ($method == 'show' ? '.' : $this->href($method)) . '" title="' . $this->_t($hint) . '"';

			if ($access_key !== '')
			{
				$tab .= ' accesskey="' . $access_key . '"';
			}

			$tab .= $params . '>' . $title . '</a>';
		}

		$tab .= "</li>\n";

		echo $tab;
	};

	echo '<ul class="submenu">'."\n";

	$echo_tab('show', 'ShowTip', 'ShowText', 1, '', 'v');

	if (!$this->page)
	{
		if ($this->has_access('create') || $this->is_admin())
		{
			$echo_tab('edit', 'EditTip', 'EditText', 1, '', 'e');
			$echo_tab('new', 'CreateNewPageTip', 'CreateNewPageText', 1, '', 'n');
		}
	}
	else
	{
		$readable = $this->has_access('read');

		// edit or source tab
		if ($this->is_admin()
				|| ($this->forum
					? ($this->is_owner() || $this->is_moderator()) && (int)$this->page['comments'] == 0
					: $this->has_access('write')))
		{
			$echo_tab('edit', 'EditTip', 'EditText', 1, '', 'e');
		}
		else if ($readable)
		{
			$echo_tab('source', 'SourceTip', 'SourceText', 1, '', '', 'e');
		}

		if (!$this->count_revisions($this->page['page_id'], 0, $this->is_admin()))
		{
			// no revisions - nothing to show
			$this->hide_revisions = -1;
		}

		// revisions tab
		if (!$this->forum && $readable && !$this->hide_revisions)
		{
			$echo_tab('revisions', 'RevisionTip', 'RevisionText', 1, '', 'r');
		}

		// properties tab
		if (!$this->forum && ($this->is_owner()) || $this->is_admin())
		{
			$echo_tab('properties', 'PropertiesTip', 'PropertiesText', 1, '', 's');
		}

		// show more tab

		// display more icon and text
		//  echo '<li class="sublist"><a href="#" id="more-icon"><img src="'.$this->config['theme_url'].'icon/more.png" title="'.$this->_t('PageHandlerMoreTip').'" alt="'.$this->_t('PageHandlerMoreTip').'" /> '.$this->_t('PageHandlerMoreTip')."</a> \n";
		// only display 'more' text that shows handler list on hover

		{
			echo '<li class="dropdown"><a href="#" id="more">' . $this->_t('PageHandlerMoreTip') . '<span class="dropdown_arrow">&#9660;</span></a>' . " \n";
			echo '<ul class="dropdown_menu">' . "\n";

			// print tab
			if ($readable)
			{
				$echo_tab('print', 'PrintVersion', 'PrintText', 2, '', 'v', ' target="_blank"');
			}

			// create tab
			if ($this->has_access('create') || $this->is_admin())
			{
				$echo_tab('new', 'CreateNewPageTip', 'CreateNewPageText', 2, '', 'n');
			}

			// clone tab
			if ($this->has_access('create') || $this->is_admin())
			{
				$echo_tab('clone', 'ClonePage', 'CloneText', 2, '', '');
			}

			// remove tab
			if (($this->is_admin()
					|| (!$this->config['remove_onlyadmins']
						&& ($this->forum ? $this->is_owner() && (int)$this->page['comments'] == 0 : $this->is_owner()))))
			{
				$echo_tab('remove', 'DeleteTip', 'DeleteText', 2, '', '');
			}

			// rename tab
			if ($this->is_admin() || ($this->is_owner()
					&& (!$this->forum || (int)$this->page['comments'] != 0)))
			{
				$echo_tab('rename', 'RenameTip', 'RenameText', 2, '', '');
			}

			// moderation tab
			if ($readable && $this->is_moderator())
			{
				$echo_tab('moderate', 'ModerateTip', 'ModerateText', 2, '', 'm');
			}

			// permissions tab
			if (!$this->forum && ($this->is_admin() || $this->is_owner()))
			{
				$echo_tab('permissions', 'ACLTip', 'ACLText', 2, '', 'a');
			}

			// categories tab
			if ($this->is_admin() || $this->is_owner())
			{
				$echo_tab('categories', 'CategoriesTip', 'CategoriesText', 2, '', 'c');
			}

			// referrers tab
			$echo_tab('referrers', 'ReferrersTip', 'ReferrersText', 2, '', 'l');

			// watch tab
				// ($this->forum === false && $this->page && ($this->is_admin() || $this->is_owner())) ? ($this->is_watched === true ? $this->_t('UnWatchText') : $this->_t('WatchText') ) : '',
			if ($logged_in)
			{
				if ($this->is_watched)
				{
					$echo_tab('watch', 'RemoveWatch', 'UnWatchText', 2, 'watch-off', 'w');
				}
				else
				{
					$echo_tab('watch', 'SetWatch', 'WatchText', 2, 'watch-on', 'w');
				}
			}

			// review tab
			if (!$this->forum && $readable && $this->config['review'] && $this->is_reviewer())
			{
				if ($this->page['reviewed'])
				{
					$echo_tab('review', 'RemoveReview', 'Reviewed', 2, 'review2', 'z');
				}
				else
				{
					$echo_tab('review', 'SetReview', 'Review', 2, 'review1', 'z');
				}
			}

			// upload tab
			if (!$this->forum && $this->has_access('upload'))
			{
				$echo_tab('upload', 'FilesTip', 'FilesText', 2, '', 'u');
			}

			// last empty
			echo "<li></li>\n";
			echo "</ul>\n";
			echo "</li>\n";
		}
	}

			// echo "</ul>\n"; // list continues with search
?>
			<li class="search">
				<div id="search_box">
<?php
				// opens search form
				echo $this->form_open('search', ['form_method' => 'get', 'tag' => $this->_t('TextSearchPage')]);

				// searchbar
?>
				<span class="search nobr"><label for="phrase"><?php echo $this->_t('SearchText'); ?></label>
				<input type="search" name="phrase" id="phrase" size="20" />
				<input type="submit" class="submitinput" title="<?php echo $this->_t('SearchButtonText') ?>" value="<?php echo $this->_t('SearchButtonText') ?>"/>
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
		// echo '<br />'.$this->get_user_trail($titles = true, $separator = ' &gt; ', $linking = true, $size = 8);
?>
		</nav>
	</header>
	<main>
<?php

// here we show messages
if (!@$this->sess->MinPHPVersion)
{
	if (version_compare(PHP_VERSION, PHP_MIN_VERSION) < 0)
	{
		$this->show_message($this->_t('ErrorMinPHPVersion'), 'error');
	}

	$this->sess->MinPHPVersion = 1;
}

$this->output_messages();
