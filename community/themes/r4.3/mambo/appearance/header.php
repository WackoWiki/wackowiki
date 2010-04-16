<?php
	header( "Content-Type: text/html; charset=".$this->GetCharset() );
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->page["lang"] ?>" lang="<?php echo $this->page["lang"] ?>">
	<head>
  		<title>
			<?php echo $this->config["wacko_name"]." : ".$this->AddSpaces($this->tag).($this->method!="show"?" (".$this->method.")":""); ?>
		</title>
<?php
	if ($this->method != 'show' || $this->page["latest"] == "0") {
		echo "<meta name=\"robots\" content=\"noindex, nofollow\" />\n";
	}
?>
		<meta name="keywords" content="<?php echo $this->GetKeywords(); ?>" />
		<meta name="description" content="<?php echo $this->GetDescription(); ?>" />
		<meta name="language" content="<?php echo $this->page["lang"] ?>" />
		<meta http-equiv="content-type" content="text/html; charset=<?php echo $this->GetCharset(); ?>" />
		<link rel="stylesheet" type="text/css" href="<?php echo $this->config["theme_url"] ?>css/default.css" />
		<?php if ($this->config["allow_x11colors"]) {?><link rel="stylesheet" type="text/css" href="<?php echo $this->config["base_url"] ?>themes/_common/X11colors.css" /><?php } ?>
		<link rel="stylesheet" type="text/css" href="<?php echo $this->config["theme_url"] ?>css/left.css" />
		<link rel="shortcut icon" href="<?php echo $this->config["theme_url"] ?>icons/favicon.ico" type="image/x-icon" />
		<link rel="alternate" type="application/rss+xml" title="<?php echo $this->GetTranslation("RecentChangesRSS");?>" href="<?php echo $this->config["base_url"];?>xml/changes_<?php echo preg_replace("/[^a-zA-Z0-9]/", "", strtolower($this->config["wacko_name"]));?>.xml" />
		<link rel="alternate" type="application/rss+xml" title="<?php echo $this->GetTranslation("RecentCommentsRSS");?>" href="<?php echo $this->config["base_url"];?>xml/comments_<?php echo preg_replace("/[^a-zA-Z0-9]/", "", strtolower($this->config["wacko_name"]));?>.xml" />
		<link rel="alternate" type="application/rss+xml" title="<?php echo $this->GetTranslation("HistoryRevisionsRSS");?><?php echo $this->tag; ?>" href="<?php echo $this->href("revisions.xml");?>" />
<?php
// JS files.
// default.js contains common procedures and should be included everywhere
?>
  <script type="text/javascript" src="<?php echo $this->config["base_url"];?>js/default.js"></script>
<?php
// protoedit & wikiedit2.js contain classes for WikiEdit editor. We may include them only on method==edit pages
if ($this->method == 'edit')
{
	echo "  <script type=\"text/javascript\" src=\"".$this->config["base_url"]."js/protoedit.js\"></script>\n";
	echo "  <script type=\"text/javascript\" src=\"".$this->config["base_url"]."js/wikiedit2.js\"></script>\n";
	echo "  <script type=\"text/javascript\" src=\"".$this->config["base_url"]."js/autocomplete.js\"></script>\n";
}
?>
		<script type="text/javascript" src="<?php echo $this->config["base_url"];?>js/swfobject.js"></script>
		<script type="text/javascript" src="<?php echo $this->config["base_url"];?>js/captcha.js"></script>
		<script type="text/javascript" src="<?php echo $this->config["theme_url"] ?>js/leftframe.js"></script>
<?php
// Doubleclick edit feature.
// Enabled only for registered users who don't swith it off (requires class=page in show handler).
if ($user = $this->GetUser())
   {
      if ($user["doubleclick_edit"] == "1")
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

<body onload="all_init();">

<table class="topbody" align="center" border="0" cellpadding="0" cellspacing="0" width="100%">
	<tr>
  		<td>
			<?php echo $this->config["wacko_name"] ?>: <?php echo $this->GetPagePath(); ?>
			<a class="Search" title="<?php echo $this->GetTranslation("SearchTitleTip")?>" href="<?php echo $this->config["base_url"].$this->GetTranslation("TextSearchPage").($this->config["rewrite_mode"] ? "?" : "&amp;");?>phrase=<?php echo urlencode($this->tag); ?>">...</a>
		</td>
	  	<td class="searchArea" align="right" valign="bottom">
			<?php echo $this->FormOpen("", $this->GetTranslation("TextSearchPage"), "get"); ?>
			<?php echo $this->GetTranslation("SearchText") ?>
			<input type="text" name="phrase" size="15" style="border: none; border-bottom: 1px solid #CCCCAA; padding: 0px; margin: 0px;" />
			<?php echo $this->FormClose(); ?>
		</td>
	</tr>
</table>

<table align="center" border="0" cellpadding="0" cellspacing="0" width="100%">
	<tr>
  		<td class="left" valign="top">
		  	<table class="navOpened" id="sw_n0" align="center" cellpadding="0" cellspacing="0" width="100%">
				<tr>
    				<th onclick="opentree('sw_n0')" valign="top">
						<table class="navTitle" onmouseover="mover(this)" onmouseout="mout(this)" border="0" cellpadding="0" cellspacing="0" width="100%">
							<tr>
								<td class="titleLeft"><img src="<?php echo $this->config["theme_url"] ?>images/1x1.gif" alt="" height="1" width="14"/></td>
								<td class="titleText" width="100%">
									<?php echo $this->GetTranslation("YourBookmarks"); ?>
								</td>
								<td class="titleHandle"><img src="<?php echo $this->config["theme_url"] ?>images/1x1.gif" alt="" height="1" width="20"/></td>
								<td class="titleRight"><img src="<?php echo $this->config["theme_url"] ?>images/1x1.gif" alt="" height="1" width="3"/></td>
							</tr>
						</table>
					</th>
    			</tr>
			    <tr>
    				<td class="modulecontent">
						<div class="modulecontent">
<?php
        echo $this->ComposeLinkToPage($this->config["root_page"]);
        echo "<hr />";
        echo $this->Format(implode( "\n", $this->GetBookmarks()));
        echo "<hr />";

        if ($this->GetUser()) {
			if (!in_array($this->tag, $this->GetBookmarkLinks())) {?>
				<a href="<?php echo $this->Href('', '', "addbookmark=yes")?>">
					<?php echo $this->GetTranslation("AddToBookmarks"); ?>
				</a>
	<?php } else { ?>
			<a href="<?php echo $this->Href('', '', "removebookmark=yes")?>">
			<?php echo $this->GetTranslation("RemoveFromBookmarks"); ?>
			</a>
	<?php }
        }
?>
						</div>
					</td>
				</tr>
      		</table>

		  	<table class="navOpened" id="sw_n1" align="center" cellpadding="0" cellspacing="0" width="100%">
				<tr>
    				<th onclick="opentree('sw_n1')" valign="top">
						<table class="navTitle" onmouseover="mover(this)" onmouseout="mout(this)" border="0" cellpadding="0" cellspacing="0" width="100%">
							<tr>
								<td class="titleLeft"><img src="<?php echo $this->config["theme_url"] ?>images/1x1.gif" alt="" height="1" border="0" width="14"/></td>
								<td class="titleText" width="100%">This Page</td>
								<td class="titleHandle"><img src="<?php echo $this->config["theme_url"] ?>images/1x1.gif" alt="" height="1" width="20"/></td>
								<td class="titleRight"><img src="<?php echo $this->config["theme_url"] ?>images/1x1.gif" alt="" height="1" width="3"/></td>
							</tr>
						</table>
					</th>
    			</tr>
			    <tr>
    				<td class="modulecontent">
						<div class="modulecontent">
						<?php
echo $this->page["modified"] ? "<a href=\"".$this->href("revisions")."\" title=\"".$this->GetTranslation("RevisionTip")."\">".$this->GetPageTimeFormatted()."</a>\n" : "";
        					echo "<hr />";

                            if ($this->HasAccess("write")) {
								echo "<a href=\"".$this->href("edit")."\" accesskey=\"E\" title=\"".$this->GetTranslation("EditTip")."\">".$this->GetTranslation("EditText")."</a>\n";
							}
							echo '<br />';
                            if ($this->page["modified"]) {
								echo "<a href=\"".$this->href("revisions")."\" title=\"".$this->GetTranslation("RevisionTip")."\">".$this->GetTranslation('SettingsRevisions')."</a>\n";
                            }
							// if this page exists
							if ($this->page) {
								// if owner is current user
							    if ($this->UserIsOwner()) {
									echo '<br />';
							    	print(" <a href=\"".$this->href("rename")."\">".$this->GetTranslation("RenameText")."</a>");
									echo '<br />';
							    	print("<a href=\"".$this->href("acls")."\"".(($this->method=='edit')?" onclick=\"return window.confirm('".$this->GetTranslation("EditACLConfirm")."');\"":"").">".$this->GetTranslation("EditACLText")."</a>");
							    }

							    if ($this->CheckACL($this->GetUserName(),$this->config["rename_globalacl"]) && !$this->UserIsOwner()) {
									echo '<br />';
							    	print(" <a href=\"".$this->href("rename")."\">".$this->GetTranslation("RenameText")."</a>");
							    }

							    if ($this->IsAdmin()) {
									echo '<br />';
									print(" <a href=\"".$this->href("remove")."\">".$this->GetTranslation("DeleteText")."</a>");
							    }

								echo '<br />';
							    print("<a href=\"".$this->href("settings"). "\"".(($this->method=='edit')?" onclick=\"return window.confirm('".$this->GetTranslation("EditACLConfirm")."');\"":"").">".$this->GetTranslation("SettingsText")."</a>");

								echo '<br />';
								print "<a href=\"".$this->href("export.xml")."\" title=\"Click to view recent page revisions in XML format.\" target=\"_blank\">Export to XML</a>\n";

								//print $this->Format( '{{TOC}}' );

							    if ($this->UserIsOwner()) {
		                       		echo "<hr />";
									print($this->GetTranslation("YouAreOwner"));
							    } else {
		                       		echo "<hr />";
							    	if ($owner = $this->GetPageOwner()) {
							        print($this->GetTranslation("Owner").": ".$this->Link($owner));
							      } else if (!$this->page["comment_on_id"]) {
							        print($this->GetTranslation("Nobody").($this->GetUser() ? " (<a href=\"".$this->href("claim")."\">".$this->GetTranslation("TakeOwnership")."</a>)" : ""));
							      }
								}
							}
						?>
						</div>
					</td>
				</tr>
      		</table>
		</td>
		<td>
<!-- wrapper -->

<?php echo $this->FormOpen("", $this->GetTranslation("LoginPage"), "post"); ?>
<input type="hidden" name="action" value="login" />

<div class="header">
	<?php echo ($this->iswatched === true
			? "<a href=\"".$this->href("watch")."\"><img src=\"".$this->config["theme_url"]."icons/unwatch.gif\" title=\"".$this->GetTranslation("RemoveWatch")."\" alt=\"".$this->GetTranslation("RemoveWatch")."\"  align=\"absmiddle\" border=\"0\" /></a>"
			: "<a href=\"".$this->href("watch")."\"><img src=\"".$this->config["theme_url"]."icons/watch.gif\" title=\"".$this->GetTranslation("SetWatch")."\" alt=\"".$this->GetTranslation("SetWatch")."\"  align=\"absmiddle\" border=\"0\" /></a>" ) ?> |
  	<?php echo "<a href=\"".$this->href("print")."\" target=\"_new\"><img src=\"".$this->config["theme_url"]."icons/print.gif\" title=\"".$this->GetTranslation("PrintVersion")."\" alt=\"".$this->GetTranslation("PrintVersion")."\"  align=\"absmiddle\" border=\"0\" /></a>";?> |
    <?php
		if ($this->GetUser()) { ?>
            <span class="nobr">
				<?php echo $this->GetTranslation("YouAre"); ?>
				<img src="<?php echo $this->config["theme_url"] ?>icons/user.gif" width="12" height="12" border="0" style="vertical-align: baseline; " alt=""/>
				<?php echo $this->Link($this->GetUserName()) ?>
			</span>
            <small>
				(
				<span class="nobr Tune">
					<?php echo $this->ComposeLinkToPage($this->GetTranslation("YouArePanelLink"), "", $this->GetTranslation("YouArePanelAccount"), 0); ?> |
					<a onclick="return confirm('<?php echo $this->GetTranslation("LogoutAreYouSure");?>');" href="<?php echo $this->Href("",$this->GetTranslation("LoginPage")).($this->config["rewrite_mode"] ? "?" : "&amp;");?>action=logout&amp;goback=<?php echo $this->SlimUrl($this->tag);?>">
						<?php echo $this->GetTranslation("LogoutLink"); ?>
					</a>
				</span>
				)
			</small>

    <?php } else { ?>
            <span class="nobr">
				<input type="hidden" name="goback" value="<?php echo $this->SlimUrl($this->tag);?>" />
				<strong><?php echo $this->GetTranslation("LoginWelcome") ?>:&nbsp;</strong>
				<input type="text" name="name" size="18" class="login" />&nbsp;<?php echo $this->GetTranslation("LoginPassword") ?>:&nbsp;<input type="password" name="password" class="login" size="8" />&nbsp;<input type="submit" value="Ok" />
			</span>
    <?php } ?>

</div>
<?php echo $this->FormClose(); ?>
<?php
// here we show messages
if ($message = $this->GetMessage()) echo "<div class=\"info\">$message</div>";
?>