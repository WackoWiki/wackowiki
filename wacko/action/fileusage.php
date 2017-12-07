<?php

if (!defined('IN_WACKO'))
{
	exit;
}

if (!isset($file_id))	$file_id = null;
if (!isset($nomark))	$nomark = 0;
if (!isset($title))		$title = '';

if ($file_id)
{
	if ($pages = $this->load_file_usage($file_id))
	{
		foreach ($pages as $page)
		{
			$this->cache_page($page, true);
			$page_ids[] = (int) $page['page_id'];
			// cache page_id for for has_access validation in link function
			$this->page_id_cache[$page['tag']] = $page['page_id'];
		}

		// cache acls
		$this->preload_acl($page_ids);

		if (!$nomark)
		{
			echo '<div class="layout-box"><p><span>' . $this->_t('FileUsage') . ': '.'' . "</span></p>\n";
		}

		echo "<ol>\n";

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
						echo '<li>' . $_link . "</li>\n";
					}
				}
			}
		}

	echo "</ol>\n";

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
