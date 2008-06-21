<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<!--
I tried to fit the W3C standards while creating this template.
Please do NEVER forget: Microsoft != standard

Based on the NoProbs template from Gururaj:
http://openwebdesign.org/userinfo.phtml?user=kpgururaja
-->
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->page["lang"] ?>" lang="<?php echo $this->page["lang"] ?>">
<head>
	<meta name="author" content="Theme for WackoWiki by Robert Vaeth" />
	<meta name="keywords" content="<?php echo $this->GetKeywords(); ?>" />
	<meta name="description" content="<?php echo $this->GetDescription(); ?>" />
	<meta http-equiv="content-type" content="text/html; charset=<?php echo $this->GetCharset(); ?>" />
	<link rel="stylesheet" type="text/css" href="<?php echo $this->GetConfigValue("theme_url"); ?>css/default.css" media="screen" />
	<link rel="stylesheet" type="text/css" href="<?php echo $this->GetConfigValue("theme_url"); ?>css/page.css" media="screen" />
	<link rel="stylesheet" type="text/css" href="<?php echo $this->GetConfigValue("theme_url"); ?>css/wakka.css" media="screen" />
	<link rel="shortcut icon" type="image/x-icon" href="<?php echo $this->GetConfigValue("theme_url"); ?>icons/icon.gif" />
	<link rel="alternate" type="application/rss+xml" title="RecentChanges in RSS" href="<?php echo $this->GetConfigValue("root_url"); ?>xml/recentchanges_<?php echo preg_replace("/[^a-zA-Z0-9]/", "", strtolower($this->GetConfigValue("wakka_name"))); ?>.xml" />
	<link rel="alternate" type="application/rss+xml" title="History/revisions of <?php echo $this->tag; ?> in RSS" href="<?php echo $this->href("revisions.xml");?>" /> 
	<?php if($this->GetMethod() != 'show' || $this->page["latest"] == "N") { ?><meta name="robots" content="noindex, nofollow" /><?php } ?>
	<title><?php echo $this->GetWakkaName()." : ".$this->AddSpaces($this->GetPageTag()).($this->method!="show"?" (".$this->method.")":""); ?></title>
	<!-- JavaScript used by WackoWiki -->
	<script language="JavaScript" type="text/javascript" src="<?php echo $this->GetConfigValue("root_url"); ?>js/default.js"></script>
	<script language="JavaScript" type="text/javascript" src="<?php echo $this->GetConfigValue("root_url"); ?>js/protoedit.js"></script>
	<script language="JavaScript" type="text/javascript" src="<?php echo $this->GetConfigValue("root_url"); ?>js/wikiedit2.js"></script>
	<script language="JavaScript" type="text/javascript" src="<?php echo $this->GetConfigValue("root_url"); ?>js/autocomplete.js"></script>
	<script language="JavaScript" type="text/javascript" src="<?php echo $this->GetConfigValue("root_url");?>js/swfobject.js"></script>
	<?php if($user = $this->GetUser()) if($user["doubleclickedit"] == "Y") { ?>
	<!-- Edit by doubleclick for logged in users -->
	<script language="JavaScript" type="text/javascript">
		var edit = "<?php echo $this->href("edit");?>";
	</script>
	<?php } ?>
</head>

<body onload="all_init();<?php if($message) echo "alert('".$message."');"; ?>">
	<div id="mainwrapper">
		<div id="header">
			<?php // Insert search form ?> 
			<?php echo $this->FormOpen("", $this->GetResourceValue("TextSearchPage"), "get"); ?>
			<input type="text" name="phrase" size="15" value="<?php echo $this->GetResourceValue("SearchButtonText"); ?>" class="search">
			<?php echo $this->FormClose(); ?> 
			
			<?php // Print wackoname and wackopath (and the magic 3 dots) ?>
			<b><?php echo $this->config["wakka_name"]; ?>:</b>
			<?php echo $this->GetPagePath(); ?>
			<a title="<?php echo $this->GetResourceValue("SearchTitleHelp"); ?>" href="<?php echo $this->config["base_url"].$this->GetResourceValue("TextSearchPage").($this->config["rewrite_mode"] ? "?" : "&amp;"); ?>phrase=<?php echo urlencode($this->GetPageTag()); ?>">...</a> 
		</div>
		<div id="quicklinks">
			<div class="bookmarks">
				<?php // Insert links to root page and personal bookmarks ?>
				<?php echo $this->ComposeLinkToPage($this->config["root_page"]); ?> |
				<?php echo $this->Format($this->GetBookmarksFormatted(), "post_wacko"); ?>
			</div>
			<?php // If logged in, show username, settings and logout ?>
			<?php if($user = $this->GetUser()) { ?>
			<div class="user">
				<?php echo $this->Link($this->GetUserName()); ?>
				<small>( <?php echo $this->ComposeLinkToPage($this->GetResourceValue("YouArePanelLink"), "", $this->GetResourceValue("YouArePanelName"), 0); ?> |
				<a href="<?php echo $this->Href("",$this->GetResourceValue("LoginPage")).($this->config["rewrite_mode"] ? "?" : "&amp;");?>action=logout&amp;goback=<?php echo $this->SlimUrl($this->tag);?>"><?php echo $this->GetResourceValue("LogoutLink"); ?></a> )</small>
			</div>
			<?php } ?>
		</div>
		<div id="quickactions">
			<?php // If logged in, show quick actions, else show login box ?>
			<?php if($user = $this->GetUser()) { ?>
			<?php // Show edit button only if user has privileges ?>
			<?php if($this->HasAccess("write")) { ?>
			<a href="<?php echo $this->href("edit"); ?>" accesskey="E">
				<img src="<?php echo $this->GetConfigValue("theme_url"); ?>images/qa-edit.gif" alt="<?php echo $this->GetResourceValue("EditTip"); ?>" title="<?php echo $this->GetResourceValue("EditTip"); ?>" />
			</a>&nbsp;&nbsp;&nbsp;
			<?php } ?>
			<?php // Show ACL button only if user has privileges (or is admin) and if the page exists ?>
			<?php if($this->page) if($this->UserIsOwner() || $this->IsAdmin()) { ?>
			<a href="<?php echo $this->href("acls"); ?>">
				<img src="<?php echo $this->GetConfigValue("theme_url"); ?>images/qa-acl.gif" alt="<?php echo $this->GetResourceValue("EditACLText"); ?>" title="<?php echo $this->GetResourceValue("EditACLText"); ?>" />
			</a>
			<?php } ?>
			<a href="<?php echo $this->href("print"); ?>">
				<img src="<?php echo $this->GetConfigValue("theme_url"); ?>images/qa-print.gif" alt="<?php echo $this->GetResourceValue("PrintVersion"); ?>" title="<?php echo $this->GetResourceValue("PrintVersion"); ?>" />
			</a>
			<?php } else { ?>
			<div class="loginbox">
				<?php echo $this->FormOpen("", $this->GetResourceValue("LoginPage"), "post"); ?>
				<input type="hidden" name="action" value="login" /> 
				<input type="hidden" name="goback" value="<?php echo $this->SlimUrl($this->tag); ?>" />
				<?php echo $this->GetResourceValue("LoginWelcome"); ?>
				<input type="text" name="name" size="15" class="login" />
				<?php echo $this->GetResourceValue("LoginPassword"); ?>
				<input type="password" name="password" size="10" class="login" />
				<input type="image" src="<?php echo $this->GetConfigValue("theme_url"); ?>icons/login.gif" alt="<?php echo $this->GetResourceValue("LoginWelcome"); ?>" class="login" />
				<?php echo $this->FormClose(); ?>
			</div>
			<?php } ?>
		</div>
