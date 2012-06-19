<?php

if (!defined('IN_WACKO'))
{
	exit;
}

if ($this->has_access('read'))
{
	// store files display in session
	if (!isset($_SESSION[$this->config['session_prefix'].'_'.'show_files'][$this->page['page_id']]))
	{
		$_SESSION[$this->config['session_prefix'].'_'.'show_files'][$this->page['page_id']] = ($this->user_wants_files() ? '1' : '0');
	}

	if(isset($_GET['show_files']))
	{
		switch($_GET['show_files'])
		{
			case '0':
				$_SESSION[$this->config['session_prefix'].'_'.'show_files'][$this->page['page_id']] = 0;
				break;
			case '1':
				$_SESSION[$this->config['session_prefix'].'_'.'show_files'][$this->page['page_id']] = 1;
				break;
		}
	}

	if ($user = $this->get_user())
	{
		$user_name = strtolower($this->get_user_name());
		$registered = true;
	}
	else
	{
		$user_name = GUEST;
	}

	// display files!
	if ($this->page && $_SESSION[$this->config['session_prefix'].'_'.'show_files'][$this->page['page_id']])
	{
		// display files header
		?>
	<div id="filesheader">
	<?php echo '<a href="'.$this->href('', '', 'show_files=0').'" title="'.$this->get_translation('HideFiles').'">'.$this->get_translation('Files_all').'</a>'; ?>
	</div>

		<?php
		echo '<div class="files">'."\n";
		echo $this->action('files', array('nomark' => 1));
		echo '</div>';

		// display form
		if (isset($registered)
			&&
				(
					($this->config['upload'] === true) || ($this->config['upload'] == 1) ||
					($this->check_acl($user_name, $this->config['upload']))
				)
			)
		{
			echo '<div class="filesform">'."\n";
			echo $this->action('upload', array('nomark' => 1));
			echo '</div>'."\n";
		}
	}
	else
	{
		if ($this->page['page_id'])
		{
			// load files for this page
			$files = $this->load_all(
				"SELECT upload_id ".
				"FROM ".$this->config['table_prefix']."upload ".
				"WHERE page_id = '". quote($this->dblink, $this->page['page_id']) ."'");
		}
		else
		{
			$files = array();
		}

		switch ($c = count($files))
		{
			case 0:
				if ($this->get_user() &&
					($this->config['upload'] === true) || ($this->config['upload'] == 1) ||
					($this->check_acl($user_name, $this->config['upload']))
				)
				{
					$show_files = $this->get_translation('Files_0');
				}
				break;
			case 1:
				$show_files = $this->get_translation('Files_1');
				break;
			default:
				$show_files = str_replace('%1', $c, $this->get_translation('Files_n'));
		}
		// show link to show files only if there is one or/and user has the right to add a new one
		if (!empty($show_files))
		{
			echo '<div id="filesheader">'."\n";
			echo '<a href="'.$this->href('', '', 'show_files=1#filesheader').'" title="'.$this->get_translation('ShowFiles').'">'.$show_files.'</a>';
			echo '</div>'."\n";
		}
		else
		{
			// TODO: add message if registered users can upload files on this page
			// e.g. 'Log in or create an account to attach files to this page.'
		}
	}
}

?>