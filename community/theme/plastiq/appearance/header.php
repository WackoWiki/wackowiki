<?php

#require (Ut::join_path(THEME_DIR, '_common/_header.php'));

?>
<?php
/*
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
<table style="width:100%;">
	<tr>
		<td style="width:50; height:64; background-image:url(<?php echo $this->db->theme_url ?>images/back_top_1.png);"><img src="<?php echo $this->db->theme_url ?>images/spacer.png" width="50" height="1"></td>
		<td style="background-image:url(<?php echo $this->db->theme_url ?>images/back_top_3.png); background-repeat:repeat-x;">
			<table style="width:100%; background-image:url(<?php echo $this->db->theme_url ?>images/back_top_2.png); background-repeat:no-repeat;">
				<tr>
					<td>
						<div id="title" style="padding-top:5px;">
							<h1><a href="<?php echo $this->href('', $this->db->root_page); ?>"><?php echo htmlspecialchars($this->db->site_name, ENT_COMPAT | ENT_HTML5, HTML_ENTITIES_CHARSET); ?></a></h1>
							<h2><a href="<?php echo $this->href('', $this->db->root_page); ?>"><?php echo htmlspecialchars($this->db->site_desc, ENT_COMPAT | ENT_HTML5, HTML_ENTITIES_CHARSET); ?></a></h2>
						</div>
					</td>
					<td style="vertical-align:top;">
						<div id="controls">
<?php
$user = '';

if ($user = $this->get_user())
{
	echo 'id: ' . $this->link($this->db->users_page . '/' . $this->get_user_name(), '', $this->get_user_name()) . ' &nbsp; <a href="' . $this->href('', $this->_t('AccountLink')) . '" title="' . $this->_t('AccountTip') . '">' . $this->_t('AccountText') . '</a> &nbsp; <a href="' . $this->href('', $this->_t('LoginPage')) . '" title="' . $this->_t('SessionTip') . '">' . $this->_t('Session') . '</a> &nbsp; <a onclick="return confirm(\'' . $this->_t('LogoutAreYouSure') . '\');" href="' . $this->href('', $this->_t('LoginPage'), 'action=logout&amp;goback=' . $this->slim_url($this->tag)) . '" title="' . $this->_t('LogoutButton') . '">' . $this->_t('LogoutLink') . '</a><br>';
}
else
{
?>
	id: <em><?php echo $this->_t('Guest') ;?></em> &nbsp; <a href="<?php echo $this->href('', $this->_t('LoginPage')); ?>" title="log and log in"><?php echo $this->_t('LoginPage'); ?></a> &nbsp; <a href="<?php echo $this->href('', $this->_t('RegistrationPage')); ?>" title="log in"><?php echo $this->_t('RegistrationPage'); ?></a><br>
<?php
}
echo "\n";
?>
							<?php echo $this->_t('CurrentTime') . ' '. $this->get_time_formatted( time() ); ?>
						</div>
					</td>
				</tr>
			</table>
		</td>
		<td style="width:25; background-image:url(<?php echo $this->db->theme_url ?>images/back_top_4.png);"><img src="<?php echo $this->db->theme_url ?>images/spacer.png" width="25" height="1"></td>
		<td style="width:25; background-image:url(<?php echo $this->db->theme_url ?>images/back_top_5.png);"><img src="<?php echo $this->db->theme_url ?>images/spacer.png" width="25" height="1"></td>
	</tr>
	<tr>
		<td style="height:315; vertical-align:top; background-image:url(<?php echo $this->db->theme_url ?>images/back_left_2.png); background-repeat:repeat-y;"><div style="background-image:url(<?php echo $this->db->theme_url ?>images/back_left_1.png); background-repeat:no-repeat; height:311px;"></div></td>
		<td colspan="2" rowspan="2">
			<table style="width:100%; background-color:#FFFFFF;">
				<tr>
					<td style="height:25;" colspan="3">
						<table style="width:100%; background-color:#646464;">
							<tr>
								<td style="width:25; height:25; background-image:url(<?php echo $this->db->theme_url ?>images/panel_left.png);"></td>
								<td style="background-image:url(<?php echo $this->db->theme_url ?>images/panel_mid.png); background-repeat:repeat-x;">
									<div id="navigation">
<?php
	$this->context[++$this->current_context] = '/';
	$this->stop_link_tracking();

	// default menu
	if ($menu = $this->get_default_menu($user['user_lang']))
	{
		foreach ($menu as $menu_item)
		{
			$formatted_menu = $this->format($this->format(strtolower($menu_item[1])), 'post_wacko');

			if ($this->page['page_id'] == $menu_item[0])
			{
				echo '<span class="active">';
			}
			else
			{
				echo '<span>';
			}

			echo $formatted_menu . "</span>\n";
		}
	}

	$this->start_link_tracking();
	$this->current_context--;
	echo "\n";
?>
									</div>
								</td>
								<td style="width:50; text-align:right; background-image:url(<?php echo $this->db->theme_url ?>images/panel_right.png);">
									<div id="tools">
<?php
	if ($this->get_user())
	{
		if (in_array($this->tag, $this->get_menu_links()))
		{
			echo '<div class="bookmark_out"><a href="' . $this->href('', '', 'removebookmark=yes') . '" title="' . $this->_t('RemoveBookmark') . '"><img src="' . $this->db->theme_url . 'images/spacer.png"></a></div>';
		}
		else
		{
			echo '<div class="bookmark_in"><a href="' . $this->href('', '', 'addbookmark=yes') . '" title="' . $this->_t('AddBookmark') . '"><img src="' . $this->db->theme_url . 'images/spacer.png"></a></div>';
		}
	}
	else
	{
		echo '<div class="bookmark_in"><img src="' . $this->db->theme_url . 'images/spacer.png" title="' . $this->_t('CantAddBookmarks') . '"></div>';
	}
	echo "\n";

	$wordsHeight = ( isset($this->categories) ? 'height:42px;' : 'height:29px;' );
?>
									</div>
								</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td colspan="2" style="vertical-align:top; background-image:url(<?php echo $this->db->theme_url ?>images/body_leftmid.png); background-repeat:repeat-y; <?php echo $wordsHeight; ?>">
						<div style="background-image:url(<?php echo $this->db->theme_url ?>images/body_topmid.png); background-repeat:repeat-x; <?php echo $wordsHeight; ?>">
							<div id="meta" style="background-image:url(<?php echo $this->db->theme_url ?>images/body_topleft.png); background-repeat:no-repeat; <?php echo $wordsHeight; ?>">
								<table style="width:100%;">
									<tr>
										<td>
<?php
	if ($this->page)
	{
		if ($this->forum === true)
		{
			if ($owner = $this->get_page_owner())
			{
				echo 'By topic: ' . $this->user_link($owner, $lang = '', true, false) . ', ';
			}

			if ($this->page['created'])
			{
				echo 'Theme open ' . $this->get_time_formatted($this->page['created']);
			}
		}
		else
		{
			if ($owner = $this->get_page_owner())
			{
				echo $this->_t('Owner') . ': ' . $this->user_link($owner, $lang = '', true, false) . ' ';
			}
			else
			{
				echo ( substr($this->tag, 0, strlen($this->db->news_cluster)) == $this->db->news_cluster
					? $this->_t('Nobody') . ' '
					: '<a href="' . $this->href('claim') . '">' . $this->_t('TakeOwnership') . '</a> '
				);
			}

			if ($this->page['created'])
			{
				echo '(' . $this->_t('Created') . ' ' . $this->get_time_formatted($this->page['created']) . '), ';
			}

			echo $this->_t('Modified') . ' ' . $this->get_time_formatted($this->page['modified']) . ' (' . $this->_t('By') . ': ' . $this->user_link($this->page['user_name'], $lang = '', true, false) . ')';
		}
	}
	echo "\n";
?>
										</td>
										<td style="text-align:right;">
<?php
	if ($this->page)
	{
		if ($this->get_user())
		{
			if ($this->is_watched === true)
			{
				?><a href="<?php echo $this->href('watch') ?>" title="<?php echo $this->_t('RemoveWatch'); ?>"><?php echo $this->_t('UnwatchText'); ?></a> &nbsp;&nbsp; <?php
			}
			else
			{
				?><a href="<?php echo $this->href('watch') ?>" title="<?php echo $this->_t('SetWatch'); ?>"><?php echo $this->_t('WatchText'); ?></a> &nbsp;&nbsp; <?php
			}
		}
		?><a href="<?php echo $this->href('print') ?>" title="<?php echo $this->_t('PrintVersion'); ?>"><?php echo $this->_t('PrintText'); ?></a><?php
	}
	echo "\n";
?>
										</td>
									</tr>
								</table>
<?php
	if (isset($this->categories))
	{
		$i = '';
		echo '<div style="white-space:normal;">' . $this->_t('Categories') . ': ';

		foreach ($this->categories as $word)
		{
			if ($i++ > 0) echo ", ";
			echo '<a href="' . $this->href('', $this->_t('SearchPage'), 'filter=pages&amp;keywords='.rawurlencode($word)) . '">' . strtolower($word) . '</a>';
		}

		echo '</div>';
	}
?>
								<div class="path" title="Path to current document">
									<a href="<?php echo $this->db->base_url; ?>"><?php echo $this->db->base_url; ?></a><?php echo $this->get_page_path() ?>
								</div>
							</div>
						</div>
					</td>
					<td rowspan="2" style="width:210; vertical-align:top; background-image:url(<?php echo $this->db->theme_url ?>images/body_rightmid.png); background-position:right; background-repeat:repeat-y;">
						<table style="width:100%;">
							<tr>
								<td style="height:348; vertical-align:top; background-image:url(<?php echo $this->db->theme_url ?>images/body_right.png); background-position:top right; background-repeat:no-repeat;">
									<div id="sidepanel">
										<div style="background-image:url(<?php echo $this->db->theme_url ?>images/glass_top.png); height:20px;"></div>
										<div id="bookmarks">
										<?php
											// outputs bookmarks menu
											echo "<ol>\n";

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

													echo $formatted_menu . "</li>\n";
												}
											}


											echo "\n</ol>";
										?>
										</div>
<?php
	if (preg_match('/^' . $this->db->news_cluster.str_replace('/.+', '\/.+?', $this->db->news_levels) . '/', $this->tag))
	{
		$this->db->hide_index = 1;
	}

	if ($this->page && $this->db->hide_index == 0 && $this->method == 'show')
	{
?>
										<div style="background-image:url(<?php echo $this->db->theme_url ?>images/glass_sub_1.png); height:20px;"></div>
										<div style="background-image:url(<?php echo $this->db->theme_url ?>images/glass_sub_2.png); height:20px;">
											<div style="background-image:url(<?php echo $this->db->theme_url ?>images/glass_sections.png); background-position:right; background-repeat:no-repeat; height:20px;"></div>
										</div>
										<div style="background-image:url(<?php echo $this->db->theme_url ?>images/glass_sub_3.png); height:20px;"></div>
										<div id="sections">
<?php
		if (substr($this->tag, 0, strlen($this->db->forum_cluster)) == $this->db->forum_cluster)
		{
			// forum index
			echo $this->action('tree', array('page' => $this->db->forum_cluster, 'depth' => 1, 'nomark' => 1));
		}
		else if ($this->db->tree_level == 1)
		{
			// lower index
			echo $this->action('tree', array('page' => $this->tag, 'depth' => 1, 'nomark' => 1));
		}
		else if ($this->db->tree_level == 2)
		{
			// upper index
			$page = '/'.substr($this->tag, 0, ( strrpos($this->tag, '/') ? strrpos($this->tag, '/') : strlen($this->tag) ));
			echo $this->action('tree', array('page' => $page, 'depth' => 1, 'nomark' => 1));
		}
		else
		{
			// default index
			$page = '/'.substr($this->tag, 0, ( strrpos($this->tag, '/') ? strrpos($this->tag, '/') : strlen($this->tag) ));
			echo $this->action('tree', array('page' => $page, 'depth' => 2, 'nomark' => 1));
		}
?>
										</div>
										<div style="background-image:url(<?php echo $this->db->theme_url ?>images/glass_mid_2.png); background-repeat:repeat-y; height:20px;"></div>
<?php
	}
	else
	{
?>
										<div style="background-image:url(<?php echo $this->db->theme_url ?>images/glass_mid_1.png); background-repeat:repeat-y; height:20px;"></div>
<?php
	}
	echo "\n";
?>
										<div style="background-image:url(<?php echo $this->db->theme_url ?>images/glass_bot.png); height:5px; background-repeat:no-repeat;"></div>
									</div>
								</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td style="width:25; height:321; vertical-align:top; background-image:url(<?php echo $this->db->theme_url ?>images/body_leftmid.png); background-repeat:repeat-y;">
						<div id="tools" style="background-image:url(<?php echo $this->db->theme_url ?>images/tools_back.png); background-repeat:repeat-y;">
							<div style="background-image:url(<?php echo $this->db->theme_url ?>images/tools_top.png); height:7px;"></div>
<?php
	// defining tabs constructor
	function echo_tab($link, $hint, $title, $active = false, $bonus = '')
	{
		global $engine;

		if ($title == '') return; // no tab;

		$method = substr($link, strrpos($link, '/') + 1);

		if ($active)
		{
			$tab = "<div class=\"$method\"><img src=\"" . $engine->db->theme_url."images/spacer.png\" alt=\"$title\"></div>\n";
		}
		else
		{
			$tab = "<div class=\"$method\"><a href=\"$link\" title=\"$hint\" accesskey=\"$bonus\"><img src=\"" . $engine->db->theme_url."images/spacer.png\" alt=\"$title\"></a></div>\n";
		}

		return $tab;
	}

	// create tab
	echo echo_tab(
		$this->href('new'),
		$this->_t('CreateNewPageTip'),
		$this->_t('CreatePageButton'),
		$this->method == 'new',
		'n');

	// show tab
	echo echo_tab(
		$this->href('show'),
		$this->_t('ShowTip'),
		$this->has_access('read') ? $this->_t('ShowText') : '',
		$this->method == 'show',
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
		'e');

	// revisions tab
	echo echo_tab(
		$this->href('revisions'),
		$this->_t('RevisionTip'),
		((($this->db->hide_revisions == 1 && $this->get_user()) || ($this->db->hide_revisions == 2 && $this->is_owner()) || $this->is_admin() ) && $this->forum === false && $this->page && $this->has_access('read')) ? $this->_t('RevisionText') : '',
		$this->method == 'revisions' || $this->method == 'diff',
		'r');

	// remove tab
	echo echo_tab(
		$this->href('remove'),
		$this->_t('DeleteTip'),
		($this->page && ($this->is_admin() || !$this->db->remove_onlyadmins && (
			($this->forum === true && $this->is_owner() && (int) $this->page['comments'] == 0) ||
			($this->forum === false && $this->is_owner()))))
			? $this->_t('DeleteText')  : '',
		$this->method == 'remove');

	// referrers tab
	echo echo_tab(
		$this->href('referrers'),
		$this->_t('ReferrersTip'),
		($this->page && $this->has_access('read')) ? $this->_t('ReferrersText') : '',
		$this->method == 'referrers' || $this->method == 'referrers_sites',
		'l');

	// moderation tab
	echo echo_tab(
		$this->href('moderate'),
		$this->_t('ModerateTip'),
		($this->is_moderator() && $this->has_access('read')) ? $this->_t('ModerateText') : '',
		$this->method == 'moderate',
		'm');

	// settings tab
	echo echo_tab(
		$this->href('properties'),
		$this->_t('PropertiesTip'),
		(/* $this->forum === false && $this->page && */ ($this->is_admin() /*|| $this->is_moderator() */|| $this->is_owner())) ? $this->_t('PropertiesText') : '',
		$this->method == 'properties' || $this->method == 'rename' || $this->method == 'purge' || $this->method == 'keywords',
		's');

	// upload tab
	echo echo_tab(
		$this->href('upload'),
		$this->_t('FilesTip'),
		(/* $this->forum === false && */ $this->page && $this->has_access('upload')) ? $this->_t('FilesText') : '',
		$this->method == 'upload',
		'u');

	// acls tab
	echo echo_tab(
		$this->href('permissions'),
		$this->_t('ACLTip'),
		($this->forum === false && $this->page && ($this->is_admin() || $this->is_owner())) ? $this->_t('ACLText') : '',
		$this->method == 'permissions',
		'a');
?>
							<div style="background-image:url(<?php echo $this->db->theme_url ?>images/tools_bottom.png); height:7px;"></div>
						</div>
					</td>
					<td style="height:321; vertical-align:top; background-image:url(<?php echo $this->db->theme_url ?>images/body_divider.png); background-repeat:no-repeat;">
						<div id="body"><div id="content">
<?php
	$this->output_messages();
?>
<!-- begin page output -->
