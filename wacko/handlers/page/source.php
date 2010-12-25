<div id="page">
<?php

/*
	the source text will be shown with exception of those fragments which are hidden by formatters %%(comments)..%%

	TODO: add config option to set an treshhold or to disable the source handler
*/

// redirect to show method if page don't exists
if (!$this->page)
{
	$this->redirect($this->href('show'));
}

// deny for comment
if ($this->page['comment_on_id'])
{
	$this->redirect($this->href('', $this->page['tag']));
}

if ($this->has_access('read'))
{
	if (!$this->page)
	{
		echo str_replace('%1', $this->href('edit'), $this->get_translation('DoesNotExists'));
	}
	else
	{
		/* obsolete code - or do we need an ability to print old revisions?
		if ($this->page['latest'] == 0)
		{
			echo "<div class=\"revisioninfo\">".
			str_replace('%1', $this->href(),
			str_replace('%2', $this->tag,
			str_replace('%3', $this->page['modified'],
			$this->get_translation('Revision')))).".</div>";
		}*/

		// build html body
		$data = $this->page['body'];

		// display page
		$data = $this->format($data, 'source', array('bad' => 'good'));
		echo $data;
	}
}
else
{
	echo $this->get_translation('ReadAccessDenied');
}

?>
</div>