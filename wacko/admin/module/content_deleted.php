<?php

if (!defined('IN_WACKO'))
{
	exit;
}

########################################################
##   Recently deleted pages controls                  ##
########################################################
$_mode = 'content_deleted';

$module[$_mode] = [
		'order'	=> 340,
		'cat'	=> 'content',
		'status'=> (RECOVERY_MODE ? false : true),
		'mode'	=> $_mode,
		'name'	=> $engine->_t($_mode)['name'],		// Deleted
		'title'	=> $engine->_t($_mode)['title'],	// Newly deleted content
	];

########################################################

function admin_content_deleted(&$engine, &$module)
{
?>
	<h1><?php echo $module['title']; ?></h1>
	<br />
<?php
	// clear specific page revisions
	if (isset($_GET['remove']))
	{
		$id = (int) $_GET['remove'];
		$engine->db->sql_query(
			"DELETE FROM " . $engine->db->table_prefix . "revision " .
			"WHERE page_id = '" . $id . "' ");

		$engine->db->sql_query(
			"DELETE FROM " . $engine->db->table_prefix . "page " .
			"WHERE page_id = '" . $id . "' " .
				"AND deleted = '1'");

		$engine->db->sql_query(
			"DELETE FROM " . $engine->db->table_prefix . "file " .
			"WHERE page_id = '" . $id . "'");
	}

	// restore specific page revisions
	if (isset($_GET['restore']))
	{
		$id = (int) $_GET['restore'];
		$engine->restore_page($id);
		$engine->restore_file($id);
	}

?>
	<p>
		List of removed pages and copies which were in the table revision.
		Finally remove or restore the pages from the database by clicking on the link <em>Remove</em>
		or <em>Restore</em> in the corresponding row. (Be careful, no delete confirmation is requested!)
	</p>
<?php

	if (isset($_GET['type']) && $_GET['type'] == OBJECT_FILE)
	{
		list($files, $pagination) = $engine->load_deleted_files(50, false);
	}
	else
	{
		list($pages, $pagination) = $engine->load_deleted_pages(50, false);
	}

	if (isset($pages))
	{
		$engine->print_pagination($pagination);

		echo '<table>';

		$curday = '';
		foreach ($pages as $page)
		{
			// day header
			list($day, $time) = explode(' ', $page['modified']);

			if ($day != $curday)
			{
				if ($curday)
				{
					echo "\n";
				}

				echo '<tr><td colspan="2"><br /><strong>' . date($engine->db->date_format, strtotime($day)) . ":</strong></td></tr>\n";
				$curday = $day;
			}

			// print entry
			echo '<tr>' .
					'<td class="lined">' .
						'<small>' . date($engine->db->time_format_seconds, strtotime($time)) . ' - ' .
						' [ <a href="' . rawurldecode($engine->href()) . '&amp;remove=' . $page['page_id'] . '">' . $engine->_t('RemoveButton') . '</a> ]'.
						' [ <a href="' . rawurldecode($engine->href()) . '&amp;archive=' . $page['page_id'] . '">' . $engine->_t('ArchiveButton') . '</a> ]'.
						' [ <a href="' . rawurldecode($engine->href()) . '&amp;restore=' . $page['page_id'] . '">' . $engine->_t('RestoreButton') . '</a> ]</small> '.
						$engine->compose_link_to_page($page['tag'], 'revisions', '', 0, $page['title']) .
					'</td>' .
				"</tr>\n";
		}

		echo '</table>';

		$engine->print_pagination($pagination);
	}
	else if ($files)
	{
		$engine->print_pagination($pagination);

		echo '<table>';

		$curday = '';
		foreach ($files as $file)
		{
			// day header
			list($day, $time) = explode(' ', $file['modified_dt']);

			if ($day != $curday)
			{
				if ($curday)
				{
					echo "\n";
				}

				echo '<tr><td colspan="2"><br /><strong>' . date($engine->db->date_format, strtotime($day)) . ":</strong></td></tr>\n";
				$curday = $day;
			}

			// print entry
			echo '<tr>' .
					'<td class="lined">' .
						'<small>' . date($engine->db->time_format_seconds, strtotime($time)) . ' - ' .
						' [ <a href="' . rawurldecode($engine->href()) . '&amp;remove=' . $file['file_id'] . '">' . $engine->_t('RemoveButton') . '</a> ]'.
						' [ <a href="' . rawurldecode($engine->href()) . '&amp;archive=' . $file['file_id'] . '">' . $engine->_t('ArchiveButton') . '</a> ]'.
						' [ <a href="' . rawurldecode($engine->href()) . '&amp;restore=' . $file['file_id'] . '">' . $engine->_t('RestoreButton') . '</a> ]</small> '.
						$engine->compose_link_to_page($file['file_name'], 'revisions', '', 0, $file['file_description']) .
					'</td>' .
				"</tr>\n";
		}

		echo '</table>';

		$engine->print_pagination($pagination);
	}
	else
	{
		echo '<br /><p>' . $engine->_t('NoDeletedPages') . '</p>';
	}
}

?>
