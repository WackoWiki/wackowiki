<?php

// Action parameters:
// nomark=[1,0]			Show legend and fieldset frame.
//						Default: 0
// style=["ul","br"]	List markup style.
//						Default: "ul"

// create polls object
$this->UseClass('polls');
$pollsObj = new Polls($this);

// parameters
if (!isset($nomark))		$nomark	= 0;
if (!isset($style))			$style	= 'ul';
if (!isset($_GET['year']))	$year	= date('Y');
else						$year	= (int)$_GET['year'];

// print results
if (isset($_GET['poll']) && (isset($_GET['results']) && $_GET['results'] == 1))
{
	echo $pollsObj->ShowPollResults((int)$_GET['poll']);
	echo '<br />';
}

// make list
if ($year != 0)	$list	= $pollsObj->GetPollsList('archive', $year);
else			$list	= $pollsObj->GetPollsList('all');
				$years	= $pollsObj->PollYears();


// print list
if(!$nomark)
{
	print("<div class=\"layout-box\"><p class=\"layout-box\"><span>".($year == 0 ? $this->GetTranslation('PollsArchiveAll') : str_replace('%1', $year, $this->GetTranslation('PollsArchiveYear')))."</span></p>\n");
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
		echo '<em>'.$this->GetTranslation('PollsEmptyList').'</em><br />';
	}

	// pagination
	echo '<small><strong>'.$this->GetTranslation('PollsShow').':</strong> ';
	if ($year == 0) echo $this->GetTranslation('PollsAll').' ';
	else echo '<a href="'.$this->href('', '', 'year=0').'">'.$this->GetTranslation('PollsAll').'</a> ';
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
unset($pollsObj);

?>
