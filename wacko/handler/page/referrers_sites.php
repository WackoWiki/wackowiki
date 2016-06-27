<?php

if (!defined('IN_WACKO'))
{
	exit;
}

// TODO: remove or reuse ?obsolete? message sets: ViewReferringSitesGlobal, ViewReferringSites

echo '<div id="page">';
$include_tail = '</div>';

// redirect to show method if page don't exists
if (!$this->page)
{
	$this->redirect($this->href());
}

if (($this->config['enable_referrers'] == 0) ||
	($this->config['enable_referrers'] == 1 && !$this->get_user()) ||
	($this->config['enable_referrers'] == 2 && !$this->is_admin()))
{
	$this->show_message($this->get_translation('ReadAccessDenied'), 'info');
	return;
}


// deny for comment
if ($this->page['comment_on_id'])
{
	$this->redirect($this->href('', $this->get_page_tag($this->page['comment_on_id']), 'show_comments=1')."#".$this->page['tag']);
}

$mode = @$_GET['o'];
if (!ctype_lower($mode))
{
	$mode = '';
}

// navigation
if ($mode == 'global')
{
	echo "<h3>".$this->get_translation('ReferrersText')." &raquo; ".$this->get_translation('ViewReferrersGlobal')."</h3>";
	echo '<ul class="menu">
			<li><a href="'.$this->href('referrers_sites').'">'.$this->get_translation('ViewReferrersPage').'</a></li>
			<li class="active">'.$this->get_translation('ViewReferrersGlobal')."</li>
		</ul><br /><br />\n";
}
else
{
	echo "<h3>".$this->get_translation('ReferrersText')." &raquo; ".$this->get_translation('ViewReferrersPage')."</h3>";
	echo '<ul class="menu">
			<li class="active">'.$this->get_translation('ViewReferrersPage').'</li>
			<li><a href="'.$this->href('referrers_sites', '', 'o=global').'">'. $this->get_translation('ViewReferrersGlobal')."</a></li>
		</ul><br /><br />\n";
}

$href = $this->href('referrers', '', 'o=' . $mode);
if ($mode == 'global')
{
	$title		= perc_replace($this->get_translation('DomainsSitesPagesGlobal'), $href);
	$referrers	= $this->load_referrers();
}
else
{
	$title = perc_replace($this->get_translation('DomainsSitesPages'),
		$this->compose_link_to_page($this->tag),
		(($i = $this->config['referrers_purge_time']) == 0? '' :
			($i == 1? $this->get_translation('Last24Hours') :
			perc_replace($this->get_translation('LastDays'), $i))),
		$href);
	$referrers = $this->load_referrers($this->page['page_id']);
}

echo "<strong>" . $title . "</strong><br /><br />\n";

if ($referrers)
{
	$referrer_sites = [];
	$unknown = 'unknown';
	foreach ($referrers as $ref)
	{
		$url = parse_url($ref['referrer']);
		$url = $url['host']? strtolower(preg_replace('/^www\./Ui', '', $url['host'])) : $unknown;

		if (isset($referrer_sites[$url]))
		{
			$referrer_sites[$url] += $ref['num'];
		}
		else
		{
			$referrer_sites[$url] = $ref['num'];
		}
	}

	array_multisort($referrer_sites, SORT_DESC, SORT_NUMERIC);

	echo '<ul class="ul_list">'."\n";

	foreach ($referrer_sites as $site => $site_count)
	{
		echo '<li class="lined">';
		echo '<span class="list_count">' . $site_count . '</span>&nbsp;&nbsp;&nbsp;&nbsp;'.
			(($site !== $unknown)
				? '<a href="http://' . htmlspecialchars($site, ENT_COMPAT | ENT_HTML401, HTML_ENTITIES_CHARSET) . '" rel="nofollow noreferrer">'.
					htmlspecialchars($site, ENT_COMPAT | ENT_HTML401, HTML_ENTITIES_CHARSET) . '</a>'
				: $site
			);
		echo "</li>\n";
	}

	echo "</ul>\n";
}
else
{
	echo $this->get_translation('NoneReferrers')."<br />\n";
}
