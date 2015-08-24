<?php

if (!defined('IN_WACKO'))
{
	exit;
}

########################################################
##   Recently deleted pages controls                  ##
########################################################

$module['content_deleted'] = array(
		'order'	=> 16,
		'cat'	=> 'Content',
		'status'=> (RECOVERY_MODE ? false : true),
		'mode'	=> 'content_deleted',
		'name'	=> 'Deleted',
		'title'	=> 'Newly deleted content',
	);

########################################################

function admin_content_deleted(&$engine, &$module)
{
	$curday = '';
?>
	<h1><?php echo $module['title']; ?></h1>
	<br />
<?php
	// clear specific page revisions
	if (isset($_GET['remove']))
	{
		$engine->sql_query(
			"DELETE FROM {$engine->config['table_prefix']}revision ".
			"WHERE page_id = '".(int)$_GET['remove']."'");

		$engine->sql_query(
			"DELETE FROM {$engine->config['table_prefix']}page ".
			"WHERE page_id = '".(int)$_GET['remove']."'");
	}

	// restore specific page revisions
	if (isset($_GET['restore']))
	{
		/* $engine->sql_query(
				"UPDATE {$engine->config['table_prefix']}revision SET ".
					"deleted	= '0' ".
				"WHERE page_id = '".(int)$_GET['remove']."'"); */

		$engine->sql_query(
				"UPDATE {$engine->config['table_prefix']}page SET ".
					"deleted	= '0' ".
				"WHERE page_id = '".(int)$_GET['restore']."'");
	}

	$pages = $engine->load_deleted(100000, 0);
?>
	<p>
		List of removed pages, copies which were in the table revision.
		Finally remove the pages from the database by clicking on the link <em>Remove</em>
		in the corresponding row. (Be careful, no delete confirmation is requested!)
	</p>
<?php
	if ($pages == true)
	{
		echo '<table>';

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
						$engine->compose_link_to_page($page['tag'], 'revisions', '', 0).
					'</td>'.
				"</tr>\n";
		}

		echo '</table>';
	}
	else
	{
		echo $engine->get_translation('NoRecentlyDeleted');
	}
}

?>