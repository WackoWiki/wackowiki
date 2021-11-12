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
	<p>
		<?php echo $engine->_t('PagesSettingsInfo');?>
	</p>
	<br>
<?php
	$sanitize_tag = function ($tag) use ($engine)
	{
		$engine->sanitize_page_tag($tag);

		return utf8_trim($tag, '/');
	};

	// Regular expression (SQL regexp-slang), specifying the number of intermediate levels of the news root cluster
	// directly to the names of pages of news reports (e.g. [cluster]/[year]/[month] -> /.+/.+/.+).
	$count_levels = function ($tag, $sub) use ($engine)
	{
		$engine->sanitize_page_tag($tag);
		$levels = $engine->get_page_depth($tag . $sub);

		return str_repeat('/.+', $levels);
	};

	// update settings
	if (isset($_POST['action']) && $_POST['action'] == 'update')
	{
		$config['list_count']				= (int) $_POST['list_count'];
		$config['forum_cluster']			= (string) $sanitize_tag($_POST['forum_cluster']);
		$config['forum_topics']				= (int) $_POST['forum_topics'];
		$config['comments_count']			= (int) $_POST['comments_count'];
		$config['news_cluster']				= (string) $sanitize_tag($_POST['news_cluster']);
		$config['news_structure']			= (string) $_POST['news_structure'];
		$config['news_levels']				= (string) $count_levels($_POST['news_cluster'], $_POST['news_structure']);
		$config['enable_license']			= (int) $_POST['enable_license'];
		$config['license']					= (string) $_POST['license'];
		$config['allow_license_per_page']	= (int) $_POST['license_per_page'];
		$config['root_page']				= (string) $sanitize_tag($_POST['root_page']);
		$config['help_page']				= (string) $sanitize_tag($_POST['help_page']);
		$config['privacy_page']				= (string) $sanitize_tag($_POST['privacy_page']);
		$config['terms_page']				= (string) $sanitize_tag($_POST['terms_page']);
		$config['search_page']				= (string) $sanitize_tag($_POST['search_page']);
		$config['registration_page']		= (string) $sanitize_tag($_POST['registration_page']);
		$config['login_page']				= (string) $sanitize_tag($_POST['login_page']);
		$config['account_page']				= (string) $sanitize_tag($_POST['account_page']);
		$config['password_page']			= (string) $sanitize_tag($_POST['password_page']);
		$config['users_page']				= (string) $sanitize_tag($_POST['users_page']);
		$config['category_page']			= (string) $sanitize_tag($_POST['category_page']);
		$config['tag_page']					= (string) $sanitize_tag($_POST['tag_page']);
		$config['groups_page']				= (string) $sanitize_tag($_POST['groups_page']);
		$config['changes_page']				= (string) $sanitize_tag($_POST['changes_page']);
		$config['comments_page']			= (string) $sanitize_tag($_POST['comments_page']);
		$config['index_page']				= (string) $sanitize_tag($_POST['index_page']);
		$config['random_page']				= (string) $sanitize_tag($_POST['random_page']);
		$config['removals_page']			= (string) $sanitize_tag($_POST['removals_page']);
		$config['wanted_page']				= (string) $sanitize_tag($_POST['wanted_page']);
		$config['orphaned_page']			= (string) $sanitize_tag($_POST['orphaned_page']);
		$config['sandbox']					= (string) $sanitize_tag($_POST['sandbox']);

		$engine->config->_set($config);

		$engine->log(1, $engine->_t('PagesSettingsUpdated', SYSTEM_LANG));
		$engine->set_message($engine->_t('PagesSettingsUpdated'), 'success');
		$engine->http->redirect($engine->href());
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
			<tr class="hl-setting">
				<td class="label">
					<label for="list_count"><strong><?php echo $engine->_t('ListCount');?>:</strong><br>
					<small><?php echo $engine->_t('ListCountInfo');?></small></label>
				</td>
				<td>
					<input type="number" min="0" maxlength="3" id="list_count" name="list_count" value="<?php echo (int) $engine->db->list_count;?>">
				</td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl-setting">
				<td class="label">
					<label for="comments_count"><strong><?php echo $engine->_t('CommentsCount');?>:</strong><br>
					<small><?php echo $engine->_t('CommentsCountInfo');?></small></label>
				</td>
				<td>
					<input type="number" min="0" maxlength="3" id="comments_count" name="comments_count" value="<?php echo (int) $engine->db->comments_count;?>">
				</td>
			</tr>
			<tr>
				<th colspan="2"><?php echo $engine->_t('ForumSection');?></th>
			</tr>
			<tr class="hl-setting">
				<td class="label">
					<label for="forum_cluster"><strong><?php echo $engine->_t('ForumCluster');?>:</strong><br>
					<small><?php echo Ut::perc_replace($engine->_t('ForumClusterInfo'), '<code>{{forums}}</code>');?></small></label>
				</td>
				<td>
					<input type="text" maxlength="255" id="forum_cluster" name="forum_cluster" value="<?php echo Ut::html($engine->db->forum_cluster);?>">
				</td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl-setting">
				<td class="label">
					<label for="forum_topics"><strong><?php echo $engine->_t('ForumTopics');?>:</strong><br>
					<small><?php echo Ut::perc_replace($engine->_t('ForumTopicsInfo'), '<code>{{topics}}</code>');?></small></label>
				</td>
				<td>
					<input type="number" min="0" maxlength="3" id="forum_topics" name="forum_topics" value="<?php echo (int) $engine->db->forum_topics;?>">
				</td>
			</tr>
			<tr>
				<th colspan="2">
					<br>
					<?php echo $engine->_t('NewsSection');?>
				</th>
			</tr>
			<tr class="hl-setting">
				<td class="label">
					<label for="news_cluster"><strong><?php echo $engine->_t('NewsCluster');?>:</strong><br>
					<small><?php echo Ut::perc_replace($engine->_t('NewsClusterInfo'), '<code>{{news}}</code>');?></small></label>
				</td>
				<td>
					<input type="text" maxlength="255" id="news_cluster" name="news_cluster" value="<?php echo Ut::html($engine->db->news_cluster);?>">
				</td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl-setting">
				<td class="label">
					<label for="news_structure"><strong><?php echo $engine->_t('NewsStructure');?>:</strong><br>
					<small><?php echo $engine->_t('NewsStructureInfo');?></small></label>
				</td>
				<td>
					<select id="news_structure" name="news_structure">
						<option value=""<?php		echo ($engine->db->news_structure == ''		? ' selected' : '');?>>--</option>
						<option value="Y/"<?php		echo ($engine->db->news_structure == 'Y/'	? ' selected' : '');?>>Y</option>
						<option value="Y/m/"<?php	echo ($engine->db->news_structure == 'Y/m/'	? ' selected' : '');?>>Y/m</option>
						<option value="Y/W/"<?php	echo ($engine->db->news_structure == 'Y/W/'	? ' selected' : '');?>>Y/W</option>
					</select>
					<?php
					// needs to be numeric for ordering
					switch ($engine->db->news_structure)
					{
						case 'Y/':
							$news_structure = date('Y/');
							break;
						case 'Y/m/':
							$news_structure = date('Y/') . date('m/');
							break;
						case 'Y/W/':
							$news_structure = date('Y/') . date('W/');
							break;
						default:
							$news_structure = '';
					}

					echo '<br><small><code>' . $engine->db->news_cluster . '/' . $news_structure . '*</code></small><br>';
					?>
				</td>
			</tr>
			<tr>
				<th colspan="2">
					<br>
					<?php echo $engine->_t('LicenseSection');?>
				</th>
			</tr>
			<tr class="hl-setting">
				<td class="label">
					<strong><?php echo $engine->_t('EnableLicense');?>:</strong><br>
					<small><?php echo $engine->_t('EnableLicenseInfo');?></small>
				</td>
				<td>
					<input type="radio" id="enable_license_on" name="enable_license" value="1"<?php echo ($engine->db->enable_license == 1 ? ' checked' : '');?>>
					<label for="enable_license_on"><?php echo $engine->_t('On');?></label>
					<input type="radio" id="enable_license_off" name="enable_license" value="0"<?php echo ($engine->db->enable_license == 0 ? ' checked' : '');?>>
					<label for="enable_license_off"><?php echo $engine->_t('Off');?></label>
				</td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl-setting">
				<td class="label">
					<label for="license"><strong><?php echo $engine->_t('DefaultLicense');?>:</strong><br>
					<small><?php echo $engine->_t('DefaultLicenseInfo');?></small></label>
				</td>
				<td>
					<?php
						$license = $engine->db->license ?? 0;
						echo $engine->show_select_license('license', $license, false);
					?>
				</td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl-setting">
				<td class="label">
					<strong><?php echo $engine->_t('LicensePerPage');?>:</strong><br>
					<small><?php echo $engine->_t('LicensePerPageInfo');?></small>
				</td>
				<td>
					<input type="radio" id="license_per_page_on" name="license_per_page" value="1"<?php echo ($engine->db->allow_license_per_page == 1 ? ' checked' : '');?>>
					<label for="license_per_page_on"><?php echo $engine->_t('On');?></label>
					<input type="radio" id="license_per_page_off" name="license_per_page" value="0"<?php echo ($engine->db->allow_license_per_page == 0 ? ' checked' : '');?>>
					<label for="license_per_page_off"><?php echo $engine->_t('Off');?></label>
				</td>
			</tr>
			<tr>
				<th colspan="2">
					<br>
					<?php echo $engine->_t('ServicePagesSection');?>
				</th>
			</tr>
			<tr class="hl-setting">
				<td class="label">
					<label for="root_page"><strong><?php echo $engine->_t('RootPage');?>:</strong><br>
					<small><?php echo $engine->_t('RootPageInfo');?></small></label>
				</td>
				<td>
					<input type="text" maxlength="255" id="root_page" name="root_page" value="<?php echo Ut::html($engine->db->root_page);?>">
				</td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl-setting">
				<td class="label">
					<label for="help_page"><strong><?php echo $engine->_t('HelpPage');?>:</strong><br>
					<small><?php echo $engine->_t('HelpPageInfo');?></small></label>
				</td>
				<td>
					<input type="text" maxlength="255" id="help_page" name="help_page" value="<?php echo Ut::html($engine->db->help_page);?>">
				</td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl-setting">
				<td class="label">
					<label for="privacy_page"><strong><?php echo $engine->_t('PrivacyPage');?>:</strong><br>
					<small><?php echo $engine->_t('PrivacyPageInfo');?></small></label>
				</td>
				<td>
					<input type="text" maxlength="255" id="privacy_page" name="privacy_page" value="<?php echo Ut::html($engine->db->privacy_page);?>">
				</td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl-setting">
				<td class="label">
					<label for="terms_page"><strong><?php echo $engine->_t('TermsPage');?>:</strong><br>
					<small><?php echo $engine->_t('TermsPageInfo');?></small></label>
				</td>
				<td>
					<input type="text" maxlength="255" id="terms_page" name="terms_page" value="<?php echo Ut::html($engine->db->terms_page);?>">
				</td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl-setting">
				<td class="label">
					<label for="search_page"><strong><?php echo $engine->_t('SearchPage');?>:</strong><br>
					<small><?php echo Ut::perc_replace($engine->_t('SearchPageInfo'), '<code>{{search}}</code>');?></small></label>
				</td>
				<td>
					<input type="text" maxlength="255" id="search_page" name="search_page" value="<?php echo Ut::html($engine->db->search_page);?>">
				</td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl-setting">
				<td class="label">
					<label for="registration_page"><strong><?php echo $engine->_t('RegistrationPage');?>:</strong><br>
					<small><?php echo Ut::perc_replace($engine->_t('RegistrationPageInfo'), '<code>{{registration}}</code>');?></small></label>
				</td>
				<td>
					<input type="text" maxlength="255" id="registration_page" name="registration_page" value="<?php echo Ut::html($engine->db->registration_page);?>">
				</td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl-setting">
				<td class="label">
					<label for="login_page"><strong><?php echo $engine->_t('LoginPage');?>:</strong><br>
					<small><?php echo Ut::perc_replace($engine->_t('LoginPageInfo'), '<code>{{login}}</code>');?></small></label>
				</td>
				<td>
					<input type="text" maxlength="255" id="login_page" name="login_page" value="<?php echo Ut::html($engine->db->login_page);?>">
				</td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl-setting">
				<td class="label">
					<label for="account_page"><strong><?php echo $engine->_t('SettingsPage');?>:</strong><br>
					<small><?php echo Ut::perc_replace($engine->_t('SettingsPageInfo'), '<code>{{usersettings}}</code>');?></small></label>
				</td>
				<td>
					<input type="text" maxlength="255" id="account_page" name="account_page" value="<?php echo Ut::html($engine->db->account_page);?>">
				</td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl-setting">
				<td class="label">
					<label for="password_page"><strong><?php echo $engine->_t('PasswordPage');?>:</strong><br>
					<small><?php echo Ut::perc_replace($engine->_t('PasswordPageInfo'), '<code>{{changepassword}}</code>');?></small></label>
				</td>
				<td>
					<input type="text" maxlength="255" id="password_page" name="password_page" value="<?php echo Ut::html($engine->db->password_page);?>">
				</td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl-setting">
				<td class="label">
					<label for="users_page"><strong><?php echo $engine->_t('UsersPage');?>:</strong><br>
					<small><?php echo Ut::perc_replace($engine->_t('UsersPageInfo'), '<code>{{users}}</code>');?></small></label>
				</td>
				<td>
					<input type="text" maxlength="255" id="users_page" name="users_page" value="<?php echo Ut::html($engine->db->users_page);?>">
				</td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl-setting">
				<td class="label">
					<label for="category_page"><strong><?php echo $engine->_t('CategoryPage');?> :</strong><br>
					<small><?php echo Ut::perc_replace($engine->_t('CategoryPageInfo'), '<code>{{category}}</code>');?></small></label>
				</td>
				<td>
					<input type="text" maxlength="255" id="category_page" name="category_page" value="<?php echo Ut::html($engine->db->category_page);?>">
				</td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl-setting">
				<td class="label">
					<label for="tag_page"><strong><?php echo $engine->_t('TagPage');?> :</strong><br>
					<small><?php echo Ut::perc_replace($engine->_t('TagPageInfo'), '<code>{{tag}}</code>');?></small></label>
				</td>
				<td>
					<input type="text" maxlength="255" id="tag_page" name="tag_page" value="<?php echo Ut::html($engine->db->tag_page);?>">
				</td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl-setting">
				<td class="label">
					<label for="groups_page"><strong><?php echo $engine->_t('GroupsPage');?>:</strong><br>
					<small><?php echo Ut::perc_replace($engine->_t('GroupsPageInfo'), '<code>{{usergroups}}</code>');?></small></label>
				</td>
				<td>
					<input type="text" maxlength="255" id="groups_page" name="groups_page" value="<?php echo Ut::html($engine->db->groups_page);?>">
				</td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl-setting">
				<td class="label">
					<label for="changes_page"><strong><?php echo $engine->_t('ChangesPage');?>:</strong><br>
					<small><?php echo Ut::perc_replace($engine->_t('ChangesPageInfo'), '<code>{{changes}}</code>');?></small></label>
				</td>
				<td>
					<input type="text" maxlength="255" id="changes_page" name="changes_page" value="<?php echo Ut::html($engine->db->changes_page);?>">
				</td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl-setting">
				<td class="label">
					<label for="comments_page"><strong><?php echo $engine->_t('CommentsPage');?>:</strong><br>
					<small><?php echo Ut::perc_replace($engine->_t('CommentsPageInfo'), '<code>{{commented}}</code>');?></small></label>
				</td>
				<td>
					<input type="text" maxlength="255" id="comments_page" name="comments_page" value="<?php echo Ut::html($engine->db->comments_page);?>">
				</td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl-setting">
				<td class="label">
					<label for="index_page"><strong><?php echo $engine->_t('IndexPage');?>:</strong><br>
					<small><?php echo Ut::perc_replace($engine->_t('IndexPageInfo'), '<code>{{pageindex}}</code>');?></small></label>
				</td>
				<td>
					<input type="text" maxlength="255" id="index_page" name="index_page" value="<?php echo Ut::html($engine->db->index_page);?>">
				</td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl-setting">
				<td class="label">
					<label for="random_page"><strong><?php echo $engine->_t('RandomPage');?>:</strong><br>
					<small><?php echo Ut::perc_replace($engine->_t('RandomPageInfo'), '<code>{{randompage}}</code>');?></small></label>
				</td>
				<td>
					<input type="text" maxlength="255" id="random_page" name="random_page" value="<?php echo Ut::html($engine->db->random_page);?>">
				</td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl-setting">
				<td class="label">
					<label for="removals_page"><strong><?php echo $engine->_t('RemovalsPage');?>:</strong><br>
					<small><?php echo Ut::perc_replace($engine->_t('RemovalsPageInfo'), '<code>{{deleted}}</code>');?></small></label>
				</td>
				<td>
					<input type="text" maxlength="255" id="removals_page" name="removals_page" value="<?php echo Ut::html($engine->db->removals_page);?>">
				</td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl-setting">
				<td class="label">
					<label for="wanted_page"><strong><?php echo $engine->_t('WantedPage');?>:</strong><br>
					<small><?php echo Ut::perc_replace($engine->_t('WantedPageInfo'), '<code>{{wanted}}</code>');?></small></label>
				</td>
				<td>
					<input type="text" maxlength="255" id="wanted_page" name="wanted_page" value="<?php echo Ut::html($engine->db->wanted_page);?>">
				</td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl-setting">
				<td class="label">
					<label for="orphaned_page"><strong><?php echo $engine->_t('OrphanedPage');?>:</strong><br>
					<small><?php echo Ut::perc_replace($engine->_t('OrphanedPageInfo'), '<code>{{orphaned}}</code>');?></small></label>
				</td>
				<td>
					<input type="text" maxlength="255" id="orphaned_page" name="orphaned_page" value="<?php echo Ut::html($engine->db->orphaned_page);?>">
				</td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr class="hl-setting">
				<td class="label">
					<label for="sandbox"><strong><?php echo $engine->_t('SandboxPage');?>:</strong><br>
					<small><?php echo $engine->_t('SandboxPageInfo');?></small></label>
				</td>
				<td>
					<input type="text" maxlength="255" id="sandbox" name="sandbox" value="<?php echo Ut::html($engine->db->sandbox);?>">
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

