<?php

if (!defined('IN_WACKO'))
{
	exit;
}

########################################################
##   Messages settings                                ##
########################################################

$module['massemail'] = array(
		'order'	=> 700,
		'cat'	=> 'Messages',
		'status'=> (RECOVERY_MODE ? false : true),
		'mode'	=> 'massemail',
		'name'	=> 'Mass email',
		'title'	=> 'Mass email',
	);

########################################################

function admin_massemail(&$engine, &$module)
{
?>
	<h1><?php echo $module['title']; ?></h1>
	<br />
	<p>
		Here you can email a message to either all of your users or all users of a specific group having the option to receive mass emails enabled. To achieve this an email will be sent out to the administrative email address supplied, with a blind carbon copy sent to all recipients. The default setting is to only include 20 recipients in such an email, for more recipients more emails will be sent. If you are emailing a large group of people please be patient after submitting and do not stop the page halfway through. It is normal for a mass emailing to take a long time, you will be notified when the script has completed.</td>
	</p>
	<br />
<?php
$mail_body = '';

	// update settings
	if (isset($_POST['action']) && $_POST['action'] == 'update')
	{
		$group_id				= (int)$_POST['group_id'];
		$user_id				= (int)$_POST['user_id'];
		$mail_subject			= (string)$_POST['mail_subject'];
		$mail_body				= (string)$_POST['mail_body'];
		$language				= (string)$_POST['language'];

		#$engine->config->_set($config);

		$members = $engine->db->load_all(
			"SELECT DISTINCT
				gm.user_id,
				u.user_name,
				u.email,
				u.enabled,
				u.email_confirm,
				us.allow_massemail
			FROM
				{$engine->config['table_prefix']}user u
					INNER JOIN {$engine->config['table_prefix']}usergroup_member gm
						ON u.user_id = gm.user_id
					INNER JOIN {$engine->config['table_prefix']}user_setting us
						ON u.user_id = us.user_id
			WHERE
				gm.group_id = '{$group_id}'
					OR u.user_id = '{$user_id}' ",
				true);

		foreach ($members as $user)
		{
			if ($engine->config['enable_email'] == true && $engine->config['enable_email_notification'] == true && $user['enabled'] == true && $user['email_confirm'] == '' && $user['allow_massemail'] != 0)
			{
				$subject	= '['.$engine->config['site_name'].'] '.$mail_subject;
				$body		= $engine->_t('EmailHello').' '.$user['user_name'].",\n\n".

							$mail_body."\n\n\n".

							$engine->_t('EmailDoNotReply')."\n\n".
							$engine->_t('EmailGoodbye')."\n".
							$engine->config['site_name']."\n".
							$engine->config['base_url'];

				$engine->send_mail($user['email'], $subject, $body);
			}
		}

		$engine->log(1, 'Messemail send: '.$mail_subject.' to group / user '. $group_id);
		$engine->set_message('Massemail send: '.$mail_subject, 'success');

		#$engine->redirect(rawurldecode($engine->href()));
	}

	$available_groups = $engine->db->load_all(
			"SELECT group_id, group_name ".
			"FROM {$engine->config['table_prefix']}usergroup ".
			"WHERE active = '1' ".
			"ORDER BY BINARY group_name", true);

	#$engine->debug_print_r($available_users);

	echo $engine->form_open('massemail');
?>
		<input type="hidden" name="action" value="update" />
		<table class="formation">

		<tr class="hl_setting">
			<td class="label">
				<label for="user_id"><strong><?php echo $engine->_t('SendToUser'); ?></strong></label>
			</td>
			<td>
				<select id="nuser_id" name="user_id">
					<option value=""></option>
<?php
			if ($users = $engine->load_users())
			{
				foreach($users as $user)
				{
					echo '<option value="'.$user['user_id'].'">'.htmlspecialchars($user['user_name'])."</option>\n";
				}
			}
?>
				</select>
			</td>
		</tr>
<?php
	echo '<tr class="hl_setting">
			<td class="label">
				<label for="group_id"><strong>'.$engine->_t('SendToGroup').':</strong></label>
			</td>'.
			'<td>
				<select id="group_id" name="group_id">
					<option value=""></option>';

			if ($available_groups)
			{
				foreach($available_groups as $group)
				{
					echo '<option value="'.$group['group_id'].'">'.htmlspecialchars($group['group_name'], ENT_COMPAT | ENT_HTML401, HTML_ENTITIES_CHARSET)."</option>\n";
				}
			}

			echo '</select>';
			?>
			</td></tr>
			<tr class="hl_setting">
				<td class="label"><strong><?php echo $engine->_t('UsersIntercomSubject'); ?>:</strong><br />
					<small>Allow themes per page, which the page owner can choose via page properties.</small></td>
				</td>
				<td>
					<input type="text" name="mail_subject" value="<?php echo (isset($_POST['mail_subject']) ? htmlspecialchars($_POST['mail_subject'], ENT_COMPAT | ENT_HTML401, HTML_ENTITIES_CHARSET) : ""); ?>" size="60" maxlength="200"  required />
				</td></tr>

			<tr class="hl_setting">
				<td class="label"  style="vertical-align:top;"><label for="mail_body"><strong>Your message:</strong><br />
					<small>Please note that you may enter only plain text. All markup will be removed before sending.</small></label></td>
				<td  style="width:40%;"><textarea style="font-size:12px; letter-spacing:normal; width:200px; height:100px;" id="mail_body" name="mail_body"  required><?php echo htmlspecialchars($mail_body, ENT_COMPAT | ENT_HTML401, HTML_ENTITIES_CHARSET);?></textarea></td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl_setting">
				<td class="label"><label for="language"><strong>Default language:</strong><br />
					<small>Specifies the language for mapping unregistered guests, as well as the locale settings and the rules of transliteration of addresses of pages.</small></label></td>
				<td>
					<select style="width:200px;" id="language" name="language">
<?php
						$languages	= $engine->_t('LanguageArray');
						$langs		= $engine->available_languages();

						foreach ($langs as $lang)
						{
							echo '<option value="'.$lang.'" '.($engine->config['language'] == $lang ? 'selected="selected"' : '').'>'.$languages[$lang].' ('.$lang.')</option>';
						}
?>
					</select>
				</td>
			</tr>
		</table>
		<br />
		<div class="center">
			<input type="submit" id="submit" value="send" />
			<input type="reset" id="button" value="reset" />
		</div>
<?php
	echo $engine->form_close();
}

?>
