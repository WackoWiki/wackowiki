<?php

if (!defined('IN_WACKO'))
{
	exit;
}

##########################################################
##	Permissions settings								##
##########################################################

$module['config_permissions'] = [
		'order'	=> 220,
		'cat'	=> 'preferences',
		'status'=> !RECOVERY_MODE,
	];

##########################################################

function admin_config_permissions(&$engine, $module)
{
?>
	<h1><?php echo $engine->_t($module)['title']; ?></h1>
	<br>
	<p>
		<?php echo $engine->_t('PermissionsSettingsInfo');?>
	</p>
	<br>
	<?php
	$action = $_POST['_action'] ?? null;

	// update settings
	if ($action == 'permissions')
	{
		$read_acl		= $engine->sanitize_acl_syntax($_POST['default_read_acl']);
		$write_acl		= $engine->sanitize_acl_syntax($_POST['default_write_acl']);
		$comment_acl	= $engine->sanitize_acl_syntax($_POST['default_comment_acl']);
		$create_acl		= $engine->sanitize_acl_syntax($_POST['default_create_acl']);
		$upload_acl		= $engine->sanitize_acl_syntax($_POST['default_upload_acl']);
		$rename_acl		= $engine->sanitize_acl_syntax($_POST['rename_global_acl']);

		if ($engine->validate_acl_syntax($read_acl, 'read'))
		{
			$config['default_read_acl']			= (string) $read_acl;
		}

		if ($engine->validate_acl_syntax($write_acl, 'write'))
		{
			$config['default_write_acl']		= (string) $write_acl;
		}

		if ($engine->validate_acl_syntax($comment_acl, 'comment'))
		{
			$config['default_comment_acl']		= (string) $comment_acl;
		}

		if ($engine->validate_acl_syntax($create_acl, 'create'))
		{
			$config['default_create_acl']		= (string) $create_acl;
		}

		if ($engine->validate_acl_syntax($upload_acl, 'upload'))
		{
			$config['default_upload_acl']		= (string) $upload_acl;
		}

		if ($engine->validate_acl_syntax($upload_acl, 'rename_global'))
		{
			$config['rename_global_acl']		= (string) $rename_acl;
		}

		$config['acl_lock']						= (int) ($_POST['acl_lock'] ?? 0);
		$config['hide_locked']					= (int) ($_POST['hide_locked'] ?? 0);
		$config['remove_onlyadmins']			= (int) ($_POST['remove_onlyadmins'] ?? 0);
		$config['owners_can_remove_comments']	= (int) ($_POST['owners_can_remove_comments'] ?? 0);
		$config['categories_handler']			= (int) ($_POST['categories_handler'] ?? 0);
		$config['moders_can_edit']				= (int) $_POST['moders_can_edit'];

		$engine->config->_set($config);

		$engine->log(1, '!!' . $engine->_t('PermissionsSettingsUpdated', SYSTEM_LANG) . '!!');
		$engine->set_message($engine->_t('PermissionsSettingsUpdated'), 'success');
		$engine->http->redirect($engine->href());
	}

	echo $engine->form_open('permissions');
?>
		<table class="setting formation">
			<colgroup>
				<col span="1">
				<col span="1">
			</colgroup>
			<tr>
				<th colspan="2">
					<br>
					<?php echo $engine->_t('PermissionsSection');?>
				</th>
			</tr>
			<tr class="hl-setting">
				<td class="label">
					<label for="default_read_acl"><strong><?php echo $engine->_t('ReadRights');?></strong><br>
					<small><?php echo $engine->_t('ReadRightsInfo');?></small></label>
				</td>
				<td>
					<textarea class="permissions" id="default_read_acl" name="default_read_acl"><?php echo Ut::html($engine->db->default_read_acl);?></textarea>
				</td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl-setting">
				<td class="label">
					<label for="default_write_acl"><strong><?php echo $engine->_t('WriteRights');?></strong><br>
					<small><?php echo $engine->_t('WriteRightsInfo');?></small></label>
				</td>
				<td>
					<textarea class="permissions" id="default_write_acl" name="default_write_acl"><?php echo Ut::html($engine->db->default_write_acl);?></textarea>
				</td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl-setting">
				<td class="label">
					<label for="default_comment_acl"><strong><?php echo $engine->_t('CommentRights');?></strong><br>
					<small><?php echo $engine->_t('CommentRightsInfo');?></small></label>
				</td>
				<td>
					<textarea class="permissions" id="default_comment_acl" name="default_comment_acl"><?php echo Ut::html($engine->db->default_comment_acl);?></textarea>
				</td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl-setting">
				<td class="label">
					<label for="default_create_acl"><strong><?php echo $engine->_t('CreateRights');?></strong><br>
					<small><?php echo $engine->_t('CreateRightsInfo');?></small></label>
				</td>
				<td>
					<textarea class="permissions" id="default_create_acl" name="default_create_acl"><?php echo Ut::html($engine->db->default_create_acl);?></textarea>
				</td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl-setting">
				<td class="label">
					<label for="default_upload_acl"><strong><?php echo $engine->_t('UploadRights');?></strong><br>
					<small><?php echo $engine->_t('UploadRightsInfo');?></small></label>
				</td>
				<td>
					<textarea class="permissions" id="default_upload_acl" name="default_upload_acl"><?php echo Ut::html($engine->db->default_upload_acl);?></textarea>
				</td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl-setting">
				<td class="label">
					<label for="rename_global_acl"><strong><?php echo $engine->_t('RenameRights');?></strong><br>
					<small><?php echo $engine->_t('RenameRightsInfo');?></small></label>
				</td>
				<td>
					<textarea class="permissions" id="rename_global_acl" name="rename_global_acl"><?php echo Ut::html($engine->db->rename_global_acl);?></textarea>
				</td>
			</tr>
			<tr class="hl-setting">
				<th colspan="2">
					<br>
					<?php echo $engine->_t('MiscellaneousSection');?>
				</th>
			</tr>
			<tr class="hl-setting">
				<td class="label">
					<label for="acl_lock"><strong><?php echo $engine->_t('LockAcl');?></strong><br>
					<small><span class="cite"><?php echo $engine->_t('LockAclInfo');?></small></label>
				</td>
				<td>
					<input type="checkbox" id="acl_lock" name="acl_lock" value="1"<?php echo ($engine->db->acl_lock ? ' checked' : '');?>>
				</td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl-setting">
				<td class="label">
					<label for="hide_locked"><strong><?php echo $engine->_t('HideLocked');?></strong><br>
					<small><?php echo $engine->_t('HideLockedInfo');?></small></label>
				</td>
				<td>
					<input type="checkbox" id="hide_locked" name="hide_locked" value="1"<?php echo ($engine->db->hide_locked ? ' checked' : '');?>>
				</td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl-setting">
				<td class="label">
					<label for="remove_onlyadmins"><strong><?php echo $engine->_t('RemoveOnlyAdmins');?></strong><br>
					<small><?php echo $engine->_t('RemoveOnlyAdminsInfo');?></small></label>
				</td>
				<td>
					<input type="checkbox" id="remove_onlyadmins" name="remove_onlyadmins" value="1"<?php echo ($engine->db->remove_onlyadmins ? ' checked' : '');?>>
				</td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl-setting">
				<td class="label">
					<label for="owners_can_remove_comments"><strong><?php echo $engine->_t('OwnersRemoveComments');?></strong><br>
					<small><?php echo $engine->_t('OwnersRemoveCommentsInfo');?></small></label>
				</td>
				<td>
					<input type="checkbox" id="owners_can_remove_comments" name="owners_can_remove_comments" value="1"<?php echo ($engine->db->owners_can_remove_comments ? ' checked' : '');?>>
				</td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl-setting">
				<td class="label">
					<label for="categories_handler"><strong><?php echo $engine->_t('OwnersEditCategories');?></strong><br>
					<small><?php echo $engine->_t('OwnersEditCategoriesInfo');?></small></label>
				</td>
				<td>
					<input type="radio" id="categories_handler_admin" name="categories_handler" value="0" <?php echo ($engine->db->categories_handler == 0 ? ' checked' : '');?>><label for="categories_handler_admin"><?php echo $engine->_t('Admin');?></label>
					<input type="radio" id="categories_handler_owner" name="categories_handler" value="1" <?php echo ($engine->db->categories_handler == 1 ? ' checked' : '');?>><label for="categories_handler_owner"><?php echo $engine->_t('Owner');?></label>
					<input type="radio" id="categories_handler_user" name="categories_handler" value="2" <?php echo ($engine->db->categories_handler == 2 ? ' checked' : '');?>><label for="categories_handler_user"><?php echo $engine->_t('Registered');?></label>
				</td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl-setting">
				<td class="label">
					<label for="moders_can_edit"><strong><?php echo $engine->_t('TermHumanModeration');?></strong><br>
					<small><?php echo $engine->_t('TermHumanModerationInfo');?></small></label>
				</td>
				<td>
					<input type="number" min="0" maxlength="4" id="moders_can_edit" name="moders_can_edit" value="<?php echo (int) $engine->db->moders_can_edit;?>">
				</td>
			</tr>
		</table>
		<br>
		<div class="center">
			<button type="submit" id="submit"><?php echo $engine->_t('SaveButton');?></button>
			<button type="reset" id="button"><?php echo $engine->_t('ResetButton');?></button>
		</div>
<?php
	echo $engine->form_close();
}

