<div id="page" class="page">
<h3><?php echo $this->GetTranslation("CreateNewPage") ?></h3>
<br />
<?php

// process input
if ($newtag = trim($_POST['tag'], '/ '))
{
	switch ((int)$_POST['option'])
	{
		case 1:
			$prefix = $this->tag.'/';
			break;
		case 2:
			$prefix = substr($this->tag, 0, strrpos($this->tag, '/') + 1);
			break;
		default:
			$prefix = '';
	}
	
	// check target page existance
	if ($page = $this->LoadPage($prefix.$newtag, '', LOAD_CACHE, LOAD_META))
	{
		$message = $this->GetTranslation("PageAlreadyExists")." &laquo;".$page['tag']."&raquo;. ";
		
		// check existing page write access
		if ($this->HasAccess('write', $prefix.$newtag))
		{
			$message .= $this->GetTranslation("PageAlreadyExistsEdit")." <a href=\"".$this->href('edit', $prefix.$newtag)."\">".$this->GetTranslation("PageAlreadyExistsEdit2")." </a>?";
		}
		else
		{
			$message .= $this->GetTranslation("PageAlreadyExistsEditDenied");
		}
		$this->SetMessage($message);
	}
	else
	{
		// check new page write access
		if ($this->HasAccess('write', $prefix.$newtag))
		{
			$this->Redirect($this->href('edit', $prefix.$newtag, '', 1));
		}
		else
		{
			$this->SetMessage($this->GetTranslation("CreatePageDeniedAddress"));
		}
	}
}

// show form

// create a peer page
echo $this->FormOpen('new');
echo "<input type=\"hidden\" name=\"option\" value=\"1\" />";
echo "<label>".$this->GetTranslation("CreateSubPage").":</label><br />";
if ($this->HasAccess('write', $this->tag))
{
	echo "<tt>".( strlen($this->tag) > 50 ? "...".substr($this->tag, -50) : $this->tag )."/</tt>".
		"<input name=\"tag\" value=\"".( $_POST['option'] === '1' ? htmlspecialchars($newtag) : "" )."\" size=\"20\" maxlength=\"255\" /> ".
		"<input id=\"submit\" type=\"submit\" value=\"".$this->GetTranslation("CreatePageButton")."\" />";
}
else
{
	echo "<em>".$this->GetTranslation("CreatePageDenied")."</em>";
}
echo "";
echo $this->FormClose();
echo "<br />";

// create a child page. only inside a cluster
if (substr_count($this->tag, '/') > 0)
{
	$parent = substr($this->tag, 0, strrpos($this->tag, '/'));
	
	echo $this->FormOpen('new');
	echo "<input type=\"hidden\" name=\"option\" value=\"2\" />";
	echo "<label>".$this->GetTranslation("CreatePageParentCluster").":</label><br />";
	if ($this->HasAccess('write', $parent))
	{
		echo "<tt>".( strlen($parent) > 50 ? "...".substr($parent, -50) : $parent )."/</tt>".
			"<input name=\"tag\" value=\"".( $_POST['option'] === '2' ? htmlspecialchars($newtag) : "" )."\" size=\"20\" maxlength=\"255\" /> ".
			"<input id=\"submit\" type=\"submit\" value=\"".$this->GetTranslation("CreatePageButton")."\" />";
	}
	else
	{
		echo "<em>".$this->GetTranslation("CreatePageDenied")."</em>";
	}
	echo "";
	echo $this->FormClose();
	echo "<br />";
}

// 
echo $this->FormOpen('new');
echo "<input type=\"hidden\" name=\"option\" value=\"3\" />";
echo "<label>".$this->GetTranslation("CreateRandomPage").":</label><br />";
echo "<input name=\"tag\" value=\"".( $_POST['option'] === '3' ? htmlspecialchars($newtag) : "" )."\" size=\"60\" maxlength=\"255\" /> ".
	"<input id=\"submit\" type=\"submit\" value=\"".$this->GetTranslation("CreatePageButton")."\" />";
echo "";
echo $this->FormClose();

?>
</div>