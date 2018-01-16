<?php

if (!defined('IN_WACKO'))
{
	exit;
}

// redirect to show method if hide_revisions is true
if ($this->hide_revisions)
{
	$this->http->redirect($this->href());
}

$this->ensure_page(true);

// show minor edits
if ($this->db->minor_edit)
{
	$hide_minor_edit = (int) @$_GET['minor_edit'];
}
else
{
	$hide_minor_edit = 0;
}

// show deleted pages
$show_deleted = $this->is_admin();

// get page_id for deleted but stored page
if ($this->page['deleted'])
{
	$this->show_message(
		// $this->_t('DoesNotExists') . " " . ( $this->has_access('create') ?  Ut::perc_replace($this->_t('PromptCreate'), $this->href('edit', '', '', 1)) : '').
		'BACKUP of deleted page!' // TODO: localize and add description: to restore the page you ...
		);
}

if ($this->has_access('read'))
{
	// load revisions for this page
	if (list ($revisions, $pagination) = $this->load_revisions($this->page['page_id'], $hide_minor_edit, $show_deleted))
	{
		$this->context[++$this->current_context] = '';

		echo $this->form_open('diff_versions', ['page_method' => 'diff', 'form_method' => 'get']) .
			"<p>\n" .
				'<input type="submit" value="' . $this->_t('ShowDifferencesButton') . '">';

		$place_holder	= '&nbsp;&nbsp;&nbsp;';
		$user			= $this->get_user();
		$default_mode	= $user['diff_mode'] ?: $this->db->default_diff_mode;
		$diff_modes		= $this->_t('DiffMode');
		$diff_mode_list	= explode(',', $this->db->diff_modes);

		foreach($diff_mode_list as $mode)
		{
			echo $place_holder .
				'<input type="radio" id="' . 'diff_mode_' . $mode . '" name="diffmode" value="' . $mode . '"' .
				($mode == $default_mode? ' checked' : '') . '>' .
				'<label for="' . 'diff_mode_' . $mode . '">' . $diff_modes[$mode] . '</label>';
		}

		echo $place_holder .
			'<a href="' . $this->href('revisions.xml') . '">' .
				'<img src="' . $this->db->theme_url . 'icon/spacer.png' . '" title="' . $this->_t('RevisionXMLTip') . '" alt="XML" class="btn-feed">' .
			'</a>';

		if ($this->db->minor_edit)
		{
			// STS: ?!..
			// filter minor edits
			echo
				'<input name="minor_edit" value="' . $hide_minor_edit . '" type="hidden">' . "\n" .
				'<br>' .
				($hide_minor_edit
					? '<a href="' . $this->href('revisions', '', ['minor_edit' => 0]) . '">' . $this->_t('MinorEditShow') . '</a>'
					: '<a href="' . $this->href('revisions', '', ['minor_edit' => 1]) . '">' . $this->_t('MinorEditHide') . '</a>');
		}

		echo "</p>\n";

		$this->print_pagination($pagination);

		echo '<ul class="revisions">' . "\n";

		$diff_class			= '';
		$this->parent_size	= 0;

		// get size diff to parent version
		$r_revisions = array_reverse($revisions);

		foreach ($r_revisions as $r)
		{
			// page_size change
			$size_delta			= $r['page_size'] - $this->parent_size;
			$this->parent_size	= $r['page_size'];

			$this->rev_delta[$r['revision_id']] = $size_delta;
		}

		foreach ($revisions as $num => $page)
		{
			$edit_note =
				$page['edit_note']
					? '<span class="editnote">[' . $page['edit_note'] . ']</span>'
					: '';

			// page_size change
			$size_delta		= $this->rev_delta[$page['revision_id']];

			echo
				'<li>' .
					'<span style="display: inline-block; width:40px;">' . $page['version_id'] . '.</span>' .

					'<input type="radio" name="a" value="' . (!$num && !$pagination['offset'] ? '-1' : $page['revision_id']) . '" ' . ($num == 0 ? 'checked' : '') . '>' .
					$place_holder .
					'<input type="radio" name="b" value="' . (!$num && !$pagination['offset'] ? '-1' : $page['revision_id']) . '" ' . ($num == 1 ? 'checked' : '') . '>' .
					$place_holder . '&nbsp;' .

					($page['deleted'] ? '<del>' : '') .

					'<a href="' . $this->href('show', '', ['revision_id' => $page['revision_id']]) . '">' . $this->get_time_formatted($page['modified']) . '</a>' .
					'<span style="display: inline-block; width:130px;">' . '&nbsp; &mdash; (' . $this->binary_multiples($page['page_size'], false, true, true) . ') ' . $this->delta_formatted($size_delta) . '</span> ';

					($page['deleted'] ? '</del>' : '') .

					$place_holder . '&nbsp;' .
					$this->_t('By') . ' ' .
					$this->user_link($page['user_name'], '', true, false) . ' ' .

					$edit_note . ' ' .
					($page['minor_edit'] ? 'm' : '');

			// review
			if ($this->db->review)
			{
				if ($page['reviewed'])
				{
					echo '<span class="review">[' . $this->_t('ReviewedBy') . ' ' . $this->user_link($page['reviewer'], '', true, false) . ']</span>';
				}
				else if ($this->is_reviewer())
				{
					if (!$num)
					{
						echo ' <span class="review">[' . $this->_t('Review') . ']</span>';
					}
				}
			}

			echo "</li>\n";
		}

		echo "</ul>\n<br>\n";

		$this->print_pagination($pagination);

		echo '<a href="' . $this->href() . '" class="btn_link">' .
				'<input type="button" value="' . $this->_t('CancelDifferencesButton') . '">' .
			 '</a>' . "\n";

		echo $this->form_close() . "\n";
	}

	$this->current_context--;
}
else
{
	$this->show_message($this->_t('ReadAccessDenied'), 'error');
}
