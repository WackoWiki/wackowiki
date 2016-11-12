<?php

require (Ut::join_path(THEME_DIR, '_common/_header.php'));

?>
<script src="<?php echo $this->db->theme_url ?>js/leftframe.js"></script>

<body
	onload="all_init();">

<table class="topbody" style="text-align:center; width:100%;">
	<tr>
		<td><?php echo $this->db->site_name ?>: <?php echo $this->get_page_path(); ?>
		</td>
		<td class="searchArea" style="text-align:right; vertical-align:bottom;"><?php echo $this->form_open('search', '', 'get', $this->_t('TextSearchPage')); ?>
		<input type="search" name="phrase"
			style="border: none; border-bottom: 1px solid #FFFFFF; padding: 0px; margin: 0px; background-color: #FFFFFF;"
			size="21" /> <?php echo $this->form_close(); ?></td>
	</tr>
</table>

<table style="text-align:center; width:100%;">
	<tr>
		<td class="left" style="vertical-align:top; white-space: nowrap; width:185;">
		<table style="text-align:left; width:185;">
			<tr style="text-align:left;">
				<td>
				<table class="navOpened" id="sw_n0" style="text-align:left; width:100%;">
					<tr>
						<th onclick="opentree('sw_n0')" style="vertical-align:top;">
						<table class="navTitle" onmouseover="mover(this)"
							onmouseout="mout(this)"
							 style="width:100%">
							<tr>
								<td class="titleLeft"><img
									src="<?php echo $this->db->theme_url ?>images/1x1.png" width="14" /></td>
								<td class="titleText" style="width:100%"><?php echo $this->_t('YourBookmarks'); ?>
								</td>
							</tr>
						</table>
						</th>
					</tr>
					<tr>
						<td class="modulecontent">
						<div class="modulecontent"><?php
						// outputs bookmarks menu
						echo '<div id="menu-user">';
						echo "<ol>\n";
						// main page
						echo "<li>" . $this->compose_link_to_page($this->db->root_page) . "</li>\n";

						// menu
						if ($menu = $this->get_menu())
						{
							foreach ($menu as $menu_item)
							{
								$formatted_menu = $this->format($menu_item[2], 'post_wacko');

								if ($this->page['page_id'] == $menu_item[0])
								{
									echo '<li class="active">';
								}
								else
								{
									echo '<li>';
								}

								echo $formatted_menu . "</li>\n";
							}
						}

						if ($this->get_user())
						{
							// determines what it should show: "add to bookmarks" or "remove from bookmarks" icon
							if (!in_array($this->page['page_id'], $this->get_menu_links()))
							{
								echo '<li><a href="' .  $this->href('', '', 'addbookmark=yes')
									 . '"><img src="' .  $this->db->theme_url
									.'icon/bookmark1.png" alt="+" title="' . 
									$this->_t('AddToBookmarks')  . '"/></a></li>';
							}
							else
							{
								echo '<li><a href="' .  $this->href('', '', 'removebookmark=yes')
									 . '"><img src="' .  $this->db->theme_url
									.'icon/bookmark2.png" alt="-" title="' . 
									$this->_t('RemoveFromBookmarks')  . '"/></a></li>';
							}
						}
						echo "\n</ol></div>";
						?></div>
						</td>
					</tr>
				</table>
				</td>
			</tr>
			<tr style="text-align:left;">
				<td>
				<table class="navOpened" id="sw_n1" style="text-align:center; width:100%;">
					<tr>
						<th onclick="opentree('sw_n1')" style="vertical-align:top;">
						<table class="navTitle" onmouseover="mover(this)"
							onmouseout="mout(this)"
							 style="width:100%">
							<tr>
								<td class="titleLeft"><img
									src="<?php echo $this->db->theme_url ?>images/1x1.png"
									width="14" /></td>
								<td class="titleText" style="width:100%"><?php echo $this->_t('ThisPage'); ?>
								</td>
							</tr>
						</table>
						</th>
					</tr>
					<tr>
						<td class="modulecontent">
						<div class="modulecontent"><?php
							// Revisions link
								echo (( $this->db->hide_revisions == false || ($this->db->hide_revisions == 1 && $this->get_user()) || ($this->db->hide_revisions == 2 && $this->is_owner()) || $this->is_admin() )
									? "<a href=\"" . $this->href('revisions') . "\" title=\"" . $this->_t('RevisionTip') . "\">" . $this->get_time_formatted($this->page['modified']) . "</a>\n"
									: "" . $this->get_time_formatted($this->page['modified']) . "\n"
								);

						echo "<hr color=\"#CCCCCC\" noshade=\"noshade\" size=\"1\" />";

						if ($this->has_access('write')) {
							echo "<a href=\"" . $this->href('edit') . "\" accesskey=\"E\" title=\"" . $this->_t('EditTip') . "\"><img src=\"" . $this->db->theme_url."icon/edit.png\""."style=\"vertical-align: middle\""."\">" . $this->_t('EditText') . "</a>\n";

						}
						echo '<br />';
						if ($this->page['modified']) {
							echo "<a href=\"" . $this->href('revisions') . "\" title=\"" . $this->_t('RevisionTip') . "\"><img src=\"" . $this->db->theme_url."icon/vers.png\""."style=\"vertical-align: middle\""."\">" . $this->_t('SettingsRevisions') . "</a>\n";
						}
						// if this page exists
						if ($this->page) {
							// if owner is current user
							if ($this->is_owner()) {
								echo '<br />';
								print(" <a href=\"" . $this->href('rename') . "\"><img src=\"" . $this->db->theme_url."icon/ren.png\""."style=\"vertical-align: middle\""."\">" . $this->_t('RenameText') . "</a>");
								echo '<br />';
								print("<a href=\"" . $this->href('permissions') . "\"" . (($this->method=='edit')?" onclick=\"return window.confirm('" . $this->_t('EditACLConfirm') . "');\"":"") . "\"><img src=\"" . $this->db->theme_url."icon/access.png\""."style=\"vertical-align: middle\"".">" . $this->_t('ACLText') . "</a>");
							}

							if ($this->check_acl($this->get_user_name(),$this->db->rename_globalacl) && !$this->is_owner()) {
								echo '<br />';
								print(" <a href=\"" . $this->href('rename') . "\">" . $this->_t('RenameText') . "</a>");
							}

							if ($this->is_admin()) {
								echo '<br />';
								print(" <a href=\"" . $this->href('remove') . "\"><img src=\"" . $this->db->theme_url."icon/delete.png\""."style=\"vertical-align: middle\""."\">" . $this->_t('DeleteText') . "</a>");
							}

							echo '<br />';
							print("<a href=\"" . $this->href('properties'). "\"" . (($this->method=='edit')?" onclick=\"return window.confirm('" . $this->_t('EditACLConfirm') . "');\"":"") . "\"><img src=\"" . $this->db->theme_url."icon/prop.png\""."style=\"vertical-align: middle\"".">" . $this->_t('SettingsText') . "</a>");

							echo '<br />';
							print "<a href=\"" . $this->href('export.xml') . "\" title=\"" . $this->_t('RevisionXMLTip') . "\"><img src=\"" . $this->db->theme_url."icon/1xml.png\""."style=\"vertical-align: middle\""."\">" . $this->_t('ExportToXML') . "</a>\n";

							//print $this->format( '{{TOC}}' );

							if ($this->is_owner()) {
								echo "<hr color=\"#CCCCCC\" noshade=\"noshade\" size=\"1\" />";
								print($this->_t('YouAreOwner'));
							} else {
								echo "<hr color=\"#CCCCCC\" noshade=\"noshade\" size=\"1\" />";
								if ($owner = $this->get_page_owner()) {
									print($this->_t('Owner') . ": " . $this->user_link($owner, $lang = '', true, false));
								} else if (!$this->page['comment_on_id']) {
									print($this->_t('Nobody').($this->get_user() ? " (<a href=\"" . $this->href('claim') . "\">" . $this->_t('TakeOwnership') . "</a>)" : ""));
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
		<td><!-- wrapper --> <?php echo $this->form_open('login', '', 'post', $this->_t('LoginPage')); ?>
		<input type="hidden" name="action" value="login" />

		<div class="header"><?php echo ($this->is_watched === true
		? "<a href=\"" . $this->href('watch') . "\"><img src=\"" . $this->db->theme_url."icon/unwatch.png\" title=\"" . $this->_t('RemoveWatch') . "\" alt=\"" . $this->_t('RemoveWatch') . "\" /></a>"
		: "<a href=\"" . $this->href('watch') . "\"><img src=\"" . $this->db->theme_url."icon/watch.png\" title=\"" . $this->_t('SetWatch') . "\" alt=\"" . $this->_t('SetWatch') . "\" /></a>" ) ?>
		| <?php echo "<a href=\"" . $this->href('print') . "\"><img src=\"" . $this->db->theme_url."icon/print.png\" title=\"" . $this->_t('PrintVersion') . "\" alt=\"" . $this->_t('PrintVersion') . "\" /></a>";?>
		| <?php
		if ($this->get_user()) { ?> <span class="nobr"> <?php echo $this->_t('YouAre'); ?>
		<img
			src="<?php echo $this->db->theme_url ?>icon/user.png"
			alt="" width="16" height="16"
			style="text-align:middle; vertical-align: baseline;" /> <?php echo $this->link($this->db->users_page.'/' . $this->get_user_name(), '', $this->get_user_name()) ?>
		</span> <small> ( <span class="nobr Tune"> <?php echo $this->compose_link_to_page($this->_t('AccountLink'), "", $this->_t('AccountText'), 0); ?>
		| <a
			onclick="return confirm('<?php echo $this->_t('LogoutAreYouSure');?>');"
			href="<?php echo $this->href('', $this->_t('LoginPage'), 'action=logout&amp;goback=' . $this->slim_url($this->tag));?>">
			<?php echo $this->_t('LogoutLink'); ?> </a> </span> ) </small>

			<?php } else { ?> <span class="nobr"> <input type="hidden"
			name="goback" value="<?php echo $this->slim_url($this->tag);?>" /> <strong><?php echo $this->_t('LoginWelcome') ?>:&nbsp;</strong>
		<input type="text" name="name" size="18" class="login" />&nbsp;<?php echo $this->_t('LoginPassword') ?>:&nbsp;<input
			type="password" name="password" class="login" size="8" />&nbsp;<input
			type="submit" value="Ok" /> </span> <?php } ?></div>

			<?php echo $this->form_close(); ?>
<?php
// here we show messages
$this->output_messages();
?>
