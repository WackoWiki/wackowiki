<?php

if (!defined('IN_WACKO'))
{
	exit;
}

########################################################
##   Recently deleted pages controls                  ##
########################################################

$module['content_deleted'] = array(
		'order'	=> 340,
		'cat'	=> 'Content',
		'status'=> (RECOVERY_MODE ? false : true),
		'mode'	=> 'content_deleted',
		'name'	=> 'Deleted',
		'title'	=> 'Newly deleted content',
	);

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
		$id = (int)$_GET['remove'];
		$engine->sql_query(
			"DELETE FROM {$engine->config['table_prefix']}revision ".
			"WHERE page_id = '".$id."'");

		$engine->sql_query(
			"DELETE FROM {$engine->config['table_prefix']}page ".
			"WHERE page_id = '".$id."'");

		$engine->sql_query(
			"DELETE FROM {$engine->config['table_prefix']}upload ".
			"WHERE page_id = '".$id."'");

	}

	// restore specific page revisions
	if (isset($_GET['restore']))
	{
		$id = (int)$_GET['restore'];
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
	list($pages, $pagination) = $engine->load_deleted(50, false);

	if ($pages)
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

				echo '<tr><td colspan="2"><br /><strong>'.date($engine->config['date_format'],strtotime($day)).":</strong></td></tr>\n";
				$curday = $day;
			}

			// print entry
			echo '<tr>'.
					'<td class="lined" style="text-align:left">'.
						'<small>'.date($engine->config['time_format_seconds'], strtotime($time)).' - '.
						' [ <a href="'.rawurldecode($engine->href()).'&amp;remove='.$page['page_id'].'">'.$engine->get_translation('RemoveButton').'</a> ]'.
						' [ <a href="'.rawurldecode($engine->href()).'&amp;restore='.$page['page_id'].'">'.$engine->get_translation('RestoreButton').'</a> ]</small> '.
						$engine->compose_link_to_page($page['tag'], 'revisions', '', 0, $page['title']).
					'</td>'.
				"</tr>\n";
		}

		echo '</table>';

		$engine->print_pagination($pagination);
	}
	else
	{
		echo $engine->get_translation('NoRecentlyDeleted');
	}
}

?>
