<?php
	header('Content-Type: text/html; charset='.$this->GetCharset());
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo htmlspecialchars($this->config['wacko_name']); ?> : <?php echo $this->GetPagePath(true, $separator = "/", false); ?></title>
<?php if ($this->method != 'show' || $this->page['latest'] == '0') { ?>
<meta name="robots" content="noindex, nofollow" />
<?php } ?>
<meta name="keywords" content="<?php echo htmlspecialchars($this->GetKeywords()); ?>" />
<meta name="description" content="<?php echo htmlspecialchars($this->GetDescription()); ?>" />
<meta http-equiv="content-type" content="text/html; charset=<?php echo $this->GetCharset(); ?>" />
<meta http-equiv="imagetoolbar" content="no" />
<link href="<?php echo $this->config["theme_url"] ?>css/atom.css" rel="stylesheet" type="text/css" media="screen" />
<?php if ($this->config["allow_x11colors"]) {?><link rel="stylesheet" type="text/css" href="<?php echo $this->config["base_url"] ?>themes/_common/X11colors.css" /><?php } ?>
<link href="<?php echo $this->config["theme_url"] ?>css/wacko.css" rel="stylesheet" type="text/css" media="screen" />
<link href="<?php echo $this->config["theme_url"] ?>css/default.css" rel="stylesheet" type="text/css" media="screen" />
<link rel="start" href="/" />
<link rel="copyright" href="<?php echo htmlspecialchars($this->href('', $this->config['policy_page'])); ?>" />
<link rel="alternate" type="application/rss+xml" title="<?php echo $this->GetTranslation("RecentNewsRSS");?>" href="/xml/news_<?php echo preg_replace('/[^a-zA-Z0-9]/', '', strtolower($this->config['wacko_name'])); ?>.xml" />
<link rel="alternate" type="application/rss+xml" title="<?php echo $this->GetTranslation("RecentCommentsRSS");?>" href="/xml/comments_<?php echo preg_replace('/[^a-zA-Z0-9]/', '', strtolower($this->config['wacko_name'])); ?>.xml" />
<link rel="alternate" type="application/rss+xml" title="<?php echo $this->GetTranslation("RecentChangesRSS");?>" href="/xml/changes_<?php echo preg_replace('/[^a-zA-Z0-9]/', '', strtolower($this->config['wacko_name'])); ?>.xml" />
<link rel="alternate" type="application/rss+xml" title="<?php echo $this->GetTranslation("HistoryRevisionsRSS");?><?php echo $this->tag; ?>" href="<?php echo $this->href('revisions.xml');?>" />
<script type="text/javascript" src="<?php echo $this->config["base_url"] ?>js/controls.js"></script>
<script type="text/javascript" src="<?php echo $this->config["base_url"] ?>js/protoedit.js"></script>
<script type="text/javascript" src="<?php echo $this->config["base_url"] ?>js/wikiedit2.js"></script>
</head>
</head>
<body>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td width="50" height="64" style="background-image:url(<?php echo $this->config["theme_url"] ?>images/back_top_1.png);"><img src="<?php echo $this->config["theme_url"] ?>images/spacer.gif" width="50" height="1" /></td>
		<td style="background-image:url(<?php echo $this->config["theme_url"] ?>images/back_top_3.png); background-repeat:repeat-x;">
			<table width="100%" border="0" cellspacing="0" cellpadding="0" style="background-image:url(<?php echo $this->config["theme_url"] ?>images/back_top_2.png); background-repeat:no-repeat;">
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
	if ($this->GetUser())
	{
?>
							id: <?php echo $this->GetUserName() ;?> &nbsp; <a href="<?php echo $this->href('', $this->config['settings_page']); ?>" title="Account Settings"><?php echo $this->GetTranslation("YouArePanelAccount"); ?></a> &nbsp; <a href="<?php echo $this->href('', $this->config['login_page']); ?>" title="parameters of current session">Session</a> &nbsp; <a onclick="return confirm('Do you really want to leave the system?');" href="<?php echo $this->href('', $this->config['login_page'], 'action=logout&amp;goback='.$this->SlimUrl($this->tag)); ?>" title="Logout">Logout</a><br />
<?php
	}
	else
	{
?>
							id: <em><?php echo $this->GetTranslation('Guest') ;?></em> &nbsp; <a href="<?php echo $this->href('', $this->config['login_page']); ?>" title="log and log in">login</a> &nbsp; <a href="<?php echo $this->href('', $this->config['registration_page']); ?>" title="log in">Registration</a><br />
<?php
	}
	echo "\n";
?>
							current time <?php echo date($this->config['time_format_seconds'].' '.$this->config['date_format'], time()); ?>
						</div>
					</td>
				</tr>
			</table>
		</td>
		<td width="25" style="background-image:url(<?php echo $this->config["theme_url"] ?>images/back_top_4.png);"><img src="<?php echo $this->config["theme_url"] ?>images/spacer.gif" width="25" height="1" /></td>
		<td width="25" style="background-image:url(<?php echo $this->config["theme_url"] ?>images/back_top_5.png);"><img src="<?php echo $this->config["theme_url"] ?>images/spacer.gif" width="25" height="1" /></td>
	</tr>
	<tr>
		<td height="315" valign="top" style="background-image:url(<?php echo $this->config["theme_url"] ?>images/back_left_2.png); background-repeat:repeat-y;"><div style="background-image:url(<?php echo $this->config["theme_url"] ?>images/back_left_1.png); background-repeat:no-repeat; height:311px;"></div></td>
		<td colspan="2" rowspan="2">
			<table width="100%" border="0" cellspacing="0" cellpadding="0" style="background-color:#FFFFFF;">
				<tr>
					<td height="25" colspan="3">
						<table width="100%" border="0" cellspacing="0" cellpadding="0" style="background-color:#646464;">
							<tr>
								<td width="25" height="25" style="background-image:url(<?php echo $this->config["theme_url"] ?>images/panel_left.png);"></td>
								<td style="background-image:url(<?php echo $this->config["theme_url"] ?>images/panel_mid.png); background-repeat:repeat-x;">
									<div id="navigation">
<?php
	$this->context[++$this->current_context] = '/';
	$this->StopLinkTracking();
	echo $this->Format($this->Format(strtolower(str_replace("\n", ' ', $this->GetDefaultBookmarks($user['lang'], 'site')))), 'post_wacko');
	$this->StartLinkTracking();
	$this->current_context--;
	echo "\n";
?>
									</div>
								</td>
								<td width="50" align="right" style="background-image:url(<?php echo $this->config["theme_url"] ?>images/panel_right.png);">
									<div id="tools">
<?php
	if ($this->GetUser())
	{
		if (in_array($this->tag, $this->GetBookmarkLinks()))
		{
			echo '<div class="bookmark_out"><a href="'.$this->href('', '', 'removebookmark=yes').'" title="remove this page from the Bookmarks menu"><img src="'.$this->config["theme_url"].'images/spacer.gif" /></a></div>';
		}
		else
		{
			echo '<div class="bookmark_in"><a href="'.$this->href('', '', 'addbookmark=yes').'" title="Add this page to the bookmark menu"><img src="'.$this->config["theme_url"].'images/spacer.gif" /></a></div>';
		}
	}
	else
	{
		echo '<div class="bookmark_in"><img src="'.$this->config["theme_url"].'images/spacer.gif" title="You must be registered to work with the system bookmarks" /></div>';
	}
	echo "\n";

	$wordsHeight = ( $this->keywords ? 'height:42px;' : 'height:29px;' );
?>
									</div>
								</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td colspan="2" valign="top" style="background-image:url(<?php echo $this->config["theme_url"] ?>images/body_leftmid.png); background-repeat:repeat-y; <?php echo $wordsHeight; ?>">
						<div style="background-image:url(<?php echo $this->config["theme_url"] ?>images/body_topmid.png); background-repeat:repeat-x; <?php echo $wordsHeight; ?>">
							<div id="meta" style="background-image:url(<?php echo $this->config["theme_url"] ?>images/body_topleft.png); background-repeat:no-repeat; <?php echo $wordsHeight; ?>">
								<table width="100%" border="0" cellspacing="0" cellpadding="0">
									<tr>
										<td>
<?php
	if ($this->page)
	{
		if ($this->forum === true)
		{
			if ($this->UserIsOwner())
				echo 'Thread poster: You, ';
			else if ($owner = $this->GetPageOwner())
				echo 'By topic: '.( $owner == GUEST ? '<em>'.$this->GetTranslation('Guest').'</em>' : '<a href="'.$this->href('', $this->config['users_page'], 'profile='.$owner).'">'.$owner.'</a>' ).', ';

			if ($this->page['created'] != SQL_NULLDATE) echo 'Theme open '.$this->GetTimeStringFormatted($this->page['created']);
		}
		else
		{
			if ($this->UserIsOwner())
				echo 'Owner: You ';
			else if ($owner = $this->GetPageOwner())
				echo 'Owner: '.( $owner == GUEST ? '<em>'.$this->GetTranslation('Guest').'</em>' : '<a href="'.$this->href('', $this->config['users_page'], 'profile='.$owner).'">'.$owner.'</a>' ).' ';
			else
				echo ( substr($this->tag, 0, strlen($this->config['news_cluster'])) == $this->config['news_cluster']
					? 'Holder No '
					: '<a href="'.$this->href('claim').'">Possession</a> ' );

			if ($this->page['created'] != SQL_NULLDATE) echo '(created '.$this->GetTimeStringFormatted($this->page['created']).'), ';

			echo 'modified '.$this->GetTimeStringFormatted($this->page['modified']).' ('.$this->GetTranslation('By').': '.( $this->page['user_id'] == GUEST ? '<em>'.$this->GetTranslation('Guest').'</em>' : ( $this->page['user_name'] == $this->GetUserName() ? 'You' : '<a href="'.$this->href('', $this->config['users_page'], 'profile='.$this->page['user_name']).'">'.$this->page['user_name'].'</a>' ) ).')';
		}
	}
	echo "\n";
?>
										</td>
										<td align="right">
<?php
	if ($this->page)
	{
		if ($this->GetUser())
		{
			if ($this->iswatched === true)
			{
				?><a href="<?php echo $this->href('watch') ?>" title="stop monitor page">Not follow</a> &nbsp;&nbsp; <?php
			}
			else
			{
				?><a href="<?php echo $this->href('watch') ?>" title="monitor homepage">Watch</a> &nbsp;&nbsp; <?php
			}
		}
		?><a href="<?php echo $this->href('print') ?>" title="Print">Print</a><?php
	}
	echo "\n";
?>
										</td>
									</tr>
								</table>
<?php
	if ($this->keywords)
	{
		echo '<div style="white-space:normal;">Categories: ';
		foreach ($this->keywords as $word)
		{
			if ($i++ > 0) echo ",\n";
			echo '<a href="'.$this->href('', $this->config['search_page'], 'filter=pages&amp;keywords='.rawurlencode($word)).'">'.strtolower($word).'</a>';
		}
		echo '</div>';
	}
?>
								<div class="path" title="Path to current document">
									<a href="/"><?php echo trim($this->config['base_url'], '/'); ?></a>/<?php echo $this->GetPagePath() ?> <a title="look like in other documents" href="<?php echo $this->href('', $this->config['search_page'], 'phrase='.urlencode($this->GetPageTitle())); ?>">&gt;&gt;&gt;</a>
								</div>
							</div>
						</div>
					</td>
					<td width="210" rowspan="2" valign="top" style="background-image:url(<?php echo $this->config["theme_url"] ?>images/body_rightmid.png); background-position:right; background-repeat:repeat-y;">
						<table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td height="348" valign="top" style="background-image:url(<?php echo $this->config["theme_url"] ?>images/body_right.png); background-position:top right; background-repeat:no-repeat;">
									<div id="sidepanel">
										<div style="background-image:url(<?php echo $this->config["theme_url"] ?>images/glass_top.png); height:20px;"></div>
										<div id="bookmarks">
<?php
	echo $this->Format(implode(' ', $this->GetBookmarks())) . "\n";
?>
										</div>
<?php
	if (preg_match('/^'.$this->config['news_cluster'].str_replace('/.+', '\/.+?', $this->config['news_levels']).'/', $this->tag))
		$this->config['hide_index'] = 1;

	if ($this->page && $this->config['hide_index'] == '0' && $this->method == 'show')
	{
?>
										<div style="background-image:url(<?php echo $this->config["theme_url"] ?>images/glass_sub_1.png); height:20px;"></div>
										<div style="background-image:url(<?php echo $this->config["theme_url"] ?>images/glass_sub_2.png); height:20px;">
											<div style="background-image:url(<?php echo $this->config["theme_url"] ?>images/glass_sections.png); background-position:right; background-repeat:no-repeat; height:20px;"></div>
										</div>
										<div style="background-image:url(<?php echo $this->config["theme_url"] ?>images/glass_sub_3.png); height:20px;"></div>
										<div id="sections">
<?php
		/* if (substr($this->tag, 0, strlen($this->config['forum_cluster'])) == $this->config['forum_cluster'])
		{
			// forum index
			echo $this->Action('tree', array('page' => $this->config['forum_cluster'], 'depth' => 1, 'nomark' => 1));
		}
		else */ if ($this->config['lower_index'] == '1')
		{
			// lower index
			echo $this->Action('tree', array('page' => $this->tag, 'depth' => 1, 'nomark' => 1));
		}
		else if ($this->config['upper_index'] == '1')
		{
			// upper index
			$page = '/'.substr($this->tag, 0, ( strrpos($this->tag, '/') ? strrpos($this->tag, '/') : strlen($this->tag) ));
			echo $this->Action('tree', array('page' => $page, 'depth' => 1, 'nomark' => 1));
		}
		else
		{
			// default index
			$page = '/'.substr($this->tag, 0, ( strrpos($this->tag, '/') ? strrpos($this->tag, '/') : strlen($this->tag) ));
			echo $this->Action('tree', array('page' => $page, 'depth' => 2, 'nomark' => 1));
		}
?>
										</div>
										<div style="background-image:url(<?php echo $this->config["theme_url"] ?>images/glass_mid_2.png); background-repeat:repeat-y; height:20px;"></div>
<?php
	}
	else
	{
?>
										<div style="background-image:url(<?php echo $this->config["theme_url"] ?>images/glass_mid_1.png); background-repeat:repeat-y; height:20px;"></div>
<?php
	}
	echo "\n";
?>
										<div style="background-image:url(<?php echo $this->config["theme_url"] ?>images/glass_bot.png); height:5px; background-repeat:no-repeat;"></div>
									</div>
								</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td width="25" height="321" valign="top" style="background-image:url(<?php echo $this->config["theme_url"] ?>images/body_leftmid.png); background-repeat:repeat-y;">
						<div id="tools" style="background-image:url(<?php echo $this->config["theme_url"] ?>images/tools_back.png); background-repeat:repeat-y;">
							<div style="background-image:url(<?php echo $this->config["theme_url"] ?>images/tools_top.png); height:7px;"></div>
<?php
	// defining tabs constructor
	function EchoTab($link, $hint, $title, $active = false, $bonus = '')
	{
		global $engine;

		if ($title == '') return; // no tab;

		$method = substr($link, strrpos($link, '/') + 1);

		if ($active)
			$tab = "<div class=\"$method\"><img src=\"".$engine->config["theme_url"]."images/spacer.gif\" alt=\"$title\" /></div>\n";
		else
			$tab = "<div class=\"$method\"><a href=\"$link\" title=\"$hint\" accesskey=\"$bonus\"><img src=\"".$engine->config["theme_url"]."images/spacer.gif\" alt=\"$title\" /></a></div>\n";

		return $tab;
	}

	// create tab
	echo EchoTab(
		$this->href('new'),
		$this->GetTranslation('CreateTip'),
		'создать',
		$this->method == 'new',
		'n');

	// show tab
	echo EchoTab(
		$this->href('show'),
		$this->GetTranslation('ShowTip'),
		$this->HasAccess('read') ? $this->GetTranslation("ShowText") : '',
		$this->method == 'show',
		'v');

	// edit tab
	echo EchoTab(
		$this->href('edit'),
		$this->GetTranslation('EditTip'),
		((!$this->page && $this->HasAccess('create')) || $this->IsAdmin() ||
			($this->forum === false && $this->HasAccess('write')) ||
			($this->forum === true && ($this->UserIsOwner() || $this->IsModerator()) && (int)$this->page['comments'] == 0))
			? $this->GetTranslation("EditText") : '',
		$this->method == 'edit',
		'e');

	// revisions tab
	echo EchoTab(
		$this->href('revisions'),
		$this->GetTranslation('RevisionTip'),
		(/* $this->forum === false && */ $this->page && $this->HasAccess('read')) ? $this->GetTranslation('RevisionText') : '',
		$this->method == 'revisions' || $this->method == 'diff',
		'r');

	// remove tab
	echo EchoTab(
		$this->href('remove'),
		$this->GetTranslation('DeleteTip'),
		($this->page && ($this->IsAdmin() || !$this->config['remove_onlyadmins'] && (
			($this->forum === true && $this->UserIsOwner() && (int)$this->page['comments'] == 0) ||
			($this->forum === false && $this->UserIsOwner()))))
			? $this->GetTranslation('DeleteText')  : '',
		$this->method == 'remove');

	// referrers tab
	echo EchoTab(
		$this->href('referrers'),
		$this->GetTranslation('ReferrersTip'),
		($this->page && $this->HasAccess('read')) ? $this->GetTranslation("ReferrersText") : '',
		$this->method == 'referrers' || $this->method == 'referrers_sites',
		'l');

	// moderation tab
	echo EchoTab(
		$this->href('moderate'),
		$this->GetTranslation('ModerateTip'),
		($this->IsModerator() && $this->HasAccess('read')) ? $this->GetTranslation('ModerateText') : '',
		$this->method == 'moderate',
		'm');

	// settings tab
	echo EchoTab(
		$this->href('properties'),
		$this->GetTranslation('PropertiesTip'),
		(/* $this->forum === false && $this->page && */ ($this->IsAdmin() /*|| $this->IsModerator() */|| $this->UserIsOwner())) ? $this->GetTranslation("PropertiesText") : '',
		$this->method == 'properties' || $this->method == 'rename' || $this->method == 'purge' || $this->method == 'keywords',
		's');

	// upload tab
	echo EchoTab(
		$this->href('upload'),
		$this->GetTranslation('FilesTip'),
		(/* $this->forum === false && */ $this->page && $this->HasAccess('upload')) ? $this->GetTranslation('FilesText') : '',
		$this->method == 'upload',
		'u');

	// acls tab
	echo EchoTab(
		$this->href('acls'),
		$this->GetTranslation('ACLTip'),
		($this->forum === false && $this->page && ($this->IsAdmin() || $this->UserIsOwner())) ? $this->GetTranslation("ACLText") : '',
		$this->method == 'acls',
		'a');
?>
							<div style="background-image:url(<?php echo $this->config["theme_url"] ?>images/tools_bottom.png); height:7px;"></div>
						</div>
					</td>
					<td height="321" valign="top" style="background-image:url(<?php echo $this->config["theme_url"] ?>images/body_divider.png); background-repeat:no-repeat;">
						<div id="body"><div id="content">
<?php
	if ($message = $this->GetMessage()) echo "<div class=\"info\">$message</div>";
?>
<!-- begin page output -->
