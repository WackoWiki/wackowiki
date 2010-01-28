<?php

########################################################
##   Basic settings                                   ##
########################################################

$module['configbasic'] = array(
		'order'	=> 2,
		'cat'	=> 'Preferences',
		'mode'	=> 'configbasic',
		'name'	=> 'Basic',
		'title'	=> 'Basic parameters',
	);

########################################################

function admin_configbasic(&$engine, &$module)
{
?>
	<h1><?php echo $module['title']; ?></h1>
	<br />
<?php
	// update settings
	if ($_POST['action'] == 'update')
	{
		$engine->Query(
			"UPDATE {$engine->config['table_prefix']}config SET ".
				"`wacko_name`			= '".quote($engine->dblink, (string)$_POST['wacko_name'])."', ".
				"`wacko_desc`			= '".quote($engine->dblink, (string)$_POST['wacko_desc'])."', ".
				"`meta_description`		= '".quote($engine->dblink, (string)$_POST['meta_description'])."', ".
				"`meta_keywords`		= '".quote($engine->dblink, (string)$_POST['meta_keywords'])."', ".
				"`theme`				= '".quote($engine->dblink, (string)$_POST['theme'])."', ".
				"`admin_name`			= '".quote($engine->dblink, (string)$_POST['admin_name'])."', ".
				"`admin_email`			= '".quote($engine->dblink, (string)$_POST['admin_email'])."', ".
				"`abuse_email`			= '".quote($engine->dblink, (string)$_POST['abuse_email'])."', ".
				"`language`				= '".quote($engine->dblink, (string)$_POST['language'])."', ".
				"`multilanguage`		= '".quote($engine->dblink, (int)$_POST['multilanguage'])."', ".
				"`upload_images_only`	= '".quote($engine->dblink, (int)$_POST['upload_images_only'])."', ".
				"`upload_max_size`		= '".quote($engine->dblink, (int)$_POST['upload_max_size'])."', ".
				"`upload_max_per_user`	= '".quote($engine->dblink, (int)$_POST['upload_max_per_user'])."', ".
				"`hide_comments`		= '".quote($engine->dblink, (int)$_POST['hide_comments'])."', ".
				"`hide_files`			= '".quote($engine->dblink, (int)$_POST['hide_files'])."', ".
				"`hide_rating`			= '".quote($engine->dblink, (int)$_POST['hide_rating'])."', ".
				"`hide_toc`				= '".quote($engine->dblink, (int)$_POST['hide_toc'])."', ".
				"`hide_index`			= '".quote($engine->dblink, (int)$_POST['hide_index'])."', ".
				"`lower_index`			= '".quote($engine->dblink,  $_POST['index_mode'] == 'l' ? 1 : 0 )."', ".
				"`upper_index`			= '".quote($engine->dblink,  $_POST['index_mode'] == 'u' ? 1 : 0 )."', ".
				"`disable_autosubscribe`	= '".quote($engine->dblink, (int)$_POST['disable_autosubscribe'])."', ".
				"`default_rename_redirect`	= '".quote($engine->dblink, (int)$_POST['default_rename_redirect'])."', ".
				"`store_deleted_pages`		= '".quote($engine->dblink, (int)$_POST['store_deleted_pages'])."', ".
				"`keep_deleted_time`	= '".quote($engine->dblink, (string)$_POST['keep_deleted_time'])."', ".
				"`pages_purge_time`		= '".quote($engine->dblink, (string)$_POST['pages_purge_time'])."', ".
				"`referrers_purge_time`	= '".quote($engine->dblink, (string)$_POST['referrers_purge_time'])."' ");
		$engine->Log(1, 'Updated basic parameters  WackoWiki');
		$engine->Redirect(rawurldecode($engine->href()));
	}
?>
	<form action="admin.php" method="post" name="basic">
		<input type="hidden" name="mode" value="configbasic" />
		<input type="hidden" name="action" value="update" />
		<table cellspacing="3" class="formation">
			<tr>
				<th colspan="2">Basic parameters</th>
			</tr>
			<tr>
				<td class="label"><label for="wacko_name"><strong>Site Name:</strong><br />
				<small>The title that appears on this site, email-notification, etc.</small></label></td>
				<td style="width:40%;"><input maxlength="255" style="width:200px;" id="wacko_name" name="wacko_name" value="<?php echo htmlspecialchars($engine->config['wacko_name']);?>" /></td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr>
				<td class="label"><label for="wacko_name"><strong>Site Description:</strong><br />
				<small>Supplement to the title of a site that appears in the pages header.</small></label></td>
				<td><input maxlength="255" style="width:200px;" id="wacko_desc" name="wacko_desc" value="<?php echo htmlspecialchars($engine->config['wacko_desc']);?>" /></td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr>
				<td class="label" valign="top"><label for="meta_description"><strong>Description of the document by default:</strong><br />
				<small>The text used by default for meta-tags <tt>description</tt> (maximum of 255 characters).</small></label></td>
				<td><textarea style="font-size:12px; letter-spacing:normal; width:200px; height:100px;" id="meta_description" name="meta_description"><?php echo htmlspecialchars($engine->config['meta_description']);?></textarea></td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr>
				<td class="label" valign="top"><label for="meta_keywords"><strong>Keywords page default:</strong><br />
				<small>Key words used by default for meta-tags <tt>keywords</tt> (maximum of 255 characters).</small></label></td>
				<td><textarea style="font-size:12px; letter-spacing:normal; width:200px; height:100px;" id="meta_keywords" name="meta_keywords"><?php echo htmlspecialchars($engine->config['meta_keywords']);?></textarea></td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr>
				<td class="label"><label for="theme"><strong>Theme design:</strong><br />
				<small>Template design a site that is used by default.</small></label></td>
				<td>
					<select style="width:200px;" id="theme" name="theme">
<?php
						$themes = $engine->AvailableThemes();
						for ($i = 0; $i < count($themes); $i++)
						{
							echo '<option value="'.$themes[$i].'" '.($engine->config['theme'] == $themes[$i] ? 'selected="selected"' : '').'>'.$themes[$i].'</option>';
						}
?>
					</select>
				</td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr>
				<td class="label"><label for="admin_name"><strong>Admin of Site:</strong><br />
				<small>User name, which is responsible for overall support of the site. This name is not used to determine access rights, but it is desirable to conform to the name of the chief administrator of the site.</small></label></td>
				<td><input maxlength="25" style="width:200px;" id="admin_name" name="admin_name" value="<?php echo htmlspecialchars($engine->config['admin_name']);?>" /></td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr>
				<td class="label"><label for="admin_email"><strong>Email of the site owner:</strong><br />
				<small>This address will appear as the<tt>"From:"</tt> all the email-notification site.</small></label></td>
				<td><input maxlength="100" style="width:200px;" id="admin_email" name="admin_email" value="<?php echo htmlspecialchars($engine->config['admin_email']);?>" /></td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr>
				<td class="label"><label for="abuse_email"><strong>Email service abuse:</strong><br />
				<small>Address requests for urgent matters: registration for a foreign email, etc. It may coincide with the previous.</small></label></td>
				<td><input maxlength="100" style="width:200px;" id="abuse_email" name="abuse_email" value="<?php echo htmlspecialchars($engine->config['abuse_email']);?>" /></td>
			</tr>
			<tr>
				<th colspan="2">
					<br />
					<div class="center">
						<input id="submit" type="submit" value="save" />
						<input id="button" type="reset" value="reset" />
					</div>
					<br />
					Language settings
				</th>
			</tr>
			<tr>
				<td class="label"><label for="language"><strong>Default language:</strong><br />
				<small>Specifies the language for mapping unregistered guests, as well as the locale settings and the rules of transliteration of addresses of pages.</small></label></td>
				<td>
					<select style="width:200px;" id="language" name="language">
<?php
						$langs = $engine->AvailableLanguages();
						for ($i = 0; $i < count($langs); $i++)
						{
							echo '<option value="'.$langs[$i].'" '.($engine->config['language'] == $langs[$i] ? 'selected="selected"' : '').'>'.$langs[$i].'</option>';
						}
?>
					</select>
				</td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr>
				<td class="label"><label for="multilanguage"><strong>Multilanguage support:</strong><br />
				<small>Include a choice of language on the page by page basis.</small></label></td>
				<td><input type="checkbox" id="multilanguage" name="multilanguage" value="1"<?php echo ( $engine->config['multilanguage'] ? ' checked="checked"' : '' );?> /></td>
			</tr>
			<tr>
				<th colspan="2">
					<br />
					<div class="center">
						<input id="submit" type="submit" value="save" />
						<input id="button" type="reset" value="reset" />
					</div>
					<br />
					File uploads
				</th>
			</tr>
			<tr>
				<td class="label"><label for="upload_images_only"><strong>Please only upload an image:</strong><br />
				<small>Allow uploading of image files only on the page.</small></label></td>
				<td><input type="checkbox" id="upload_images_only" name="upload_images_only" value="1"<?php echo ( $engine->config['upload_images_only'] ? ' checked="checked"' : '' );?> /></td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr>
				<td class="label"><label for="upload_max_size"><strong>Maximum file size (Kb):</strong><br />
				<small>Limiting the size of files uploaded by users.</small></label></td>
				<td><input maxlength="7" style="width:200px;" id="upload_max_size" name="upload_max_size" value="<?php echo htmlspecialchars($engine->config['upload_max_size']);?>" /></td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr>
				<td class="label"><label for="upload_max_per_user"><strong>Restricting files to a user:</strong><br />
				<small>Restriction on the number of files that can be uploaded by one user. Zero indicates the absence of restrictions.</small></label></td>
				<td><input maxlength="4" style="width:200px;" id="upload_max_per_user" name="upload_max_per_user" value="<?php echo htmlspecialchars($engine->config['upload_max_per_user']);?>" /></td>
			</tr>
			<tr>
				<th colspan="2">
					<br />
					<div class="center">
						<input id="submit" type="submit" value="save" />
						<input id="button" type="reset" value="reset" />
					</div>
					<br />
					Toolbar
				</th>
			</tr>
			<tr>
				<td class="label"><strong>Comments panel:</strong><br />
				<small>The default display in the bottom of the cover pages of comments.</small></td>
				<td>
					<input type="radio" id="hide_comments_on" name="hide_comments" value="0"<?php echo ( !$engine->config['hide_comments'] ? ' checked="checked"' : '' );?> /><label for="hide_comments_on">On.</label>
					<input type="radio" id="hide_comments_off" name="hide_comments" value="1"<?php echo ( $engine->config['hide_comments'] ? ' checked="checked"' : '' );?> /><label for="hide_comments_off">Off.</label>
				</td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr>
				<td class="label"><strong>File panel:</strong><br />
				<small>The default display in the bottom of the cover pages of attachments.</small></td>
				<td>
					<input type="radio" id="hide_files_on" name="hide_files" value="0"<?php echo ( !$engine->config['hide_files'] ? ' checked="checked"' : '' );?> /><label for="hide_files_on">On.</label>
					<input type="radio" id="hide_files_off" name="hide_files" value="1"<?php echo ( $engine->config['hide_files'] ? ' checked="checked"' : '' );?> /><label for="hide_files_off">Off.</label>
				</td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr>
				<td class="label"><strong>Rating panel :</strong><br />
				<small>The default display in the bottom of the panel rating of the document.</small></td>
				<td>
					<input type="radio" id="hide_rating_on" name="hide_rating" value="0"<?php echo ( !$engine->config['hide_rating'] ? ' checked="checked"' : '' );?> /><label for="hide_rating_on">On.</label>
					<input type="radio" id="hide_rating_off" name="hide_rating" value="1"<?php echo ( $engine->config['hide_rating'] ? ' checked="checked"' : '' );?> /><label for="hide_rating_off">Off.</label>
				</td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr>
				<td class="label"><strong>Table of contents panel :</strong><br />
				<small>The default display panel table of contents of document (may need support in the templates).</small></td>
				<td>
					<input type="radio" id="hide_toc_on" name="hide_toc" value="0"<?php echo ( !$engine->config['hide_toc'] ? ' checked="checked"' : '' );?> /><label for="hide_toc_on">On.</label>
					<input type="radio" id="hide_toc_off" name="hide_toc" value="1"<?php echo ( $engine->config['hide_toc'] ? ' checked="checked"' : '' );?> /><label for="hide_toc_off">Off.</label>
				</td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr>
				<td class="label"><strong>The panel sections:</strong><br />
				<small>By default the display panel adjacent documents (requires support in the templates).</small></td>
				<td>
					<input type="radio" id="hide_index_on" name="hide_index" value="0"<?php echo ( !$engine->config['hide_index'] ? ' checked="checked"' : '' );?> /><label for="hide_index_on">On.</label>
					<input type="radio" id="hide_index_off" name="hide_index" value="1"<?php echo ( $engine->config['hide_index'] ? ' checked="checked"' : '' );?> /><label for="hide_index_off">Off.</label>
				</td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr>
				<td class="label"><strong>Displaying sections:</strong><br />
				<small>When the previous options, whether to display only daughter of page (<em>lower</em>), only neighbor (<em>top</em>) or both, and other (<em>tree</em>).</small></td>
				<td>
					<input type="radio" id="full_index" name="index_mode" value="f"<?php echo ( !$engine->config['lower_index'] && !$engine->config['upper_index'] ? ' checked="checked"' : '' );?> /><label for="full_index">Tree</label>
					<input type="radio" id="lower_index" name="index_mode" value="l"<?php echo ( $engine->config['lower_index'] ? ' checked="checked"' : '' );?> /><label for="lower_index">Lower</label>
					<input type="radio" id="upper_index" name="index_mode" value="u"<?php echo ( $engine->config['upper_index'] ? ' checked="checked"' : '' );?> /><label for="upper_index">Upper</label>
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
					Miscellaneous
				</th>
			</tr>
			<tr>
				<td class="label"><strong>Edit summary:</strong><br />
				<small>Shows change summary in the edit mode.</small></td>
				<td>
					<input type="radio" id="edit_summary_on" name="edit_summary" value="1"<?php echo ( $engine->config['edit_summary'] ? ' checked="checked"' : '' );?> /><label for="edit_summary_on">On.</label>
					<input type="radio" id="edit_summary_off" name="edit_summary" value="0"<?php echo ( !$engine->config['edit_summary'] ? ' checked="checked"' : '' );?> /><label for="edit_summary_off">Off.</label>
				</td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr>
				<td class="label"><strong>Minor edit:</strong><br />
				<small>Enables minor edit option in the edit mode.</small></td>
				<td>
					<input type="radio" id="minor_edit_on" name="minor_edit" value="1"<?php echo ( $engine->config['minor_edit'] ? ' checked="checked"' : '' );?> /><label for="minor_edit_on">On.</label>
					<input type="radio" id="minor_edit_off" name="minor_edit" value="0"<?php echo ( !$engine->config['minor_edit'] ? ' checked="checked"' : '' );?> /><label for="minor_edit_off">Off.</label>
				</td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr>
				<td class="label"><strong>Autosubscribe:</strong><br />
				<small>Automatically sign a new page in the owner's notice of its changes.</small></td>
				<td>
					<input type="radio" id="disable_autosubscribe_on" name="disable_autosubscribe" value="0"<?php echo ( !$engine->config['disable_autosubscribe'] ? ' checked="checked"' : '' );?> /><label for="disable_autosubscribe_on">On.</label>
					<input type="radio" id="disable_autosubscribe_off" name="disable_autosubscribe" value="1"<?php echo ( $engine->config['disable_autosubscribe'] ? ' checked="checked"' : '' );?> /><label for="disable_autosubscribe_off">Off.</label>
				</td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr>
				<td class="label"><label for="default_rename_redirect"><strong>When renaming put redirection:</strong><br />
				<small>By default, propose to redirect the old address pereimenuemoy page.</small></label></td>
				<td><input type="checkbox" id="default_rename_redirect" name="default_rename_redirect" value="1"<?php echo ( $engine->config['default_rename_redirect'] ? ' checked="checked"' : '' );?> /></td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr>
				<td class="label"><label for="store_deleted_pages"><strong>Keep deleted pages:</strong><br />
				<small>When you delete a page (the comment) put her in a special section where she had some time (below) will be available for viewing and recovery.</small></label></td>
				<td><input type="checkbox" id="store_deleted_pages" name="store_deleted_pages" value="1"<?php echo ( $engine->config['store_deleted_pages'] ? ' checked="checked"' : '' );?> /></td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr>
				<td class="label"><label for="keep_deleted_time"><strong>Shelf life of remote pages:</strong><br />
				<small>The period in days. It makes sense only if the previous option. Zero indicates the eternal possession (in this case the administrator can clear the "cart" manually).</small></label></td>
				<td><input maxlength="4" style="width:200px;" id="keep_deleted_time" name="keep_deleted_time" value="<?php echo htmlspecialchars($engine->config['keep_deleted_time']);?>" /></td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr>
				<td class="label"><label for="pages_purge_time"><strong>Shelf life editorial pages:</strong><br />
				<small>Automatically delete the older edition of the number of days. If you enter zero, the old edition will not be removed.</small></label></td>
				<td><input maxlength="4" style="width:200px;" id="pages_purge_time" name="pages_purge_time" value="<?php echo htmlspecialchars($engine->config['pages_purge_time']);?>" /></td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr>
				<td class="label"><label for="referrers_purge_time"><strong>Shelf life referrers:</strong><br />
				<small>Keep history of invoking external pages no more than this number of days. Zero means the perpetual possession, but to actively visit the site this could lead to overcrowding in the database.</small></label></td>
				<td><input maxlength="4" style="width:200px;" id="referrers_purge_time" name="referrers_purge_time" value="<?php echo htmlspecialchars($engine->config['referrers_purge_time']);?>" /></td>
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