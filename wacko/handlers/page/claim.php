<?php

// only claim ownership if this page has no owner, and if user is logged in.
if ($this->page && !$this->page["owner_id"] && $this->GetUser() && !$this->page["comment_on_id"])
{
	$this->SetPageOwner($this->GetPageId(), $this->GetUserId());
	$this->SetMessage($this->GetTranslation("YouAreNowTheOwner"));
	// log event
	$this->Log(4, str_replace("%1", $this->tag." ".$this->page["title"], $this->GetTranslation("LogPageOwnershipClaimed")));
}

$this->Redirect($this->href());

?>