<?php

/*

########################################################
##                Polls common methods                ##
########################################################


*/

class Polls
{
	// VARIABLES
	var $engine;

	// CONSTRUCTOR
	function Polls(&$engine)
	{
		$this->engine = & $engine;
	}

	// id number of the latest poll
	function GetLastPollID()
	{
		$id = $this->engine->LoadSingle(
			'SELECT poll_id '.
			'FROM '.$this->engine->config['table_prefix'].'polls '.
			'ORDER BY poll_id DESC '.
			'LIMIT 1');
		if ($id['id'] == false) return 0;
		else return $id['id'];
	}

	// title information for a given poll
	function GetPollTitle($id)
	{
		$title = $this->engine->LoadSingle(
			"SELECT poll_id, text, user_id, plural, votes, start, end ".
			"FROM {$this->engine->config['table_prefix']}polls ".
			"WHERE poll_id = $id AND v_id = 0");
		return $title;
	}

	// variants data for a given poll
	// sorts by total votes if "$votes = 1"
	function GetPollVars($id, $votes = 0)
	{
		$vars = $this->engine->LoadAll(
			"SELECT poll_id, v_id, text, votes ".
			"FROM {$this->engine->config['table_prefix']}polls ".
			"WHERE poll_id = $id AND v_id <> 0 ".
			"ORDER BY ".($votes == 1 ? "votes DESC, " : "")."v_id ASC");
		return $vars;
	}

	// all years when new surveys was started
	function PollYears()
	{
		$list = $this->engine->LoadAll(
			"SELECT YEAR(start) AS years ".
			"FROM {$this->engine->config['table_prefix']}polls ".
			"WHERE v_id = 0 AND start <> '".SQL_NULLDATE."' ".
			"GROUP BY years ".
			"ORDER BY years DESC");
		foreach ($list as $item)
		{
			$years[] = $item['years'];
		}
		return $years;
	}

	// the duration of a poll in days
	function PollTime($start, $end)
	{
		if (is_string($start))	$start	= strtotime($start);
		if (is_string($end))	$end	= strtotime($end);
		return ceil((($end - $start) / 3600) / 24);
	}

	// various polls lists
	function GetPollsList($mode, $year = 0)
	{
		switch ($mode)
		{
			case 'active':
			case 'current':
				$list = $this->engine->LoadAll(
					"SELECT poll_id, text, user_id, plural, start ".
					"FROM {$this->engine->config['table_prefix']}polls ".
					"WHERE v_id = 0 AND start <> '".SQL_NULLDATE."' AND end = '".SQL_NULLDATE."' ".
					"ORDER BY start DESC");
				break;
			case 'mod':
			case 'moderation':
				$list = $this->engine->LoadAll(
					"SELECT poll_id, text, user_id, plural ".
					"FROM {$this->engine->config['table_prefix']}polls ".
					"WHERE v_id = 0 AND start = '".SQL_NULLDATE."' AND end = '".SQL_NULLDATE."' ".
					"ORDER BY poll_id ASC");
				break;
			case 'ended':
				$list = $this->engine->LoadAll(
					"SELECT poll_id, text, user_id, plural, start, end ".
					"FROM {$this->engine->config['table_prefix']}polls ".
					"WHERE v_id = 0 AND start <> '".SQL_NULLDATE."' AND end <> '".SQL_NULLDATE."' ".
					"ORDER BY end DESC");
				break;
			case 'archive':
				if ($year == 0) $year = date('Y');
				$list = $this->engine->LoadAll(
					"SELECT poll_id, text, user_id, plural, start, end ".
					"FROM {$this->engine->config['table_prefix']}polls ".
					"WHERE v_id = 0 AND start <> '".SQL_NULLDATE."' ".
						"AND end <> '".SQL_NULLDATE."' AND YEAR(start) = $year ".
					"ORDER BY end DESC");
				break;
			default:
			case 'all':
				$list = $this->engine->LoadAll(
					"SELECT poll_id, text, user_id, plural, start, end ".
					"FROM {$this->engine->config['table_prefix']}polls ".
					"WHERE v_id = 0 AND start <> '".SQL_NULLDATE."' ".
					"ORDER BY start DESC");
		}
		return $list;
	}

	// add a new poll into the database
	function SubmitPoll($id, $topic, $plural, $answers, $user, $start = 0)
	{
		$topic	= quote($this->engine->dblink, $topic);
		$user	= quote($this->engine->dblink, $user);
		if ($plural != 1) $plural = 0;

		// submitting title
		$this->engine->Query(
			"INSERT INTO {$this->engine->config['table_prefix']}polls SET ".
				"poll_id	= $id, ".
				"text		= '".quote($this->engine->dblink, rtrim($topic, '.'))."', ".
				"user_id	= '".quote($this->engine->dblink, $user)."', ".
				"plural		= $plural, ".
				"start		= ".($start == 1 ? "NOW()" : "'".SQL_NULLDATE."'"));

		// submitting variants
		foreach ($answers as $v_id => $v_text)
		{
			$v_id	+= 1;
			$v_text	= quote($this->engine->dblink, $v_text);
			$this->engine->Query(
				"INSERT INTO {$this->engine->config['table_prefix']}polls SET ".
					"poll_id	= $id, ".
					"v_id		= $v_id, ".
					"text		= '".quote($this->engine->dblink, rtrim($v_text, '.'))."'");
		}
		return true;
	}

	// remove a given poll from the datebase
	function RemovePoll($id)
	{
		return $this->engine->Query(
			"DELETE FROM {$this->engine->config['table_prefix']}polls ".
			"WHERE poll_id = $id");
	}

	// print voting form
	// tag parameter specifies wiki page
	// for form action url if necessary
	function ShowPollVote($id, $tag = '')
	{
		if ($tag != '') $tag = str_replace('%2F', '/', rawurlencode($tag));

		// load poll data
		$header		= $this->GetPollTitle($id);
		$vars		= $this->GetPollVars($id);
		$duration	= $this->PollTime($header['start'], ($header['end'] == SQL_NULLDATE ? time() : $header['end']));
		$user		= ( strpos($header['user_id'], '.') ? '<em>'.$this->engine->GetTranslation('PollsGuest').'</em>' : $header['user_id'] );

		if ($header['start'] == SQL_NULLDATE)
		{	// non-existent or not moderated poll
			$poll	= '<table cellspacing="3" class="formation">'.
					'<tr><th>'.$this->engine->GetTranslation('PollsError').'</th></tr>'.
					'<tr><td align="center"><em>'.$this->engine->GetTranslation('PollsNotExists').'</em></td></tr>'.
					'</table>';
		}
		else
		{
			$poll	= $this->engine->FormOpen('', $tag, '', '', '', '#poll'.$id.'_form').
					'<a name="p'.date('dm', strtotime($header['start'])).'"></a>'.
					'<a name="poll'.$id.'_form"></a>'.
					'<input name="poll" type="hidden" value="'.$id.'" />'.
					'<table cellspacing="3" class="formation">'.
					'<tr><th colspan="2" style="text-align:left;">'.date('d/m', strtotime($header['start'])).' (id'.((int)$id).'): '.$header['text'].'</th></tr>';
			foreach ($vars as $var)
			{
				$poll	.= '<tr><td class="label">'.
							($header['plural'] == 1
								? '<input name="'.$var['v_id'].'" type="checkbox" value="1" />'
								: '<input name="id" type="radio" value="'.$var['v_id'].'" />').
							'</td>'.
						'<td style="width:95%;text-align:left;">'.$var['text'].'</td></tr>'.
						'<tr class="lined"><td colspan="2"></td></tr>';
			}
			$poll	.= '<tr><td colspan="2"><small>'.$this->engine->GetTranslation('PollsLasts').': '.$duration.
						'<br />'.$this->engine->GetTranslation('PollsAdded').': '.( strpos($header['user_id'], '.') ? $user : '<a href="'.$this->engine->href('', $this->engine->config['users_page'], 'profile='.$user).'">'.$user.'</a>' ).'</small></td></tr>'.
					'<tr><td colspan="2" style="white-space:nowrap;">'.
					'<input name="vote" id="submit" type="submit" value="'.$this->engine->GetTranslation('PollsSubmit').'" /> '.
					'<input name="results" id="submit" type="submit" value="'.$this->engine->GetTranslation('PollsResults').'" />'.
					'</tr></td>'.
					'</table>'.
					$this->engine->FormClose();
		}
		return $poll;
	}

	// print survey results
	function ShowPollResults($id)
	{
		// load poll data
		$header		= $this->GetPollTitle($id);
		$vars		= $this->GetPollVars($id, 1);
		$duration	= $this->PollTime($header['start'], ($header['end'] == SQL_NULLDATE ? time() : $header['end']));
		$user		= ( strpos($header['user_id'], '.') ? '<em>'.$this->engine->GetTranslation('PollsGuest').'</em>' : $header['user_id'] );
		$voters	= $header['votes'];

		if ($header['plural'] != 1)		$total  = $header['votes'];
		else foreach ($vars as $var)	$total += $var['votes'];

		if ($header['start'] == SQL_NULLDATE)
		{	// non-existent or not moderated poll
			$poll	= '<table cellspacing="3" class="formation">'.
					'<tr><th>'.$this->engine->GetTranslation('PollsError').'</th></tr>'.
					'<tr><td align="center"><em>'.$this->engine->GetTranslation('PollsNotExists').'</em></td></tr>'.
					'</table>';
		}
		else
		{
			$poll	= $this->engine->FormOpen().
					'<a name="p'.date('dm', strtotime($header['start'])).'"></a>'.
					'<a name="poll'.$id.'_form"></a>'.
					'<table cellspacing="3" class="formation">'.
					'<tr><th colspan="3" style="text-align:left;">'.date('d/m', strtotime($header['start'])).' (id'.((int)$id).'): '.$header['text'].'</th></tr>';
			foreach ($vars as $var)
			{
				$percent = ($total == 0 ? 0 : round($var['votes'] / $total * 100, 1));
				$poll	.= '<tr class="lined"><td style="width:95%;text-align:left;">'.$var['text'].'</td>'.
						'<td>&nbsp;<strong>'.$var['votes'].'</strong>&nbsp;</td>'.
						'<td>&nbsp;<strong>'.$percent.'%</strong></td></tr>';
			}
			$poll	.= '<tr><td colspan="3"><small>'.$this->engine->GetTranslation('PollsTotalVotes').': '.$voters.
						'<br />'.($header['end'] != SQL_NULLDATE ? $this->engine->GetTranslation('PollsLasted') :
							$this->engine->GetTranslation('PollsLasts')).': '.$duration.
						'<br />'.$this->engine->GetTranslation('PollsAdded').': '.( strpos($header['user_id'], '.') ? $user : '<a href="'.$this->engine->href('', $this->engine->config['users_page'], 'profile='.$user).'">'.$user.'</a>' ).'</small></td></tr>'.
					'</table>'.
					$this->engine->FormClose();
		}

		if ($header == true)
		{
			return $poll;
		}
		else
		{
			return false;
		}
	}

	// determine if user has voted a given poll
	function PollIsVoted($id)
	{
		$cookie	= $this->engine->GetCookie('poll');
		$ids	= explode(';', $cookie);

		if (in_array($id, $ids) === true || $id == $cookie) return true;
		else return false;
	}

	// set poll cookie
	function SetPollCookie($id)
	{
		if ($cookie = $this->engine->GetCookie('poll')) $ids = explode(';', $cookie);
		$ids[]	= $id;
		$cookie	= implode(';', $ids);
		$this->engine->SetSessionCookie('poll', $cookie);
		$this->engine->SetPersistentCookie('poll', $cookie, 365);
		return true;
	}

	// vote a given poll
	// if $ballot is an array it is
	// presumed that survey is plural
	function VotePoll($id, $ballot)
	{
		$header	= $this->GetPollTitle($id);
		$vars	= $this->GetPollVars($id, 1);

		if (!is_array($ballot)) $ballot = array($ballot);

		foreach ($vars as $var)
		{
			foreach ($ballot as $vote => $vote_id)
			{
				if ($var['v_id'] == $vote_id)
				{
					$new = $var['votes'] + 1;
					$this->engine->Query(
						"UPDATE {$this->engine->config['table_prefix']}polls ".
						"SET votes = '".quote($this->engine->dblink, $new)."' ".
						"WHERE poll_id = '".quote($this->engine->dblink, $id)."' ".
							"AND v_id = '".quote($this->engine->dblink, $vote_id)."'");
//					$total++;
				}
			}
		}
		$new = $header['votes'] + 1; //$total;
		$this->engine->Query(
			"UPDATE {$this->engine->config['table_prefix']}polls ".
			"SET votes = '".quote($this->engine->dblink, $new)."' ".
			"WHERE poll_id = '".quote($this->engine->dblink, $id)."' ".
				"AND v_id = '0'");

		return true;
	}
}

?>