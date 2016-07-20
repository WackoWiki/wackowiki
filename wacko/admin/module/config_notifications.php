<?php

if (!defined('IN_WACKO'))
{
	exit;
}

########################################################
##   Notifications settings                           ##
########################################################

$module['config_notifications'] = array(
		'order'	=> 271,
		'cat'	=> 'Preferences',
		'status'=> (RECOVERY_MODE ? false : true),
		'mode'	=> 'config_notifications',
		'name'	=> 'Notifications',
		'title'	=> 'Notifications settings',
	);

########################################################

function admin_config_notifications(&$engine, &$module)
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
		$config['enable_email_notification']	= (int)$_POST['enable_email_notification'];
		$config['notify_minor_edit']			= (int)$_POST['notify_minor_edit'];
		$config['notify_page']					= (int)$_POST['notify_page'];
		$config['notify_comment']				= (int)$_POST['notify_comment'];
		$config['notify_new_user_account']		= (int)$_POST['notify_new_user_account'];

		$engine->config->_set($config);

		$engine->log(1, '!!Updated security settings!!');
		$engine->set_message('Updated security settings', 'success');
		$engine->redirect(rawurldecode($engine->href()));
	}

	echo $engine->form_open('notifications');
?>
		<input type="hidden" name="action" value="update" />
		<table class="formation">
			<tr>
				<th colspan="2">Basic parameters</th>
			</tr>
			<tr class="hl_setting">
				<td class="label">
					<label for="enable_email_notification"><strong>Email Notification:</strong><br />
					<small>Allow email notification. Set to ON to enable email notifications, OFF to disable them. Note that
						disabling email notifications has no effect on emails generated as part
						of the user signup process.</small></label>
				</td>
				<td style="width:40%;">
					<input type="radio" id="enable_email_notification_on" name="enable_email_notification" value="1"<?php echo ( $engine->config['enable_email_notification'] == 1 ? ' checked="checked"' : '' );?> /><label for="enable_email_notification_on">Enabled.</label>
					<input type="radio" id="enable_email_notification_off" name="enable_email_notification" value="0"<?php echo ( $engine->config['enable_email_notification'] == 0 ? ' checked="checked"' : '' );?> /><label for="enable_email_notification_off">Disabled.</label>
				</td>
			</tr>
			<tr>
				<th colspan="2">
					<br />
					Default user notification settings
				</th>
			</tr>
			<tr class="hl_setting">
				<td class="label">
					<label for="notify_page"><strong>Notify page edit:</strong><br />
					<small>Pending - Sending a email notification only for the first change until the user visits the page again.</small></label>
				</td>
				<td>
					<input type="radio" id="notify_page0" name="notify_page" value="0"<?php echo ( $engine->config['notify_page'] == 0 ? ' checked="checked"' : '' );?> /><label for="notify_page0"><?php echo $engine->_t('NotifyOff'); ?></label>
					<input type="radio" id="notify_page1" name="notify_page" value="1"<?php echo ( $engine->config['notify_page'] == 1 ? ' checked="checked"' : '' );?> /><label for="notify_page1"><?php echo $engine->_t('NotifyAlways'); ?></label>
					<input type="radio" id="notify_page2" name="notify_page" value="2"<?php echo ( $engine->config['notify_page'] == 2 ? ' checked="checked"' : '' );?> /><label for="notify_page2"><?php echo $engine->_t('NotifyPending'); ?></label>
				</td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl_setting">
				<td class="label">
					<label for="notify_minor_edit"><strong>Notify minor edit:</strong><br />
					<small>Sends notifications also for minor edits.</small></label>
				</td>
				<td>
					<input type="checkbox" id="notify_minor_edit" name="notify_minor_edit" value="1"<?php echo ( $engine->config['notify_minor_edit'] ? ' checked="checked"' : '' );?> />
				</td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl_setting">
				<td class="label">
					<label for="notify_comment"><strong>Notify new comment:</strong><br />
					<small>Pending - Sending a email notification only for the first comment until the user visits the page again.</small></label>
				</td>
				<td>
					<input type="radio" id="notify_comment0" name="notify_comment" value="0"<?php echo ( $engine->config['notify_comment'] == 0 ? ' checked="checked"' : '' );?> /><label for="notify_comment0"><?php echo $engine->_t('NotifyOff'); ?></label>
					<input type="radio" id="notify_comment1" name="notify_comment" value="1"<?php echo ( $engine->config['notify_comment'] == 1 ? ' checked="checked"' : '' );?> /><label for="notify_comment1"><?php echo $engine->_t('NotifyAlways'); ?></label>
					<input type="radio" id="notify_comment2" name="notify_comment" value="2"<?php echo ( $engine->config['notify_comment'] == 2 ? ' checked="checked"' : '' );?> /><label for="notify_comment2"><?php echo $engine->_t('NotifyPending'); ?></label>
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
					<label for="notify_new_user_account"><strong>Notify new user account:</strong><br />
					<small>The Admin will to be notified when a new user has been created using the "signup form".</small></label>
				</td>
				<td>
					<input type="checkbox" id="notify_new_user_account" name="notify_new_user_account" value="1"<?php echo ( $engine->config['notify_new_user_account'] ? ' checked="checked"' : '' );?> />
				</td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
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
