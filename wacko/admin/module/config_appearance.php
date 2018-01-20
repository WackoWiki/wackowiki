<?php

if (!defined('IN_WACKO'))
{
	exit;
}

##########################################################
##	Appearance settings									##
##########################################################
$_mode = 'config_appearance';

$module[$_mode] = [
		'order'	=> 202,
		'cat'	=> 'preferences',
		'status'=> (RECOVERY_MODE ? false : true),
		'mode'	=> $_mode,
		'name'	=> $engine->_t($_mode)['name'],		// Appearance
		'title'	=> $engine->_t($_mode)['title'],	// Appearance settings
	];

##########################################################

function admin_config_appearance(&$engine, &$module)
{
?>
	<h1><?php echo $module['title']; ?></h1>
	<br>
	<p>
		<?php echo $engine->_t('AppearanceSettingsInfo');?>
	</p>
	<br>
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
		$ext					= strtolower($ext);

		$image['favicon']		= ['gif', 'ico' , 'jpeg', 'jpe', 'jpg', 'png', 'svg'];
		$image['logo']			= ['gif', 'jpeg', 'jpe', 'jpg', 'png', 'webp'];
		// calculate resonable filesize: Pixels * Bit Depth
		// - GIF/PNG palette-based images (up to 8-bit)
		// - Non-palette images (JPEG/PNG/TIFF/SVG) are 0, 8, or 16.
		$max_size['favicon']	= 64 * 64 * 8;
		$max_size['logo']		= 1024 * 1024 * 2;

		if (in_array($ext, $image[$file]))
		{
			if (is_writable(IMAGE_DIR . '/'))
			{
				if ($_FILES[$file]['size'] > ($max_size[$file]))
				{
					$error = $engine->_t('UploadMaxSizeReached');
				}

				$size			= [0, 0];
				$size			= @getimagesize($_FILES[$file]['tmp_name']);

				if ($file == 'logo')
				{
					$config['logo_height']			= (int) $size[1];
					$config['logo_width']			= (int) $size[0];
				}
				else if ($file == 'favicon'
					&& ($size[0] > 64 || $size[1] > 64))
				{
					#$error = $engine->_t('UploadMaxSizeReached');
					$error = 'Favicon is bigger than 64 &times; 64px. <code>' . (int) $size[0] . ' &times; ' . (int) $size[1] .'px</code>';
				}

				if (!$error)
				{
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
				else
				{
					$engine->set_message($error, 'error');
				}
			}
			else
			{
				$engine->set_message(Ut::perc_replace($engine->_t('DirNotWritable'), '<code>' . IMAGE_DIR . '/' . '</code>'), 'error');
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
			$config['logo_height']			= (int) $_POST['logo_height'];
			$config['logo_width']			= (int) $_POST['logo_width'];
		}

		if (isset($_FILES['favicon']['tmp_name']) && is_uploaded_file($_FILES['favicon']['tmp_name']))
		{
			$upload_file('favicon', '');
		}

		#Ut::debug_print_r($_POST);
		$config['logo_display']				= (int) $_POST['logo_display'];
		$config['theme']					= (string) $_POST['theme'];

		if (is_array($_POST['allow_themes']))
		{
			$config['allow_themes'] = (string) implode(',', $_POST['allow_themes']);
		}
		else
		{
			$config['allow_themes'] = '0';
		}

		$config['allow_themes_per_page']	= (int) $_POST['themes_per_page'];

		$engine->config->_set($config);

		$engine->log(1, $engine->_t('AppearanceSettingsUpdated', SYSTEM_LANG));
		$engine->set_message($engine->_t('AppearanceSettingsUpdated'), 'success');
		$engine->http->redirect(rawurldecode($engine->href()));
	}

	echo $engine->form_open('basic', ['form_more' => ' enctype="multipart/form-data" ']);

	?>
		<input type="hidden" name="action" value="update">
		<table class="formation">
			<colgroup>
				<col span="1" style="width: 50%;">
				<col span="1" style="width: 50%;">
			</colgroup>
			<tr>
				<th colspan="2">
					<br>
					<?php echo $engine->_t('LogoSection');?>
				</th>
			</tr>
			<tr class="hl_setting">
				<td class="label">
					<label for="logo"><strong><?php echo $engine->_t('SiteLogo');?>:</strong><br>
					<small><?php echo $engine->_t('SiteLogoInfo');?></small></label>
				</td>
				<td>
				<?php if (file_exists(Ut::join_path(IMAGE_DIR, $engine->db->site_logo)) && $engine->db->site_logo)
				{?>
					<img src="<?php echo Ut::join_path(IMAGE_DIR, $engine->db->site_logo); ?>" alt="" height="<?php echo $engine->db->logo_height; ?>" width="<?php echo $engine->db->logo_width; ?>"><br>
					<input type="submit" id="remove_logo" name="remove_logo" value="<?php echo $engine->_t('Remove'); ?>">
				<?php }
					// SVG format is intentionally excluded ?>
					<input type="file" name="logo" id="logo_upload" accept=".gif, .jpg, .png, .webp, image/gif, image/jpeg, image/png, image/webp">
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
					<label for="logo_width"><strong><?php echo $engine->_t('LogoDimensions');?>:</strong><br>
					<small><?php echo $engine->_t('LogoDimensionsInfo');?></small></label>
				</td>
				<td>
				<?php	// TODO: add option to reset dimentions to default image size
						// + option to 'readonly / disable' input fields
				?>
					<input type="number" min="16" max="500" maxlength="3" style="width: 50px;" id="logo_width" name="logo_width" value="<?php echo (int) $engine->db->logo_width;?>">&nbsp;&times;&nbsp;<input type="number" min="16" max="500" maxlength="3" style="width:50px;" id="logo_height" name="logo_height" value="<?php echo (int) $engine->db->logo_height;?>"> pix
				</td>
			</tr>
			<?php } ?>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl_setting">
				<td class="label">
					<label for="logo_display"><strong><?php echo $engine->_t('LogoDisplayMode');?>:</strong><br>
					<small><?php echo $engine->_t('LogoDisplayModeInfo');?></small></label>
				</td>
				<td>
					<select id="logo_display" name="logo_display" style="width: 200px;">
						<option value="0" <?php echo ($engine->db->logo_display  == 0  ? ' selected' : ''); ?>><?php echo $engine->_t('LogoOff');?></option>
						<option value="1" <?php echo ($engine->db->logo_display  == 1  ? ' selected' : ''); ?>><?php echo $engine->_t('LogoOnly');?></option>
						<option value="2" <?php echo ($engine->db->logo_display  == 2  ? ' selected' : ''); ?>><?php echo $engine->_t('LogoAndTitle');?></option>
					</select>
				</td>
			</tr>
			<tr>
				<th colspan="2">
					<br>
					<?php echo $engine->_t('FaviconSection');?>
				</th>
			</tr>
			<tr class="hl_setting">
				<td class="label">
					<label for="logo"><strong><?php echo $engine->_t('SiteFavicon');?>:</strong><br>
					<small><?php echo $engine->_t('SiteFaviconInfo');?></small></label>
				</td>
				<td>
				<?php if (file_exists(Ut::join_path(IMAGE_DIR, $engine->db->site_favicon)) && $engine->db->site_favicon)
				{?>
					<img src="<?php echo Ut::join_path(IMAGE_DIR, $engine->db->site_favicon); ?>" alt="Site Favicon"><br>
					<input type="submit" id="remove_favicon" name="remove_favicon" value="<?php echo $engine->_t('Remove'); ?>">
				<?php }?>
					<input type="file" name="favicon" id="favicon_upload" accept=".gif, .ico, .jpg, .png, .svg, .webp, image/gif, image/x-icon, image/jpeg, image/png, image/svg+xml, image/webp">
				</td>
			</tr>
			<tr>
				<th colspan="2">
					<br>
					<?php echo $engine->_t('LayoutSection');?>
				</th>
			</tr>
			<tr class="hl_setting">
				<td class="label">
					<label for="theme"><strong><?php echo $engine->_t('Theme');?>:</strong><br>
					<small><?php echo $engine->_t('ThemeInfo');?></small></label>
				</td>
				<td>
					<select id="theme" name="theme">
					<?php
						$themes = $engine->available_themes();

						foreach ($themes as $theme)
						{
							echo '<option value="' . $theme . '" ' . ($engine->db->theme == $theme ? 'selected' : '') . '>' . $theme . '</option>';
						}
					?>
					</select>
				</td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl_setting">
				<td class="label">
					<label for=""><strong><?php echo $engine->_t('ThemesAllowed');?>:</strong><br>
					<small><?php echo $engine->_t('ThemesAllowedInfo');?></small></label>
				</td>
				<td>
				<?php
					if (isset($engine->db->allow_themes))
					{
						$theme_list = explode(',', $engine->db->allow_themes);
					}
					else
					{
						$theme_list= [];
					}

					$themes = $engine->available_themes();

					echo "<table>\n\t<tr>\n";

					foreach ($themes as $n => $theme)
					{
						echo	"\t\t<td>\n\t\t\t" . '<input type="checkbox" name="allow_themes[' . $n . ']" id="theme_' . $n . '" value="' . $theme . '" ' . (in_array($theme, $theme_list) ? ' checked' : ''). '>' . "\n\t\t\t" .
								'<label for="theme_' . $n . '">' . $themes[$n] . '</label>' . "\n\t\t</td>\n";

						// modulus operator: every third loop add a break
						if ($n % 3 == 0)
						{
							echo "\t</tr>\n\t<tr>\n";
						}
					}

					echo "\t</tr>\n</table>";
					?>
				</td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl_setting">
				<td class="label">
					<strong><?php echo $engine->_t('ThemesPerPage');?>:</strong><br>
					<small><?php echo $engine->_t('ThemesPerPageInfo');?></small>
				</td>
				<td>
					<input type="radio" id="themes_per_page_on" name="themes_per_page" value="1"<?php echo ($engine->db->allow_themes_per_page == 1 ? ' checked' : '');?>>
					<label for="themes_per_page_on"><?php echo $engine->_t('On');?></label>
					<input type="radio" id="themes_per_page_off" name="themes_per_page" value="0"<?php echo ($engine->db->allow_themes_per_page == 0 ? ' checked' : '');?>>
					<label for="themes_per_page_off"><?php echo $engine->_t('Off');?></label>
				</td>
			</tr>
		</table>
		<br>
		<div class="center">
			<input type="submit" id="submit" value="<?php echo $engine->_t('FormSave');?>">
			<input type="reset" id="button" value="<?php echo $engine->_t('FormReset');?>">
		</div>
<?php
	echo $engine->form_close();
}

?>
