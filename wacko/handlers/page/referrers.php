<div id="page">
<?php

// redirect to show method if page don't exists
if (!$this->page) $this->redirect($this->href('show'));

// deny for comment
if ($this->page['comment_on_id'])
	$this->redirect($this->href('', $this->get_page_tag_by_id($this->page['comment_on_id']), 'show_comments=1')."#".$this->page['tag']);

if ($user = $this->get_user())
{
	if ($global = isset($_GET['global']))
	{
		$title = str_replace('%1', $this->href('referrers_sites', '', 'global=1'), $this->get_translation('ExternalPagesGlobal'));
		$referrers = $this->load_referrers();
	}
	else
	{
		$title = $this->get_translation('ReferringPages').":";
		print("<strong>$title</strong><br /><br />\n");

		// show backlinks
		if ($pages = $this->load_pages_linking_to($this->tag))
		{
			foreach ($pages as $page)
			{
				if ($page['tag'])
				{
					if ($this->config['hide_locked'])
					{
						$access = $this->has_access('read',$page['page_id']);
					}
					else
					{
						$access = true;
					}
					if ($access)
					{
						$links[] = $this->link('/'.$page['tag']);
					}
				}
			}
			print(implode("<br />\n", $links)."<p></p>");
		}
		else
		{
			print($this->get_translation('NoReferringPages')."<p></p>");
		}

		$title = str_replace('%1', $this->compose_link_to_page($this->tag),
		str_replace('%2',
		($this->config['referrers_purge_time']
		? ($this->config['referrers_purge_time'] == 1
			? $this->get_translation('Last24Hours')
			: str_replace('%1', $this->config['referrers_purge_time'], $this->get_translation('LastDays')))
		: ''),
		str_replace('%3', $this->href('referrers_sites'), $this->get_translation('ExternalPages'))));

		$referrers = $this->load_referrers($this->page['page_id']);
	}

	print("<strong>$title</strong><br /><br />\n");
	if ($referrers)
	{
		{
			print("<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\n");
			foreach ($referrers as $referrer)
			{
				print("<tr>");
				print("<td width=\"30\" align=\"right\" valign=\"top\" style=\"padding-right: 10px\">".$referrer['num']."</td>");
				print("<td valign=\"top\"><a href=\"".$referrer['referrer']."\">".htmlspecialchars($referrer['referrer'])."</a></td>");
				print("</tr>\n");
			}
			print("</table>\n");
		}
	}
	else
	{
		print($this->get_translation('NoneReferrers')."<br />\n");
	}

	if ($global)
	{
		print("<br />[".str_replace('%1', $this->href('referrers_sites'), str_replace('%2', $this->tag, $this->get_translation('ViewReferringSites')))." | ".str_replace('%1', $this->href('referrers'),str_replace('%2', $this->tag, $this->get_translation('ViewReferrersFor')))."]");
	}
	else
	{
		print("<br />[".str_replace('%1', $this->href('referrers_sites', '', 'global=1'),$this->get_translation('ViewReferringSitesGlobal')) ." | ".str_replace('%1', $this->href('referrers', '', 'global=1'), $this->get_translation('ViewReferrersForGlobal'))."]");
	}
}
else
{
	print($this->get_translation('ReadAccessDenied'));
}
?>
</div>