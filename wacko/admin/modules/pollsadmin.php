<?php

########################################################
##   Polls Moderation                                 ##
########################################################

$module['pollsadmin'] = array(
		'order'	=> 4,
		'cat'	=> 'Content',
		'mode'	=> 'pollsadmin',
		'name'	=> 'Polls',
		'title'	=> 'Editing, start and stop polls',
	);

########################################################

function admin_pollsadmin(&$engine, &$module)
{
?>
	<h1><?php echo $module['title']; ?></h1>
	<br />
<?php
	// create polls object
	$engine->UseClass("polls", "classes/");
	$pollsObj = new Polls($engine);

	// define context
	$admin		= true; #$engine->IsAdmin();
	$mode		= $module['mode'];
	$mode_http	= 'mode='.$mode.'&amp;';
	$mode_file	= $_SERVER['PHP_SELF'];

	// processing input
	if ($admin === true)
	{
		#$engine->UseClass("rss", "classes/");
		#$xml = new RSS($engine);

		// selected year for archived polls
		if (!isset($_GET['year']))	$year	= date('Y');
		else						$year	= $_GET['year'];

		// intent to remove a survey
		if ($_POST['remove'] && $_POST['id'])
		{
			$remove_id		= $_POST['id'];
			$title			= $pollsObj->GetPollTitle($remove_id);
			$title			= $title['text'];
			$confirmation	= true;
		}
		// approvely delete a survey
		else if ($_POST['delete'] && $_POST['yes'])
		{
			$pollsObj->RemovePoll($_POST['delete']);
			$engine->Log(1, str_replace('%1', (int)$_POST['delete'], $engine->GetTranslation('LogRemovedPoll')));
		}
		// stop current survey
		else if ($_POST['stop'] && $_POST['id'])
		{
			$engine->Query(
				"UPDATE {$engine->config['table_prefix']}polls ".
				"SET end = NOW() ".
				"WHERE poll_id = ".quote($engine->dblink, (int)$_POST['id'])." AND v_id = 0 ".
				"LIMIT 1");
			$engine->Log(4, str_replace('%1', (int)$_POST['id'], $engine->GetTranslation('LogPollStopped')));
		}
		// reset current survey
		else if ($_POST['reset'] && $_POST['id'])
		{
			$engine->Query(	// reset start date
				"UPDATE {$engine->config['table_prefix']}polls SET ".
					"start	= NOW() ".
				"WHERE poll_id = ".quote($engine->dblink, (int)$_POST['id'])." AND v_id = 0");
			$engine->Query(	// reset votes and update servey id
				"UPDATE {$engine->config['table_prefix']}polls SET ".
					"poll_id		= ".($pollsObj->GetLastPollID() + 1).", ".
					"votes	= 0 ".
				"WHERE poll_id = ".quote($engine->dblink, (int)$_POST['id']));
			$xml->News(); // update news feed
			$engine->Log(4, str_replace('%1', (int)$_POST['id'], $engine->GetTranslation('LogPollReset')));
		}
		// activate new survey
		else if ($_POST['activate'] && $_POST['id'])
		{
			$engine->Query(
				"UPDATE {$engine->config['table_prefix']}polls ".
				"SET start = NOW() ".
				"WHERE poll_id = ".quote($engine->dblink, (int)$_POST['id'])." AND v_id = 0");
			$xml->News(); // update news feed
			$engine->Log(4, str_replace('%1', (int)$_POST['id'], $engine->GetTranslation('LogPollStarted')));
		}
		// edit/moderate new survey
		else if ($_POST['edit'] && $_POST['id'])
		{
			$edit_id		= $_POST['id'];
			$header			= $pollsObj->GetPollTitle($edit_id);
			if ($header['start'] == SQL_NULLDATE && $header['end'] == SQL_NULLDATE)
				$moderation	= true;
		}
		// continued moderation
		else if ($_POST['moderation'])
		{
			$moderation = true;
		}

		unset($xml);
	}

	// lists output
	if ($admin === true && isset($install) === false)
	{
		// show poll results
		if ($_GET['poll'] && $_GET['results'] == 1)
		{
			echo $pollsObj->ShowPollResults($_GET['poll']);
		}

		// poll remove confirmation dialog
		if ($confirmation === true)
		{
			echo $engine->FormOpen('', $mode_file);
			echo '<input name="mode" type="hidden" value="'.$mode.'" />';
			echo '<input name="delete" type="hidden" value="'.$remove_id.'" />';
			echo '<table cellspacing="3" class="formation">';
			echo '<tr><th>'.$engine->GetTranslation('PollsConfirmDelete').'</th></tr>';
			echo '<tr><td><em>&quot;'.$title.'&quot;</em></td></tr>';
			echo '<tr><td>'.
				'<input name="yes" id="submit" type="submit" value="'.$engine->GetTranslation('PollsSubmit').'" /> '.
				'<input name="cancel" id="button" type="button" value="'.$engine->GetTranslation('PollsCancel').'" onclick="document.location=\''.addslashes(rawurldecode($engine->href('', $mode_file, $mode_http))).'\';" />'.
				'</td></tr>';
			echo '</table>';
			echo $engine->FormClose();
		}
		// poll moderation
		else if ($moderation === true)
		{
			echo $engine->Action('pollsadd', array('moderation' => true, 'edit_id' => $edit_id, 'mode' => $mode));
		}

		// current active polls
		echo $engine->FormOpen('', $mode_file);
		echo '<input name="mode" type="hidden" value="'.$mode.'" />';
		echo '<table cellspacing="3" class="formation">';
		$list = $pollsObj->GetPollsList('current');
		if (empty($list))
		{
			echo '<tr><th>'.$engine->GetTranslation('PollsCurrent').'</th></tr>';
			echo '<tr><td align="center"><em>'.$engine->GetTranslation('PollsEmptyList').'</em></td></tr>';
		}
		else
		{
			echo '<tr><th colspan="4">'.$engine->GetTranslation('PollsCurrent').'</th></tr>';
			foreach ($list as $row)
			{
				echo '<tr class="lined">';
					echo '<td class="label"><input name="id" type="radio" value="'.$row['poll_id'].'" /></td>';
					echo '<td style="text-align:left;width:95%;"><a href="'.
						rawurldecode($engine->href('', $mode_file, $mode_http.'poll='.$row['poll_id'].'&amp;results=1')).'">'.
						date('d/m', strtotime($row['start'])).': '.$row['text'].'</a></td>';
					echo '<td>'.$row['user_id'].'</td>';
					echo '<td style="white-space:nowrap;">'.$pollsObj->PollTime($row['start'], time()).'</td>';
				echo '</tr>';
			}
			echo '<tr><td colspan="4">'.
				'<input name="stop" id="submit" type="submit" value="'.$engine->GetTranslation('PollsStop').'" /> '.
				'<input name="reset" id="submit" type="submit" value="'.$engine->GetTranslation('PollsReset').'" /> '.
				'<input name="remove" id="submit" type="submit" value="'.$engine->GetTranslation('PollsRemove').'" />'.
				'</td></tr>';
		}
		echo '</table>';
		echo $engine->FormClose();

		// polls for moderation
		echo $engine->FormOpen('', $mode_file);
		echo '<input name="mode" type="hidden" value="'.$mode.'" />';
		echo '<table cellspacing="3" class="formation">';
		$list = $pollsObj->GetPollsList('moderation');
		if (empty($list))
		{
			echo '<tr><th>'.$engine->GetTranslation('PollsModeration').'</th></tr>';
			echo '<tr><td align="center"><em>'.$engine->GetTranslation('PollsEmptyList').'</em></td></tr>';
		}
		else
		{
			echo '<tr><th colspan="3">'.$engine->GetTranslation('PollsModeration').'</th></tr>';
			foreach ($list as $row)
			{
				echo '<tr>';
					echo '<td class="label"><input name="id" type="radio" value="'.$row['poll_id'].'" /></td>';
					echo '<td style="text-align:left;width:80%;">'.$row['text'].'</td>';
					echo '<td valign="top">'.$row['user'].'</td>';
				echo '</tr>';
				echo '<tr>';
					$vars	= $pollsObj->GetPollVars($row['poll_id']);
					echo '<td></td>';
					echo '<td><table>';
					foreach ($vars as $var)
					{
						echo '<tr class="lined"><td style="text-align:left;">'.$var['text'].'</td></tr>';
					}
					echo '</table></td>';
					echo '<td style="text-align:left;" valign="top">'.
						($row['plural'] == 1 ? $engine->GetTranslation('PollsPlural') : $engine->GetTranslation('PollsSingular')).'</td>';
				echo '</tr>';
			}
			echo '<tr><td colspan="3">'.
				'<input name="activate" id="submit" type="submit" value="'.$engine->GetTranslation('PollsActivate').'" /> '.
				'<input name="edit" id="submit" type="submit" value="'.$engine->GetTranslation('PollsEdit').'" /> '.
				'<input name="remove" id="submit" type="submit" value="'.$engine->GetTranslation('PollsRemove').'" />'.
				'</td></tr>';
		}
		echo '</table>';
		echo $engine->FormClose();

		// ended polls
		echo $engine->FormOpen('', $mode_file);
		echo '<input name="mode" type="hidden" value="'.$mode.'" />';
		echo '<table cellspacing="3" class="formation">';
		// make list
		if ($year != 0)	$list	= $pollsObj->GetPollsList('archive', $year);
		else			$list	= $pollsObj->GetPollsList('ended');
						$years	= $pollsObj->PollYears();
		if (empty($list))
		{
			echo '<tr><th>'.$engine->GetTranslation('PollsEnded').'</th></tr>';
			echo '<tr><td align="center"><em>'.$engine->GetTranslation('PollsEmptyList').'</em></td></tr>';
		}
		else
		{
			echo '<tr><th colspan="4">'.$engine->GetTranslation('PollsEnded').'</th></tr>';

			foreach ($list as $row)
			{
				echo '<tr class="lined">';
					echo '<td class="label"><input name="id" type="radio" value="'.$row['poll_id'].'" /></td>';
					echo '<td style="text-align:left;width:95%;"><a href="'.
						rawurldecode($engine->href('', $mode_file, $mode_http.'year='.$year.'&amp;poll='.$row['poll_id'].'&amp;results=1')).'">'.
						date('d/m/y', strtotime($row['start'])).': '.$row['text'].'</a></td>';
					echo '<td>'.$row['user_id'].'</td>';
					echo '<td style="white-space:nowrap;">'.$pollsObj->PollTime($row['start'], $row['end']).'</td>';
				echo '</tr>';
			}
		}

		echo '<tr><td colspan="4">';
		// pagination
		echo '<small><strong>'.$engine->GetTranslation('PollsShow').':</strong> ';
		if ($year == 0) echo $engine->GetTranslation('PollsAll').' ';
		else echo '<a href="'.rawurldecode($engine->href('', $mode_file, $mode_http.'year=0')).'">'.$engine->GetTranslation('PollsAll').'</a> ';
		foreach ($years as $item)
		{
			if ($item == $year) echo $item.' ';
			else echo '<a href="'.rawurldecode($engine->href('', $mode_file, $mode_http.'year='.$item)).'">'.$item.'</a> ';
		}
		echo '</small>';
		echo '</td></tr>';

		if (!empty($list))
		{
			echo '<tr><td colspan="4">'.
				'<input name="remove" id="submit" type="submit" value="'.$engine->GetTranslation('PollsRemove').'" />'.
				'</td></tr>';
		}
		echo '</table>';
		echo $engine->FormClose();
	}

	// destroy polls object
	unset($pollsObj);
}

?>