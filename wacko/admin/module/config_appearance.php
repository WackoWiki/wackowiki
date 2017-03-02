<?php

if (!defined('IN_WACKO'))
{
	exit;
}

########################################################
##   Appearance settings                              ##
########################################################
$_mode = 'config_appearance';

$module[$_mode] = [
		'order'	=> 202,
		'cat'	=> 'preferences',
		'status'=> (RECOVERY_MODE ? false : true),
		'mode'	=> $_mode,
		'name'	=> $engine->_t($_mode)['name'],		// Appearance
		'title'	=> $engine->_t($_mode)['title'],	// Appearance settings
	];

########################################################

function admin_config_appearance(&$engine, &$module)
{
?>
	<h1><?php echo $module['title']; ?></h1>
	<br />
	<p>
		<?php echo $engine->_t('AppearanceSettingsInfo');?>
	</p>
	<br />
<?php
	$remove_file = function ($file, $update_config = true) use ($engine)
	{
		if (!in_array($file, ['favicon', 'logo']))
		{
			return;
		}

		// $engine->{'db->site_' . $file} no way! - more Spaghetti
		$yeah['favicon']	= $engine->db->site_favicon;
		$yeah['logo']		= $engine->db->site_logo;

		$file_name = Ut::join_path(IMAGE_DIR, $yeah[$file]);

		if (unlink($file_name))
		{
			clearstatcache();
			$engine->set_message($engine->_t('FileRemovedFromFS'), 'success');
			# $engine->set_message($engine->_t('LogoRemoved'), 'success');

			$config['site_' . $file]		= '';

			if ($file == 'logo')
			{
				$config['logo_display']		= 0;
				$config['logo_height']		= '';
				$config['logo_width']		= '';
			}

			$engine->config->_set($config);
		}
		else
		{
			clearstatcache();
			$permissions = substr(sprintf('%o', fileperms($file_name)), -4);
			$engine->set_message('File permissions <code>' . $file_name . '</code> ' . $permissions, 'error');

			$engine->set_message($engine->_t('FileRemovedFromFSError'), 'error');
		}
	};

	$upload_file = function ($file, $update_config = true) use ($engine, $remove_file)
	{
		if (!in_array($file, ['favicon', 'logo']))
		{
			return;
		}

		// 1. check out $data
		$_data	= explode('.', $_FILES[$file]['name']);
		$ext	= $_data[count($_data) - 1];
		unset($_data[count($_data) - 1]);

		// 3. extensions
		$ext				= strtolower($ext);
		$image['favicon']	= ['gif', 'jpeg', 'jpe', 'jpg', 'png', 'svg'];
		$image['logo']		= ['gif', 'jpeg', 'jpe', 'jpg', 'png'];

		if (in_array($ext, $image[$file]))
		{
			if (is_writable(IMAGE_DIR . '/'))
			{
				if ($_FILES[$file]['size'] > (1024 * 1024 * 2))
				{
					$error = $engine->_t('UploadMaxSizeReached');
				}

				// remove old image from FS, extension of new file may differ
				$yeah['favicon']	= $engine->db->site_favicon;
				$yeah['logo']		= $engine->db->site_logo;

				if ($yeah[$file])
				{
					$remove_file($file);
				}

				$result_name	= $file . '.' . $ext;

				if ($file == 'logo')
				{
					$size			= [0, 0];
					$size			= @getimagesize($_FILES[$file]['tmp_name']);

					$config['logo_height']			= (int) $size[1];
					$config['logo_width']			= (int) $size[0];
				}

				move_uploaded_file($_FILES[$file]['tmp_name'], Ut::join_path(IMAGE_DIR, $result_name));
				chmod(Ut::join_path(IMAGE_DIR, $result_name), 0644);

				$config['site_' . $file]		= $result_name;

				$engine->config->_set($config);

				$engine->set_message($engine->_t('UploadDone'), 'success');
			}
		}
		else
		{
			$engine->set_message($engine->_t('UploadNotAPicture'), 'error');
		}
	};

	// remove logo
	if (isset($_POST['remove_logo']))
	{
		$remove_file('logo');

		$engine->http->redirect(rawurldecode($engine->href()));
	}

	// remove favicon
	if (isset($_POST['remove_favicon']))
	{
		$remove_file('favicon');

		$engine->http->redirect(rawurldecode($engine->href()));
	}

	// update settings
	if (isset($_POST['action']) && $_POST['action'] == 'update')
	{
		if (isset($_FILES['logo']['tmp_name']) && is_uploaded_file($_FILES['logo']['tmp_name']))
		{
			$upload_file('logo', '');
		}
		else
		{
			$config['logo_height']			= (int) $_POST['logo_height'];'';
			$config['logo_width']			= (int) $_POST['logo_width'];'';
		}

		if (isset($_FILES['favicon']['tmp_name']) && is_uploaded_file($_FILES['favicon']['tmp_name']))
		{
			$upload_file('favicon', '');
		}

		#$engine->debug_print_r($_POST);
		$config['logo_display']				= (int) $_POST['logo_display'];
		$config['theme']					= (string) $_POST['theme'];
		$config['allow_themes']				= (string) $_POST['allow_themes'];
		$config['allow_themes_per_page']	= (string) $_POST['themes_per_page'];

		$engine->config->_set($config);

		$engine->log(1, 'Updated appearance settings');
		$engine->set_message('Updated appearance settings', 'success');
		$engine->http->redirect(rawurldecode($engine->href()));
	}

	echo $engine->form_open('basic', ['form_more' => ' enctype="multipart/form-data" ']);

	?>
		<input type="hidden" name="action" value="update" />
		<table class="formation">
			<tr>
				<th colspan="2">
					<br />
					Logo
				</th>
			</tr>
			<tr class="hl_setting">
				<td class="label"  style="vertical-align:top;"><label for="logo"><strong>Site Logo:</strong><br />
					<small>Your logo will appear at the top left corner of the application. Max size is 2 MiB. Optimal dimensions are 255 pixels wide by 55 pixels high.</small></label>
				</td>
				<td style="width:40%;">
				<?php if (file_exists(Ut::join_path(IMAGE_DIR, $engine->db->site_logo)) && $engine->db->site_logo)
				{?>
					<img src="<?php echo Ut::join_path(IMAGE_DIR, $engine->db->site_logo); ?>" alt="" height="<?php echo $engine->db->logo_height; ?>" width="<?php echo $engine->db->logo_width; ?>"><br />
					<input type="submit" id="remove_logo" name="remove_logo" value="<?php echo $engine->_t('Remove'); ?>">
				<?php }
					// SVG format is intentionally excluded ?>
					<input type="file" name="logo" id="logo_upload" accept=".gif, .jpg, .png, image/gif, image/jpeg, image/png" />
				</td>
			</tr>
			<?php
			if ($engine->db->site_logo)
			{
			?>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl_setting">
				<td class="label">
					<label for="logo_width"><strong>Logo dimensions:</strong><br />
					<small>Width and height of the displayed Logo.</small></label>
				</td>
				<td>
				<?php	// TODO: add option to reset dimentions to default image size
						// + option to 'readonly / disable' input fields
				?>
					<input type="number" min="16" max="500" maxlength="3" style="width:50px;" id="logo_width" name="logo_width" value="<?php echo (int) $engine->db->logo_width;?>" />&nbsp;×&nbsp;<input type="number" min="16" max="500" maxlength="3" style="width:50px;" id="logo_height" name="logo_height" value="<?php echo (int) $engine->db->logo_height;?>" /> pix
				</td>
			</tr>
			<?php } ?>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl_setting">
				<td class="label"><label for="logo_display"><strong>Logo display mode:</strong><br />
					<small>Defines the apearence of the Logo. Default is off.</small></label></td>
				<td>
					<select id="logo_display" name="logo_display" style="width: 200px;">
						<option value="0" <?php echo ($engine->db->logo_display  == 0  ? ' selected="selected"' : ''); ?>><?php echo $engine->_t('LogoOff');?></option>
						<option value="1" <?php echo ($engine->db->logo_display  == 1  ? ' selected="selected"' : ''); ?>><?php echo $engine->_t('LogoOnly');?></option>
						<option value="2" <?php echo ($engine->db->logo_display  == 2  ? ' selected="selected"' : ''); ?>><?php echo $engine->_t('LogoAndTitle');?></option>
					</select>
				</td>
			</tr>
			<tr>
				<th colspan="2">
					<br />
					Favicon
				</th>
			</tr>
			<tr class="hl_setting">
				<td class="label"  style="vertical-align:top;"><label for="logo"><strong>Site Favicon:</strong><br />
					<small>Your shortcut icon, or favicon, is displayed in the address bar, tabs and bookmarks of most browsers.</small></label>
				</td>
				<td>
				<?php if (file_exists(Ut::join_path(IMAGE_DIR, $engine->db->site_favicon)) && $engine->db->site_favicon)
				{?>
					<img src="<?php echo Ut::join_path(IMAGE_DIR, $engine->db->site_favicon); ?>" alt="Site Favicon"><br />
					<input type="submit" id="remove_favicon" name="remove_favicon" value="<?php echo $engine->_t('Remove'); ?>">
				<?php }?>
					<input type="file" name="favicon" id="favicon_upload" accept=".gif, .ico, .jpg, .png, .svg, image/gif, image/x-icon, image/jpeg, image/png, image/svg+xml" />
				</td>
			</tr>
			<tr>
				<th colspan="2">
					<br />
					Layout
				</th>
			</tr>
			<tr class="hl_setting">
				<td class="label"><label for="theme"><strong>Theme:</strong><br />
					<small>Template design the site uses by default.</small></label></td>
				<td>
					<select style="width:200px;" id="theme" name="theme">
					<?php
						$themes = $engine->available_themes();

						foreach ($themes as $theme)
						{
							echo '<option value="' . $theme . '" '.($engine->db->theme == $theme ? 'selected="selected"' : '') . '>' . $theme . '</option>';
						}
					?>
					</select>
				</td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl_setting">
				<td class="label"><label for="allow_themes"><strong>Allowed Themes:</strong><br />
					<small>Allowed themes, which the user can choose: <code>0</code> - all available themes are allowed (default), <br /><code>default,coffee</code> - here only these both themes are allowed.</small></label></td>
				<td><input type="text" maxlength="25" style="width:200px;" id="allow_themes" name="allow_themes" value="<?php echo htmlspecialchars($engine->db->allow_themes, ENT_COMPAT | ENT_HTML401, HTML_ENTITIES_CHARSET);?>" /></td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl_setting">
				<td class="label"><strong>Themes per page:</strong><br />
					<small>Allow themes per page, which the page owner can choose via page properties.</small></td>
				<td>
					<input type="radio" id="themes_per_page_on" name="themes_per_page" value="1"<?php echo ($engine->db->allow_themes_per_page == 1 ? ' checked="checked"' : '');?> /><label for="themes_per_page_on"><?php echo $engine->_t('On');?></label>
					<input type="radio" id="themes_per_page_off" name="themes_per_page" value="0"<?php echo ($engine->db->allow_themes_per_page == 0 ? ' checked="checked"' : '');?> /><label for="themes_per_page_off"><?php echo $engine->_t('Off');?></label>
				</td>
			</tr>
		</table>
		<br />
		<div class="center">
			<input type="submit" id="submit" value="<?php echo $engine->_t('FormSave');?>" />
			<input type="reset" id="button" value="<?php echo $engine->_t('FormReset');?>" />
		</div>
<?php
	echo $engine->form_close();
}

?>
