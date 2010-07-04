<!--notypo-->
<?php

if ((isset($_POST['action'])) && $_POST['action'] == 'newsadd')
{
	// checking user input
	if ($_POST['title'])
	{
		$name		= trim($_POST['title'], ". \t");
		$namehead	= $name;
		$name		= ucwords($name);
		$name		= preg_replace('/[^- \\w]/', '', $name);
		$name		= str_replace(array(' ', "\t"), '', $name);

		if ($name == '') $error = $this->GetTranslation('NewsNoName');
	}
	else
	{
		$error = $this->GetTranslation('NewsNoName');
	}

	// if errors were found - return, else continue
	if ($error)
	{
		$this->SetMessage('<div class="error">'.$error.'</div>');
		$this->Redirect($this->href());
	}
	else
	{
		// building news template
		$template	= '===={{a name="'.date ('dm').'"}}""'.date ('d.m').' // '.$namehead.'""====

!!Delete this text and in its place enter your news.!!';

		// redirecting to the edit form
		$_SESSION['body']	= $template;
		$_SESSION['title']	= $namehead;
		$this->Redirect($this->href('edit', $this->config["news_cluster"].'/'.date('Y/').date('F/').$name, '', 1));
	}
}
if (!empty($this->config["news_cluster"]))
{
	echo $this->FormOpen();
?>
	<input type="hidden" name="action" value="newsadd" />
	<label for="newstitle"><?php echo $this->GetTranslation("NewsName"); ?>:</label>
	<input id="newstitle" name="title" size="50" maxlength="100" value="" />
	<input id="submit" type="submit" value="<?php echo $this->GetTranslation("NewsSubmit"); ?>" />

<?php echo $this->FormClose(); 
}
else
{
	echo $this->GetTranslation("NewsNoClusterDefined");
}
?>
<!--/notypo-->
