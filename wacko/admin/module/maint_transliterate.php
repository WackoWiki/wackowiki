<?php

if (!defined('IN_WACKO'))
{
	exit;
}

########################################################
##   DB Update                                        ##
########################################################
$_mode = 'maint_transliterate';

$module[$_mode] = [
		'order'	=> 610,
		'cat'	=> 'maintenance',
		'status'=> (RECOVERY_MODE ? false : true),
		'mode'	=> $_mode,
		'name'	=> $engine->_t($_mode)['name'],		// Transliterate
		'title'	=> $engine->_t($_mode)['title'],	// Update the supertag in the database records
	];

########################################################

function admin_maint_transliterate(&$engine, &$module)
{
?>
	<h1><?php echo $module['title']; ?></h1>
	<br>
<?php
	if (isset($_REQUEST['start']))
	{
		$limit = 1500;

		if (isset($_REQUEST['i']))
		{
			$i = $_REQUEST['i'];
		}
		else
		{
			$i = 0;
		}

		// links
		if ((int) $_REQUEST['step'] === 1)
		{
			if ($pages = $engine->db->load_all(
				"SELECT to_tag
				FROM " . $engine->db->table_prefix . "page_link
				LIMIT " . ($i * $limit) . ", $limit"))
			{
				foreach ($pages as $page)
				{
					$engine->db->sql_query(
						"UPDATE " . $engine->db->table_prefix . "page_link SET " .
							"to_supertag = " . $engine->db->q($engine->translit($page['to_tag'])) . " " .
						"WHERE to_tag = " . $engine->db->q($page['to_tag']) . " ");
				}

				$engine->http->redirect(rawurldecode($engine->href('', 'admin.php', 'mode=' . $module['mode'] . '&amp;start=1&amp;step=' . $_REQUEST['step'] . '&amp;i='.(++$i))));
			}
			else
			{
?>
				<ol>
					<li value="1"><del>Transliterate field <code>to_supertag</code> in table `page_link`</del>.</li>
				</ol>
				<br>
<?php
				echo $engine->form_open('sysupdate');
?>
					<input type="hidden" name="step" value="2">
					<input type="submit" name="start" id="submit" value="continue">
<?php
				echo $engine->form_close();
			}
		}
		// pages
		else if ((int) $_REQUEST['step'] === 2)
		{
			if ($pages = $engine->db->load_all(
				"SELECT page_id, tag
				FROM " . $engine->db->table_prefix . "page
				LIMIT " . ($i * $limit) . ", $limit"))
			{
				foreach ($pages as $page)
				{
					$engine->db->sql_query(
						"UPDATE " . $engine->db->table_prefix . "page SET " .
							"supertag = " . $engine->db->q($engine->translit($page['tag'])) . " " .
						"WHERE page_id = '" . $page['page_id']) . "'";
				}

				$engine->http->redirect(rawurldecode($engine->href('', 'admin.php', 'mode=' . $module['mode'] . '&amp;start=1&amp;step=' . $_REQUEST['step'] . '&amp;i='.(++$i))));
			}
			else
			{
?>
				<ol>
					<li value="2"><del>Transliterate field <code>supertag</code> in table `page`</del>.</li>
				</ol>
				<br>
<?php
				echo $engine->form_open('sysupdate');
?>
					<input type="hidden" name="step" value="3">
					<input type="submit" name="start" id="submit" value="continue">
<?php
				echo $engine->form_close();
			}
		}
		// revisions
		else if ((int) $_REQUEST['step'] === 3)
		{
			if ($pages = $engine->db->load_all(
					"SELECT revision_id, tag
					FROM " . $engine->db->table_prefix . "revision
					LIMIT " . ($i * $limit) . ", $limit"))
			{
				foreach ($pages as $page)
				{
					$engine->db->sql_query(
						"UPDATE " . $engine->db->table_prefix . "revision SET " .
							"supertag = " . $engine->db->q($engine->translit($page['tag'])) . " " .
						"WHERE revision_id = '" . $page['revision_id']) . "'";
				}

				$engine->http->redirect(rawurldecode($engine->href('', 'admin.php', 'mode=' . $module['mode'] . '&amp;start=1&amp;step=' . $_REQUEST['step'] . '&amp;i='.(++$i))));
			}
			else
			{
?>
				<ol>
					<li value="3"><del>Transliterate field <code>supertag</code> in table `revision`</del>.</li>
				</ol>
				<br>
				<p>The update procedure is completed.</p>
<?php
				#echo $engine->form_open('sysupdate');
				#echo '<input type="hidden" name="step" value="4">';
				#echo '<input type="submit" name="start" id="submit" value="continue">';
				#echo $engine->form_close();
			}
		}
	}
	else
	{
?>
		<ol>
			<li>Transliterate field <code>to_supertag</code> in table `page_link`.</li>
			<li>Transliterate field <code>supertag</code> in table `page`.</li>
			<li>Transliterate field <code>supertag</code> in table `revision`.</li>
		</ol>
		<br>
<?php
		echo $engine->form_open('sysupdate');
?>
			<input type="hidden" name="step" value="1">
			<input type="submit" name="start" id="submit" value="Start">
<?php
		echo $engine->form_close();
	}
}

?>
