<?php
if ($this->GetUser() && $this->page)
{
	if ($this->IsWatched($this->GetUserId(), $this->GetPageId()))
	{
		$this->ClearWatch($this->GetUserId(), $this->GetPageId());
	}
	else
	{
		$this->SetWatch($this->GetUserId(), $this->GetPageId());
	}
}
$this->Redirect($this->href());

?>