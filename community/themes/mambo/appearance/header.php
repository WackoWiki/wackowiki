<?php
	header( "Content-Type: text/html; charset=".$this->get_charset() );
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->page['lang'] ?>" lang="<?php echo $this->page['lang'] ?>">
	<head>
  		<title>
			<?php echo htmlspecialchars($this->config['wacko_name'])." : ".(isset($this->page['title']) ? $this->page['title'] : $this->add_spaces($this->tag)).($this->method != 'show' ? ' ('.$this->method.')' : ''); ?>
		</title>
<?php
// We don't need search robots to index subordinate pages, if indexing is disabled globally or per page
if ($this->method != 'show' || $this->page['latest'] == 0 || $this->config['noindex'] == 1 || $this->page['noindex'] == 1)
	echo "	<meta name=\"robots\" content=\"noindex, nofollow\" />\n";
?>
		<meta name="keywords" content="<?php echo $this->get_keywords(); ?>" />
		<meta name="description" content="<?php echo $this->get_description(); ?>" />
		<meta name="language" content="<?php echo $this->page['lang'] ?>" />
		<meta http-equiv="content-type" content="text/html; charset=<?php echo $this->get_charset(); ?>" />
		<link rel="stylesheet" type="text/css" href="<?php echo $this->config['theme_url'] ?>css/default.css" />
		<?php if ($this->config['allow_x11colors']) {?><link rel="stylesheet" type="text/css" href="<?php echo $this->config['base_url'] ?>themes/_common/X11colors.css" /><?php } ?>
		<link rel="stylesheet" type="text/css" href="<?php echo $this->config['theme_url'] ?>css/left.css" />
		<link rel="shortcut icon" href="<?php echo $this->config['theme_url'] ?>icons/favicon.ico" type="image/x-icon" />
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
		<script type="text/javascript" src="<?php echo $this->config['theme_url'] ?>js/leftframe.js"></script>
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

<table class="topbody" align="center" border="0" cellpadding="0" cellspacing="0" width="100%">
	<tr>
  		<td>
			<?php echo $this->config['wacko_name'] ?>: <?php echo $this->get_page_path(); ?>
			<a class="Search" title="<?php echo $this->get_translation('SearchTitleTip')?>" href="<?php echo $this->config['base_url'].$this->get_translation('TextSearchPage').($this->config['rewrite_mode'] ? "?" : "&amp;");?>phrase=<?php echo urlencode($this->tag); ?>">...</a>
		</td>
	  	<td class="searchArea" align="right" valign="bottom">
			<?php echo $this->form_open('', $this->get_translation('TextSearchPage'), 'get'); ?>
			<?php echo $this->get_translation('SearchText') ?>
			<input type="text" name="phrase" size="15" style="border: none; border-bottom: 1px solid #CCCCAA; padding: 0px; margin: 0px;" />
			<?php echo $this->form_close(); ?>
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
								<td class="titleLeft"><img src="<?php echo $this->config['theme_url'] ?>images/1x1.gif" alt="" height="1" width="14"/></td>
								<td class="titleText" width="100%">
									<?php echo $this->get_translation('YourBookmarks'); ?>
								</td>
								<td class="titleHandle"><img src="<?php echo $this->config['theme_url'] ?>images/1x1.gif" alt="" height="1" width="20"/></td>
								<td class="titleRight"><img src="<?php echo $this->config['theme_url'] ?>images/1x1.gif" alt="" height="1" width="3"/></td>
							</tr>
						</table>
					</th>
    			</tr>
			    <tr>
    				<td class="modulecontent">
						<div class="modulecontent">
<?php
        echo $this->compose_link_to_page($this->config['root_page']);
        echo "<hr />";
        echo $this->format(implode( "\n", $this->get_bookmarks()));
        echo "<hr />";

        if ($this->get_user()) {
			if (!in_array($this->tag, $this->get_bookmark_links())) {?>
				<a href="<?php echo $this->href('', '', "addbookmark=yes")?>">
					<?php echo $this->get_translation('AddToBookmarks'); ?>
				</a>
	<?php } else { ?>
			<a href="<?php echo $this->href('', '', "removebookmark=yes")?>">
			<?php echo $this->get_translation('RemoveFromBookmarks'); ?>
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
								<td class="titleLeft"><img src="<?php echo $this->config['theme_url'] ?>images/1x1.gif" alt="" height="1" border="0" width="14"/></td>
								<td class="titleText" width="100%">This Page</td>
								<td class="titleHandle"><img src="<?php echo $this->config['theme_url'] ?>images/1x1.gif" alt="" height="1" width="20"/></td>
								<td class="titleRight"><img src="<?php echo $this->config['theme_url'] ?>images/1x1.gif" alt="" height="1" width="3"/></td>
							</tr>
						</table>
					</th>
    			</tr>
			    <tr>
    				<td class="modulecontent">
						<div class="modulecontent">
						<?php
echo $this->page['modified'] ? "<a href=\"".$this->href('revisions')."\" title=\"".$this->get_translation('RevisionTip')."\">".$this->get_page_time_formatted()."</a>\n" : "";
        					echo "<hr />";

                            if ($this->has_access('write')) {
								echo "<a href=\"".$this->href('edit')."\" accesskey=\"E\" title=\"".$this->get_translation('EditTip')."\">".$this->get_translation('EditText')."</a>\n";
							}
							echo '<br />';
                            if ($this->page['modified']) {
								echo "<a href=\"".$this->href('revisions')."\" title=\"".$this->get_translation('RevisionTip')."\">".$this->get_translation('SettingsRevisions')."</a>\n";
                            }
							// if this page exists
							if ($this->page) {
								// if owner is current user
							    if ($this->user_is_owner()) {
									echo '<br />';
							    	print(" <a href=\"".$this->href('rename')."\">".$this->get_translation('RenameText')."</a>");
									echo '<br />';
							    	print("<a href=\"".$this->href('permissions')."\"".(($this->method=='edit')?" onclick=\"return window.confirm('".$this->get_translation('EditACLConfirm')."');\"":"").">".$this->get_translation('ACLText')."</a>");
							    }

							    if ($this->check_acl($this->get_user_name(),$this->config['rename_globalacl']) && !$this->user_is_owner()) {
									echo '<br />';
							    	print(" <a href=\"".$this->href('rename')."\">".$this->get_translation('RenameText')."</a>");
							    }

							    if ($this->is_admin()) {
									echo '<br />';
									print(" <a href=\"".$this->href('remove')."\">".$this->get_translation('DeleteText')."</a>");
							    }

								echo '<br />';
							    print("<a href=\"".$this->href('properties'). "\"".(($this->method=='edit')?" onclick=\"return window.confirm('".$this->get_translation('EditACLConfirm')."');\"":"").">".$this->get_translation('SettingsText')."</a>");

								echo '<br />';
								print "<a href=\"".$this->href('export.xml')."\" title=\"Click to view recent page revisions in XML format.\" target=\"_blank\">Export to XML</a>\n";

								//print $this->format( '{{TOC}}' );

							    if ($this->user_is_owner()) {
		                       		echo "<hr />";
									print($this->get_translation('YouAreOwner'));
							    } else {
		                       		echo "<hr />";
							    	if ($owner = $this->get_page_owner()) {
							        print($this->get_translation('Owner').": ".$this->link($owner));
							      } else if (!$this->page['comment_on_id']) {
							        print($this->get_translation('Nobody').($this->get_user() ? " (<a href=\"".$this->href('claim')."\">".$this->get_translation('TakeOwnership')."</a>)" : ""));
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

<?php echo $this->form_open('', $this->get_translation('LoginPage'), 'post'); ?>
<input type="hidden" name="action" value="login" />

<div class="header">
	<?php echo ($this->iswatched === true
			? "<a href=\"".$this->href('watch')."\"><img src=\"".$this->config['theme_url']."icons/unwatch.gif\" title=\"".$this->get_translation('RemoveWatch')."\" alt=\"".$this->get_translation('RemoveWatch')."\"  align=\"absmiddle\" border=\"0\" /></a>"
			: "<a href=\"".$this->href('watch')."\"><img src=\"".$this->config['theme_url']."icons/watch.gif\" title=\"".$this->get_translation('SetWatch')."\" alt=\"".$this->get_translation('SetWatch')."\"  align=\"absmiddle\" border=\"0\" /></a>" ) ?> |
  	<?php echo "<a href=\"".$this->href('print')."\" target=\"_blank\"><img src=\"".$this->config['theme_url']."icons/print.gif\" title=\"".$this->get_translation('PrintVersion')."\" alt=\"".$this->get_translation('PrintVersion')."\"  align=\"absmiddle\" border=\"0\" /></a>";?> |
    <?php
		if ($this->get_user()) { ?>
            <span class="nobr">
				<?php echo $this->get_translation('YouAre'); ?>
				<img src="<?php echo $this->config['theme_url'] ?>icons/user.gif" width="12" height="12" border="0" style="vertical-align: baseline; " alt=""/>
				<?php echo $this->link($this->get_user_name()) ?>
			</span>
            <small>
				(
				<span class="nobr Tune">
					<?php echo $this->compose_link_to_page($this->get_translation('AccountLink'), "", $this->get_translation('AccountText'), 0); ?> |
					<a onclick="return confirm('<?php echo $this->get_translation('LogoutAreYouSure');?>');" href="<?php echo $this->href('', $this->get_translation('LoginPage')).($this->config['rewrite_mode'] ? "?" : "&amp;");?>action=logout&amp;goback=<?php echo $this->slim_url($this->tag);?>">
						<?php echo $this->get_translation('LogoutLink'); ?>
					</a>
				</span>
				)
			</small>

    <?php } else { ?>
            <span class="nobr">
				<input type="hidden" name="goback" value="<?php echo $this->slim_url($this->tag);?>" />
				<strong><?php echo $this->get_translation('LoginWelcome') ?>:&nbsp;</strong>
				<input type="text" name="name" size="18" class="login" />&nbsp;<?php echo $this->get_translation('LoginPassword') ?>:&nbsp;<input type="password" name="password" class="login" size="8" />&nbsp;<input type="submit" value="Ok" />
			</span>
    <?php } ?>

</div>
<?php echo $this->form_close(); ?>
<?php
// here we show messages
if ($message = $this->get_message()) echo "<div class=\"info\">$message</div>";
?>