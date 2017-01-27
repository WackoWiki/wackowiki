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
	if ($this->has_access('read'))
	{
		echo '<ul class="menu">' .
				#'<li class="active">' . $this->_t('Attachments') . '</li>' .
				($can_upload
					? '<li><a href="' . $this->href('upload', '', '') . '">' . $this->_t('UploadFile') . '</a></li>'
					: '') .
			"</ul>\n";

		if (isset($_GET['files']) && $_GET['files'] == 'global')
		{
			echo '<h3>' . $this->_t('Attachments') . ' &raquo; ' . $this->_t('AttachmentsGlobal') . '</h3>';
			echo '<ul class="menu">' .
					'<li><a href="' . $this->href('attachments', '', '') . '">' . $this->_t('AttachmentsToPage') . '</a></li>' .
					'<li class="active">' . $this->_t('AttachmentsGlobal') . '</li>' .
					'<li><a href="' . $this->href('attachments', '', ['files=all']) . '">' . $this->_t('AttachmentsAll') . '</a></li>' .
				"</ul><br /><br />\n";

			echo $this->action('files', ['global' => 1, 'nomark' => 1, 'method' => 'attachments', 'params' => ['files' => 'global']]) . '<br />';
		}
		else if (isset($_GET['files']) && $_GET['files'] == 'all')
		{
			echo '<h3>' . $this->_t('Attachments') . ' &raquo; ' . $this->_t('AttachmentsAll') . '</h3>';
			echo '<ul class="menu">' .
					'<li><a href="' . $this->href('attachments', '', '') . '">' . $this->_t('AttachmentsToPage') . '</a></li>' .
					'<li><a href="' . $this->href('attachments', '', ['files=global']) . '">' . $this->_t('AttachmentsGlobal') . '</a></li>' .
					'<li class="active">' . $this->_t('AttachmentsAll') . '</li>' .
				"</ul><br /><br />\n";

			echo $this->action('files', ['all' => 1, 'nomark' => 1, 'method' => 'attachments', 'params' => ['files' => 'all']]) . '<br />';
		}
		else
		{
			echo '<h3>' . $this->_t('Attachments') . ' &raquo; ' . $this->_t('AttachmentsToPage') . '</h3>';
			echo '<ul class="menu">' .
					'<li class="active">' . $this->_t('AttachmentsToPage') . '</li>' .
					'<li><a href="' . $this->href('attachments', '', ['files=global']) . '">' . $this->_t('AttachmentsGlobal') . '</a></li>' .
					'<li><a href="' . $this->href('attachments', '', ['files=all']) . '">' . $this->_t('AttachmentsAll') . '</a></li>' .
				"</ul><br /><br />\n";

			echo $this->action('files', ['picture' => 1, 'nomark' => 1, 'method' => 'attachments']) . '<br />';
		}

		echo '<a href="' . $this->href() . '" style="text-decoration: none;"><input type="button" value="' . $this->_t('CancelDifferencesButton') . '" /></a>' . "\n";
	}

#}

