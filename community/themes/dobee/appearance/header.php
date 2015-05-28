<?php

require ('themes/_common/_header.php');

?>
<script src="<?php echo $this->config['theme_url'] ?>js/leftframe.js"></script>

<body
	onload="all_init();">

<table class="topbody" style="text-align:center; width:100%;">
	<tr>
		<td><?php echo $this->config['site_name'] ?>: <?php echo $this->get_page_path(); ?>
		</td>
		<td class="searchArea" style="text-align:right; vertical-align:bottom;"><?php echo $this->form_open('search', '', 'get', $this->get_translation('TextSearchPage')); ?>
		<input name="phrase" type="text"
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
									src="<?php echo $this->config['theme_url'] ?>images/1x1.png" width="14" /></td>
								<td class="titleText" style="width:100%"><?php echo $this->get_translation('YourBookmarks'); ?>
								</td>
							</tr>
						</table>
						</th>
					</tr>
					<tr>
						<td class="modulecontent">
						<div class="modulecontent"><?php
						// outputs bookmarks menu
						echo '<div id="usermenu">';
						echo "<ol>\n";
						// main page
						echo "<li>".$this->compose_link_to_page($this->config['root_page'])."</li>\n";

						// menu
						if ($menu = $this->get_menu())
						{
							foreach ($menu as $menu_item)
							{
								$formatted_menu = $this->format($menu_item[1], 'post_wacko');

								if ($this->page['page_id'] == $menu_item[0])
								{
									echo '<li class="active">';
								}
								else
								{
									echo '<li>';
								}

								echo $formatted_menu."</li>\n";
							}
						}

						if ($this->get_user())
						{
							// determines what it should show: "add to bookmarks" or "remove from bookmarks" icon
							if (!in_array($this->page['page_id'], $this->get_menu_links()))
							{
								echo '<li><a href="'. $this->href('', '', 'addbookmark=yes')
									.'"><img src="'. $this->config['theme_url']
									.'icons/bookmark1.png" alt="+" title="'.
									$this->get_translation('AddToBookmarks') .'"/></a></li>';
							}
							else
							{
								echo '<li><a href="'. $this->href('', '', 'removebookmark=yes')
									.'"><img src="'. $this->config['theme_url']
									.'icons/bookmark2.png" alt="-" title="'.
									$this->get_translation('RemoveFromBookmarks') .'"/></a></li>';
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
									src="<?php echo $this->config['theme_url'] ?>images/1x1.png"
									width="14" /></td>
								<td class="titleText" style="width:100%"><?php echo $this->get_translation('ThisPage'); ?>
								</td>
							</tr>
						</table>
						</th>
					</tr>
					<tr>
						<td class="modulecontent">
						<div class="modulecontent"><?php
							// Revisions link
								echo (( $this->config['hide_revisions'] == false || ($this->config['hide_revisions'] == 1 && $this->get_user()) || ($this->config['hide_revisions'] == 2 && $this->user_is_owner()) || $this->is_admin() )
									? "<a href=\"".$this->href('revisions')."\" title=\"".$this->get_translation('RevisionTip')."\">".$this->get_time_string_formatted($this->page['modified'])."</a>\n"
									: "".$this->get_time_string_formatted($this->page['modified'])."\n"
								);

						echo "<hr color=\"#CCCCCC\" noshade=\"noshade\" size=\"1\" />";

						if ($this->has_access('write')) {
							echo "<a href=\"".$this->href('edit')."\" accesskey=\"E\" title=\"".$this->get_translation('EditTip')."\"><img src=\"".$this->config['theme_url']."icons/edit.png\""."style=\"vertical-align: middle\""."\">".$this->get_translation('EditText')."</a>\n";

						}
						echo '<br />';
						if ($this->page['modified']) {
							echo "<a href=\"".$this->href('revisions')."\" title=\"".$this->get_translation('RevisionTip')."\"><img src=\"".$this->config['theme_url']."icons/vers.png\""."style=\"vertical-align: middle\""."\">".$this->get_translation('SettingsRevisions')."</a>\n";
						}
						// if this page exists
						if ($this->page) {
							// if owner is current user
							if ($this->user_is_owner()) {
								echo '<br />';
								print(" <a href=\"".$this->href('rename')."\"><img src=\"".$this->config['theme_url']."icons/ren.png\""."style=\"vertical-align: middle\""."\">".$this->get_translation('RenameText')."</a>");
								echo '<br />';
								print("<a href=\"".$this->href('permissions')."\"".(($this->method=='edit')?" onclick=\"return window.confirm('".$this->get_translation('EditACLConfirm')."');\"":"")."\"><img src=\"".$this->config['theme_url']."icons/access.png\""."style=\"vertical-align: middle\"".">".$this->get_translation('ACLText')."</a>");
							}

							if ($this->check_acl($this->get_user_name(),$this->config['rename_globalacl']) && !$this->user_is_owner()) {
								echo '<br />';
								print(" <a href=\"".$this->href('rename')."\">".$this->get_translation('RenameText')."</a>");
							}

							if ($this->is_admin()) {
								echo '<br />';
								print(" <a href=\"".$this->href('remove')."\"><img src=\"".$this->config['theme_url']."icons/delete.png\""."style=\"vertical-align: middle\""."\">".$this->get_translation('DeleteText')."</a>");
							}

							echo '<br />';
							print("<a href=\"".$this->href('properties'). "\"".(($this->method=='edit')?" onclick=\"return window.confirm('".$this->get_translation('EditACLConfirm')."');\"":"")."\"><img src=\"".$this->config['theme_url']."icons/prop.png\""."style=\"vertical-align: middle\"".">".$this->get_translation('SettingsText')."</a>");

							echo '<br />';
							print "<a href=\"".$this->href('export.xml')."\" title=\"".$this->get_translation('RevisionXMLTip')."\"><img src=\"".$this->config['theme_url']."icons/1xml.png\""."style=\"vertical-align: middle\""."\">".$this->get_translation('ExportToXML')."</a>\n";

							//print $this->format( '{{TOC}}' );

							if ($this->user_is_owner()) {
								echo "<hr color=\"#CCCCCC\" noshade=\"noshade\" size=\"1\" />";
								print($this->get_translation('YouAreOwner'));
							} else {
								echo "<hr color=\"#CCCCCC\" noshade=\"noshade\" size=\"1\" />";
								if ($owner = $this->get_page_owner()) {
									print($this->get_translation('Owner').": "."<a href=\"".$this->href('', $this->config['users_page'], 'profile='.$owner)."\">".$owner."</a>");
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
		<td><!-- wrapper --> <?php echo $this->form_open('login', '', 'post', $this->get_translation('LoginPage')); ?>
		<input type="hidden" name="action" value="login" />

		<div class="header"><?php echo ($this->is_watched === true
		? "<a href=\"".$this->href('watch')."\"><img src=\"".$this->config['theme_url']."icons/unwatch.png\" title=\"".$this->get_translation('RemoveWatch')."\" alt=\"".$this->get_translation('RemoveWatch')."\" /></a>"
		: "<a href=\"".$this->href('watch')."\"><img src=\"".$this->config['theme_url']."icons/watch.png\" title=\"".$this->get_translation('SetWatch')."\" alt=\"".$this->get_translation('SetWatch')."\" /></a>" ) ?>
		| <?php echo "<a href=\"".$this->href('print')."\"><img src=\"".$this->config['theme_url']."icons/print.png\" title=\"".$this->get_translation('PrintVersion')."\" alt=\"".$this->get_translation('PrintVersion')."\" /></a>";?>
		| <?php
		if ($this->get_user()) { ?> <span class="nobr"> <?php echo $this->get_translation('YouAre'); ?>
		<img
			src="<?php echo $this->config['theme_url'] ?>icons/user.png"
			alt="" width="16" height="16"
			style="text-align:middle; vertical-align: baseline;" /> <?php echo $this->link($this->config['users_page'].'/'.$this->get_user_name(), '', $this->get_user_name()) ?>
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
$this->output_messages();
?>