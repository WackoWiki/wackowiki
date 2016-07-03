<?php

if (!defined('IN_WACKO'))
{
	exit;
}

echo '<div id="page">';
$include_tail = '</div>';

$max			= '';
$output			= '';
$deleted		= 1;
$place_holder	= '&nbsp;&nbsp;&nbsp;';

// redirect to show method if hide_revisions is true
if ($this->hide_revisions)
{
	$this->redirect($this->href());
}

// deny for comment
if ($this->page['comment_on_id'])
{
	$this->redirect($this->href('', $this->get_page_tag($this->page['comment_on_id']), 'show_comments=1')."#".$this->page['tag']);
}

// show minor edits
if (!isset($hide_minor_edit))
{
	$hide_minor_edit = isset($_GET['minor_edit']) ? $_GET['minor_edit'] : '';
}

// show deleted pages
if ($this->is_admin())
{
	$deleted = 1;
}

// get page_id for deleted but stored page
if ($this->page['deleted'])
{
	$this->show_message(
			// $this->get_translation('DoesNotExists') ." ".( $this->has_access('create') ?  str_replace('%1', $this->href('edit', '', '', 1), $this->get_translation('PromptCreate')) : '').
			'BACKUP of deleted page!' // TODO: localize and add description: to restore the page you ...
			);
}

if ($this->has_access('read'))
{
	// load revisions for this page
	if (($revisions = $this->load_revisions($this->page['page_id'], $hide_minor_edit, $deleted)))
	{
		$this->context[++$this->current_context] = '';

		$output .= $this->form_open('diff_versions', 'diff', 'get');
		$output .= "<p>\n";
		$output .= '<input type="submit" value="'.$this->get_translation('ShowDifferencesButton').'" />';
		// $output .= '<a href="'.$this->href('').'" style="text-decoration: none;"><input type="button" value="'.$this->get_translation('CancelDifferencesButton').'" /></a>'."\n";

		$default_mode = 0; // TODO: configurable per user
		for ($mode = 0; ($text = $this->get_translation($id = 'DiffMode' . $mode)) !== null; ++$mode)
		{
			if ($text)
			{
				$output .= $place_holder .
							'<input type="radio" id="' . $id . '" name="diffmode" value="' . $mode . '"' .
							($mode == $default_mode? ' checked="checked"' : '') . ' />' .
							'<label for="' . $id . '">' . $text . '</label>';
			}
		}

		$output .= $place_holder.
					'<a href="'.$this->href('revisions.xml').'">
						<img src="'.$this->config['theme_url'].'icon/spacer.png'.'" title="'.$this->get_translation('RevisionXMLTip').'" alt="XML" class="btn-feed"/>
					</a>';

		if ($this->config['minor_edit'])
		{
			$output .= '<br />'.((isset($_GET['minor_edit']) && !$_GET['minor_edit'] == 1) ? '<a href="'.$this->href('revisions', '', 'minor_edit=1').'">'.$this->get_translation('MinorEditHide').'</a>' : '<a href="'.$this->href('revisions', '', 'minor_edit=0').'">'.$this->get_translation('MinorEditShow').'</a>');
		}

		$output .= "</p>\n".'<ul class="revisions">'."\n";

		if (@$_GET['show'] == 'all')
		{
			$max = 0;
		}
		else if (($user = $this->get_user()))
		{
			$max = $user['list_count'];
		}
		else
		{
			$max = 20;
		}

		$c = 0;
		$a = count($revisions);

		foreach ($revisions as $num => $page)
		{
			if ($page['edit_note'])
			{
				$edit_note = '<span class="editnote">['.$page['edit_note'].']</span>';
			}
			else
			{
				$edit_note = '';
			}

			$output .= '<li>';
			$output .= '<span style="display: inline-block; width:40px;">' . $page['version_id'] . '.</span>';
			$output .= '<input type="radio" name="a" value="'.(!$c ? '-1' : $page['revision_id']).'" '.($c == 0 ? 'checked="checked"' : '').' />';
			$output .= $place_holder.
						'<input type="radio" name="b" value="'.(!$c ? '-1' : $page['revision_id']).'" '.($c == 1 ? 'checked="checked"' : '').' />';
			$output .= $place_holder.'&nbsp;
						<a href="'.$this->href('show', '', 'revision_id='.$page['revision_id']).'">'.$this->get_time_formatted($page['modified']).'</a>';
			$output .= '<span style="display: inline-block; width:80px;">'."&nbsp; — id ".$page['revision_id']."</span> ";
			$output .= $place_holder."&nbsp;".$this->get_translation('By')." ".
						$this->user_link($page['user_name'], '', true, false);
			$output .= ''.$edit_note.'';
			$output .= ' '.($page['minor_edit'] ? 'm' : '');

			// review
			if ($this->config['review'])
			{
				if ($page['reviewed'])
				{
					$output .= '<span class="review">['.$this->get_translation('ReviewedBy').' '.$this->user_link($page['reviewer'], '', true, false).']</span>';
				}
				else if ($this->is_reviewer())
				{
					if (!$num)
					{
						$output .= ' <span class="review">['.$this->get_translation('Review').']</span>';
					}
				}
			}

			$output .= "</li>\n";

			if (++$c >= $max && $max)
			{
				break;
			}
		}

		$output .= "</ul>\n<br />\n";

		if ($max && $a > $max)
		{
			$output .=  '<a href="'.$this->href('revisions', '', 'show=all').'">'.$this->get_translation('RevisionsShowAll')."</a><br /><br />\n";
		}

		$output .= '<a href="'.$this->href('').'" style="text-decoration: none;"><input type="button" value="'.
					$this->get_translation('CancelDifferencesButton').'" /></a>'."\n";

		$output .= $this->form_close()."\n";
	}

	echo $output;
	$this->current_context--;
}
else
{
	$message = $this->get_translation('ReadAccessDenied');
	$this->show_message($message, 'info');
}
