<?php

if (!isset($top))		$top	= 5;
if (!isset($bottom))	$bottom	= 5;

if ($top > 20)			$top	= 20;
if ($bottom > 20)		$bottom	= 20;

// min votes to be included in the list
$min = 3;

// max positive rating
if (isset($top))
{
	$pages = $this->load_all(
		"SELECT p.tag AS pagetag, p.title AS title, MAX(r.value) AS rate, ".
			"r.voters AS votes, (r.value / r.voters) AS ratio ".
		"FROM {$this->config['table_prefix']}page AS p, {$this->config['table_prefix']}rating AS r ".
		"WHERE p.page_id = r.page_id AND r.voters >= $min AND r.value > 0 ".
		"GROUP BY p.tag ".
		"ORDER BY ratio DESC, votes DESC ".
		"LIMIT ".(int)$top);
		
	echo "<div class=\"layout-box\"><p class=\"layout-box\"><span>".$this->get_translation('RatingTopPages').":</span></p>\n";
	if ($pages)
	{
		echo '<table>'."\n";
		foreach ($pages as $page)
		{
			echo '<tr class="lined"><td>'.$this->compose_link_to_page($page['pagetag'], '', $page['title'], 0).'</td>'.
				 '<td style="width:10px; white-space:nowrap;">&nbsp;<strong>+'.round($page['rate'] / $page['votes'], 2).'</strong></td></tr>'."\n";
		}
		echo '</table>'."\n";
	}
	else
	{
		echo '<em>'.$this->get_translation('RatingNoPagesRated').'</em>'."\n";
	}
	echo "</div>\n";
}

if (isset($top, $bottom)) echo '<br />';

// max negative rating
if (isset($bottom))
{
	$pages = $this->load_all(
		"SELECT p.tag AS pagetag, p.title AS title, MAX(r.value) AS rate, ".
			"r.voters AS votes, (r.value / r.voters) AS ratio ".
		"FROM {$this->config['table_prefix']}page AS p, {$this->config['table_prefix']}rating AS r ".
		"WHERE p.page_id = r.page_id AND r.voters >= $min AND r.value < 0 ".
		"GROUP BY p.tag ".
		"ORDER BY ratio DESC, votes DESC ".
		"LIMIT ".(int)$bottom);
		
	echo "<div class=\"layout-box\"><p class=\"layout-box\"><span>".$this->get_translation('RatingBottomPages').":</span></p>\n";
	if ($pages)
	{
		echo '<table>'."\n";
		foreach ($pages as $page)
		{
			echo '<tr class="lined"><td>'.$this->compose_link_to_page($page['pagetag'], '', $page['title'], 0).'</td>'.
				 '<td style="width:10px; white-space:nowrap">&nbsp;<strong>'.round($page['rate'] / $page['votes'], 2).'</strong></td></tr>'."\n";
		}
		echo '</table>'."\n";
	}
	else
	{
		echo '<em>'.$this->get_translation('RatingNoPagesRated').'</em>'."\n";
	}
	echo "</div>\n";
}

?>