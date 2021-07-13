<?php

if (!defined('IN_WACKO'))
{
	exit;
}

if ($this->has_access('read'))
{
	// 'show files' status are stored in session
	$show_files		= &$this->sess->show_files[$this->page['page_id']];
	$show_files		??= !!$this->get_user_setting('show_files');

	if (isset($_GET['show_files']))
	{
		$show_files = !!$_GET['show_files'];
	}

	if (($user_name = mb_strtolower($this->get_user_name())))
	{
		$registered = true;
	}
	else
	{
		$user_name = GUEST;
	}

	$tpl->enter('fp_s_');

	// display files!
	if ($show_files)
	{
		// display files header
		$tpl->href		= $this->href('', '', ['show_files' => 0]);
		$tpl->title		= $this->_t('HideFiles');
		$tpl->text		= $this->_t('Files');

		$tpl->f_files	= $this->action('files', ['nomark' => 1]);

		// display form
		if (isset($registered)
			&& (   $this->db->upload === true
				|| $this->db->upload == 1
				|| $this->check_acl($user_name, $this->db->upload)
				)
			)
		{
			$tpl->u_upload = $this->action('upload', ['nomark' => 1]);
		}
	}
	else
	{
		$have_files = '';

		switch ($c = $this->page['files'])
		{
			case 0:
				if ($this->get_user()
					&& (   $this->db->upload === true
						|| $this->db->upload == 1
						|| $this->check_acl($user_name, $this->db->upload)
						)
				)
				{
					$have_files = $this->_t('Files0');
				}
				break;
			case 1:
				$have_files = $this->_t('Files1');
				break;
			default:
				$have_files = Ut::perc_replace($this->_t('FilesN'), $c);
		}

		// show link to show files only if there is one or/and user has the right to add a new one
		if ($have_files)
		{
			// display files section
			$tpl->href		= $this->href('', '', ['show_files' => 1, '#' => 'header-files']);
			$tpl->title		= $this->_t('ShowFiles');
			$tpl->text		= $have_files;
		}
		else
		{
			// TODO: add message if registered users can upload files on this page
			// e.g. 'Log in or create an account to attach files to this page.'
		}
	}

	$tpl->leave();
}

