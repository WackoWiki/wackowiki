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

$type			= (int)		($_GET['type'] ?? OBJECT_PAGE);
$action			= (string)	($_GET['action'] ?? null);
$page_id		= (int)		($_GET['page_id'] ?? null);
$revision_id	= (int)		($_GET['revision_id'] ?? null);
$file_id		= (int)		($_GET['file_id'] ?? null);

if ($type == OBJECT_PAGE && $page_id)
{
	if ($action == 'delete')
	{
		$engine->delete_pages([$page_id]);
		$engine->delete_acls([$page_id], true);
		// page_id -> tag -> page_id (really)
		$tag = $engine->get_page_tag($page_id);
		$engine->remove_revisions($tag, false, true);
		$engine->remove_files_perpage($tag, false, true);
	}
	else if ($action == 'restore')
	{
		$engine->restore_page($page_id);
		$engine->restore_files_perpage($page_id);
	}
}
else if ($type == OBJECT_REVISION && $revision_id)
{
	if ($action == 'delete')
	{
		$engine->remove_revision($page_id, $revision_id, true);
	}
	else if ($action == 'restore')
	{
		$engine->restore_revision($page_id, $revision_id);
	}
}
else if ($type == OBJECT_FILE && $file_id)
{
	if ($action == 'delete')
	{
		$engine->remove_file($file_id, true);
	}
	else if ($action == 'restore')
	{
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
		($type == OBJECT_REVISION
			? ' | <span class="active">' . $engine->_t('UsersRevisions') . '</span>'
			: ' | <a href="' . $engine->href('', '', ['type' => OBJECT_REVISION]) . '">' . $engine->_t('UsersRevisions') . '</a>' ) .
		($type == OBJECT_FILE
			? ' | <span class="active">' . $engine->_t('Files') . '</span>'
			: ' | <a href="' . $engine->href('', '', ['type' => OBJECT_FILE]) . '">' . $engine->_t('Files') . '</a>') .
		'</p>';


	if ($type == OBJECT_FILE)
	{
		[$files, $pagination] = $engine->load_deleted_files(50, false);
	}
	else if  ($type == OBJECT_REVISION)
	{
		[$revisions, $pagination] = $engine->load_deleted_revisions(50, false);
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
						' [ <a href="' . $engine->href('', '', ['action' => 'delete', 'page_id' => $page['page_id'], 'type' => OBJECT_PAGE]) . '">' . $engine->_t('DeleteButton') . '</a> ]' .
						# ' [ <a href="' . $engine->href('', '', ['action' => 'archive', 'page_id' => $page['page_id'], 'type' => OBJECT_PAGE]) . '">' . $engine->_t('ArchiveButton') . '</a> ]' .
						' [ <a href="' . $engine->href('', '', ['action' => 'restore', 'page_id' => $page['page_id'], 'type' => OBJECT_PAGE]) . '">' . $engine->_t('RestoreButton') . '</a> ]</small> ' .
						$engine->compose_link_to_page($page['tag'], 'revisions', '', $page['title']) .
					'</td>' .
				"</tr>\n";
		}

		echo '</table>';

		$engine->print_pagination($pagination);
	}
	else if (!empty($revisions))
	{
		$engine->print_pagination($pagination);

		echo '<table>';

		$curday	= '';

		foreach ($revisions as $revision)
		{
			// day header
			[$day, $time] = explode(' ', $revision['modified']);

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
						' [ <a href="' . $engine->href('', '', ['action' => 'delete', 'page_id' => $revision['page_id'], 'revision_id' => $revision['revision_id'], 'type' => OBJECT_REVISION]) . '">' . $engine->_t('DeleteButton') . '</a> ]' .
						# ' [ <a href="' . $engine->href('', '', ['action' => 'archive', 'page_id' => $revision['page_id'], 'revision_id' => $revision['revision_id'], 'type' => OBJECT_REVISION]) . '">' . $engine->_t('ArchiveButton') . '</a> ]' .
						' [ <a href="' . $engine->href('', '', ['action' => 'restore', 'page_id' => $revision['page_id'], 'revision_id' => $revision['revision_id'], 'type' => OBJECT_REVISION]) . '">' . $engine->_t('RestoreButton') . '</a> ]</small> ' .
						$engine->compose_link_to_page($revision['tag'], '', '', $revision['title'], '', ['revision_id' => $revision['revision_id']]) . ' (' . $engine->_t('Version') . ' <strong>' . $revision['version_id'] . '</strong>)' .
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
						' [ <a href="' . $engine->href('', '', ['action' => 'delete', 'file_id' => $file['file_id'], 'type' => OBJECT_FILE]) . '">' . $engine->_t('DeleteButton') . '</a> ]' .
						# ' [ <a href="' . $engine->href('', '', ['action' => 'archive', 'file_id' => $file['file_id'], 'type' => OBJECT_FILE]) . '">' . $engine->_t('ArchiveButton') . '</a> ]' .
						' [ <a href="' . $engine->href('', '', ['action' => 'restore', 'file_id' => $file['file_id'], 'type' => OBJECT_FILE]) . '">' . $engine->_t('RestoreButton') . '</a> ]</small> ' .
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
		if ($type == OBJECT_REVISION)
		{
			echo '<br><p>' . $engine->_t('NoDeletedRevisions') . '</p>';
		}
		else if ($type == OBJECT_FILE)
		{
			echo '<br><p>' . $engine->_t('NoDeletedFiles') . '</p>';
		}
	}
}

