<?php

if (!defined('IN_WACKO'))
{
	exit;
}

##########################################################
##	Security settings									##
##########################################################
$_mode = 'config_security';

$module[$_mode] = [
		'order'	=> 221,
		'cat'	=> 'preferences',
		'status'=> (RECOVERY_MODE ? false : true),
		'mode'	=> $_mode,
		'name'	=> $engine->_t($_mode)['name'],		// Security
		'title'	=> $engine->_t($_mode)['title'],	// Security subsystems settings
	];

##########################################################

function admin_config_security(&$engine, &$module)
{
?>
	<h1><?php echo $module['title']; ?></h1>
	<br>
	<p>
		<?php echo $engine->_t('SecuritySettingsInfo');?>
	</p>
	<br>
<?php
	// update settings
	if (isset($_POST['action']) && $_POST['action'] == 'update')
	{
		$config['allow_registration']			= (int) ($_POST['allow_registration'] ?? 0);
		$config['approve_new_user']				= (int) $_POST['approve_new_user'];
		$config['enable_captcha']				= (int) $_POST['enable_captcha'];
		$config['captcha_new_comment']			= (int) ($_POST['captcha_new_comment'] ?? 0);
		$config['captcha_new_page']				= (int) ($_POST['captcha_new_page'] ?? 0);
		$config['captcha_edit_page']			= (int) ($_POST['captcha_edit_page'] ?? 0);
		$config['captcha_registration']			= (int) ($_POST['captcha_registration'] ?? 0);
		$config['allow_persistent_cookie']		= (int) ($_POST['allow_persistent_cookie'] ?? 0);
		$config['disable_wikiname']				= (int) ($_POST['disable_wikiname'] ?? 0);
		$config['allow_email_reuse']			= (int) ($_POST['allow_email_reuse'] ?? 0);
		$config['tls']							= (int) ($_POST['tls'] ?? 0);
		$config['tls_implicit']					= (int) ($_POST['tls_implicit'] ?? 0);
		$config['pwd_admin_min_chars']			= (int) $_POST['pwd_admin_min_chars'];
		$config['pwd_min_chars']				= (int) $_POST['pwd_min_chars'];
		$config['pwd_char_classes']				= (int) $_POST['pwd_char_classes'];
		$config['pwd_unlike_login']				= (int) $_POST['pwd_unlike_login'];
		$config['session_length']				= (int) $_POST['session_length'];
		$config['comment_delay']				= (int) $_POST['comment_delay'];
		$config['intercom_delay']				= (int) $_POST['intercom_delay'];
		$config['enable_security_headers']		= (int) $_POST['enable_security_headers'];
		$config['csp']							= (int) $_POST['csp'];
		$config['permissions_policy']			= (int) $_POST['permissions_policy'];
		$config['referrer_policy']				= (int) $_POST['referrer_policy'];
		$config['max_login_attempts']			= (int) $_POST['max_login_attempts'];
		$config['ip_login_limit_max']			= (int) $_POST['ip_login_limit_max'];
		$config['username_chars_min']			= (int) $_POST['username_chars_min'];
		$config['username_chars_max']			= (int) $_POST['username_chars_max'];
		$config['form_token_time']				= (int) $_POST['form_token_time'];
		$config['registration_delay']			= (int) $_POST['registration_delay'];

		$engine->config->_set($config);

		$engine->log(1, '!!' . $engine->_t('SecuritySettingsUpdated', SYSTEM_LANG) . '!!');
		$engine->set_message($engine->_t('SecuritySettingsUpdated'), 'success');
		$engine->http->redirect($engine->href());
	}

	echo $engine->form_open('security');
?>
		<input type="hidden" name="action" value="update">
		<table class="formation">
			<colgroup>
				<col span="1" style="width:50%;">
				<col span="1" style="width:50%;">
			</colgroup>
			<tr>
				<th colspan="2"><?php echo $engine->_t('MainSection');?></th>
			</tr>
			<tr class="hl-setting">
				<td class="label">
					<label for="allow_registration"><strong><?php echo $engine->_t('AllowRegistration');?>:</strong><br>
					<small><?php echo $engine->_t('AllowRegistrationInfo');?></small></label>
				</td>
				<td>
					<input type="checkbox" id="allow_registration" name="allow_registration" value="1"<?php echo ($engine->db->allow_registration ? ' checked' : '');?>>
				</td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl-setting">
				<td class="label">
					<label for="approve_new_user"><strong><?php echo $engine->_t('ApproveNewUser');?>:</strong><br>
					<small><?php echo $engine->_t('ApproveNewUserInfo');?></small></label>
				</td>
				<td>
					<input type="radio" id="approve_new_user_on" name="approve_new_user" value="1"<?php echo ($engine->db->approve_new_user == 1 ? ' checked' : '');?>><label for="approve_new_user_on"><?php echo $engine->_t('On');?></label>
					<input type="radio" id="approve_new_user_off" name="approve_new_user" value="0"<?php echo ($engine->db->approve_new_user == 0 ? ' checked' : '');?>><label for="approve_new_user_off"><?php echo $engine->_t('Off');?></label>
				</td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl-setting">
				<td class="label">
					<label for="allow_persistent_cookie"><strong><?php echo $engine->_t('PersistentCookies');?>:</strong><br>
					<small><?php echo $engine->_t('PersistentCookiesInfo');?></small></label>
				</td>
				<td>
					<input type="checkbox" id="allow_persistent_cookie" name="allow_persistent_cookie" value="1"<?php echo ($engine->db->allow_persistent_cookie ? ' checked' : '');?>>
				</td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl-setting">
				<td class="label">
					<label for="disable_wikiname"><strong><?php echo $engine->_t('DisableWikiName');?>:</strong><br>
					<small><?php echo $engine->_t('DisableWikiNameInfo');?></small></label>
				</td>
				<td>
					<input type="checkbox" id="disable_wikiname" name="disable_wikiname" value="1"<?php echo ($engine->db->disable_wikiname ? ' checked' : '');?>>
				</td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl-setting">
				<td class="label">
					<label for="allow_email_reuse"><strong><?php echo $engine->_t('AllowEmailReuse');?>:</strong><br>
					<small><?php echo $engine->_t('AllowEmailReuseInfo');?></small></label>
				</td>
				<td>
					<input type="checkbox" id="allow_email_reuse" name="allow_email_reuse" value="1"<?php echo ($engine->db->allow_email_reuse ? ' checked' : '');?>>
				</td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl-setting">
				<td class="label">
					<label for="username_chars_min"><strong><?php echo $engine->_t('UsernameLength');?>:</strong><br>
					<small><?php echo $engine->_t('UsernameLengthInfo');?></small></label>
				</td>
				<td>
					<input type="number" min="0" maxlength="3" id="username_chars_min" name="username_chars_min" value="<?php echo (int) $engine->db->username_chars_min;?>"> Min  <input type="number" min="0" maxlength="3" id="username_chars_max" name="username_chars_max" value="<?php echo (int) $engine->db->username_chars_max;?>"> Max
				</td>
			</tr>
			<tr>
				<th colspan="2">
					<br>
					<?php echo $engine->_t('CaptchaSection');?>
				</th>
			</tr>
			<tr class="hl-setting">
				<td class="label">
					<label for="enable_captcha"><strong><?php echo $engine->_t('EnableCaptcha');?>:</strong><br>
					<small><?php echo $engine->_t('EnableCaptchaInfo');?></small></label>
				</td>
				<td>
					<input type="radio" id="enable_captcha_on" name="enable_captcha" value="1"<?php echo ($engine->db->enable_captcha == 1 ? ' checked' : '');?>><label for="enable_captcha_on"><?php echo $engine->_t('On');?></label>
					<input type="radio" id="enable_captcha_off" name="enable_captcha" value="0"<?php echo ($engine->db->enable_captcha == 0 ? ' checked' : '');?>><label for="enable_captcha_off"><?php echo $engine->_t('Off');?></label>
				</td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl-setting">
				<td class="label">
					<label for="captcha_new_comment"><strong><?php echo $engine->_t('CaptchaComment');?>:</strong><br>
					<small><?php echo $engine->_t('CaptchaCommentInfo');?></small></label>
				</td>
				<td>
					<input type="checkbox" id="captcha_new_comment" name="captcha_new_comment" value="1"<?php echo ($engine->db->captcha_new_comment ? ' checked' : '');?>>
				</td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl-setting">
				<td class="label">
					<label for="captcha_new_page"><strong><?php echo $engine->_t('CaptchaPage');?>:</strong><br>
					<small><?php echo $engine->_t('CaptchaPageInfo');?></small></label>
				</td>
				<td>
					<input type="checkbox" id="captcha_new_page" name="captcha_new_page" value="1"<?php echo ($engine->db->captcha_new_page ? ' checked' : '');?>>
				</td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl-setting">
				<td class="label">
					<label for="captcha_edit_page"><strong><?php echo $engine->_t('CaptchaEdit');?>:</strong><br>
					<small><?php echo $engine->_t('CaptchaEditInfo');?></small></label>
				</td>
				<td>
					<input type="checkbox" id="captcha_edit_page" name="captcha_edit_page" value="1"<?php echo ($engine->db->captcha_edit_page ? ' checked' : '');?>>
				</td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl-setting">
				<td class="label">
					<label for="captcha_registration"><strong><?php echo $engine->_t('CaptchaRegistration');?>:</strong><br>
					<small><?php echo $engine->_t('CaptchaRegistrationInfo');?></small></label>
				</td>
				<td>
					<input type="checkbox" id="captcha_registration" name="captcha_registration" value="1"<?php echo ($engine->db->captcha_registration ? ' checked' : '');?>>
				</td>
			</tr>
			<tr>
				<th colspan="2">
					<br>
					<?php echo $engine->_t('TlsSection');?>
				</th>
			</tr>
			<tr class="hl-setting">
				<td class="label">
					<label for="tls"><strong><?php echo $engine->_t('TlsConnection');?>:</strong><br>
					<small><?php echo $engine->_t('TlsConnectionInfo');?></small></label>
				</td>
				<td>
					<input type="checkbox" id="tls" name="tls" value="1"<?php echo ($engine->db->tls ? ' checked' : '');?>>
				</td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl-setting">
				<td class="label">
					<label for="tls_implicit"><strong><?php echo $engine->_t('TlsImplicit');?>:</strong><br>
					<small><?php echo $engine->_t('TlsImplicitInfo');?></small></label>
				</td>
				<td>
					<input type="checkbox" id="tls_implicit" name="tls_implicit" value="1"<?php echo ($engine->db->tls_implicit ? ' checked' : '');?>>
				</td>
			</tr>
			<tr class="hl-setting">
				<th colspan="2">
					<br>
					<?php echo $engine->_t('HttpSecurityHeaders');?>
				</th>
			</tr>
			<tr class="hl-setting">
				<td class="label">
					<label for="enable_security_headers"><strong><?php echo $engine->_t('EnableSecurityHeaders');?>:</strong><br>
					<small><?php echo $engine->_t('EnableSecurityHeadersinfo');?></small></label>
				</td>
				<td>
					<input type="radio" id="security_headers_on" name="enable_security_headers" value="1"<?php echo ($engine->db->enable_security_headers == 1 ? ' checked' : '');?>><label for="security_headers_on"><?php echo $engine->_t('On');?></label>
					<input type="radio" id="security_headers_off" name="enable_security_headers" value="0"<?php echo ($engine->db->enable_security_headers == 0 ? ' checked' : '');?>><label for="security_headers_off"><?php echo $engine->_t('Off');?></label>
				</td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl-setting">
				<td class="label">
					<label for="csp"><strong><?php echo $engine->_t('Csp');?>:</strong><br>
					<small><?php echo $engine->_t('CspInfo');?></small></label>
				</td>
				<td>
					<select id="csp" name="csp">
						<?php
						$csp_modes = $engine->_t('PolicyModes');

						foreach ($csp_modes as $mode => $csp_mode)
						{
							echo '<option value="' . $mode . '" ' . ( (int) $engine->db->csp === $mode ? 'selected' : '') . '>' . $mode . ': ' . $csp_mode . '</option>' . "\n";
						}
					?>
					</select>
				</td>
			</tr>
			<tr>
				<?php
				if ($engine->db->csp)
				{
					switch ($engine->db->csp)
					{
						// default
						case 1:
							$file_name	= 'csp.conf';
							break;

						// custom
						case 2:
							$file_name	= 'csp_custom.conf';
							break;
					}

					$file_path	= Ut::join_path(CONFIG_DIR, $file_name);
					$csp_header	= file_get_contents($file_path);

					?>
				<th colspan="2">
					CSP header <?php echo $file_name; ?>
				</th>
			</tr>
			<tr>
				<td colspan="2">
					<textarea style="width: 100%; min-height: 200px;" id="csp_header" name="csp_header"><?php echo Ut::html($csp_header);?></textarea>
				</td>
			</tr>
			<?php
				} // close CSP file display
			?>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl-setting">
				<td class="label">
					<label for="csp"><strong><?php echo $engine->_t('PermissionsPolicy');?>:</strong><br>
					<small><?php echo $engine->_t('PermissionsPolicyInfo');?></small></label>
				</td>
				<td>
					<select id="permissions_policy" name="permissions_policy">
						<?php
						$pp_modes = $engine->_t('PolicyModes');

						foreach ($pp_modes as $mode => $pp_mode)
						{
							echo '<option value="' . $mode . '" ' . ( (int) $engine->db->permissions_policy === $mode ? 'selected' : '') . '>' . $mode . ': ' . $pp_mode . '</option>' . "\n";
						}
					?>
					</select>
				</td>
			</tr>
			<tr>
				<?php
				if ($engine->db->permissions_policy)
				{
					switch ($engine->db->permissions_policy)
					{
						// default
						case 1:
							$file_name	= 'permissions_policy.conf';
							break;

						// custom
						case 2:
							$file_name	= 'permissions_policy_custom.conf';
							break;
					}

					$file_path	= Ut::join_path(CONFIG_DIR, $file_name);
					$pp_header	= file_get_contents($file_path);

					?>
				<th colspan="2">
					Permissions-Policy header <?php echo $file_name; ?>
				</th>
			</tr>
			<tr>
				<td colspan="2">
					<textarea style="width: 100%; min-height: 200px;" id="csp_header" name="pp_header"><?php echo Ut::html($pp_header);?></textarea>
				</td>
			</tr>
			<?php
				} // close Permissions-Policy file display
			?>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl-setting">
				<td class="label">
					<label for="referrer_policy"><strong><?php echo $engine->_t('ReferrerPolicy');?>:</strong><br>
					<small><?php echo $engine->_t('ReferrerPolicyInfo');?></small></label>
				</td>
				<td>
					<select id="referrer_policy" name="referrer_policy">
						<?php
						$referrer_modes = $engine->_t('ReferrerPolicyModes');

						foreach ($referrer_modes as $mode => $referrer_mode)
						{
							echo '<option value="' . $mode . '" ' . ( (int) $engine->db->referrer_policy === $mode ? 'selected' : '') . '>' . $mode . ': ' . $referrer_mode . '</option>' . "\n";
						}
					?>
					</select>
				</td>
			</tr>
			<tr>
				<th colspan="2">
					<br>
					<?php echo $engine->_t('UserPasswordSection');?>
				</th>
			</tr>
			<tr class="hl-setting">
				<td class="label">
					<label for="pwd_min_chars"><strong><?php echo $engine->_t('PwdMinChars');?>:</strong><br>
					<small><?php echo $engine->_t('PwdMinCharsInfo');?></small></label>
				</td>
				<td>
					<input type="number" min="10" maxlength="3" id="pwd_min_chars" name="pwd_min_chars" value="<?php echo (int) $engine->db->pwd_min_chars;?>">
				</td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl-setting">
				<td class="label">
					<label for="pwd_admin_min_chars"><strong><?php echo $engine->_t('AdminPwdMinChars');?>:</strong><br>
					<small><?php echo $engine->_t('AdminPwdMinCharsInfo');?></small></label>
				</td>
				<td>
					<input type="number" min="15" maxlength="3" id="pwd_admin_min_chars" name="pwd_admin_min_chars" value="<?php echo (int) $engine->db->pwd_admin_min_chars;?>">
				</td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl-setting">
				<td class="label">
					<label for="pwd_char_classes"><strong><?php echo $engine->_t('PwdCharComplexity');?>:</strong></label>
				</td>
				<td>
					<select id="pwd_char_classes" name="pwd_char_classes">
					<?php
						$pwd_char_classes = $engine->_t('PwdCharClasses');

						foreach ($pwd_char_classes as $mode => $pwd_char_class)
						{
							echo '<option value="' . $mode . '" ' . ( (int) $engine->db->pwd_char_classes === $mode ? 'selected' : '') . '>' . $mode . ': ' . $pwd_char_class . '</option>' . "\n";
						}
					?>
					</select>
				</td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl-setting">
				<td class="label">
					<label for="pwd_unlike_login"><strong><?php echo $engine->_t('PwdUnlikeLogin');?>:</strong></label>
				</td>
				<td>
					<select id="pwd_unlike_login" name="pwd_unlike_login">
					<?php
						$pwd_unlikes = $engine->_t('PwdUnlikes');

						foreach ($pwd_unlikes as $mode => $pwd_unlike)
						{
							echo '<option value="' . $mode . '" ' . ( (int) $engine->db->pwd_unlike_login === $mode ? 'selected' : '') . '>' . $mode . ': ' . $pwd_unlike . '</option>' . "\n";
						}
					?>
					</select>
				</td>
			</tr>
			<tr>
				<th colspan="2">
					<br>
					<?php echo $engine->_t('LoginSection');?>
				</th>
			</tr>
			<tr class="hl-setting">
				<td class="label">
					<label for="max_login_attempts"><strong><?php echo $engine->_t('MaxLoginAttempts');?>:</strong><br>
					<small><?php echo $engine->_t('MaxLoginAttemptsInfo');?></small></label>
				</td>
				<td>
					<input type="number" min="0" maxlength="4" id="max_login_attempts" name="max_login_attempts" value="<?php echo (int) $engine->db->max_login_attempts;?>">
				</td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl-setting">
				<td class="label">
					<label for="ip_login_limit_max"><strong><?php echo $engine->_t('IpLoginLimitMax');?>:</strong><br>
					<small><?php echo $engine->_t('IpLoginLimitMaxInfo');?></small></label>
				</td>
				<td>
					<input type="number" min="0" maxlength="4" id="ip_login_limit_max" name="ip_login_limit_max" value="<?php echo (int) $engine->db->ip_login_limit_max;?>">
				</td>
			</tr>
			<tr class="hl-setting">
				<th colspan="2">
					<br>
					<?php echo $engine->_t('FormsSection');?>
				</th>
			</tr>
			<tr class="hl-setting">
				<td class="label">
					<label for="form_token_time"><strong><?php echo $engine->_t('FormTokenTime');?>:</strong><br>
					<small><?php echo $engine->_t('FormTokenTimeInfo');?></small></label>
				</td>
				<td>
					<input type="number" min="0" maxlength="4" id="form_token_time" name="form_token_time" value="<?php echo (int) $engine->db->form_token_time;?>">
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
					<label for="session_length"><strong><?php echo $engine->_t('SessionLength');?>:</strong><br>
					<small><?php echo $engine->_t('SessionLengthInfo');?></small></label>
				</td>
				<td>
					<input type="number" min="0" maxlength="4" id="session_length" name="session_length" value="<?php echo (int) $engine->db->session_length;?>">
				</td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl-setting">
				<td class="label">
					<label for="comment_delay"><strong><?php echo $engine->_t('CommentDelay');?>:</strong><br>
					<small><?php echo $engine->_t('CommentDelayInfo');?></small></label>
				</td>
				<td>
					<input type="number" min="0" maxlength="4" id="comment_delay" name="comment_delay" value="<?php echo (int) $engine->db->comment_delay;?>">
				</td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl-setting">
				<td class="label">
					<label for="intercom_delay"><strong><?php echo $engine->_t('IntercomDelay');?>:</strong><br>
					<small><?php echo $engine->_t('IntercomDelayInfo');?></small></label>
				</td>
				<td>
					<input type="number" min="0" maxlength="4" id="intercom_delay" name="intercom_delay" value="<?php echo (int) $engine->db->intercom_delay;?>">
				</td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl-setting">
				<td class="label">
					<label for="registration_delay"><strong><?php echo $engine->_t('RegistrationDelay');?>:</strong><br>
					<small><?php echo $engine->_t('RegistrationDelayInfo');?></small></label>
				</td>
				<td>
					<input type="number" min="0" maxlength="4" id="registration_delay" name="registration_delay" value="<?php echo (int) $engine->db->registration_delay;?>">
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

