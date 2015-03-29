<?php

// HTTP header with right Charset settings
header('Content-Type: text/html; charset='.$this->get_charset());
?>
<!DOCTYPE html>
<html lang="<?php echo $this->page['lang'] ?>">
<head>
	<title><?php echo htmlspecialchars($this->config['site_name'], ENT_COMPAT | ENT_HTML401, HTML_ENTITIES_CHARSET).' : '.(isset($this->page['title']) ? $this->page['title'] : $this->add_spaces($this->tag)).($this->method != 'show' ? ' ('.$this->method.')' : '');?></title>
<?php
// We don't need search robots to index subordinate pages, if indexing is disabled globally or per page
if ($this->method != 'show' || $this->page['latest'] == 0 || $this->config['noindex'] == 1 || $this->page['noindex'] == 1)
{
	echo '	<meta name="robots" content="noindex, nofollow" />'."\n";
}
?>
	<meta charset="<?php echo $this->get_charset(); ?>" />
	<meta name="keywords" content="<?php echo htmlspecialchars($this->get_keywords(), ENT_COMPAT | ENT_HTML401, HTML_ENTITIES_CHARSET); ?>" />
	<meta name="description" content="<?php echo htmlspecialchars($this->get_description(), ENT_COMPAT | ENT_HTML401, HTML_ENTITIES_CHARSET); ?>" />
	<meta name="language" content="<?php echo $this->page['lang'] ?>" />

	<link rel="stylesheet" href="<?php echo $this->config['theme_url'] ?>css/default.css" />
<?php if ($this->config['allow_x11colors']) {?>
	<link rel="stylesheet" href="<?php echo $this->config['base_url'] ?>themes/_common/X11colors.css" />
<?php } ?>
	<link media="print" rel="stylesheet" href="<?php echo $this->config['theme_url'] ?>css/print.css" />
	<link rel="shortcut icon" href="<?php echo $this->config['theme_url'] ?>icons/favicon.ico" type="image/x-icon" />
	<link rel="start" title="<?php echo $this->config['root_page'];?>" href="<?php echo $this->config['base_url'];?>"/>
<?php if ($this->config['policy_page']) {?>
	<link rel="copyright" href="<?php echo htmlspecialchars($this->href('', $this->config['policy_page']), ENT_COMPAT | ENT_HTML401, HTML_ENTITIES_CHARSET); ?>" title="Copyright" />
<?php } ?>
<?php if ($this->config['enable_feeds']) {?>
	<link rel="alternate" type="application/rss+xml" title="<?php echo $this->get_translation('RecentChangesRSS');?>" href="<?php echo $this->config['base_url'];?>xml/changes_<?php echo preg_replace('/[^a-zA-Z0-9]/', '', strtolower($this->config['site_name']));?>.xml" />
	<link rel="alternate" type="application/rss+xml" title="<?php echo $this->get_translation('RecentCommentsRSS');?>" href="<?php echo $this->config['base_url'];?>xml/comments_<?php echo preg_replace('/[^a-zA-Z0-9]/', '', strtolower($this->config['site_name']));?>.xml" />
<?php if ($this->config['news_cluster']) {?>
	<link rel="alternate" type="application/rss+xml" title="<?php echo $this->get_translation('RecentNewsRSS');?>" href="<?php echo $this->config['base_url'];?>xml/news_<?php echo preg_replace('/[^a-zA-Z0-9]/', '', strtolower($this->config['site_name']));?>.xml" />
<?php } ?>
<?php if ( $this->hide_revisions === false || $this->is_admin() ) {?>
	<link rel="alternate" type="application/rss+xml" title="<?php echo $this->get_translation('HistoryRevisionsRSS');?><?php echo $this->tag; ?>" href="<?php echo $this->href('revisions.xml');?>" />
<?php } ?>
<?php } ?>

<?php
// JS files.
// default.js contains common procedures and should be included everywhere
?>
	<script src="<?php echo $this->config['base_url'];?>js/default.js"></script>
<?php
// load swfobject with flash action (e.g. $this->config['allow_swfobject'] = 1), by default it is set off
if ($this->config['allow_swfobject'])
{
	echo '<script src="'.$this->config['base_url'].'js/swfobject.js"></script>'."\n";
}
// autocomplete.js, protoedit & wikiedit.js contain classes for WikiEdit editor. We may include them only on method==edit pages.
if ($this->method == 'edit')
{
	echo '<script src="'.$this->config['base_url'].'js/protoedit.js"></script>'."\n";
	echo '<script src="'.$this->config['base_url'].'js/wikiedit.js"></script>'."\n";
	echo '<script src="'.$this->config['base_url'].'js/autocomplete.js"></script>'."\n";
}
?>
	<script src="<?php echo $this->config['base_url'];?>js/captcha.js"></script>
<?php
// Doubleclick edit feature.
// Enabled only for registered users who don't switch it off (requires class=page in show handler).
$doubleclick = '';

if ($user = $this->get_user())
{
	if (isset($user['doubleclick_edit']) && $user['doubleclick_edit'] == 1)
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

<?php
// all_init() initializes all js features:
//	* WikiEdit
//	* Doubleclick editing
//	* Smooth scrolling

?>