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
		$title = str_replace('%1', $this->href('referrers', '', 'global=1'),$this->get_translation('DomainsSitesPagesGlobal'));
		$referrers = $this->load_referrers();
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

	print("<strong>$title</strong><br /><br />\n");
	if ($referrers)
	{
		for ($a = 0; $a < count($referrers); $a++)
		{
			$temp_parse_url = parse_url($referrers[$a]['referrer']);
			$temp_parse_url = ($temp_parse_url['host'] != '') ? strtolower(preg_replace('/^www\./Ui', '', $temp_parse_url['host'])) : 'unknown';

			if (isset($referrer_sites['$temp_parse_url']))
			{
				$referrer_sites['$temp_parse_url'] += $referrers[$a]['num'];
			}
			else
			{
				$referrer_sites['$temp_parse_url'] = $referrers[$a]['num'];
			}
		}

		array_multisort($referrer_sites, SORT_DESC, SORT_NUMERIC);
		reset($referrer_sites);
	?>
	<div class="cssform3">
		<?php
		foreach ($referrer_sites as $site => $site_count)
		{ ?>
		<span class="site_count"><?php echo $site_count; ?></span>&nbsp;&nbsp;&nbsp;&nbsp;<?php print((($site != 'unknown') ? "<a href=\"http://$site\">$site</a>" : $site)); ?><br />
		<?php
		}
		?>
	</div>
	<?php
	}
	else
	{
		print($this->get_translation('NoneReferrers')."<br />\n");
	}

	if ($global)
	{
		print("<br />[".str_replace('%1',$this->href('referrers_sites'),str_replace('%2', $this->tag, $this->get_translation('ViewReferringSites')))." | ".str_replace('%1', $this->href('referrers'), str_replace('%2', $this->tag, $this->get_translation('ViewReferrersFor')))."]");
	}
	else
	{
		print("<br />[".str_replace('%1', $this->href('referrers_sites', '', 'global=1'), $this->get_translation('ViewReferringSitesGlobal')) ." | ".str_replace('%1', $this->href('referrers', '', 'global=1'), $this->get_translation('ViewReferrersForGlobal'))."]");
	}
}
else
{
	print($this->get_translation('ReadAccessDenied'));
}
?>
</div>