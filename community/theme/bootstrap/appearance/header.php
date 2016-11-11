<?php
/*
 Default theme.
 Common header file.
*/

require (Ut::join_path(THEME_DIR, '_common/_header.php'));


?>
<!-- load bootstrap css -->
<link rel="stylesheet" href="<?php echo $this->db->theme_url ?>./css/bootstrap.css" />
<link rel="stylesheet" href="<?php echo $this->db->theme_url ?>./css/bootstrap.min.css" />

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="./js/jquery-2.1.3.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="./js/bootstrap.min.js"></script>
<script src="./js/bootstrap.js"></script>
<script src="./js/npm.js"></script>

<!-- mobile first -->
<meta name="viewport" content="width=device-width, initial-scale=1">

<!-- init theme -->
<body onload="all_init();" >

<!-- header -->
<nav class="navbar navbar-default">
<div class="container-fluid">
<div class="navbar-header">


<span class="navbar-brand">
<?php echo ($this->page['tag'] == $this->db->root_page ? $this->db->site_name : "<a href=\"".$this->db->base_url."\">".$this->db->site_name."</a>") ?>:


<?php echo (isset($this->page['title']) ? $this->page['title'] : $this->get_page_path() ); ?></span>


</div>
<?php /* <div id="navbar" class="collapse navbar-collapse">
<ul class="nav navbar-nav">
<li class="active">
<li>
<li>
</ul> */
?>

<form class="navbar-form navbar-right" role="search">
<span class="glyphicon glyphicon-search" aria-hidden="true"></span>

	<div id="search">
<?php
// opens search form
echo $this->form_open('search', '', 'get', $this->_t('TextSearchPage'));

// searchbar
?>
<span class="search nobr"><label for="phrase"><?php echo $this->_t('SearchText'); ?></label>
<input type="text" name="phrase" id="phrase" size="20" />
<button class="fa fa-search" type="submit" title="<?php echo $this->_t('SearchButtonText') ?>" alt="<?php echo $this->_t('SearchButtonText') ?>" value="#xf002;"/>
</span>
<?php

// search form close
echo $this->form_close();
?>
</div>

 </form>


</div>
</div>
</nav>


<div class="container-fluid">
<div id="slim-container" class="row">
<div id="slim-background" class="col-md-12">
<h2>Learn</h2>
</div>
</div>


<?php
// outputs bookmarks menu
	echo '<div id="navbar" class="collapse navbar-collapse">';
	echo '<ul class="nav navbar-nav">';
	// echo "<ol>\n"; //
	// main page
	#echo "<li>".$this->compose_link_to_page($this->db->root_page)."</li>\n";

	// menu
	if ($menu = $this->get_menu())
	{
		foreach ($menu as $menu_item)
		{
			$formatted_menu = $this->format($menu_item[2], 'post_wacko');

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
		// determines what it should show: "add to menu" or "remove from menu" icon
		if (!in_array($this->page['page_id'], (array)$this->get_menu_links()))
		{
			echo '<li><a href="'. $this->href('', '', 'addbookmark=yes')
				.'"><img src="'. $this->db->theme_url
				.'icon/bookmark1.png" alt="+" title="'.
				$this->_t('AddToBookmarks') .'"/></a></li>';
		}
		else
		{
			echo '<li><a href="'. $this->href('', '', 'removebookmark=yes')
				.'"><img src="'. $this->db->theme_url
				.'icon/bookmark2.png" alt="-" title="'.
				$this->_t('RemoveFromBookmarks') .'"/></a></li>';
		}
	}
	//echo "\n</ol></div>";//
	echo "</ul>";
?>











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
			$_image = 'spacer.png';
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

				$tab = "<li class=\"$method active\"><span><img src=\"".$engine->db->theme_url."icon/$_image\" alt=\"$title\" />"." ".$_title."</span></li>\n";
			}
			else
			{
				$tab = "<li class=\"$method active\"><span>"." ".$title."</span></li>\n";
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

				$tab = "<li class=\"$method\"><a href=\"$link\" title=\"$hint\" accesskey=\"$accesskey\"><img src=\"".$engine->db->theme_url."icon/$_image\" alt=\"$title\" />".$_title."</a></li>\n";
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
		$this->_t('ShowTip'),
		$this->has_access('read') ? $this->_t('ShowText') : '',
		$this->method == 'show',
		1,
		'v');

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
		'e');

	// revisions tab
	echo echo_tab(
		$this->href('revisions'),
		$this->_t('RevisionTip'),
		($this->forum === false && $this->page && $this->has_access('read') && $this->hide_revisions === false ) ? $this->_t('RevisionText') : '',
		$this->method == 'revisions' || $this->method == 'diff',
		1,
		'r');

	// properties tab
	echo echo_tab(
		$this->href('properties'),
		$this->_t('PropertiesTip'),
		($this->forum === false && $this->page && ($this->is_admin() || $this->is_owner())) ? $this->_t('PropertiesText') : '',
		$this->method == 'properties' || $this->method == 'rename' || $this->method == 'purge' || $this->method == 'keywords',
		1,
		's');

	// show more tab

	// display more icon and text
	# echo "<li class='sublist'><a href='#' id='more-icon'><img src=\"".$this->db->theme_url."icon/more.png\" title=\"".$this->_t('PageHandlerMoreTip')."\" alt=\"".$this->_t('PageHandlerMoreTip')."\" /> ".$this->_t('PageHandlerMoreTip')."</a> \n";
	// only display 'more' text that shows handler list on hover

	if ($this->has_access('read'))
	{
		echo '<li class="dropdown"><a href="#" id="more">'.$this->_t('PageHandlerMoreTip').'<span class="dropdown_arrow">&#9660;</span></a>'." \n";
		echo '<ul class="dropdown_menu">'."\n";

		// print tab
		// TODO: should add 'PrintTip' to the language file
		echo echo_tab(
			$this->href('print'),
			$this->_t('PrintVersion'),
			$this->has_access('read') ? $this->_t('PrintText') : '',
			$this->method == 'print',
			2,
			'v');

		// create tab
		echo echo_tab(
			$this->href('new'),
			$this->_t('CreateNewPageTip'),
			((!$this->page && $this->has_access('create')) || $this->is_admin() ||
				($this->forum === false && $this->has_access('write')) ||
				($this->forum === true && ($this->is_owner() || $this->is_moderator()) && (int) $this->page['comments'] == 0))
				? $this->_t('CreateNewPageText') : '',
			$this->method == 'new',
			2,
			'n');

		// remove tab
		echo echo_tab(
			$this->href('remove'),
			$this->_t('DeleteTip'),
			($this->page && ($this->is_admin() || !$this->db->remove_onlyadmins && (
				($this->forum === true && $this->is_owner() && (int) $this->page['comments'] == 0) ||
				($this->forum === false && $this->is_owner()))))
				? $this->_t('DeleteText') : '',
			$this->method == 'remove',
			2,
			'');

		// rename tab
		echo echo_tab(
			$this->href('rename'),
			$this->_t('RenameTip'),
			($this->page && ($this->is_admin() || $this->is_owner() && (
				($this->forum === true && $this->is_owner() && (int) $this->page['comments'] == 0) ||
				($this->forum === false && $this->is_owner()))))
				? $this->_t('RenameText') : '',
			$this->method == 'rename',
			2,
			'');

		// moderation tab
		echo echo_tab(
			$this->href('moderate'),
			$this->_t('ModerateTip'),
			($this->is_moderator() && $this->has_access('read')) ? $this->_t('ModerateText') : '',
			$this->method == 'moderate',
			2,
			'm');

		// permissions tab
		echo echo_tab(
			$this->href('permissions'),
			$this->_t('ACLTip'),
			($this->forum === false && $this->page && ($this->is_admin() || $this->is_owner())) ? $this->_t('ACLText') : '',
			$this->method == 'permissions',
			2,
			'a');

		// categories tab
		echo echo_tab(
			$this->href('categories'),
			$this->_t('CategoriesTip'),
			($this->forum === false && $this->page && ($this->is_admin() || $this->is_owner())) ? $this->_t('CategoriesText') : '',
			$this->method == 'categories',
			2,
			'c');

		// referrers tab
		echo echo_tab(
			$this->href('referrers'),
			$this->_t('ReferrersTip'),
			($this->page && $this->has_access('read') && $this->get_user()) ? $this->_t('ReferrersText') : '',
			$this->method == 'referrers' || $this->method == 'referrers_sites',
			2,
			'l');

		// watch tab
		echo echo_tab(
			$this->href('watch'),
			($this->iswatched === true ? $this->_t('RemoveWatch') : $this->_t('SetWatch')),
			#($this->forum === false && $this->page && ($this->is_admin() || $this->is_owner())) ? ($this->iswatched === true ? $this->_t('UnWatchText') : $this->_t('WatchText') ) : '',
			($this->page && ($this->get_user())) ? ($this->iswatched === true ? $this->_t('UnWatchText') : $this->_t('WatchText') ) : '',
			$this->method == 'watch',
			($this->iswatched === true ? 'watch-on.png' : 'watch-off.png'),
			'a');

		// review tab
		echo echo_tab(
			$this->href('review'),
			($this->page['reviewed'] == 1 ? $this->_t('RemoveReview') : $this->_t('SetReview')),
			($this->forum === false && $this->page && ($this->db->review && $this->is_reviewer())) ? $this->_t('Review') : '',
			$this->method == 'review',
			($this->page['reviewed'] == 1 ? 'review2.png' : 'review1.png'),
			'z');

		// upload tab
		echo echo_tab(
			$this->href('upload'),
			$this->_t('FilesTip'),
			($this->forum === false && $this->page && $this->has_access('upload')) ? $this->_t('FilesText') : '',
			$this->method == 'upload',
			2,
			'u');

			// last empty
			echo "<li></li>\n";
			echo "</ul>\n";
			echo "</li>\n";
	}
	#echo "</ul>\n"; // list continues with search
?>





</div>


<div class="container">
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
$this->output_messages();
?>
