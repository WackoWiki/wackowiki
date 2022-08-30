<?php

if (!defined('IN_WACKO'))
{
	exit;
}

##########################################################
##	Filter settings										##
##########################################################

$module['config_filter'] = [
		'order'	=> 207,
		'cat'	=> 'preferences',
		'status'=> !RECOVERY_MODE,
	];

##########################################################

function admin_config_filter(&$engine, $module)
{
	/*
	TODO:
	1) use word table to add row 'set'
	2) add option to choose action: block, replace, moderate
	3) add option to switch between antispam.conf file and word table
	4) add option to select where the filter is applied: edit, tags, registration, referrers
	*/
?>
	<h1><?php echo $engine->_t($module)['title']; ?></h1>
	<br>
	<p>
		<?php echo $engine->_t('FilterSettingsInfo');?>
	</p>
	<br>
<?php
	$file_name = Ut::join_path(CONFIG_DIR, 'antispam.conf');
	// update settings
	if (isset($_POST['action']) && $_POST['action'] == 'update')
	{
		// update secondary config
		$config['spam_filter']					= (string) $_POST['spam_filter'];
		#$config['spam_action']					= (string) $_POST['spam_action'];

		$engine->config->_set($config);

		// write antispam.conf file
		$phrase_list	= (string) $_POST['phrase_list'];
		file_put_contents($file_name, $phrase_list);
		chmod($file_name, CHMOD_FILE);

		$engine->log(1, '!!' . $engine->_t('FilterSettingsUpdated', SYSTEM_LANG) . '!!');
		$engine->set_message($engine->_t('FilterSettingsUpdated'), 'success');
		$engine->http->redirect($engine->href());
	}

	$phrases = file_get_contents($file_name);

	echo $engine->form_open('filter');
?>
		<input type="hidden" name="action" value="update">
		<table class="setting formation">
			<colgroup>
				<col span="1">
				<col span="1">
			</colgroup>
			<tr>
				<th colspan="2"><?php echo $engine->_t('WordCensoringSection');?></th>
			</tr>
			<tr class="hl-setting">
				<td class="label">
					<label for="spam_filter"><strong><?php echo $engine->_t('SPAMFilter');?></strong><br>
					<small><?php echo $engine->_t('SPAMFilterInfo');?></small></label>
				</td>
				<td>
					<input type="radio" id="spam_filter_on" name="spam_filter" value="1"<?php echo ($engine->db->spam_filter == 1 ? ' checked' : '');?>><label for="spam_filter_on"><?php echo $engine->_t('Enabled'); ?></label>
					<input type="radio" id="spam_filter_off" name="spam_filter" value="0"<?php echo ($engine->db->spam_filter == 0 ? ' checked' : '');?>><label for="spam_filter_off"><?php echo $engine->_t('Disabled'); ?></label>
				</td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl-setting">
				<td class="label">
					<label for="phrase_list"><strong><?php echo $engine->_t('WordList');?></strong><br>
					<small><?php echo $engine->_t('WordListInfo');?></small></label>
				</td>
				<td>
					<textarea style="width:400px; height:400px;" id="phrase_list" name="phrase_list"><?php echo Ut::html($phrases);?></textarea>
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