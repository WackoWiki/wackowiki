<?php

if (!defined('IN_WACKO'))
{
	exit;
}

########################################################
##   DB Synchronization                               ##
########################################################

$module['db_resync'] = array(
		'order'	=> 28,
		'cat'	=> 'Database',
		'status'=> (RECOVERY_MODE ? false : true),
		'mode'	=> 'db_resync',
		'name'	=> 'Data Synchronization',
		'title'	=> 'Synchronizing databases',
	);

########################################################

function admin_db_resync(&$engine, &$module)
{
?>
	<h1><?php echo $module['title']; ?></h1>
	<br />
<?php
	if (isset($_REQUEST['start']))
	{
		if ($_REQUEST['action'] == 'userstats')
		{
			// total pages in ownership
			$users1 = $engine->load_all(
				"SELECT u.user_id, COUNT(p.tag) AS n ".
				"FROM {$engine->config['table_prefix']}page AS p, {$engine->config['user_table']} AS u ".
				"WHERE p.owner_id = u.user_id AND p.comment_on_id = '0' ".
				"AND p.deleted <> '1' ".
				"GROUP BY p.owner_id");

			// missing pages
			$users2 =  $engine->load_all(
				"SELECT
					u.user_id, '0' as n
				FROM
					{$engine->config['table_prefix']}user u
					LEFT JOIN {$engine->config['table_prefix']}page p ON (u.user_id = p.owner_id)
				WHERE
					u.total_pages <> '0'
				AND
					p.owner_id IS NULL");

			$users = array_merge($users1, $users2);

			foreach ($users as $user)
			{
				$engine->sql_query(
					"UPDATE {$engine->config['user_table']} ".
					"SET total_pages = ".(int)$user['n']." ".
					"WHERE user_id = '".$user['user_id']."' ".
					"LIMIT 1");
			}

			// total comments posted
			$users1 = $engine->load_all(
				"SELECT p.user_id, COUNT(p.tag) AS n ".
				"FROM {$engine->config['table_prefix']}page AS p, {$engine->config['user_table']} AS u ".
				"WHERE p.owner_id = u.user_id AND p.comment_on_id <> '0' ".
				"AND p.deleted <> '1' ".
				"GROUP BY p.user_id");

			// missing comments
			$users2 =  $engine->load_all(
				"SELECT
					u.user_id, '0' as n
				FROM
					{$engine->config['table_prefix']}user u
					LEFT JOIN {$engine->config['table_prefix']}page p ON (u.user_id = p.owner_id)
				WHERE
					(u.total_comments <> '0'
					AND
					p.owner_id IS NULL
					OR
					(p.owner_id = u.user_id AND p.comment_on_id = '0' ".
					"AND p.deleted <> '1' ))
				");

			$users = array_merge($users1, $users2);

			foreach ($users as $user)
			{
				$engine->sql_query(
					"UPDATE {$engine->config['user_table']} ".
					"SET total_comments = ".(int)$user['n']." ".
					"WHERE user_id = '".$user['user_id']."' ".
					"LIMIT 1");
			}

			// total revisions made
			$users = $engine->load_all(
				"SELECT r.user_id, COUNT(r.tag) AS n ".
				"FROM {$engine->config['table_prefix']}revision AS r, {$engine->config['user_table']} AS u ".
				"WHERE r.owner_id = u.user_id AND r.comment_on_id = '0' ".
				"GROUP BY r.user_id");

			foreach ($users as $user)
			{
				$engine->sql_query(
					"UPDATE {$engine->config['user_table']} ".
					"SET total_revisions = ".(int)$user['n']." ".
					"WHERE user_id = '".$user['user_id']."' ".
					"LIMIT 1");
			}

			// total files uploaded
			$users = $engine->load_all(
					"SELECT u.user_id, COUNT(f.upload_id) AS n ".
					"FROM {$engine->config['table_prefix']}upload f, {$engine->config['user_table']} AS u ".
					"WHERE f.user_id = u.user_id ".
					"AND f.deleted <> '1' ".
					"GROUP BY f.user_id");

			foreach ($users as $user)
			{
				$engine->sql_query(
					"UPDATE {$engine->config['user_table']} ".
					"SET total_uploads = ".(int)$user['n']." ".
					"WHERE user_id = '".$user['user_id']."' ".
					"LIMIT 1");
			}

			$engine->log(1, 'Synchronized user statistics');

			$message = 'User Statistics synchronized.';
			$engine->show_message($message);
		}
		else if ($_REQUEST['action'] == 'rssfeeds')
		{
			$engine->use_class('rss');
			$xml = new rss($engine);
			$xml->changes();
			$xml->comments();

			if ($engine->config['news_cluster'])
			{
				$xml->news();
			}

			$engine->log(1, 'Synchronized RSS feeds');
			unset($xml);

				$message = 'RSS-feeds updated.';
				$engine->show_message($message);
		}
		else if ($_REQUEST['action'] == 'wikilinks')
		{
			$limit = 50;

			if (isset($_REQUEST['i']))
			{
				$i = $_REQUEST['i'];
			}
			else
			{
				// truncate table
				$i = 0;
				$engine->sql_query("DELETE FROM {$engine->config['table_prefix']}link");
			}

			$engine->set_user_setting('dont_redirect', '1');

			if ($pages = $engine->load_all(
			"SELECT page_id, tag, body, body_r, body_toc, comment_on_id
			FROM {$engine->config['table_prefix']}page
			LIMIT ".($i * $limit).", $limit"))
			{
				foreach ($pages as $n => $page)
				{
					echo (($i * $limit) + $n + 1).'. '.$page['tag']."<br />\n";

					// recompile if necessary
					if ($page['body_r'] == '')
					{

						// build html body
						$page['body_r'] = $engine->format($page['body'], 'wacko');

						// build toc
						if ($engine->config['paragrafica'] && $page['comment_on_id'] == 0 && $page['body_toc'] == '')
						{
							$page['body_r']		= $engine->format($page['body_r'], 'paragrafica');
							$page['body_toc']	= $engine->body_toc;
						}

						// store to DB
						$engine->sql_query(
							"UPDATE {$engine->config['table_prefix']}page SET ".
								"body_r		= '".quote($engine->dblink, $page['body_r'])."', ".
								"body_toc	= '".quote($engine->dblink, $page['body_toc'])."' ".
							"WHERE page_id = '".$page['page_id']."' ".
							"LIMIT 1");

						#if ($body_t) unset($body_t);
					}

					// rendering links
					$engine->context[++$engine->current_context] = ( $page['comment_on_id'] ? $page['comment_on_id'] : $page['tag'] );
					$engine->update_link_table($page['page_id'], $page['body_r']);
					$engine->current_context--;
				}

				$engine->redirect(rawurldecode($engine->href('', 'admin.php', 'mode='.$module['mode'].'&amp;start=1&amp;action=wikilinks&amp;i='.(++$i))));
			}
			else
			{
				$message = 'Wiki-links restored.';
				$engine->show_message($message);
			}
		}
	}
?>
	<h3>User statistics</h3>
	<br />
	<p>
		User statistics (number of comments and pages owned)
		in some situations may differ from actual data. This operation
		allows updating statistics on current actual data of the database.
	</p>
	<br />
<?php
	echo $engine->form_open('usersupdate', '', 'post', true, '', '');
?>
		<input type="hidden" name="action" value="userstats" />
		<input name="start" id="submit" type="submit" value="synchronize" />
<?php	echo $engine->form_close();?>
	<br />
	<hr />
	<h3>RSS-Feeds</h3>
	<br />
	<p>
		In the case of direct editing of pages in the database, the content of RSS-feeds are not
		reflect the changes made. This function synchronizes the RSS-channels
		Current state of the database.
	</p>
	<br />
<?php
	echo $engine->form_open('usersupdate', '', 'post', true, '', '');
?>
		<input type="hidden" name="action" value="rssfeeds" />
		<input name="start" id="submit" type="submit" value="synchronize" />
<?php		echo $engine->form_close();;?>
	<br />
	<hr />
	<h3>Wiki-links</h3>
	<br />
	<p>
		Performs re-rendering all intrasite links and restores
		the contents of the table 'links' in the event of damage or injury (this can take
		considerable time).
	</p>
	<br />
<?php
	echo $engine->form_open('usersupdate', '', 'post', true, '', '');
?>
		<input type="hidden" name="action" value="wikilinks" />
		<input name="start" id="submit" type="submit" value="synchronize" />
<?php
	echo $engine->form_close();;
}

?>