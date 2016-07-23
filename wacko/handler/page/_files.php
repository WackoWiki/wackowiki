<?php

if (!defined('IN_WACKO'))
{
	exit;
}

if ($this->has_access('read'))
{
	// "show files" status are stored in _SESSION
	$show_files = &$this->sess->show_files[$this->page['page_id']];
	if (!isset($show_files))
	{
		$show_files = !!$this->get_user_setting('show_files');
	}
	if (isset($_GET['show_files']))
	{
		$show_files = !!$_GET['show_files'];
	}

	if (($user_name = strtolower($this->get_user_name())))
	{
		$registered = true;
	}
	else
	{
		$user_name = GUEST;
	}

	// display files!
	if ($show_files)
	{
		// display files section
		echo '<section id="section-files">'."\n";

		// display files header
		?>
		<header id="header-files">
		<?php echo '<h1><a href="'.$this->href('', '', 'show_files=0').'" title="'.$this->_t('HideFiles').'">'.$this->_t('Files_all').'</a></h1>'; ?>
		</header>

		<?php
		echo '<div class="files">'."\n";
		echo $this->action('files', array('nomark' => 1));
		echo '</div>';

		// display form
		if (isset($registered)
			&& (   $this->config['upload'] === true
				|| $this->config['upload'] == 1
				|| $this->check_acl($user_name, $this->config['upload'])
				)
			)
		{
			echo '<div class="filesform">'."\n";
			echo $this->action('upload', array('nomark' => 1));
			echo '</div>'."\n";
		}

		echo "</section>\n";
	}
	else
	{
		// load files for this page
		$files = $this->db->load_single(
			"SELECT COUNT(upload_id) AS count ".
			"FROM ".$this->config['table_prefix']."upload ".
			"WHERE page_id = '". $this->page['page_id'] ."' ".
				"AND deleted <> '1' LIMIT 1");

		$have_files = '';
		switch ($c = $files['count'])
		{
			case 0:
				if ($this->get_user()
					&& (   $this->config['upload'] === true
						|| $this->config['upload'] == 1
						|| $this->check_acl($user_name, $this->config['upload'])
						)
				)
				{
					$have_files = $this->_t('Files_0');
				}
				break;
			case 1:
				$have_files = $this->_t('Files_1');
				break;
			default:
				$have_files = str_replace('%1', $c, $this->_t('Files_n'));
		}
		// show link to show files only if there is one or/and user has the right to add a new one
		if ($have_files)
		{
			// display files section
			echo '<section id="section-files">'."\n";
			echo '<header id="header-files">'."\n";
			echo '<h1><a href="'.$this->href('', '', 'show_files=1#header-files').'" title="'.$this->_t('ShowFiles').'">'.$have_files.'</a></h1>';
			echo '</header>'."\n";
			echo "</section>\n";
		}
		else
		{
			// TODO: add message if registered users can upload files on this page
			// e.g. 'Log in or create an account to attach files to this page.'
		}
	}
}

?>
