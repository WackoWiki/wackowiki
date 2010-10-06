<div id="page">
<?php

// redirect to show method if page don't exists
if (!$this->page) $this->redirect($this->href('show'));

if ($this->has_access('read'))
{
	if (!$this->page)
	{
		print(str_replace("%1",$this->href('edit'),$this->get_translation('DoesNotExists')));
	}
	else
	{
		// comment header?
		if ($this->page['comment_on_id'])
		{
			print("<div class=\"commentinfo\">".$this->get_translation('ThisIsCommentOn')." ".$this->compose_link_to_page($this->get_comment_on_tag($this->page['comment_on_id']), "", "", 0).", ".$this->get_translation('PostedBy')." ".$this->format($this->page['user_name'])." ".$this->get_translation('At')." ".$this->page['modified']."</div>");
		}

		if ($this->page['latest'] == "0")
		{
			print("<div class=\"revisioninfo\">".
			str_replace("%1",$this->href(),
			str_replace("%2",$this->tag,
			str_replace("%3",$this->page['modified'],
			$this->get_translation('Revision')))).".</div>");
		}

		// display page
		$this->context[++$this->current_context] = $this->tag;
		$data = $this->format($this->page['body'], "msword");
		if ($this->tocAutoNumerate == 1) $data = $this->tocEnumerate($data,2); // TOC, Automatic numeration of headings
		print($data);
		$this->current_context--;

	}
}
else
{
	print($this->get_translation('ReadAccessDenied'));
}
?>
</div>
