<?php

if (!defined('IN_WACKO'))
{
	exit;
}

##########################################################
##	Notifications settings								##
##########################################################
$_mode = 'config_notifications';

$module[$_mode] = [
		'order'	=> 271,
		'cat'	=> 'preferences',
		'status'=> (RECOVERY_MODE ? false : true),
		'mode'	=> $_mode,
		'name'	=> $engine->_t($_mode)['name'],		// Notifications
		'title'	=> $engine->_t($_mode)['title'],	// Notifications settings
	];

##########################################################

function admin_config_notifications(&$engine, &$module)
{
?>
	<h1><?php echo $module['title']; ?></h1>
	<br>
	<p>
		<?php echo $engine->_t('NotificationSettingsInfo');?>
	</p>
	<br>
<?php
	// update settings
	if (isset($_POST['action']) && $_POST['action'] == 'update')
	{
		$config['enable_email_notification']	= (int) $_POST['enable_email_notification'];
		$config['disable_autosubscribe']		= (int) $_POST['disable_autosubscribe'];
		$config['notify_diff_mode']				= (int) $_POST['notify_diff_mode'];
		$config['notify_minor_edit']			= (int) ($_POST['notify_minor_edit'] ?? 0);
		$config['notify_page']					= (int) $_POST['notify_page'];
		$config['notify_comment']				= (int) $_POST['notify_comment'];
		$config['notify_upload']				= (int) $_POST['notify_upload'];
		$config['notify_new_user_account']		= (int) ($_POST['notify_new_user_account'] ?? 0);
		$config['allow_intercom']				= (int) $_POST['allow_intercom'];
		$config['allow_massemail']				= (int) $_POST['allow_massemail'];

		$engine->config->_set($config);

		$engine->log(1, '!!' . $engine->_t('NotificationSettingsUpdated', SYSTEM_LANG)  . '!!');
		$engine->set_message($engine->_t('NotificationSettingsUpdated'), 'success');
		$engine->http->redirect(rawurldecode($engine->href()));
	}

	echo $engine->form_open('notifications');
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
			<tr class="hl_setting">
				<td class="label">
					<label for="enable_email_notification"><strong><?php echo $engine->_t('EmailNotification');?>:</strong><br>
					<small><?php echo $engine->_t('EmailNotificationInfo');?></small></label>
				</td>
				<td>
					<input type="radio" id="enable_email_notification_on" name="enable_email_notification" value="1"<?php echo ($engine->db->enable_email_notification == 1 ? ' checked' : '');?>><label for="enable_email_notification_on"><?php echo $engine->_t('Enabled'); ?></label>
					<input type="radio" id="enable_email_notification_off" name="enable_email_notification" value="0"<?php echo ($engine->db->enable_email_notification == 0 ? ' checked' : '');?>><label for="enable_email_notification_off"><?php echo $engine->_t('Disabled'); ?></label>
				</td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl_setting">
				<td class="label">
					<label for=""><strong><?php echo $engine->_t('Autosubscribe');?>:</strong><br>
					<small><?php echo $engine->_t('AutosubscribeInfo');?></small></label>
				</td>
				<td>
					<input type="radio" id="disable_autosubscribe_on" name="disable_autosubscribe" value="0"<?php echo (!$engine->db->disable_autosubscribe ? ' checked' : '');?>><label for="disable_autosubscribe_on"><?php echo $engine->_t('On');?></label>
					<input type="radio" id="disable_autosubscribe_off" name="disable_autosubscribe" value="1"<?php echo ($engine->db->disable_autosubscribe ? ' checked' : '');?>><label for="disable_autosubscribe_off"><?php echo $engine->_t('Off');?></label>
				</td>
			</tr>
			<tr>
				<th colspan="2">
					<br>
					<?php echo $engine->_t('NotificationSection');?>
				</th>
			</tr>
			<tr class="hl_setting">
				<td class="label">
					<label for="notify_page"><strong><?php echo $engine->_t('NotifyPageEdit');?>:</strong><br>
					<small><?php echo $engine->_t('NotifyPageEditInfo');?></small></label>
				</td>
				<td>
					<input type="radio" id="notify_page0" name="notify_page" value="0"<?php echo ($engine->db->notify_page == 0 ? ' checked' : '');?>><label for="notify_page0"><?php echo $engine->_t('NotifyOff'); ?></label>
					<input type="radio" id="notify_page1" name="notify_page" value="1"<?php echo ($engine->db->notify_page == 1 ? ' checked' : '');?>><label for="notify_page1"><?php echo $engine->_t('NotifyAlways'); ?></label>
					<input type="radio" id="notify_page2" name="notify_page" value="2"<?php echo ($engine->db->notify_page == 2 ? ' checked' : '');?>><label for="notify_page2"><?php echo $engine->_t('NotifyPending'); ?></label>
				</td>
			</tr>
						<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl_setting">
				<td class="label">
					<label for="default_diff_mode"><strong><?php echo $engine->_t('NotifyDiffMode');?>:</strong><br>
					<small><?php echo $engine->_t('NotifyDiffModeInfo');?><br>(Content-Type: text/plain;)</small></label>
				</td>
				<td>
					<select id="notify_diff_mode" name="notify_diff_mode">
					<?php
						/*
						 * Choose only text/plain DiffModes for sending emails
						 *
						 * DiffMode
						 *	0	Full diff
						 *	2	Source			(text/plain)
						 *	3	Side by side
						 *	4	Inline
						 *	5	Unified			(text/plain)
						 *	6	Context			(text/plain)
						 */
						$diff_modes = $engine->_t('DiffMode');

						foreach ($diff_modes as $mode => $diff_mode)
						{
							if (in_array($mode, [2, 5, 6]))
							{
								echo '<option value="' . $mode . '" ' . ( (int) $engine->db->notify_diff_mode == $mode ? 'selected' : '') . '>' . $diff_mode . ' (' . $mode . ')</option>' . "\n";
							}
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
					<label for="notify_minor_edit"><strong><?php echo $engine->_t('NotifyMinorEdit');?>:</strong><br>
					<small><?php echo $engine->_t('NotifyMinorEditInfo');?></small></label>
				</td>
				<td>
					<input type="checkbox" id="notify_minor_edit" name="notify_minor_edit" value="1"<?php echo ($engine->db->notify_minor_edit ? ' checked' : '');?>>
				</td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl_setting">
				<td class="label">
					<label for="notify_comment"><strong><?php echo $engine->_t('NotifyNewComment');?>:</strong><br>
					<small><?php echo $engine->_t('NotifyNewCommentInfo');?></small></label>
				</td>
				<td>
					<input type="radio" id="notify_comment0" name="notify_comment" value="0"<?php echo ($engine->db->notify_comment == 0 ? ' checked' : '');?>><label for="notify_comment0"><?php echo $engine->_t('NotifyOff'); ?></label>
					<input type="radio" id="notify_comment1" name="notify_comment" value="1"<?php echo ($engine->db->notify_comment == 1 ? ' checked' : '');?>><label for="notify_comment1"><?php echo $engine->_t('NotifyAlways'); ?></label>
					<input type="radio" id="notify_comment2" name="notify_comment" value="2"<?php echo ($engine->db->notify_comment == 2 ? ' checked' : '');?>><label for="notify_comment2"><?php echo $engine->_t('NotifyPending'); ?></label>
				</td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl_setting">
				<td class="label">
					<label for="allow_intercom"><strong><?php echo $engine->_t('AllowIntercomDefault');?>:</strong><br>
					<small><?php echo $engine->_t('AllowIntercom');?></small></label>
				</td>
				<td>
					<input type="radio" id="allow_intercom_on" name="allow_intercom" value="0"<?php echo (!$engine->db->allow_intercom ? ' checked' : '');?>><label for="allow_intercom_on"><?php echo $engine->_t('On');?></label>
					<input type="radio" id="allow_intercom_off" name="allow_intercom" value="1"<?php echo ($engine->db->allow_intercom ? ' checked' : '');?>><label for="allow_intercom_off"><?php echo $engine->_t('Off');?></label>
				</td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl_setting">
				<td class="label">
					<label for="allow_massemail"><strong><?php echo $engine->_t('AllowMassemailDefault');?>:</strong><br>
					<small><?php echo $engine->_t('AllowMassemailDefaultInfo');?></small></label>
				</td>
				<td>
					<input type="radio" id="allow_massemail_on" name="allow_massemail" value="0"<?php echo (!$engine->db->allow_massemail ? ' checked' : '');?>><label for="allow_massemail_on"><?php echo $engine->_t('On');?></label>
					<input type="radio" id="allow_massemail_off" name="allow_massemail" value="1"<?php echo ($engine->db->allow_massemail ? ' checked' : '');?>><label for="allow_massemail_off"><?php echo $engine->_t('Off');?></label>
				</td>
			</tr>
			<tr class="hl_setting">
				<th colspan="2">
					<br>
					<?php echo $engine->_t('MiscellaneousSection');?>
				</th>
			</tr>
			<tr class="hl_setting">
				<td class="label">
					<label for="notify_new_user_account"><strong><?php echo $engine->_t('NotifyUserAccount');?>:</strong><br>
					<small><?php echo $engine->_t('NotifyUserAccountInfo');?></small></label>
				</td>
				<td>
					<input type="checkbox" id="notify_new_user_account" name="notify_new_user_account" value="1"<?php echo ($engine->db->notify_new_user_account ? ' checked' : '');?>>
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
