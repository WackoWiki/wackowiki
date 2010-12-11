<?php

if (!isset($page))		$page = '';
if (!isset($nomark))	$nomark = '';
if (!isset($title))		$title = '';

if ($page)
{
	$tag = $this->unwrap_link($page);
}
else
{
	$tag = $this->tag;
}

if ($pages = $this->load_pages_linking_to($tag))
{
	if(!$nomark)
	{
		echo "<div class=\"layout-box\"><p class=\"layout-box\"><span>".$this->get_translation('ReferringPages').":</span></p>\n";
	}

	foreach ($pages as $page)
	{
		if ($page['tag'])
		{
			if ($this->config['hide_locked'])
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
					$_link = $this->link('/'.$page['tag']."#".$this->npj_translit($tag), '', $page['title']);
				}
				else
				{
					$_link = $this->link('/'.$page['tag']."#".$this->npj_translit($tag), '', $page['tag']);
				}

				if (strpos($_link, 'span class="missingpage"') === false)
				{
					echo ($_link."<br />\n");
				}
			}
		}
	}

	if(!$nomark)
	{
		echo "</div>\n";
	}
}
else
{
	echo $this->get_translation('NoReferringPages');
}
?>