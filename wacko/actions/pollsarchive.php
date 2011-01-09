<?php

// Action parameters:
// nomark=[1,0]			Show legend and fieldset frame.
//						Default: 0
// style=["ul","br"]	List markup style.
//						Default: "ul"

// create polls object
$this->use_class('polls');
$polls_obj = new Polls($this);

// parameters
if (!isset($nomark))		$nomark	= 0;
if (!isset($style))			$style	= 'ul';
if (!isset($_GET['year']))	$year	= date('Y');
else						$year	= (int)$_GET['year'];

// print results
if (isset($_GET['poll']) && (isset($_GET['results']) && $_GET['results'] == 1))
{
	echo $polls_obj->show_poll_results((int)$_GET['poll']);
	echo '<br />';
}

// make list
if ($year != 0)	$list	= $polls_obj->get_polls_list('archive', $year);
else			$list	= $polls_obj->get_polls_list('all');
				$years	= $polls_obj->poll_years();


// print list
if(!$nomark)
{
	print("<div class=\"layout-box\"><p class=\"layout-box\"><span>".($year == 0 ? $this->get_translation('PollsArchiveAll') : str_replace('%1', $year, $this->get_translation('PollsArchiveYear')))."</span></p>\n");
}

	if ($list) // normal list
	{
		echo ($style == 'ul' ? '<ul>' : '');
		foreach ($list as $row)
		{
			if ($year != 0) $date = date('d/m', strtotime($row['start']));
			else			$date = date('d/m/y', strtotime($row['start']));
			echo ($style == 'ul' ? '<li>' : '');
			echo '<a href="'.
				$this->href('', '', 'year='.$year.'&amp;poll='.$row['id'].'&amp;results=1').'">'.
				$date.' (id'.$row['id'].'): '.$row['text'].'</a>';
			echo ($style == 'br' ? '<br />' : '');
			echo ($style == 'ul' ? '</li>' : '');
		}
		echo ($style == 'ul' ? '</ul>' : '');
	}
	else // empty list
	{
		echo '<em>'.$this->get_translation('PollsEmptyList').'</em><br />';
	}

	// pagination
	echo '<small><strong>'.$this->get_translation('PollsShow').':</strong> ';
	if ($year == 0) echo $this->get_translation('PollsAll').' ';
	else echo '<a href="'.$this->href('', '', 'year=0').'">'.$this->get_translation('PollsAll').'</a> ';
	foreach ($years as $item)
	{
		if ($item == $year) echo $item.' ';
		else echo '<a href="'.$this->href('', '', 'year='.$item).'">'.$item.'</a> ';
	}
	echo '</small>';

if(!$nomark)
{
	echo "</div>\n";
}

// destroy polls object
unset($polls_obj);

?>
