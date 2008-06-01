<?php
if ($user = $this->GetUser()) {
	if ($this->IsWatched($this->GetUserName(), $this->GetPageTag()))
	$this->ClearWatch($this->GetUserName(), $this->GetPageTag());
	else
	$this->SetWatch($this->GetUserName(), $this->GetPageTag());
}
header("Location: ".$this->Href() );
?>