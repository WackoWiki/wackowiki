<?php
	# load main menu
	include_once('mainmenu.inc.php');

	$base_url = $this->config['base_url'];

	// HTTP header with right Charset settings
	header("Content-Type: text/html; charset=".$this->get_charset());
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->config['language']; ?>" lang="<?php echo $this->config['language']; ?>">
<head>
	<meta name="keywords" content="<?php echo $this->get_keywords(); ?>" />
	<meta name="description" content="<?php echo $this->get_description(); ?>" />
	<meta http-equiv="content-type" content="text/html; charset=<?php echo $this->get_charset(); ?>" />
<?php
// We don't need search robots to index subordinate pages, if indexing is disabled globally or per page
if ($this->method != 'show' || $this->page['latest'] == 0 || $this->config['noindex'] == 1 || $this->page['noindex'] == 1)
	echo "	<meta name=\"robots\" content=\"noindex, nofollow\" />\n";
?>
	<link href="<?php echo $this->config['theme_url'] ?>../default/css/default.css.php" rel="stylesheet" type="text/css" />
	<?php if ($this->config['allow_x11colors']) {?><link rel="stylesheet" type="text/css" href="<?php echo $this->config['base_url'] ?>themes/_common/X11colors.css" /><?php } ?>
	<link href="<?php echo $this->config['theme_url'] ?>layout/screen.css" media="screen, projection" rel="stylesheet" type="text/css" />
	<link href="<?php echo $this->config['theme_url'] ?>layout/patches/opera.css" rel="stylesheet" type="text/opera" />
	<!--[if IE 5]><link href="<?php echo $this->config['theme_url'] ?>layout/patches/ie5.css" rel="stylesheet" type="text/css" /><![endif]-->
	<!--[if IE 6]><link href="<?php echo $this->config['theme_url'] ?>layout/patches/ie6.css" rel="stylesheet" type="text/css" /><![endif]-->
	<!--[if IE 7]><link href="<?php echo $this->config['theme_url'] ?>layout/patches/ie7.css" rel="stylesheet" type="text/css" /><![endif]-->
	<link href="<?php echo $this->config['theme_url'] ?>layout/print.css" media="print" rel="stylesheet" type="text/css" />

	<!-- MiniWackoLicious Theme for WackoWiki, by eye48.com -->

<?php
	echo '	<link rel="start" href="'.$base_url.'Homepage" />'."\n";
	// Echoes Title of the page.
	echo "	<title>" . $this->config['wacko_name']." : ".(isset($this->page['title']) ? $this->page['title'] : $this->add_spaces($this->tag)).($this->method != 'show' ? ' ('.$this->method.')' : '');
	echo "</title>\n";
?>
	<!-- link rel="shortcut icon" href="<?php echo $this->config['theme_url'] ?>icons/favicon.ico" type="image/x-icon" / -->
	<link rel="alternate" type="application/rss+xml" title="<?php echo $this->get_translation('RecentChangesRSS');?>" href="<?php echo $this->config['base_url'];?>xml/changes_<?php echo preg_replace('/[^a-zA-Z0-9]/', '', strtolower($this->config['wacko_name']));?>.xml" />
	<link rel="alternate" type="application/rss+xml" title="<?php echo $this->get_translation('RecentCommentsRSS');?>" href="<?php echo $this->config['base_url'];?>xml/comments_<?php echo preg_replace('/[^a-zA-Z0-9]/', '', strtolower($this->config['wacko_name']));?>.xml" />
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
<?php
// all_init() initializes all js features:
//   * WikiEdit
//   * Doubleclick editing
//   * Smooth scrolling

?>
<body onload="all_init();"<?php echo ($this->get_user()) ? ' id="backend"':'';?>>
<script type="text/javascript">
    // test for javascript
    document.getElementsByTagName("body")[0].className = "js";
</script>
    <div class="sitewrapper">
<?php echo ($this->get_user()) ? '<div id="backendrow"></div><div id="system_bookmarks" class="backendbutton" onclick="var menu = document.getElementById(\'usermenu\'); if (menu.className==\'normal\') {menu.className=\'dropdown\';} else {menu.className=\'normal\';} return;"></div>':''; ?>

        <div class="header">

            <h1><?php echo '<a href="'.$this->config['base_url'].'">'.$this->config['wacko_name'].'</a>' ?></h1>

            <div class="nav-main">

                <ul>
                    <?php if (function_exists('mainMenu')) {mainMenu($this);} else {die('no theme menu function found!');} ?>
                </ul>

                <div class="search">
                    <?php echo $this->form_open('', $this->get_translation('TextSearchPage'), 'get'); ?>
                        <fieldset>
                            <label for="phrase">Search: </label>
                            <input name="phrase" id="phrase" size="15" class="textinput" type="text"/>
                            <button type="submit"><span class="onlyAural">Search </span>&raquo;</button>
                        </fieldset>
                    <?php echo $this->form_close(); ?>
                </div> <!-- /search -->

            </div> <!-- /nav-main -->

            <?php if ($this->config['root_page'] != $this->tag) { ?>
            <div class="nav-breadcrumb">
           		<hr class="onlyAural"/>
                <p>
                    <span class="onlyAural"><?php echo $this->get_translation('YouAreHere'); ?>: </span>
                    <?php
                        if (strpos($this->tag, $this->config['root_page'].'/') !== 0)
                            echo '<a href="'.$this->config['base_url'].'">'.$this->config['root_page'].'</a> /';
                    ?>
                    <?php echo $this->get_page_path(false, " / "); ?>
                </p>
            </div>
            <?php } ?>

        </div> <!-- /header -->

		<hr class="onlyAural"/>

        <div id="content" class="content">

		<?php
		// here we show messages
		if ($message = $this->get_message()) echo "<div class=\"info\">$message</div>";
		?>
