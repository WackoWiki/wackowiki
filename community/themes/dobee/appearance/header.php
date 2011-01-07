<?php
header( "Content-Type: text/html; charset=".$this->get_charset() );
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"
	xml:lang="<?php echo $this->page['lang'] ?>"
	lang="<?php echo $this->page['lang'] ?>">

<head>
<title><?php echo htmlspecialchars($this->config['wacko_name'])." : ".(isset($this->page['title']) ? $this->page['title'] : $this->add_spaces($this->tag)).($this->method != 'show' ? ' ('.$this->method.')' : ''); ?>
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
<script type="text/javascript"
	src="<?php echo $this->config['base_url'];?>js/swfobject.js"></script>
<script type="text/javascript"
	src="<?php echo $this->config['base_url'];?>js/captcha.js"></script>
<script type="text/javascript"
	src="<?php echo $this->config['theme_url'] ?>js/leftframe.js"></script>
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

<body
	onload="all_init();">

<table class="topbody" align="center" border="0" cellpadding="0"
	cellspacing="0" width="100%">
	<tr>
		<td><?php echo $this->config['wacko_name'] ?>: <?php echo $this->get_page_path(); ?>
		<a class="Search"
			title="<?php echo $this->get_translation('SearchTitleTip')?>"
			href="<?php echo $this->config['base_url'].$this->get_translation('TextSearchPage').($this->config['rewrite_mode'] ? "?" : "&amp;");?>phrase=<?php echo urlencode($this->tag); ?>">...</a>
		</td>
		<td class="searchArea" align="right" valign="bottom"><?php echo $this->form_open('', $this->get_translation('TextSearchPage'), 'get'); ?>
		<input name="phrase" type="text"
			style="border: none; border-bottom: 1px solid #FFFFFF; padding: 0px; margin: 0px; background-color: #FFFFFF;"
			size="21" /> <?php echo $this->form_close(); ?></td>
	</tr>
</table>

<table align="center" border="0" cellpadding="0" cellspacing="0"
	width="100%">
	<tr>
		<td valign="top" class="left" width="185" style="white-space: nowrap;">
		<table width="185" border="0" align="left" cellpadding="0"
			cellspacing="0">
			<tr align="left">
				<td>
				<table class="navOpened" id="sw_n0" align="left" cellpadding="0"
					cellspacing="0" width="100%">
					<tr>
						<th onclick="opentree('sw_n0')" valign="top">
						<table class="navTitle" onmouseover="mover(this)"
							onmouseout="mout(this)" border="0" cellpadding="0"
							cellspacing="0" width="100%">
							<tr>
								<td class="titleLeft"><img
									src="<?php echo $this->config['theme_url'] ?>images/1x1.gif"
									width="14" /></td>
								<td class="titleText" width="100%"><?php echo $this->get_translation('YourBookmarks'); ?>
								</td>
							</tr>
						</table>
						</th>
					</tr>
					<tr>
						<td class="modulecontent">
						<div class="modulecontent"><?php
						echo $this->compose_link_to_page($this->config['root_page']);
						echo "<hr color=\"#CCCCCC\" noshade=\"noshade\" size=\"1\" />";
						echo $this->format(implode( "\n", $this->get_bookmarks()));
						echo "<hr color=\"#CCCCCC\" noshade=\"noshade\" size=\"1\" />";

						if ($this->get_user()) {
							if (!in_array($this->tag, $this->get_bookmark_links())) {?>
						<a href="<?php echo $this->href('', '', "addbookmark=yes")?>"
							title="<?php echo $this->get_translation('AddToBookmarks'); ?>">
						<img
							src="<?php echo $this->config['theme_url'] ?>icons/bookmark1.gif"
							border="0" align="bottom" style="vertical-align: middle;" /> <?php echo $this->get_translation('Bookmarks'); ?>
						</a> <?php } else { ?> <a
							href="<?php echo $this->href('', '', "removebookmark=yes")?>"
							title="<?php echo $this->get_translation('RemoveFromBookmarks'); ?>">
						<img
							src="<?php echo $this->config['theme_url'] ?>icons/bookmark2.gif"
							style="vertical-align: middle;" /> <?php echo $this->get_translation('Bookmarks'); ?>
						</a> <?php }
						}
						?></div>
						</td>
					</tr>
				</table>
				</td>
			</tr>
			<tr align="left">
				<td>
				<table class="navOpened" id="sw_n1" align="center" cellpadding="0"
					cellspacing="0" width="100%">
					<tr>
						<th onclick="opentree('sw_n1')" valign="top">
						<table class="navTitle" onmouseover="mover(this)"
							onmouseout="mout(this)" border="0" cellpadding="0"
							cellspacing="0" width="100%">
							<tr>
								<td class="titleLeft"><img
									src="<?php echo $this->config['theme_url'] ?>images/1x1.gif"
									width="14" /></td>
								<td class="titleText" width="100%"><?php echo $this->get_translation('ThisPage'); ?>
								</td>
							</tr>
						</table>
						</th>
					</tr>
					<tr>
						<td class="modulecontent">
						<div class="modulecontent"><?php
						echo $this->page['modified'] ? "<a href=\"".$this->href('revisions')."\" title=\"".$this->get_translation('RevisionTip')."\">".$this->get_page_time_formatted()."</a>\n" : "";
						echo "<hr color=\"#CCCCCC\" noshade=\"noshade\" size=\"1\" />";

						if ($this->has_access('write')) {
							echo "<a href=\"".$this->href('edit')."\" accesskey=\"E\" title=\"".$this->get_translation('EditTip')."\"><img src=\"".$this->config['theme_url']."icons/edit.gif\""."style=\"vertical-align: middle\""."\">".$this->get_translation('EditText')."</a>\n";

						}
						echo '<br />';
						if ($this->page['modified']) {
							echo "<a href=\"".$this->href('revisions')."\" title=\"".$this->get_translation('RevisionTip')."\"><img src=\"".$this->config['theme_url']."icons/vers.gif\""."style=\"vertical-align: middle\""."\">".$this->get_translation('SettingsRevisions')."</a>\n";
						}
						// if this page exists
						if ($this->page) {
							// if owner is current user
							if ($this->user_is_owner()) {
								echo '<br />';
								print(" <a href=\"".$this->href('rename')."\"><img src=\"".$this->config['theme_url']."icons/ren.gif\""."style=\"vertical-align: middle\""."\">".$this->get_translation('RenameText')."</a>");
								echo '<br />';
								print("<a href=\"".$this->href('permissions')."\"".(($this->method=='edit')?" onclick=\"return window.confirm('".$this->get_translation('EditACLConfirm')."');\"":"")."\"><img src=\"".$this->config['theme_url']."icons/access.gif\""."style=\"vertical-align: middle\"".">".$this->get_translation('ACLText')."</a>");
							}

							if ($this->check_acl($this->get_user_name(),$this->config['rename_globalacl']) && !$this->user_is_owner()) {
								echo '<br />';
								print(" <a href=\"".$this->href('rename')."\">".$this->get_translation('RenameText')."</a>");
							}

							if ($this->is_admin()) {
								echo '<br />';
								print(" <a href=\"".$this->href('remove')."\"><img src=\"".$this->config['theme_url']."icons/delete.gif\""."style=\"vertical-align: middle\""."\">".$this->get_translation('DeleteText')."</a>");
							}

							echo '<br />';
							print("<a href=\"".$this->href('properties'). "\"".(($this->method=='edit')?" onclick=\"return window.confirm('".$this->get_translation('EditACLConfirm')."');\"":"")."\"><img src=\"".$this->config['theme_url']."icons/prop.gif\""."style=\"vertical-align: middle\"".">".$this->get_translation('SettingsText')."</a>");

							echo '<br />';
							print "<a href=\"".$this->href('export.xml')."\" title=\"".$this->get_translation('RevisionXMLTip')."\"><img src=\"".$this->config['theme_url']."icons/1xml.gif\""."style=\"vertical-align: middle\""."\" target=\"_blank\">".$this->get_translation('ExportToXML')."</a>\n";

							//print $this->format( '{{TOC}}' );

							if ($this->user_is_owner()) {
								echo "<hr color=\"#CCCCCC\" noshade=\"noshade\" size=\"1\" />";
								print($this->get_translation('YouAreOwner'));
							} else {
								echo "<hr color=\"#CCCCCC\" noshade=\"noshade\" size=\"1\" />";
								if ($owner = $this->get_page_owner()) {
									print($this->get_translation('Owner').": ".$this->link($owner));
								} else if (!$this->page['comment_on_id']) {
									print($this->get_translation('Nobody').($this->get_user() ? " (<a href=\"".$this->href('claim')."\">".$this->get_translation('TakeOwnership')."</a>)" : ""));
								}
							}
						}
						?></div>
						</td>
					</tr>
				</table>
				</td>
			</tr>
		</table>
		</td>
		<td><!-- wrapper --> <?php echo $this->form_open('', $this->get_translation('LoginPage'), 'post'); ?>
		<input type="hidden" name="action" value="login" />

		<div class="header"><?php echo ($this->iswatched === true
		? "<a href=\"".$this->href('watch')."\"><img src=\"".$this->config['theme_url']."icons/unwatch.gif\" title=\"".$this->get_translation('RemoveWatch')."\" alt=\"".$this->get_translation('RemoveWatch')."\"  align=\"absmiddle\" border=\"0\" /></a>"
		: "<a href=\"".$this->href('watch')."\"><img src=\"".$this->config['theme_url']."icons/watch.gif\" title=\"".$this->get_translation('SetWatch')."\" alt=\"".$this->get_translation('SetWatch')."\"  align=\"absmiddle\" border=\"0\" /></a>" ) ?>
		| <?php echo "<a href=\"".$this->href('print')."\" target=\"_blank\"><img src=\"".$this->config['theme_url']."icons/print.gif\" title=\"".$this->get_translation('PrintVersion')."\" alt=\"".$this->get_translation('PrintVersion')."\"  align=\"absmiddle\" border=\"0\" /></a>";?>
		| <?php
		if ($this->get_user()) { ?> <span class="nobr"> <?php echo $this->get_translation('YouAre'); ?>
		<img
			src="<?php echo $this->config['theme_url'] ?>icons/user.gif"
			alt="" width="16" height="16" border="0" align="middle"
			style="vertical-align: baseline;" /> <?php echo $this->link($this->get_user_name()) ?>
		</span> <small> ( <span class="nobr Tune"> <?php echo $this->compose_link_to_page($this->get_translation('AccountLink'), "", $this->get_translation('AccountText'), 0); ?>
		| <a
			onclick="return confirm('<?php echo $this->get_translation('LogoutAreYouSure');?>');"
			href="<?php echo $this->href('', $this->get_translation('LoginPage')).($this->config['rewrite_mode'] ? "?" : "&amp;");?>action=logout&amp;goback=<?php echo $this->slim_url($this->tag);?>">
			<?php echo $this->get_translation('LogoutLink'); ?> </a> </span> ) </small>

			<?php } else { ?> <span class="nobr"> <input type="hidden"
			name="goback" value="<?php echo $this->slim_url($this->tag);?>" /> <strong><?php echo $this->get_translation('LoginWelcome') ?>:&nbsp;</strong>
		<input type="text" name="name" size="18" class="login" />&nbsp;<?php echo $this->get_translation('LoginPassword') ?>:&nbsp;<input
			type="password" name="password" class="login" size="8" />&nbsp;<input
			type="submit" value="Ok" /> </span> <?php } ?></div>

			<?php echo $this->form_close(); ?>
<?php
// here we show messages
if ($message = $this->get_message()) echo "<div class=\"info\">$message</div>";
?>