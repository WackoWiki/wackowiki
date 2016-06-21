<?php

if (!defined('IN_WACKO'))
{
	exit;
}

// show deleted pages and comments
if ($this->is_admin())
{
	if (!isset($max) || $max > 1000) $max = 1000;

	if (list ($pages, $pagination) = $this->load_deleted((int)$max, false))
	{
		$show_pagination = $this->show_pagination(isset($pagination['text']) ? $pagination['text'] : '');

		// pagination
		echo $show_pagination;

		if ($pages == true)
		{
			$i = 0;

			echo '<ul class="ul_list">'."\n";

			foreach ($pages as $page)
			{
				$i++;

				if ($this->config['hide_locked'])
				{
					$access = $this->has_access('read', $page['page_id']);
				}
				else
				{
					$access = true;
				}

				if ($access === true)
				{
					// tz offset
					$time_tz = $this->get_time_tz( strtotime($page['modified']) );
					$time_tz = date('Y-m-d H:i:s', $time_tz);

					// day header
					list($day, $time) = explode(' ', $time_tz);

					if (!isset($curday)) $curday = '';

					if ($day != $curday)
					{
						if ($curday)
						{
							echo "</ul>\n<br /></li>\n";
						}

						echo "<li><strong>".date($this->config['date_format'], strtotime($day)).":</strong>\n<ul>\n";
						$curday = $day;
					}

					// do unicode entities
					if ($this->page['page_lang'] != $page['page_lang'])
					{
						$page_lang = $page['page_lang'];
					}
					else
					{
						$page_lang = '';
					}

					if ($page['edit_note'])
					{
						if ($page_lang)
						{
							$page['edit_note'] = $this->do_unicode_entities($page['edit_note'], $page_lang);
						}

						$edit_note = '<span class="editnote">['.$page['edit_note'].']</span>';
					}
					else
					{
						$edit_note = '';
					}

					// print entry
					echo '<li class="lined">'.
							'<span style="text-align:left">'.
								"<small>".date($this->config['time_format_seconds'], strtotime($time))."</small>  &mdash; ".
								#$this->compose_link_to_page($page['tag'], 'revisions', '', 0).
								'<img src="'.$this->config['theme_url'].'icon/spacer.png'.'" title="'.$this->get_translation('CommentDeleted').'" alt="[deleted]" class="btn-delete"/> '.
								$this->compose_link_to_page($page['tag'], '', '', 0).
							"</span>".
							" . . . . . . . . . . . . . . . . <small>".
							$this->user_link($page['user_name'], $lang = '', true, false).' '.

							$edit_note.
							"</small>".
						"</li>\n";
				}

				if ($i >= $max) break;
			}

			echo "</ul>\n</li>\n</ul>";
		}

		// pagination
		echo $show_pagination;
	}
	else
	{
		echo $this->get_translation('NoRecentlyDeleted');
	}
}

?>