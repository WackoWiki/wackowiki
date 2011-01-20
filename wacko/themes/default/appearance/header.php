<?php
/*
 Default theme.
 Common header file.
*/

// HTTP header with right Charset settings
header("Content-Type: text/html; charset=".$this->get_charset());
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->page['lang'] ?>" lang="<?php echo $this->page['lang'] ?>">
<head>
	<title><?php echo htmlspecialchars($this->config['wacko_name']).' : '.(isset($this->page['title']) ? $this->page['title'] : $this->add_spaces($this->tag)).($this->method != 'show' ? ' ('.$this->method.')' : '');?></title>
<?php
// We don't need search robots to index subordinate pages, if indexing is disabled globally or per page
if ($this->method != 'show' || $this->page['latest'] == 0 || $this->config['noindex'] == 1 || $this->page['noindex'] == 1)
{
	echo "	<meta name=\"robots\" content=\"noindex, nofollow\" />\n";
}
?>
	<meta name="keywords" content="<?php echo htmlspecialchars($this->get_keywords()); ?>" />
	<meta name="description" content="<?php echo htmlspecialchars($this->get_description()); ?>" />
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
	<link rel="copyright" href="<?php echo htmlspecialchars($this->href('', $this->config['policy_page'])); ?>" title="Copyright" />
<?php } ?>
	<link rel="alternate" type="application/rss+xml" title="<?php echo $this->get_translation('RecentChangesRSS');?>" href="<?php echo $this->config['base_url'];?>xml/changes_<?php echo preg_replace('/[^a-zA-Z0-9]/', '', strtolower($this->config['wacko_name']));?>.xml" />
	<link rel="alternate" type="application/rss+xml" title="<?php echo $this->get_translation('RecentCommentsRSS');?>" href="<?php echo $this->config['base_url'];?>xml/comments_<?php echo preg_replace('/[^a-zA-Z0-9]/', '', strtolower($this->config['wacko_name']));?>.xml" />
<?php if ($this->config['news_cluster']) {?>
	<link rel="alternate" type="application/rss+xml" title="<?php echo $this->get_translation('RecentNewsRSS');?>" href="<?php echo $this->config['base_url'];?>xml/news_<?php echo preg_replace('/[^a-zA-Z0-9]/', '', strtolower($this->config['wacko_name']));?>.xml" />
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
// autocomplete.js, protoedit & wikiedit2.js contain classes for WikiEdit editor. We may include them only on method==edit pages.
if ($this->method == 'edit')
{
	echo "<script type=\"text/javascript\" src=\"".$this->config['base_url']."js/protoedit.js\"></script>\n";
	echo "<script type=\"text/javascript\" src=\"".$this->config['base_url']."js/wikiedit2.js\"></script>\n";
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
<div id="mainwrapper">
	<div id="header">
		<div id="header-main">
			<div id="header-top">
			<span class="main"><?php echo ($this->page['tag'] == $this->config['root_page'] ? $this->config['wacko_name'] : "<a href=\"".$this->config['base_url']."\">".$this->config['wacko_name']."</a>") ?>: </span><?php echo (isset($this->page['title']) ? $this->page['title'] : $this->get_page_path() ); ?> <a class="Search" title="<?php echo $this->get_translation('SearchTitleTip')?>" href="<?php echo $this->config['base_url'].$this->get_translation('TextSearchPage').($this->config['rewrite_mode'] ? "?" : "&amp;");?>phrase=<?php echo urlencode($this->tag); ?>">...</a>
		</div>
		<div id="login">
<?php
// If user are logged, Wacko shows "You are UserName"
if ($this->get_user())
{ ?> <span class="nobr"><?php echo $this->get_translation('YouAre')." ".$this->link($this->get_user_name()) ?></span><small> ( <span class="nobr Tune"><?php
echo $this->compose_link_to_page($this->get_translation('AccountLink'), "", $this->get_translation('AccountText'), 0); ?>
 | <a onclick="return confirm('<?php echo $this->get_translation('LogoutAreYouSure');?>');" href="<?php echo $this->href('', $this->get_translation('LoginPage')).($this->config['rewrite_mode'] ? "?" : "&amp;");?>action=logout&amp;goback=<?php echo $this->slim_url($this->tag);?>"><?php echo $this->get_translation('LogoutLink'); ?></a></span>
)</small>
<?php
// Else Wacko shows login's controls
}
else
{
	// Show Register / Login link
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
// Outputs Bookmarks AKA QuickLinks
	echo '<div id="usermenu">';
	echo "<ol>\n";
	// Main page
	#echo "<li>".$this->compose_link_to_page($this->config['root_page'])."</li>\n";
	echo "<li>";
	// Bookmarks
	$formated_bm = $this->format($this->get_bookmarks_formatted(), 'post_wacko');
	$formated_bm = str_replace ("<br />", "", $formated_bm);
	$formated_bm = str_replace ("\n", "</li>\n<li>", $formated_bm);
	echo $formated_bm;
	echo "</li>\n";

	if ($this->get_user())
	{
		// Here Wacko determines what it should show: "add to Bookmarks" or "remove from Bookmarks" icon
		if (!in_array($this->tag, $this->get_bookmark_links()))
			echo '<li><a href="'. $this->href('', '', 'addbookmark=yes')
				.'"><img src="'. $this->config['theme_url']
				.'icons/bookmark1.gif" alt="+" title="'.
				$this->get_translation('AddToBookmarks') .'"/></a></li>';
		else
			echo '<li><a href="'. $this->href('', '', 'removebookmark=yes')
				.'"><img src="'. $this->config['theme_url']
				.'icons/bookmark2.gif" alt="-" title="'.
				$this->get_translation('RemoveFromBookmarks') .'"/></a></li>';
	}
	echo "\n</ol></div>";
?>
<div id="handler">

<?php
	// defining tabs constructor
	function echo_tab($link, $hint, $title, $active = false, $image, $accesskey = '')
	{
		global $engine;
		if ($title == '') return; // no tab;
		if ($image == 1) $image = 'spacer.gif';

		$method = substr($link, strrpos($link, '/') + 1);

		if ($active)
		{
			if ($image)
			{
				$tab = "<li class=\"$method active\"><img src=\"".$engine->config['theme_url']."icons/$image\" alt=\"$title\" /></li>\n";
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
				$tab = "<li class=\"$method\"><a href=\"$link\" title=\"$hint\" accesskey=\"$accesskey\"><img src=\"".$engine->config['theme_url']."icons/$image\" alt=\"$title\" /></a></li>\n";
			}
			else
			{
				$tab = "<li class=\"$method\"><a href=\"$link\" title=\"$hint\" accesskey=\"$accesskey\">$title</a></li>\n";
			}
		}
		return $tab;
	}

	echo "<ul>\n";

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
		'n');

	// revisions tab
	echo echo_tab(
		$this->href('revisions'),
		$this->get_translation('RevisionTip'),
		($this->forum === false && $this->page && $this->has_access('read')) ? $this->get_translation('RevisionText') : '',
		$this->method == 'revisions' || $this->method == 'diff',
		1,
		'r');

	// remove tab
	#echo echo_tab(
	#	$this->href('remove'),
	#	$this->get_translation('DeleteTip'),
	#	($this->page && ($this->is_admin() || !$this->config['remove_onlyadmins'] && (
	#		($this->forum === true && $this->user_is_owner() && (int)$this->page['comments'] == 0) ||
	#		($this->forum === false && $this->user_is_owner()))))
	#		? $this->get_translation('DeleteText') : '',
	#	0,
	#	$this->method == 'remove');

	// moderation tab
	#echo echo_tab(
	#	$this->href('moderate'),
	#	$this->get_translation('ModerateTip'),
	#	($this->is_moderator() && $this->has_access('read')) ? $this->get_translation('ModerateText') : '',
	#	$this->method == 'moderate',
	#	0,
	#	'm');

	// permissions tab
	echo echo_tab(
		$this->href('permissions'),
		$this->get_translation('ACLTip'),
		($this->forum === false && $this->page && ($this->is_admin() || $this->user_is_owner())) ? $this->get_translation('ACLText') : '',
		$this->method == 'permissions',
		1,
		'a');

	// categories tab
	echo echo_tab(
		$this->href('categories'),
		$this->get_translation('CategoriesTip'),
		($this->forum === false && $this->page && ($this->is_admin() || $this->user_is_owner())) ? $this->get_translation('CategoriesText') : '',
		$this->method == 'categories',
		1,
		'c');

	// referrers tab
	#echo echo_tab(
	#	$this->href('referrers'),
	#	$this->get_translation('ReferrersTip'),
	#	($this->page && $this->has_access('read')) ? $this->get_translation('ReferrersText') : '',
	#	$this->method == 'referrers' || $this->method == 'referrers_sites',
	#	0,
	#	'l');

	// watch tab
	echo echo_tab(
		$this->href('watch'),
		($this->iswatched === true ? $this->get_translation('RemoveWatch') : $this->get_translation('SetWatch')),
		($this->forum === false && $this->page && ($this->is_admin() || $this->user_is_owner())) ? $this->get_translation('SetWatch') : '',
		$this->method == 'watch',
		($this->iswatched === true ? 'watch-on.png' : 'watch-off.png'),
		'a');

	// review tab
	echo echo_tab(
		$this->href('review'),
		($this->page['reviewed'] == 1 ? $this->get_translation('RemoveReview') : $this->get_translation('SetReview')),
		($this->forum === false && $this->page && ($this->config['review'] && $this->is_reviewer())) ? $this->get_translation('SetReview') : '',
		$this->method == 'review',
		($this->page['reviewed'] == 1 ? 'review2.png' : 'review1.png'),
		'z');

	// properties tab
	echo echo_tab(
		$this->href('properties'),
		$this->get_translation('PropertiesTip'),
		($this->forum === false && $this->page && ($this->is_admin() || $this->user_is_owner())) ? $this->get_translation('PropertiesText') : '',
		$this->method == 'properties' || $this->method == 'rename' || $this->method == 'purge' || $this->method == 'keywords',
		1,
		's');

	// upload tab
	echo echo_tab(
		$this->href('upload'),
		$this->get_translation('FilesTip'),
		($this->forum === false && $this->page && $this->has_access('upload')) ? $this->get_translation('FilesText') : '',
		$this->method == 'upload',
		1,
		'u');

	#echo "</ul>\n";
?>
<li class="search">
<div id="search">
<?php
// Opens Search form
echo $this->form_open('', $this->get_translation('TextSearchPage'), 'get');

// Searchbar
?>
<span class="search nobr"><label for="phrase"><?php echo $this->get_translation('SearchText'); ?></label>
<input type="text" name="phrase" id="phrase" size="20" />
<input class="submitinput" type="submit" title="<?php echo $this->get_translation('SearchButtonText') ?>" alt="<?php echo $this->get_translation('SearchButtonText') ?>" value="<?php echo $this->get_translation('SearchButtonText') ?>"/>
</span>
<?php

// Search form close
echo $this->form_close();
?>
</div>
</li></ul>
</div>
</div>
<div class="breadcrumb">
<?php
// Shows breadcrumbs
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