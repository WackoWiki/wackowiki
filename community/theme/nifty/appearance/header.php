<?php
/*
 A nifty theme - maybe someday ;)
 Common header file.
*/

// HTTP header with right charset settings
header("Content-Type: text/html; charset=" . $this->get_charset());
?>
<!DOCTYPE html>
<html lang="<?php echo $this->page['page_lang'] ?>">
<head>
	<title><?php echo htmlspecialchars($this->db->site_name, ENT_COMPAT | ENT_HTML5, HTML_ENTITIES_CHARSET) . ' : '.(isset($this->page['title']) ? $this->page['title'] : $this->add_spaces($this->tag)).($this->method != 'show' ? ' (' . $this->method . ')' : '');?></title>
<?php
// We don't need search robots to index subordinate pages, if indexing is disabled globally or per page
if ($this->method != 'show' || $this->page['latest'] == 0 || $this->db->noindex == 1 || $this->page['noindex'] == 1)
{
	echo "	<meta name=\"robots\" content=\"noindex, nofollow\">\n";
}
?>
	<meta name="keywords" content="<?php echo htmlspecialchars($this->get_keywords(), ENT_COMPAT | ENT_HTML5, HTML_ENTITIES_CHARSET); ?>">
	<meta name="description" content="<?php echo htmlspecialchars($this->get_description(), ENT_COMPAT | ENT_HTML5, HTML_ENTITIES_CHARSET); ?>">
	<meta name="language" content="<?php echo $this->page['page_lang'] ?>">
	<meta charset="<?php echo $this->get_charset(); ?>">

	<link rel="stylesheet" href="<?php echo $this->db->theme_url ?>css/default.css">
	<?php if ($this->db->allow_x11colors) {?>
	<link rel="stylesheet" href="<?php echo Ut::join_path(THEME_DIR, "_common/X11colors.css"); ?>">
	<?php } ?>
	<link media="print" rel="stylesheet" href="<?php echo $this->db->theme_url ?>css/print.css">
	<link rel="icon" href="<?php echo $this->db->theme_url ?>icon/favicon.ico" type="image/x-icon">
	<link  rel="start" title="<?php echo $this->db->root_page;?>" href="<?php echo $this->db->base_url;?>">
	<?php if ($this->db->terms_page) {?>
	<link rel="license" href="<?php echo htmlspecialchars($this->href('', $this->db->terms_page), ENT_COMPAT | ENT_HTML5, HTML_ENTITIES_CHARSET); ?>" title="Copyright">
	<?php } ?>
	<link rel="alternate" type="application/rss+xml" title="<?php echo $this->_t('ChangesFeed');?>" href="<?php echo $this->db->base_url . XML_DIR . '/changes_' . preg_replace('/[^a-zA-Z0-9]/', '', strtolower($this->db->site_name));?>.xml">
	<link rel="alternate" type="application/rss+xml" title="<?php echo $this->_t('CommentsFeed');?>" href="<?php echo $this->db->base_url . XML_DIR . '/comments_' . preg_replace('/[^a-zA-Z0-9]/', '', strtolower($this->db->site_name));?>.xml">
	<?php if ($this->db->news_cluster) {?>
	<link rel="alternate" type="application/rss+xml" title="<?php echo $this->_t('NewsFeed');?>" href="<?php echo $this->db->base_url . XML_DIR . '/news_' . preg_replace('/[^a-zA-Z0-9]/', '', strtolower($this->db->site_name));?>.xml">
	<?php } ?>
	<link rel="alternate" type="application/rss+xml" title="<?php echo $this->_t('RevisionsFeed');?><?php echo $this->tag; ?>" href="<?php echo $this->href('revisions.xml');?>">
<?php
// JS files.
// default.js contains common procedures and should be included everywhere
?>
	<script src="<?php echo $this->db->base_url;?>js/default.js"></script>
<?php
// autocomplete.js, protoedit & wikiedit.js contain classes for WikiEdit editor. We include them only for pages in edit mode.
if ($this->method == 'edit')
{
	echo "<script src=\"" . $this->db->base_url . "js/protoedit.js\"></script>\n";
	echo '<script src="' . $this->db->base_url . 'js/lang/wikiedit.' . $this->user_lang . '.js"></script>' . "\n";
	echo "<script src=\"" . $this->db->base_url . "js/wikiedit.js\"></script>\n";
	echo "<script src=\"" . $this->db->base_url . "js/autocomplete.js\"></script>\n";
}

// Doubleclick edit feature.
// Enabled only for registered users who don't swith it off (requires class=page in show handler).
$doubleclick = '';
if ($user = $this->get_user())
{
	if ($user['doubleclick_edit'] == 1)
	{
		$doubleclick = true;
	}
}
else if($this->has_access('write'))
{
	$doubleclick = true;
}
if ($doubleclick == true)
{
?>
	<script>
	var edit = "<?php echo $this->href('edit');?>";
	</script>
<?php
}
?>
</head>

<body>

<div id="top-background"></div>
<div id="top-background-second"></div>

<div id="mainwrapper">
	<div id="header">
		<div id="header-content">
			<div id="site-home">
				<span class="main">
				<?php
				// display WackoName and make it clickable if not already at the wiki root
				// TODO: drop a commented line here for using a logo image instead of the wikis name
				echo ($this->page['tag'] == $this->db->root_page ? $this->db->site_name : "<a href=\"" . $this->db->base_url."\">" . $this->db->site_name . "</a>")
				?></span>
				<?php # echo (isset($this->page['title']) ? $this->page['title'] : $this->get_page_path() ); ?>
			</div>

			<div id="user-area">
				<?php
				// outputs bookmarks aka menu items
				// there are default bookmarks and user bookmarks
				// you can use them independetly or within one list
					echo "<div id=\"menu-user\">\n\t\t\t\t\t";
					echo "<ul><li class=\"sublist\">";

							// compose link with icon to bookmarks list
							// TODO: add BookmarkTip to translation
							echo "<a class=\"bookmark\"><img class=\"bookmark-icon\" src=\"" . $this->db->theme_url."icon/bookmark-dark.svg\" title=\"" . $this->_t('ReferrersTip') . "\" alt=\"" . $this->_t('ReferrersText') . "\"></a>";

							// display bookmarks text
							# " . $this->_t('Bookmarks') . "

						echo "<ol>\n";

						// bookmarks
						// TODO: should be taken out of user session
						foreach ($this->get_user_menu($user['user_id']) as $_bookmark)
						{
							$formatted_user_menu = $this->format($_bookmark[2], 'wiki');

							if ($this->page['page_id'] == $_bookmark[0])
							{
								echo '<li class="active">';
							}
							else
							{
								echo '<li>';
							}

							echo $formatted_user_menu . "</li>\n\t\t\t\t\t";
						}

						// now show add or remove bookmark link
						// takes stuff out of user session unlike get_user_bookmarks above
						if ($this->get_user())
						{
							if (in_array($this->page['page_id'], $this->get_menu_links()))
							{
								echo "<div class=\"bookmark_remove\"><a href=\"" . $this->href('', '', 'removebookmark=1') . "\"><img title=\"" . $this->_t('RemoveBookmark') . "\" src=\"" . $this->db->theme_url."icon/spacer.png\"></a></div>";
							}
							else
							{
								echo '<div class="bookmark_add"><a href="' . $this->href('', '', 'addbookmark=1') . '" title="' . $this->_t('AddBookmark') . '"><img src="' . $this->db->theme_url . 'icon/spacer.png"></a></div>';
							}
						}
						else
						{
							echo '<div class="bookmark_add"><img src="' . $this->db->theme_url . 'icon/spacer.png" title="' . $this->_t('CantAddBookmarks') . '"></div>';
						}
						echo "\n";

						echo "\n</ol>";

					echo "</li></ul></div>\n";
				?>

				<div id="login">
					<?php
					// If user are logged, Wacko shows "You are UserName"
					if ($this->get_user())
					{
						// compose user identity icon with link to user page
						echo "<a href=\"" . $this->db->base_url.$this->db->users_page . '/' . $this->get_user_name() . "\"><img src=\"" . $this->db->theme_url."icon/user_white.svg\" title=\"" . $this->_t('YouAre').$this->get_user_name() . "\" alt=\"" . $this->_t('YouAre').$this->get_user_name() . "\"></a>\n";
						?>
						<span class="nobr">
						<?php
						// display link to user space at UserList cluster (distinct namespace later on)
						echo $this->compose_link_to_page($this->db->users_page . '/' . $this->get_user_name(), "", $this->get_user_name());

						// TODO: tag ( | ) properly so we can apply css rules
						?>
						</span>
						(
						<?php
						// compose user account settings icon with link to account settings page
						echo "<a href=\"" . $this->db->base_url.$this->_t('AccountLink') . "\"><img src=\"" . $this->db->theme_url."icon/account_settings_white.png\" title=\"" . $this->_t('AccountTip') . "\" alt=\"" . $this->_t('AccountTip') . "\"></a>\n";
						// display link to user settings page
						echo $this->compose_link_to_page($this->_t('AccountLink'), "", $this->_t('AccountText'));
						// display logout icon and link
						?>
						 |
						<a onclick="return confirm('<?php echo $this->_t('LogoutAreYouSure');?>');"
							href="<?php echo $this->href('', $this->_t('LoginPage'), 'action=logout&amp;goback=' . $this->slim_url($this->tag));?>"><?php echo "<img src=\"" . $this->db->theme_url."icon/logout.png\" title=\"" . $this->_t('LogoutButton') . "\" alt=\"" . $this->_t('LogoutButton') . "\">"; ?>
						</a>
						<a onclick="return confirm('<?php echo $this->_t('LogoutAreYouSure');?>');"
							href="<?php echo $this->href('', $this->_t('LoginPage'), 'action=logout&amp;goback=' . $this->slim_url($this->tag));?>"><?php echo $this->_t('LogoutLink'); ?>
						</a>
						)
					<?php
					// else show login controls
					}
					else
					{
						// show register / login link
						echo "<ul>\n<li>" . $this->compose_link_to_page($this->_t('LoginPage'), "", $this->_t('LoginPage'), '', null, "goback=" . $this->slim_url($this->tag)) . "</li>\n";
						echo "<li>" . $this->compose_link_to_page($this->_t('RegistrationPage'), "", $this->_t('RegistrationPage')) . "</li>\n";
						// echo "<li>" . $this->compose_link_to_page($this->_t('RegistrationPage'), "", $this->_t('Help')) . "</li>\n";
						echo "</ul>\n";
					}
					// End if
					?>
				</div>
				<!-- end: "login" -->
			</div>
			<!-- end: "user-area" -->

			<div id="global-menu">
				<ul id="global-menu-items">
					<?php
					// display global bookmarks as a user menu, inline top
					// use default bookmarks (owner is system-user)


					#$this->context[++$this->current_context] = '/';
					#$this->stop_link_tracking();

					foreach ($this->get_default_menu($user['user_lang']) as $_menu)
					{
						$formatted_menu = $this->format($this->format($_menu[2]), 'post_wacko');

						if ($this->page['page_id'] == $_menu[0])
						{
							echo '<li class="active">';
						}
						else
						{
							echo '<li>';
						}

						echo $formatted_menu . "</li>\n\t\t\t\t\t";
					}

					#$this->start_link_tracking();
					#$this->current_context--;

					?>
				</ul>
			</div>
			<!-- end: "global-menu" -->
		</div>
		<!-- end: "header-content" -->
	</div>
	<!-- end: header -->

	<div class="breadcrumbs">
	<?php
	// display a home icon, clickable if its not the root page
	echo ($this->page['tag'] == $this->db->root_page ? "<img class=\"home-icon\" src=\"" . $this->db->theme_url."icon/home.svg\" title=\"" . $this->db->root_page."\" alt=\"" . $this->db->root_page."\">\n" : "<a href=\"" . $this->db->base_url."\"><img class=\"home-icon\" src=\"" . $this->db->theme_url."icon/home.svg\" title=\"" . $this->db->root_page."\" alt=\"" . $this->db->root_page."\"></a>");
	echo " &gt; ";
	// show breadcrumbs
	echo "<span class=\"breadcrumb\">" . $this->get_page_path($titles = false, $separator = ' &gt; ', $linking = true) . "</span>";
	?>
	</div>
	<!-- end: breadcrumbs -->

	<div id="search-wrapper" class="search-wrapper-height">
		<div class="border-box-top-right search-wrapper-height"></div>
		<div class="border-box-bottom-left search-wrapper-height"></div>
		<div class="border-box-top-left search-wrapper-height"></div>
		<div class="border-box-bottom-right search-wrapper-height"></div>

		<div id="search">
		<?php
		// opens search form
		echo $this->form_open('search', ['form_method' => 'get', 'tag' => $this->_t('SearchPage')]);

		// searchbar
		?>
		<span class="search nobr"><label for="phrase"><?php echo $this->_t('SearchText'); ?></label>
		<input type="search" name="phrase" id="phrase" size="15">
		<input type="submit" id="search-submit-button" class="submitinput" title="<?php echo $this->_t('SearchButton') ?>" alt="<?php echo $this->_t('SearchButton') ?>" value="<?php echo $this->_t('SearchButton') ?>">
		</span>
		<?php
		// search form close
		echo $this->form_close();
		?>
		</div>
		<!-- end: search -->
	</div>
	<!-- end: search-wrapper -->

	<div id="content">

		<?php
		// displays messages
		// TODO: position this div static and use some js to hide it on click or after some seconds
		$this->output_messages();
		?>

		<?php
		// sidebar div contains six sidebar boxes:
		//		toc: this page,
		//		tree: this page and one level down,
		//		user bookmarks: if logged in,
		//		last comments: this page; with anchors to comments below page,
		//		categories: this page,
		//		tag cloud: global
		// simply comment or remove those that you don't need

		// only include sidebar for show handler and existing pages
		// TODO: do not show sidebar for handler pages like Comments, Index, etc
		// TODO: some js onclick dispay/hide for each box and sidebar
		if ($this->page &&
			$this->method == 'show' &&
			$this->page['tag'] != 'Category')
		{
		?>
		<div id="sidebar">
			<?php
			// side bar toc list
			// TODO: add condition to only display if toc array is not empty ...
			// TODO: if ($this->has_access('read', $_page['page_id'])) ?
			?>
			<div id="sidebar-toc-list-wrapper" class="toc-list-wrapper sidebar-box">
				<div id="sidebar-toc-list-header" class="toc-list-header sidebar-box-header">
				<?php
				echo $this->_t('TOCTitle');
				?>
				</div>
				<div id="sidebar-toc-list" class="sidebar-toc-list">
				<?php
				// display the page toc list, numerated, without labels and markup
				echo $this->action('toc', ['numerate' => 0, 'nomark' => 1]);
				?>
				</div>
			</div>
			<!-- end: sidebar-toc-list-wrapper -->

			<div id="sidebar-tree-wrapper" class="tree-wrapper sidebar-box">
				<div id="sidebar-tree-header" class="tree-header sidebar-box-header">
				<?php
				// $this->_t('TreeClusterTitle');
				echo $this->_t('TreeClusterHeader'); // subpages (de: Unterseiten)
				?>
				</div>

				<div id="sidebar-tree" class="sidebar-tree">
					<?php
					// display all subpages for this page/cluster, 3 levels down
					echo $this->action('tree', ['page' => $this->tag, 'depth' => 3, 'nomark' => 1]);

					// tree
					#if ($this->db->tree_level == 1)
					#{
					    // lower index
					#    echo $this->action('tree', ['page' => $this->tag, 'depth' => 1, 'nomark' => 0]);
					#}
					#else if ($this->db->tree_level == 2)
					#{
					    // upper index
					#    $page = '/'.substr($this->tag, 0, ( strrpos($this->tag, '/') ? strrpos($this->tag, '/') : strlen($this->tag) ));
					#    echo $this->action('tree', ['page' => $page, 'depth' => 1, 'nomark' => 0]);
					#}
					#else
					#{
					    // default index
					#    $page = '/'.substr($this->tag, 0, ( strrpos($this->tag, '/') ? strrpos($this->tag, '/') : strlen($this->tag) ));
					#    echo $this->action('tree', ['page' => $page, 'depth' => 3, 'nomark' => 0]);
					#}
					?>
				</div>
			</div>
			<!-- end: sidebar-tree-wrapper -->

			<div id="sidebar-user-bookmarks-wrapper" class="user-bookmarks-wrapper sidebar-box">
				<div id="sidebar-user-bookmarks-header" class="user-bookmarks-header sidebar-box-header">
				<span>
				<?php
				echo $this->_t('Bookmarks');
				?>
				</span>
				</div>
				<div id="sidebar-user-bookmarks-list" class="sidebar-user-bookmarks-list">
					<?php
					// display the user bookmarks list and the add/tool-current-page-from-bookmarks-icon
					echo "<ul>\n";
						// TODO: should be taken out of user session
						foreach ($this->get_user_menu($user['user_id']) as $_menu)
						{
						$formatted_user_menu = $this->format($_menu[2], 'wiki');

						if ($this->page['page_id'] == $_menu[0])
						{
							echo '<li class="active">';
						}
						else
						{
							echo '<li>';
						}

							echo $formatted_user_menu . "</li>\n\t\t\t\t\t";
						}

						// now show add or remove menu link
						// takes stuff out of user session unlike get_user_menu above
						if ($this->get_user())
						{
							if (in_array($this->page['page_id'], $this->get_menu_links()))
							{
								echo "<div class=\"bookmark_remove\"><a href=\"" . $this->href('', '', 'removebookmark=yes') . "\"><img title=\"" . $this->_t('RemoveBookmark') . "\" src=\"" . $this->db->theme_url."icon/spacer.png\"></a></div>";
							}
							else
							{
								echo '<div class="bookmark_add"><a href="' . $this->href('', '', 'addbookmark=yes') . '" title="' . $this->_t('AddBookmark') . '"><img src="' . $this->db->theme_url . 'icon/spacer.png"></a></div>';
							}
						}
						else
						{
							echo '<div class="bookmark_add"><img src="' . $this->db->theme_url . 'icon/spacer.png" title="' . $this->_t('CantAddBookmarks') . '"></div>';
						}
						echo "\n";

						echo "\n</ul>";

					?>
				</div>
			</div>
			<!-- end: sidebar-user-bookmarks-wrapper -->


			<div id="sidebar-page-recent-comments-wrapper" class="page-recent-comments-wrapper sidebar-box">
				<div id="sidebar-page-recent-comments-header" class="page-recent-comments-header sidebar-box-header">
				<?php
				echo $this->_t('RecentCommentsThisPage');
				?>
				</div>
				<div id="sidebar-page-recent-comments-list" class="sidebar-page-recent-comments-list">
				<?php
				// display recent comments for this page
				echo "CommentTitle  UserName";
				?>
				</div>
			</div>
			<!-- end: sidebar-page-recent-comments-wrapper -->


			<div id="sidebar-page-categories-wrapper" class="page-categories-wrapper sidebar-box">
				<div id="sidebar-page-categories-header" class="page-categories-header sidebar-box-header">
				<?php
				echo $this->_t('Categories');
				?>
				</div>
				<div id="sidebar-page-categories-list" class="sidebar-page-categories-list">
				<?php
				// display the categories for this page
				// TODO: use category action so you can display all categories (?)
				// needs to reference to $this->db->category_page at line 142 instead of self
				echo $this->action('categories', ['list' => 1, 'nomark' => 1]);
				?>
				</div>
			</div>
			<!-- end: sidebar-page-categories-wrapper -->

		</div>
		<!-- end: sidebar -->
		<?php
		// end if: include sidebar for show-page handler only
		}
		?>

		<div id="main-content-wrapper">
			<div class="box-header">
				<div id="toc-button-wrapper" class="button">
					<ul>
						<li>
						<?php
						// inserts the toc list if page handler method is 'show'
						// TODO: only insert if there is more than zero (or one?) headline
						if ($this->method == 'show')
						{
							// TODO: add translation TocTip and TocText
							// compose image to indicate a toc-list
							echo "<a class=\"toc-icon\"><img src=\"" . $this->db->theme_url."icon/toc-ordered.svg\" title=\"" . $this->_t('MetaToc') . "\" alt=\"" . $this->_t('MetaToc') . "\"></a>\n";

							// display the page toc list, numerated (?), without labels and markup
							// toc numerated does not work as intended
							echo "<div id=\"toc-list\">\n";
							echo $this->action('toc', ['numerate' => '', 'nomark' => 1]);
							echo "</div>\n";
						}
						// TODO: else ... maybe insert a spacer to get in line with header vertical text flow
						?>
						</li>
					</ul>
				</div>
				<!-- end: toc-button-wrapper -->

				<div id="page-title" class="tab-horizontal">
					<?php
					// hide  H1 article header
					$this->hide_article_header = true;
					// displays the page title or page tag above page content
					// TODO: might want to make this clickable for any other than the show handler only
					echo "<a title=\"". $this->page['title'] ."\" href=\"" . $this->db->base_url.$this->tag."\">" . (isset($this->page['title']) ? $this->page['title'] : $this->tag) . "</a>";
					?>
				</div>

				<div id="back-to-page-button" class="button">
					<?php
					// if a page is accessed by any other page handler than 'show'
					// display a "back-to-page" button/icon next to the page tag/title
					if ($this->method !== 'show')
					{
						echo "<a href=\"" . $this->db->base_url.$this->tag."\"><img src=\"" . $this->db->theme_url."icon/show-back.svg\" title=\"" . $this->_t('ShowTip') . "\" alt=\"" . $this->_t('ShowText') . "\"></a>";
					}
					?>
				</div>

				<div id="handler">
				<?php
					// tabs constructor
					// TODO: shouldn't this function become part of some wacko class ?
					// display_option - 2 image and text, 1 image only, 0 text only
					// image_name: optional, if spacer.png and img display via css is not used
					function echo_tab($link, $hint, $title, $active = false, $display_option, $image_name = false, $accesskey = '')
					{
						global $engine;

						$_image = '';
						#$_title = '';

						if ($title == '') return; // no tab;
						if (!$image_name) $image_name = 'spacer.png';

						$method = substr($link, strrpos($link, '/') + 1);

						if ($active)
						{
							if ($display_option)
							{
								if ($display_option == 2)
									{
										// img + text
										$tab = "<li class=\"$method active\"><img src=\"" . $engine->db->theme_url."icon/$image_name\" alt=\"$title\">" . $title . "</li>\n";
									}
								else if ($display_option == 1)
								{
									// img only
									$tab = "<li class=\"$method active\"><img src=\"" . $engine->db->theme_url."icon/$image_name\" alt=\"$title\"></li>\n";
								}
							}
							else
							{
								// text only
								$tab = "<li class=\"$method active\">$title</li>\n";
							}
						}
						else
						{
							if ($method == 'show') $link = ".";

							if ($display_option)
							{
								if ($display_option == 2)
								{
									// img and text
									$tab = "<li class=\"$method\"><a href=\"$link\" title=\"$hint\" accesskey=\"$accesskey\"><img src=\"" . $engine->db->theme_url."icon/$image_name\" alt=\"$title\">" . $title . "</a></li>\n";
								}
								else if ($display_option == 1)
								{
									// img only
									$tab = "<li class=\"$method\"><a href=\"$link\" title=\"$hint\" accesskey=\"$accesskey\"><img src=\"" . $engine->db->theme_url."icon/$image_name\" alt=\"$title\"></a></li>\n";
								}
							}
							else
							{
								// text only
								$tab = "<li class=\"$method\"><a href=\"$link\" title=\"$hint\" accesskey=\"$accesskey\">$title</a></li>\n";
							}
						}
						return $tab;
					}

					// output tabs
					echo "<ul>\n\t";

					// show tab
					#echo echo_tab(
					#	$this->href('show'),
					#	$this->_t('ShowTip'),
					#	$this->has_access('read') ? $this->_t('ShowText') : '',
					#	$this->method == 'show',
					#	1,
					#	'',
					#	'v');

					// edit tab
					echo echo_tab(
						$this->href('edit'),
						$this->_t('EditTip'),
						((!$this->page && $this->has_access('create')) || $this->is_admin() ||
							($this->forum === false && $this->has_access('write')) ||
							($this->forum === true && ($this->is_owner() || $this->is_moderator()) && (int) $this->page['comments'] == 0))
							? $this->_t('EditText') : '',
						$this->method == 'edit',
						1,
						'',
						'e');

					// revisions tab
					echo echo_tab(
						$this->href('revisions'),
						$this->_t('RevisionTip'),
						($this->forum === false && $this->page && $this->has_access('read')) ? $this->_t('RevisionText') : '',
						$this->method == 'revisions' || $this->method == 'diff',
						1,
						'',
						'r');

					// show more tab
					// TODO: add translation to all theme translations ... $this->_t('PageHandlerMoreTip')
					// display more icon with descriptive text
					# echo "<li class='sublist'><a href='#' id='more-icon'><img src=\"" . $this->db->theme_url."icon/more.png\" title=\"" . $this->_t('PageHandlerMoreTip') . "\" alt=\"" . $this->_t('PageHandlerMoreTip') . "\"> more</a> \n";
					// display 'more' text that shows a list with page handlers on hover
					echo "<li class='sublist'><a href='#' id='more'>" . $this->_t('PageHandlerMoreTip') . "</a> \n\t";
						echo "<ul class='sublist'>\n\t";

						// upload tab
						echo echo_tab(
							$this->href('upload'),
							$this->_t('FilesTip'),
							($this->forum === false && $this->page /*&& $this->has_access('upload')*/) ? $this->_t('FilesText') : '',
							$this->method == 'upload',
							1,
							'',
							'u');

						// create tab
						echo echo_tab(
							$this->href('new'),
							$this->_t('CreateNewPageTip'),
							((!$this->page && $this->has_access('create')) || $this->is_admin() ||
								($this->forum === false && $this->has_access('write')) ||
								($this->forum === true && ($this->is_owner() || $this->is_moderator()) && (int) $this->page['comments'] == 0))
								? $this->_t('CreateNewPageText') : '',
							$this->method == 'new',
							1,
							'',
							'n');

						// print tab
						// TODO: should add 'PrintTip' to the language file
						echo echo_tab(
							$this->href('print'),
							$this->_t('PrintVersion'),
							$this->has_access('read') ? $this->_t('PrintVersion') : '',
							$this->method == 'print',
							1,
							'',
							'v');

						// remove tab used to be named delete
						echo echo_tab(
							$this->href('remove'),
							$this->_t('DeleteTip'),
							($this->page && ($this->is_admin() || !$this->db->remove_onlyadmins && (
								($this->forum === true && $this->is_owner() && (int) $this->page['comments'] == 0) ||
								($this->forum === false && $this->is_owner()))))
								? $this->_t('DeleteText') : '',
							$this->method == 'remove',
							1,
							'',
							'');

						// rename tab
						// TODO: validate this forum BS, only copy & paste from above
						echo echo_tab(
							$this->href('rename'),
							$this->_t('RenameText'),
							($this->page && (($this->is_admin() || $this->is_owner()) && (
								($this->forum === true && $this->is_owner() && (int) $this->page['comments'] == 0) ||
								($this->forum === false && $this->is_owner()))))
								? $this->_t('RenameText') : '',
							$this->method == 'rename',
							1,
							'',
							'');

						// moderation tab
						echo echo_tab(
							$this->href('moderate'),
							$this->_t('ModerateTip'),
							($this->is_moderator() && $this->has_access('read')) ? $this->_t('ModerateText') : '',
							$this->method == 'moderate',
							1,
							'',
							'm');

						// permissions tab
						echo echo_tab(
							$this->href('permissions'),
							$this->_t('ACLTip'),
							($this->forum === false && $this->page && ($this->is_admin() || $this->is_owner())) ? $this->_t('ACLText') : '',
							$this->method == 'permissions',
							1,
							'',
							'a');

						// categories tab
						echo echo_tab(
							$this->href('categories'),
							$this->_t('CategoriesTip'),
							($this->forum === false && $this->page && ($this->is_admin() || $this->is_owner())) ? $this->_t('CategoriesText') : '',
							$this->method == 'categories',
							1,
							'',
							'c');

						// referrers tab
						echo echo_tab(
							$this->href('referrers'),
							$this->_t('ReferrersTip'),
							($this->page && $this->has_access('read')) ? $this->_t('ReferrersText') : '',
							$this->method == 'referrers' || $this->method == 'referrers_sites',
							1,
							'',
							'l');

						// watch tab
						#echo echo_tab(
						#	$this->href(($this->is_watched === true ? 'watch-on' : 'watch-off')),
						#	($this->is_watched === true ? $this->_t('RemoveWatch') : $this->_t('SetWatch')),
						#	($this->forum === false && $this->page && ($this->is_admin() || $this->is_owner())) ? ($this->is_watched === true ? $this->_t('UnwatchText') : $this->_t('WatchText') ) : '',
						#	$this->method == 'watch',
						#	1,
						#	'a');

						echo echo_tab(
							$this->href('watch'),
							($this->is_watched === true ? $this->_t('RemoveWatch') : $this->_t('SetWatch')),
							($this->forum === false && $this->page && ($this->is_admin() || $this->is_owner())) ? ($this->is_watched === true ? $this->_t('UnwatchText') : $this->_t('WatchText') ): '',
							$this->method == 'watch',
							1,
							($this->is_watched === true ? 'watch-on.svg' : 'watch-off.svg'),
							'a');

						// review tab
						echo echo_tab(
							$this->href('review'),
							($this->page['reviewed'] == 1 ? $this->_t('RemoveReview') : $this->_t('SetReview')),
							($this->forum === false && $this->page && ($this->db->review && $this->is_reviewer())) ? ($this->page['reviewed'] == 1 ? $this->_t('RemoveReview') : $this->_t('SetReview') ) : '',
							$this->method == 'review',
							1,
							($this->page['reviewed'] == 1 ? 'review-remove.png' : 'review-set.png'),
							'z');

						// properties tab
						echo echo_tab(
							$this->href('properties'),
							$this->_t('PropertiesTip'),
							($this->forum === false && $this->page && ($this->is_admin() || $this->is_owner())) ? $this->_t('PropertiesText') : '',
							$this->method == 'properties' || $this->method == 'purge' || $this->method == 'keywords',
							1,
							'',
							's');

						// closes inner sublist (more tab)
						echo "</ul>\n\t";
					echo "</li>\n\t";

					// closes tabs list
					echo "</ul>\n";
					?>

				</div>
				<!-- end: (page-)handler -->

				<div id="review-notification" class="notice">
					<?php
					// if a page has not been reviewed display a notice
					// TODO: add a condition to display this only for certain clusters
					if ($this->db->review == 1 &&
						$this->page['reviewed'] == 0 &&
						$this->method == 'show' &&
						// this determines the cluster(s) or pages - or whatever you declare within the regex - that display the review notification
						// http://www.php.net/manual/en/reference.pcre.pattern.syntax.php
						// '/^ClusterTagToBeReviewed/i' - matches a certain Cluster at the beginning, case-insensitive
						// '/PageNamesToBeReviewed$/i' matches page names (tags) at the end
						// ''/SomeText/i' matches for all pages that contain SomeText within its page tag
						// make sure to escape slashes within the supertag properly: \/
						preg_match('/^users\/wikiadmin/i', $this->page['supertag']) )
					{
						// TODO: add translation for all other languages ... $this->_t('ReviewNoticeUserAttention')
						echo "<a href=\"" . $this->db->base_url.$this->tag."/revisions"."\">" . $this->_t('ReviewNoticeUserAttention') . "</a>";
					}
					else
					{
						// do not display a notice if page has been reviewed
						#echo "";
					}
					?>
				</div>
				<!-- end: review-notification -->
			</div>
			<!-- end: box-header -->
