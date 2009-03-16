<div id="page">
<?php
if ($this->HasAccess("read"))
{
	if (!$this->page)
	{
		print(str_replace("%1",$this->href("edit"),$this->GetTranslation("DoesNotExists")));
	}
	else
	{
		// comment header?
		if ($this->page["comment_on"])
		{
			print("<div class=\"commentinfo\">".$this->GetTranslation("ThisIsCommentOn")." ".$this->ComposeLinkToPage($this->page["comment_on"], "", "", 0).", ".$this->GetTranslation("PostedBy")." ".$this->Format($this->page["user"])." ".$this->GetTranslation("At")." ".$this->page["time"]."</div>");
		}

		if ($this->page["latest"] == "N")
		{
			print("<div class=\"revisioninfo\">".
			str_replace("%1",$this->href(),
			str_replace("%2",$this->GetPageTag(),
			str_replace("%3",$this->page["time"],
			$this->GetTranslation("Revision")))).".</div>");
		}

		// display page
		$this->context[++$this->current_context] = $this->tag;
		$data = $this->Format($this->page["body"], "msword");
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
