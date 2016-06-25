<?php

if (!defined('IN_WACKO'))
{
	exit;
}

// show deleted pages and comments
if ($this->is_admin())
{
	if (!isset($max) || $max > 1000) $max = 1000;

	list($pages, $pagination) = $this->load_deleted((int)$max, false);

	if ($pages)
	{
		$this->print_pagination($pagination);

		$curday = '';

		echo '<ul class="ul_list">'."\n";

		foreach ($pages as $page)
		{
			if (!$this->config['hide_locked'] || $this->has_access('read', $page['page_id']))
			{
				// tz offset
				$time	= $this->get_time_tz(strtotime($page['modified']));
				$day	= date($this->config['date_format'], $time);
				$time	= date($this->config['time_format_seconds'], $time);

				// day header
				if ($day != $curday)
				{
					if ($curday)
					{
						echo "</ul>\n<br /></li>\n";
					}

					echo '<li><strong>' . $day . ":</strong>\n<ul>\n";
					$curday = $day;
				}

				// do unicode entities
				if (($edit_note = $page['edit_note']) !== '')
				{
					if ($this->page['page_lang'] != $page['page_lang'])
					{
						$edit_note = $this->do_unicode_entities($edit_note, $page['page_lang']);
					}

					$edit_note = ' <span class="editnote">[' . $edit_note . ']</span>';
				}

				// print entry
				echo '<li class="lined">' .
						'<span style="text-align:left">' .
							'<small>' . $time . '</small>  &mdash; ' .
							// $this->compose_link_to_page($page['tag'], 'revisions', '', 0) .
							'<img src="' . $this->config['theme_url'] . 'icon/spacer.png' . '" title="' .
									$this->get_translation('CommentDeleted') . '" alt="[deleted]" class="btn-delete"/> ' .
							$this->compose_link_to_page($page['tag'], '', '', 0) .
						'</span>' .
						' . . . . . . . . . . . . . . . . <small>' .
						$this->user_link($page['user_name'], '', true, false) .
						$edit_note .
						'</small>' .
					"</li>\n";
			}
		}

		echo "</ul>\n</li>\n</ul>";

		$this->print_pagination($pagination);
	}
	else
	{
		echo $this->get_translation('NoRecentlyDeleted');
	}
}

?>
