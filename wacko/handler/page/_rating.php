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

		if ($page_id = array_search($page_id, $ids))
		{
			return true;
		}
		else
		{
			return false;
		}
	}
}

// determine if user has rated this page
if (handler_show_page_is_rated($this, $this->page['page_id']) === false && (isset($_GET['show_rating']) && $_GET['show_rating'] != 1) )
{
	// display rating section
	echo '<section id="section-rating">';

	// display rating header
	echo '<header id="header-rating">';
	echo $this->_t('RatingHeader') . ' [<a href="' . $this->href('', '', 'show_rating=1') . '#header-rating">' . $this->_t('RatingResults') . '</a>]';
	echo "</header>\n";

	// display rating form
	echo '<div class="rating">' . $this->form_open('rate', ['page_method' => 'rate']) . '';
	echo '<input type="radio" id="minus3" name="value" value="-3" /><label for="minus3">-3</label>' .
		 '<input type="radio" id="minus2" name="value" value="-2" /><label for="minus2">-2</label>' .
		 '<input type="radio" id="minus1" name="value" value="-1" /><label for="minus1">-1</label>' .
		 '<input type="radio" id="plus0" name="value" value="0" /><label for="plus0"> 0</label>' .
		 '<input type="radio" id="plus1" name="value" value="1" /><label for="plus1">+1</label>' .
		 '<input type="radio" id="plus2" name="value" value="2" /><label for="plus2">+2</label>' .
		 '<input type="radio" id="plus3" name="value" value="3" /><label for="plus3">+3</label>' .
		 '<input type="submit" name="rate" id="submit" value="' . $this->_t('RatingSubmit') . '" />';
	echo '' . $this->form_close() . '</div>';

	echo "</section>\n";
}
else
{
	$results = $this->db->load_single(
				"SELECT page_id, value, voters " .
				"FROM " . $this->db->table_prefix . "rating " .
				"WHERE page_id = {$this->page['page_id']} " .
				"LIMIT 1");

	if ($results['voters'] > 0)			$results['ratio'] = $results['value'] / $results['voters'];
	if (is_float($results['ratio']))	$results['ratio'] = round($results['ratio'], 2);
	if ($results['ratio'] > 0)			$results['ratio'] = '+' . $results['ratio'];

	// display rating section
	echo '<section id="section-rating">' . "\n";

	// display rating header
	echo '<header id="header-rating">' . "\n";
	echo $this->_t('RatingHeaderResults') .
	(handler_show_page_is_rated($this, $this->page['page_id']) === false
	? ' [<a href="' . $this->href('', '', 'show_rating=0') . '#header-rating">' . $this->_t('RatingForm') . '</a>]'
	: '');
	echo "</header>\n";

	// display rating results
	if (isset($results['ratio']))
	{
		echo '<div class="rating">';
		echo '' . $this->_t('RatingTotal') . ': <strong>' . $results['ratio'] . '</strong>' .
					 ' '.
					 '' . $this->_t('RatingVoters') . ': <strong>' . $results['voters'] . '</strong>';
		echo '</div>';
	}
	else
	{
		echo '<div class="rating">';
		echo '<em>' . $this->_t('RatingNotRated') . '</em>';
		echo '</div>';
	}

	echo "</section>\n";
}

?>
