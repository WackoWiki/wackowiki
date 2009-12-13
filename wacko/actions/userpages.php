<?php

if ($this->GetUserName())
{
	echo "<ul>";
	echo "<li><a href=\"".$this->href("", "", "mode=mypages")."#list\">".$this->GetTranslation("ListMyPages")."</a></li>";
	echo "<li><a href=\"".$this->href("", "", "mode=mychanges")."#list\">".$this->GetTranslation("ListMyChanges")."</a></li>";
	echo "<li><a href=\"".$this->href("", "", "mode=mywatches")."#list\">".$this->GetTranslation("ListMyWatches")."</a></li>";
	echo "<li><a href=\"".$this->href("", "", "mode=mychangeswatches")."#list\">".$this->GetTranslation("ListMyChangesWatches")."</a></li>";
	echo "</ul>";
	
	if ($_GET["mode"] == "mypages")
	{
		echo "<a name=\"list\"></a><h3>".$this->GetTranslation("ListMyPages")."</h3>";
		echo $this->Action("mypages");
	}
	else if ($_GET["mode"] == "mywatches")
	{
		echo "<a name=\"list\"></a><h3>".$this->GetTranslation("ListMyWatches")."</h3>";
		echo $this->Action("mywatches");
	}
	else if (!isset($_GET["mode"]) || $_GET["mode"] == "mychangeswatches")
	{
		echo "<a name=\"list\"></a><h3>".$this->GetTranslation("ListMyChangesWatches")."</h3>";
		echo $this->Action("mychangeswatches");
	}
	else if ($_GET["mode"] == "mychanges")
	{
		echo "<a name=\"list\"></a><h3>".$this->GetTranslation("ListMyChanges")."</h3>";
		echo $this->Action("mychanges");
	}
}
else
	echo $this->GetTranslation("NotLoggedInThusOwned");

?>