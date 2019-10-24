<?php

if (!defined('IN_WACKO'))
{
	exit;
}

##########################################################
##	DB Synchronization									##
##########################################################
$_mode = 'maint_resync';

$module[$_mode] = [
		'order'	=> 620,
		'cat'	=> 'maintenance',
		'status'=> (RECOVERY_MODE ? false : true),
		'mode'	=> $_mode,
		'name'	=> $engine->_t($_mode)['name'],		// Data Synchronization
		'title'	=> $engine->_t($_mode)['title'],	// Synchronizing data
	];

##########################################################

function admin_maint_resync(&$engine, &$module)
{
	$prefix		= $engine->db->table_prefix;
?>
	<h1><?php echo $module['title']; ?></h1>
	<br>
<?php
	if (isset($_REQUEST['start']))
	{
		if ($_REQUEST['action'] == 'userstats')
		{
			// reset stats
			$sql[] = "UPDATE " . $engine->db->user_table . " SET
						total_comments	= 0,
						total_uploads	= 0,
						total_revisions	= 0,
						total_pages		= 0";

			// set total comments posted
			$sql[] = "UPDATE " . $engine->db->user_table . " AS u,
						(SELECT p.owner_id as user_id, COUNT(p.tag) AS n
						FROM " . $prefix . "page AS p,
							{$engine->db->user_table} AS o
						WHERE p.owner_id = o.user_id
							AND p.comment_on_id <> 0
							AND p.deleted <> 1
						GROUP BY p.owner_id) AS s
					SET
						u.total_comments = s.n
					WHERE u.user_id = s.user_id";

			// set total pages in ownership
			$sql[] = "UPDATE " . $engine->db->user_table . " AS u,
						(SELECT o.user_id, COUNT(p.tag) AS n
						FROM " . $prefix . "page AS p,
							{$engine->db->user_table} AS o
						WHERE p.owner_id = o.user_id
							AND p.comment_on_id = 0
							AND p.deleted <> 1
						GROUP BY p.owner_id) AS s
					SET
						u.total_pages = s.n
					WHERE u.user_id = s.user_id";

			// set total revisions made
			$sql[] = "UPDATE " . $engine->db->user_table . " AS u,
						(SELECT r.user_id, COUNT(r.page_id) AS n
						FROM " . $prefix . "revision AS r,
							{$engine->db->user_table} AS o
						WHERE r.owner_id = o.user_id
							AND r.comment_on_id = 0
						GROUP BY r.user_id) AS s
					SET
						u.total_revisions = s.n
					WHERE u.user_id = s.user_id";

			// set total files uploaded
			$sql[] = "UPDATE " . $engine->db->user_table . " AS u,
						(SELECT o.user_id, COUNT(f.file_id) AS n
						FROM " . $prefix . "file f,
							{$engine->db->user_table} AS o
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
		else if ($_REQUEST['action'] == 'pagestats')
		{
			// reset stats
			$sql[] = "UPDATE " . $prefix . "page SET
						comments	= 0,
						files		= 0,
						revisions	= 0";
			// set comments
			$sql[] = "UPDATE " . $prefix . "page AS p,
						(SELECT e.page_id, COUNT( c.page_id ) AS n
						FROM " . $prefix . "page AS c
							RIGHT JOIN " . $prefix . "page AS e ON c.comment_on_id = e.page_id
						WHERE c.deleted <> 1
						GROUP BY e.page_id) AS s
					SET
						p.comments = s.n
					WHERE p.page_id = s.page_id";
			// set files
			$sql[] = "UPDATE " . $prefix . "page AS p,
						(SELECT page_id, COUNT(file_id) AS files
						FROM " . $prefix . "file
						WHERE page_id <> 0
						GROUP BY page_id) AS f
					SET
						p.files = f.files
					WHERE p.page_id = f.page_id";
			// set revisions
			$sql[] = "UPDATE " . $prefix . "page AS p,
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
		else if ($_REQUEST['action'] == 'rssfeeds')
		{
			$xml = new Feed($engine);
			$xml->changes();
			$xml->comments();

			if ($engine->db->news_cluster)
			{
				$xml->feed();
			}

			$engine->log(1, $engine->_t('LogFeedsUpdated', SYSTEM_LANG));
			unset($xml);

			$engine->show_message($engine->_t('FeedsUpdated'), 'success');
		}
		else if ($_REQUEST['action'] == 'xml_sitemap')
		{
			// update sitemap
			$engine->write_sitemap(true, false);

			$engine->show_message($engine->_t('SiteMapCreated'), 'success');
		}
		else if ($_REQUEST['action'] == 'wikilinks')
		{
			/* TODO:	1) dies if a rendered page throws a fatal error (e.g. action) -> fix broken page, its the last page shown in the list
						2) Browser will stop after 20 redirects with: ERR_TOO_MANY_REDIRECTS: There were too many redirects. -> load recent url again after error,
							solution: stopp after after 15 redirects and provide a 'contine button
							Chrome and Firefox out of the box is 20, Internet Explorer is 10
						3) if processing breaks see point 1
							- fails with page having a broken action using templates
							- (Undefined property: Wacko::$charset) -> include_buffered()
							- $tpl->setEncoding($this->charset);
							- registration and changepassword action?
			*/
			$limit		= 500;
			$recompile	= 0;

			if (isset($_POST['recompile_page']) && $_POST['recompile_page']	== 1) $recompile = true;

			if (isset($_REQUEST['i']))
			{
				$i = $_REQUEST['i'];
			}
			else
			{
				// truncate link tables
				$i = 0;
				$engine->db->sql_query("TRUNCATE " . $prefix . "page_link");
				$engine->db->sql_query("TRUNCATE " . $prefix . "file_link");

				// purge body_r and body_toc field to enforce page re-compiling
				if ($recompile)
				{
					$engine->db->sql_query("UPDATE " . $prefix . "page SET body_toc = ''");
					$engine->db->sql_query("UPDATE " . $prefix . "page SET body_r = ''");
				}
			}

			// do not allow automatic redirection by action redirect
			$engine->set_user_setting('dont_redirect', 1, 0);

			if ($pages = $engine->db->load_all(
			"SELECT a.page_id, a.tag, a.body, a.body_r, a.body_toc, a.comment_on_id, b.tag as comment_on_tag " .
			"FROM " . $prefix . "page a " .
				"LEFT JOIN " . $prefix . "page b ON (a.comment_on_id = b.page_id) " .
			"WHERE a.owner_id <> " . (int) $engine->db->system_user_id . " " .
			"LIMIT " . ($i * $limit) . ", $limit"))
			{
				foreach ($pages as $n => $page)
				{
					$record = (($i * $limit) + $n + 1);
					echo $record . '. ' . $page['tag'] . "<br>\n";
					// find last rendered page
					# Diag::dbg('GOLD', $record, $page['tag']);

					// recompile if necessary
					if ($page['body_r'] == '')
					{
						$paragrafica	= ($page['comment_on_id'] ? false : true);
						$page['body_r']	= $engine->compile_body($page['body'], $page['page_id'], $paragrafica, true);
					}

					// rendering links
					$engine->context[++$engine->current_context] = ($page['comment_on_id'] ? $page['comment_on_tag'] : $page['tag']);
					// TODO: update_link_table() may break processing !!! (WHY?)
					$engine->update_link_table($page['page_id'], $page['body_r']);
					$engine->current_context--;
				}

				// TODO: Fix or workaround, see notice above
				#if ($i < 20)
				$engine->http->redirect(rawurldecode($engine->href('', '', ['start' => 1, 'action' => 'wikilinks', 'i' => (++$i)])));
			}
			else
			{
				$engine->log(1, $engine->_t('LogPageBodySynched', SYSTEM_LANG));
				$engine->show_message($engine->_t('WikiLinksRestored'), 'success');
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
		<input type="submit" name="start" id="submit" value="<?php echo $engine->_t('Synchronize');?>">
<?php	echo $engine->form_close();?>

	<h2><?php echo $engine->_t('PageStats');?></h2>
	<p><?php echo $engine->_t('PageStatsInfo');?></p>
<?php
	echo $engine->form_open('pageupdate');
?>
		<input type="hidden" name="action" value="pagestats">
		<input type="submit" name="start" id="submit" value="<?php echo $engine->_t('Synchronize');?>">
<?php		echo $engine->form_close();?>

	<h2><?php echo $engine->_t('Feeds');?></h2>
	<p><?php echo $engine->_t('FeedsInfo');?></p>
<?php
	echo $engine->form_open('feedupdate');
?>
		<input type="hidden" name="action" value="rssfeeds">
		<input type="submit" name="start" id="submit" value="<?php echo $engine->_t('Synchronize');?>">
<?php		echo $engine->form_close();?>

<?php
if ($engine->db->xml_sitemap)
{ ?>
	<h2><?php echo $engine->_t('XmlSiteMap');?></h2>
	<p><?php echo $engine->_t('XmlSiteMapInfo');?><br>
		<?php echo Ut::perc_replace($engine->_t('XmlSiteMapPeriod'),
				'<strong>' . $engine->db->xml_sitemap_time . '</strong>',
				'<a href="' . $engine->db->base_url . SITEMAP_XML . '" title="' . $engine->_t('XmlSiteMapView') . '" target="_blank" rel="noopener">' . date('Y-m-d H:i:s', $engine->db->maint_last_xml_sitemap) . '</a>'); ?>
	</p>
<?php
	echo $engine->form_open('sitemap_update');
?>
		<input type="hidden" name="action" value="xml_sitemap">
		<input type="submit" name="start" id="submit" value="<?php echo $engine->_t('Synchronize');?>">
<?php		echo $engine->form_close();
}?>

	<h2><?php echo $engine->_t('WikiLinksResync');?></h2>
	<p><?php echo $engine->_t('WikiLinksResyncInfo');?></p>
<?php
	echo $engine->form_open('linksupdate');
?>
		<input type="hidden" name="action" value="wikilinks">
		<br>
		<strong><small><?php echo $engine->_t('ResyncOptions');?>:</small></strong><br>
		<input type="checkbox" id="recompile_page" name="recompile_page" value="1">
		<label for="recompile_page"><small><?php echo $engine->_t('RecompilePage');?></small></label><br><br>
		<input type="submit" name="start" id="submit" value="<?php echo $engine->_t('Synchronize');?>">
<?php
	echo $engine->form_close();
}

