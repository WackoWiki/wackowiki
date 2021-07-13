<?php

if (!defined('IN_WACKO'))
{
	exit;
}

$top	??= 5;
$bottom	??= 5;

if ($top > 20)			$top	= 20;
if ($bottom > 20)		$bottom	= 20;

// min votes to be included in the list
$min = 3;

// max positive rating
if (isset($top))
{
	$pages = $this->db->load_all(
		"SELECT p.tag AS pagetag, p.title AS title, MAX(r.value) AS rate, " .
			"r.voters AS votes, (r.value / r.voters) AS ratio " .
		"FROM " . $this->db->table_prefix . "page AS p, " . $this->db->table_prefix . "rating AS r " .
		"WHERE p.deleted <> 1 " .
			"AND p.page_id = r.page_id " .
			"AND r.voters >= " . (int) $min . " " .
			"AND r.value > 0 " .
		"GROUP BY p.tag " .
		"ORDER BY ratio DESC, votes DESC " .
		"LIMIT " . (int) $top, true);

	echo '<div class="layout-box"><p><span>' . $this->_t('RatingTopPages') . ":</span></p>\n";

	if ($pages)
	{
		echo '<table class="lined">' . "\n";

		foreach ($pages as $page)
		{
			echo '<tr><td>' . $this->compose_link_to_page($page['pagetag'], '', $page['title']) . '</td>' .
				 '<td class="nowrap" style="width:10px;">' . NBSP . '<strong>+' . round($page['rate'] / $page['votes'], 2) . '</strong></td></tr>' . "\n";
		}

		echo '</table>' . "\n";
	}
	else
	{
		echo '<em>' . $this->_t('RatingNoPagesRated') . '</em>' . "\n";
	}

	echo "</div>\n";
}

if (isset($top, $bottom)) echo '<br>';

// max negative rating
if (isset($bottom))
{
	$pages = $this->db->load_all(
		"SELECT p.tag AS pagetag, p.title AS title, MAX(r.value) AS rate, " .
			"r.voters AS votes, (r.value / r.voters) AS ratio " .
		"FROM " . $this->db->table_prefix . "page AS p, " . $this->db->table_prefix . "rating AS r " .
		"WHERE p.deleted <> 1 " .
			"AND p.page_id = r.page_id " .
			"AND r.voters >= " . (int) $min . " " .
			"AND r.value < 0 " .
		"GROUP BY p.tag " .
		"ORDER BY ratio DESC, votes DESC " .
		"LIMIT " . (int) $bottom, true);

	echo '<div class="layout-box"><p><span>' . $this->_t('RatingBottomPages') . ":</span></p>\n";

	if ($pages)
	{
		echo '<table class="lined">' . "\n";

		foreach ($pages as $page)
		{
			echo '<tr><td>' . $this->compose_link_to_page($page['pagetag'], '', $page['title']) . '</td>' .
				 '<td class="nowrap" style="width:10px;">' . NBSP . '<strong>' . round($page['rate'] / $page['votes'], 2) . '</strong></td></tr>' . "\n";
		}

		echo '</table>' . "\n";
	}
	else
	{
		echo '<em>' . $this->_t('RatingNoPagesRated') . '</em>' . "\n";
	}

	echo "</div>\n";
}
