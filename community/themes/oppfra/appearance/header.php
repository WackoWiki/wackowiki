<?php
/*
Oppfra theme.
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
<!--BEGINN: KOPF-->
<div id="header">
<div class="navigation">
<?php
// Outputs page title
?>
<ul>
	<li><?php echo $this->compose_link_to_page($this->config["root_page"]);?>:</li>   <li><?php echo $this->get_page_path(); ?></li>
	<li><a title="<?php echo $this->get_translation("SearchTitleTip")?>" href="<?php echo $this->config["base_url"].$this->get_translation("TextSearchPage").($this->config["rewrite_mode"] ? "?" : "&amp;");?>phrase=<?php echo urlencode($this->tag); ?>">...</a></li>
</ul>
</div></div>
<!--ENDE: KOPF-->
<!--BEGINN: MENUE-->
<div class="cap" id="menu"><img src="<?php echo $this->config['theme_url'] ?>icons/logo.png" alt="alternativ Text" align="middle" />

</div>
<!--ENDE: MENUE-->

<!--BEGINN: INHALT-->
<div id="content">
<?php
// here we show messages
if ($message = $this->get_message())
{
	echo "<div class=\"info\">$message</div>";
}
?>
<div class="article_inner">