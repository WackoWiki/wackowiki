<?php
	header('Content-Type: text/html; charset='.$this->get_charset());
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo htmlspecialchars($this->config['wacko_name']); ?> : <?php echo $this->get_page_path(true, $separator = '/', false); ?></title>
<?php
// We don't need search robots to index subordinate pages, if indexing is disabled globally or per page
if ($this->method != 'show' || $this->page['latest'] == 0 || $this->config['noindex'] == 1 || $this->page['noindex'] == 1)
{
	echo "	<meta name=\"robots\" content=\"noindex, nofollow\" />\n";
}
?>
<meta name="keywords" content="<?php echo htmlspecialchars($this->get_keywords()); ?>" />
<meta name="description" content="<?php echo htmlspecialchars($this->get_description()); ?>" />
<meta http-equiv="content-type" content="text/html; charset=<?php echo $this->get_charset(); ?>" />
<meta http-equiv="imagetoolbar" content="no" />
<link href="<?php echo $this->config['theme_url'] ?>css/atom.css" rel="stylesheet" type="text/css" media="screen" />
<?php if ($this->config['allow_x11colors'])
{?>
<link rel="stylesheet" type="text/css" href="<?php echo $this->config['base_url'] ?>themes/_common/X11colors.css" />
<?php } ?>
<link href="<?php echo $this->config['theme_url'] ?>css/wacko.css" rel="stylesheet" type="text/css" media="screen" />
<link href="<?php echo $this->config['theme_url'] ?>css/default.css" rel="stylesheet" type="text/css" media="screen" />
<link rel="start" href="/" />
<link rel="credits" href="<?php echo htmlspecialchars($this->href('', $this->config['policy_page'])); ?>" />
<link rel="alternate" type="application/rss+xml" title="<?php echo $this->get_translation('RecentNewsRSS');?>" href="<?php echo $this->config['base_url'];?>xml/news_<?php echo preg_replace('/[^a-zA-Z0-9]/', '', strtolower($this->config['wacko_name'])); ?>.xml" />
<link rel="alternate" type="application/rss+xml" title="<?php echo $this->get_translation('RecentCommentsRSS');?>" href="<?php echo $this->config['base_url'];?>xml/comments_<?php echo preg_replace('/[^a-zA-Z0-9]/', '', strtolower($this->config['wacko_name'])); ?>.xml" />
<link rel="alternate" type="application/rss+xml" title="<?php echo $this->get_translation('RecentChangesRSS');?>" href="<?php echo $this->config['base_url'];?>xml/changes_<?php echo preg_replace('/[^a-zA-Z0-9]/', '', strtolower($this->config['wacko_name'])); ?>.xml" />
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
<body onload="all_init();">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td width="50" height="64" style="background-image:url(<?php echo $this->config['theme_url'] ?>images/back_top_1.png);"><img src="<?php echo $this->config['theme_url'] ?>images/spacer.gif" width="50" height="1" /></td>
		<td style="background-image:url(<?php echo $this->config['theme_url'] ?>images/back_top_3.png); background-repeat:repeat-x;">
			<table width="100%" border="0" cellspacing="0" cellpadding="0" style="background-image:url(<?php echo $this->config['theme_url'] ?>images/back_top_2.png); background-repeat:no-repeat;">
				<tr>
					<td>
						<div id="title" style="padding-top:5px;">
							<h1><a href="<?php echo $this->href('', $this->config['root_page']); ?>"><?php echo htmlspecialchars($this->config['wacko_name']); ?></a></h1>
							<h2><a href="<?php echo $this->href('', $this->config['root_page']); ?>"><?php echo htmlspecialchars($this->config['wacko_desc']); ?></a></h2>
						</div>
					</td>
					<td valign="top">
						<div id="controls">
							<a name="top"></a>
<?php
$user = '';

if ($user = $this->get_user())
{
	echo 'id: '.$this->get_user_name().' &nbsp; <a href="'.$this->href('', $this->get_translation('AccountLink')).'" title="'.$this->get_translation('AccountTip').'">'.$this->get_translation('AccountText').'</a> &nbsp; <a href="'.$this->href('', $this->get_translation('LoginPage')).'" title="'.$this->get_translation('SessionTip').'">'.$this->get_translation('Session').'</a> &nbsp; <a onclick="return confirm(\''.$this->get_translation('LogoutAreYouSure').'\');" href="'.$this->href('', $this->get_translation('LoginPage'), 'action=logout&amp;goback='.$this->slim_url($this->tag)).'" title="'.$this->get_translation('LogoutButton').'">'.$this->get_translation('LogoutLink').'</a><br />';
}
else
{
?>
	id: <em><?php echo $this->get_translation('Guest') ;?></em> &nbsp; <a href="<?php echo $this->href('', $this->get_translation('LoginPage')); ?>" title="log and log in"><?php echo $this->get_translation('LoginPage'); ?></a> &nbsp; <a href="<?php echo $this->href('', $this->get_translation('RegistrationPage')); ?>" title="log in"><?php echo $this->get_translation('RegistrationPage'); ?></a><br />
<?php
}
echo "\n";
?>
							<?php echo $this->get_translation('CurrentTime').' '. date($this->config['time_format_seconds'].' '.$this->config['date_format'], time()); ?>
						</div>
					</td>
				</tr>
			</table>
		</td>
		<td width="25" style="background-image:url(<?php echo $this->config['theme_url'] ?>images/back_top_4.png);"><img src="<?php echo $this->config['theme_url'] ?>images/spacer.gif" width="25" height="1" /></td>
		<td width="25" style="background-image:url(<?php echo $this->config['theme_url'] ?>images/back_top_5.png);"><img src="<?php echo $this->config['theme_url'] ?>images/spacer.gif" width="25" height="1" /></td>
	</tr>
	<tr>
		<td height="315" valign="top" style="background-image:url(<?php echo $this->config['theme_url'] ?>images/back_left_2.png); background-repeat:repeat-y;"><div style="background-image:url(<?php echo $this->config['theme_url'] ?>images/back_left_1.png); background-repeat:no-repeat; height:311px;"></div></td>
		<td colspan="2" rowspan="2">
			<table width="100%" border="0" cellspacing="0" cellpadding="0" style="background-color:#FFFFFF;">
				<tr>
					<td height="25" colspan="3">
						<table width="100%" border="0" cellspacing="0" cellpadding="0" style="background-color:#646464;">
							<tr>
								<td width="25" height="25" style="background-image:url(<?php echo $this->config['theme_url'] ?>images/panel_left.png);"></td>
								<td style="background-image:url(<?php echo $this->config['theme_url'] ?>images/panel_mid.png); background-repeat:repeat-x;">
									<div id="navigation">
<?php
	$this->context[++$this->current_context] = '/';
	$this->stop_link_tracking();
	echo $this->format($this->format(strtolower(str_replace("\n", ' ', $this->get_default_bookmarks($user['lang'])))), 'post_wacko');
	$this->start_link_tracking();
	$this->current_context--;
	echo "\n";
?>
									</div>
								</td>
								<td width="50" align="right" style="background-image:url(<?php echo $this->config['theme_url'] ?>images/panel_right.png);">
									<div id="tools">
<?php
	if ($this->get_user())
	{
		if (in_array($this->tag, $this->get_bookmark_links()))
		{
			echo '<div class="bookmark_out"><a href="'.$this->href('', '', 'removebookmark=yes').'" title="'.$this->get_translation('RemoveFromBookmarks').'"><img src="'.$this->config['theme_url'].'images/spacer.gif" /></a></div>';
		}
		else
		{
			echo '<div class="bookmark_in"><a href="'.$this->href('', '', 'addbookmark=yes').'" title="'.$this->get_translation('AddToBookmarks').'"><img src="'.$this->config['theme_url'].'images/spacer.gif" /></a></div>';
		}
	}
	else
	{
		echo '<div class="bookmark_in"><img src="'.$this->config['theme_url'].'images/spacer.gif" title="'.$this->get_translation('CantAddBookmarks').'" /></div>';
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
					<td colspan="2" valign="top" style="background-image:url(<?php echo $this->config['theme_url'] ?>images/body_leftmid.png); background-repeat:repeat-y; <?php echo $wordsHeight; ?>">
						<div style="background-image:url(<?php echo $this->config['theme_url'] ?>images/body_topmid.png); background-repeat:repeat-x; <?php echo $wordsHeight; ?>">
							<div id="meta" style="background-image:url(<?php echo $this->config['theme_url'] ?>images/body_topleft.png); background-repeat:no-repeat; <?php echo $wordsHeight; ?>">
								<table width="100%" border="0" cellspacing="0" cellpadding="0">
									<tr>
										<td>
<?php
	if ($this->page)
	{
		if ($this->forum === true)
		{
			if ($this->user_is_owner())
			{
				echo 'Thread poster: You, ';
			}
			else if ($owner = $this->get_page_owner())
			{
				echo 'By topic: '.( $owner == GUEST
					? '<em>'.$this->get_translation('Guest').'</em>'
					: '<a href="'.$this->href('', $this->config['users_page'], 'profile='.$owner).'">'.$owner.'</a>'
				).', ';
			}

			if ($this->page['created'] != SQL_NULLDATE)
			{
				echo 'Theme open '.$this->get_time_string_formatted($this->page['created']);
			}
		}
		else
		{
			if ($this->user_is_owner())
			{
				echo $this->get_translation('Owner').': '.$this->get_translation('YouAreOwner');
			}
			else if ($owner = $this->get_page_owner())
			{
				echo $this->get_translation('Owner').': '.( $owner == GUEST ? '<em>'.$this->get_translation('Guest').'</em>' : '<a href="'.$this->href('', $this->config['users_page'], 'profile='.$owner).'">'.$owner.'</a>' ).' ';
			}
			else
			{
				echo ( substr($this->tag, 0, strlen($this->config['news_cluster'])) == $this->config['news_cluster']
					? $this->get_translation('Nobody').' '
					: '<a href="'.$this->href('claim').'">'.$this->get_translation('TakeOwnership').'</a> '
				);
			}

			if ($this->page['created'] != SQL_NULLDATE)
			{
				echo '('.$this->get_translation('Created').' '.$this->get_time_string_formatted($this->page['created']).'), ';
			}

			echo $this->get_translation('Modified').' '.$this->get_time_string_formatted($this->page['modified']).' ('.$this->get_translation('By').': '.( $this->page['user_id'] == GUEST ? '<em>'.$this->get_translation('Guest').'</em>' : ( $this->page['user_name'] == $this->get_user_name() ? 'You' : '<a href="'.$this->href('', $this->config['users_page'], 'profile='.$this->page['user_name']).'">'.$this->page['user_name'].'</a>' ) ).')';
		}
	}
	echo "\n";
?>
										</td>
										<td align="right">
<?php
	if ($this->page)
	{
		if ($this->get_user())
		{
			if ($this->iswatched === true)
			{
				?><a href="<?php echo $this->href('watch') ?>" title="<?php echo $this->get_translation('RemoveWatch'); ?>"><?php echo $this->get_translation('UnWatchText'); ?></a> &nbsp;&nbsp; <?php
			}
			else
			{
				?><a href="<?php echo $this->href('watch') ?>" title="<?php echo $this->get_translation('SetWatch'); ?>"><?php echo $this->get_translation('WatchText'); ?></a> &nbsp;&nbsp; <?php
			}
		}
		?><a href="<?php echo $this->href('print') ?>" title="<?php echo $this->get_translation('PrintVersion'); ?>"><?php echo $this->get_translation('PrintText'); ?></a><?php
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
		echo '<div style="white-space:normal;">'.$this->get_translation('Categories').': ';

		foreach ($this->categories as $word)
		{
			if ($i++ > 0) echo ", ";
			echo '<a href="'.$this->href('', $this->get_translation('TextSearchPage'), 'filter=pages&amp;keywords='.rawurlencode($word)).'">'.strtolower($word).'</a>';
		}

		echo '</div>';
	}
?>
								<div class="path" title="Path to current document">
									<a href="/"><?php echo trim($this->config['base_url'], '/'); ?></a>/<?php echo $this->get_page_path() ?> <a title="<?php echo $this->get_translation('SearchTitleTip'); ?>" href="<?php echo $this->href('', $this->get_translation('TextSearchPage'), 'phrase='.urlencode($this->get_page_title())); ?>">&gt;&gt;&gt;</a>
								</div>
							</div>
						</div>
					</td>
					<td width="210" rowspan="2" valign="top" style="background-image:url(<?php echo $this->config['theme_url'] ?>images/body_rightmid.png); background-position:right; background-repeat:repeat-y;">
						<table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td height="348" valign="top" style="background-image:url(<?php echo $this->config['theme_url'] ?>images/body_right.png); background-position:top right; background-repeat:no-repeat;">
									<div id="sidepanel">
										<div style="background-image:url(<?php echo $this->config['theme_url'] ?>images/glass_top.png); height:20px;"></div>
										<div id="bookmarks">
<?php
	echo $this->format(implode(' ', $this->get_bookmarks())) . "\n";
?>
										</div>
<?php
	if (preg_match('/^'.$this->config['news_cluster'].str_replace('/.+', '\/.+?', $this->config['news_levels']).'/', $this->tag))
		$this->config['hide_index'] = 1;

	if ($this->page && $this->config['hide_index'] == 0 && $this->method == 'show')
	{
?>
										<div style="background-image:url(<?php echo $this->config['theme_url'] ?>images/glass_sub_1.png); height:20px;"></div>
										<div style="background-image:url(<?php echo $this->config['theme_url'] ?>images/glass_sub_2.png); height:20px;">
											<div style="background-image:url(<?php echo $this->config['theme_url'] ?>images/glass_sections.png); background-position:right; background-repeat:no-repeat; height:20px;"></div>
										</div>
										<div style="background-image:url(<?php echo $this->config['theme_url'] ?>images/glass_sub_3.png); height:20px;"></div>
										<div id="sections">
<?php
		/* if (substr($this->tag, 0, strlen($this->config['forum_cluster'])) == $this->config['forum_cluster'])
		{
			// forum index
			echo $this->action('tree', array('page' => $this->config['forum_cluster'], 'depth' => 1, 'nomark' => 1));
		}
		else */ if ($this->config['tree_level'] == 1)
		{
			// lower index
			echo $this->action('tree', array('page' => $this->tag, 'depth' => 1, 'nomark' => 1));
		}
		else if ($this->config['tree_level'] == 2)
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
										<div style="background-image:url(<?php echo $this->config['theme_url'] ?>images/glass_mid_2.png); background-repeat:repeat-y; height:20px;"></div>
<?php
	}
	else
	{
?>
										<div style="background-image:url(<?php echo $this->config['theme_url'] ?>images/glass_mid_1.png); background-repeat:repeat-y; height:20px;"></div>
<?php
	}
	echo "\n";
?>
										<div style="background-image:url(<?php echo $this->config['theme_url'] ?>images/glass_bot.png); height:5px; background-repeat:no-repeat;"></div>
									</div>
								</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td width="25" height="321" valign="top" style="background-image:url(<?php echo $this->config['theme_url'] ?>images/body_leftmid.png); background-repeat:repeat-y;">
						<div id="tools" style="background-image:url(<?php echo $this->config['theme_url'] ?>images/tools_back.png); background-repeat:repeat-y;">
							<div style="background-image:url(<?php echo $this->config['theme_url'] ?>images/tools_top.png); height:7px;"></div>
<?php
	// defining tabs constructor
	function echo_tab($link, $hint, $title, $active = false, $bonus = '')
	{
		global $engine;

		if ($title == '') return; // no tab;

		$method = substr($link, strrpos($link, '/') + 1);

		if ($active)
			$tab = "<div class=\"$method\"><img src=\"".$engine->config['theme_url']."images/spacer.gif\" alt=\"$title\" /></div>\n";
		else
			$tab = "<div class=\"$method\"><a href=\"$link\" title=\"$hint\" accesskey=\"$bonus\"><img src=\"".$engine->config['theme_url']."images/spacer.gif\" alt=\"$title\" /></a></div>\n";

		return $tab;
	}

	// create tab
	echo echo_tab(
		$this->href('new'),
		$this->get_translation('CreateNewPageTip'),
		$this->get_translation('CreatePageButton'),
		$this->method == 'new',
		'n');

	// show tab
	echo echo_tab(
		$this->href('show'),
		$this->get_translation('ShowTip'),
		$this->has_access('read') ? $this->get_translation('ShowText') : '',
		$this->method == 'show',
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
		'e');

	// revisions tab
	echo echo_tab(
		$this->href('revisions'),
		$this->get_translation('RevisionTip'),
		(/* $this->forum === false && */ $this->page && $this->has_access('read')) ? $this->get_translation('RevisionText') : '',
		$this->method == 'revisions' || $this->method == 'diff',
		'r');

	// remove tab
	echo echo_tab(
		$this->href('remove'),
		$this->get_translation('DeleteTip'),
		($this->page && ($this->is_admin() || !$this->config['remove_onlyadmins'] && (
			($this->forum === true && $this->user_is_owner() && (int)$this->page['comments'] == 0) ||
			($this->forum === false && $this->user_is_owner()))))
			? $this->get_translation('DeleteText')  : '',
		$this->method == 'remove');

	// referrers tab
	echo echo_tab(
		$this->href('referrers'),
		$this->get_translation('ReferrersTip'),
		($this->page && $this->has_access('read')) ? $this->get_translation('ReferrersText') : '',
		$this->method == 'referrers' || $this->method == 'referrers_sites',
		'l');

	// moderation tab
	echo echo_tab(
		$this->href('moderate'),
		$this->get_translation('ModerateTip'),
		($this->is_moderator() && $this->has_access('read')) ? $this->get_translation('ModerateText') : '',
		$this->method == 'moderate',
		'm');

	// settings tab
	echo echo_tab(
		$this->href('properties'),
		$this->get_translation('PropertiesTip'),
		(/* $this->forum === false && $this->page && */ ($this->is_admin() /*|| $this->is_moderator() */|| $this->user_is_owner())) ? $this->get_translation('PropertiesText') : '',
		$this->method == 'properties' || $this->method == 'rename' || $this->method == 'purge' || $this->method == 'keywords',
		's');

	// upload tab
	echo echo_tab(
		$this->href('upload'),
		$this->get_translation('FilesTip'),
		(/* $this->forum === false && */ $this->page && $this->has_access('upload')) ? $this->get_translation('FilesText') : '',
		$this->method == 'upload',
		'u');

	// acls tab
	echo echo_tab(
		$this->href('permissions'),
		$this->get_translation('ACLTip'),
		($this->forum === false && $this->page && ($this->is_admin() || $this->user_is_owner())) ? $this->get_translation('ACLText') : '',
		$this->method == 'permissions',
		'a');
?>
							<div style="background-image:url(<?php echo $this->config['theme_url'] ?>images/tools_bottom.png); height:7px;"></div>
						</div>
					</td>
					<td height="321" valign="top" style="background-image:url(<?php echo $this->config['theme_url'] ?>images/body_divider.png); background-repeat:no-repeat;">
						<div id="body"><div id="content">
<?php
	if ($message = $this->get_message()) echo "<div class=\"info\">$message</div>";
?>
<!-- begin page output -->