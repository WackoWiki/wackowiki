<?php
	$message = $this->GetMessage();
	header( "Content-Type: text/html; charset=".$this->GetCharset() );
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->page["lang"] ?>" lang="<?php echo $this->page["lang"] ?>">

<html>
	<head>
  		<title>
			<?php echo $this->GetWakkaName()." : ".$this->AddSpaces($this->GetPageTag()).($this->method!="show"?" (".$this->method.")":""); ?>
		</title>
<?php
	if ($this->GetMethod() != 'show' || $this->page["latest"] == "N") {
		echo "<meta name=\"robots\" content=\"noindex, nofollow\" />\n";
	}
?>
		<meta name="keywords" content="<?php echo $this->GetKeywords(); ?>" />
		<meta name="description" content="<?php echo $this->GetDescription(); ?>" />
		<meta http-equiv="content-type" content="text/html; charset=<?php echo $this->GetCharset(); ?>" />
		<link rel="stylesheet" type="text/css" href="<?php echo $this->GetConfigValue("theme_url") ?>css/wakka.css" />
		<link rel="stylesheet" type="text/css" href="<?php echo $this->GetConfigValue("theme_url") ?>css/left.css" />
		<link rel="shortcut icon" href="<?php echo $this->GetConfigValue("theme_url") ?>icons/wacko.ico" type="image/x-icon" />
		<link rel="alternate" type="application/rss+xml" title="RecentChanges in RSS" href="<?php echo $this->GetConfigValue("root_url");?>xml/recentchanges_<?php echo preg_replace("/[^a-zA-Z0-9]/", "", strtolower($this->GetConfigValue("wakka_name")));?>.xml" />
		<script language="JavaScript" type="text/javascript" src="<?php echo $this->GetConfigValue("root_url");?>js/default.js"></script>
		<script language="JavaScript" type="text/javascript" src="<?php echo $this->GetConfigValue("root_url");?>js/protoedit.js"></script>
		<script language="JavaScript" type="text/javascript" src="<?php echo $this->GetConfigValue("root_url");?>js/wikiedit2.js"></script>

		<script language="javascript" type="text/javascript" src="<?php echo $this->GetConfigValue("theme_url") ?>js/leftframe.js"></script>
<?php
    if ($user = $this->GetUser()){
		if ($user["doubleclickedit"] == "Y") {
?>
		<script language="JavaScript" type="text/javascript">
			var edit = "<?php echo $this->href("edit");?>";
		</script>
		<?php
		}
	}
?>
	</head>

<body onload="all_init();<?php if ($message) echo "alert('".$message."');";?>">

<table class="topbody" align="center" border="0" cellpadding="0" cellspacing="0" width="100%">
	<tr>
  		<td>
			<?php echo $this->config["wakka_name"] ?>: <?php echo $this->GetPagePath(); ?>
			<a class="Search" title="<?php echo $this->GetResourceValue("search_title_help")?>" href="<?php echo $this->config["base_url"].$this->GetResourceValue("TextSearchPage").($this->config["rewrite_mode"] ? "?" : "&amp;");?>phrase=<?php echo urlencode($this->GetPageTag()); ?>">...</a>
		</td>
	  	<td class="searchArea" align="right" valign="bottom">
			<?php echo $this->FormOpen("", $this->GetResourceValue("TextSearchPage"), "get"); ?>
			<input name="phrase" type="text" style="border: none; border-bottom: 1px solid #FFFFFF; padding: 0px; margin: 0px; background-color: #FFFFFF;" size="21" />
			<?php echo $this->FormClose(); ?>
	  </td>
	</tr>
</table>

<table align="center" border="0" cellpadding="0" cellspacing="0" width="100%">
	<tr>
  		<td valign="top" class="left" width="185" nowrap="nowrap">
		  	<table width="185" border="0" align="left" cellpadding="0" cellspacing="0">
              <tr align="left">
                <td><table class="navOpened" id="sw_n0" align="left" cellpadding="0" cellspacing="0" width="100%">
				<tr>
    				<th onclick="opentree('sw_n0')" valign="top">
						<table class="navTitle" onmouseover="mover(this)" onmouseout="mout(this)" border="0" cellpadding="0" cellspacing="0" width="100%">
							<tr>
								<td class="titleLeft"><img src="<?php echo $this->GetConfigValue("theme_url") ?>images/1x1.gif" width="14" /></td>
								<td class="titleText" width="100%">
									<?php echo $this->GetResourceValue("YourBookmarks"); ?>								</td>
						  </tr>
						</table>					</th>
    			</tr>
			    <tr>
    				<td class="modulecontent">
						<div class="modulecontent"><?php
        echo $this->ComposeLinkToPage($this->config["root_page"]);
        echo "<HR color=#CCCCCC noshade size=1 />";
        echo $this->Format(implode( "\n", $this->GetBookmarks()));
        echo "<HR color=#CCCCCC noshade size=1 />";

       if ($this->GetUser()) {
			if (!in_array($this->GetPageSuperTag(),$this->GetBookmarkLinks())) {?>
				<a href="<?php echo $this->Href('', '', "addbookmark=yes")?>" title="<?php echo $this->GetResourceValue("AddToBookmarks"); ?>">
				<img src="<?php echo $this->GetConfigValue("theme_url") ?>icons/toolbar1.gif" border="0" align="bottom" style="vertical-align: middle; " />
					<?php echo $this->GetResourceValue("Bookmarks"); ?>
				</a>
	<?php } else { ?>
			<a href="<?php echo $this->Href('', '', "removebookmark=yes")?>" title="<?php echo $this->GetResourceValue("RemoveFromBookmarks"); ?>">
			<img src="<?php echo $this->GetConfigValue("theme_url") ?>icons/toolbar2.gif" style="vertical-align: middle; "/>
			<?php echo $this->GetResourceValue("Bookmarks"); ?>
			</a>
	<?php }
        }
?>
						</div>					</td>
				</tr>
   		  </table></td>
              </tr>
              <tr align="left">
                <td><table class="navOpened" id="sw_n1" align="center" cellpadding="0" cellspacing="0" width="100%">
				<tr>
    				<th onclick="opentree('sw_n1')" valign="top">
						<table class="navTitle" onmouseover="mover(this)" onmouseout="mout(this)" border="0" cellpadding="0" cellspacing="0" width="100%">
							<tr>
							<td class="titleLeft"><img src="<?php echo $this->GetConfigValue("theme_url") ?>images/1x1.gif" width="14" /></td>
								<td class="titleText" width="100%">
								<?php echo $this->GetResourceValue("ThisPage"); ?>
								</td>
							</tr>
						</table>					</th>
    			</tr>
			    <tr>
    				<td class="modulecontent">
						<div class="modulecontent"><?php
echo $this->GetPageTime() ? "<a href=\"".$this->href("revisions")."\" title=\"".$this->GetResourceValue("RevisionTip")."\">".$this->GetPageTime()."</a>\n" : "";
        					echo "<HR color=#CCCCCC noshade size=1 />";

                            if ($this->HasAccess("write")) {
								echo "<a href=\"".$this->href("edit")."\" accesskey=\"E\" title=\"".$this->GetResourceValue("EditTip")."\"><img src=\"".$this->GetConfigValue("theme_url")."icons/edit.gif\""."style=\"vertical-align: middle\""."\">".$this->GetResourceValue("EditText")."</a>\n";
							
							}
							echo '<br />';
							if ($this->GetPageTime()) {
								echo "<a href=\"".$this->href("revisions")."\" title=\"".$this->GetResourceValue("RevisionTip")."\"><img src=\"".$this->GetConfigValue("theme_url")."icons/vers.gif\""."style=\"vertical-align: middle\""."\">".$this->GetResourceValue('SettingsRevisions')."</a>\n";
                            }
							// if this page exists
							if ($this->page) {
								// if owner is current user
							    if ($this->UserIsOwner()) {
									echo '<br />';
							    	print(" <a href=\"".$this->href("rename")."\"><img src=\"".$this->GetConfigValue("theme_url")."icons/ren.gif\""."style=\"vertical-align: middle\""."\">".$this->GetResourceValue("RenameText")."</a>");
									echo '<br />';
							    	print("<a href=\"".$this->href("acls")."\"".(($this->method=='edit')?" onclick=\"return window.confirm('".$this->GetResourceValue("EditACLConfirm")."');\"":"")."\"><img src=\"".$this->GetConfigValue("theme_url")."icons/access.gif\""."style=\"vertical-align: middle\"".">".$this->GetResourceValue("EditACLText")."</a>");
							    }

							    if ($this->CheckACL($this->GetUserName(),$this->config["rename_globalacl"]) && !$this->UserIsOwner()) {
									echo '<br />';
							    	print(" <a href=\"".$this->href("rename")."\">".$this->GetResourceValue("RenameText")."</a>");
							    }

							    if ($this->IsAdmin()) {
									echo '<br />';
									print(" <a href=\"".$this->href("remove")."\"><img src=\"".$this->GetConfigValue("theme_url")."icons/1del.gif\""."style=\"vertical-align: middle\""."\">".$this->GetResourceValue("DeleteText")."</a>");
							    }

								echo '<br />';
							    print("<a href=\"".$this->href("settings"). "\"".(($this->method=='edit')?" onclick=\"return window.confirm('".$this->GetResourceValue("EditACLConfirm")."');\"":"")."\"><img src=\"".$this->GetConfigValue("theme_url")."icons/prop.gif\""."style=\"vertical-align: middle\"".">".$this->GetResourceValue("SettingsText")."</a>");

								echo '<br />';
								print "<a href=\"".$this->href("export.xml")."\" title=\"".$this->GetResourceValue("RevisionXMLTip")."\"><img src=\"".$this->GetConfigValue("theme_url")."icons/1xml.gif\""."style=\"vertical-align: middle\""."\" target=\"_blank\">".$this->GetResourceValue("ExportToXML")."</a>\n";

								//print $this->Format( '{{TOC}}' );

							    if ($this->UserIsOwner()) {
		                       		echo "<HR color=#CCCCCC noshade size=1 />";
									print($this->GetResourceValue("YouAreOwner"));
							    } else {
		                       		echo "<HR color=#CCCCCC noshade size=1 />";
							    	if ($owner = $this->GetPageOwner()) {
							        print($this->GetResourceValue("Owner").$this->Link($owner));
							      } else if (!$this->page["comment_on"]) {
							        print($this->GetResourceValue("Nobody").($this->GetUser() ? " (<a href=\"".$this->href("claim")."\">".$this->GetResourceValue("TakeOwnership")."</a>)" : ""));
							      }
								}
							}
						?>
						</div>					</td>
				</tr>
	  </table></td>
              </tr>
            </table>
		  	

	  </td>
		<td>
<!-- wrapper -->

<?php echo $this->FormOpen("", $this->GetResourceValue("LoginPage"), "post"); ?>
<input type="hidden" name="action" value="login" />

<div class="header">
	<?php echo ($this->IsWatched($this->GetUserName(), $this->GetPageTag())
			? "<a href=\"".$this->href("watch")."\"><img src=\"".$this->GetConfigValue("theme_url")."icons/1unvisibl.gif\" title=\"".$this->GetResourceValue("RemoveWatch")."\" alt=\"".$this->GetResourceValue("RemoveWatch")."\"  align=\"absmiddle\" border=\"0\" /></a>"
			: "<a href=\"".$this->href("watch")."\"><img src=\"".$this->GetConfigValue("theme_url")."icons/visibl.gif\" title=\"".$this->GetResourceValue("SetWatch")."\" alt=\"".$this->GetResourceValue("SetWatch")."\"  align=\"absmiddle\" border=\"0\" /></a>" ) ?> |
  	<?php echo "<a href=\"".$this->href("print")."\" target=\"_new\"><img src=\"".$this->GetConfigValue("theme_url")."icons/1print.gif\" title=\"".$this->GetResourceValue("PrintVersion")."\" alt=\"".$this->GetResourceValue("PrintVersion")."\"  align=\"absmiddle\" border=\"0\" /></a>";?> |
    <?php
		if ($this->GetUser()) { ?>
            <span class="nobr">
				<?php echo $this->GetResourceValue("YouAre"); ?>
				<img src="<?php echo $this->GetConfigValue("theme_url") ?>icons/user.gif" alt="" width="16" height="16" border="0" align="absmiddle" style="vertical-align: baseline; "/>
				<?php echo $this->Link($this->GetUserName()) ?>			</span>
            <small>
				(
				<span class="nobr Tune">
					<?php echo $this->ComposeLinkToPage($this->GetResourceValue("YouArePanelLink"), "", $this->GetResourceValue("YouArePanelName"), 0); ?> |
					<a onclick="return confirm('<?php echo $this->GetResourceValue("LogoutAreYouSure");?>');" href="<?php echo $this->Href("",$this->GetResourceValue("LoginPage")).($this->config["rewrite_mode"] ? "?" : "&amp;");?>action=logout&amp;goback=<?php echo $this->SlimUrl($this->tag);?>">
						<?php echo $this->GetResourceValue("LogoutLink"); ?>					</a>				</span>
				)			</small>

    <?php } else { ?>
            <span class="nobr">
				<input type="hidden" name="goback" value="<?php echo $this->SlimUrl($this->tag);?>" />
				<strong><?php echo $this->GetResourceValue("LoginWelcome") ?>:&nbsp;</strong>
				<input type="text" name="name" size="18" class="login" />&nbsp;<?php echo $this->GetResourceValue("LoginPassword") ?>:&nbsp;<input type="password" name="password" class="login" size="8" />&nbsp;<input type="submit" value="Ok" />
	  </span>
    <?php } ?>

                

</div>


<?php echo $this->FormClose(); ?>

