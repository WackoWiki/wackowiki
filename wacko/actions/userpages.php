<?php

if ($this->get_user_name())
{
	echo "<ul>";
	echo "<li><a href=\"".$this->href('', '', 'mode=mypages')."#list\">".$this->get_translation('ListMyPages')."</a></li>";
	echo "<li><a href=\"".$this->href('', '', 'mode=mychanges')."#list\">".$this->get_translation('ListMyChanges')."</a></li>";
	echo "<li><a href=\"".$this->href('', '', 'mode=mywatches')."#list\">".$this->get_translation('ListMyWatches')."</a></li>";
	echo "<li><a href=\"".$this->href('', '', 'mode=mychangeswatches')."#list\">".$this->get_translation('ListMyChangesWatches')."</a></li>";
	echo "</ul>";

	if (isset($_GET['mode']) && $_GET['mode'] == 'mypages')
	{
		echo "<a name=\"list\"></a><h3>".$this->get_translation('ListMyPages')."</h3>";
		echo $this->action('mypages');
	}
	else if (isset($_GET['mode']) && $_GET['mode'] == 'mywatches')
	{
		echo "<a name=\"list\"></a><h3>".$this->get_translation('ListMyWatches')."</h3>";
		echo $this->action('mywatches');
	}
	else if (!isset($_GET['mode']) || $_GET['mode'] == 'mychangeswatches')
	{
		echo "<a name=\"list\"></a><h3>".$this->get_translation('ListMyChangesWatches')."</h3>";
		echo $this->action('mychangeswatches');
	}
	else if (isset($_GET['mode']) && $_GET['mode'] == 'mychanges')
	{
		echo "<a name=\"list\"></a><h3>".$this->get_translation('ListMyChanges')."</h3>";
		echo $this->action('mychanges');
	}
}
else
	echo $this->get_translation('NotLoggedInThusOwned');

?>