<div id="page">
<?php

$max	= '';
$output	= '';

// redirect to show method if hide_revisions is true (1 - guests, 2 - registered users)
#if ($this->config['hide_revisions']) $this->redirect($this->href('show'));

// redirect to show method if page don't exists
#if (!$this->page) $this->redirect($this->href('show'));

// deny for comment
if ($this->page['comment_on_id'])
{
	$this->redirect($this->href('', $this->get_page_tag_by_id($this->page['comment_on_id']), 'show_comments=1')."#".$this->page['tag']);
}

if (!isset($hide_minor_edit))
{
	$hide_minor_edit = isset($_GET['minor_edit']) ? $_GET['minor_edit'] :"";
}

// get page_id for deleted but stored page
if (!isset($this->page['page_id']))
{
	$tag = trim($_GET['page'], '/revisions'); //
	// Returns Array ( [id] => Value )
	$get_page_id = $this->load_single(
			"SELECT page_id ".
			"FROM ".$this->config['table_prefix']."revision ".
			"WHERE tag = '".quote($this->dblink, $tag)."' ".
			"LIMIT 1");

	// Get the_ID value
	$this->page['page_id'] = $get_page_id['page_id'];
	echo "BACKUP of deleted page!"; // TODO: localize and add description: to restore the page you ...
}

if ($this->has_access('read'))
{
	// load revisions for this page
	if ($pages = $this->load_revisions($this->page['page_id'], $hide_minor_edit))
	{
		$this->context[++$this->current_context] = '';
		$output .= $this->form_open('diff', '', 'get');
		$output .= "<p>\n";
		$output .= "<input type=\"submit\" value=\"".$this->get_translation('ShowDifferencesButton')."\" />";
		#$output .= "<input type=\"button\" value=\"".$this->get_translation('CancelDifferencesButton')."\" onclick=\"document.location='".addslashes($this->href(''))."';\" />\n";
		$output .= "&nbsp;&nbsp;&nbsp;<input type=\"checkbox\" id=\"fastdiff\" name=\"fastdiff\" />\n <label for=\"fastdiff\">".$this->get_translation('SimpleDiff')."</label>";
		$output .= "&nbsp;&nbsp;&nbsp;<input type=\"checkbox\" id=\"source\" name=\"source\" />\n <label for=\"source\">".$this->get_translation('SourceDiff')."</label>";
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
		$t = $a = count($pages);

		foreach ($pages as $num => $page)
		{
			if ($page['edit_note'])
			{
				$edit_note = " <span class=\"editnote\">[".$page['edit_note']."]</span>";
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
				($page['user']
					? ($this->is_wiki_name($page['user'])
						? $this->link('/'.$page['user'], '', $page['user'])
						: $page['user'])
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

		if (!$this->config['revisions_hide_cancel'])
		{
			$output .= "<input type=\"button\" value=\"".$this->get_translation('CancelDifferencesButton')."\" onclick=\"document.location='".addslashes($this->href(''))."';\" />\n";
		}

		$output .= $this->form_close()."\n";
	}

	echo $output;
	$this->current_context--;

	if ($max && $a > $max)
	{
		echo "<a href=\"".$this->href('revisions', '', 'show=all')."\">".$this->get_translation('RevisionsShowAll')."</a>";
	}
}
else
{
	echo $this->get_translation('ReadAccessDenied');
}

?>
</div>