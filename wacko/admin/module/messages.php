<?php

if (!defined('IN_WACKO'))
{
	exit;
}

########################################################
##   Messages settings                                ##
########################################################

$module['messages'] = array(
		'order'	=> 710,
		'cat'	=> 'Messages',
		'status'=> (RECOVERY_MODE ? false : true),
		'mode'	=> 'messages',
		'name'	=> 'System message',
		'title'	=> 'System messages',
	);

########################################################

function admin_messages(&$engine, &$module)
{
?>
	<h1><?php echo $module['title']; ?></h1>
	<br />
<?php
	// update settings
	if (isset($_POST['action']) && $_POST['action'] == 'update')
	{
		$config['system_message']			= (string)$_POST['system_message'];

		$config['system_message'] = $engine->format($config['system_message'], 'wiki');

		$config['system_message_type']		= (string)$_POST['system_message_type'];

		$engine->config->_set($config);

		$engine->log(1, 'Updated system message');
		$engine->set_message('Updated system message', 'success');
		$engine->redirect(rawurldecode($engine->href()));
	}

	echo $engine->form_open('messages', '', 'post', true, '', '');
?>
		<input type="hidden" name="action" value="update" />
		<table class="formation">
			<tr>
				<th colspan="2">System message</th>
			</tr>
			<tr class="hl_setting">
				<td class="label"  style="vertical-align:top;"><label for="system_message"><strong>System message:</strong><br />
					<small>Your text here</small></label></td>
				<td  style="width:40%;"><textarea style="font-size:12px; letter-spacing:normal; width:200px; height:100px;" id="system_message" name="system_message"><?php echo htmlspecialchars($engine->config['system_message'], ENT_COMPAT | ENT_HTML401, HTML_ENTITIES_CHARSET);?></textarea></td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl_setting">
				<td class="label"><label for="system_message_type"><strong>Type:</strong><br />
					<small>Message type (CSS).</small></label></td>
				<td>
					<select style="width:200px;" id="system_message_type" name="system_message_type">
<?php
						$typs = array('info', 'warning', 'marquee');

						foreach ($typs as $type)
						{
							echo '<option value="'.$type.'" '.($engine->config['system_message_type'] == $type ? 'selected="selected"' : '').'>'.$type.'</option>';
						}
?>
					</select>
				</td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl_setting">
				<td class="label"><strong>Themes per page:</strong><br />
					<small>Allow themes per page, which the page owner can choose via page properties.</small></td>
				<td>
					<input type="radio" id="themes_per_page_on" name="themes_per_page" value="1"<?php echo ( $engine->config['allow_themes_per_page'] == 1 ? ' checked="checked"' : '' );?> /><label for="themes_per_page_on">On.</label>
					<input type="radio" id="themes_per_page_off" name="themes_per_page" value="0"<?php echo ( $engine->config['allow_themes_per_page'] == 0 ? ' checked="checked"' : '' );?> /><label for="themes_per_page_off">Off.</label>
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
