<?php

if (!defined('IN_WACKO'))
{
	exit('No direct script access allowed');
}

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
	function __construct(&$engine)
	{
		$this->engine = & $engine;
	}

	// id number of the latest poll
	function get_last_poll_id()
	{
		$poll_id = $this->engine->load_single(
			'SELECT poll_id '.
			'FROM '.$this->engine->config['table_prefix'].'poll '.
			'ORDER BY poll_id DESC '.
			'LIMIT 1');

		if ($poll_id['poll_id'] == false)
		{
			return 0;
		}
		else
		{
			return $poll_id['poll_id'];
		}
	}

	// title information for a given poll
	function get_poll_title($poll_id)
	{
		$title = $this->engine->load_single(
			"SELECT p.poll_id, p.text, p.user_id, p.plural, p.votes, p.start, p.end, u.user_name ".
			"FROM {$this->engine->config['table_prefix']}poll p ".
				"LEFT JOIN {$this->engine->config['table_prefix']}user u ON (p.user_id = u.user_id) ".
			"WHERE p.poll_id = '".$poll_id."' AND p.v_id = 0");

		return $title;
	}

	// variants data for a given poll
	// sorts by total votes if "$votes = 1"
	function get_poll_vars($poll_id, $votes = 0)
	{
		$vars = $this->engine->load_all(
			"SELECT poll_id, v_id, text, votes ".
			"FROM {$this->engine->config['table_prefix']}poll ".
			"WHERE poll_id = '".$poll_id."' AND v_id <> 0 ".
			"ORDER BY ".($votes == 1 ? "votes DESC, " : "")."v_id ASC");

		return $vars;
	}

	// all years when new surveys was started
	function poll_years()
	{
		$years = '';

		$list = $this->engine->load_all(
			"SELECT YEAR(start) AS years ".
			"FROM {$this->engine->config['table_prefix']}poll ".
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
	function poll_time($start, $end)
	{
		if (is_string($start))	$start	= strtotime($start);
		if (is_string($end))	$end	= strtotime($end);

		return ceil((($end - $start) / 3600) / 24);
	}

	// various polls lists
	function get_polls_list($mode, $year = 0)
	{
		switch ($mode)
		{
			case 'active':
			case 'current':
				$list = $this->engine->load_all(
					"SELECT poll_id, text, p.user_id, plural, start, u.user_name ".
					"FROM {$this->engine->config['table_prefix']}poll p ".
						"LEFT OUTER JOIN ".$this->engine->config['table_prefix']."user u ON (p.user_id = u.user_id) ".
					"WHERE v_id = 0 AND start <> '".SQL_NULLDATE."' AND end = '".SQL_NULLDATE."' ".
					"ORDER BY start DESC");
				break;

			case 'mod':
			case 'moderation':
				$list = $this->engine->load_all(
					"SELECT poll_id, text, p.user_id, plural, u.user_name as user ".
					"FROM {$this->engine->config['table_prefix']}poll p ".
						"LEFT OUTER JOIN ".$this->engine->config['table_prefix']."user u ON (p.user_id = u.user_id) ".
					"WHERE v_id = 0 AND start = '".SQL_NULLDATE."' AND end = '".SQL_NULLDATE."' ".
					"ORDER BY poll_id ASC");
				break;

			case 'ended':
				$list = $this->engine->load_all(
					"SELECT poll_id, text, p.user_id, plural, start, end, u.user_name as user ".
					"FROM {$this->engine->config['table_prefix']}poll p ".
						"LEFT OUTER JOIN ".$this->engine->config['table_prefix']."user u ON (p.user_id = u.user_id) ".
					"WHERE v_id = 0 AND start <> '".SQL_NULLDATE."' AND end <> '".SQL_NULLDATE."' ".
					"ORDER BY end DESC");
				break;

			case 'archive':
				if ($year == 0) $year = date('Y');
				$list = $this->engine->load_all(
					"SELECT poll_id, text, p.user_id, plural, start, end, u.user_name as user ".
					"FROM {$this->engine->config['table_prefix']}poll p ".
						"LEFT OUTER JOIN ".$this->engine->config['table_prefix']."user u ON (p.user_id = u.user_id) ".
					"WHERE v_id = 0 AND start <> '".SQL_NULLDATE."' ".
						"AND end <> '".SQL_NULLDATE."' AND YEAR(start) = '".$year."' ".
					"ORDER BY end DESC");
				break;

			default:
			case 'all':
				$list = $this->engine->load_all(
					"SELECT poll_id, text, p.user_id, plural, start, end, u.user_name as user ".
					"FROM {$this->engine->config['table_prefix']}poll p ".
						"LEFT OUTER JOIN ".$this->engine->config['table_prefix']."user u ON (p.user_id = u.user_id) ".
					"WHERE v_id = 0 AND start <> '".SQL_NULLDATE."' ".
					"ORDER BY start DESC");
		}

		return $list;
	}

	// add a new poll into the database
	function submit_poll($poll_id, $topic, $plural, $answers, $user_id, $start = 0)
	{
		$topic		= quote($this->engine->dblink, $topic);
		$user_id	= (int)$user_id;

		if ($plural != 1) $plural = 0;

		// submitting title
		$this->engine->sql_query(
			"INSERT INTO {$this->engine->config['table_prefix']}poll SET ".
				"poll_id	= '".(int)$poll_id."', ".
				"text		= '".quote($this->engine->dblink, rtrim($topic, '.'))."', ".
				"user_id	= '".(int)$user_id."', ".
				"plural		= '".$plural."', ".
				"start		= ".($start == 1 ? "NOW()" : "'".SQL_NULLDATE."'"));

		// submitting variants
		foreach ($answers as $v_id => $v_text)
		{
			$v_id	+= 1;
			$v_text	= quote($this->engine->dblink, $v_text);
			$this->engine->sql_query(
				"INSERT INTO {$this->engine->config['table_prefix']}poll SET ".
					"poll_id	= '".(int)$poll_id."', ".
					"v_id		= '".(int)$v_id."', ".
					"text		= '".quote($this->engine->dblink, rtrim($v_text, '.'))."'");
		}

		return true;
	}

	// remove a given poll from the datebase
	function remove_poll($poll_id)
	{
		return $this->engine->sql_query(
			"DELETE FROM {$this->engine->config['table_prefix']}poll ".
			"WHERE poll_id = '".$poll_id."'");
	}

	// print voting form
	// tag parameter specifies wiki page
	// for form action url if necessary
	function show_poll_vote($poll_id, $tag = '')
	{
		if ($tag != '') $tag = str_replace('%2F', '/', rawurlencode($tag));

		// load poll data
		$header		= $this->get_poll_title($poll_id);
		$vars		= $this->get_poll_vars($poll_id);
		$duration	= $this->poll_time($header['start'], ($header['end'] == SQL_NULLDATE ? time() : $header['end']));
		$user		= ( strpos($header['user_id'], '.') ? '<em>'.$this->engine->get_translation('PollsGuest').'</em>' : $header['user_name'] );

		if ($header['start'] == SQL_NULLDATE)
		{	// non-existent or not moderated poll
			$poll	= '<table class="formation">'.
					'<tr><th>'.$this->engine->get_translation('PollsError').'</th></tr>'.
					'<tr><td align="center"><em>'.$this->engine->get_translation('PollsNotExists').'</em></td></tr>'.
					'</table>';
		}
		else
		{
			$poll	= $this->engine->form_open('', $tag, '', '', '', '#poll'.$poll_id.'_form').
					'<a name="p'.date('dm', strtotime($header['start'])).'"></a>'.
					'<a name="poll'.$poll_id.'_form"></a>'.
					'<input name="poll" type="hidden" value="'.$poll_id.'" />'.
					'<table class="formation">'."\n".
					'<tr><th colspan="2" style="text-align:left;">'.date('d/m', strtotime($header['start'])).' (#'.((int)$poll_id).'): '.$header['text'].'</th></tr>'."\n";

			foreach ($vars as $var)
			{
				$poll	.= '<tr class="lined"><td class="label">'.
							($header['plural'] == 1
								? '<input id="'.$var['v_id'].'" name="'.$var['v_id'].'" type="checkbox" value="1" />'
								: '<input id="'.$var['v_id'].'" name="id" type="radio" value="'.$var['v_id'].'" />').
							'</td>'.
						'<td style="width:95%;text-align:left;"><label for="'.$var['v_id'].'">'.$var['text'].'</label></td></tr>'."\n";
			}

			$poll	.= '<tr><td colspan="2"><small>'.$this->engine->get_translation('PollsLasts').': '.$duration.
						'<br />'.$this->engine->get_translation('PollsAdded').': '.( strpos($header['user_id'], '.') ? $user : '<a href="'.$this->engine->href('', $this->engine->config['users_page'], 'profile='.$user).'">'.$user.'</a>' ).'</small></td></tr>'.
					'<tr><td colspan="2" style="white-space:nowrap;">'.
					'<input name="vote" id="submit" type="submit" value="'.$this->engine->get_translation('PollsSubmit').'" /> '.
					'<input name="results" id="submit" type="submit" value="'.$this->engine->get_translation('PollsResults').'" />'.
					'</tr></td>'.
					'</table>'.
					$this->engine->form_close();
		}

		return $poll;
	}

	// print survey results
	function show_poll_results($poll_id)
	{
		$total = '';

		// load poll data
		$header		= $this->get_poll_title($poll_id);
		$vars		= $this->get_poll_vars($poll_id, 1);
		$duration	= $this->poll_time($header['start'], ($header['end'] == SQL_NULLDATE ? time() : $header['end']));
		$user		= ( strpos($header['user_id'], '.') ? '<em>'.$this->engine->get_translation('PollsGuest').'</em>' : $header['user_name'] );
		$voters		= $header['votes'];

		if ($header['plural'] != 1)		$total  = $header['votes'];
		else foreach ($vars as $var)	$total += $var['votes'];

		if ($header['start'] == SQL_NULLDATE)
		{	// non-existent or not moderated poll
			$poll	= '<table class="formation">'.
					'<tr><th>'.$this->engine->get_translation('PollsError').'</th></tr>'.
					'<tr><td align="center"><em>'.$this->engine->get_translation('PollsNotExists').'</em></td></tr>'.
					'</table>';
		}
		else
		{
			$poll	= $this->engine->form_open().
					'<a name="p'.date('dm', strtotime($header['start'])).'"></a>'.
					'<a name="poll'.$poll_id.'_form"></a>'.
					'<table class="formation">'.
					'<tr><th colspan="3" style="text-align:left;">'.date('d/m', strtotime($header['start'])).' (#'.((int)$poll_id).'): '.$header['text'].'</th></tr>';

			foreach ($vars as $var)
			{
				$percent = ($total == 0 ? 0 : round($var['votes'] / $total * 100, 1));
				$poll	.= '<tr class="lined"><td style="width:95%;text-align:left;">'.$var['text'].'</td>'.
						'<td>&nbsp;<strong>'.$var['votes'].'</strong>&nbsp;</td>'.
						'<td>&nbsp;<strong>'.$percent.'%</strong></td></tr>';
			}

			$poll	.= '<tr><td colspan="3"><small>'.$this->engine->get_translation('PollsTotalVotes').': '.$voters.
						'<br />'.($header['end'] != SQL_NULLDATE ? $this->engine->get_translation('PollsLasted') :
							$this->engine->get_translation('PollsLasts')).': '.$duration.
						'<br />'.$this->engine->get_translation('PollsAdded').': '.( strpos($header['user_name'], '.') ? $user : '<a href="'.$this->engine->href('', $this->engine->config['users_page'], 'profile='.$user).'">'.$user.'</a>' ).'</small></td></tr>'.
					'</table>'.
					$this->engine->form_close();
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
	function poll_is_voted($poll_id)
	{
		$cookie	= $this->engine->get_cookie('poll');
		$ids	= explode(';', $cookie);

		if (in_array($poll_id, $ids) === true || $poll_id == $cookie)
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	// set poll cookie
	function set_poll_cookie($poll_id)
	{
		if ($cookie = $this->engine->get_cookie('poll'))
		{
			$ids = explode(';', $cookie);
		}

		$ids[]	= $poll_id;
		$cookie	= implode(';', $ids);
		$this->engine->set_session_cookie('poll', $cookie);
		$this->engine->set_persistent_cookie('poll', $cookie, 365);
		return true;
	}

	// vote a given poll
	// if $ballot is an array it is
	// presumed that survey is plural
	function vote_poll($poll_id, $ballot)
	{
		$header	= $this->get_poll_title($poll_id);
		$vars	= $this->get_poll_vars($poll_id, 1);

		if (!is_array($ballot))
		{
			$ballot = array($ballot);
		}

		foreach ($vars as $var)
		{
			foreach ($ballot as $vote => $vote_id)
			{
				if ($var['v_id'] == $vote_id)
				{
					$new_votes = $var['votes'] + 1;
					$this->engine->sql_query(
						"UPDATE {$this->engine->config['table_prefix']}poll ".
						"SET votes = '".(int) $new_votes."' ".
						"WHERE poll_id = '".(int)$poll_id."' ".
							"AND v_id = '".(int)$vote_id."'");
//					$total++;
				}
			}
		}

		$new_votes = $header['votes'] + 1; //$total;

		$this->engine->sql_query(
			"UPDATE {$this->engine->config['table_prefix']}poll ".
			"SET votes = '".(int)$new_votes."' ".
			"WHERE poll_id = '".(int)$poll_id."' ".
				"AND v_id = '0'");

		return true;
	}
}

?>