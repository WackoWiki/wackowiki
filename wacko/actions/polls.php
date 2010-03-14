<?php

// Action parameters:
// id=[id]			Only show given survey voting form.
//					Default: null
// results=[1,0]	Return poll results instead of voting form.
//					Default: 0
// align=["h","v"]	Orientation of surveys table: horizontal
//					or vertical.
//					Default: "h"

// create polls object
$this->UseClass("polls", "classes/");
$pollsObj = new Polls($this);

// processing input
if ($_POST['vote'] && $_POST['poll'])
{
	$header	= $pollsObj->GetPollTitle((int)$_POST['poll']);

	if ($header['start'] != SQL_NULLDATE && $header['end'] == SQL_NULLDATE && !$pollsObj->PollIsVoted($header['poll_id']))
	{
		if ($header['plural'] == 1)
		{
			// making plural ballot
			foreach ($_POST as $key => $value)
			{
				if (preg_match('/^[0-9]{1,2}$/', $key) && $value === '1') $ballot[] = (int)$key;
			}
		}
		else
		{
			// making singular ballot
			$ballot = (int)$_POST['id'];
		}

		// checking ballot: we need at least one vote
		if ($ballot && count($ballot) > 0)
		{
			// putting ballot into the ballot-box
			$pollsObj->VotePoll($header['poll_id'], $ballot);
			$pollsObj->SetPollCookie($header['poll_id']);
			$vote = $header['poll_id'];

			// update cache
			$this->SetMessage($this->GetTranslation('PollsDone'));
			$this->cache->CacheInvalidate($this->supertag);
		}
	}
	else if ($pollsObj->PollIsVoted($header['poll_id']))
	{
		$vote = $header['poll_id'];
		$this->SetMessage($this->GetTranslation('PollsAlreadyVoted'));
		$this->cache->CacheInvalidate($this->supertag);
	}
	else if ($header['start'] != SQL_NULLDATE && $header['end'] != SQL_NULLDATE)
	{
		$vote = $header['poll_id'];
		$this->SetMessage($this->GetTranslation('PollsAlreadyEnded'));
		$this->cache->CacheInvalidate($this->supertag);
	}
	else
	{
		$vote = $header['poll_id'];
	}
}
else if ($_POST['results'] && $_POST['poll'])
{
	$vote = (int)$_POST['poll'];
}

// print survey forms/results
if (isset($id))
{
	$header	= $pollsObj->GetPollTitle($id);

	if ($results == 1 || $pollsObj->PollIsVoted($id) || $header['end'] != SQL_NULLDATE)
	{
		echo $pollsObj->ShowPollResults($id);
	}
	else
	{
		echo $pollsObj->ShowPollVote($id);
	}
}
else
{
	if ($align != 'v') $align = 'h';

	if ($polls = $pollsObj->GetPollsList('active'))
	{
		echo '<table border="0" cellpadding="0" cellspacing="0">';
		echo ($align == 'h' ? '<tr>' : '');
		foreach ($polls as $poll)
		{
			echo ($align == 'v' ? '<tr>' : '').'<td valign="top">';
			if ($results == 1 || $vote == $poll['poll_id'] || $pollsObj->PollIsVoted($poll['poll_id']))
			{
				echo $pollsObj->ShowPollResults($poll['poll_id']);
			}
			else
			{
				echo $pollsObj->ShowPollVote($poll['poll_id']);
			}
			echo '</td>'.($align == 'v' ? '</tr>' : '');
		}
		echo ($align == 'h' ? '</tr>' : '');
		echo '</table>';
	}
	else
	{
		echo '<table cellspacing="3" class="formation"><tr><td align="center"><em>';
		echo $this->GetTranslation('PollsNone');
		echo '</em></td></tr></table>';
	}
}

// destroy polls object
unset($pollsObj);

?>
