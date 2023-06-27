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
	$prefix		= $engine->prefix;

	$user_groups = $engine->db->load_all(
		'SELECT group_name
		FROM ' . $prefix . 'usergroup
		ORDER BY BINARY group_name');

	foreach ($user_groups as $group)
	{
		$lower = mb_strtolower($group['group_name']);

		$_groups[] = $lower;
		$groups[]  = [
			'name'	=> $group['group_name'],
			'value'	=>  $lower
		];
	}
?>
	<h1><?php echo $engine->_t($module)['title']; ?></h1>
		<br>
	<p>
		<?php echo $engine->_t('UploadSettingsInfo');?>
	</p>
	<br>
<?php
	$action			= $_POST['_action'] ?? null;
	$binary_factor	= [
		'0' => 1,
		'1' => 1024,
		'2' => (1024 * 1024),
		'3' => (1024 * 1024 * 1024)
	];

	// update settings
	if ($action == 'upload')
	{
		$upload = $_POST['upload'] ?? 0;

		// validate upload parameter (0 | 1 | group_name)
		if (!in_array($upload, [0, 1]))
		{
			$upload		= $engine->sanitize_username($upload);

			if (!in_array($upload, $_groups))
			{
				$upload = 0;
			}
		}

		$p_allowed_exts	= trim($_POST['upload_allowed_exts'] ?? '');

		// validate upload_allowed_exts parameter, e.g (png, ogg, mp4)
		$sanitize_exts = function($extensions) use ($engine)
		{
			if (!$extensions)
			{
				return '';
			}

			$banned_exts	= $engine->get_filetype_list($engine->db->upload_banned_exts);
			$allowed_exts	= $engine->get_filetype_list($extensions);
			$allowed		= [];

			foreach ($allowed_exts as $ext)
			{
				// file type is not in forbidden and part of MIME map
				if (!in_array($ext, $banned_exts) && $engine->validate_extension($ext))
				{
					$allowed[] = $ext;
				}
			}

			if ($allowed)
			{
				sort($allowed);

				return implode(', ', array_unique($allowed));
			}
			else
			{
				return '';
			}
		};

		$allowed_exts = $sanitize_exts($p_allowed_exts);


		$config['upload']					= (string) $upload;
		$config['upload_max_size']			= (int) ($_POST['upload_max_size'] * $binary_factor[$_POST['upload_max_size_factor']]);
		$config['upload_quota']				= (int) ($_POST['upload_quota'] * $binary_factor[$_POST['upload_quota_factor']]);
		$config['upload_quota_per_user']	= (int) $_POST['upload_quota_per_user'] * $binary_factor[$_POST['upload_quota_per_user_factor']];
		$config['upload_translit']			= (int) $_POST['upload_translit'];
		$config['upload_images_only']		= (int) ($_POST['upload_images_only'] ?? 0);
		$config['upload_allowed_exts']		= (string) $allowed_exts;
		$config['check_mimetype']			= (int) $_POST['check_mimetype'];
		$config['svg_sanitizer']			= (int) $_POST['svg_sanitizer'];
		$config['create_thumbnail']			= (int) $_POST['create_thumbnail'];
		$config['jpeg_quality']				= (int) $_POST['jpeg_quality'];
		$config['max_image_area']			= (int) $_POST['max_image_area'];
		$config['max_thumb_width']			= (int) $_POST['max_thumb_width'];
		$config['max_image_width']			= (int) $_POST['max_image_width'];

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
						<?php
						echo '<option value="0"' . ((string) $engine->db->upload === '0' ? ' selected' : '') . '>' . $engine->_t('Disabled') . '</option>';

						foreach ($groups as $group)
						{
							echo '<option value="' . $group['value'] . '"' . ((string) $engine->db->upload === $group['value'] ? ' selected' : '') . '>' . $group['name'] . '</option>';
						}

						echo '<option value="1"' . ((string) $engine->db->upload === '1' ? ' selected' : '') . '>' . $engine->_t('RegisteredUsers') . '</option>';
						?>
					</select>
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
						<option value="0" <?php echo ($x == 0 ? ' selected' : '');?> ><?php echo $engine->_t('ByteBinaryShort')[0];?></option>
						<option value="1" <?php echo ($x == 1 ? ' selected' : '');?> ><?php echo $engine->_t('ByteBinaryShort')[1];?></option>
						<option value="2" <?php echo ($x == 2 ? ' selected' : '');?> ><?php echo $engine->_t('ByteBinaryShort')[2];?></option>
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
						<option value="0" <?php echo ($x == 0 ? ' selected' : '');?> ><?php echo $engine->_t('ByteBinaryShort')[0];?></option>
						<option value="1" <?php echo ($x == 1 ? ' selected' : '');?> ><?php echo $engine->_t('ByteBinaryShort')[1];?></option>
						<option value="2" <?php echo ($x == 2 ? ' selected' : '');?> ><?php echo $engine->_t('ByteBinaryShort')[2];?></option>
						<option value="3" <?php echo ($x == 3 ? ' selected' : '');?> ><?php echo $engine->_t('ByteBinaryShort')[3];?></option>
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
						<option value="0" <?php echo ($x == 0 ? ' selected' : '');?> ><?php echo $engine->_t('ByteBinaryShort')[0];?></option>
						<option value="1" <?php echo ($x == 1 ? ' selected' : '');?> ><?php echo $engine->_t('ByteBinaryShort')[1];?></option>
						<option value="2" <?php echo ($x == 2 ? ' selected' : '');?> ><?php echo $engine->_t('ByteBinaryShort')[2];?></option>
						<option value="3" <?php echo ($x == 3 ? ' selected' : '');?> ><?php echo $engine->_t('ByteBinaryShort')[3];?></option>
					</select>
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
					<?php echo $engine->_t('FileTypes');?>
				</th>
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
					<label for="upload_allowed_exts"><strong><?php echo $engine->_t('AllowedUploadExts');?></strong><br>
					<small><?php echo $engine->_t('AllowedUploadExtsInfo');?></small></label>
				</td>
				<td>
					<textarea type="text" id="upload_allowed_exts" name="upload_allowed_exts"><?php echo Ut::html($engine->db->upload_allowed_exts);?></textarea>
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
					<strong><?php echo $engine->_t('SvgSanitizer');?></strong><br>
					<small><?php echo $engine->_t('SvgSanitizerInfo');?></small>
				</td>
				<td>
					<input type="radio" id="svg_sanitizer_on" name="svg_sanitizer" value="1"<?php echo ($engine->db->svg_sanitizer == 1 ? ' checked' : '');?>>
					<label for="svg_sanitizer_on"><?php echo $engine->_t('On');?></label>
					<input type="radio" id="svg_sanitizer_off" name="svg_sanitizer" value="0"<?php echo ($engine->db->svg_sanitizer == 0 ? ' checked' : '');?>>
					<label for="svg_sanitizer_off"><?php echo $engine->_t('Off');?></label>
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
					<input type="radio" id="create_thumbnail_on" name="create_thumbnail" value="1"<?php echo ($engine->db->create_thumbnail == 1 ? ' checked' : '');?>><label for="create_thumbnail_on"><?php echo $engine->_t('On');?></label>
					<input type="radio" id="create_thumbnail_off" name="create_thumbnail" value="0"<?php echo ($engine->db->create_thumbnail == 0 ? ' checked' : '');?>><label for="create_thumbnail_off"><?php echo $engine->_t('Off');?></label>
				</td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl-setting">
				<td class="label">
					<label for="jpeg_quality"><strong><?php echo $engine->_t('JpegQuality');?></strong><br>
					<small><?php echo $engine->_t('JpegQualityInfo');?></small></label>
				</td>
				<td>
					<input type="number" min="1" max="100" maxlength="3" size="3" id="jpeg_quality" name="jpeg_quality" value="<?php echo (int) $engine->db->jpeg_quality;?>">
				</td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl-setting">
				<td class="label">
					<label for="max_image_area"><strong><?php echo $engine->_t('MaxImageArea');?></strong><br>
					<small><?php echo $engine->_t('MaxImageAreaInfo');?></small></label>
				</td>
				<td>
					<input type="number" min="-1" max="100000000000" maxlength="10" size="10" id="max_image_area" name="max_image_area" value="<?php echo (int) $engine->db->max_image_area;?>"> <?php echo $engine->_t('UnitPixel'); ?>
				</td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl-setting">
				<td class="label">
					<label for="max_thumb_width"><strong><?php echo $engine->_t('MaxThumbWidth');?></strong><br>
					<small><?php echo $engine->_t('MaxThumbWidthInfo');?></small></label>
				</td>
				<td>
					<select id="max_thumb_width" name="max_thumb_width">
					<?php
					$thumb_width = [120, 150, 180, 200, 250, 300];

					foreach ($thumb_width as $width)
					{
						$selected = ($engine->db->max_thumb_width == $width ? ' selected' : '');
						echo '<option value="' . $width . '"' . $selected . '>' . $width . '</option>';
					}
					?>
					</select> <?php echo $engine->_t('UnitPixel'); ?>
				</td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl-setting">
				<td class="label">
					<label for="max_image_width"><strong><?php echo $engine->_t('MaxImageWidth');?></strong><br>
					<small><?php echo $engine->_t('MaxImageWidthInfo');?></small></label>
				</td>
				<td>
					<select id="max_image_width" name="max_image_width">
					<?php
					$max_width = [0, 320, 640, 800, 1024, 1280, 2560];

					foreach ($max_width as $width)
					{
						$selected = ($engine->db->max_image_width == $width ? ' selected' : '');
						echo '<option value="' . $width . '"' . $selected . '>' . ($width ?: $engine->_t('Off')) . '</option>';
					}
					?>
					</select> <?php echo $engine->_t('UnitPixel'); ?>
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
