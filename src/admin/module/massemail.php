<?php

if (!defined('IN_WACKO'))
{
	exit;
}

##########################################################
##	Messages settings									##
##########################################################

$module['massemail'] = [
		'order'	=> 700,
		'cat'	=> 'messages',
		'status'=> !RECOVERY_MODE,
	];

##########################################################

function admin_massemail(&$engine, $module)
{
	$prefix		= $engine->prefix;
?>
	<h1><?php echo $engine->_t($module)['title']; ?></h1>
	<br>
	<p>
		<?php echo $engine->_t('MassemailInfo');?>
	</p>
	<br>
	<?php
	$mail_subject	= (string) ($_POST['mail_subject'] ?? '');
	$mail_body		= (string) ($_POST['mail_body'] ?? '');
	$error			= false;

	// send massmail
	if (isset($_POST['action']) && $_POST['action'] == 'update')
	{
		$group_id		= (int) $_POST['group_id'];
		$user_ids		= [];

		if (isset($_POST['user_id']))
		{
			foreach ($_POST['user_id'] as $user_id)
			{
				$user_ids[] = (int) $user_id;
			}
		}
		else
		{
			$engine->show_message($engine->_t('NoEmailRecipient'), 'error');
		}

		if (empty($mail_subject))
		{
			$engine->set_message($engine->_t('NoEmailSubject'), 'error');
			$error = true;
		}
		else if (empty($mail_body))
		{
			$engine->set_message($engine->_t('NoEmailMessage'), 'error');
			$error = true;
		}

		if ($error)
		{
			$engine->http->redirect($engine->href());
		}

		//  remove all markup before sending
		$mail_body = strip_tags ($mail_body);

		$members = $engine->db->load_all(
			"SELECT DISTINCT
				gm.user_id,
				u.user_name,
				u.email,
				us.user_lang,
				u.enabled,
				u.email_confirm,
				us.allow_massemail
			FROM
				" . $prefix . "user u
					INNER JOIN " . $prefix . "usergroup_member gm
						ON (u.user_id = gm.user_id)
					INNER JOIN " . $prefix . "user_setting us
						ON (u.user_id = us.user_id)
			WHERE
				u.account_type = 0
					AND (gm.group_id = " . (int) $group_id . "
					OR u.user_id IN (" . $engine->ids_string($user_ids) . "))",
				true);

		if ($members)
		{
			foreach ($members as $user)
			{
				if ($engine->db->enable_email
					&& $engine->db->enable_email_notification
					&& $user['enabled']
					&& $user['email_confirm'] == ''
					&& $user['allow_massemail'])
				{
					$subject	= $mail_subject;
					$body		= $mail_body . "\n";

					$engine->send_user_email($user, $subject, $body);
				}
			}

			$engine->log(2, 'Massemail send: ' . $mail_subject . ' to group / user ' . $group_id);
			$engine->set_message($engine->_t('MassemailSend') . ': ' . $mail_subject, 'success');

			$engine->http->redirect($engine->href());
		}
		else
		{
			// no results / members
		}
	}

	$available_groups = $engine->db->load_all(
		"SELECT group_id, group_name " .
		"FROM " . $prefix . "usergroup " .
		"WHERE active = 1 " .
		"ORDER BY BINARY group_name", true);

	#Ut::debug_print_r($available_users);

	echo $engine->form_open('massemail');
?>
	<input type="hidden" name="action" value="update">
	<table class="setting formation">
		<colgroup>
			<col span="1">
			<col span="1">
		</colgroup>
		<tr>
			<th colspan="2"><?php echo $engine->_t('SysMsgSection');?></th>
		</tr>
		<tr class="hl-setting">
			<td class="label">
				<label for="user_id"><strong><?php echo $engine->_t('SendToUser'); ?></strong><br>
					<small><?php echo $engine->_t('SendToUserInfo');?></small></label>
			</td>
			<td>
				<select id="user_id" name="user_id[]" multiple size="8">
					<option value="">[<?php echo $engine->_t('NoUser');?>]</option>
<?php
			$users = $engine->db->load_all(
				"SELECT u.user_id, u.user_name, u.email_confirm, us.user_lang, us.allow_massemail " .
				"FROM " . $prefix . "user u " .
					"INNER JOIN " . $prefix . "user_setting us ON (u.user_id = us.user_id) " .
				"WHERE u.enabled = 1 " .
					"AND u.email_confirm = '' " .
					"AND us.allow_massemail <> 0 " .
				"ORDER BY BINARY u.user_name");

			if ($users)
			{
				foreach ($users as $user)
				{
					echo '<option value="' . $user['user_id'] . '">' . Ut::html($user['user_name']) . "</option>\n";
				}
			}
?>
				</select>
			</td>
		</tr>
		<tr class="lined">
			<td colspan="2"></td>
		</tr>
<?php
	echo '<tr class="hl-setting">
			<td class="label">
				<label for="group_id"><strong>' . $engine->_t('SendToGroup') . '</strong></label>
			</td>' .
			'<td>
				<select id="group_id" name="group_id">
					<option value="">[' . $engine->_t('NoUserGroup') . ']</option>';

			if ($available_groups)
			{
				foreach ($available_groups as $group)
				{
					echo '<option value="' . $group['group_id'] . '">' . Ut::html($group['group_name']) . "</option>\n";
				}
			}

			echo '</select>';
			?>
				</td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl-setting">
				<td class="label">
					<label for="mail_subject"><strong><?php echo $engine->_t('MessageSubject'); ?></strong><br>
					<small><?php echo $engine->_t('MessageSubjectInfo');?></small></label></td>
				</td>
				<td>
					<input type="text" id="mail_subject" name="mail_subject" value="<?php echo Ut::html($mail_subject); ?>" size="60" maxlength="200"  required>
				</td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl-setting">
				<td class="label"><label for="mail_body"><strong><?php echo $engine->_t('YourMessage');?></strong><br>
					<small><?php echo $engine->_t('YourMessageInfo');?></small></label></td>
				<td><textarea style="width:500px; height:200px;" id="mail_body" name="mail_body" required><?php echo Ut::html($mail_body);?></textarea></td>
			</tr>
		</table>
		<br>
		<div class="center">
			<button type="submit" id="submit"><?php echo $engine->_t('SendButton');?></button>
			<button type="reset" id="button"><?php echo $engine->_t('ResetButton');?></button>
		</div>
<?php
	echo $engine->form_close();
}
