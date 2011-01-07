<?php

if (!isset($useemptystring)) $useemptystring = '';

$vars[0] = $this->unwrap_link($vars[0]);
$page_id = $this->get_page_id($vars[0]);

if (! $this->has_access('read', $page_id))
{
	echo $this->get_translation('NoAccessToSourcePage');
}
else
{
	if (isset($_GET['revision_id']))
	{
		$revision_id = $_GET['revision_id'];
	}
	else
	{
		$revision_id = '';
	}

	if (!$phrase_page = $this->load_page($vars[0], 0, $revision_id))
	{
		echo "<em> ".$this->get_translation('SourcePageDoesntExist')."(".$vars[0].")</em>";
	}
	else
	{
		$strings = preg_replace('/\{\{[^\}]+\}\}/', '', $phrase_page['body']);
		$strings = $this->format($strings);
		$splitexpr = '|<br />|';

		if ($useemptystring == 1)
		{
			$splitexpr = '|<br />[\n\r ]*<br />|';
		}

		$lines = preg_split($splitexpr, $strings);
		$lines = array_values(array_filter($lines, 'trim'));
		srand ((double) microtime() * 1000000);
		echo $lines[rand(0, count($lines) - 1)];
	};
}

?>