<?php

if (!defined('IN_WACKO'))
{
	exit;
}

// Action parameters:
// nomark=[1|0]			Show legend and fieldset frame.
//						Default: 0
// style=['ul','br']	List markup style.
//						Default: 'ul'

// create polls object
$polls_obj = new Polls($this);

// parameters
if (!isset($nomark))		$nomark	= 0;
if (!isset($style))			$style	= 'ul';
if (!isset($_GET['year']))	$year	= date('Y');
else						$year	= (int) $_GET['year'];

// print results
if (isset($_GET['poll_id']) && (isset($_GET['results']) && $_GET['results'] == 1))
{
	echo $polls_obj->show_poll_results((int) $_GET['poll_id']);
	echo '<br>';
}

// make list
if ($year != 0)
{
	$list	= $polls_obj->get_polls_list('archive', $year);
}
else
{
	$list	= $polls_obj->get_polls_list('all');
}

$years	= $polls_obj->poll_years();


// print list
if (!$nomark)
{
	echo '<div class="layout-box"><p><span>' .
			($year == 0
				? $this->_t('PollsArchiveAll')
				: Ut::perc_replace($this->_t('PollsArchiveYear'), $year)
			) . "</span></p>\n";
}

	if ($list) // normal list
	{
		echo ($style == 'ul' ? '<ul>' : '');

		foreach ($list as $row)
		{
			if ($year != 0)
			{
				$date = date('d/m', strtotime($row['start']));
			}
			else
			{
				$date = $this->get_time_formatted($row['start']);
			}

			echo ($style == 'ul' ? '<li>' : '');
			echo '<a href="' .
				$this->href('', '', ['year' => $year, 'poll_id' => $row['poll_id'], 'results' => 1, '#' => 'poll-results' . $row['poll_id'] . '_form']) . '">' .
				$date . ' (#' . $row['poll_id'] . '): ' . $row['text'] . '</a>';
			echo ($style == 'br' ? '<br>' : '');
			echo ($style == 'ul' ? '</li>' : '');
		}

		echo ($style == 'ul' ? '</ul>' : '');
	}
	else // empty list
	{
		echo '<em>' . $this->_t('PollsEmptyList') . '</em><br>';
	}

	// pagination
	echo '<br><small><strong>' . $this->_t('PollsShow') . ':</strong> ';

	if ($year == 0)
	{
		echo $this->_t('PollsAll') . ' ';
	}
	else
	{
		echo '<a href="' . $this->href('', '', ['year' => 0]) . '">' . $this->_t('PollsAll') . '</a> ';
	}

	foreach ($years as $item)
	{
		if ($item == $year)
		{
			echo $item . ' ';
		}
		else
		{
			echo '<a href="' . $this->href('', '', ['year' => $item]) . '">' . $item . '</a> ';
		}
	}

	echo '</small>';

if (!$nomark)
{
	echo "</div>\n";
}

// destroy polls object
unset($polls_obj);

