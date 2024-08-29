<?php

if (!defined('IN_WACKO'))
{
	exit;
}

$this->ensure_page(true); // allow forums

if ((  $this->db->enable_referrers == 0)
	||($this->db->enable_referrers == 1 && !$this->get_user())
	||($this->db->enable_referrers == 2 && !$this->is_admin()))
{
	$this->set_message($this->_t('ReadAccessDenied'), 'error');
	$this->show_must_go_on();
}

$mod_selector	= 'o';
$modes			= [
					''			=> 'ViewReferrersPage',
					'global'	=> 'ViewReferrersGlobal',
				];
$mode			= $_GET[$mod_selector] ?? '';

if (!ctype_lower($mode))
{
	$mode = '';
}

// let's start: print header
foreach ($modes as $i => $text)
{
	if ($mode == $i)
	{
		$tpl->header = $this->_t($text);
		break;
	}
}

// print navigation
$tpl->menu = $this->tab_menu($modes, $mode, 'referrers_sites', [], $mod_selector);

$href = $this->href('referrers', '', ['o' => $mode]);

if ($mode == 'global')
{
	$tpl->title = Ut::perc_replace($this->_t('DomainsSitesPagesGlobal'), $href);
	$referrers	= $this->load_referrers();
}
else
{
	$tpl->title = Ut::perc_replace($this->_t('DomainsSitesPages'),
		$this->compose_link_to_page($this->tag),
		(($i = $this->db->referrers_purge_time) == 0? '' :
			($i == 1
				? $this->_t('Last24Hours')
				: Ut::perc_replace($this->_t('LastDays'), $i))
			),
		$href);
	$referrers = $this->load_referrers([$this->page['page_id']]);
}

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

	foreach ($referrer_sites as $site => $site_count)
	{
		$tpl->l_count	= $site_count;
		$tpl->l_site	= (($site !== $unknown)
				? '<a href="https://' . Ut::html($site) . '" rel="nofollow noreferrer">' .
					Ut::html($site) . '</a>'
				: $site
			);
	}
}
else
{
	$tpl->none = true;
}
