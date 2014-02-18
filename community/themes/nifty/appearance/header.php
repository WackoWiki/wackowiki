<?php
/*
 A nifty theme - maybe someday ;)
 Common header file.
*/

// HTTP header with right charset settings
header("Content-Type: text/html; charset=".$this->get_charset());
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->page['lang'] ?>" lang="<?php echo $this->page['lang'] ?>">
<head>
	<title><?php echo htmlspecialchars($this->config['site_name'], ENT_COMPAT | ENT_HTML401, HTML_ENTITIES_CHARSET).' : '.(isset($this->page['title']) ? $this->page['title'] : $this->add_spaces($this->tag)).($this->method != 'show' ? ' ('.$this->method.')' : '');?></title>
<?php
// We don't need search robots to index subordinate pages, if indexing is disabled globally or per page
if ($this->method != 'show' || $this->page['latest'] == 0 || $this->config['noindex'] == 1 || $this->page['noindex'] == 1)
{
	echo "	<meta name=\"robots\" content=\"noindex, nofollow\" />\n";
}
?>
	<meta name="keywords" content="<?php echo htmlspecialchars($this->get_keywords(), ENT_COMPAT | ENT_HTML401, HTML_ENTITIES_CHARSET); ?>" />
	<meta name="description" content="<?php echo htmlspecialchars($this->get_description(), ENT_COMPAT | ENT_HTML401, HTML_ENTITIES_CHARSET); ?>" />
	<meta name="language" content="<?php echo $this->page['lang'] ?>" />
	<meta http-equiv="content-type" content="text/html; charset=<?php echo $this->get_charset(); ?>" />

	<link rel="stylesheet" type="text/css" href="<?php echo $this->config['theme_url'] ?>css/default.css" />
	<?php if ($this->config['allow_x11colors']) {?>
	<link rel="stylesheet" type="text/css" href="<?php echo $this->config['base_url'] ?>themes/_common/X11colors.css" />
	<?php } ?>
	<link media="print" rel="stylesheet" type="text/css" href="<?php echo $this->config['theme_url'] ?>css/print.css" />
	<link rel="shortcut icon" href="<?php echo $this->config['theme_url'] ?>icons/favicon.ico" type="image/x-icon" />
	<link  rel="start" title="<?php echo $this->config['root_page'];?>" href="<?php echo $this->config['base_url'];?>"/>
	<?php if ($this->config['policy_page']) {?>
	<link rel="copyright" href="<?php echo htmlspecialchars($this->href('', $this->config['policy_page']), ENT_COMPAT | ENT_HTML401, HTML_ENTITIES_CHARSET); ?>" title="Copyright" />
	<?php } ?>
	<link rel="alternate" type="application/rss+xml" title="<?php echo $this->get_translation('RecentChangesRSS');?>" href="<?php echo $this->config['base_url'];?>xml/changes_<?php echo preg_replace('/[^a-zA-Z0-9]/', '', strtolower($this->config['site_name']));?>.xml" />
	<link rel="alternate" type="application/rss+xml" title="<?php echo $this->get_translation('RecentCommentsRSS');?>" href="<?php echo $this->config['base_url'];?>xml/comments_<?php echo preg_replace('/[^a-zA-Z0-9]/', '', strtolower($this->config['site_name']));?>.xml" />
	<?php if ($this->config['news_cluster']) {?>
	<link rel="alternate" type="application/rss+xml" title="<?php echo $this->get_translation('RecentNewsRSS');?>" href="<?php echo $this->config['base_url'];?>xml/news_<?php echo preg_replace('/[^a-zA-Z0-9]/', '', strtolower($this->config['site_name']));?>.xml" />
	<?php } ?>
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
	echo "<script type=\"text/javascript\" src=\"".$this->config['base_url']."js/swfobject.js\"></script>\n";
}
// autocomplete.js, protoedit & wikiedit.js contain classes for WikiEdit editor. We include them only for pages in edit mode.
if ($this->method == 'edit')
{
	echo "<script type=\"text/javascript\" src=\"".$this->config['base_url']."js/protoedit.js\"></script>\n";
	echo "<script type=\"text/javascript\" src=\"".$this->config['base_url']."js/wikiedit.js\"></script>\n";
	echo "<script type=\"text/javascript\" src=\"".$this->config['base_url']."js/autocomplete.js\"></script>\n";
}
?>
	<script type="text/javascript" src="<?php echo $this->config['base_url'];?>js/captcha.js"></script>
<?php
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
				echo ($this->page['tag'] == $this->config['root_page'] ? $this->config['site_name'] : "<a href=\"".$this->config['base_url']."\">".$this->config['site_name']."</a>")
				?></span>
				<?php # echo (isset($this->page['title']) ? $this->page['title'] : $this->get_page_path() ); ?>
			</div>

			<div id="user-area">
				<?php
				// outputs bookmarks aka menu items
				// there are default bookmarks and user bookmarks
				// you can use them independetly or within one list
					echo "<div id=\"usermenu\">\n\t\t\t\t\t";
					echo "<ul><li class=\"sublist\">";

							// compose link with icon to bookmarks list
							// TODO: add BookmarkTip to translation
							echo "<a class=\"bookmark\"><img class=\"bookmark-icon\" src=\"".$this->config['theme_url']."icons/bookmark.png\" title=\"".$this->get_translation('ReferrersTip')."\" alt=\"".$this->get_translation('ReferrersText')."\" /></a>";

							// display bookmarks text
							# ".$this->get_translation('Bookmarks')."

						echo "<ol>\n";
						// main page
						#echo "<li>".$this->compose_link_to_page($this->config['root_page'])."</li>\n";
						#echo "<li>";
						// get all bookmarks - old version
						#$formatedBMs = $this->format($this->get_bookmarks_formatted(), 'post_wacko');
						#$formatedBMs = str_replace ("\n", "</li>\n<li>", $formatedBMs);
						#echo $formatedBMs;

						// get default bookmarks - if not already displayed at global menu div
						// $formated_default_bookmarks = $this->format($this->get_default_bookmarks($user['lang']), 'wiki');
						// $formated_default_bookmarks = str_replace ("\n", "</li>\n\t\t\t\t\t<li>", $formated_default_bookmarks);
						// echo $formated_default_bookmarks;

						// get user bookmarks - old version
						#$formated_user_bookmarks = $this->format($this->get_user_bookmarks($user['user_id']), 'wiki');
						#$formated_user_bookmarks = str_replace ("\n", "</li>\n\t\t\t\t\t<li>", $formated_user_bookmarks);
						#echo $formated_user_bookmarks;

						#echo "</li>\n";


						// bookmarks
						// TODO: should be taken out of user session
						foreach ($this->get_user_menu($user['user_id']) as $_bookmark)
						{
						$formatted_user_menu = $this->format($_bookmark[1], 'wiki');

						if ($this->page['page_id'] == $_bookmark[0])
						{
							echo '<li class="active">';
						}
						else
						{
							echo '<li>';
						}

							echo $formatted_user_menu."</li>\n\t\t\t\t\t";
						}

						// now show add or remove bookmark link
						// takes stuff out of user session unlike get_user_bookmarks above
						if ($this->get_user())
						{
							if (in_array($this->page['page_id'], $this->get_menu_links()))
							{
								echo "<div class=\"bookmark_remove\"><a href=\"".$this->href('', '', 'removebookmark=yes')."\"><img title=\"".$this->get_translation('RemoveFromBookmarks')."\" src=\"".$this->config['theme_url']."icons/spacer.png\" /></a></div>";
							}
							else
							{
								echo '<div class="bookmark_add"><a href="'.$this->href('', '', 'addbookmark=yes').'" title="'.$this->get_translation('AddToBookmarks').'"><img src="'.$this->config['theme_url'].'icons/spacer.png" /></a></div>';
							}
						}
						else
						{
							echo '<div class="bookmark_add"><img src="'.$this->config['theme_url'].'icons/spacer.png" title="'.$this->get_translation('CantAddBookmarks').'" /></div>';
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
						echo "<a href=\"".$this->config['base_url'].$this->config['users_page']."/".$this->get_user_name()."\"><img src=\"".$this->config['theme_url']."icons/user_identity_white.png\" title=\"".$this->get_translation('YouAre').$this->get_user_name()."\" alt=\"".$this->get_translation('YouAre').$this->get_user_name()."\" /></a>\n";
						?>
						<span class="nobr">
						<?php
						// display link to user space at UserList cluster (distinct namespace later on)
						echo $this->compose_link_to_page($this->config['users_page']."/".$this->get_user_name(), "", $this->get_user_name(), 0);

						// TODO: tag ( | ) properly so we can apply css rules
						?>
						</span>
						(
						<?php
						// compose user account settings icon with link to account settings page
						echo "<a href=\"".$this->config['base_url'].$this->get_translation('AccountLink')."\"><img src=\"".$this->config['theme_url']."icons/account_settings_white.png\" title=\"".$this->get_translation('AccountTip')."\" alt=\"".$this->get_translation('AccountTip')."\" /></a>\n";
						// display link to user settings page
						echo $this->compose_link_to_page($this->get_translation('AccountLink'), "", $this->get_translation('AccountText'), 0);
						// display logout icon and link
						?>
						 |
						<a onclick="return confirm('<?php echo $this->get_translation('LogoutAreYouSure');?>');"
							href="<?php echo $this->href('', $this->get_translation('LoginPage')).($this->config['rewrite_mode'] ? "?" : "&amp;");?>action=logout&amp;goback=<?php echo $this->slim_url($this->tag);?>"><?php echo "<img src=\"".$this->config['theme_url']."icons/logout.png\" title=\"".$this->get_translation('LogoutButton')."\" alt=\"".$this->get_translation('LogoutButton')."\" />"; ?>
						</a>
						<a onclick="return confirm('<?php echo $this->get_translation('LogoutAreYouSure');?>');"
							href="<?php echo $this->href('', $this->get_translation('LoginPage')).($this->config['rewrite_mode'] ? "?" : "&amp;");?>action=logout&amp;goback=<?php echo $this->slim_url($this->tag);?>"><?php echo $this->get_translation('LogoutLink'); ?>
						</a>
						)
					<?php
					// else show login controls
					}
					else
					{
						// show register / login link
						echo "<ul>\n<li>".$this->compose_link_to_page($this->get_translation('LoginPage').($this->config['rewrite_mode'] ? "?" : "&amp;")."goback=".$this->slim_url($this->tag), "", $this->get_translation('LoginPage'), 0)."</li>\n";
						echo "<li>".$this->compose_link_to_page($this->get_translation('RegistrationPage'), "", $this->get_translation('RegistrationPage'), 0)."</li>\n";
						// echo "<li>".$this->compose_link_to_page($this->get_translation('RegistrationPage'), "", $this->get_translation('Help'), 0)."</li>\n";
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
					#$formated_default_menu = $this->format($this->get_default_menu($user['lang']), 'wiki');
					#$formated_default_menu = str_replace ("\n", "</li>\n\t\t\t\t\t<li>", $formated_default_menu);
					#echo $formated_default_menu;
					#echo "</li>\n";

					#$this->context[++$this->current_context] = '/';
					#$this->stop_link_tracking();

					foreach ($this->get_default_menu($user['lang']) as $_menu)
					{
						$formatted_menu = $this->format($this->format($_menu[1]), 'post_wacko');

						if ($this->page['page_id'] == $_menu[0])
						{
							echo '<li class="active">';
						}
						else
						{
							echo '<li>';
						}

						echo $formatted_menu."</li>\n\t\t\t\t\t";
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
	echo ($this->page['tag'] == $this->config['root_page'] ? "<img class=\"home-icon\" src=\"".$this->config['theme_url']."icons/home_grey_suse.png\" title=\"".$this->config['root_page']."\" alt=\"".$this->config['root_page']."\" />\n" : "<a href=\"".$this->config['base_url']."\"><img class=\"home-icon\" src=\"".$this->config['theme_url']."icons/home_grey_suse.png\" title=\"".$this->config['root_page']."\" alt=\"".$this->config['root_page']."\" /></a>");
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
		echo $this->form_open('', $this->get_translation('TextSearchPage'), 'get');

		// searchbar
		?>
		<span class="search nobr"><label for="phrase"><?php echo $this->get_translation('SearchText'); ?></label>
		<input type="text" name="phrase" id="phrase" size="15" />
		<input id="search-submit-button" class="submitinput" type="submit" title="<?php echo $this->get_translation('SearchButtonText') ?>" alt="<?php echo $this->get_translation('SearchButtonText') ?>" value="<?php echo $this->get_translation('SearchButtonText') ?>" />
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
		if ($message = $this->get_message())
		{
			echo "<div class=\"info\">$message</div>";
		}
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
			$this->page['tag'] != $this->config['permalink_page'] &&
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
				echo $this->get_translation('TOCTitle');
				?>
				</div>
				<div id="sidebar-toc-list" class="sidebar-toc-list">
				<?php
				// display the page toc list, numerated, without labels and markup
				echo $this->action('toc', array('numerate' => 0, 'nomark' => 1));
				?>
				</div>
			</div>
			<!-- end: sidebar-toc-list-wrapper -->

			<div id="sidebar-tree-wrapper" class="tree-wrapper sidebar-box">
				<div id="sidebar-tree-header" class="tree-header sidebar-box-header">
				<?php
				// $this->get_translation('TreeClusterTitle');
				echo $this->get_translation('TreeClusterHeader'); // subpages (de: Unterseiten)
				?>
				</div>

				<div id="sidebar-tree" class="sidebar-tree">
					<?php
					// display all subpages for this page/cluster, 3 levels down
					echo $this->action('tree', array('page' => $this->tag, 'depth' => 3, 'nomark' => 1));

					// tree
					#if ($this->config['tree_level'] == 1)
					#{
					    // lower index
					#    echo $this->action('tree', array('page' => $this->tag, 'depth' => 1, 'nomark' => 0));
					#}
					#else if ($this->config['tree_level'] == 2)
					#{
					    // upper index
					#    $page = '/'.substr($this->tag, 0, ( strrpos($this->tag, '/') ? strrpos($this->tag, '/') : strlen($this->tag) ));
					#    echo $this->action('tree', array('page' => $page, 'depth' => 1, 'nomark' => 0));
					#}
					#else
					#{
					    // default index
					#    $page = '/'.substr($this->tag, 0, ( strrpos($this->tag, '/') ? strrpos($this->tag, '/') : strlen($this->tag) ));
					#    echo $this->action('tree', array('page' => $page, 'depth' => 3, 'nomark' => 0));
					#}
					?>
				</div>
			</div>
			<!-- end: sidebar-tree-wrapper -->

			<div id="sidebar-user-bookmarks-wrapper" class="user-bookmarks-wrapper sidebar-box">
				<div id="sidebar-user-bookmarks-header" class="user-bookmarks-header sidebar-box-header">
				<span>
				<?php
				echo $this->get_translation('Bookmarks');
				?>
				</span>
				</div>
				<div id="sidebar-user-bookmarks-list" class="sidebar-user-bookmarks-list">
					<?php
					// display the user bookmarks list and the add/remove-current-page-from-bookmarks-icon
					echo "<ul>\n";
						// TODO: should be taken out of user session
						foreach ($this->get_user_menu($user['user_id']) as $_menu)
						{
						$formatted_user_menu = $this->format($_menu[1], 'wiki');

						if ($this->page['page_id'] == $_menu[0])
						{
							echo '<li class="active">';
						}
						else
						{
							echo '<li>';
						}

							echo $formatted_user_menu."</li>\n\t\t\t\t\t";
						}

						// now show add or remove menu link
						// takes stuff out of user session unlike get_user_menu above
						if ($this->get_user())
						{
							if (in_array($this->page['page_id'], $this->get_menu_links()))
							{
								echo "<div class=\"bookmark_remove\"><a href=\"".$this->href('', '', 'removebookmark=yes')."\"><img title=\"".$this->get_translation('RemoveFromBookmarks')."\" src=\"".$this->config['theme_url']."icons/spacer.png\" /></a></div>";
							}
							else
							{
								echo '<div class="bookmark_add"><a href="'.$this->href('', '', 'addbookmark=yes').'" title="'.$this->get_translation('AddToBookmarks').'"><img src="'.$this->config['theme_url'].'icons/spacer.png" /></a></div>';
							}
						}
						else
						{
							echo '<div class="bookmark_add"><img src="'.$this->config['theme_url'].'icons/spacer.png" title="'.$this->get_translation('CantAddBookmarks').'" /></div>';
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
				echo $this->get_translation('RecentCommentsThisPage');
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
				echo $this->get_translation('Categories');
				?>
				</div>
				<div id="sidebar-page-categories-list" class="sidebar-page-categories-list">
				<?php
				// display the categories for this page
				// TODO: use category action so you can display all categories (?)
				// needs to reference to $this->config['category_page'] at line 142 instead of self
				echo $this->action('categories', array('list' => 1, 'nomark' => 1));
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
							echo "<a class=\"toc-icon\"><img src=\"".$this->config['theme_url']."icons/toc_ordered.png\" title=\"".$this->get_translation('MetaToc')."\" alt=\"".$this->get_translation('MetaToc')."\" /></a>\n";

							// display the page toc list, numerated (?), without labels and markup
							// toc numerated does not work as intended
							echo "<div id=\"toc-list\">\n";
							echo $this->action("toc", array('numerate' => '', 'nomark' => 1));
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
					// displays the page title or page tag above page content
					// TODO: might want to make this clickable for any other than the show handler only
					echo "<a title=\"". $this->page['title'] ."\" href=\"".$this->config['base_url'].$this->tag."\">" . (isset($this->page['title']) ? $this->page['title'] : $this->tag) . "</a>";
					?>
				</div>

				<div id="back-to-page-button" class="button">
					<?php
					// if a page is accessed by any other page handler than 'show'
					// display a "back-to-page" button/icon next to the page tag/title
					if ($this->method !== 'show')
					{
						echo "<a href=\"".$this->config['base_url'].$this->tag."\"><img src=\"".$this->config['theme_url']."icons/show_back.png\" title=\"".$this->get_translation('ShowTip')."\" alt=\"".$this->get_translation('ShowText')."\" /></a>";
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
										$tab = "<li class=\"$method active\"><img src=\"".$engine->config['theme_url']."icons/$image_name\" alt=\"$title\" />".$title."</li>\n";
									}
								else if ($display_option == 1)
								{
									// img only
									$tab = "<li class=\"$method active\"><img src=\"".$engine->config['theme_url']."icons/$image_name\" alt=\"$title\" /></li>\n";
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
									$tab = "<li class=\"$method\"><a href=\"$link\" title=\"$hint\" accesskey=\"$accesskey\"><img src=\"".$engine->config['theme_url']."icons/$image_name\" alt=\"$title\" />".$title."</a></li>\n";
								}
								else if ($display_option == 1)
								{
									// img only
									$tab = "<li class=\"$method\"><a href=\"$link\" title=\"$hint\" accesskey=\"$accesskey\"><img src=\"".$engine->config['theme_url']."icons/$image_name\" alt=\"$title\" /></a></li>\n";
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
					#	$this->get_translation('ShowTip'),
					#	$this->has_access('read') ? $this->get_translation('ShowText') : '',
					#	$this->method == 'show',
					#	1,
					#	'',
					#	'v');

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
						'',
						'e');

					// revisions tab
					echo echo_tab(
						$this->href('revisions'),
						$this->get_translation('RevisionTip'),
						($this->forum === false && $this->page && $this->has_access('read')) ? $this->get_translation('RevisionText') : '',
						$this->method == 'revisions' || $this->method == 'diff',
						1,
						'',
						'r');

					// show more tab
					// TODO: add translation to all theme translations ... $this->get_translation('PageHandlerMoreTip')
					// display more icon with descriptive text
					# echo "<li class='sublist'><a href='#' id='more-icon'><img src=\"".$this->config['theme_url']."icons/more.png\" title=\"".$this->get_translation('PageHandlerMoreTip')."\" alt=\"".$this->get_translation('PageHandlerMoreTip')."\" /> more</a> \n";
					// display 'more' text that shows a list with page handlers on hover
					echo "<li class='sublist'><a href='#' id='more'>".$this->get_translation('PageHandlerMoreTip')."</a> \n\t";
						echo "<ul class='sublist'>\n\t";

						// upload tab
						echo echo_tab(
							$this->href('upload'),
							$this->get_translation('FilesTip'),
							($this->forum === false && $this->page /*&& $this->has_access('upload')*/) ? $this->get_translation('FilesText') : '',
							$this->method == 'upload',
							1,
							'',
							'u');

						// create tab
						echo echo_tab(
							$this->href('new'),
							$this->get_translation('CreateNewPageTip'),
							((!$this->page && $this->has_access('create')) || $this->is_admin() ||
								($this->forum === false && $this->has_access('write')) ||
								($this->forum === true && ($this->user_is_owner() || $this->is_moderator()) && (int)$this->page['comments'] == 0))
								? $this->get_translation('CreateNewPageText') : '',
							$this->method == 'new',
							1,
							'',
							'n');

						// print tab
						// TODO: should add 'PrintTip' to the language file
						echo echo_tab(
							$this->href('print'),
							$this->get_translation('PrintVersion'),
							$this->has_access('read') ? $this->get_translation('PrintVersion') : '',
							$this->method == 'print',
							1,
							'',
							'v');

						// remove tab used to be named delete
						echo echo_tab(
							$this->href('remove'),
							$this->get_translation('DeleteTip'),
							($this->page && ($this->is_admin() || !$this->config['remove_onlyadmins'] && (
								($this->forum === true && $this->user_is_owner() && (int)$this->page['comments'] == 0) ||
								($this->forum === false && $this->user_is_owner()))))
								? $this->get_translation('DeleteText') : '',
							$this->method == 'remove',
							1,
							'',
							'');

						// rename tab
						// TODO: validate this forum BS, only copy & paste from above
						echo echo_tab(
							$this->href('rename'),
							$this->get_translation('RenameText'),
							($this->page && (($this->is_admin() || $this->user_is_owner()) && (
								($this->forum === true && $this->user_is_owner() && (int)$this->page['comments'] == 0) ||
								($this->forum === false && $this->user_is_owner()))))
								? $this->get_translation('RenameText') : '',
							$this->method == 'rename',
							1,
							'',
							'');

						// moderation tab
						echo echo_tab(
							$this->href('moderate'),
							$this->get_translation('ModerateTip'),
							($this->is_moderator() && $this->has_access('read')) ? $this->get_translation('ModerateText') : '',
							$this->method == 'moderate',
							1,
							'',
							'm');

						// permissions tab
						echo echo_tab(
							$this->href('permissions'),
							$this->get_translation('ACLTip'),
							($this->forum === false && $this->page && ($this->is_admin() || $this->user_is_owner())) ? $this->get_translation('ACLText') : '',
							$this->method == 'permissions',
							1,
							'',
							'a');

						// categories tab
						echo echo_tab(
							$this->href('categories'),
							$this->get_translation('CategoriesTip'),
							($this->forum === false && $this->page && ($this->is_admin() || $this->user_is_owner())) ? $this->get_translation('CategoriesText') : '',
							$this->method == 'categories',
							1,
							'',
							'c');

						// referrers tab
						echo echo_tab(
							$this->href('referrers'),
							$this->get_translation('ReferrersTip'),
							($this->page && $this->has_access('read')) ? $this->get_translation('ReferrersText') : '',
							$this->method == 'referrers' || $this->method == 'referrers_sites',
							1,
							'',
							'l');

						// watch tab
						#echo echo_tab(
						#	$this->href(($this->iswatched === true ? 'watch-on' : 'watch-off')),
						#	($this->iswatched === true ? $this->get_translation('RemoveWatch') : $this->get_translation('SetWatch')),
						#	($this->forum === false && $this->page && ($this->is_admin() || $this->user_is_owner())) ? ($this->iswatched === true ? $this->get_translation('UnWatchText') : $this->get_translation('WatchText') ) : '',
						#	$this->method == 'watch',
						#	1,
						#	'a');

						echo echo_tab(
							$this->href('watch'),
							($this->iswatched === true ? $this->get_translation('RemoveWatch') : $this->get_translation('SetWatch')),
							($this->forum === false && $this->page && ($this->is_admin() || $this->user_is_owner())) ? ($this->iswatched === true ? $this->get_translation('UnWatchText') : $this->get_translation('WatchText') ): '',
							$this->method == 'watch',
							1,
							($this->iswatched === true ? 'watch-on.png' : 'watch-off.png'),
							'a');

						// review tab
						echo echo_tab(
							$this->href('review'),
							($this->page['reviewed'] == 1 ? $this->get_translation('RemoveReview') : $this->get_translation('SetReview')),
							($this->forum === false && $this->page && ($this->config['review'] && $this->is_reviewer())) ? ($this->page['reviewed'] == 1 ? $this->get_translation('RemoveReview') : $this->get_translation('SetReview') ) : '',
							$this->method == 'review',
							1,
							($this->page['reviewed'] == 1 ? 'review-remove.png' : 'review-set.png'),
							'z');

						// properties tab
						echo echo_tab(
							$this->href('properties'),
							$this->get_translation('PropertiesTip'),
							($this->forum === false && $this->page && ($this->is_admin() || $this->user_is_owner())) ? $this->get_translation('PropertiesText') : '',
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
					if ($this->config['review'] == 1 &&
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
						// TODO: add translation for all other languages ... $this->get_translation('ReviewNoticeUserAttention')
						echo "<a href=\"".$this->config['base_url'].$this->tag."/revisions"."\">".$this->get_translation('ReviewNoticeUserAttention')."</a>";
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