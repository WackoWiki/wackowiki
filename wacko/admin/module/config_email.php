<?php

if (!defined('IN_WACKO'))
{
	exit;
}

########################################################
##   Email settings                                   ##
########################################################

$module['config_email'] = array(
		'order'	=> 270,
		'cat'	=> 'Preferences',
		'status'=> (RECOVERY_MODE ? false : true),
		'mode'	=> 'config_email',
		'name'	=> 'Email',
		'title'	=> 'Email settings',
	);

########################################################

function admin_config_email(&$engine, &$module)
{
?>
	<h1><?php echo $module['title']; ?></h1>
	<br />
	<p>
		This information is used when the engine sends emails to your users. Please ensure the email address you specify is valid, any bounced or undeliverable messages will likely be sent to that address. If your host does not provide a native (PHP based) email service you can instead send messages directly using SMTP. This requires the address of an appropriate server (ask your provider if necessary). If the server requires authentication (and only if it does) enter the necessary username, password and authentication method.
	</p>
	<br />
<?php
	// update settings
	if (isset($_POST['action']) && $_POST['action'] == 'update')
	{
		$config['email_from']					= (string)$_POST['email_from'];
		$config['admin_email']					= (string)$_POST['admin_email'];
		$config['abuse_email']					= (string)$_POST['abuse_email'];
		$config['smtp_connection_mode']			= (string)$_POST['smtp_connection_mode'];
		$config['smtp_host']					= (string)$_POST['smtp_host'];
		$config['smtp_password']				= (string)$_POST['smtp_password'];
		$config['smtp_port']					= (int)$_POST['smtp_port'];
		$config['smtp_username']				= (string)$_POST['smtp_username'];
		$config['enable_email']					= (int)$_POST['enable_email'];
		$config['phpmailer']					= (int)$_POST['phpmailer'];
		$config['phpmailer_method']				= (string)$_POST['phpmailer_method'];

		$engine->_set_config($config, '', true);

		$engine->log(1, '!!Updated email settings!!');
		$engine->set_message('Updated email settings');
		$engine->redirect(rawurldecode($engine->href()));
	}

	echo $engine->form_open('email', '', 'post', true, '', '');
?>
		<input type="hidden" name="action" value="update" />
		<table class="formation">
			<tr>
				<th colspan="2">Basic parameters</th>
			</tr>
			<tr class="hl_setting">
				<td class="label">
					<label for="enable_email"><strong>Email:</strong><br />
					<small>Enabling email</small></label>
				</td>
				<td style="width:40%;">
					<input type="radio" id="enable_email_on" name="enable_email" value="1"<?php echo ( $engine->config['enable_email'] == 1 ? ' checked="checked"' : '' );?> /><label for="enable_email_on">Enabled.</label>
					<input type="radio" id="enable_email_off" name="enable_email" value="0"<?php echo ( $engine->config['enable_email'] == 0 ? ' checked="checked"' : '' );?> /><label for="enable_email_off">Disabled.</label>
				</td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl_setting">
				<td class="label">
					<label for="phpmailer"><strong>PHPMailer:</strong><br />
					<small>Use the PHPMailer class. Enabling this option ...</small></label>
				</td>
				<td style="width:40%;">
					<input type="radio" id="phpmailer_on" name="phpmailer" value="1"<?php echo ( $engine->config['phpmailer'] == 1 ? ' checked="checked"' : '' );?> /><label for="phpmailer_on">Enabled.</label>
					<input type="radio" id="phpmailer_off" name="phpmailer" value="0"<?php echo ( $engine->config['phpmailer'] == 0 ? ' checked="checked"' : '' );?> /><label for="phpmailer_off">Disabled.</label>
				</td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl_setting">
				<td class="label">
					<label for="phpmailer_method"><strong>E-mail function name:</strong><br />
					<small>The e-mail function used to send mails through PHP.</small></label></td>
				<td>
					<select style="width:200px;" id="phpmailer_method" name="phpmailer_method">
						<option value=""<?php echo ( (string)$engine->config['phpmailer_method'] === '' ? ' selected="selected"' : '' );?>>default</option>
						<option value="mail"<?php echo ( (string)$engine->config['phpmailer_method'] === 'mail' ? ' selected="selected"' : '' );?>>mail</option>
						<option value="sendmail"<?php echo ( (string)$engine->config['phpmailer_method'] === 'sendmail' ? ' selected="selected"' : '' );?>>sendmail</option>
						<option value="smtp"<?php echo ( (string)$engine->config['phpmailer_method'] === 'smtp' ? ' selected="selected"' : '' );?>>SMTP</option>
					</select>
				</td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl_setting">
				<td class="label">
					<label for="email_from"><strong>Sender name of the site owner:</strong><br />
					<small>The sender name, part of <code>'From:'</code> header in emails for all the email-notification site.</small></label>
				</td>
				<td>
					<input type="text" maxlength="100" style="width:200px;" id="email_from" name="email_from" value="<?php echo htmlspecialchars($engine->config['email_from'], ENT_COMPAT | ENT_HTML401, HTML_ENTITIES_CHARSET);?>" />
				</td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl_setting">
				<td class="label"><label for="admin_email"><strong>Email of the site owner:</strong><br />
				<small>This address will appear as the<code>'From:'</code> all the email-notification site.</small></label></td>
				<td><input type="email" maxlength="100" style="width:200px;" id="admin_email" name="admin_email" value="<?php echo htmlspecialchars($engine->config['admin_email'], ENT_COMPAT | ENT_HTML401, HTML_ENTITIES_CHARSET);?>" /></td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl_setting">
				<td class="label"><label for="abuse_email"><strong>Email service abuse:</strong><br />
				<small>Address requests for urgent matters: registration for a foreign email, etc. It may coincide with the previous.</small></label></td>
				<td><input type="email" maxlength="100" style="width:200px;" id="abuse_email" name="abuse_email" value="<?php echo htmlspecialchars($engine->config['abuse_email'], ENT_COMPAT | ENT_HTML401, HTML_ENTITIES_CHARSET);?>" /></td>
			</tr>
			<tr>
				<th colspan="2">
					<br />
					SMTP Settings
				</th>
			</tr>
			<tr class="hl_setting">
				<td class="label"><label for="smtp_host"><strong>SMTP server address:</strong></label></td>
				<td><input type="text" maxlength="50" style="width:200px;" id="smtp_host" name="smtp_host" value="<?php echo htmlspecialchars($engine->config['smtp_host'], ENT_COMPAT | ENT_HTML401, HTML_ENTITIES_CHARSET);?>" /></td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl_setting">
				<td class="label"><label for="smtp_port"><strong>SMTP server port:</strong><br />
				<small>Only change this if you know your SMTP server is on a different port. (default 25 or 587)</small></label></td>
				<td><input type="number" min="0" maxlength="5" style="width:200px;" id="smtp_port" name="smtp_port" value="<?php echo htmlspecialchars($engine->config['smtp_port'], ENT_COMPAT | ENT_HTML401, HTML_ENTITIES_CHARSET);?>" /></td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl_setting">
				<td class="label"><label for="smtp_connection_mode"><strong>Connection mode for SMTP:</strong><br />
				<small>Only used if a username/password is set, ask your provider if you are unsure which method to use.</small></label></td>
				<td><select style="width:200px;" id="smtp_connection_mode" name="smtp_connection_mode">
						<option value=""<?php echo ( (string)$engine->config['smtp_connection_mode'] === '' ? ' selected="selected"' : '' );?>>none</option>
						<option value="ssl"<?php echo ( (string)$engine->config['smtp_connection_mode'] === 'ssl' ? ' selected="selected"' : '' );?>>SSL</option>
						<option value="tls"<?php echo ( (string)$engine->config['smtp_connection_mode'] === 'tls' ? ' selected="selected"' : '' );?>>TLS</option>
					</select>
				</td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl_setting">
				<td class="label"><label for="smtp_username"><strong>SMTP username:</strong><br />
				<small>Only enter a username if your SMTP server requires it.</small></label></td>
				<td>
					<input type="text" maxlength="255" style="width:200px;" id="smtp_username" name="smtp_username" value="<?php echo htmlspecialchars($engine->config['smtp_username'], ENT_COMPAT | ENT_HTML401, HTML_ENTITIES_CHARSET);?>" />
				</td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl_setting">
				<td class="label"><label for="smtp_password"><strong>SMTP password:</strong><br />
				<small>Only enter a password if your SMTP server requires it.<br />
				<strong>Warning:</strong> <em>This password will be stored as plain text in the database, visible to everybody who can access your database or who can view this configuration page.</em></small></label></td>
				<td>
					<input type="password" maxlength="255" style="width:200px;" id="smtp_password" name="smtp_password" value="<?php echo htmlspecialchars($engine->config['smtp_password'], ENT_COMPAT | ENT_HTML401, HTML_ENTITIES_CHARSET);?>" />
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