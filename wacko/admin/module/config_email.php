<?php

if (!defined('IN_WACKO'))
{
	exit;
}

########################################################
##   Email settings                                   ##
########################################################
$_mode = 'config_email';

$module[$_mode] = [
		'order'	=> 270,
		'cat'	=> 'preferences',
		'status'=> (RECOVERY_MODE ? false : true),
		'mode'	=> $_mode,
		'name'	=> $engine->_t($_mode)['name'],		// Email
		'title'	=> $engine->_t($_mode)['title'],	// Email settings
	];

########################################################

function admin_config_email(&$engine, &$module)
{
?>
	<h1><?php echo $module['title']; ?></h1>
	<br />
	<p>
		<?php echo $engine->_t('EmaiSettingsInfo'); ?>
	</p>
	<br />
<?php

	// send test email
	if (isset($_POST['send_test_email']))
	{
		$subject	= $engine->_t('TestEmailSubject');
		$body		= $engine->_t('TestEmailBody');

		$engine->send_user_email('System', $subject, $body);

		$engine->set_message($engine->_t('TestEmailMessage'), 'success');
		$engine->http->redirect(rawurldecode($engine->href()));
	}

	// update settings
	if (isset($_POST['action']) && $_POST['action'] == 'update')
	{
		$config['email_from']					= (string) $_POST['email_from'];
		$config['admin_email']					= (string) $_POST['admin_email'];
		$config['abuse_email']					= (string) $_POST['abuse_email'];
		$config['noreply_email']				= (string) $_POST['noreply_email'];
		$config['smtp_auto_tls']				= (int) $_POST['smtp_auto_tls'];
		$config['smtp_connection_mode']			= (string) $_POST['smtp_connection_mode'];
		$config['smtp_host']					= (string) $_POST['smtp_host'];
		$config['smtp_password']				= (string) $_POST['smtp_password'];
		$config['smtp_port']					= (int) $_POST['smtp_port'];
		$config['smtp_username']				= (string) $_POST['smtp_username'];
		$config['enable_email']					= (int) $_POST['enable_email'];
		$config['phpmailer_method']				= (string) $_POST['phpmailer_method'];

		$engine->config->_set($config);

		$engine->log(1, '!!Updated email settings!!');
		$engine->set_message('Updated email settings', 'success');
		$engine->http->redirect(rawurldecode($engine->href()));
	}



	echo $engine->form_open('email');
?>
		<input type="hidden" name="action" value="update" />
		<table class="formation">
			<colgroup>
				<col span="1" style="width:60%;">
				<col span="1" style="width:40%;">
			</colgroup>
			<tr>
				<th colspan="2">Basic parameters</th>
			</tr>
			<tr class="hl_setting">
				<td class="label">
					<label for="enable_email"><strong><?php echo $engine->_t('EnableEmail'); ?>:</strong><br />
					<small><?php echo $engine->_t('EnableEmailInfo'); ?></small></label>
				</td>
				<td>
					<input type="radio" id="enable_email_on" name="enable_email" value="1"<?php echo ($engine->db->enable_email == 1 ? ' checked="checked"' : '');?> /><label for="enable_email_on"><?php echo $engine->_t('Enabled'); ?></label>
					<input type="radio" id="enable_email_off" name="enable_email" value="0"<?php echo ($engine->db->enable_email == 0 ? ' checked="checked"' : '');?> /><label for="enable_email_off"><?php echo $engine->_t('Disabled'); ?></label>
				</td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl_setting">
				<td class="label">
					<label for="phpmailer_method"><strong><?php echo $engine->_t('EmailFunctionName'); ?>:</strong><br />
					<small><?php echo $engine->_t('EmailFunctionNameInfo'); ?><br />
					<?php echo $engine->_t('UseSmtpInfo'); ?></small></label></td>
				<td>
					<select style="width:200px;" id="phpmailer_method" name="phpmailer_method">
						<option value="mail"<?php echo ((string) $engine->db->phpmailer_method === 'mail' ? ' selected="selected"' : '');?>>mail</option>
						<option value="sendmail"<?php echo ((string) $engine->db->phpmailer_method === 'sendmail' ? ' selected="selected"' : '');?>>sendmail</option>
						<option value="smtp"<?php echo ((string) $engine->db->phpmailer_method === 'smtp' ? ' selected="selected"' : '');?>>SMTP</option>
					</select>
				</td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl_setting">
				<td class="label">
					<label for="email_from"><strong><?php echo $engine->_t('FromEmailName'); ?>:</strong><br />
					<small><?php echo $engine->_t('FromEmailNameInfo'); ?></small></label>
				</td>
				<td>
					<input type="text" maxlength="100" style="width:200px;" id="email_from" name="email_from" value="<?php echo htmlspecialchars($engine->db->email_from, ENT_COMPAT | ENT_HTML401, HTML_ENTITIES_CHARSET);?>" />
				</td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl_setting">
				<td class="label"><label for="noreply_email"><strong><?php echo $engine->_t('NoReplyEmail'); ?>:</strong><br />
				<small><?php echo $engine->_t('NoReplyEmailInfo'); ?></small></label></td>
				<td><input type="email" maxlength="100" style="width:200px;" id="noreply_email" name="noreply_email" value="<?php echo htmlspecialchars($engine->db->noreply_email, ENT_COMPAT | ENT_HTML401, HTML_ENTITIES_CHARSET);?>" /></td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl_setting">
				<td class="label"><label for="admin_email"><strong><?php echo $engine->_t('AdminEmail'); ?>:</strong><br />
				<small><?php echo $engine->_t('AdminEmailInfo'); ?></small></label></td>
				<td><input type="email" maxlength="100" style="width:200px;" id="admin_email" name="admin_email" value="<?php echo htmlspecialchars($engine->db->admin_email, ENT_COMPAT | ENT_HTML401, HTML_ENTITIES_CHARSET);?>" /></td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl_setting">
				<td class="label"><label for="abuse_email"><strong><?php echo $engine->_t('AbuseEmail'); ?>:</strong><br />
				<small><?php echo $engine->_t('AbuseEmailInfo'); ?></small></label></td>
				<td><input type="email" maxlength="100" style="width:200px;" id="abuse_email" name="abuse_email" value="<?php echo htmlspecialchars($engine->db->abuse_email, ENT_COMPAT | ENT_HTML401, HTML_ENTITIES_CHARSET);?>" /></td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl_setting">
				<td class="label"><label for="send_test_email"><strong><?php echo $engine->_t('SendTestEmail'); ?>:</strong><br />
				<small><?php echo $engine->_t('SendTestEmailInfo'); ?></small></label></td>
				<td><input type="submit" id="send_test_email" name="send_test_email" value="<?php echo $engine->_t('SendTestEmail'); ?>"></td>
			</tr>

			<tr>
				<th colspan="2">
					<br />
					<?php echo $engine->_t('SmtpSettings'); ?>
				</th>
			</tr>
			<tr class="hl_setting">
				<td class="label"><label for="smtp_host"><strong><?php echo $engine->_t('SmtpServer'); ?>:</strong><br />
				<small><?php echo $engine->_t('SmtpServerInfo'); ?></small></label></td>
				<td><input type="text" maxlength="50" style="width:200px;" id="smtp_host" name="smtp_host" value="<?php echo htmlspecialchars($engine->db->smtp_host, ENT_COMPAT | ENT_HTML401, HTML_ENTITIES_CHARSET);?>" /></td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl_setting">
				<td class="label"><label for="smtp_port"><strong><?php echo $engine->_t('SmtpPort'); ?>:</strong><br />
				<small><?php echo $engine->_t('SmtpPortInfo'); ?></small></label></td>
				<td><input type="number" min="0" maxlength="5" style="width:200px;" id="smtp_port" name="smtp_port" value="<?php echo (int) $engine->db->smtp_port;?>" /></td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl_setting">
				<td class="label"><label for="smtp_connection_mode"><strong><?php echo $engine->_t('SmtpConnectionMode'); ?>:</strong><br />
				<small><?php echo $engine->_t('SmtpConnectionModeInfo'); ?>.</small></label></td>
				<td><select style="width:200px;" id="smtp_connection_mode" name="smtp_connection_mode">
						<option value="" <?php echo ((string) $engine->db->smtp_connection_mode === '' ? ' selected="selected"' : '');?>><?php echo $engine->_t('None'); ?>none</option>
						<option value="ssl" <?php echo ((string) $engine->db->smtp_connection_mode === 'ssl' ? ' selected="selected"' : '');?>>SSL</option>
						<option value="tls" <?php echo ((string) $engine->db->smtp_connection_mode === 'tls' ? ' selected="selected"' : '');?>>TLS</option>
					</select>
				</td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl_setting">
				<td class="label">
					<label for="smtp_auto_tls"><strong><?php echo $engine->_t('SmtpAutoTls'); ?>:</strong><br />
					<small><?php echo $engine->_t('SmtpAutoTlsInfo'); ?></small></label>
				</td>
				<td style="width:40%;">
					<input type="radio" id="smtp_auto_tls_on" name="smtp_auto_tls" value="1" <?php echo ($engine->db->smtp_auto_tls == 1 ? ' checked="checked"' : '');?> /><label for="smtp_auto_tls_on"><?php echo $engine->_t('Enabled'); ?></label>
					<input type="radio" id="smtp_auto_tls_off" name="smtp_auto_tls" value="0" <?php echo ($engine->db->smtp_auto_tls == 0 ? ' checked="checked"' : '');?> /><label for="smtp_auto_tls_off"><?php echo $engine->_t('Disabled'); ?></label>
				</td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl_setting">
				<td class="label"><label for="smtp_username"><strong><?php echo $engine->_t('SmtpUsername'); ?>:</strong><br />
				<small><?php echo $engine->_t('SmtpUsernameInfo'); ?></small></label></td>
				<td>
					<input type="text" maxlength="255" style="width:200px;" id="smtp_username" name="smtp_username" value="<?php echo htmlspecialchars($engine->db->smtp_username, ENT_COMPAT | ENT_HTML401, HTML_ENTITIES_CHARSET);?>" />
				</td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl_setting">
				<td class="label"><label for="smtp_password"><strong><?php echo $engine->_t('SmtpPassword'); ?>:</strong><br />
				<small><?php echo $engine->_t('SmtpPasswordInfo'); ?></small></label></td>
				<td>
					<input type="password" maxlength="255" style="width:200px;" id="smtp_password" name="smtp_password" value="<?php echo htmlspecialchars($engine->db->smtp_password, ENT_COMPAT | ENT_HTML401, HTML_ENTITIES_CHARSET);?>" />
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
