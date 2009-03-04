<?php

// only claim ownership if this page has no owner, and if user is logged in.
if ($this->page && !$this->GetPageOwner() && $this->GetUser() && !$this->page["comment_on"])
{
	$this->SetPageOwner($this->GetPageTag(), $this->GetUserName());
	$this->SetMessage($this->GetTranslation("YouAreNowTheOwner"));
}

$this->Redirect($this->href());

?>