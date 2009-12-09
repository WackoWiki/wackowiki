<?php

########################################################
##   Security settings                                ##
########################################################

$module['configsecurity'] = array(
		'order'	=> 2,
		'cat'	=> 'Preferences',
		'mode'	=> 'configsecurity',
		'name'	=> 'Safety',
		'title'	=> 'setting the security subsystems',
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
	if ($_POST['action'] == 'update')
	{
		$engine->Query(
			"UPDATE {$engine->config['table_prefix']}config SET ".
				"`allow_registration`	= '".quote((int)$_POST['allow_registration'])."', ".
				"`captcha`				= '".quote((int)$_POST['captcha'])."', ".
				"`strong_cookies`		= '".quote((int)$_POST['strong_cookies'])."', ".
				"`antidupe`				= '".quote((int)$_POST['antidupe'])."', ".
				"`default_read_acl`		= '".quote((string)$_POST['default_read_acl'])."', ".
				"`default_write_acl`	= '".quote((string)$_POST['default_write_acl'])."', ".
				"`default_comment_acl`	= '".quote((string)$_POST['default_comment_acl'])."', ".
				"`default_create_acl`	= '".quote((string)$_POST['default_create_acl'])."', ".
				"`default_upload_acl`	= '".quote((string)$_POST['default_upload_acl'])."', ".
				"`rename_globalacl`		= '".quote((string)$_POST['rename_globalacl'])."', ".
				"`hide_locked`			= '".quote((int)$_POST['hide_locked'])."', ".
				"`remove_onlyadmins`	= '".quote((int)$_POST['remove_onlyadmins'])."', ".
				"`owners_can_remove_comments`	= '".quote((int)$_POST['owners_can_remove_comments'])."', ".
				"`owners_can_change_keywords`	= '".quote((int)$_POST['owners_can_change_keywords'])."', ".
				"`moders_can_edit`		= '".quote((int)$_POST['moders_can_edit'])."', ".
				"`ssl`					= '".quote((int)$_POST['ssl'])."', ".
				"`ssl_implicit`			= '".quote((int)$_POST['ssl_implicit'])."', ".
				"`pwd_min_chars`		= '".quote((int)$_POST['pwd_min_chars'])."', ".
				"`pwd_char_classes`		= '".quote((int)$_POST['pwd_char_classes'])."', ".
				"`pwd_unlike_login`		= '".quote((int)$_POST['pwd_unlike_login'])."', ".
				/* 
				"`gpg`					= '".quote((int)$_POST['gpg'])."', ".
				"`gpg_debug`			= '".quote((int)$_POST['gpg_debug'])."', ".
				"`gpg_server`			= '".quote((string)$_POST['gpg_server'])."', ".
				"`gpg_home`				= '".quote((string)$_POST['gpg_home'])."', ".
				"`gpg_temp`				= '".quote((string)$_POST['gpg_temp'])."', ".
				"`gpg_wrapper`			= '".quote((string)$_POST['gpg_wrapper'])."', ".
				*/
				"`log_min_level`		= '".quote((int)$_POST['log_min_level'])."', ".
				"`log_default_show`		= '".quote((int)$_POST['log_default_show'])."', ".
				"`log_purge_time`		= '".quote((int)$_POST['log_purge_time'])."', ".
				"`cookie_session`		= '".quote((int)$_POST['cookie_session'])."', ".
				"`comment_delay`		= '".quote((int)$_POST['comment_delay'])."', ".
				"`intercom_delay`		= '".quote((int)$_POST['intercom_delay'])."' ");
		$engine->Log(1, '!!Updated security settings WackoWiki!!');
		$engine->Redirect(rawurldecode($engine->href()));
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
				<td class="label"><label for="captcha"><strong>Turing test (CAPTCHA):</strong><br />
				<small>As a measure of protection against spam publications require unregistered users a single solution of the test before registering, posting the comment and editing pages. The parameters for fine-tuning are in the configuration file WackoWiki.</small></label></td>
				<td><input type="checkbox" id="captcha" name="captcha" value="1"<?php echo ( $engine->config['captcha'] ? ' checked="checked"' : '' );?> /></td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr>
				<td class="label"><label for="strong_cookies"><strong>Secure cookies:</strong><br />
				<small>Use the authenticated cookie with protection against unauthorized use. Enabling this option may complicate the work of users simultaneously through multiple browsers.</small></label></td>
				<td><input type="checkbox" id="strong_cookies" name="strong_cookies" value="1"<?php echo ( $engine->config['strong_cookies'] ? ' checked="checked"' : '' );?> /></td>
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
					<div class="center">
						<input id="submit" type="submit" value="save" />
						<input id="button" type="reset" value="reset" />
					</div>
					<br />
					Tolerances and privileges
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
				<td class="label"><label for="owners_can_change_keywords"><strong>Owners can edit pages keywords:</strong><br />
				<small>Allow owners to modify the documents keyword list your site (add words, delete the word), assigns to a page.</small></label></td>
				<td><input type="checkbox" id="owners_can_change_keywords" name="owners_can_change_keywords" value="1"<?php echo ( $engine->config['owners_can_change_keywords'] ? ' checked="checked"' : '' );?> /></td>
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
					<div class="center">
						<input id="submit" type="submit" value="save" />
						<input id="button" type="reset" value="reset" />
					</div>
					<br />
					SSL Settings
				</th>
			</tr>
			<tr>
				<td class="label"><label for="ssl"><strong>SSL-Connection:</strong><br />
				<small>Use SSL-secured connection. <span class="cite">To activate the required pre-installed on the server SSL-certificate, otherwise you will lose access to the admin panel!</span></small></label></td>
				<td><input type="checkbox" id="ssl" name="ssl" value="1"<?php echo ( $engine->config['ssl'] ? ' checked="checked"' : '' );?> /></td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr>
				<td class="label"><label for="ssl_implicit"><strong>Forced SSL:</strong><br />
				<small>Force client reconnection c HTTP to HTTPS. When this option the customer can view the site for open HTTP-channel.</small></label></td>
				<td><input type="checkbox" id="ssl_implicit" name="ssl_implicit" value="1"<?php echo ( $engine->config['ssl_implicit'] ? ' checked="checked"' : '' );?> /></td>
			</tr>
			<tr>
				<th colspan="2">
					<br />
					<div class="center">
						<input id="submit" type="submit" value="save" />
						<input id="button" type="reset" value="reset" />
					</div>
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
					<div class="center">
						<input id="submit" type="submit" value="save" />
						<input id="button" type="reset" value="reset" />
					</div>
					<br />
					Log settings
				</th>
			</tr>
			<tr>
				<td class="label"><label for="log_min_level"><strong>Using logging:</strong><br />
				<small>The minimum priority of the events recorded in the log.</small></label></td>
				<td>
					<select style="width:200px;" id="log_min_level" name="log_min_level">
						<option value="-1"<?php echo ( (int)$engine->config['log_min_level'] === -1 ? ' selected="selected"' : '' );?>>not keep a journal</option>
						<option value="0"<?php echo ( (int)$engine->config['log_min_level'] === 0 ? ' selected="selected"' : '' );?>>record all</option>
						<option value="6"<?php echo ( (int)$engine->config['log_min_level'] === 6 ? ' selected="selected"' : '' );?>>the minimum level</option>
						<option value="5"<?php echo ( (int)$engine->config['log_min_level'] === 5 ? ' selected="selected"' : '' );?>>from low</option>
						<option value="4"<?php echo ( (int)$engine->config['log_min_level'] === 4 ? ' selected="selected"' : '' );?>>on average</option>
						<option value="3"<?php echo ( (int)$engine->config['log_min_level'] === 3 ? ' selected="selected"' : '' );?>>from high</option>
						<option value="2"<?php echo ( (int)$engine->config['log_min_level'] === 2 ? ' selected="selected"' : '' );?>>from the highest level</option>
						<option value="1"<?php echo ( (int)$engine->config['log_min_level'] === 1 ? ' selected="selected"' : '' );?>>only the critical level</option>
					</select>
				</td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr>
				<td class="label"><label for="log_default_show"><strong>Display Mode magazine:</strong><br />
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
				<td class="label"><label for="log_purge_time"><strong>Shelf life magazine:</strong><br />
				<small>Remove event log over a given number of days.</small></label></td>
				<td><input maxlength="4" style="width:200px;" id="log_purge_time" name="log_purge_time" value="<?php echo htmlspecialchars($engine->config['log_purge_time']);?>" /></td>
			</tr>
			<tr>
				<th colspan="2">
					<br />
					<div class="center">
						<input id="submit" type="submit" value="save" />
						<input id="button" type="reset" value="reset" />
					</div>
					<br />
					Miscellaneous
				</th>
			</tr>
			<tr>
				<td class="label"><label for="cookie_session"><strong>Term login cookie:</strong><br />
				<small>The lifetime of the user cookie login by default (in days).</small></label></td>
				<td><input maxlength="4" style="width:200px;" id="cookie_session" name="cookie_session" value="<?php echo htmlspecialchars($engine->config['cookie_session']);?>" /></td>
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