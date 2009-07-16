<?php

$page = $this->UnwrapLink($page);

if ($_SESSION[$this->config["session_prefix"].'_'."linktracking"] && $track)
	$this->TrackLinkTo($page);

if (in_array($page, $this->context)) return;

if ($page == $this->tag) return;

if (! $this->HasAccess("read", $page))
{
	if ($nowarning != 1) echo $this->GetTranslation("NoAccessToSourcePage");
}
else
{
	if (!$inc_page = $this->LoadPage($page, $_GET["time"]))
	{
		echo "<em> ".$this->GetTranslation("SourcePageDoesntExist")."(".$this->Link("/".$page).")</em>";
	}
	else
	{
		if ($inc_page["body_r"])
		{
			$strings = $inc_page["body_r"];
		}
		else
		{
			// recompile body
			// build html body
			$strings = $this->Format($inc_page["body"], "wacko");
		}

		// cleaning up
		$strings = preg_replace("/<!--action:begin-->toc<!--action:end-->/i", "", $strings);
		$strings = preg_replace("/<!--action:begin-->tableofcontents<!--action:end-->/i", "", $strings);
		$strings = preg_replace("/<!--action:begin-->p<!--action:end-->/i", "", $strings);
		$strings = preg_replace("/<!--action:begin-->showparagraphs<!--action:end-->/i", "", $strings);
		$strings = preg_replace("/<!--action:begin-->redirect<!--action:end-->/i", "", $strings);
		$strings = preg_replace("/.*<!--action:begin-->a name=\"?$first_anchor\"?<!--action:end-->(.*)<!--action:begin-->a name=\"?$last_anchor\"?<!--action:end-->.*$/is", "\$1", $strings);

		// header
		if (($this->GetMethod() != "print") && ($nomark != 1) && ($nomark != 2 || $this->HasAccess("write", $page)))
		{
			echo "<div class=\"include\">"."<div class=\"name\">".$this->Link("/".$inc_page['tag'])."&nbsp;&nbsp;::&nbsp;".
				"<a href=\"".$this->Href("edit", $inc_page['tag'])."\">".$this->GetTranslation("EditIcon")."</a></div>";
		}

		// body
		$this->StopLinkTracking();
		$this->context[++$this->current_context] = $inc_page['tag'];
		echo $this->Format($strings, "post_wacko");
		$this->context[$this->current_context] = "~~"; // clean stack
		$this->current_context--;
		$this->StartLinkTracking();

		// footer
		if (($this->GetMethod() != "print") && ($nomark !=1 ) && ($nomark != 2 || $this->HasAccess("write", $page)))
		{
			echo "<div class=\"name\">".$this->Link("/".$inc_page['tag'])."&nbsp;&nbsp;::&nbsp;".
                          "<a href=\"".$this->Href("edit", $inc_page['tag'])."\">".$this->GetTranslation("EditIcon")."</a></div></div>";
		}
	}
}

?>