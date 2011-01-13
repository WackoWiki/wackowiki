<?php

########################################################
##   Security settings                                ##
########################################################

$module['configsecurity'] = array(
		'order'	=> 2,
		'cat'	=> 'Preferences',
		'mode'	=> 'configsecurity',
		'name'	=> 'Security',
		'title'	=> 'Security subsystems settings',
	);

########################################################

function admin_configsecurity(&$engine, &$module)
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
		$config['allow_registration']			= (int)$_POST['allow_registration'];
		$config['captcha_new_comment']			= (int)$_POST['captcha_new_comment'];
		$config['captcha_new_page']				= (int)$_POST['captcha_new_page'];
		$config['captcha_edit_page']			= (int)$_POST['captcha_edit_page'];
		$config['captcha_registration']			= (int)$_POST['captcha_registration'];
		$config['session_encrypt_cookie']		= (int)$_POST['session_encrypt_cookie'];
		$config['antidupe']						= (int)$_POST['antidupe'];
		$config['default_read_acl']				= (string)$_POST['default_read_acl'];
		$config['default_write_acl']			= (string)$_POST['default_write_acl'];
		$config['default_comment_acl']			= (string)$_POST['default_comment_acl'];
		$config['default_create_acl']			= (string)$_POST['default_create_acl'];
		$config['default_upload_acl']			= (string)$_POST['default_upload_acl'];
		$config['rename_globalacl']				= (string)$_POST['rename_globalacl'];
		$config['hide_locked']					= (int)$_POST['hide_locked'];
		$config['remove_onlyadmins']			= (int)$_POST['remove_onlyadmins'];
		$config['owners_can_remove_comments']	= (int)$_POST['owners_can_remove_comments'];
		$config['owners_can_change_categories']	= (int)$_POST['owners_can_change_categories'];
		$config['moders_can_edit']				= (int)$_POST['moders_can_edit'];
		$config['tls']							= (int)$_POST['tls'];
		$config['tls_implicit']					= (int)$_POST['tls_implicit'];
		$config['tls_proxy']					= trim((string)$_POST['tls_proxy']);
		$config['pwd_min_chars']				= (int)$_POST['pwd_min_chars'];
		$config['pwd_char_classes']				= (int)$_POST['pwd_char_classes'];
		$config['pwd_unlike_login']				= (int)$_POST['pwd_unlike_login'];
		$config['log_level']					= (int)$_POST['log_level'];
		$config['log_default_show']				= (int)$_POST['log_default_show'];
		$config['log_purge_time']				= (int)$_POST['log_purge_time'];
		$config['session_expiration']			= (int)$_POST['session_expiration'];
		$config['comment_delay']				= (int)$_POST['comment_delay'];
		$config['intercom_delay']				= (int)$_POST['intercom_delay'];

		foreach($config as $key => $value)
		{
			$engine->query(
				"UPDATE {$engine->config['table_prefix']}config SET value = '$value' WHERE config_name = '$key'");
		}
		$engine->log(1, '!!Updated security settings!!');
		$engine->redirect(rawurldecode($engine->href()));
	}
?>
	<form action="admin.php" method="post" name="security">
		<input type="hidden" name="mode" value="configsecurity" />
		<input type="hidden" name="action" value="update" />
		<table cellspacing="3" class="formation">
			<tr>
				<th colspan="2">Basic parameters</th>
			</tr>
			<tr>
				<td class="label"><label for="allow_registration"><strong>Register online:</strong><br />
				<small>Ongoing registration of users. Disabling the option will prevent free registration, however, the site administrator will be able to register other users on their own.</small></label></td>
				<td style="width:40%;"><input type="checkbox" id="allow_registration" name="allow_registration" value="1"<?php echo ( $engine->config['allow_registration'] ? ' checked="checked"' : '' );?> /></td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr>
				<td class="label"><label for="session_encrypt_cookie"><strong>Secure cookies:</strong><br />
				<small>Use the authenticated cookie with protection against unauthorized use. Enabling this option may complicate the work of users simultaneously through multiple browsers.</small></label></td>
				<td><input type="checkbox" id="session_encrypt_cookie" name="session_encrypt_cookie" value="1"<?php echo ( $engine->config['session_encrypt_cookie'] ? ' checked="checked"' : '' );?> /></td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr>
				<td class="label"><label for="antidupe"><strong>Anti-clone:</strong><br />
				<small>Disable register on the website under the names, <u>like</u> on the names of existing users (guests also can not use similar names for the signature comments). When this option is checked only <u>identical</u> names.</small></label></td>
				<td><input type="checkbox" id="antidupe" name="antidupe" value="1"<?php echo ( $engine->config['antidupe'] ? ' checked="checked"' : '' );?> /></td>
			</tr>
			<tr>
				<th colspan="2">
					<br />
					CAPTCHA
				</th>
			</tr>
			<tr>
				<td class="label"><label for="captcha_new_comment"><strong>New comment:</strong><br />
				<small>As a measure of protection against spam publications require unregistered users a single solution of the test before posting the comment. The parameters for fine-tuning are in the configuration file.</small></label></td>
				<td><input type="checkbox" id="captcha_new_comment" name="captcha_new_comment" value="1"<?php echo ( $engine->config['captcha_new_comment'] ? ' checked="checked"' : '' );?> /></td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr>
				<td class="label"><label for="captcha_new_page"><strong>New page:</strong><br />
				<small>As a measure of protection against spam publications require unregistered users a single solution of the test before creating a new pages. The parameters for fine-tuning are in the configuration file.</small></label></td>
				<td><input type="checkbox" id="captcha_new_page" name="captcha_new_page" value="1"<?php echo ( $engine->config['captcha_new_page'] ? ' checked="checked"' : '' );?> /></td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr>
				<td class="label"><label for="captcha_edit_page"><strong>Edit page:</strong><br />
				<small>As a measure of protection against spam publications require unregistered users a single solution of the test before editing pages. The parameters for fine-tuning are in the configuration file.</small></label></td>
				<td><input type="checkbox" id="captcha_edit_page" name="captcha_edit_page" value="1"<?php echo ( $engine->config['captcha_edit_page'] ? ' checked="checked"' : '' );?> /></td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr>
				<td class="label"><label for="captcha_registration"><strong>Registration:</strong><br />
				<small>As a measure of protection against spam publications require unregistered users a single solution of the test before registering. The parameters for fine-tuning are in the configuration file.</small></label></td>
				<td><input type="checkbox" id="captcha_registration" name="captcha_registration" value="1"<?php echo ( $engine->config['captcha_registration'] ? ' checked="checked"' : '' );?> /></td>
			</tr>
			<tr>
				<th colspan="2">
					<br />
					Rights and privileges
				</th>
			</tr>
			<tr>
				<td class="label" valign="top"><label for="default_read_acl"><strong>Read rights by default:</strong><br />
				<small>Typically used for putting the root pages, and pages for which we can not determine parental rights.</small></label></td>
				<td><textarea style="font-size:12px; letter-spacing:normal; width:200px; height:50px;" id="default_read_acl" name="default_read_acl"><?php echo htmlspecialchars($engine->config['default_read_acl']);?></textarea></td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr>
				<td class="label" valign="top"><label for="default_write_acl"><strong>Write rights by default:</strong><br />
				<small>Typically used for putting the root pages, and pages for which we can not determine the parental rights.</small></label></td>
				<td><textarea style="font-size:12px; letter-spacing:normal; width:200px; height:50px;" id="default_write_acl" name="default_write_acl"><?php echo htmlspecialchars($engine->config['default_write_acl']);?></textarea></td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr>
				<td class="label" valign="top"><label for="default_comment_acl"><strong>Commenting on the Rights of the default:</strong><br />
				<small>Typically used for putting the root pages, and pages for which we can not determine the parental rights.</small></label></td>
				<td><textarea style="font-size:12px; letter-spacing:normal; width:200px; height:50px;" id="default_comment_acl" name="default_comment_acl"><?php echo htmlspecialchars($engine->config['default_comment_acl']);?></textarea></td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr>
				<td class="label" valign="top"><label for="default_create_acl"><strong>Create rights of a sub-default:</strong><br />
				<small>Define the tolerance for the establishment of root pages and assign pages for which we can not determine the parental rights.</small></label></td>
				<td><textarea style="font-size:12px; letter-spacing:normal; width:200px; height:50px;" id="default_create_acl" name="default_create_acl"><?php echo htmlspecialchars($engine->config['default_create_acl']);?></textarea></td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr>
				<td class="label" valign="top"><label for="default_upload_acl"><strong>Rights uploading files by default:</strong><br />
				<small>Typically used for putting the root pages, and pages for which we can not determine parental rights.</small></label></td>
				<td><textarea style="font-size:12px; letter-spacing:normal; width:200px; height:50px;" id="default_upload_acl" name="default_upload_acl"><?php echo htmlspecialchars($engine->config['default_upload_acl']);?></textarea></td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr>
				<td class="label" valign="top"><label for="rename_globalacl"><strong>Right global rename:</strong><br />
				<small>List for admission to the possibility of free rename (move) pages.</small></label></td>
				<td><textarea style="font-size:12px; letter-spacing:normal; width:200px; height:50px;" id="rename_globalacl" name="rename_globalacl"><?php echo htmlspecialchars($engine->config['rename_globalacl']);?></textarea></td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr>
				<td class="label"><label for="hide_locked"><strong>Hide inaccessible page:</strong><br />
				<small>If the user does not have permission to read the page, hide it in different lists of documents (placed in the link text, however, will still be visible).</small></label></td>
				<td><input type="checkbox" id="hide_locked" name="hide_locked" value="1"<?php echo ( $engine->config['hide_locked'] ? ' checked="checked"' : '' );?> /></td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr>
				<td class="label"><label for="remove_onlyadmins"><strong>Only administrators can delete pages:</strong><br />
				<small>Deny all, except administrators, to delete pages. In the first limit applies to owners of normal pages.</small></label></td>
				<td><input type="checkbox" id="remove_onlyadmins" name="remove_onlyadmins" value="1"<?php echo ( $engine->config['remove_onlyadmins'] ? ' checked="checked"' : '' );?> /></td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr>
				<td class="label"><label for="owners_can_remove_comments"><strong>Owners of pages can delete comments:</strong><br />
				<small>Allow owners of documents moderate comments on their pages.</small></label></td>
				<td><input type="checkbox" id="owners_can_remove_comments" name="owners_can_remove_comments" value="1"<?php echo ( $engine->config['owners_can_remove_comments'] ? ' checked="checked"' : '' );?> /></td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr>
				<td class="label"><label for="owners_can_change_categories"><strong>Owners can edit pages categories:</strong><br />
				<small>Allow owners to modify the pages category list of your site (add words, delete words), assigns to a page.</small></label></td>
				<td><input type="checkbox" id="owners_can_change_categories" name="owners_can_change_categories" value="1"<?php echo ( $engine->config['owners_can_change_categories'] ? ' checked="checked"' : '' );?> /></td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr>
				<td class="label"><label for="moders_can_edit"><strong>Term human moderation:</strong><br />
				<small>Moderators can edit comments, only if they were set up at most as many days ago (this restriction does not apply to the last comment in the topic).</small></label></td>
				<td><input maxlength="4" style="width:200px;" id="moders_can_edit" name="moders_can_edit" value="<?php echo htmlspecialchars($engine->config['moders_can_edit']);?>" /></td>
			</tr>
			<tr>
				<th colspan="2">
					<br />
					TLS Settings
				</th>
			</tr>
			<tr>
				<td class="label"><label for="tls"><strong>TLS-Connection:</strong><br />
				<small>Use TLS-secured connection. <span class="cite">Activate the required pre-installed TLS-certificate on the server , otherwise you will lose access to the admin panel!</span></small></label></td>
				<td><input type="checkbox" id="tls" name="tls" value="1"<?php echo ( $engine->config['tls'] ? ' checked="checked"' : '' );?> /></td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr>
				<td class="label"><label for="tls_implicit"><strong>Forced TLS:</strong><br />
				<small>Force client reconnection from HTTP to HTTPS. When this option the customer can view the site for open HTTP-channel.</small></label></td>
				<td><input type="checkbox" id="tls_implicit" name="tls_implicit" value="1"<?php echo ( $engine->config['tls_implicit'] ? ' checked="checked"' : '' );?> /></td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr>
				<td class="label"><label for="tls_proxy"><strong>TLS Proxy:</strong><br />
				<small>Uses the provided TLS Proxy inplace of TLS. E.g. https://<span class="cite">your-https-proxy.tld</span> without ending slash.</small></label></td>
				<td><input maxlength="100" style="width:200px;" id="tls_proxy" name="tls_proxy" value="<?php echo htmlspecialchars($engine->config['tls_proxy']);?>" /></td>
			</tr>
			<tr>
				<th colspan="2">
					<br />
					Persistence of user passwords
				</th>
			</tr>
			<tr>
				<td class="label"><label for="pwd_min_chars"><strong>Minimum password length:</strong></label></td>
				<td><input maxlength="3" style="width:200px;" id="pwd_min_chars" name="pwd_min_chars" value="<?php echo htmlspecialchars($engine->config['pwd_min_chars']);?>" /></td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr>
				<td class="label"><label for="pwd_char_classes"><strong>The required password complexity:</strong></label></td>
				<td>
					<select style="width:200px;" id="pwd_char_classes" name="pwd_char_classes">
						<option value="0"<?php echo ( (int)$engine->config['pwd_char_classes'] === 0 ? ' selected="selected"' : '' );?>>not tested</option>
						<option value="1"<?php echo ( (int)$engine->config['pwd_char_classes'] === 1 ? ' selected="selected"' : '' );?>>any letters + numbers</option>
						<option value="2"<?php echo ( (int)$engine->config['pwd_char_classes'] === 2 ? ' selected="selected"' : '' );?>>uppercase and lowercase + numbers</option>
						<option value="3"<?php echo ( (int)$engine->config['pwd_char_classes'] === 3 ? ' selected="selected"' : '' );?>>uppercase and lowercase + numbers + characters</option>
					</select>
				</td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr>
				<td class="label"><label for="pwd_unlike_login"><strong>Additional complication:</strong></label></td>
				<td>
					<select style="width:200px;" id="pwd_unlike_login" name="pwd_unlike_login">
						<option value="0"<?php echo ( (int)$engine->config['pwd_unlike_login'] === 0 ? ' selected="selected"' : '' );?>>not tested</option>
						<option value="1"<?php echo ( (int)$engine->config['pwd_unlike_login'] === 1 ? ' selected="selected"' : '' );?>>password is not identical to the login</option>
						<option value="2"<?php echo ( (int)$engine->config['pwd_unlike_login'] === 2 ? ' selected="selected"' : '' );?>>password does not contain username</option>
					</select>
				</td>
			</tr>
			<tr>
				<th colspan="2">
					<br />
					Log settings
				</th>
			</tr>
			<tr>
				<td class="label"><label for="log_level"><strong>Using logging:</strong><br />
				<small>The minimum priority of the events recorded in the log.</small></label></td>
				<td>
					<select style="width:200px;" id="log_level" name="log_level">
						<option value="0"<?php echo ( (int)$engine->config['log_level'] === 0 ? ' selected="selected"' : '' );?>>0: not keep a journal</option>
						<option value="7"<?php echo ( (int)$engine->config['log_level'] === 7 ? ' selected="selected"' : '' );?>>7: record all</option>
						<option value="6"<?php echo ( (int)$engine->config['log_level'] === 6 ? ' selected="selected"' : '' );?>>6: the minimum level</option>
						<option value="5"<?php echo ( (int)$engine->config['log_level'] === 5 ? ' selected="selected"' : '' );?>>5: from low</option>
						<option value="4"<?php echo ( (int)$engine->config['log_level'] === 4 ? ' selected="selected"' : '' );?>>4: on average</option>
						<option value="3"<?php echo ( (int)$engine->config['log_level'] === 3 ? ' selected="selected"' : '' );?>>3: from high</option>
						<option value="2"<?php echo ( (int)$engine->config['log_level'] === 2 ? ' selected="selected"' : '' );?>>2: from the highest level</option>
						<option value="1"<?php echo ( (int)$engine->config['log_level'] === 1 ? ' selected="selected"' : '' );?>>1: only the critical level</option>
					</select>
				</td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr>
				<td class="label"><label for="log_default_show"><strong>Display Log Mode:</strong><br />
				<small>The minimum priority events displayed in the log by default.</small></label></td>
				<td>
					<select style="width:200px;" id="log_default_show" name="log_default_show">
						<option value="7"<?php echo ( (int)$engine->config['log_default_show'] === 7 ? ' selected="selected"' : '' );?>>show all</option>
						<option value="6"<?php echo ( (int)$engine->config['log_default_show'] === 6 ? ' selected="selected"' : '' );?>>from the minimum level</option>
						<option value="5"<?php echo ( (int)$engine->config['log_default_show'] === 5 ? ' selected="selected"' : '' );?>>from a low</option>
						<option value="4"<?php echo ( (int)$engine->config['log_default_show'] === 4 ? ' selected="selected"' : '' );?>>the average</option>
						<option value="3"<?php echo ( (int)$engine->config['log_default_show'] === 3 ? ' selected="selected"' : '' );?>>from high-level</option>
						<option value="2"<?php echo ( (int)$engine->config['log_default_show'] === 2 ? ' selected="selected"' : '' );?>>from the highest level</option>
						<option value="1"<?php echo ( (int)$engine->config['log_default_show'] === 1 ? ' selected="selected"' : '' );?>>only the critical level</option>
					</select>
				</td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr>
				<td class="label"><label for="log_purge_time"><strong>Storage time of Log:</strong><br />
				<small>Remove event log over a given number of days.</small></label></td>
				<td><input maxlength="4" style="width:200px;" id="log_purge_time" name="log_purge_time" value="<?php echo htmlspecialchars($engine->config['log_purge_time']);?>" /></td>
			</tr>
			<tr>
				<th colspan="2">
					<br />
					Miscellaneous
				</th>
			</tr>
			<tr>
				<td class="label"><label for="session_expiration"><strong>Term login cookie:</strong><br />
				<small>The lifetime of the user cookie login by default (in days).</small></label></td>
				<td><input maxlength="4" style="width:200px;" id="session_expiration" name="session_expiration" value="<?php echo htmlspecialchars($engine->config['session_expiration']);?>" /></td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr>
				<td class="label"><label for="comment_delay"><strong>Anti-flood for comments:</strong><br />
				<small>
The minimum delay between the publication of the new user comments (in seconds).</small></label></td>
				<td><input maxlength="4" style="width:200px;" id="comment_delay" name="comment_delay" value="<?php echo htmlspecialchars($engine->config['comment_delay']);?>" /></td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr>
				<td class="label"><label for="intercom_delay"><strong>Anti-flood for personal communications:</strong><br />
				<small>The minimum delay between sending a private message user connection (in seconds).</small></label></td>
				<td><input maxlength="4" style="width:200px;" id="intercom_delay" name="intercom_delay" value="<?php echo htmlspecialchars($engine->config['intercom_delay']);?>" /></td>
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