<?php

if (!defined('IN_WACKO'))
{
	exit;
}

########################################################
##   Recently deleted pages controls                  ##
########################################################

$module['deletedpages'] = array(
		'order'	=> 4,
		'cat'	=> 'Content',
		'mode'	=> 'deletedpages',
		'name'	=> 'Deleted pages',
		'title'	=> 'Copies of the newly deleted pages',
	);

########################################################

function admin_deletedpages(&$engine, &$module)
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
			"WHERE page_id = '".(int)$_GET['remove'])."'";

		$engine->sql_query(
			"DELETE FROM {$engine->config['table_prefix']}page ".
			"WHERE page_id = '".(int)$_GET['remove'])."'";
	}

	$pages = $engine->load_recently_deleted(100000, 0);
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

				echo '<tr class="lined"><td colspan="2"><br /><strong>'.date($engine->config['date_format'],strtotime($day)).":</strong></td></tr>\n";
				$curday = $day;
			}

			// print entry
			echo '<tr>'.
					'<td style="text-align:left">'.
						'<small>('.date($engine->config['time_format_seconds'], strtotime($time)).' - <a href="'.rawurldecode($engine->href()).'&amp;remove='.$page['page_id'].'">'.$engine->get_translation('RemoveButton').'</a>)</small> '.
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