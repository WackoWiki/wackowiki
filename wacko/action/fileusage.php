<?php

if (!defined('IN_WACKO'))
{
	exit;
}

if (!isset($file_id))	$file_id = '';
if (!isset($nomark))	$nomark = '';
if (!isset($title))		$title = '';

if ($file_id)
{
	if ($pages = $this->load_file_usage($file_id))
	{
		if (!$nomark)
		{
			echo '<div class="layout-box"><p><span>' . $this->_t('FileUsage') . ': '.'' . "</span></p>\n";
		}

		foreach ($pages as $page)
		{
			if ($page['tag'])
			{
				if ($this->db->hide_locked)
				{
					$access = $this->has_access('read', $page['page_id']);
				}
				else
				{
					$access = true;
				}

				if ($access)
				{
					if ($title == 1)
					{
						$_link = $this->link('/' . $page['tag'], '', $page['title']);
					}
					else
					{
						$_link = $this->link('/' . $page['tag'], '', $page['tag'], $page['title']);
					}

					if (strpos($_link, 'span class="missingpage"') === false)
					{
						echo ($_link . "<br>\n");
					}
				}
			}
		}

		if (!$nomark)
		{
			echo "</div>\n";
		}
	}
	else
	{
		echo $this->_t('NoFileUsage');
	}
}
?>