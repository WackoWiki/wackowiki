<?php

if (!defined('IN_WACKO'))
{
	exit;
}

// TODO: remove or reuse ?obsolete? message sets: ViewReferringSitesGlobal, ViewReferringSites

?>
<div id="page">
<?php

// redirect to show method if page don't exists
if (!$this->page)
{
	$this->redirect($this->href('show'));
}

// deny for comment
if ($this->page['comment_on_id'])
{
	$this->redirect($this->href('', $this->get_page_tag($this->page['comment_on_id']), 'show_comments=1')."#".$this->page['tag']);
}

// navigation
if (isset($_GET['global']))
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
			<li><a href="'.$this->href('referrers_sites', '', 'global=1').'">'. $this->get_translation('ViewReferrersGlobal')."</a></li>
		</ul><br /><br />\n";
}

if ($user = $this->get_user())
{
	if ($global = isset($_GET['global']))
	{
		$title		= str_replace('%1', $this->href('referrers', '', 'global=1'), $this->get_translation('DomainsSitesPagesGlobal'));
		$referrers	= $this->load_referrers();
	}
	else
	{
		$title = str_replace('%1', $this->compose_link_to_page($this->tag),
		str_replace('%2',
		($this->config['referrers_purge_time'] ?
		($this->config['referrers_purge_time'] == 1 ?
		$this->get_translation('Last24Hours') :
		str_replace('%1', $this->config['referrers_purge_time'],
		$this->get_translation('LastDays'))): ''),
		str_replace('%3', $this->href('referrers'),$this->get_translation('DomainsSitesPages'))));

		$referrers = $this->load_referrers($this->page['page_id']);
	}

	echo "<strong>".$title."</strong><br /><br />\n";

	if ($referrers)
	{
		for ($a = 0; $a < count($referrers); $a++)
		{
			$temp_parse_url = parse_url($referrers[$a]['referrer']);
			$temp_parse_url = ($temp_parse_url['host'] != '') ? strtolower(preg_replace('/^www\./Ui', '', $temp_parse_url['host'])) : 'unknown';

			if (isset($referrer_sites[$temp_parse_url]))
			{
				$referrer_sites[$temp_parse_url] += $referrers[$a]['num'];
			}
			else
			{
				$referrer_sites[$temp_parse_url] = $referrers[$a]['num'];
			}
		}

		array_multisort($referrer_sites, SORT_DESC, SORT_NUMERIC);
		reset($referrer_sites);

		echo "<ul class=\"ul_list\">\n";

		foreach ($referrer_sites as $site => $site_count)
		{
			echo '<li class="lined">';
			echo '<span class="list_count">'.$site_count.'</span>&nbsp;&nbsp;&nbsp;&nbsp;'.
				(($site != 'unknown')
					? '<a href="http://'.htmlspecialchars($site, ENT_COMPAT | ENT_HTML401, HTML_ENTITIES_CHARSET).'" rel="nofollow noreferrer">'.htmlspecialchars($site, ENT_COMPAT | ENT_HTML401, HTML_ENTITIES_CHARSET).'</a>'
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
}
else
{
	$message = $this->get_translation('ReadAccessDenied');
	$this->show_message($message, 'info');
}

?>
</div>