<?php

if (!defined('IN_WACKO'))
{
	exit;
}

?>
<div id="page">
<?php

$max	= '';
$output	= '';

// redirect to show method if hide_revisions is true
if ($this->hide_revisions === true)
{
	$this->redirect($this->href('show'));
}

// redirect to show method if page don't exists
#if (!$this->page) $this->redirect($this->href('show'));

// deny for comment
if ($this->page['comment_on_id'])
{
	$this->redirect($this->href('', $this->get_page_tag($this->page['comment_on_id']), 'show_comments=1')."#".$this->page['tag']);
}

if (!isset($hide_minor_edit))
{
	$hide_minor_edit = isset($_GET['minor_edit']) ? $_GET['minor_edit'] :"";
}

// get page_id for deleted but stored page
if ($this->page['deleted'] == 1)
{
	echo '<br /><div class="notice">'.
			#$this->get_translation('DoesNotExists') ." ".( $this->has_access('create') ?  str_replace('%1', $this->href('edit', '', '', 1), $this->get_translation('PromptCreate')) : '').
			'BACKUP of deleted page!'. // TODO: localize and add description: to restore the page you ...
			'</div>';
}

if ($this->has_access('read'))
{
	// load revisions for this page
	if ($revisions = $this->load_revisions($this->page['page_id'], $hide_minor_edit))
	{
		$this->context[++$this->current_context] = '';
		$output .= $this->form_open('diff', '', 'get');
		$output .= "<p>\n";
		$output .= "<input type=\"submit\" value=\"".$this->get_translation('ShowDifferencesButton')."\" />";
		#$output .= "<input type=\"button\" value=\"".$this->get_translation('CancelDifferencesButton')."\" onclick=\"document.location='".addslashes($this->href(''))."';\" />\n";
		$output .= "&nbsp;&nbsp;&nbsp;<input type=\"radio\" id=\"fulldiff\" name=\"diffmode\" value=\"0\" checked=\"checked\" />\n <label for=\"fulldiff\">".$this->get_translation('FullDiff')."</label>";
		$output .= "&nbsp;&nbsp;&nbsp;<input type=\"radio\" id=\"fastdiff\" name=\"diffmode\" value=\"1\" />\n <label for=\"fastdiff\">".$this->get_translation('SimpleDiff')."</label>";
		$output .= "&nbsp;&nbsp;&nbsp;<input type=\"radio\" id=\"source\" name=\"diffmode\" value=\"2\" />\n <label for=\"source\">".$this->get_translation('SourceDiff')."</label>";
		$output .= "&nbsp;&nbsp;&nbsp;<a href=\"".$this->href('revisions.xml')."\"><img src=\"".$this->config['theme_url']."icons/xml.gif"."\" title=\"".$this->get_translation('RevisionXMLTip')."\" alt=\"XML\" /></a>";

		if ($this->config['minor_edit'])
		{
			$output .= "<br />".((isset($_GET['minor_edit']) && !$_GET['minor_edit'] == 1) ? "<a href=\"".$this->href('revisions', '', 'minor_edit=1')."\">".$this->get_translation('MinorEditHide')."</a>" : "<a href=\"".$this->href('revisions', '', 'minor_edit=0')."\">".$this->get_translation('MinorEditShow')."</a>");
		}

		$output .= "</p>\n<ul class=\"revisions\">\n";

		if (isset($_GET['show']) && $_GET['show'] == 'all')
		{
			$max = 0;
		}
		else if ($user = $this->get_user())
		{
			$max = $user['revisions_count'];
		}
		else
		{
			$max = 20;
		}

		$c = 0;
		$t = $a = count($revisions);

		foreach ($revisions as $num => $page)
		{
			if ($page['edit_note'])
			{
				$edit_note = ' <span class="editnote">['.$page['edit_note'].']</span>';
			}
			else
			{
				$edit_note = '';
			}

			if (++$c <= $max || !$max)
			{
				$output .= "<li>";
				$output .= '<span style="display: inline-block; width:40px;">'.($t--).'.</span>';
				$output .= "<input type=\"radio\" name=\"a\" value=\"".($c == 1 ? "-1" : $page['revision_m_id'])."\" ".($c == 1 ? "checked=\"checked\"" : "")." />";
				$output .= "&nbsp;&nbsp;&nbsp;<input type=\"radio\" name=\"b\" value=\"".($c == 1 ? "-1" : $page['revision_m_id'])."\" ".($c == 2 ? "checked=\"checked\"" : "")." />";
				$output .= "&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"".$this->href('show').($this->config['rewrite_mode'] ? "?" : "&amp;")."revision_id=".$page['revision_m_id']."\">".$this->get_time_string_formatted($page['modified'])."</a>";
				$output .= '<span style="display: inline-block; width:80px;">'."&nbsp; — id ".$page['revision_m_id']."</span> ";
				$output .= "&nbsp;&nbsp;&nbsp;&nbsp;".$this->get_translation('By')." ".
				($page['user_name']
					? "<a href=\"".$this->href('', $this->config['users_page'], 'profile='.$page['user_name'])."\">".$page['user_name']."</a>"
					: $this->get_translation('Guest')).'';
				$output .= ''.$edit_note.'';
				$output .= ' '.($page['minor_edit'] ? 'm' : '');

				// review
				if ($this->config['review'])
				{
					if ($page['reviewed'] == 0 &&  $this->is_reviewer())
					{
						if ($num == 0)
						{
							$output .= " <span class=\"review\">[".$this->get_translation('Review')."]</span>";
						}
					}
					else if ($page['reviewed'] == 1)
					{
						$output .= ' <span class="review">['.$this->get_translation('ReviewedBy').' <a href="'.$this->href('', $this->config['users_page'], 'profile='.$page['reviewer']).'">'.$page['reviewer'].'</a>'.']</span>';
					}
				}

				$output .= "</li>\n";
			}
		}

		$output .= "</ul>\n<br />\n";

		if ($max && $a > $max)
		{
			$output .=  "<a href=\"".$this->href('revisions', '', 'show=all')."\">".$this->get_translation('RevisionsShowAll')."</a><br /><br />\n";
		}

		if (!$this->config['revisions_hide_cancel'])
		{
			$output .= "<input type=\"button\" value=\"".$this->get_translation('CancelDifferencesButton')."\" onclick=\"document.location='".addslashes($this->href(''))."';\" />\n";
		}

		$output .= $this->form_close()."\n";
	}

	echo $output;
	$this->current_context--;
}
else
{
	echo $this->get_translation('ReadAccessDenied');
}

?>
</div>