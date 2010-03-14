<?php

// create polls object
$this->UseClass("polls", "classes/");
$pollsObj = new Polls($this);

// polls for moderation
echo '<table cellspacing="3" class="formation">';
$list = $pollsObj->GetPollsList('moderation');
if (empty($list))
{
	echo '<tr><th>'.$this->GetTranslation('PollsModeration').'</th></tr>';
	echo '<tr><td align="center"><em>'.$this->GetTranslation('PollsEmptyList').'</em></td></tr>';
}
else
{
	echo '<tr><th colspan="3">'.$this->GetTranslation('PollsModeration').'</th></tr>';
	foreach ($list as $row)
	{
		$user = ( strpos($row['user'], '.') ? '<em>'.$this->GetTranslation('PollsGuest').'</em>' : '<a href="'.$this->href('', $this->config['users_page'], 'profile='.$row['user']).'">'.$row['user'].'</a>' );
		echo '<tr>';
			echo '<td class="label"></td>';
			echo '<td style="text-align:left;width:80%;">'.$row['text'].'</td>';
			echo '<td valign="top">'.$user.'</td>';
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
				($row['plural'] == 1 ? $this->GetTranslation('PollsPlural') : $this->GetTranslation('PollsSingular')).'</td>';
		echo '</tr>';
	}
}
echo '</table>';

// destroy polls object
unset($pollsObj);

?>
