<?php

if (!defined('IN_WACKO'))
{
	exit;
}

##########################################################
##	DB Synchronization									##
##########################################################

$module['maint_resync'] = [
		'order'	=> 601,
		'cat'	=> 'maintenance',
		'status'=> !RECOVERY_MODE,
	];

##########################################################

function admin_maint_resync($engine, $module)
{
	$prefix		= $engine->prefix;
	$batches	= [10, 20, 30, 50, 100, 200, 300, 500];
?>
	<h1><?php echo $engine->_t($module)['title']; ?></h1>
	<br>
<?php
	if (isset($_REQUEST['start']))
	{
		$action = $_REQUEST['action'] ?? null;

		if ($action == 'userstats')
		{
			// reset stats
			$sql[] = "UPDATE " . $prefix . "user SET
						total_comments	= 0,
						total_uploads	= 0,
						total_revisions	= 0,
						total_pages		= 0";

			// set total comments posted
			$sql[] = "UPDATE " . $prefix . "user u,
						(SELECT p.owner_id as user_id, COUNT(p.tag) AS n
						FROM " . $prefix . "page p,
							{$prefix}user o
						WHERE p.owner_id = o.user_id
							AND p.comment_on_id <> 0
							AND p.deleted <> 1
						GROUP BY p.owner_id) AS s
					SET
						u.total_comments = s.n
					WHERE u.user_id = s.user_id";

			// set total pages in ownership
			$sql[] = "UPDATE " . $prefix . "user u,
						(SELECT o.user_id, COUNT(p.tag) AS n
						FROM " . $prefix . "page p,
							{$prefix}user o
						WHERE p.owner_id = o.user_id
							AND p.comment_on_id = 0
							AND p.deleted <> 1
						GROUP BY p.owner_id) AS s
					SET
						u.total_pages = s.n
					WHERE u.user_id = s.user_id";

			// set total revisions made
			$sql[] = "UPDATE " . $prefix . "user u,
						(SELECT r.user_id, COUNT(r.page_id) AS n
						FROM " . $prefix . "revision r,
							{$prefix}user o
						WHERE r.owner_id = o.user_id
							AND r.comment_on_id = 0
						GROUP BY r.user_id) AS s
					SET
						u.total_revisions = s.n
					WHERE u.user_id = s.user_id";

			// set total files uploaded
			$sql[] = "UPDATE " . $prefix . "user u,
						(SELECT o.user_id, COUNT(f.file_id) AS n
						FROM " . $prefix . "file f,
							{$prefix}user o
						WHERE f.user_id = o.user_id
							AND f.deleted <> 1
						GROUP BY f.user_id) AS s
					SET
						u.total_uploads = s.n
					WHERE u.user_id = s.user_id";

			foreach ($sql as $query)
			{
				$engine->db->sql_query($query);
			}

			$engine->log(1, $engine->_t('LogUserStatsSynched', SYSTEM_LANG));
			$engine->show_message($engine->_t('UserStatsSynched'), 'success');
		}
		else if ($action == 'pagestats')
		{
			// reset stats
			$sql[] = "UPDATE " . $prefix . "page SET
						comments	= 0,
						files		= 0,
						revisions	= 0";
			// set comments
			$sql[] = "UPDATE " . $prefix . "page p,
						(SELECT e.page_id, COUNT( c.page_id ) AS n
						FROM " . $prefix . "page c
							RIGHT JOIN " . $prefix . "page AS e ON c.comment_on_id = e.page_id
						WHERE c.deleted <> 1
						GROUP BY e.page_id) AS s
					SET
						p.comments = s.n
					WHERE p.page_id = s.page_id";
			// set files
			$sql[] = "UPDATE " . $prefix . "page p,
						(SELECT page_id, COUNT(file_id) AS files
						FROM " . $prefix . "file
						WHERE page_id <> 0
						GROUP BY page_id) AS f
					SET
						p.files = f.files
					WHERE p.page_id = f.page_id";
			// set revisions
			$sql[] = "UPDATE " . $prefix . "page p,
						(SELECT page_id, COUNT(page_id) AS revisions
						FROM " . $prefix . "revision
						GROUP BY page_id) AS r
					SET
						p.revisions = r.revisions
					WHERE p.page_id = r.page_id";

			foreach ($sql as $query)
			{
				$engine->db->sql_query($query);
			}

			$engine->log(1, $engine->_t('LogPageStatsSynched', SYSTEM_LANG));

			$message = $engine->_t('PageStatsSynched');
			$engine->show_message($message, 'success');
		}
		else if ($action == 'rssfeeds')
		{
			$engine->module	= null;

			// write feeds
			$xml = new Feed($engine);

			if ($engine->db->enable_feeds)
			{
				$xml->changes();
				$xml->comments();

				if ($engine->db->news_cluster)
				{
					$xml->feed();
				}
			}

			// update OpenSearch description file
			if ($engine->db->opensearch)
			{
				$xml->open_search();
			}

			unset($xml);

			$engine->log(1, $engine->_t('LogFeedsUpdated', SYSTEM_LANG));
			$engine->set_language($engine->user_lang, true);
			$engine->show_message($engine->_t('FeedsUpdated'), 'success');
		}
		else if ($action == 'xml_sitemap')
		{
			// update sitemap
			$engine->write_sitemap(true, false);

			$engine->show_message($engine->_t('SiteMapCreated'), 'success');
		}
		else if ($action == 'reparse_body')
		{
			// purge body_r field to enforce page re-compiling
			$engine->db->sql_query("UPDATE " . $prefix . "page SET body_r = ''");

			$engine->show_message($engine->_t('PreparsedBodyPurged'), 'success');
		}
		else if ($action == 'wikilinks')
		{
			/* TODO:	1) dies if a rendered page throws a fatal error (e.g. action) -> fix broken page, its the last page shown in the list
						2) Browser will stop after 20 redirects with: ERR_TOO_MANY_REDIRECTS: There were too many redirects. -> load recent url again after error,
							solution: stop after after 15 redirects and provide a 'contine' button
							Chrome and Firefox out of the box is 20
						3) if processing breaks see point 1
							- fails with page having a broken action using templates
						4) TIMEOUT or reach of memory limit - try to reduce the value for the $page_limit parameter
			*/

			if (isset($_POST['page_limit']))
			{
				$page_limit					= (int) ($_POST['page_limit'] ?? 30);
				$engine->sess->resync_limit	= (in_array($page_limit, $batches)) ? $page_limit : 30;
			}

			$limit							= $engine->sess->resync_limit;
			$engine->sess->resync_batch		= $engine->sess->resync_batch ?? 1;
			$recompile						= 0;
			$redirects						= 10;

			@set_time_limit(1800);

			if (isset($_POST['recompile_page']) && $_POST['recompile_page'] == 1)
			{
				$recompile = true;
			}

			if (isset($_REQUEST['i']))
			{
				$i		= (int) ($_REQUEST['i'] ?? 0);
			}
			else
			{
				// truncate link tables
				$i = 0;
				$engine->sess->resync_links			= '';
				$engine->sess->resync_counter		= 0;

				$engine->db->sql_query("TRUNCATE " . $prefix . "page_link");
				$engine->db->sql_query("TRUNCATE " . $prefix . "file_link");

				// purge body_r and body_toc field to enforce page re-compiling
				if ($recompile)
				{
					$engine->db->sql_query("UPDATE " . $prefix . "page SET body_toc = ''");
					$engine->db->sql_query("UPDATE " . $prefix . "page SET body_r = ''");
				}
			}

			// do not allow automatic redirection by action {{redirect}}
			$engine->set_user_setting('dont_redirect', 1, false);

			if ($pages = $engine->db->load_all(
			"SELECT a.page_id, a.tag, a.body, a.body_r, a.body_toc, a.comment_on_id, a.page_lang, a.allow_rawhtml, a.disable_safehtml, a.typografica, " .
				"b.tag AS comment_on_tag, b.allow_rawhtml AS parent_allow_rawhtml, b.disable_safehtml AS parent_disable_safehtml, b.typografica AS parent_typografica " .
			"FROM " . $prefix . "page a " .
				"LEFT JOIN " . $prefix . "page b ON (a.comment_on_id = b.page_id) " .
			"ORDER BY a.tag COLLATE utf8mb4_unicode_520_ci " .
			"LIMIT " . ($i * $limit) . ", $limit"))
			{
				$engine->sess->resync_links .= '<br>##### ' . date('H:i:s') . ' --> ' . ($i + 1) . " #########################################\n\n";

				foreach ($pages as $n => $page)
				{
					$record = (($i * $limit) + $n + 1);
					$engine->sess->resync_links .=  $record . '. ' . $page['tag'] . "\n";

					// find last rendered page
					# Diag::dbg('GOLD', $record, $page['tag']);

					// override global formatter settings with perpage settings
					$page_options = [
						'allow_rawhtml',
						'disable_safehtml',
						'typografica',
					];

					// comment requires settings from parent page, e.g. 'parent_*'
					foreach ($page_options as $key)
					{
						// ignore perpage page settings with empty / null as value
						if (!Ut::is_empty($val = $page['comment_on_id'] ? $page['parent_' . $key] : $page[$key]))
						{
							$engine->db[$key] = $val;
						}
					}

					// setting context
					$engine->context[++$engine->current_context] = ($page['comment_on_id'] ? $page['comment_on_tag'] : $page['tag']);

					// recompile if necessary
					if ($page['body_r'] == '')
					{
						$engine->resync_page_id		= $page['page_id'];
						$engine->resync_page_lang	= $page['page_lang'];
						$paragrafica				= !$page['comment_on_id'];
						$page['body_r']				= $engine->compile_body($page['body'], $page['page_id'], $paragrafica, true);
					}

					// rendering links
					$engine->update_link_table($page['page_id'], $page['body_r']);
					$engine->current_context--;
				}

				#Diag::dbg('GOLD', $i, $engine->sess->resync_counter);

				// redirect limit workaround, see notice above
				if ($i < ($redirects + ($engine->sess->resync_counter)))
				{
					$engine->http->redirect($engine->href('', '', ['start' => 1, 'action' => 'wikilinks', 'i' => (++$i)]));
				}
				else
				{
					// show next » link to compile the following batch
					$engine->sess->resync_counter	= $i + 1 ;
					$engine->sess->resync_batch		= $engine->sess->resync_batch + 1;
					$message = $engine->_t('ParseNextBatch') . ' #' . $engine->sess->resync_batch . ' ' .
						'<a href="' . $engine->href('', '', ['start' => 1, 'action' => 'wikilinks', 'i' => (++$i)]) . '"' . '>' . $engine->_t('Next') . ' »</a>' .
						"<br>\n";
					$engine->show_message($message);
				}
			}
			else
			{
				$engine->sess->resync_links .= '<br>##### ' . date('H:i:s') . ' --> ' . ' DONE ' . " #########################################\n\n";

				$engine->show_message($engine->_t('WikiLinksRestored'), 'success');
				?>
				<div class="code">
					<pre><?php echo $engine->sess->resync_links; ?></pre>
				</div><br>
				<?php

				$engine->sess->resync_links		= null;
				$engine->sess->resync_counter	= null;
				$engine->sess->resync_batch		= null;

				$engine->log(1, $engine->_t('LogPageBodySynched', SYSTEM_LANG));
			}
		}
	}
?>
	<h2><?php echo $engine->_t('UserStats');?></h2>
	<p><?php echo $engine->_t('UserStatsInfo');?></p>

<?php
	echo $engine->form_open('usersupdate');
?>
		<input type="hidden" name="action" value="userstats">
		<button type="submit" name="start" id="submit_userstats"><?php echo $engine->_t('Synchronize');?></button>
<?php	echo $engine->form_close();?>

	<h2><?php echo $engine->_t('PageStats');?></h2>
	<p><?php echo $engine->_t('PageStatsInfo');?></p>
<?php
	echo $engine->form_open('pageupdate');
?>
		<input type="hidden" name="action" value="pagestats">
		<button type="submit" name="start" id="submit_pagestats"><?php echo $engine->_t('Synchronize');?></button>
<?php		echo $engine->form_close();?>

	<h2><?php echo $engine->_t('Feeds');?></h2>
	<p><?php echo $engine->_t('FeedsInfo');?></p>
<?php
	echo $engine->form_open('feedupdate');
?>
		<input type="hidden" name="action" value="rssfeeds">
		<button type="submit" name="start" id="submit_rssfeeds"><?php echo $engine->_t('Synchronize');?></button>
<?php		echo $engine->form_close();?>

<?php
if ($engine->db->xml_sitemap)
{ ?>
	<h2><?php echo $engine->_t('XmlSiteMap');?></h2>
	<p><?php echo $engine->_t('XmlSiteMapInfo');?><br>
		<?php echo Ut::perc_replace($engine->_t('XmlSiteMapPeriod'),
				'<strong>' . $engine->db->xml_sitemap_time . '</strong>',
				'<a href="' . $engine->db->base_url . Ut::join_path(XML_DIR, SITEMAP_XML) . ($engine->db->xml_sitemap_gz ? '.gz' : '') . '" title="' . $engine->_t('XmlSiteMapView') . '" target="_blank" rel="noopener">' .
					date('Y-m-d H:i:s', ($engine->db->maint_last_xml_sitemap - $engine->db->xml_sitemap_time * DAYSECS)) .
				'</a>'); ?>
	</p>
<?php
	echo $engine->form_open('sitemap_update');
?>
		<input type="hidden" name="action" value="xml_sitemap">
		<button type="submit" name="start" id="submit_sitemap"><?php echo $engine->_t('Synchronize');?></button>
<?php		echo $engine->form_close();
}?>

	<h2><?php echo $engine->_t('ReparseBody');?></h2>
	<p><?php echo $engine->_t('ReparseBodyInfo');?></p>

<?php
	echo $engine->form_open('reparse_body');
?>
		<input type="hidden" name="action" value="reparse_body">
		<button type="submit" name="start" id="submit_reparse"><?php echo $engine->_t('Synchronize');?></button>
<?php	echo $engine->form_close();?>

	<h2><?php echo $engine->_t('WikiLinksResync');?></h2>
	<p><?php echo $engine->_t('WikiLinksResyncInfo');?></p>
<?php
	echo $engine->form_open('linksupdate');
?>
		<input type="hidden" name="action" value="wikilinks">
		<br>
		<strong><small><?php echo $engine->_t('ResyncOptions');?>:</small></strong><br>
		<select id="page_limit" name="page_limit">
		<?php
		foreach ($batches as $value)
		{
			echo '<option value="' . $value . '"' . ($value == 50 ? ' selected' : '') . '>' . $value . '</option>';
		}
		?>
		</select>
		<label for="page_limit"><small><?php echo $engine->_t('RecompilePageLimit');?></small></label><br><br>
		<input type="checkbox" id="recompile_page" name="recompile_page" value="1">
		<label for="recompile_page"><small><?php echo $engine->_t('RecompilePage');?></small></label><br><br>
		<button type="submit" name="start" id="submit_wikilinks"><?php echo $engine->_t('Synchronize');?></button>
<?php
	echo $engine->form_close();
}
