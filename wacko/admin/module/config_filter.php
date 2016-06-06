<?php

if (!defined('IN_WACKO'))
{
	exit;
}

########################################################
##   Filter settings                                  ##
########################################################

$module['config_filter'] = array(
		'order'	=> 250,
		'cat'	=> 'Preferences',
		'status'=> (RECOVERY_MODE ? false : true),
		'mode'	=> 'config_filter',
		'name'	=> 'Filter',
		'title'	=> 'Filter settings',
	);

########################################################

function admin_config_filter(&$engine, &$module)
{
	/*
	TODO:
	1) use word table to add row 'set'
	2) add option to choose action: block, replace, moderate
	3) add option to switch between antispam.conf file and word table
	4) add option to select where the filter is applied: edit, tags, registration, referrers
	*/
?>
	<h1><?php echo $module['title']; ?></h1>
	<br />
	<p>
		Words that will be automatically censored on your Wiki.
	</p>
	<br />
<?php
	// update settings
	if (isset($_POST['action']) && $_POST['action'] == 'update')
	{
		// check form token
		if (!$engine->validate_form_token('filter'))
		{
			$message = $engine->get_translation('FormInvalid');
			$engine->set_message($message, 'error');
		}
		else
		{
			// update secondary config
			$config['spam_filter']					= (string)$_POST['spam_filter'];
			#$config['spam_action']					= (string)$_POST['spam_action'];

			$engine->_set_config($config, '', true);

			// write antispam.conf file
			$phrase_list	= (string)$_POST['phrase_list'];
			$file_name		= 'config/antispam.conf';
			file_put_contents($file_name, $phrase_list);
			chmod($file_name, 0644);

			$engine->log(1, '!!Updated spam filter settings!!');
			$engine->set_message('Updated spam filter settings');
			$engine->redirect(rawurldecode($engine->href()));
		}
	}

	$phrases = implode('', file('config/antispam.conf', 1));

	echo $engine->form_open('filter', '', 'post', true, '', '');
?>
		<input type="hidden" name="action" value="update" />
		<table class="formation">
			<tr>
				<th colspan="2">Word censoring</th>
			</tr>
			<tr class="hl_setting">
				<td class="label">
					<label for="spam_filter"><strong>SPAM Filter:</strong><br />
					<small>Enabling SPAM Filter</small></label>
				</td>
				<td style="width:40%;">
					<input type="radio" id="spam_filter_on" name="spam_filter" value="1"<?php echo ( $engine->config['spam_filter'] == 1 ? ' checked="checked"' : '' );?> /><label for="spam_filter_on">Enabled.</label>
					<input type="radio" id="spam_filter_off" name="spam_filter" value="0"<?php echo ( $engine->config['spam_filter'] == 0 ? ' checked="checked"' : '' );?> /><label for="spam_filter_off">Disabled.</label>
				</td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl_setting">
				<td class="label"  style="vertical-align:top;"><label for="phrase_list"><strong>Word list:</strong><br />
					<small>Word or phrase <code>fragment</code> to be blacklisted (one per line)</small></label></td>
				<td><textarea style="font-size:12px; letter-spacing:normal; width:400px; height:400px;" id="phrase_list" name="phrase_list"><?php echo htmlspecialchars($phrases, ENT_COMPAT | ENT_HTML401, HTML_ENTITIES_CHARSET);?></textarea></td>
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