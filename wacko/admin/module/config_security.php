<?php

if (!defined('IN_WACKO'))
{
	exit;
}

########################################################
##   Security settings                                ##
########################################################
$_mode = 'config_security';

$module[$_mode] = [
		'order'	=> 221,
		'cat'	=> 'preferences',
		'status'=> (RECOVERY_MODE ? false : true),
		'mode'	=> $_mode,
		'name'	=> $engine->_t($_mode)['name'],		// Security
		'title'	=> $engine->_t($_mode)['title'],	// Security subsystems settings
	];

########################################################

function admin_config_security(&$engine, &$module)
{
?>
	<h1><?php echo $module['title']; ?></h1>
	<br />
	<p>
		Parameters responsible for the overall safety of the platform, work permits and additional security subsystems.
	</p>
	<br />
<?php
	// update settings
	if (isset($_POST['action']) && $_POST['action'] == 'update')
	{
		$config['allow_registration']			= (int) $_POST['allow_registration'];
		$config['approve_new_user']				= (int) $_POST['approve_new_user'];
		$config['enable_captcha']				= (int) $_POST['enable_captcha'];
		$config['captcha_new_comment']			= (int) $_POST['captcha_new_comment'];
		$config['captcha_new_page']				= (int) $_POST['captcha_new_page'];
		$config['captcha_edit_page']			= (int) $_POST['captcha_edit_page'];
		$config['captcha_registration']			= (int) $_POST['captcha_registration'];
		$config['allow_persistent_cookie']		= (int) $_POST['allow_persistent_cookie'];
		$config['antidupe']						= (int) $_POST['antidupe'];
		$config['disable_wikiname']				= (int) $_POST['disable_wikiname'];
		$config['allow_email_reuse']			= (int) $_POST['allow_email_reuse'];
		$config['tls']							= (int) $_POST['tls'];
		$config['tls_implicit']					= (int) $_POST['tls_implicit'];
		$config['tls_proxy']					= trim((string) $_POST['tls_proxy']);
		$config['pwd_min_chars']				= (int) $_POST['pwd_min_chars'];
		$config['pwd_char_classes']				= (int) $_POST['pwd_char_classes'];
		$config['pwd_unlike_login']				= (int) $_POST['pwd_unlike_login'];
		$config['log_level']					= (int) $_POST['log_level'];
		$config['log_default_show']				= (int) $_POST['log_default_show'];
		$config['log_purge_time']				= (int) $_POST['log_purge_time'];
		$config['session_length']				= (int) $_POST['session_length'];
		$config['comment_delay']				= (int) $_POST['comment_delay'];
		$config['intercom_delay']				= (int) $_POST['intercom_delay'];
		$config['enable_security_headers']		= (int) $_POST['enable_security_headers'];
		$config['csp']							= (int) $_POST['csp'];
		$config['max_login_attempts']			= (int) $_POST['max_login_attempts'];
		$config['ip_login_limit_max']			= (int) $_POST['ip_login_limit_max'];
		$config['username_chars_min']			= (int) $_POST['username_chars_min'];
		$config['username_chars_max']			= (int) $_POST['username_chars_max'];
		$config['form_token_time']				= (int) $_POST['form_token_time'];

		$engine->config->_set($config);

		$engine->log(1, '!!Updated security settings!!');
		$engine->set_message('Updated security settings', 'success');
		$engine->http->redirect(rawurldecode($engine->href()));
	}

	echo $engine->form_open('security');
?>
		<input type="hidden" name="action" value="update" />
		<table class="formation">
			<tr>
				<th colspan="2">Basic parameters</th>
			</tr>
			<tr class="hl_setting">
				<td class="label">
					<label for="allow_registration"><strong>Register online:</strong><br />
					<small>Ongoing registration of users. Disabling the option will prevent free registration, however, the site administrator will be able to register other users on their own.</small></label>
				</td>
				<td style="width:40%;">
					<input type="checkbox" id="allow_registration" name="allow_registration" value="1"<?php echo ( $engine->db->allow_registration ? ' checked="checked"' : '' );?> />
				</td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl_setting">
				<td class="label">
					<label for="approve_new_user"><strong>Approve new users:</strong><br />
					<small>Allows Administrators to approve users once they register. Only approved users will be allowed to log in the site.</small></label>
				</td>
				<td>
					<input type="radio" id="approve_new_user_on" name="approve_new_user" value="1"<?php echo ( $engine->db->approve_new_user == 1 ? ' checked="checked"' : '' );?> /><label for="approve_new_user_on"><?php echo $engine->_t('On');?></label>
					<input type="radio" id="approve_new_user_off" name="approve_new_user" value="0"<?php echo ( $engine->db->approve_new_user == 0 ? ' checked="checked"' : '' );?> /><label for="approve_new_user_off"><?php echo $engine->_t('Off');?></label>
				</td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl_setting">
				<td class="label">
					<label for="allow_persistent_cookie"><strong>Persistent cookies:</strong><br />
					<small>Allow persistent cookies.</small></label>
				</td>
				<td>
					<input type="checkbox" id="allow_persistent_cookie" name="allow_persistent_cookie" value="1"<?php echo ( $engine->db->allow_persistent_cookie ? ' checked="checked"' : '' );?> />
				</td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl_setting">
				<td class="label">
					<label for="antidupe"><strong>Anti-clone:</strong><br />
					<small>Disable register on the website under the names, <span class="underline">like</span> on the names of existing users (guests also can not use similar names for the signature comments). When this option is checked only <span class="underline">identical</span> names.</small></label>
				</td>
				<td>
					<input type="checkbox" id="antidupe" name="antidupe" value="1"<?php echo ( $engine->db->antidupe ? ' checked="checked"' : '' );?> />
				</td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl_setting">
				<td class="label">
					<label for="disable_wikiname"><strong>Disable WikiName:</strong><br />
					<small>Disable the the mandatory use of WikiName. Allows to register users with traditional nicknames, not forced NameSurname.</small></label>
				</td>
				<td>
					<input type="checkbox" id="disable_wikiname" name="disable_wikiname" value="1"<?php echo ( $engine->db->disable_wikiname ? ' checked="checked"' : '' );?> />
				</td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl_setting">
				<td class="label">
					<label for="allow_email_reuse"><strong>Allow email address re-use:</strong><br />
					<small>Different users can register with the same e-mail address.</small></label>
				</td>
				<td>
					<input type="checkbox" id="allow_email_reuse" name="allow_email_reuse" value="1"<?php echo ( $engine->db->allow_email_reuse ? ' checked="checked"' : '' );?> />
				</td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl_setting">
				<td class="label">
					<label for="username_chars_min"><strong>Username length:</strong><br />
					<small>Minimum and maximum number of characters in usernames.</small></label>
				</td>
				<td>
					<input type="number" min="0" maxlength="3" style="width:40px;" id="username_chars_min" name="username_chars_min" value="<?php echo (int) $engine->db->username_chars_min;?>" /> Min&nbsp;&nbsp;<input type="number" min="0" maxlength="3" style="width:40px;" id="username_chars_max" name="username_chars_max" value="<?php echo (int) $engine->db->username_chars_max;?>" /> Max
				</td>
			</tr>
			<tr>
				<th colspan="2">
					<br />
					CAPTCHA
				</th>
			</tr>
			<tr class="hl_setting">
				<td class="label">
					<label for="enable_captcha"><strong>Enable Captcha:</strong><br />
					<small>If enabled, Captcha will be shown in the following cases and if a security threshold is reached.</small></label>
				</td>
				<td>
					<input type="radio" id="enable_captcha_on" name="enable_captcha" value="1"<?php echo ( $engine->db->enable_captcha == 1 ? ' checked="checked"' : '' );?> /><label for="enable_captcha_on"><?php echo $engine->_t('On');?></label>
					<input type="radio" id="enable_captcha_off" name="enable_captcha" value="0"<?php echo ( $engine->db->enable_captcha == 0 ? ' checked="checked"' : '' );?> /><label for="enable_captcha_off"><?php echo $engine->_t('Off');?></label>
				</td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl_setting">
				<td class="label">
					<label for="captcha_new_comment"><strong>New comment:</strong><br />
					<small>As a measure of protection against spam publications require unregistered users a single solution of the test before posting the comment.</small></label>
				</td>
				<td>
					<input type="checkbox" id="captcha_new_comment" name="captcha_new_comment" value="1"<?php echo ( $engine->db->captcha_new_comment ? ' checked="checked"' : '' );?> />
				</td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl_setting">
				<td class="label">
					<label for="captcha_new_page"><strong>New page:</strong><br />
					<small>As a measure of protection against spam publications require unregistered users a single solution of the test before creating a new pages.</small></label>
				</td>
				<td>
					<input type="checkbox" id="captcha_new_page" name="captcha_new_page" value="1"<?php echo ( $engine->db->captcha_new_page ? ' checked="checked"' : '' );?> />
				</td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl_setting">
				<td class="label">
					<label for="captcha_edit_page"><strong>Edit page:</strong><br />
					<small>As a measure of protection against spam publications require unregistered users a single solution of the test before editing pages.</small></label>
				</td>
				<td>
					<input type="checkbox" id="captcha_edit_page" name="captcha_edit_page" value="1"<?php echo ( $engine->db->captcha_edit_page ? ' checked="checked"' : '' );?> />
				</td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl_setting">
				<td class="label">
					<label for="captcha_registration"><strong>Registration:</strong><br />
					<small>As a measure of protection against spam publications require unregistered users a single solution of the test before registering.</small></label>
				</td>
				<td>
					<input type="checkbox" id="captcha_registration" name="captcha_registration" value="1"<?php echo ( $engine->db->captcha_registration ? ' checked="checked"' : '' );?> />
				</td>
			</tr>
			<tr>
				<th colspan="2">
					<br />
					TLS Settings
				</th>
			</tr>
			<tr class="hl_setting">
				<td class="label">
					<label for="tls"><strong>TLS-Connection:</strong><br />
					<small>Use TLS-secured connection. <span class="cite">Activate the required pre-installed TLS-certificate on the server , otherwise you will lose access to the admin panel!</span></small></label>
				</td>
				<td>
					<input type="checkbox" id="tls" name="tls" value="1"<?php echo ( $engine->db->tls ? ' checked="checked"' : '' );?> />
				</td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl_setting">
				<td class="label">
					<label for="tls_implicit"><strong>Forced TLS:</strong><br />
					<small>Force client reconnection from HTTP to HTTPS. When this option the customer can view the site for open HTTP-channel.</small></label>
				</td>
				<td>
					<input type="checkbox" id="tls_implicit" name="tls_implicit" value="1"<?php echo ( $engine->db->tls_implicit ? ' checked="checked"' : '' );?> />
				</td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl_setting">
				<td class="label">
					<label for="tls_proxy"><strong>TLS Proxy:</strong><br />
					<small>Uses the provided TLS Proxy inplace of TLS. E.g. https://<span class="cite">your-https-proxy.tld</span> without ending slash and without https://.</small></label>
				</td>
				<td>
					<input type="text" maxlength="100" style="width:200px;" id="tls_proxy" name="tls_proxy" value="<?php echo htmlspecialchars($engine->db->tls_proxy, ENT_COMPAT | ENT_HTML401, HTML_ENTITIES_CHARSET);?>" />
				</td>
			</tr>
			<tr class="hl_setting">
				<th colspan="2">
					<br />
					HTTP Security Headers
				</th>
			</tr>
			<tr class="hl_setting">
				<td class="label">
					<label for="enable_security_headers"><strong>Enable Security Headers:</strong><br />
					<small>Set security headers (frame busting, clickjacking/XSS/CSRF protection). <br />CSP may cause issues in certain situations (e.g. during development), or when using plugins relying on externally hosted resources such as images or scripts. <br />Disabling Content Security Policy is a security risk !</small></label>
				</td>
				<td>
					<input type="radio" id="security_headers_on" name="enable_security_headers" value="1"<?php echo ( $engine->db->enable_security_headers == 1 ? ' checked="checked"' : '' );?> /><label for="security_headers_on"><?php echo $engine->_t('On');?></label>
					<input type="radio" id="security_headers_off" name="enable_security_headers" value="0"<?php echo ( $engine->db->enable_security_headers == 0 ? ' checked="checked"' : '' );?> /><label for="security_headers_off"><?php echo $engine->_t('Off');?></label>
				</td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl_setting">
				<td class="label">
					<label for="csp"><strong>Content-Security-Policy (CSP):</strong><br />
					<small>Configuring Content Security Policy involves deciding what policies you want to enforce, and then configuring them and using Content-Security-Policy to establish your policy.</small></label>
				</td>
				<td>
					<select style="width:200px;" id="csp" name="csp">
						<option value="0"<?php echo ( (int) $engine->db->csp === 0 ? ' selected="selected"' : '' );?>>disabled</option>
						<option value="1"<?php echo ( (int) $engine->db->csp === 1 ? ' selected="selected"' : '' );?>>strict</option>
						<option value="2"<?php echo ( (int) $engine->db->csp === 2 ? ' selected="selected"' : '' );?>>custom</option>
					</select>
				</td>
			</tr>
			<tr>
				<th colspan="2">
					<br />
					Persistence of user passwords
				</th>
			</tr>
			<tr class="hl_setting">
				<td class="label">
					<label for="pwd_min_chars"><strong>Minimum password length:</strong><br />
					<small>Longer passwords are necessarily more secure than shorter passwords (e.g. 12 to 16 characters).<br />The use of passphrases instead of passwords is encouraged.</small></label>
				</td>
				<td>
					<input type="number" min="5" maxlength="3" style="width:200px;" id="pwd_min_chars" name="pwd_min_chars" value="<?php echo (int) $engine->db->pwd_min_chars;?>" />
				</td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl_setting">
				<td class="label">
					<label for="pwd_char_classes"><strong>The required password complexity:</strong></label>
				</td>
				<td>
					<select style="width:200px;" id="pwd_char_classes" name="pwd_char_classes">
						<option value="0"<?php echo ( (int) $engine->db->pwd_char_classes === 0 ? ' selected="selected"' : '' );?>>not tested</option>
						<option value="1"<?php echo ( (int) $engine->db->pwd_char_classes === 1 ? ' selected="selected"' : '' );?>>any letters + numbers</option>
						<option value="2"<?php echo ( (int) $engine->db->pwd_char_classes === 2 ? ' selected="selected"' : '' );?>>uppercase and lowercase + numbers</option>
						<option value="3"<?php echo ( (int) $engine->db->pwd_char_classes === 3 ? ' selected="selected"' : '' );?>>uppercase and lowercase + numbers + characters</option>
					</select>
				</td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl_setting">
				<td class="label">
					<label for="pwd_unlike_login"><strong>Additional complication:</strong></label>
				</td>
				<td>
					<select style="width:200px;" id="pwd_unlike_login" name="pwd_unlike_login">
						<option value="0"<?php echo ( (int) $engine->db->pwd_unlike_login === 0 ? ' selected="selected"' : '' );?>>not tested</option>
						<option value="1"<?php echo ( (int) $engine->db->pwd_unlike_login === 1 ? ' selected="selected"' : '' );?>>password is not identical to the login</option>
						<option value="2"<?php echo ( (int) $engine->db->pwd_unlike_login === 2 ? ' selected="selected"' : '' );?>>password does not contain username</option>
					</select>
				</td>
			</tr>
			<tr>
				<th colspan="2">
					<br />
					Login
				</th>
			</tr>
			<tr class="hl_setting">
				<td class="label">
					<label for="max_login_attempts"><strong>Maximum number of login attempts per username:</strong><br />
					<small>The number of login attempts allowed for a single account before the anti-spambot task is triggered. Enter 0 to prevent the anti-spambot task from being triggered for distinct user accounts.</small></label>
				</td>
				<td>
					<input type="number" min="0" maxlength="4" style="width:200px;" id="max_login_attempts" name="max_login_attempts" value="<?php echo (int) $engine->db->max_login_attempts;?>" />
				</td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl_setting">
				<td class="label">
					<label for="ip_login_limit_max"><strong>Maximum number of login attempts per IP address:</strong><br />
					<small>The threshold of login attempts allowed from a single IP address before an anti-spambot task is triggered. Enter 0 to prevent the anti-spambot task from being triggered by IP addresses.</small></label>
				</td>
				<td>
					<input type="number" min="0" maxlength="4" style="width:200px;" id="ip_login_limit_max" name="ip_login_limit_max" value="<?php echo (int) $engine->db->ip_login_limit_max;?>" />
				</td>
			</tr>
			<tr>
				<th colspan="2">
					<br />
					Log settings
				</th>
			</tr>
			<tr class="hl_setting">
				<td class="label">
					<label for="log_level"><strong>Using logging:</strong><br />
					<small>The minimum priority of the events recorded in the log.</small></label>
				</td>
				<td>
					<select style="width:200px;" id="log_level" name="log_level">
						<option value="0"<?php echo ( (int) $engine->db->log_level === 0 ? ' selected="selected"' : '' );?>>0: not keep a journal</option>
						<option value="7"<?php echo ( (int) $engine->db->log_level === 7 ? ' selected="selected"' : '' );?>>7: record all</option>
						<option value="6"<?php echo ( (int) $engine->db->log_level === 6 ? ' selected="selected"' : '' );?>>6: the minimum level</option>
						<option value="5"<?php echo ( (int) $engine->db->log_level === 5 ? ' selected="selected"' : '' );?>>5: from low</option>
						<option value="4"<?php echo ( (int) $engine->db->log_level === 4 ? ' selected="selected"' : '' );?>>4: on average</option>
						<option value="3"<?php echo ( (int) $engine->db->log_level === 3 ? ' selected="selected"' : '' );?>>3: from high</option>
						<option value="2"<?php echo ( (int) $engine->db->log_level === 2 ? ' selected="selected"' : '' );?>>2: from the highest level</option>
						<option value="1"<?php echo ( (int) $engine->db->log_level === 1 ? ' selected="selected"' : '' );?>>1: only the critical level</option>
					</select>
				</td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl_setting">
				<td class="label">
					<label for="log_default_show"><strong>Display Log Mode:</strong><br />
					<small>The minimum priority events displayed in the log by default.</small></label>
				</td>
				<td>
					<select style="width:200px;" id="log_default_show" name="log_default_show">
						<option value="7"<?php echo ( (int) $engine->db->log_default_show === 7 ? ' selected="selected"' : '' );?>>show all</option>
						<option value="6"<?php echo ( (int) $engine->db->log_default_show === 6 ? ' selected="selected"' : '' );?>>from the minimum level</option>
						<option value="5"<?php echo ( (int) $engine->db->log_default_show === 5 ? ' selected="selected"' : '' );?>>from a low</option>
						<option value="4"<?php echo ( (int) $engine->db->log_default_show === 4 ? ' selected="selected"' : '' );?>>the average</option>
						<option value="3"<?php echo ( (int) $engine->db->log_default_show === 3 ? ' selected="selected"' : '' );?>>from high-level</option>
						<option value="2"<?php echo ( (int) $engine->db->log_default_show === 2 ? ' selected="selected"' : '' );?>>from the highest level</option>
						<option value="1"<?php echo ( (int) $engine->db->log_default_show === 1 ? ' selected="selected"' : '' );?>>only the critical level</option>
					</select>
				</td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl_setting">
				<td class="label">
					<label for="log_purge_time"><strong>Storage time of Log:</strong><br />
					<small>Remove event log over a given number of days.</small></label>
				</td>
				<td>
					<input type="number" min="0" maxlength="4" style="width:200px;" id="log_purge_time" name="log_purge_time" value="<?php echo (int) $engine->db->log_purge_time;?>" />
				</td>
			</tr>
			<tr class="hl_setting">
				<th colspan="2">
					<br />
					Forms
				</th>
			</tr>
			<tr class="hl_setting">
				<td class="label">
					<label for="form_token_time"><strong>Maximum time to submit forms:</strong><br />
					<small>The time a user has to submit a form (in seconds).<br /> Use -1 to disable. Note that a form might become invalid if the session expires, regardless of this setting.</small></label>
				</td>
				<td>
					<input type="number" min="0" maxlength="4" style="width:200px;" id="form_token_time" name="form_token_time" value="<?php echo (int) $engine->db->form_token_time;?>" />
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
					<label for="session_length"><strong>Term login cookie:</strong><br />
					<small>The lifetime of the user cookie login by default (in days).</small></label>
				</td>
				<td>
					<input type="number" min="0" maxlength="4" style="width:200px;" id="session_length" name="session_length" value="<?php echo (int) $engine->db->session_length;?>" />
				</td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl_setting">
				<td class="label">
					<label for="comment_delay"><strong>Anti-flood for comments:</strong><br />
					<small>The minimum delay between the publication of the new user comments (in seconds).</small></label>
				</td>
				<td>
					<input type="number" min="0" maxlength="4" style="width:200px;" id="comment_delay" name="comment_delay" value="<?php echo (int) $engine->db->comment_delay;?>" />
				</td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl_setting">
				<td class="label">
					<label for="intercom_delay"><strong>Anti-flood for personal communications:</strong><br />
					<small>The minimum delay between sending a private message user connection (in seconds).</small></label>
				</td>
				<td>
					<input type="number" min="0" maxlength="4" style="width:200px;" id="intercom_delay" name="intercom_delay" value="<?php echo (int) $engine->db->intercom_delay;?>" />
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
