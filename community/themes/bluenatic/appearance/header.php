<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<!--
I tried to fit the W3C standards while creating this template.
Please do NEVER forget: Microsoft != standard

Based on the NoProbs template from Gururaj:
http://openwebdesign.org/userinfo.phtml?user=kpgururaja
-->
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->page['lang'] ?>" lang="<?php echo $this->page['lang'] ?>">
<head>
	<meta name="author" content="Theme for WackoWiki by Robert Vaeth" />
	<meta name="keywords" content="<?php echo $this->get_keywords(); ?>" />
	<meta name="description" content="<?php echo $this->get_description(); ?>" />
	<meta http-equiv="content-type" content="text/html; charset=<?php echo $this->get_charset(); ?>" />
	<link rel="stylesheet" type="text/css" href="<?php echo $this->config['theme_url']; ?>css/default.css" media="screen" />
	<?php if ($this->config['allow_x11colors']) {?><link rel="stylesheet" type="text/css" href="<?php echo $this->config['base_url'] ?>themes/_common/X11colors.css" /><?php } ?>
	<link rel="stylesheet" type="text/css" href="<?php echo $this->config['theme_url']; ?>css/page.css" media="screen" />
	<link rel="stylesheet" type="text/css" href="<?php echo $this->config['theme_url']; ?>css/wacko.css" media="screen" />
	<link rel="shortcut icon" type="image/x-icon" href="<?php echo $this->config['theme_url']; ?>icons/icon.gif" />
	<link rel="alternate" type="application/rss+xml" title="<?php echo $this->get_translation('RecentChangesRSS');?>" href="<?php echo $this->config['base_url'];?>xml/changes_<?php echo preg_replace('/[^a-zA-Z0-9]/', '', strtolower($this->config['wacko_name']));?>.xml" />
	<link rel="alternate" type="application/rss+xml" title="<?php echo $this->get_translation('RecentCommentsRSS');?>" href="<?php echo $this->config['base_url'];?>xml/comments_<?php echo preg_replace('/[^a-zA-Z0-9]/', '', strtolower($this->config['wacko_name']));?>.xml" />
	<link rel="alternate" type="application/rss+xml" title="<?php echo $this->get_translation('HistoryRevisionsRSS');?><?php echo $this->tag; ?>" href="<?php echo $this->href('revisions.xml');?>" />
	<?php
	// We don't need search robots to index subordinate pages, if indexing is disabled globally or per page
	if ($this->method != 'show' || $this->page['latest'] == 0 || $this->config['noindex'] == 1 || $this->page['noindex'] == 1)
		echo "	<meta name=\"robots\" content=\"noindex, nofollow\" />\n";
	?>
	<title><?php echo htmlspecialchars($this->config['wacko_name'])." : ".(isset($this->page['title']) ? $this->page['title'] : $this->add_spaces($this->tag)).($this->method != 'show' ? ' ('.$this->method.')' : ''); ?></title>
	<!-- JavaScript used by WackoWiki -->
	<?php
// JS files.
// default.js contains common procedures and should be included everywhere
?>
  <script type="text/javascript" src="<?php echo $this->config['base_url'];?>js/default.js"></script>
<?php
// load swfobject with flash action (e.g. $this->config['allow_swfobject'] = 1), by default it is set off
if ($this->config['allow_swfobject'])
{
	echo "  <script type=\"text/javascript\" src=\"".$this->config['base_url']."js/swfobject.js\"></script>\n";
}
// autocomplete.js, protoedit & wikiedit2.js contain classes for WikiEdit editor. We may include them only on method==edit pages.
if ($this->method == 'edit')
{
	echo "  <script type=\"text/javascript\" src=\"".$this->config['base_url']."js/protoedit.js\"></script>\n";
	echo "  <script type=\"text/javascript\" src=\"".$this->config['base_url']."js/wikiedit2.js\"></script>\n";
	echo "  <script type=\"text/javascript\" src=\"".$this->config['base_url']."js/autocomplete.js\"></script>\n";
}
?>
	<script type="text/javascript" src="<?php echo $this->config['base_url'];?>js/captcha.js"></script>
	<?php
// Doubleclick edit feature.
// Enabled only for registered users who don't swith it off (requires class=page in show handler).
if ($user = $this->get_user())
{
	if ($user['doubleclick_edit'] == 1)
	{
?>
	<script type="text/javascript">
	var edit = "<?php echo $this->href('edit');?>";
	</script>
<?php
	}
}
else if($this->has_access('write'))
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
	<div id="mainwrapper">
		<div id="header">
			<?php // Insert search form ?>
			<?php echo $this->form_open('', $this->get_translation('TextSearchPage'), 'get'); ?>
			<input type="text" name="phrase" size="15" value="<?php echo $this->get_translation('SearchButtonText'); ?>" class="search" />
			<?php echo $this->form_close(); ?>

			<?php // Print wackoname and wackopath (and the magic 3 dots) ?>
			<b><?php echo $this->config['wacko_name']; ?>:</b>
			<?php echo $this->get_page_path(); ?>
			<a title="<?php echo $this->get_translation('SearchTitleTip'); ?>" href="<?php echo $this->config['base_url'].$this->get_translation('TextSearchPage').($this->config['rewrite_mode'] ? "?" : "&amp;"); ?>phrase=<?php echo urlencode($this->tag); ?>">...</a>
		</div>
		<div id="quicklinks">
			<div class="bookmarks">
				<?php // Insert links to root page and personal bookmarks ?>
				<?php echo "<ol>\n"; ?>
				<?php echo "<li>".$this->compose_link_to_page($this->config['root_page'])."</li>\n"; ?>
				<?php echo "<li>"; ?>
				<?php $formated_bm = $this->format($this->get_bookmarks_formatted(), 'post_wacko'); ?>
				<?php $formated_bm = str_replace ("\n", "</li>\n<li>", $formated_bm); ?>
				<?php echo $formated_bm; ?>
				<?php echo "</li>\n"; ?>
				<?php echo "</ol>\n"; ?>
			</div>
			<?php // If logged in, show username, settings and logout ?>
			<?php if($user = $this->get_user()) { ?>
			<div class="user">
				<?php echo $this->link($this->get_user_name()); ?>
				<small>( <?php echo $this->compose_link_to_page($this->get_translation('AccountLink'), "", $this->get_translation('AccountText'), 0); ?> |
				<a href="<?php echo $this->href('', $this->get_translation('LoginPage')).($this->config['rewrite_mode'] ? "?" : "&amp;");?>action=logout&amp;goback=<?php echo $this->slim_url($this->tag);?>"><?php echo $this->get_translation('LogoutLink'); ?></a> )</small>
			</div>
			<?php } ?>
		</div>
		<div id="quickactions">
			<?php // If logged in, show quick actions, else show login box ?>
			<?php if($user = $this->get_user()) { ?>
			<?php // Show edit button only if user has privileges ?>
			<?php if($this->has_access('write')) { ?>
			<a href="<?php echo $this->href('edit'); ?>" accesskey="E">
				<img src="<?php echo $this->config['theme_url']; ?>images/qa-edit.gif" alt="<?php echo $this->get_translation('EditTip'); ?>" title="<?php echo $this->get_translation('EditTip'); ?>" />
			</a>&nbsp;&nbsp;&nbsp;
			<?php } ?>
			<?php // Show ACL button only if user has privileges (or is admin) and if the page exists ?>
			<?php if($this->page) if($this->user_is_owner() || $this->is_admin()) { ?>
			<a href="<?php echo $this->href('permissions'); ?>">
				<img src="<?php echo $this->config['theme_url']; ?>images/qa-acl.gif" alt="<?php echo $this->get_translation('ACLText'); ?>" title="<?php echo $this->get_translation('ACLText'); ?>" />
			</a>
			<?php } ?>
			<a href="<?php echo $this->href('print'); ?>">
				<img src="<?php echo $this->config['theme_url']; ?>images/qa-print.gif" alt="<?php echo $this->get_translation('PrintVersion'); ?>" title="<?php echo $this->get_translation('PrintVersion'); ?>" />
			</a>
			<?php } else { ?>
			<div class="loginbox">
				<?php echo $this->form_open('', $this->get_translation('LoginPage'), 'post'); ?>
				<input type="hidden" name="action" value="login" />
				<input type="hidden" name="goback" value="<?php echo $this->slim_url($this->tag); ?>" />
				<?php echo $this->get_translation('LoginWelcome'); ?>
				<input type="text" name="name" size="15" class="login" />
				<?php echo $this->get_translation('LoginPassword'); ?>
				<input type="password" name="password" size="10" class="login" />
				<input type="image" src="<?php echo $this->config['theme_url']; ?>icons/login.gif" alt="<?php echo $this->get_translation('LoginWelcome'); ?>" class="login" />
				<?php echo $this->form_close(); ?>
			</div>
			<?php } ?>
		</div>
	<?php
	// here we show messages
	if ($message = $this->get_message()) echo "<div class=\"info\">$message</div>";
	?>