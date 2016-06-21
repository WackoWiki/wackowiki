<?php

if (!defined('IN_WACKO'))
{
	exit;
}

if ($this->get_user_name())
{
	$output1 = #'<h3>'.$this->get_translation('UserPages')."</h3>".
				'<ul class="menu" id="list">'."\n";
	$output2 = '<li><a href="'.$this->href('', '', 'mode=mypages').'#list">'.$this->get_translation('ListMyPages')."</a></li>\n";
	$output3 = '<li><a href="'.$this->href('', '', 'mode=mychanges').'#list">'.$this->get_translation('ListMyChanges')."</a></li>\n";
	$output4 = '<li><a href="'.$this->href('', '', 'mode=mywatches').'#list">'.$this->get_translation('ListMyWatches')."</a></li>";
	$output5 = '<li><a href="'.$this->href('', '', 'mode=mychangeswatches').'#list">'.$this->get_translation('ListMyChangesWatches')."</a></li>\n";
	$output6 = "</ul>\n";

	if (isset($_GET['mode']) && $_GET['mode'] == 'mypages')
	{
		echo	$output1 .
				'<li class="active">'.$this->get_translation('ListMyPages')."</a></li>\n". #$output2 .
				$output3 .
				$output4 .
				$output5 .
				$output6;
		echo	'<h3>'.$this->get_translation('ListMyPages')."</h3>";
		echo	$this->action('mypages');
	}
	else if (isset($_GET['mode']) && $_GET['mode'] == 'mywatches')
	{
		echo	$output1 .
				$output2 .
				$output3 .
				'<li class="active">'.$this->get_translation('ListMyWatches')."</a></li>\n". #$output4 .
				$output5 .
				$output6;
		echo	'<h3>'.$this->get_translation('ListMyWatches')."</h3>";
		echo	$this->action('mywatches');
	}
	else if (!isset($_GET['mode']) || $_GET['mode'] == 'mychangeswatches')
	{
		echo	$output1 .
				$output2 .
				$output3 .
				$output4 .
				'<li class="active">'.$this->get_translation('ListMyChangesWatches')."</a></li>\n". #$output5 .
				$output6;
		echo	'<h3>'.$this->get_translation('ListMyChangesWatches')."</h3>";
		echo	$this->action('mychangeswatches');
	}
	else if (isset($_GET['mode']) && $_GET['mode'] == 'mychanges')
	{
		echo	$output1 .
				$output2 .
				'<li class="active">'.$this->get_translation('ListMyChanges')."</a></li>\n". #$output3 .
				$output4 .
				$output5 .
				$output6;
		echo	'<h3>'.$this->get_translation('ListMyChanges')."</h3>";
		echo	$this->action('mychanges');
	}
}
else
{
	echo $this->get_translation('NotLoggedInThusOwned');
}

?>