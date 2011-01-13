<?php

########################################################
##   Security settings                                ##
########################################################

$module['configemail'] = array(
		'order'	=> 2,
		'cat'	=> 'Preferences',
		'mode'	=> 'configemail',
		'name'	=> 'Email',
		'title'	=> 'Email settings',
	);

########################################################

function admin_configemail(&$engine, &$module)
{
?>
	<h1><?php echo $module['title']; ?></h1>
	<br />
	<p>
		This information is used when the board sends emails to your users. Please ensure the email address you specify is valid, any bounced or undeliverable messages will likely be sent to that address. If your host does not provide a native (PHP based) email service you can instead send messages directly using SMTP. This requires the address of an appropriate server (ask your provider if necessary). If the server requires authentication (and only if it does) enter the necessary username, password and authentication method.
	</p>
	<br />
<?php
	// update settings
	if (isset($_POST['action']) && $_POST['action'] == 'update')
	{
		$config['admin_email']					= (string)$_POST['admin_email'];
		$config['abuse_email']					= (string)$_POST['abuse_email'];
		$config['smtp_connection_mode']			= (string)$_POST['smtp_connection_mode'];
		$config['smtp_host']					= (string)$_POST['smtp_host'];
		$config['smtp_password']				= (string)$_POST['smtp_password'];
		$config['smtp_port']					= (int)$_POST['smtp_port'];
		$config['smtp_username']				= (string)$_POST['smtp_username'];

		$config['phpmailer']					= (int)$_POST['phpmailer'];
		$config['phpmailer_method']				= (string)$_POST['phpmailer_method'];

		foreach($config as $key => $value)
		{
			$engine->query(
				"UPDATE {$engine->config['table_prefix']}config SET value = '$value' WHERE config_name = '$key'");
		}
		$engine->log(1, '!!Updated security settings!!');
		$engine->redirect(rawurldecode($engine->href()));
	}
?>
	<form action="admin.php" method="post" name="email">
		<input type="hidden" name="mode" value="configemail" />
		<input type="hidden" name="action" value="update" />
		<table cellspacing="3" class="formation">
			<tr>
				<th colspan="2">Basic parameters</th>
			</tr>
			<tr>
				<td class="label"><label for="phpmailer"><strong>Phpmailer:</strong><br />
				<small>Use the Phpmailer class. Enabling this option ...</small></label></td>
				<td style="width:40%;">
					<input type="radio" id="phpmailer_on" name="phpmailer" value="1"<?php echo ( $engine->config['phpmailer'] == 1 ? ' checked="checked"' : '' );?> /><label for="phpmailer_on">Enabled.</label>
					<input type="radio" id="phpmailer_off" name="phpmailer" value="0"<?php echo ( $engine->config['phpmailer'] == 0 ? ' checked="checked"' : '' );?> /><label for="phpmailer_off">Disabled.</label>
				</td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr>
				<td class="label"><label for="phpmailer_method"><strong>E-mail function name:</strong><br />
				<small>The e-mail function used to send mails through PHP.</small></label></td>
				<td><select style="width:200px;" id="phpmailer_method" name="phpmailer_method">
						<option value=""<?php echo ( (string)$engine->config['phpmailer_method'] === '' ? ' selected="selected"' : '' );?>>default</option>
						<option value="mail"<?php echo ( (string)$engine->config['phpmailer_method'] === 'mail' ? ' selected="selected"' : '' );?>>mail</option>
						<option value="sendmail"<?php echo ( (string)$engine->config['phpmailer_method'] === 'sendmail' ? ' selected="selected"' : '' );?>>sendmail</option>
						<option value="smtp"<?php echo ( (string)$engine->config['phpmailer_method'] === 'smpt' ? ' selected="selected"' : '' );?>>SMTP</option>
					</select>
				</td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr>
				<td class="label"><label for="admin_email"><strong>Email of the site owner:</strong><br />
				<small>This address will appear as the<tt>"From:"</tt> all the email-notification site.</small></label></td>
				<td><input maxlength="100" style="width:200px;" id="admin_email" name="admin_email" value="<?php echo htmlspecialchars($engine->config['admin_email']);?>" /></td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr>
				<td class="label"><label for="abuse_email"><strong>Email service abuse:</strong><br />
				<small>Address requests for urgent matters: registration for a foreign email, etc. It may coincide with the previous.</small></label></td>
				<td><input maxlength="100" style="width:200px;" id="abuse_email" name="abuse_email" value="<?php echo htmlspecialchars($engine->config['abuse_email']);?>" /></td>
			</tr>
			<tr>
			<tr>
			<tr>
				<th colspan="2">
					<br />
					SMTP Settings
				</th>
			</tr>
			<tr>
				<td class="label"><label for="smtp_host"><strong>SMTP server address:</strong></label></td>
				<td><input maxlength="50" style="width:200px;" id="smtp_host" name="smtp_host" value="<?php echo htmlspecialchars($engine->config['smtp_host']);?>" /></td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr>
				<td class="label"><label for="smtp_port"><strong>SMTP server port:</strong><br />
				<small>Only change this if you know your SMTP server is on a different port. (default 25 or 587)</small></label></td>
				<td><input maxlength="5" style="width:200px;" id="smtp_port" name="smtp_port" value="<?php echo htmlspecialchars($engine->config['smtp_port']);?>" /></td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr>
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
			<tr>
				<td class="label"><label for="smtp_username"><strong>SMTP username:</strong><br />
				<small>Only enter a username if your SMTP server requires it.</small></label></td>
				<td>
					<input maxlength="255" style="width:200px;" id="smtp_username" name="smtp_username" value="<?php echo htmlspecialchars($engine->config['smtp_username']);?>" />
				</td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr>
				<td class="label"><label for="smtp_password"><strong>SMTP password:</strong><br />
				<small>Only enter a password if your SMTP server requires it.<br />
				<b>Warning:</b> <em>This password will be stored as plain text in the database, visible to everybody who can access your database or who can view this configuration page.</em></small></label></td>
				<td>
					<input maxlength="255" style="width:200px;" id="smtp_password" name="smtp_password" value="<?php echo htmlspecialchars($engine->config['smtp_password']);?>" />
				</td>
			</tr>

		</table>
		<br />
		<div class="center">
			<input id="submit" type="submit" value="save" />
			<input id="button" type="reset" value="reset" />
		</div>
	</form>
<?php
}

?>