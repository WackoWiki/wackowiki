<?php

$page_id = $this->GetPageId();
$user_id = $this->GetUserId();

if ($this->GetUser() && $this->page)
{
	if ($this->IsWatched($user_id, $page_id))
	{
		$this->ClearWatch($user_id, $page_id);
	}
	else
	{
		$this->SetWatch($user_id, $page_id);
	}
}

$this->Redirect($this->href());

?>