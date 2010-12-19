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

		if ($name == '') $error = $this->get_translation('NewsNoName');
	}
	else
	{
		$error = $this->get_translation('NewsNoName');
	}

	// if errors were found - return, else continue
	if ($error)
	{
		$this->set_message('<div class="error">'.$error.'</div>');
		$this->redirect($this->href());
	}
	else
	{
		// building news template
		$template	= '===={{a name="'.date ('dm').'"}}""'.date ('d.m').' // '.$namehead.'""====

!!Delete this text and in its place enter your news.!!';

		// redirecting to the edit form
		$_SESSION['body']	= $template;
		$_SESSION['title']	= $namehead;
		$this->redirect($this->href('edit', $this->config['news_cluster'].'/'.date('Y/').date('F/').$name, '', 1));
	}
}
if (!empty($this->config['news_cluster']))
{
	echo $this->form_open();
?>
	<input type="hidden" name="action" value="newsadd" />
	<label for="newstitle"><?php echo $this->get_translation('NewsName'); ?>:</label>
	<input id="newstitle" name="title" size="50" maxlength="100" value="" />
	<input id="submit" type="submit" value="<?php echo $this->get_translation('NewsSubmit'); ?>" />

<?php echo $this->form_close();
}
else
{
	echo $this->get_translation('NewsNoClusterDefined');
}
?>
<!--/notypo-->