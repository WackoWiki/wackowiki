<?php

if ($this->HasAccess("comment"))
{
	// find number
	if ($latestComment = $this->LoadSingle("select tag, id from ".$this->config["table_prefix"]."pages where comment_on != '' order by id desc limit 1"))
	{
		preg_match("/^Comment([0-9]+)$/", $latestComment["tag"], $matches);
		$num = $matches[1] + 1;
	}
	else
	{
		$num = "1";
	}

	$body = str_replace("\r", "", $_POST["body"]);
	$body = trim($_POST["body"]);

	if (!$body)
	{
		$this->SetMessage($this->GetResourceValue("EmptyComment"));
	}
	else
	{
		// store new comment
		$this->SavePage("Comment".$num, $body, $this->tag);
	}

	// redirect to page
	$this->redirect($this->href());
}
else
{
	print("<div class=\"page\">".$this->GetResourceValue("CommentAccessDenied")."</div>\n");
}

?>