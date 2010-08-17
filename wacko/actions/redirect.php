<?php

// {{Redirect to="!/NewPage" permanent="0 or 1"}}

if (isset($vars['page'])) $vars['to'] = $vars['page'];
$page = $this->UnwrapLink(isset($vars['to']) ? $vars['to'] : "");
$is_permanent = (isset($vars['permanent']) ? $vars['permanent'] : 0);

if ($page)
{
	if ($is_permanent)
	{
		header("HTTP/1.0 301 Moved Permanently");
	}

	if ($this->LoadPage($page, "", LOAD_CACHE, LOAD_META))
	{
		if ($user = $this->GetUser())
		{
			if ($user["dont_redirect"] == "1" || $_POST['redirect'] == "no")
			{
				print ("<br /><br /><br />".$this->GetTranslation("PageMoved")." ".$this->Link("/".$page)."<br /><br /><br />");
			}
			else
			$this->Redirect($this->href("", $page));
		}
		else
			$this->Redirect($this->href("", $page));
	}
	else
	{
		print ("<i>".$this->GetTranslation("WrongPage4Redirect")."</i>");
	};
};
?>