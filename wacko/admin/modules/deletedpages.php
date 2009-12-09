<?php

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
?>
	<h1><?php echo $module['title']; ?></h1>
	<br />
<?php
	// clear specific page revisions
	if ($_GET['remove'])
	{
		$engine->Query(
			"DELETE FROM {$engine->config['table_prefix']}revisions ".
			"WHERE tag = '".quote($_GET['remove'])."'");
	}
	
	$pages = $engine->LoadRecentlyDeleted(100000, 0);
?>
	<p>
		List of remote documents, copies of which were in the table editors.
Finally remove the document from the database by clicking on the link <em>Remove</em>
		in the corresponding row. (Be careful not to delete confirmation is not requested!)
	</p>
<?php
	if ($pages == true)
	{
		echo '<table>';
		
		foreach ($pages as $page)
		{
			// day header
			list($day, $time) = explode(' ', $page['date']);
			
			if ($day != $curday)
			{
				if ($curday) print("\n");
				echo '<tr class="lined"><td colspan="2"><br /><strong>'.date($engine->config['date_format'],strtotime($day)).":</strong></td></tr>\n";
				$curday = $day;
			}
			
			// print entry
			echo '<tr>'.
					'<td style="text-align:left">'.
						'<small>('.date($engine->config['time_format_seconds'], strtotime($time)).' - <a href="'.rawurldecode($engine->href()).'&amp;remove='.$page['tag'].'">'.$engine->GetTranslation('RemoveButton').'</a>)</small> '.
						$engine->ComposeLinkToPage($page['tag'], 'revisions', '', 0).
					'</td>'.
				"</tr>\n";
		}
		
		echo '</table>';
	}
	else
	{
		echo $engine->GetTranslation('NoRecentlyDeleted');
	}
}

?>