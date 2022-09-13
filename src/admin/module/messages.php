<?php

if (!defined('IN_WACKO'))
{
	exit;
}

##########################################################
##	Messages settings									##
##########################################################

$module['messages'] = [
		'order'	=> 701,
		'cat'	=> 'messages',
		'status'=> !RECOVERY_MODE,
	];

##########################################################

function admin_messages(&$engine, $module)
{
?>
	<h1><?php echo $engine->_t($module)['title']; ?></h1>
	<br>
	<p>
		<?php echo $engine->_t('SystemMessageInfo');?>
	</p>
	<br>
<?php
	$action = $_POST['_action'] ?? null;

	// update settings
	if ($action == 'messages')
	{
		$config['system_message']			= (string) $_POST['system_message'];
		$config['system_message']			= $engine->format($config['system_message'], 'wiki');
		$config['system_message_type']		= (string) $_POST['system_message_type'];
		$config['enable_system_message']	= (int) $_POST['enable_system_message'];

		$engine->config->_set($config);

		$engine->log(1, $engine->_t('SysMsgUpdated', SYSTEM_LANG));
		$engine->set_message($engine->_t('SysMsgUpdated'), 'success');
		$engine->http->redirect($engine->href());
	}

	echo $engine->form_open('messages');
?>
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
					<label for="system_message"><strong><?php echo $engine->_t('SysMsg');?></strong><br>
					<small><?php echo $engine->_t('SysMsgInfo');?></small></label>
				</td>
				<td>
					<textarea style="width:500px; height:200px;" id="system_message" name="system_message"><?php echo Ut::html($engine->db->system_message);?></textarea>
				</td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl-setting">
				<td class="label">
					<label for="system_message_type"><strong><?php echo $engine->_t('SysMsgType');?></strong><br>
					<small><?php echo $engine->_t('SysMsgTypeInfo');?></small></label>
				</td>
				<td>
					<select id="system_message_type" name="system_message_type">
<?php
						$typs = ['note', 'warning', 'marquee'];

						foreach ($typs as $type)
						{
							echo '<option value="' . $type . '" ' . ($engine->db->system_message_type == $type ? 'selected' : '') . '>' . $type . '</option>';
						}

						// TODO:
						// add option: Position (header, footer, ..)
						// add option: allow users to dissmis the message
?>
					</select>
				</td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl-setting">
				<td class="label">
					<strong><?php echo $engine->_t('EnableSysMsg');?></strong><br>
					<small><?php echo $engine->_t('EnableSysMsgInfo');?></small></td>
				<td>
					<input type="radio" id="sys_message_on" name="enable_system_message" value="1"<?php echo ($engine->db->enable_system_message == 1 ? ' checked' : '');?>><label for="sys_message_on"><?php echo $engine->_t('On');?></label>
					<input type="radio" id="sys_message_off" name="enable_system_message" value="0"<?php echo ($engine->db->enable_system_message == 0 ? ' checked' : '');?>><label for="sys_message_off"><?php echo $engine->_t('Off');?></label>
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

