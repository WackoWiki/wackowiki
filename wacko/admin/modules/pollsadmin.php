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
	$confirmation = '';
	$moderation = '';

?>
	<h1><?php echo $module['title']; ?></h1>
	<br />
<?php
	// create polls object
	$engine->use_class('polls');
	$polls_obj = new Polls($engine);

	// define context
	$admin		= true; #$engine->is_admin();
	$mode		= $module['mode'];
	$mode_http	= 'mode='.$mode.'&amp;';
	$mode_file	= $_SERVER['PHP_SELF'];

	// processing input
	if ($admin === true)
	{
		#$engine->use_class('rss');
		#$xml = new rss($engine);

		// selected year for archived polls
		if (!isset($_GET['year']))	$year	= date('Y');
		else						$year	= $_GET['year'];

		// intent to remove a survey
		if (isset($_POST['remove']) && $_POST['id'])
		{
			$remove_id		= $_POST['id'];
			$title			= $polls_obj->get_poll_title($remove_id);
			$title			= $title['text'];
			$confirmation	= true;
		}
		// approvely delete a survey
		else if (isset($_POST['delete']) && $_POST['yes'])
		{
			$polls_obj->remove_poll($_POST['delete']);
			$engine->log(1, str_replace('%1', (int)$_POST['delete'], $engine->get_translation('LogRemovedPoll', $engine->config['language'])));
		}
		// stop current survey
		else if (isset($_POST['stop']) && $_POST['id'])
		{
			$engine->query(
				"UPDATE {$engine->config['table_prefix']}poll ".
				"SET end = NOW() ".
				"WHERE poll_id = ".quote($engine->dblink, (int)$_POST['id'])." AND v_id = 0 ".
				"LIMIT 1");
			$engine->log(4, str_replace('%1', (int)$_POST['id'], $engine->get_translation('LogPollStopped', $engine->config['language'])));
		}
		// reset current survey
		else if (isset($_POST['reset']) && $_POST['id'])
		{
			$engine->query(	// reset start date
				"UPDATE {$engine->config['table_prefix']}poll SET ".
					"start	= NOW() ".
				"WHERE poll_id = ".quote($engine->dblink, (int)$_POST['id'])." AND v_id = 0");
			$engine->query(	// reset votes and update servey id
				"UPDATE {$engine->config['table_prefix']}poll SET ".
					"poll_id		= ".($polls_obj->get_last_poll_id() + 1).", ".
					"votes	= 0 ".
				"WHERE poll_id = ".quote($engine->dblink, (int)$_POST['id']));
			$xml->news(); // update news feed
			$engine->log(4, str_replace('%1', (int)$_POST['id'], $engine->get_translation('LogPollReset', $engine->config['language'])));
		}
		// activate new survey
		else if (isset($_POST['activate']) && $_POST['id'])
		{
			$engine->query(
				"UPDATE {$engine->config['table_prefix']}poll ".
				"SET start = NOW() ".
				"WHERE poll_id = ".quote($engine->dblink, (int)$_POST['id'])." AND v_id = 0");

			$engine->$xml->news(); // update news feed
			$engine->log(4, str_replace('%1', (int)$_POST['id'], $engine->get_translation('LogPollStarted', $engine->config['language'])));
		}
		// edit/moderate new survey
		else if (isset($_POST['edit']) && $_POST['id'])
		{
			$edit_id		= $_POST['id'];
			$header			= $polls_obj->get_poll_title($edit_id);
			if ($header['start'] == SQL_NULLDATE && $header['end'] == SQL_NULLDATE)
				$moderation	= true;
		}
		// continued moderation
		else if (isset($_POST['moderation']))
		{
			$moderation = true;
		}

		unset($xml);
	}

	// lists output
	if ($admin === true && isset($install) === false)
	{
		// show poll results
		if (isset($_GET['poll']) && $_GET['results'] == 1)
		{
			echo $polls_obj->show_poll_results($_GET['poll']);
		}

		// poll remove confirmation dialog
		if ($confirmation === true)
		{
			#echo $engine->form_open('', $mode_file);
			#echo '<input name="mode" type="hidden" value="'.$mode.'" />';
			echo '	<form action="admin.php" method="post" name="polls">';
			echo '<input type="hidden" name="mode" value="pollsadmin" />';

			echo '<input name="delete" type="hidden" value="'.$remove_id.'" />';
			echo '<table cellspacing="3" class="formation">';
			echo '<tr><th>'.$engine->get_translation('PollsConfirmDelete').'</th></tr>';
			echo '<tr><td><em>&quot;'.$title.'&quot;</em></td></tr>';
			echo '<tr><td>'.
				'<input name="yes" id="submit" type="submit" value="'.$engine->get_translation('PollsSubmit').'" /> '.
				'<input name="cancel" id="button" type="button" value="'.$engine->get_translation('PollsCancel').'" onclick="document.location=\''.addslashes(rawurldecode($engine->href('', $mode_file, $mode_http))).'\';" />'.
				'</td></tr>';
			echo '</table>';
			echo $engine->form_close();
		}
		// poll moderation
		else if ($moderation === true)
		{
			echo $engine->action('pollsadd', array('moderation' => true, 'edit_id' => $edit_id, 'mode' => $mode));
		}

		// current active polls
			#echo $engine->form_open('', $mode_file);
			#echo '<input name="mode" type="hidden" value="'.$mode.'" />';
			echo '	<form action="admin.php" method="post" name="polls">';
			echo '<input type="hidden" name="mode" value="pollsadmin" />';

		echo '<table cellspacing="3" class="formation">';
		$list = $polls_obj->get_polls_list('current');
		if (empty($list))
		{
			echo '<tr><th>'.$engine->get_translation('PollsCurrent').'</th></tr>';
			echo '<tr><td align="center"><em>'.$engine->get_translation('PollsEmptyList').'</em></td></tr>';
		}
		else
		{
			echo '<tr><th colspan="4">'.$engine->get_translation('PollsCurrent').'</th></tr>';
			foreach ($list as $row)
			{
				echo '<tr class="lined">';
					echo '<td class="label"><input name="id" type="radio" value="'.$row['poll_id'].'" /></td>';
					echo '<td style="text-align:left;width:95%;"><a href="'.
						rawurldecode($engine->href('', $mode_file, $mode_http.'poll='.$row['poll_id'].'&amp;results=1')).'">'.
						date('d/m', strtotime($row['start'])).': '.$row['text'].'</a></td>';
					echo '<td>'.$row['user'].'</td>';
					echo '<td style="white-space:nowrap;">'.$polls_obj->poll_time($row['start'], time()).'</td>';
				echo '</tr>';
			}
			echo '<tr><td colspan="4">'.
				'<input name="stop" id="submit" type="submit" value="'.$engine->get_translation('PollsStop').'" /> '.
				'<input name="reset" id="submit" type="submit" value="'.$engine->get_translation('PollsReset').'" /> '.
				'<input name="remove" id="submit" type="submit" value="'.$engine->get_translation('PollsRemove').'" />'.
				'</td></tr>';
		}
		echo '</table>';
		echo $engine->form_close();

		// polls for moderation
			#echo $engine->form_open('', $mode_file);
			#echo '<input name="mode" type="hidden" value="'.$mode.'" />';
			echo '	<form action="admin.php" method="post" name="polls">';
			echo '<input type="hidden" name="mode" value="pollsadmin" />';

		echo '<table cellspacing="3" class="formation">';
		$list = $polls_obj->get_polls_list('moderation');
		if (empty($list))
		{
			echo '<tr><th>'.$engine->get_translation('PollsModeration').'</th></tr>';
			echo '<tr><td align="center"><em>'.$engine->get_translation('PollsEmptyList').'</em></td></tr>';
		}
		else
		{
			echo '<tr><th colspan="3">'.$engine->get_translation('PollsModeration').'</th></tr>';

			foreach ($list as $row)
			{
				echo '<tr>';
					echo '<td class="label"><input name="id" type="radio" value="'.$row['poll_id'].'" /></td>';
					echo '<td style="text-align:left;width:80%;">'.$row['text'].'</td>';
					echo '<td valign="top">'.$row['user'].'</td>';
				echo '</tr>';
				echo '<tr>';
					$vars	= $polls_obj->get_poll_vars($row['poll_id']);
					echo '<td></td>';
					echo '<td><table>';

					foreach ($vars as $var)
					{
						echo '<tr class="lined"><td style="text-align:left;">'.$var['text'].'</td></tr>';
					}

					echo '</table></td>';
					echo '<td style="text-align:left;" valign="top">'.
						($row['plural'] == 1 ? $engine->get_translation('PollsPlural') : $engine->get_translation('PollsSingular')).'</td>';
				echo '</tr>';
			}

			echo '<tr><td colspan="3">'.
				'<input name="activate" id="submit" type="submit" value="'.$engine->get_translation('PollsActivate').'" /> '.
				'<input name="edit" id="submit" type="submit" value="'.$engine->get_translation('PollsEdit').'" /> '.
				'<input name="remove" id="submit" type="submit" value="'.$engine->get_translation('PollsRemove').'" />'.
				'</td></tr>';
		}

		echo '</table>';
		echo $engine->form_close();

		// ended polls
			#echo $engine->form_open('', $mode_file);
			#echo '<input name="mode" type="hidden" value="'.$mode.'" />';
			echo '	<form action="admin.php" method="post" name="polls">';
			echo '<input type="hidden" name="mode" value="pollsadmin" />';

		echo '<table cellspacing="3" class="formation">';
		// make list
		if ($year != 0)	$list	= $polls_obj->get_polls_list('archive', $year);
		else			$list	= $polls_obj->get_polls_list('ended');
						$years	= $polls_obj->poll_years();
		if (empty($list))
		{
			echo '<tr><th>'.$engine->get_translation('PollsEnded').'</th></tr>';
			echo '<tr><td align="center"><em>'.$engine->get_translation('PollsEmptyList').'</em></td></tr>';
		}
		else
		{
			echo '<tr><th colspan="4">'.$engine->get_translation('PollsEnded').'</th></tr>';

			foreach ($list as $row)
			{
				echo '<tr class="lined">';
					echo '<td class="label"><input name="id" type="radio" value="'.$row['poll_id'].'" /></td>';
					echo '<td style="text-align:left;width:95%;"><a href="'.
						rawurldecode($engine->href('', $mode_file, $mode_http.'year='.$year.'&amp;poll='.$row['poll_id'].'&amp;results=1')).'">'.
						date('d/m/y', strtotime($row['start'])).': '.$row['text'].'</a></td>';
					echo '<td>'.$row['user'].'</td>';
					echo '<td style="white-space:nowrap;">'.$polls_obj->poll_time($row['start'], $row['end']).'</td>';
				echo '</tr>';
			}
		}

		echo '<tr><td colspan="4">';
		// pagination
		echo '<small><strong>'.$engine->get_translation('PollsShow').':</strong> ';
		if ($year == 0)
			echo $engine->get_translation('PollsAll').' ';
		else
			echo '<a href="'.rawurldecode($engine->href('', $mode_file, $mode_http.'year=0')).'">'.$engine->get_translation('PollsAll').'</a> ';

		if (!empty($years))
		{
			foreach ($years as $item)
			{
				if ($item == $year) echo $item.' ';
				else echo '<a href="'.rawurldecode($engine->href('', $mode_file, $mode_http.'year='.$item)).'">'.$item.'</a> ';
			}
		}
		echo '</small>';
		echo '</td></tr>';

		if (!empty($list))
		{
			echo '<tr><td colspan="4">'.
				'<input name="remove" id="submit" type="submit" value="'.$engine->get_translation('PollsRemove').'" />'.
				'</td></tr>';
		}
		echo '</table>';
		echo $engine->form_close();
	}

	// destroy polls object
	unset($polls_obj);
}

?>