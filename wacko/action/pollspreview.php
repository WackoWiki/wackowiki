<?php

if (!defined('IN_WACKO'))
{
	exit;
}

// create polls object
$polls_obj = new Polls($this);

// polls for moderation
echo '<table class="formation">';
$list = $polls_obj->get_polls_list('moderation');

if (empty($list))
{
	echo '<tr><th>' . $this->_t('PollsModeration') . '</th></tr>';
	echo '<tr><td class="t-center"><em>' . $this->_t('PollsEmptyList') . '</em></td></tr>';
}
else
{
	echo '<tr><th colspan="3">' . $this->_t('PollsModeration') . '</th></tr>';

	foreach ($list as $row)
	{
		$user = (mb_strpos($row['user_name'], '.') ? '<em>' . $this->_t('Guest') . '</em>' : '<a href="' . $this->href('', $this->db->users_page, ['profile' => $row['user_name']]) . '">' . $row['user_name'] . '</a>');
		echo '<tr>';
			echo '<td class="label"></td>';
			echo '<td style="width:80%;">' . $row['text'] . '</td>';
			echo '<td>' . $user . '</td>';
		echo '</tr>';
		echo '<tr>';
			$vars	= $polls_obj->get_poll_vars($row['poll_id']);
			echo '<td></td>';
			echo '<td><table>';

			foreach ($vars as $var)
			{
				echo '<tr class="lined"><td>' . $var['text'] . '</td></tr>';
			}

			echo '</table></td>';
			echo '<td class="a-top">' .
				($row['plural'] == 1 ? $this->_t('PollsPlural') : $this->_t('PollsSingular')) . '</td>';
		echo '</tr>';
	}
}
echo '</table>';

// destroy polls object
unset($polls_obj);
