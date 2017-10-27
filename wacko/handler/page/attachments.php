<?php

if (!defined('IN_WACKO'))
{
	exit;
}

$is_global		= '';
$is_image		= '';
$message		= '';
$error			= '';
$can_upload		= $this->can_upload();

$this->ensure_page(true); // TODO: upload for forums?

// check who u are, can u upload?
#if ($this->can_upload())
#{

	// show attachments for current page
	if ($this->has_access('read')
			&& ((	$this->db->attachments_handler == 2 && $this->get_user())
				||	$this->db->attachments_handler == 1)
	)
	{
		echo '<ul class="menu">' .
				#'<li class="active">' . $this->_t('File') . '</li>' .
				($can_upload
					? '<li><a href="' . $this->href('upload', '', '') . '">' . $this->_t('UploadFile') . '</a></li>'
					: '') .
			"</ul>\n";

		// tab navigation
		$mod_selector	= 'files';
		$tabs	= [
					''			=> 'AttachmentsToPage',
					'global'	=> 'AttachmentsGlobal',
					'all'		=> 'AttachmentsAll',
				];
		$mode	= @$_GET[$mod_selector];

		if (!array_key_exists($mode, $tabs))
		{
			$mode = '';
		}

		// print tabs
		echo '<h3>' . $this->_t('Attachments') . ' &raquo; ' . $this->_t($tabs[$mode]) . '</h3>';
		echo $this->tab_menu($tabs, $mode, 'attachments', [], $mod_selector);
		echo "<br><br>\n";

		if ($mode == 'global')
		{
			echo $this->action('files', ['global' => 1, 'picture' => 1, 'nomark' => 1, 'method' => 'attachments', 'params' => ['files' => 'global']]) . '<br>';
		}
		else if ($mode == 'all')
		{
			echo $this->action('files', ['all' => 1, 'nomark' => 1, 'method' => 'attachments', 'params' => ['files' => 'all']]) . '<br>';
		}
		else
		{
			echo $this->action('files', ['picture' => 1, 'nomark' => 1, 'method' => 'attachments']) . '<br>';
		}

		echo '<a href="' . $this->href() . '" class="btn_link"><input type="button" value="' . $this->_t('CancelDifferencesButton') . '"></a>' . "\n";
	}

#}

