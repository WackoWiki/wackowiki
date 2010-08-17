<div id="page">
<?php

// redirect to show method if page don't exists
if (!$this->page) $this->Redirect($this->href("show"));

if ($this->HasAccess("read"))
{
	if (!$this->page)
	{
		print(str_replace("%1",$this->href("edit"),$this->GetTranslation("DoesNotExists")));
	}
	else
	{
		// comment header?
		if ($this->page['comment_on_id'])
		{
			print("<div class=\"commentinfo\">".$this->GetTranslation("ThisIsCommentOn")." ".$this->ComposeLinkToPage($this->GetCommentOnTag($this->page['comment_on_id']), "", "", 0).", ".$this->GetTranslation("PostedBy")." ".$this->Format($this->page['user_name'])." ".$this->GetTranslation("At")." ".$this->page['modified']."</div>");
		}

		if ($this->page['latest'] == "0")
		{
			print("<div class=\"revisioninfo\">".
			str_replace("%1",$this->href(),
			str_replace("%2",$this->tag,
			str_replace("%3",$this->page['modified'],
			$this->GetTranslation("Revision")))).".</div>");
		}

		// display page
		$this->context[++$this->current_context] = $this->tag;
		$data = $this->Format($this->page['body'], "msword");
		if ($this->tocAutoNumerate == 1) $data = $this->tocEnumerate($data,2); // TOC, Automatic numeration of headings
		print($data);
		$this->current_context--;

	}
}
else
{
	print($this->GetTranslation("ReadAccessDenied"));
}
?>
</div>
