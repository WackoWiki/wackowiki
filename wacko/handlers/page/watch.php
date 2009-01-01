<?php
if ($this->GetUser() && $this->page)
{
	if ($this->IsWatched($this->GetUserName(), $this->tag))
	{
		$this->ClearWatch($this->GetUserName(), $this->tag);
	}
	else
	{
		$this->SetWatch($this->GetUserName(), $this->tag);
	}
}
$this->Redirect($this->href());

?>