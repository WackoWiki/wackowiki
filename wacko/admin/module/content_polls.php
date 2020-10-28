<?php

if (!defined('IN_WACKO'))
{
	exit;
}

##########################################################
##	Polls Moderation									##
##########################################################
$_mode = 'content_polls';

$module[$_mode] = [
		'order'	=> 330,
		'cat'	=> 'content',
		'status'=> (RECOVERY_MODE ? false : true),
		'mode'	=> $_mode,
		'name'	=> $engine->_t($_mode)['name'],		// Polls
		'title'	=> $engine->_t($_mode)['title'],	// Editing, start and stop polls
	];

##########################################################

function admin_content_polls(&$engine, &$module)
{
	$confirmation = '';
	$moderation = '';

?>
	<h1><?php echo $module['title']; ?></h1>
	<br>
<?php
	// create polls object
	$polls_obj = new Polls($engine);

	// define context
	$admin		= true; #$engine->is_admin();
	$mode		= $module['mode'];
	$mode_http	= '';

	// processing input
	if ($admin === true)
	{
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
			$engine->log(1, Ut::perc_replace($engine->_t('LogRemovedPoll', SYSTEM_LANG), (int) $_POST['delete']));
		}
		// stop current survey
		else if (isset($_POST['stop']) && $_POST['id'])
		{
			$engine->db->sql_query(
				"UPDATE " . $engine->db->table_prefix . "poll SET " .
					"end = UTC_TIMESTAMP() " .
				"WHERE poll_id = " . (int) $_POST['id'] . " AND v_id = 0 " .
				"LIMIT 1");

			$engine->log(4, Ut::perc_replace($engine->_t('LogPollStopped', SYSTEM_LANG), (int) $_POST['id']));
		}
		// reset current survey
		else if (isset($_POST['reset']) && $_POST['id'])
		{
			$engine->db->sql_query(	// reset start date
				"UPDATE " . $engine->db->table_prefix . "poll SET " .
					"start	= UTC_TIMESTAMP() " .
				"WHERE poll_id = " . (int) $_POST['id'] . " AND v_id = 0");
			$engine->db->sql_query(	// reset votes and update servey id
				"UPDATE " . $engine->db->table_prefix . "poll SET " .
					"poll_id		= " . ($polls_obj->get_last_poll_id() + 1) . ", " .
					"votes	= 0 " .
				"WHERE poll_id = " . (int) $_POST['id']);

			#$xml->feed(); // update news feed
			$engine->log(4, Ut::perc_replace($engine->_t('LogPollReset', SYSTEM_LANG), (int) $_POST['id']));
		}
		// activate new survey
		else if (isset($_POST['activate']) && $_POST['id'])
		{
			$engine->db->sql_query(
				"UPDATE " . $engine->db->table_prefix . "poll SET " .
					"start = UTC_TIMESTAMP() " .
				"WHERE poll_id = " . (int) $_POST['id'] . " AND v_id = 0");

			#$engine->$xml->feed(); // update news feed
			$engine->log(4, Ut::perc_replace($engine->_t('LogPollStarted', SYSTEM_LANG), (int) $_POST['id']));
		}
		// edit/moderate new survey
		else if (isset($_POST['edit']) && $_POST['id'])
		{
			$edit_id		= (int) $_POST['id'];
			$header			= $polls_obj->get_poll_title($edit_id);

			if (!$header['start'] && !$header['end'])
			{
				$moderation	= true;
			}
		}
		// continued moderation
		else if (isset($_POST['moderation']))
		{
			$moderation = true;
		}
	}

	// lists output
	if ($admin === true)
	{
		// show poll results
		if (isset($_GET['poll_id']) && $_GET['results'] == 1)
		{
			echo $polls_obj->show_poll_results($_GET['poll_id']);
		}

		// poll remove confirmation dialog
		if ($confirmation === true)
		{
			echo $engine->form_open('polls_remove');

			echo '<input type="hidden" name="delete" value="' . $remove_id . '">';
			echo '<table class="formation">';
			echo '<tr><th>' . $engine->_t('PollsConfirmDelete') . '</th></tr>';
			echo '<tr><td><em>&quot;' . $title.'&quot;</em></td></tr>';
			echo '<tr><td>' .
					'<input type="submit" name="yes" id="submit" value="' . $engine->_t('SubmitButton') . '"> ' .
					'<a href="' . $engine->href('', '', $mode_http) . '" class="btn-link"><input type="button" name="cancel" id="button" value="' . $engine->_t('PollsCancel') . '"></a>' .
				'</td></tr>';
			echo '</table>';
			echo $engine->form_close();
		}
		// poll moderation
		else if ($moderation === true)
		{
			// TODO: broken redirect #pollsadd_form with embedded action
			echo $engine->action('pollsadd', ['moderation' => true, 'edit_id' => $edit_id, 'mode' => $mode]);
		}

		// current active polls
		echo $engine->form_open('polls_active');

		echo '<table class="formation lined">';
		$list = $polls_obj->get_polls_list('current');

		if (empty($list))
		{
			echo '<tr><th>' . $engine->_t('PollsCurrent') . '</th></tr>';
			echo '<tr><td class="t-center"><em>' . $engine->_t('PollsEmptyList') . '</em></td></tr>';
		}
		else
		{
			echo '<tr><th colspan="4">' . $engine->_t('PollsCurrent') . '</th></tr>';

			foreach ($list as $row)
			{
				echo '<tr>';
					echo '<td class="label">
						<input type="radio" name="id" value="' . $row['poll_id'] . '"></td>';
					echo '<td style="width:95%;">
							<a href="' .
							$engine->href('', '', ['poll_id' => $row['poll_id'], 'results' => 1]) . '">' .
							date('d/m', strtotime($row['start'])) . ': ' . $row['text'] . '</a></td>';
					echo '<td>' . $row['user_name'] . '</td>';
					echo '<td class="nowrap">' . $polls_obj->poll_time($row['start'], time()) . '</td>';
				echo '</tr>';
			}

			echo '<tr><td colspan="4">' .
					'<input type="submit" name="stop" id="stop-submit" value="' . $engine->_t('PollsStop') . '"> ' .
					'<input type="submit" name="reset" id="reset-submit" value="' . $engine->_t('PollsReset') . '"> ' .
					'<input type="submit" name="remove" id="remove-submit" value="' . $engine->_t('PollsRemove') . '">' .
				'</td></tr>';
		}

		echo '</table>';
		echo $engine->form_close();

		// polls for moderation
		echo $engine->form_open('polls_moderate');


		echo '<table class="formation lined">';
		$list = $polls_obj->get_polls_list('moderation');

		if (empty($list))
		{
			echo '<tr><th>' . $engine->_t('PollsModeration') . '</th></tr>';
			echo '<tr><td class="t-center"><em>' . $engine->_t('PollsEmptyList') . '</em></td></tr>';
		}
		else
		{
			echo '<tr><th colspan="3">' . $engine->_t('PollsModeration') . '</th></tr>';

			foreach ($list as $row)
			{
				echo '<tr>';
					echo '<td class="label"><input type="radio" name="id" value="' . $row['poll_id'] . '"></td>';
					echo '<td style="width:80%;">' . $row['text'] . '</td>';
					echo '<td class="a-top">' . $row['user_name'] . '</td>';
				echo '</tr>';
				echo '<tr>';
					$vars	= $polls_obj->get_poll_vars($row['poll_id']);
					echo '<td></td>';
					echo '<td><table>';

					foreach ($vars as $var)
					{
						echo '<tr><td>' . $var['text'] . '</td></tr>';
					}

					echo '</table></td>';
					echo '<td class="t-left a-top">' .
						($row['plural'] == 1 ? $engine->_t('PollsPlural') : $engine->_t('PollsSingular')) . '</td>';
				echo '</tr>';
			}

			echo '<tr><td colspan="3">' .
					'<input type="submit" name="activate" id="activate-submit" value="' . $engine->_t('PollsActivate') . '"> ' .
					'<input type="submit" name="edit" id="edit-submit" value="' . $engine->_t('PollsEdit') . '"> ' .
					'<input type="submit" name="remove" id="remove-submit" value="' . $engine->_t('PollsRemove') . '">' .
				'</td></tr>';
		}

		echo '</table>';
		echo $engine->form_close();

		// ended polls
		echo $engine->form_open('polls_ended');


		echo '<table class="formation lined">';
		// make list
		if ($year != 0)	$list	= $polls_obj->get_polls_list('archive', $year);
		else			$list	= $polls_obj->get_polls_list('ended');
						$years	= $polls_obj->poll_years();
		if (empty($list))
		{
			echo '<tr><th>' . $engine->_t('PollsEnded') . '</th></tr>';
			echo '<tr><td class="t-center"><em>' . $engine->_t('PollsEmptyList') . '</em></td></tr>';
		}
		else
		{
			echo '<tr><th colspan="4">' . $engine->_t('PollsEnded') . '</th></tr>';

			foreach ($list as $row)
			{
				echo '<tr>';
					echo '<td class="label"><input type="radio" name="id" value="' . $row['poll_id'] . '"></td>';
					echo '<td style="width:95%;"><a href="' .
						$engine->href('', '', ['year' => $year, 'poll_id' => $row['poll_id'], 'results' => 1]) . '">' .
						date('d/m/y', strtotime($row['start'])) . ': ' . $row['text'] . '</a></td>';
					echo '<td>' . $row['user_name'] . '</td>';
					echo '<td class="nowrap">' . $polls_obj->poll_time($row['start'], $row['end']) . '</td>';
				echo '</tr>';
			}
		}

		echo '<tr><td colspan="4">';
		// pagination
		echo '<small><strong>' . $engine->_t('PollsShow') . ':</strong> ';

		if ($year == 0)
		{
			echo $engine->_t('PollsAll') . ' ';
		}
		else
		{
			echo '<a href="' . $engine->href('', '', ['year' => 0]) . '">' . $engine->_t('PollsAll') . '</a> ';
		}

		if (!empty($years))
		{
			foreach ($years as $item)
			{
				if ($item == $year)
				{
					echo $item.' ';
				}
				else
				{
					echo '<a href="' . $engine->href('', '', ['year' => $item]) . '">' . $item . '</a> ';
				}
			}
		}

		echo '</small>';
		echo '</td></tr>';

		if (!empty($list))
		{
			echo '<tr><td colspan="4">' .
					'<input type="submit" name="remove" id="submit" value="' . $engine->_t('PollsRemove') . '">' .
				'</td></tr>';
		}

		echo '</table>';
		echo $engine->form_close();
	}

	// destroy polls object
	unset($polls_obj);
}

