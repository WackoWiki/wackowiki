<?php

########################################################
##   Pages settings                                   ##
########################################################

$module['configpages'] = array(
		'order'	=> 2,
		'cat'	=> 'Preferences',
		'mode'	=> 'configpages',
		'name'	=> 'Pages',
		'title'	=> 'Pages and site parameters',
	);

########################################################

function admin_configpages(&$engine, &$module)
{
?>
	<h1><?php echo $module['title']; ?></h1>
	<br />
<?php
	// update settings
	if (isset($_POST['action']) && $_POST['action'] == 'update')
	{
		$config['forum_cluster']		= trim((string)$_POST['forum_cluster'], '/');
		$config['forum_topics']			= (int)$_POST['forum_topics'];
		$config['comments_count']		= (int)$_POST['comments_count'];
		$config['news_cluster']			= trim((string)$_POST['news_cluster'], '/');
		$config['news_levels']			= (string)$_POST['news_levels'];
		$config['root_page']			= trim((string)$_POST['root_page'], '/');
		$config['policy_page']			= trim((string)$_POST['policy_page'], '/');
		$config['search_page']			= trim((string)$_POST['search_page'], '/');
		$config['registration_page']	= trim((string)$_POST['registration_page'], '/');
		$config['login_page']			= trim((string)$_POST['login_page'], '/');
		$config['settings_page']		= trim((string)$_POST['settings_page'], '/');
		$config['password_page']		= trim((string)$_POST['password_page'], '/');
		$config['users_page']			= trim((string)$_POST['users_page'], '/');
		$config['groups_page']			= trim((string)$_POST['groups_page'], '/');
		$config['changes_page']			= trim((string)$_POST['changes_page'], '/');
		$config['comments_page']		= trim((string)$_POST['comments_page'], '/');
		$config['removals_page']		= trim((string)$_POST['removals_page'], '/');
		$config['wanted_page']			= trim((string)$_POST['wanted_page'], '/');
		$config['orphaned_page']		= trim((string)$_POST['orphaned_page'], '/');
		$config['todo_page']			= trim((string)$_POST['todo_page'], '/');
		$config['sandbox']				= trim((string)$_POST['sandbox'], '/');
		$config['wiki_docs']			= trim((string)$_POST['wiki_docs'], '/');


		foreach($config as $key => $value)
		{
			$engine->query(
				"UPDATE {$engine->config['table_prefix']}config SET value = '$value' WHERE config_name = '$key'");
		}
		$engine->log(1, 'Updated settings base pages');
		$engine->redirect(rawurldecode($engine->href()));
	}
?>
	<form action="admin.php" method="post" name="pages">
		<input type="hidden" name="mode" value="configpages" />
		<input type="hidden" name="action" value="update" />
		<table cellspacing="3" class="formation">
			<tr>
				<th colspan="2">Options Forum</th>
			</tr>
			<tr>
				<td class="label"><label for="forum_cluster"><strong>Cluster Forum:</strong><br />
				<small>Address of the index (main) page of the forum.</small></label></td>
				<td style="width:40%;"><input maxlength="255" style="width:200px;" id="forum_cluster" name="forum_cluster" value="<?php echo htmlspecialchars($engine->config['forum_cluster']);?>" /></td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr>
				<td class="label"><label for="forum_topics"><strong>Number of topics per page:</strong><br />
				<small>Number of topics displayed on each page of the list in the forum sections.</small></label></td>
				<td><input maxlength="3" style="width:200px;" id="forum_topics" name="forum_topics" value="<?php echo htmlspecialchars($engine->config['forum_topics']);?>" /></td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr>
				<td class="label"><label for="comments_count"><strong>Number of comments per page:</strong><br />
				<small>Number of comments displayed on each page list of comments. This applies to all the comments on the site, and not just posted in the forum.</small></label></td>
				<td><input maxlength="3" style="width:200px;" id="comments_count" name="comments_count" value="<?php echo htmlspecialchars($engine->config['comments_count']);?>" /></td>
			</tr>
			<tr>
				<th colspan="2">
					<br />
					Section News
				</th>
			</tr>
			<tr>
				<td class="label"><label for="news_cluster"><strong>Cluster of the News:</strong><br />
				<small>Root cluster news section.</small></label></td>
				<td><input maxlength="255" style="width:200px;" id="news_cluster" name="news_cluster" value="<?php echo htmlspecialchars($engine->config['news_cluster']);?>" /></td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr>
				<td class="label"><label for="news_levels"><strong>Depth of news pages from the root cluster:</strong><br />
				<small>Regular expression (SQL regexp-slang), specifying the number of intermediate levels of the news root cluster directly to the names of pages of news reports. (e.g. /.+/.+/.+)</small></label></td>
				<td><input maxlength="255" style="width:200px;" id="news_levels" name="news_levels" value="<?php echo htmlspecialchars($engine->config['news_levels']);?>" /></td>
			</tr>
			<tr>
				<th colspan="2">
					<br />
					Service pages
				</th>
			</tr>
			<tr>
				<td class="label"><label for="root_page"><strong>Home page:</strong><br />
				<small>Tag your main page, opens automatically when a user visits your site.</small></label></td>
				<td><input maxlength="255" style="width:200px;" id="root_page" name="root_page" value="<?php echo htmlspecialchars($engine->config['root_page']);?>" /></td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr>
				<td class="label"><label for="policy_page"><strong>Policies and Regulations:</strong><br />
				<small>The page with the rules of the site.</small></label></td>
				<td><input maxlength="255" style="width:200px;" id="policy_page" name="policy_page" value="<?php echo htmlspecialchars($engine->config['policy_page']);?>" /></td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr>
				<td class="label"><label for="search_page"><strong>Search:</strong><br />
				<small>Page with the search form (action <tt>{{Search}}</tt>).</small></label></td>
				<td><input maxlength="255" style="width:200px;" id="search_page" name="search_page" value="<?php echo htmlspecialchars($engine->config['search_page']);?>" /></td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr>
				<td class="label"><label for="registration_page"><strong>Register on our site:</strong><br />
				<small>Page new user registration (action <tt>{{Registration}}</tt>).</small></label></td>
				<td><input maxlength="255" style="width:200px;" id="registration_page" name="registration_page" value="<?php echo htmlspecialchars($engine->config['registration_page']);?>" /></td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr>
				<td class="label"><label for="login_page"><strong>User login:</strong><br />
				<small>Login page on the site (action <tt>{{Login}}</tt>).</small></label></td>
				<td><input maxlength="255" style="width:200px;" id="login_page" name="login_page" value="<?php echo htmlspecialchars($engine->config['login_page']);?>" /></td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr>
				<td class="label"><label for="settings_page"><strong>Profile Settings:</strong><br />
				<small>Page customize the user profile (action <tt>{{UserSettings}}</tt>).</small></label></td>
				<td><input maxlength="255" style="width:200px;" id="settings_page" name="settings_page" value="<?php echo htmlspecialchars($engine->config['settings_page']);?>" /></td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr>
				<td class="label"><label for="password_page"><strong>Change Password:</strong><br />
				<small>Page with a form to change / query user password (action <tt>{{ChangePassword}}</tt>).</small></label></td>
				<td><input maxlength="255" style="width:200px;" id="password_page" name="password_page" value="<?php echo htmlspecialchars($engine->config['password_page']);?>" /></td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr>
				<td class="label"><label for="users_page"><strong>User list:</strong><br />
				<small>Page with a list of registered users (action <tt>{{Users}}</tt>).</small></label></td>
				<td><input maxlength="255" style="width:200px;" id="users_page" name="users_page" value="<?php echo htmlspecialchars($engine->config['users_page']);?>" /></td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr>
				<td class="label"><label for="groups_page"><strong>List groups:</strong><br />
				<small>Page with a list of working groups (action <tt>{{UserGroups}}</tt>).</small></label></td>
				<td><input maxlength="255" style="width:200px;" id="groups_page" name="groups_page" value="<?php echo htmlspecialchars($engine->config['groups_page']);?>" /></td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr>
				<td class="label"><label for="changes_page"><strong>Recent changes:</strong><br />
				<small>Page with a list of the last modified pages (action <tt>{{RecentChanges}}</tt>).</small></label></td>
				<td><input maxlength="255" style="width:200px;" id="changes_page" name="changes_page" value="<?php echo htmlspecialchars($engine->config['changes_page']);?>" /></td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr>
				<td class="label"><label for="comments_page"><strong>Recent comments:</strong><br />
				<small>Page with a list of recent comment on the page (action <tt>{{RecentlyCommented}}</tt>).</small></label></td>
				<td><input maxlength="255" style="width:200px;" id="comments_page" name="comments_page" value="<?php echo htmlspecialchars($engine->config['comments_page']);?>" /></td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr>
				<td class="label"><label for="removals_page"><strong>Deleted pages:</strong><br />
				<small>Page with a list of recently deleted pages (action <tt>{{RecentlyDeleted}}</tt>).</small></label></td>
				<td><input maxlength="255" style="width:200px;" id="removals_page" name="removals_page" value="<?php echo htmlspecialchars($engine->config['removals_page']);?>" /></td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr>
				<td class="label"><label for="wanted_page"><strong>Wanted pages:</strong><br />
				<small>Page with a list of missing pages that are referenced (action <tt>{{WantedPages}}</tt>).</small></label></td>
				<td><input maxlength="255" style="width:200px;" id="wanted_page" name="wanted_page" value="<?php echo htmlspecialchars($engine->config['wanted_page']);?>" /></td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr>
				<td class="label"><label for="orphaned_page"><strong>Orphaned pages:</strong><br />
				<small>Page with a list of existing pages are not related links with the rest (action <tt>{{OrphanedPages}}</tt>).</small></label></td>
				<td><input maxlength="255" style="width:200px;" id="orphaned_page" name="orphaned_page" value="<?php echo htmlspecialchars($engine->config['orphaned_page']);?>" /></td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr>
				<td class="label"><label for="todo_page"><strong>ToDo:</strong><br />
				<small>Page with a list of To Do (constructed with the help of <tt>{{BackLinks}}</tt> and makro <tt>::*::</tt>).</small></label></td>
				<td><input maxlength="255" style="width:200px;" id="todo_page" name="todo_page" value="<?php echo htmlspecialchars($engine->config['todo_page']);?>" /></td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr>
				<td class="label"><label for="sandbox"><strong>Sandbox:</strong><br />
				<small>Page where users can be trained in the use of wiki-markup.</small></label></td>
				<td><input maxlength="255" style="width:200px;" id="sandbox" name="sandbox" value="<?php echo htmlspecialchars($engine->config['sandbox']);?>" /></td>
			</tr>
			<tr class="lined">
				<td colspan="2"></td>
			</tr>
			<tr>
				<td class="label"><label for="wiki_docs"><strong>Wiki documentation:</strong><br />
				<small>Section of the documentation for using the tool site.</small></label></td>
				<td><input maxlength="255" style="width:200px;" id="wiki_docs" name="wiki_docs" value="<?php echo htmlspecialchars($engine->config['wiki_docs']);?>" /></td>
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
