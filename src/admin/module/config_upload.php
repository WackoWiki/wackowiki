<?php

if (!defined('IN_WACKO'))
{
	exit;
}

##########################################################
##	Upload settings										##
##########################################################

$module['config_upload'] = [
		'order'	=> 206,
		'cat'	=> 'preferences',
		'status'=> !RECOVERY_MODE,
	];

##########################################################

function admin_config_upload($engine, $module)
{
?>
	<h1><?php echo $engine->_t($module)['title']; ?></h1>
		<br>
	<p>
		<?php echo $engine->_t('UploadSettingsInfo');?>
	</p>
	<br>
<?php
	$action = $_POST['_action'] ?? null;
	$binary_factor = ['0' => 1, '1' => 1024, '2' => (1024 * 1024), '3' => (1024 * 1024 * 1024)];

	// update settings
	if ($action == 'upload')
	{
		$config['upload']					= (string) $_POST['upload'];
		$config['upload_images_only']		= (int) ($_POST['upload_images_only'] ?? 0);
		$config['upload_max_size']			= (int) ($_POST['upload_max_size'] * $binary_factor[$_POST['upload_max_size_factor']]);
		$config['upload_quota']				= (int) ($_POST['upload_quota'] * $binary_factor[$_POST['upload_quota_factor']]);
		$config['upload_quota_per_user']	= (int) $_POST['upload_quota_per_user'] * $binary_factor[$_POST['upload_quota_per_user_factor']];
		$config['check_mimetype']			= (int) $_POST['check_mimetype'];
		$config['upload_translit']			= (int) $_POST['upload_translit'];
		$config['img_create_thumbnail']		= (int) $_POST['img_create_thumbnail'];
		$config['img_max_thumb_width']		= (int) $_POST['img_max_thumb_width'];

		$engine->config->_set($config);

		$engine->log(1, $engine->_t('UploadSettingsUpdated', SYSTEM_LANG));
		$engine->set_message($engine->_t('UploadSettingsUpdated'), 'success');
		$engine->http->redirect($engine->href());
	}

	echo $engine->form_open('upload');
?>
		<table class="setting formation">
			<colgroup>
				<col span="1">
				<col span="1">
			</colgroup>
			<tr>
				<th colspan="2">
					<br>
					<?php echo $engine->_t('FileUploadsSection');?>
				</th>
			</tr>
			<tr class="hl-setting">
				<td class="label">
					<label for="upload"><strong><?php echo $engine->_t('RightToUpload');?></strong><br>
					<small><?php echo $engine->_t('RightToUploadInfo');?></small></label>
				</td>
				<td>
					<select id="upload" name="upload">
						<option value="admins"<?php echo ((string) $engine->db->upload === 'admins' ? ' selected' : '');?>>Admins</option>
						<option value="1"<?php echo ((string) $engine->db->upload === '1' ? ' selected' : '');?>>registered users</option>
						<option value="0"<?php echo ((string) $engine->db->upload === '0' ? ' selected' : '');?>>disabled</option>
					</select>
				</td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl-setting">
				<td class="label">
					<label for="upload_images_only"><strong><?php echo $engine->_t('UploadOnlyImages');?></strong><br>
					<small><?php echo $engine->_t('UploadOnlyImagesInfo');?></small></label>
				</td>
				<td>
					<input type="checkbox" id="upload_images_only" name="upload_images_only" value="1"<?php echo ($engine->db->upload_images_only ? ' checked' : '');?>>
				</td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl-setting">
				<td class="label">
					<label for="upload_max_size"><strong><?php echo $engine->_t('UploadMaxFilesize');?></strong><br>
					<small><?php echo $engine->_t('UploadMaxFilesizeInfo');?></small></label>
				</td>
				<td>
					<input type="number" min="0" maxlength="15" size="8" id="upload_max_size" name="upload_max_size" value="<?php echo (int) $engine->binary_multiples((int) $engine->db->upload_max_size, false, true, true, false);?>">
					<?php $x = $engine->binary_multiples_factor($engine->db->upload_max_size, false); ?>
					<select name="upload_max_size_factor" id="upload_max_size_factor">
						<option value="0" <?php echo ($x == 0 ? ' selected' : '');?> ><?php echo $engine->_t('BinaryPrefixShort')[0];?></option>
						<option value="1" <?php echo ($x == 1 ? ' selected' : '');?> ><?php echo $engine->_t('BinaryPrefixShort')[1];?></option>
						<option value="2" <?php echo ($x == 2 ? ' selected' : '');?> ><?php echo $engine->_t('BinaryPrefixShort')[2];?></option>
					</select>
				</td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl-setting">
				<td class="label">
					<label for="upload_quota"><strong><?php echo $engine->_t('UploadQuota');?></strong><br>
					<small><?php echo $engine->_t('UploadQuotaInfo');?><strong> <?php echo $engine->binary_multiples($engine->upload_quota(), false, true, true);?></strong> used.</small></label>
				</td>
				<td>
					<input type="number" min="0" maxlength="15" size="8" id="upload_quota" name="upload_quota" value="<?php echo (int) $engine->binary_multiples((int) $engine->db->upload_quota, false, true, true, false);?>">
					<?php $x = $engine->binary_multiples_factor($engine->db->upload_quota, false); ?>
					<select name="upload_quota_factor" id="upload_quota_factor">
						<option value="0" <?php echo ($x == 0 ? ' selected' : '');?> ><?php echo $engine->_t('BinaryPrefixShort')[0];?></option>
						<option value="1" <?php echo ($x == 1 ? ' selected' : '');?> ><?php echo $engine->_t('BinaryPrefixShort')[1];?></option>
						<option value="2" <?php echo ($x == 2 ? ' selected' : '');?> ><?php echo $engine->_t('BinaryPrefixShort')[2];?></option>
						<option value="3" <?php echo ($x == 3 ? ' selected' : '');?> ><?php echo $engine->_t('BinaryPrefixShort')[3];?></option>
					</select>
				</td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl-setting">
				<td class="label">
					<label for="upload_quota_per_user"><strong><?php echo $engine->_t('UploadQuotaUser');?></strong><br>
					<small><?php echo $engine->_t('UploadQuotaUserInfo');?></small></label>
				</td>
				<td>
					<input type="number" min="0" maxlength="15" size="8" id="upload_quota_per_user" name="upload_quota_per_user" value="<?php echo (int) $engine->binary_multiples((int) $engine->db->upload_quota_per_user, false, true, true, false);?>">
					<?php $x = $engine->binary_multiples_factor($engine->db->upload_quota_per_user, false); ?>
					<select name="upload_quota_per_user_factor" id="upload_quota_per_user_factor">
						<option value="0" <?php echo ($x == 0 ? ' selected' : '');?> ><?php echo $engine->_t('BinaryPrefixShort')[0];?></option>
						<option value="1" <?php echo ($x == 1 ? ' selected' : '');?> ><?php echo $engine->_t('BinaryPrefixShort')[1];?></option>
						<option value="2" <?php echo ($x == 2 ? ' selected' : '');?> ><?php echo $engine->_t('BinaryPrefixShort')[2];?></option>
						<option value="3" <?php echo ($x == 3 ? ' selected' : '');?> ><?php echo $engine->_t('BinaryPrefixShort')[3];?></option>
					</select>
				</td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl-setting">
				<td class="label">
					<strong><?php echo $engine->_t('CheckMimetype');?></strong><br>
					<small><?php echo $engine->_t('CheckMimetypeInfo');?></small>
				</td>
				<td>
					<input type="radio" id="check_mimetype_on" name="check_mimetype" value="1"<?php echo ($engine->db->check_mimetype == 1 ? ' checked' : '');?>>
					<label for="check_mimetype_on"><?php echo $engine->_t('On');?></label>
					<input type="radio" id="check_mimetype_off" name="check_mimetype" value="0"<?php echo ($engine->db->check_mimetype == 0 ? ' checked' : '');?>>
					<label for="check_mimetype_off"><?php echo $engine->_t('Off');?></label>
				</td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl-setting">
				<td class="label">
					<strong><?php echo $engine->_t('TranslitFileName');?></strong><br>
					<small><?php echo $engine->_t('TranslitFileNameInfo');?></small>
				</td>
				<td>
					<input type="radio" id="upload_translit_on" name="upload_translit" value="1"<?php echo ($engine->db->upload_translit == 1 ? ' checked' : '');?>>
					<label for="upload_translit_on"><?php echo $engine->_t('On');?></label>
					<input type="radio" id="upload_translit_off" name="upload_translit" value="0"<?php echo ($engine->db->upload_translit == 0 ? ' checked' : '');?>>
					<label for="upload_translit_off"><?php echo $engine->_t('Off');?></label>
				</td>
			</tr>
			<tr>
				<th colspan="2">
					<br>
					<?php echo $engine->_t('Thumbnails');?>
				</th>
			</tr>
			<tr class="hl-setting">
				<td class="label">
					<strong><?php echo $engine->_t('CreateThumbnail');?></strong><br>
					<small><?php echo $engine->_t('CreateThumbnailInfo');?></small>
				</td>
				<td>
					<input type="radio" id="img_create_thumbnail_on" name="img_create_thumbnail" value="1"<?php echo ($engine->db->img_create_thumbnail == 1 ? ' checked' : '');?>><label for="img_create_thumbnail_on"><?php echo $engine->_t('On');?></label>
					<input type="radio" id="img_create_thumbnail_off" name="img_create_thumbnail" value="0"<?php echo ($engine->db->img_create_thumbnail == 0 ? ' checked' : '');?>><label for="img_create_thumbnail_off"><?php echo $engine->_t('Off');?></label>
				</td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl-setting">
				<td class="label">
					<label for="img_max_thumb_width"><strong><?php echo $engine->_t('MaxThumbWidth');?></strong><br>
					<small><?php echo $engine->_t('MaxThumbWidthInfo');?></small></label>
				</td>
				<td>
					<input type="number" min="0" maxlength="15" size="7" id="img_max_thumb_width" name="img_max_thumb_width" value="<?php echo (int) $engine->db->img_max_thumb_width;?>">px
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

