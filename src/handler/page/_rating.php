<?php

if (!defined('IN_WACKO'))
{
	exit;
}

if ($this->db->footer_rating != 0 && ($this->db->footer_rating != 2 || $this->get_user()))
{
	// registering local functions
	// determine if user has rated a given page
	function handler_show_page_is_rated(&$engine, $page_id)
	{
		$cookie	= $engine->sess->get_cookie('rating');
		$ids	= explode(';', $cookie);

		return (bool) array_search($page_id, $ids);
	}
}

// display rating section
$tpl->enter('rp_s_');

// determine if user has rated this page
if (handler_show_page_is_rated($this, $this->page['page_id']) === false
	&& (isset($_GET['show_rating']) && $_GET['show_rating'] != 1) )
{
	// display rating header
	$tpl->title		= $this->_t('RatingHeader');
	$tpl->l_href	= $this->href('', '', ['show_rating' => 1, '#' => 'header-rating']);
	$tpl->l_text	= $this->_t('RatingResults');

	// display rating form
	$votes = [
		'-3'	=> 'minus3',
		'-2'	=> 'minus2',
		'-1'	=> 'minus1',
		'0'		=> 'plus0',
		'1'		=> 'plus1',
		'2'		=> 'plus2',
		'3'		=> 'plus3',
	];

	foreach ($votes as $offset => $vote)
	{
		$tpl->f_i_label	= $vote;
		$tpl->f_i_value	= $offset;
	}
}
else
{
	if ($results = $this->db->load_single(
		"SELECT page_id, value, voters " .
		"FROM " . $this->db->table_prefix . "rating " .
		"WHERE page_id = {$this->page['page_id']} " .
		"LIMIT 1"))
	{
		if ($results['voters'] > 0)			$results['ratio'] = $results['value'] / $results['voters'];
		if (is_float($results['ratio']))	$results['ratio'] = round($results['ratio'], 2);
		if ($results['ratio'] > 0)			$results['ratio'] = '+' . $results['ratio'];
	}
	// display rating header
	$tpl->title		= $this->_t('RatingHeaderResults');

	if (handler_show_page_is_rated($this, $this->page['page_id']) === false)
	{
		$tpl->l_href		= $this->href('', '', ['show_rating' => 0, '#' => 'header-rating']);
		$tpl->l_text		= $this->_t('RatingForm');
	}

	$tpl->enter('r_');

	// display rating results
	if (isset($results['ratio']))
	{
		$tpl->rated_ratio	= $results['ratio'];
		$tpl->rated_voters	= $results['voters'];
	}
	else
	{
		$tpl->notrated	= true;
	}

	$tpl->leave();
}

$tpl->leave();

