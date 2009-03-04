<?php

// {{Redirect to="!/NewPage" $permanent="[true]"}}

$page = $this->UnwrapLink($vars[0]);
if ($page) 
{
	if ($this->LoadPage($page, "", LOAD_CACHE, LOAD_META)) 
	{
		$user = $this->GetUser();
		if ($user["options"]["dont_redirect"] == "Y" || $_REQUEST["redirect"] == "no")
		{
			print ("<br /><br /><br /><center>".$this->GetTranslation("PageMoved")." ".$this->Link("/".$page)."</center><br /><br /><br />");
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