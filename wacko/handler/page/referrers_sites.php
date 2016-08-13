<?php

if (!defined('IN_WACKO'))
{
	exit;
}

// TODO: remove or reuse ?obsolete? message sets: ViewReferringSitesGlobal, ViewReferringSites

$this->ensure_page(true); // allow forums

if ((  $this->db->enable_referrers == 0)
	||($this->db->enable_referrers == 1 && !$this->get_user())
	||($this->db->enable_referrers == 2 && !$this->is_admin()))
{
	$this->set_message($this->_t('ReadAccessDenied'), 'error');
	$this->show_must_go_on();
}

$mode = @$_GET['o'];
if (!ctype_lower($mode))
{
	$mode = '';
}

// navigation
if ($mode == 'global')
{
	echo "<h3>".$this->_t('ReferrersText')." &raquo; ".$this->_t('ViewReferrersGlobal')."</h3>";
	echo '<ul class="menu">
			<li><a href="'.$this->href('referrers_sites').'">'.$this->_t('ViewReferrersPage').'</a></li>
			<li class="active">'.$this->_t('ViewReferrersGlobal')."</li>
		</ul><br /><br />\n";
}
else
{
	echo "<h3>".$this->_t('ReferrersText')." &raquo; ".$this->_t('ViewReferrersPage')."</h3>";
	echo '<ul class="menu">
			<li class="active">'.$this->_t('ViewReferrersPage').'</li>
			<li><a href="'.$this->href('referrers_sites', '', 'o=global').'">'. $this->_t('ViewReferrersGlobal')."</a></li>
		</ul><br /><br />\n";
}

$href = $this->href('referrers', '', 'o=' . $mode);
if ($mode == 'global')
{
	$title		= Ut::perc_replace($this->_t('DomainsSitesPagesGlobal'), $href);
	$referrers	= $this->load_referrers();
}
else
{
	$title = Ut::perc_replace($this->_t('DomainsSitesPages'),
		$this->compose_link_to_page($this->tag),
		(($i = $this->db->referrers_purge_time) == 0? '' :
			($i == 1? $this->_t('Last24Hours') :
			Ut::perc_replace($this->_t('LastDays'), $i))),
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
	echo $this->_t('NoneReferrers')."<br />\n";
}
