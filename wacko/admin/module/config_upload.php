<?php

if (!defined('IN_WACKO'))
{
	exit;
}

########################################################
##   Upload settings                                  ##
########################################################

$module['config_upload'] = array(
		'order'	=> 250,
		'cat'	=> 'Preferences',
		'status'=> (RECOVERY_MODE ? false : true),
		'mode'	=> 'config_upload',
		'name'	=> 'Upload',
		'title'	=> 'Attachment settings',
	);

########################################################

function admin_config_upload(&$engine, &$module)
{
?>
	<h1><?php echo $module['title']; ?></h1>
		<br />
	<p>
		Here you can configure the main settings for attachments and the associated special categories.
	</p>
	<br />
<?php

	$binary_factor = array('0' => 1, '1' => 1024, '2' => (1024 * 1024));
	#echo $_POST['upload_quota_factor'].' - '.$binary_factor[$_POST['upload_quota_factor']];
	#$engine->debug_print_r($_POST);

	// update settings
	if (isset($_POST['action']) && $_POST['action'] == 'update')
	{
		// check form token
		if (!$engine->validate_form_token('upload'))
		{
			$message = $engine->get_translation('FormInvalid');
			$engine->set_message($message, 'error');
		}
		else
		{
			$config['upload']					= (string)$_POST['upload'];
			$config['upload_images_only']		= (int)$_POST['upload_images_only'];
			$config['upload_max_size']			= (int)$_POST['upload_max_size'] * $binary_factor[$_POST['upload_max_size_factor']];
			$config['upload_quota']				= (int)$_POST['upload_quota'] * $binary_factor[$_POST['upload_quota_factor']];
			$config['upload_quota_per_user']	= (int)$_POST['upload_quota_per_user'] * $binary_factor[$_POST['upload_quota_per_user_factor']];
			$config['img_create_thumbnail']		= (int)$_POST['img_create_thumbnail'];
			$config['img_max_thumb_width']		= (int)$_POST['img_max_thumb_width'];

			$engine->_set_config($config, '', true);

			$engine->log(1, 'Updated upload settings');
			$engine->set_message('Updated upload settings');
			$engine->redirect(rawurldecode($engine->href()));
		}
	}

	echo $engine->form_open('upload', '', 'post', true, '', '');
?>
		<input type="hidden" name="action" value="update" />
		<table class="formation">
			<tr>
				<th colspan="2">
					<br />
					File uploads
				</th>
			</tr>
			<tr class="hl_setting">
				<td class="label"><label for="upload"><strong>Right to the upload files:</strong><br />
					<small><code>'admins'</code> means that only users belongig to admins group can upload the files. <code>'1'</code> means that uploading is opened to everybody. <code>'0'</code> means that upload disabled</small></label></td>
				<td style="width:40%;"><input type="text" maxlength="7" style="width:200px;" id="upload" name="upload" value="<?php echo htmlspecialchars($engine->config['upload'], ENT_COMPAT | ENT_HTML401, HTML_ENTITIES_CHARSET);?>" /></td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl_setting">
				<td class="label"><label for="upload_images_only"><strong>Allow only upload of images:</strong><br />
					<small>Allow only uploading of image files on the page.</small></label></td>
				<td><input type="checkbox" id="upload_images_only" name="upload_images_only" value="1"<?php echo ( $engine->config['upload_images_only'] ? ' checked="checked"' : '' );?> /></td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl_setting">
				<td class="label"><label for="upload_max_size"><strong>Maximum file size:</strong><br />
					<small>Maximum size of each file.</small></label></td>
				<td><input type="number" min="0" maxlength="15" size="8" id="upload_max_size" name="upload_max_size" value="<?php echo (int) $engine->binary_multiples($engine->config['upload_max_size'], false, true, true, false);?>" />
					<?php $x = $engine->binary_multiples_factor($engine->config['upload_max_size'], false); ?>
					<select name="upload_max_size_factor">
						<option value="0" <?php echo ( $x == 0 ? ' selected="selected"' : '' );?> >Bytes</option>
						<option value="1" <?php echo ( $x == 1 ? ' selected="selected"' : '' );?> >KiB</option>
						<option value="2" <?php echo ( $x == 2 ? ' selected="selected"' : '' );?> >MiB</option>
					</select>
				</td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl_setting">
				<td class="label"><label for="upload_quota"><strong>Total upload quota:</strong><br />
					<small>Maximum drive space available for attachments for the whole engine, with 0 being unlimited. <strong><?php echo $engine->binary_multiples($engine->upload_quota(), false, true, true);?></strong> used.</small></label></td>
				<td><input type="number" min="0" maxlength="15" size="8" id="upload_quota" name="upload_quota" value="<?php echo (int) $engine->binary_multiples($engine->config['upload_quota'], false, true, true, false);?>" />
				<?php $x = $engine->binary_multiples_factor($engine->config['upload_quota'], false); ?>
				<select name="upload_quota_factor">
						<option value="0" <?php echo ( $x == 0 ? ' selected="selected"' : '' );?> >Bytes</option>
						<option value="1" <?php echo ( $x == 1 ? ' selected="selected"' : '' );?> >KiB</option>
						<option value="2" <?php echo ( $x == 2 ? ' selected="selected"' : '' );?> >MiB</option>
						<option value="3" <?php echo ( $x == 3 ? ' selected="selected"' : '' );?> >GiB</option>
					</select>
				</td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl_setting">
				<td class="label"><label for="upload_quota_per_user"><strong>Restricting quota of storage per user:</strong><br />
					<small>Restriction on the quota of storage that can be uploaded by one user. Zero indicates the absence of restrictions.</small></label></td>
				<td><input type="number" min="0" maxlength="15" size="8" id="upload_quota_per_user" name="upload_quota_per_user" value="<?php echo (int) $engine->binary_multiples($engine->config['upload_quota_per_user'], false, true, true, false);?>" />
					<?php $x = $engine->binary_multiples_factor($engine->config['upload_quota_per_user'], false); ?>
					<select name="upload_quota_per_user_factor">
						<option value="0" <?php echo ( $x == 0 ? ' selected="selected"' : '' );?> >Bytes</option>
						<option value="1" <?php echo ( $x == 1 ? ' selected="selected"' : '' );?> >KiB</option>
						<option value="2" <?php echo ( $x == 2 ? ' selected="selected"' : '' );?> >MiB</option>
						<option value="3" <?php echo ( $x == 3 ? ' selected="selected"' : '' );?> >GiB</option>
					</select>
				</td>
			</tr>
			<tr>
				<th colspan="2">
					<br />
					Thumbnail settings
				</th>
			</tr>
			<tr class="hl_setting">
				<td class="label"><strong>Create thumbnail:</strong><br />
					<small>Create a thumbnail in all possible situations.</small></td>
				<td>
					<input type="radio" id="img_create_thumbnail_on" name="img_create_thumbnail" value="1"<?php echo ( $engine->config['img_create_thumbnail'] == 1 ? ' checked="checked"' : '' );?> /><label for="img_create_thumbnail_on">On.</label>
					<input type="radio" id="img_create_thumbnail_off" name="img_create_thumbnail" value="0"<?php echo ( $engine->config['img_create_thumbnail'] == 0 ? ' checked="checked"' : '' );?> /><label for="img_create_thumbnail_off">Off.</label>
				</td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl_setting">
				<td class="label"><strong>Maximum thumbnail width in pixel:</strong><br />
					<small>A generated thumbnail will not exceed the width set here.</small></td>
				<td><input type="number" min="0" maxlength="15" size="7" id="img_max_thumb_width" name="img_max_thumb_width" value="<?php echo (int)$engine->config['img_max_thumb_width'];?>" />px</td>
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