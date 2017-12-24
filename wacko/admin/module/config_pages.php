<?php

if (!defined('IN_WACKO'))
{
	exit;
}

##########################################################
##	Pages settings										##
##########################################################
$_mode = 'config_pages';

$module[$_mode] = [
		'order'	=> 280,
		'cat'	=> 'preferences',
		'status'=> (RECOVERY_MODE ? false : true),
		'mode'	=> $_mode,
		'name'	=> $engine->_t($_mode)['name'],		// Pages
		'title'	=> $engine->_t($_mode)['title'],	// Pages and site parameters
	];

##########################################################

function admin_config_pages(&$engine, &$module)
{
?>
	<h1><?php echo $module['title']; ?></h1>
	<br>
<?php
	// update settings
	if (isset($_POST['action']) && $_POST['action'] == 'update')
	{
		$config['list_count']			= (int) $_POST['list_count'];
		$config['forum_cluster']		= trim((string) $_POST['forum_cluster'], '/');
		$config['forum_topics']			= (int) $_POST['forum_topics'];
		$config['comments_count']		= (int) $_POST['comments_count'];
		$config['news_cluster']			= trim((string) $_POST['news_cluster'], '/');
		$config['news_levels']			= (string) $_POST['news_levels'];
		$config['license']				= (string) $_POST['license'];
		$config['root_page']			= trim((string) $_POST['root_page'], '/');
		$config['policy_page']			= trim((string) $_POST['policy_page'], '/');
		$config['search_page']			= trim((string) $_POST['search_page'], '/');
		$config['registration_page']	= trim((string) $_POST['registration_page'], '/');
		$config['login_page']			= trim((string) $_POST['login_page'], '/');
		$config['settings_page']		= trim((string) $_POST['settings_page'], '/');
		$config['password_page']		= trim((string) $_POST['password_page'], '/');
		$config['users_page']			= trim((string) $_POST['users_page'], '/');
		$config['category_page']		= trim((string) $_POST['category_page'], '/');
		$config['tag_page']				= trim((string) $_POST['tag_page'], '/');
		$config['groups_page']			= trim((string) $_POST['groups_page'], '/');
		$config['changes_page']			= trim((string) $_POST['changes_page'], '/');
		$config['comments_page']		= trim((string) $_POST['comments_page'], '/');
		$config['removals_page']		= trim((string) $_POST['removals_page'], '/');
		$config['wanted_page']			= trim((string) $_POST['wanted_page'], '/');
		$config['orphaned_page']		= trim((string) $_POST['orphaned_page'], '/');
		$config['todo_page']			= trim((string) $_POST['todo_page'], '/');
		$config['sandbox']				= trim((string) $_POST['sandbox'], '/');
		$config['wiki_docs']			= trim((string) $_POST['wiki_docs'], '/');

		$engine->config->_set($config);

		$engine->log(1, $engine->_t('PagesSettingsUpdated'));
		$engine->set_message($engine->_t('PagesSettingsUpdated'), 'success');
		$engine->http->redirect(rawurldecode($engine->href('', '', ['mode' => $module['mode']])));
	}

	echo $engine->form_open('pages');
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
					<label for="list_count"><strong><?php echo $engine->_t('ListCount');?>:</strong><br>
					<small><?php echo $engine->_t('ListCountInfo');?></small></label>
				</td>
				<td>
					<input type="number" min="0" maxlength="3" id="list_count" name="list_count" value="<?php echo (int) $engine->db->list_count;?>">
				</td>
			</tr>
			<tr>
				<th colspan="2"><?php echo $engine->_t('ForumSection');?></th>
			</tr>
			<tr class="hl_setting">
				<td class="label">
					<label for="forum_cluster"><strong><?php echo $engine->_t('ForumCluster');?>:</strong><br>
					<small><?php echo $engine->_t('');?></small></label>
				</td>
				<td>
					<input type="text" maxlength="255" id="forum_cluster" name="forum_cluster" value="<?php echo htmlspecialchars($engine->db->forum_cluster, ENT_COMPAT | ENT_HTML5, HTML_ENTITIES_CHARSET);?>">
				</td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl_setting">
				<td class="label">
					<label for="forum_topics"><strong><?php echo $engine->_t('ForumTopics');?>:</strong><br>
					<small><?php echo $engine->_t('ForumTopicsInfo');?></small></label>
				</td>
				<td>
					<input type="number" min="0" maxlength="3" id="forum_topics" name="forum_topics" value="<?php echo (int) $engine->db->forum_topics;?>">
				</td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl_setting">
				<td class="label">
					<label for="comments_count"><strong><?php echo $engine->_t('CommentsCount');?>:</strong><br>
					<small><?php echo $engine->_t('CommentsCountInfo');?></small></label>
				</td>
				<td>
					<input type="number" min="0" maxlength="3" id="comments_count" name="comments_count" value="<?php echo (int) $engine->db->comments_count;?>">
				</td>
			</tr>
			<tr>
				<th colspan="2">
					<br>
					<?php echo $engine->_t('NewsSection');?>
				</th>
			</tr>
			<tr class="hl_setting">
				<td class="label">
					<label for="news_cluster"><strong><?php echo $engine->_t('NewsCluster');?>:</strong><br>
					<small><?php echo $engine->_t('NewsClusterInfo');?></small></label>
				</td>
				<td>
					<input type="text" maxlength="255" id="news_cluster" name="news_cluster" value="<?php echo htmlspecialchars($engine->db->news_cluster, ENT_COMPAT | ENT_HTML5, HTML_ENTITIES_CHARSET);?>">
				</td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl_setting">
				<td class="label">
					<label for="news_levels"><strong><?php echo $engine->_t('NewsLevels');?>:</strong><br>
					<small><?php echo $engine->_t('NewsLevelsInfo');?></small></label>
				</td>
				<td>
					<input type="text" maxlength="255" id="news_levels" name="news_levels" value="<?php echo htmlspecialchars($engine->db->news_levels, ENT_COMPAT | ENT_HTML5, HTML_ENTITIES_CHARSET);?>">
				</td>
			</tr>
			<tr>
				<th colspan="2">
					<br>
					<?php echo $engine->_t('LicenseSection');?>
				</th>
			</tr>
			<tr class="hl_setting">
				<td class="label">
					<label for="license"><strong><?php echo $engine->_t('DefaultLicense');?>:</strong><br>
					<small><?php echo $engine->_t('');?></small></label>
				</td>
				<td>
					<select id="license" name="license">
<?php
					$licenses = $engine->_t('License');

					foreach ($licenses as $offset => $license)
					{
						if (strlen($license) > 50)
						{
							$license = substr($license, 0, 45 ) . '...';
						}

						echo '<option value="' . $offset . '" ' .
							($engine->db->license == $offset
								? 'selected '
								: '') .
							'>' . '[ ' . $offset . ' ] ' . $license . "</option>\n";
					}
?>
					</select>
				</td>
			</tr>
			<tr>
				<th colspan="2">
					<br>
					<?php echo $engine->_t('ServicePagesSection');?>
				</th>
			</tr>
			<tr class="hl_setting">
				<td class="label">
					<label for="root_page"><strong><?php echo $engine->_t('RootPage');?>:</strong><br>
					<small><?php echo $engine->_t('RootPageInfo');?></small></label>
				</td>
				<td>
					<input type="text" maxlength="255" id="root_page" name="root_page" value="<?php echo htmlspecialchars($engine->db->root_page, ENT_COMPAT | ENT_HTML5, HTML_ENTITIES_CHARSET);?>">
				</td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl_setting">
				<td class="label">
					<label for="policy_page"><strong><?php echo $engine->_t('PolicyPage');?>:</strong><br>
					<small><?php echo $engine->_t('PolicyPageInfo');?></small></label>
				</td>
				<td>
					<input type="text" maxlength="255" id="policy_page" name="policy_page" value="<?php echo htmlspecialchars($engine->db->policy_page, ENT_COMPAT | ENT_HTML5, HTML_ENTITIES_CHARSET);?>">
				</td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl_setting">
				<td class="label">
					<label for="search_page"><strong><?php echo $engine->_t('SearchPage');?>:</strong><br>
					<small><?php echo $engine->_t('SearchPageInfo');?></small></label>
				</td>
				<td>
					<input type="text" maxlength="255" id="search_page" name="search_page" value="<?php echo htmlspecialchars($engine->db->search_page, ENT_COMPAT | ENT_HTML5, HTML_ENTITIES_CHARSET);?>">
				</td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl_setting">
				<td class="label">
					<label for="registration_page"><strong><?php echo $engine->_t('RegistrationPage');?>:</strong><br>
					<small><?php echo $engine->_t('RegistrationPageInfo');?></small></label>
				</td>
				<td>
					<input type="text" maxlength="255" id="registration_page" name="registration_page" value="<?php echo htmlspecialchars($engine->db->registration_page, ENT_COMPAT | ENT_HTML5, HTML_ENTITIES_CHARSET);?>">
				</td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl_setting">
				<td class="label">
					<label for="login_page"><strong><?php echo $engine->_t('LoginPage');?>:</strong><br>
					<small><?php echo $engine->_t('LoginPageInfo');?></small></label>
				</td>
				<td>
					<input type="text" maxlength="255" id="login_page" name="login_page" value="<?php echo htmlspecialchars($engine->db->login_page, ENT_COMPAT | ENT_HTML5, HTML_ENTITIES_CHARSET);?>">
				</td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl_setting">
				<td class="label">
					<label for="settings_page"><strong><?php echo $engine->_t('SettingsPage');?>:</strong><br>
					<small><?php echo $engine->_t('SettingsPageInfo');?></small></label>
				</td>
				<td>
					<input type="text" maxlength="255" id="settings_page" name="settings_page" value="<?php echo htmlspecialchars($engine->db->settings_page, ENT_COMPAT | ENT_HTML5, HTML_ENTITIES_CHARSET);?>">
				</td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl_setting">
				<td class="label">
					<label for="password_page"><strong><?php echo $engine->_t('PasswordPage');?>:</strong><br>
					<small><?php echo $engine->_t('PasswordPageInfo');?></small></label>
				</td>
				<td>
					<input type="text" maxlength="255" id="password_page" name="password_page" value="<?php echo htmlspecialchars($engine->db->password_page, ENT_COMPAT | ENT_HTML5, HTML_ENTITIES_CHARSET);?>">
				</td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl_setting">
				<td class="label">
					<label for="users_page"><strong><?php echo $engine->_t('UsersPage');?>:</strong><br>
					<small><?php echo $engine->_t('UsersPageInfo');?></small></label>
				</td>
				<td>
					<input type="text" maxlength="255" id="users_page" name="users_page" value="<?php echo htmlspecialchars($engine->db->users_page, ENT_COMPAT | ENT_HTML5, HTML_ENTITIES_CHARSET);?>">
				</td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl_setting">
				<td class="label">
					<label for="category_page"><strong><?php echo $engine->_t('CategoryPage');?> :</strong><br>
					<small><?php echo $engine->_t('CategoryPageInfo');?></small></label>
				</td>
				<td>
					<input type="text" maxlength="255" id="category_page" name="category_page" value="<?php echo htmlspecialchars($engine->db->category_page, ENT_COMPAT | ENT_HTML5, HTML_ENTITIES_CHARSET);?>">
				</td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl_setting">
				<td class="label">
					<label for="tag_page"><strong><?php echo $engine->_t('TagPage');?> :</strong><br>
					<small><?php echo $engine->_t('TagPageInfo');?></small></label>
				</td>
				<td>
					<input type="text" maxlength="255" id="tag_page" name="tag_page" value="<?php echo htmlspecialchars($engine->db->tag_page, ENT_COMPAT | ENT_HTML5, HTML_ENTITIES_CHARSET);?>">
				</td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl_setting">
				<td class="label">
					<label for="groups_page"><strong><?php echo $engine->_t('GroupsPage');?>:</strong><br>
					<small><?php echo $engine->_t('GroupsPageInfo');?></small></label>
				</td>
				<td>
					<input type="text" maxlength="255" id="groups_page" name="groups_page" value="<?php echo htmlspecialchars($engine->db->groups_page, ENT_COMPAT | ENT_HTML5, HTML_ENTITIES_CHARSET);?>">
				</td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl_setting">
				<td class="label">
					<label for="changes_page"><strong><?php echo $engine->_t('ChangesPage');?>:</strong><br>
					<small><?php echo $engine->_t('ChangesPageInfo');?></small></label>
				</td>
				<td>
					<input type="text" maxlength="255" id="changes_page" name="changes_page" value="<?php echo htmlspecialchars($engine->db->changes_page, ENT_COMPAT | ENT_HTML5, HTML_ENTITIES_CHARSET);?>">
				</td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl_setting">
				<td class="label">
					<label for="comments_page"><strong><?php echo $engine->_t('CommentsPage');?>:</strong><br>
					<small><?php echo $engine->_t('CommentsPageInfo');?></small></label>
				</td>
				<td>
					<input type="text" maxlength="255" id="comments_page" name="comments_page" value="<?php echo htmlspecialchars($engine->db->comments_page, ENT_COMPAT | ENT_HTML5, HTML_ENTITIES_CHARSET);?>">
				</td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl_setting">
				<td class="label">
					<label for="removals_page"><strong><?php echo $engine->_t('RemovalsPage');?>:</strong><br>
					<small><?php echo $engine->_t('RemovalsPageInfo');?></small></label>
				</td>
				<td>
					<input type="text" maxlength="255" id="removals_page" name="removals_page" value="<?php echo htmlspecialchars($engine->db->removals_page, ENT_COMPAT | ENT_HTML5, HTML_ENTITIES_CHARSET);?>">
				</td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl_setting">
				<td class="label">
					<label for="wanted_page"><strong><?php echo $engine->_t('WantedPage');?>:</strong><br>
					<small><?php echo $engine->_t('WantedPageInfo');?></small></label>
				</td>
				<td>
					<input type="text" maxlength="255" id="wanted_page" name="wanted_page" value="<?php echo htmlspecialchars($engine->db->wanted_page, ENT_COMPAT | ENT_HTML5, HTML_ENTITIES_CHARSET);?>">
				</td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl_setting">
				<td class="label">
					<label for="orphaned_page"><strong><?php echo $engine->_t('OrphanedPage');?>:</strong><br>
					<small><?php echo $engine->_t('OrphanedPageInfo');?></small></label>
				</td>
				<td>
					<input type="text" maxlength="255" id="orphaned_page" name="orphaned_page" value="<?php echo htmlspecialchars($engine->db->orphaned_page, ENT_COMPAT | ENT_HTML5, HTML_ENTITIES_CHARSET);?>">
				</td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl_setting">
				<td class="label">
					<label for="todo_page"><strong><?php echo $engine->_t('TodoPage');?>:</strong><br>
					<small><?php echo $engine->_t('TodoPageInfo');?></small></label>
				</td>
				<td>
					<input type="text" maxlength="255" id="todo_page" name="todo_page" value="<?php echo htmlspecialchars($engine->db->todo_page, ENT_COMPAT | ENT_HTML5, HTML_ENTITIES_CHARSET);?>">
				</td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl_setting">
				<td class="label">
					<label for="sandbox"><strong><?php echo $engine->_t('SandboxPage');?>:</strong><br>
					<small><?php echo $engine->_t('SandboxPageInfo');?></small></label>
				</td>
				<td>
					<input type="text" maxlength="255" id="sandbox" name="sandbox" value="<?php echo htmlspecialchars($engine->db->sandbox, ENT_COMPAT | ENT_HTML5, HTML_ENTITIES_CHARSET);?>">
				</td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl_setting">
				<td class="label">
					<label for="wiki_docs"><strong><?php echo $engine->_t('WikiDocsPage');?>:</strong><br>
					<small><?php echo $engine->_t('WikiDocsPageInfo');?></small></label>
				</td>
				<td>
					<input type="text" maxlength="255" id="wiki_docs" name="wiki_docs" value="<?php echo htmlspecialchars($engine->db->wiki_docs, ENT_COMPAT | ENT_HTML5, HTML_ENTITIES_CHARSET);?>">
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
