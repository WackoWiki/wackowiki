<?php

if (!defined('IN_WACKO'))
{
	exit;
}

########################################################
##   Permissions settings                             ##
########################################################

$module['config_permissions'] = array(
		'order'	=> 220,
		'cat'	=> 'Preferences',
		'status'=> (RECOVERY_MODE ? false : true),
		'mode'	=> 'config_permissions',
		'name'	=> 'Permissions',
		'title'	=> 'Permissions settings',
	);

########################################################

function admin_config_permissions(&$engine, &$module)
{
?>
	<h1><?php echo $module['title']; ?></h1>
	<br />
	<p>
		Parameters responsible for Access control and permissions.
	</p>
	<br />
<?php
	// update settings
	if (isset($_POST['action']) && $_POST['action'] == 'update')
	{
		$config['default_read_acl']				= (string)$_POST['default_read_acl'];
		$config['default_write_acl']			= (string)$_POST['default_write_acl'];
		$config['default_comment_acl']			= (string)$_POST['default_comment_acl'];
		$config['default_create_acl']			= (string)$_POST['default_create_acl'];
		$config['default_upload_acl']			= (string)$_POST['default_upload_acl'];
		$config['rename_globalacl']				= (string)$_POST['rename_globalacl'];
		$config['acl_lock']						= (int)$_POST['acl_lock'];
		$config['hide_locked']					= (int)$_POST['hide_locked'];
		$config['remove_onlyadmins']			= (int)$_POST['remove_onlyadmins'];
		$config['owners_can_remove_comments']	= (int)$_POST['owners_can_remove_comments'];
		$config['owners_can_change_categories']	= (int)$_POST['owners_can_change_categories'];
		$config['moders_can_edit']				= (int)$_POST['moders_can_edit'];

		$engine->config->_set($config);

		$engine->log(1, '!!Updated security settings!!');
		$engine->set_message('Updated security settings', 'success');
		$engine->http->redirect(rawurldecode($engine->href()));
	}

	echo $engine->form_open('permissions');
?>
		<input type="hidden" name="action" value="update" />
		<table class="formation">
			<tr>
				<th colspan="2">
					<br />
					Rights and privileges
				</th>
			</tr>
			<tr class="hl_setting">
				<td class="label"  style="vertical-align:top;">
					<label for="default_read_acl"><strong>Read rights by default:</strong><br />
					<small>Typically used for putting the root pages, and pages for which we can not determine parental rights.</small></label>
				</td>
				<td style="width:40%;">
					<textarea style="font-size:12px; letter-spacing:normal; width:200px; height:50px;" id="default_read_acl" name="default_read_acl"><?php echo htmlspecialchars($engine->db->default_read_acl, ENT_COMPAT | ENT_HTML401, HTML_ENTITIES_CHARSET);?></textarea>
				</td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl_setting">
				<td class="label"  style="vertical-align:top;">
					<label for="default_write_acl"><strong>Write rights by default:</strong><br />
					<small>Typically used for putting the root pages, and pages for which we can not determine the parental rights.</small></label>
				</td>
				<td>
					<textarea style="font-size:12px; letter-spacing:normal; width:200px; height:50px;" id="default_write_acl" name="default_write_acl"><?php echo htmlspecialchars($engine->db->default_write_acl, ENT_COMPAT | ENT_HTML401, HTML_ENTITIES_CHARSET);?></textarea>
				</td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl_setting">
				<td class="label"  style="vertical-align:top;">
					<label for="default_comment_acl"><strong>Comment rights by default:</strong><br />
					<small>Typically used for putting the root pages, and pages for which we can not determine the parental rights.</small></label>
				</td>
				<td>
					<textarea style="font-size:12px; letter-spacing:normal; width:200px; height:50px;" id="default_comment_acl" name="default_comment_acl"><?php echo htmlspecialchars($engine->db->default_comment_acl, ENT_COMPAT | ENT_HTML401, HTML_ENTITIES_CHARSET);?></textarea>
				</td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl_setting">
				<td class="label"  style="vertical-align:top;">
					<label for="default_create_acl"><strong>Create rights of a sub page by default:</strong><br />
					<small>Define the tolerance for the establishment of root pages and assign pages for which we can not determine the parental rights.</small></label>
				</td>
				<td>
					<textarea style="font-size:12px; letter-spacing:normal; width:200px; height:50px;" id="default_create_acl" name="default_create_acl"><?php echo htmlspecialchars($engine->db->default_create_acl, ENT_COMPAT | ENT_HTML401, HTML_ENTITIES_CHARSET);?></textarea>
				</td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl_setting">
				<td class="label"  style="vertical-align:top;">
					<label for="default_upload_acl"><strong>Upload rights by default:</strong><br />
					<small>Typically used for putting the root pages, and pages for which we can not determine parental rights.</small></label>
				</td>
				<td>
					<textarea style="font-size:12px; letter-spacing:normal; width:200px; height:50px;" id="default_upload_acl" name="default_upload_acl"><?php echo htmlspecialchars($engine->db->default_upload_acl, ENT_COMPAT | ENT_HTML401, HTML_ENTITIES_CHARSET);?></textarea>
				</td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl_setting">
				<td class="label"  style="vertical-align:top;">
					<label for="rename_globalacl"><strong>Global rename right:</strong><br />
					<small>List for admission to the possibility of free rename (move) pages.</small></label>
				</td>
				<td>
					<textarea style="font-size:12px; letter-spacing:normal; width:200px; height:50px;" id="rename_globalacl" name="rename_globalacl"><?php echo htmlspecialchars($engine->db->rename_globalacl, ENT_COMPAT | ENT_HTML401, HTML_ENTITIES_CHARSET);?></textarea>
				</td>
			</tr>
			<tr class="hl_setting">
				<th colspan="2">
					<br />
					Miscellaneous
				</th>
			</tr>
			<tr class="hl_setting">
				<td class="label">
					<label for="acl_lock"><strong>Lock all ACL to read only:</strong><br />
					<small><span class="cite">Overwrites the acl settings for all pages to read only.</span></small><br />
					This might be useful if a project is finished, you want close editing for a period for security reasons or as a emergency response.</label>
				</td>
				<td>
					<input type="checkbox" id="acl_lock" name="acl_lock" value="1"<?php echo ( $engine->db->acl_lock ? ' checked="checked"' : '' );?> />
				</td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl_setting">
				<td class="label">
					<label for="hide_locked"><strong>Hide inaccessible pages:</strong><br />
					<small>If the user does not have permission to read the page, hide it in different lists of documents (placed in the link text, however, will still be visible).</small></label>
				</td>
				<td>
					<input type="checkbox" id="hide_locked" name="hide_locked" value="1"<?php echo ( $engine->db->hide_locked ? ' checked="checked"' : '' );?> />
				</td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl_setting">
				<td class="label">
					<label for="remove_onlyadmins"><strong>Only administrators can delete pages:</strong><br />
					<small>Deny all, except administrators, to delete pages. In the first limit applies to owners of normal pages.</small></label>
				</td>
				<td>
					<input type="checkbox" id="remove_onlyadmins" name="remove_onlyadmins" value="1"<?php echo ( $engine->db->remove_onlyadmins ? ' checked="checked"' : '' );?> />
				</td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl_setting">
				<td class="label">
					<label for="owners_can_remove_comments"><strong>Owners of pages can delete comments:</strong><br />
					<small>Allow page owners to moderate comments on their pages.</small></label>
				</td>
				<td>
					<input type="checkbox" id="owners_can_remove_comments" name="owners_can_remove_comments" value="1"<?php echo ( $engine->db->owners_can_remove_comments ? ' checked="checked"' : '' );?> />
				</td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl_setting">
				<td class="label">
					<label for="owners_can_change_categories"><strong>Owners can edit page categories:</strong><br />
					<small>Allow owners to modify the pages category list of your site (add words, delete words), assigns to a page.</small></label>
				</td>
				<td>
					<input type="checkbox" id="owners_can_change_categories" name="owners_can_change_categories" value="1"<?php echo ( $engine->db->owners_can_change_categories ? ' checked="checked"' : '' );?> />
				</td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl_setting">
				<td class="label">
					<label for="moders_can_edit"><strong>Term human moderation:</strong><br />
					<small>Moderators can edit comments, only if they were set up at most as many days ago (this restriction does not apply to the last comment in the topic).</small></label>
				</td>
				<td>
					<input type="number" min="0" maxlength="4" style="width:200px;" id="moders_can_edit" name="moders_can_edit" value="<?php echo htmlspecialchars($engine->db->moders_can_edit, ENT_COMPAT | ENT_HTML401, HTML_ENTITIES_CHARSET);?>" />
				</td>
			</tr>
		</table>
		<br />
		<div class="center">
			<input type="submit" id="submit" value="save" />
			<input type="reset" id="button" value="reset" />
		</div>
<?php
	echo $engine->form_close();
}

?>
