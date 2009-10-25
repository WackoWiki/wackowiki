<?php
	# load main menu
	include_once('mainmenu.inc.php');

	$base_url = $this->GetConfigValue("base_url");

	// HTTP header with right Charset settings
	header("Content-Type: text/html; charset=".$this->GetCharset());
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->GetConfigValue("language"); ?>" lang="<?php echo $this->GetConfigValue("language"); ?>">
<head>
    <meta name="keywords" content="<?php echo $this->GetKeywords(); ?>" />
	<meta name="description" content="<?php echo $this->GetDescription(); ?>" />
	<meta http-equiv="content-type" content="text/html; charset=<?php echo $this->GetCharset(); ?>" />
<?php
	// We don't need search robots to index subordinate pages
	if ($this->GetMethod() != 'show' || $this->page["latest"] == "0")
		echo "	<meta name=\"robots\" content=\"noindex, nofollow\" />\n";
?>
 	<link href="<?php echo $this->GetConfigValue("theme_url") ?>../default/css/default.css.php" rel="stylesheet" type="text/css" />
    <link href="<?php echo $this->GetConfigValue("theme_url") ?>layout/screen.css" media="screen, projection" rel="stylesheet" type="text/css" />
    <link href="<?php echo $this->GetConfigValue("theme_url") ?>layout/patches/opera.css" rel="stylesheet" type="text/opera" />
    <!--[if IE 5]><link href="<?php echo $this->GetConfigValue("theme_url") ?>layout/patches/ie5.css" rel="stylesheet" type="text/css" /><![endif]-->
    <!--[if IE 6]><link href="<?php echo $this->GetConfigValue("theme_url") ?>layout/patches/ie6.css" rel="stylesheet" type="text/css" /><![endif]-->
    <!--[if IE 7]><link href="<?php echo $this->GetConfigValue("theme_url") ?>layout/patches/ie7.css" rel="stylesheet" type="text/css" /><![endif]-->
    <link href="<?php echo $this->GetConfigValue("theme_url") ?>layout/print.css" media="print" rel="stylesheet" type="text/css" />

    <!-- MiniWackoLicious Theme for WackoWiki, by eye48.com -->

<?php
	echo '	<link rel="start" href="'.$base_url.'Homepage" />'."\n";
	// Echoes Title of the page.
  echo "	<title>" . $this->GetWackoName()." : ".$this->AddSpaces($this->GetPageTag()).($this->method!="show"?" (".$this->method.")":"");
	echo "</title>\n";
?>
	<!-- link rel="shortcut icon" href="<?php echo $this->GetConfigValue("theme_url") ?>icons/favicon.ico" type="image/x-icon" / -->
	<link rel="alternate" type="application/rss+xml" title="<?php echo $this->GetTranslation("RecentChangesRSS");?>" href="<?php echo $this->GetConfigValue("root_url");?>xml/changes_<?php echo preg_replace("/[^a-zA-Z0-9]/", "", strtolower($this->GetConfigValue("wacko_name")));?>.xml" />
	<link rel="alternate" type="application/rss+xml" title="<?php echo $this->GetTranslation("RecentCommentsRSS");?>" href="<?php echo $this->GetConfigValue("root_url");?>xml/comments_<?php echo preg_replace("/[^a-zA-Z0-9]/", "", strtolower($this->GetConfigValue("wacko_name")));?>.xml" />
	<link rel="alternate" type="application/rss+xml" title="<?php echo $this->GetTranslation("HistoryRevisionsRSS");?><?php echo $this->tag; ?>" href="<?php echo $this->href("revisions.xml");?>" />
<?php
// JS files.
// default.js contains common procedures and should be included everywhere
?>
  <script type="text/javascript" src="<?php echo $this->GetConfigValue("root_url");?>js/default.js"></script>
<?php
// autocomplete.js, protoedit & wikiedit2.js contain classes for WikiEdit editor. We may include them only on method==edit pages.
if ($this->method == 'edit')
{
	echo "  <script type=\"text/javascript\" src=\"".$this->GetConfigValue("root_url")."js/protoedit.js\"></script>\n";
	echo "  <script type=\"text/javascript\" src=\"".$this->GetConfigValue("root_url")."js/wikiedit2.js\"></script>\n";
	echo "  <script type=\"text/javascript\" src=\"".$this->GetConfigValue("root_url")."js/autocomplete.js\"></script>\n";
}
?>
  <script type="text/javascript" src="<?php echo $this->GetConfigValue("root_url");?>js/captcha.js"></script>
<?php
// Doubleclick edit feature.
// Enabled only for registered users who don't swith it off (requires class=page in show handler).
if ($user = $this->GetUser())
   {
      if ($user["doubleclickedit"] == "1")
         {
?>
  <script type="text/javascript">
   var edit = "<?php echo $this->href("edit");?>";
  </script>
<?php
         }
   }
else if($this->HasAccess("write"))
   {
?>

      <script type="text/javascript">
      var edit = "<?php echo $this->href("edit");?>";
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
<body onload="all_init();"<?php echo ($this->GetUser()) ? ' id="backend"':'';?>>
<script type="text/javascript">
    // test for javascript
    document.getElementsByTagName("body")[0].className = "js";
</script>
    <div class="sitewrapper">
<?php echo ($this->GetUser()) ? '<div id="backendrow"></div><div id="system_bookmarks" class="backendbutton" onclick="var menu = document.getElementById(\'usermenu\'); if (menu.className==\'normal\') {menu.className=\'dropdown\';} else {menu.className=\'normal\';} return;"></div>':''; ?>

        <div class="header">

            <h1><?php echo '<a href="'.$this->GetConfigValue("base_url").'">'.$this->GetConfigValue("wacko_name").'</a>' ?></h1>

            <div class="nav-main">

                <ul>
                    <?php if (function_exists('mainMenu')) {mainMenu($this);} else {die('no theme menu function found!');} ?>
                </ul>

                <div class="search">
                    <?php echo $this->FormOpen("", $this->GetTranslation("TextSearchPage"), "get"); ?>
                        <fieldset>
                            <label for="phrase">Search: </label>
                            <input name="phrase" id="phrase" size="15" class="textinput" type="text"/>
                            <button type="submit"><span class="onlyAural">Search </span>&raquo;</button>
                        </fieldset>
                    <?php echo $this->FormClose(); ?>
                </div> <!-- /search -->

            </div> <!-- /nav-main -->

            <?php if ($this->GetConfigValue("root_page") != $this->tag) { ?>
            <div class="nav-breadcrumb">
           		<hr class="onlyAural"/>
                <p>
                    <span class="onlyAural"><?php echo $this->GetTranslation("YouAreHere"); ?>: </span>
                    <?php
                        if (strpos($this->tag, $this->GetConfigValue("root_page").'/') !== 0)
                            echo '<a href="'.$this->GetConfigValue("base_url").'">'.$this->GetConfigValue("root_page").'</a> /';
                    ?>
                    <?php echo $this->GetPagePath(" / "); ?>
                </p>
            </div>
            <?php } ?>

        </div> <!-- /header -->

		<hr class="onlyAural"/>

        <div id="content" class="content">

		<?php
		// here we show messages
		if ($message = $this->GetMessage()) echo "<div class=\"info\">$message</div>";
		?>
