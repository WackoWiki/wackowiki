<?php

if (!defined('IN_WACKO'))
{
	exit;
}

?>
<div id="page">
<?php

// redirect to show method if page don't exists
if (!$this->page) $this->redirect($this->href('show'));

// deny for comment
if ($this->page['comment_on_id'])
{
	$this->redirect($this->href('', $this->get_page_tag($this->page['comment_on_id']), 'show_comments=1')."#".$this->page['tag']);
}

if ($user = $this->get_user())
{
	if (isset($_GET['global']))
	{
		echo "<h3>".$this->get_translation('ReferrersText')." &raquo; ".$this->get_translation('ViewReferrersGlobal')."</h3>";
		echo "<ul class=\"menu\">
			<li><a href=\"".$this->href('referrers')."\">".$this->get_translation('ViewReferrersPage')."</a></li>
			<li><a href=\"".$this->href('referrers', '', 'perpage=1')."\">".$this->get_translation('ViewReferrersPerPage')."</a></li>
			<li class=\"active\">".$this->get_translation('ViewReferrersGlobal')."</li>
		</ul><br /><br />\n";
	}
	else if (isset($_GET['perpage']))
	{
		echo "<h3>".$this->get_translation('ReferrersText')." &raquo; ".$this->get_translation('ViewReferrersPerPage')."</h3>";
		echo "<ul class=\"menu\">
			<li><a href=\"".$this->href('referrers')."\">".$this->get_translation('ViewReferrersPage')."</a></li>
			<li class=\"active\">".$this->get_translation('ViewReferrersPerPage')."</li>
			<li><a href=\"".$this->href('referrers', '', 'global=1')."\">".$this->get_translation('ViewReferrersGlobal')."</a></li>
		</ul><br /><br />\n";
	}
	else
	{
		echo "<h3>".$this->get_translation('ReferrersText')." &raquo; ".$this->get_translation('ViewReferrersPage')."</h3>";
		echo "<ul class=\"menu\">
			<li class=\"active\">".$this->get_translation('ViewReferrersPage')."</li>
			<li><a href=\"".$this->href('referrers', '', 'perpage=1')."\">". $this->get_translation('ViewReferrersPerPage')."</a></li>
			<li><a href=\"".$this->href('referrers', '', 'global=1')."\">". $this->get_translation('ViewReferrersGlobal')."</a></li>
		</ul><br /><br />\n";
	}

	if ($global = isset($_GET['global']))
	{
		$title		= str_replace('%1', $this->href('referrers_sites', '', 'global=1'),
		str_replace('%2',
			($this->config['referrers_purge_time']
			? ($this->config['referrers_purge_time'] == 1
				? $this->get_translation('Last24Hours')
				: str_replace('%1', $this->config['referrers_purge_time'], $this->get_translation('LastDays')))
			: ''),
			$this->get_translation('ExternalPagesGlobal')));

		$pages		= $this->load_all(
			"SELECT count( r.referrer ) AS num
			FROM ".$this->config['table_prefix']."referrer r
			");

		$referrers	= $this->load_referrers();
	}
	else if ($perpage = isset($_GET['perpage']))
	{
		$title		= str_replace('%1', $this->href('referrers_sites', '', 'perpage=1'),
			str_replace('%2',
			($this->config['referrers_purge_time']
			? ($this->config['referrers_purge_time'] == 1
				? $this->get_translation('Last24Hours')
				: str_replace('%1', $this->config['referrers_purge_time'], $this->get_translation('LastDays')))
			: ''),
			$this->get_translation('ExternalPagesGlobal')));

		$pages		= $this->load_all(
			"SELECT r.page_id, count( r.referrer ) AS num, p.tag, p.title
			FROM ".$this->config['table_prefix']."referrer r
			LEFT JOIN ".$this->config['table_prefix']."page p ON ( p.page_id = r.page_id )
			GROUP BY r.page_id
			ORDER BY num DESC");
	}
	else
	{
		$title		= $this->get_translation('ReferringPages').":";
		echo "<strong>$title</strong><br /><br />\n";

		// show backlinks
		if ($pages = $this->load_pages_linking_to($this->tag))
		{
			echo "<ol>";

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
						echo '<li>'.$this->link('/'.$page['tag'])."</li>\n";
					}
				}
			}

			echo "</ol><p></p>";
		}
		else
		{
			echo $this->get_translation('NoReferringPages')."<p></p>";
		}

		$title		= str_replace('%1', $this->compose_link_to_page($this->tag),
			str_replace('%2',
			($this->config['referrers_purge_time']
			? ($this->config['referrers_purge_time'] == 1
				? $this->get_translation('Last24Hours')
				: str_replace('%1', $this->config['referrers_purge_time'], $this->get_translation('LastDays')))
			: ''),
			str_replace('%3', $this->href('referrers_sites'), $this->get_translation('ExternalPages'))));

		$referrers = $this->load_referrers($this->page['page_id']);
	}

	echo "<strong>$title</strong><br /><br />\n";

	if ($referrers || $perpage)
	{
		if ($perpage)
		{
			echo "<ul class=\"ul_list\">\n";

			foreach ($pages as $page)
			{
				if (isset($page['page_id']))
				{
					if ($page['page_id'] == 0)
					{
						$access = true; // 404er
					}
					else if ($this->config['hide_locked'])
					{
						$access = $this->has_access('read', $page['page_id']);
					}
					else
					{
						$access = true;
					}

					if ($access)
					{
						if ($page['page_id'] == 0)
						{
							$page_link = '404';
						}
						else
						{
							#$page_link = $this->compose_link_to_page($page['tag']);
							$page_link = $this->link('/'.$page['tag'], '', $page['title']);
						}

						echo '<li><strong>'.$page_link.'</strong>'.' ('.$page['num'].')';
						$referrers = $this->load_referrers($page['page_id']);

						echo "<ul>\n";

						foreach ($referrers as $referrer)
						{
							echo "<li class=\"lined\">";
							echo "<span class=\"\">".$referrer['num']."</span> &nbsp; ";
							echo "<span class=\"\"><a href=\"".htmlspecialchars($referrer['referrer'])."\">".htmlspecialchars($referrer['referrer'])."</a></span >";
							echo "</li>\n";
						}

						echo "</ul>\n<br /></li>\n";

					}
				}
			}

			echo "</ul>\n";
		}
		else
		{
			echo "<table>\n";

			foreach ($referrers as $referrer)
			{
				echo "<tr>";
				echo "<td width=\"30\" align=\"right\" valign=\"top\" style=\"padding-right: 10px\">".$referrer['num']."</td>";
				echo "<td valign=\"top\"><a href=\"".htmlspecialchars($referrer['referrer'])."\">".htmlspecialchars($referrer['referrer'])."</a></td>";
				echo "</tr>\n";
			}

			echo "</table>\n";
		}
	}
	else
	{
		echo $this->get_translation('NoneReferrers')."<br />\n";
	}


}
else
{
	echo $this->get_translation('ReadAccessDenied');
}

?>
</div>