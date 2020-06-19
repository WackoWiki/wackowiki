<?php

if (!defined('IN_WACKO'))
{
	exit;
}

##########################################################
##	Recently deleted pages controls						##
##########################################################
$_mode = 'content_deleted';

$module[$_mode] = [
		'order'	=> 340,
		'cat'	=> 'content',
		'status'=> (RECOVERY_MODE ? false : true),
		'mode'	=> $_mode,
		'name'	=> $engine->_t($_mode)['name'],		// Deleted
		'title'	=> $engine->_t($_mode)['title'],	// Newly deleted content
	];

##########################################################

function admin_content_deleted(&$engine, &$module)
{
?>
	<h1><?php echo $module['title']; ?></h1>
	<br>
<?php

$type = (int) ($_GET['type'] ?? OBJECT_PAGE);

if ($type == OBJECT_PAGE)
{
	// remove specific page, revisions and attached files
	if (isset($_GET['remove']))
	{
		$page_id = (int) $_GET['remove'];

		$engine->delete_pages([$page_id]);
		// page_id -> tag -> page_id (really)
		$tag = $engine->get_page_tag($page_id);
		$engine->remove_revisions($tag, false, true);
		$engine->remove_files_perpage($tag, false, true);
	}

	// restore a specific page
	if (isset($_GET['restore']))
	{
		$page_id = (int) $_GET['restore'];
		$engine->restore_page($page_id);
		$engine->restore_files_perpage($page_id);
	}
}
else if ($type == OBJECT_FILE)
{
	if (isset($_GET['remove']))
	{
		$file_id = (int) $_GET['remove'];

		$engine->remove_file($file_id, true);
	}

	// restore specific file
	if (isset($_GET['restore']))
	{
		$file_id = (int) $_GET['restore'];
		$engine->restore_file($file_id);
	}
}

?>
	<p>
	<?php echo $engine->_t('DeletedObjectsInfo');?>
	</p>
<?php

	$filter_type =
		'<p class="right">' .
		($type == OBJECT_PAGE
			? '<span class="active">' . $engine->_t('UsersPages') . '</span>'
			: '<a href="' . $engine->href('', '', ['type' => OBJECT_PAGE]) . '">' . $engine->_t('UsersPages') . '</a>' ) .
		($type == OBJECT_FILE
			? ' | <span class="active">' . $engine->_t('Files') . '</span>'
			: ' | <a href="' . $engine->href('', '', ['type' => OBJECT_FILE]) . '">' . $engine->_t('Files') . '</a>') .
		'</p>';


	if ($type == OBJECT_FILE)
	{
		[$files, $pagination] = $engine->load_deleted_files(50, false);
	}
	else
	{
		[$pages, $pagination] = $engine->load_deleted_pages(50, false);
	}

	echo $filter_type;

	if (!empty($pages))
	{
		$engine->print_pagination($pagination);

		echo '<table>';

		$curday	= '';

		foreach ($pages as $page)
		{
			// day header
			[$day, $time] = explode(' ', $page['modified']);

			if ($day != $curday)
			{
				if ($curday)
				{
					echo "\n";
				}

				echo '<tr><td colspan="2"><br><strong>' . date($engine->db->date_format, strtotime($day)) . ":</strong></td></tr>\n";
				$curday = $day;
			}

			// print entry
			echo '<tr>' .
					'<td class="lined">' .
						'<small>' . date($engine->db->time_format_seconds, strtotime($time)) . ' - ' .
						' [ <a href="' . $engine->href('', '', ['remove' => $page['page_id'], 'type' => OBJECT_PAGE]) . '">' . $engine->_t('RemoveButton') . '</a> ]' .
						# ' [ <a href="' . $engine->href('', '', ['archive' => $page['page_id'], 'type' => OBJECT_PAGE]) . '">' . $engine->_t('ArchiveButton') . '</a> ]' .
						' [ <a href="' . $engine->href('', '', ['restore' => $page['page_id'], 'type' => OBJECT_PAGE]) . '">' . $engine->_t('RestoreButton') . '</a> ]</small> ' .
						$engine->compose_link_to_page($page['tag'], 'revisions', '', $page['title']) .
					'</td>' .
				"</tr>\n";
		}

		echo '</table>';

		$engine->print_pagination($pagination);
	}
	else if (!empty($files))
	{
		$engine->print_pagination($pagination);

		echo '<table>';

		$curday	= '';

		foreach ($files as $file)
		{
			// day header
			[$day, $time] = explode(' ', $file['modified_dt']);

			if ($day != $curday)
			{
				if ($curday)
				{
					echo "\n";
				}

				echo '<tr><td colspan="2"><br><strong>' . date($engine->db->date_format, strtotime($day)) . ":</strong></td></tr>\n";
				$curday = $day;
			}

			// print entry
			echo '<tr>' .
					'<td class="lined">' .
						'<small>' . date($engine->db->time_format_seconds, strtotime($time)) . ' - ' .
						' [ <a href="' . $engine->href('', '', ['remove' => $file['file_id'], 'type' => OBJECT_FILE]) . '">' . $engine->_t('RemoveButton') . '</a> ]' .
						# ' [ <a href="' . $engine->href('', '', ['archive' => $file['file_id'], 'type' => OBJECT_FILE]) . '">' . $engine->_t('ArchiveButton') . '</a> ]' .
						' [ <a href="' . $engine->href('', '', ['restore' => $file['file_id'], 'type' => OBJECT_FILE]) . '">' . $engine->_t('RestoreButton') . '</a> ]</small> ' .
						'<span title="' . $file['file_description'] . '">' . $file['file_name'] . '</span>' .
						#$engine->shorten_string($file['file_name']))
					'</td>' .
				"</tr>\n";
		}

		echo '</table>';

		$engine->print_pagination($pagination);
	}
	else
	{
		if ($type == OBJECT_PAGE)
		{
			echo '<br><p>' . $engine->_t('NoDeletedPages') . '</p>';
		}
		else if ($type == OBJECT_FILE)
		{
			echo '<br><p>' . $engine->_t('NoDeletedFiles') . '</p>';
		}
	}
}

