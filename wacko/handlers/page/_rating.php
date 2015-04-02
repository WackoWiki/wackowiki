<?php

if (!defined('IN_WACKO'))
{
	exit;
}

if ($this->config['footer_rating'] != 0 && ($this->config['footer_rating'] != 2 || $this->get_user()))
{
	// registering local functions
	// determine if user has rated a given page
	function handler_show_page_is_rated(&$engine, $id)
	{
		$cookie	= $engine->get_cookie('rating');
		$ids	= explode(';', $cookie);

		if ($id = array_search($id, $ids))
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
	// display rating header
	echo '<div id="rateheader">';
	echo $this->get_translation('RatingHeader').' [<a href="'.$this->href('', '', 'show_rating=1').'#rateheader">'.$this->get_translation('RatingResults').'</a>]';
	echo "</div>\n";

	// display rating form
	echo '<div class="rating">'.$this->form_open('rate').'';
	echo '<input id="minus3" name="value" type="radio" value="-3" /><label for="minus3">-3</label>'.
				 '<input id="minus2" name="value" type="radio" value="-2" /><label for="minus2">-2</label>'.
				 '<input id="minus1" name="value" type="radio" value="-1" /><label for="minus1">-1</label>'.
				 '<input id="plus0" name="value" type="radio" value="0" /><label for="plus0"> 0</label>'.
				 '<input id="plus1" name="value" type="radio" value="1" /><label for="plus1">+1</label>'.
				 '<input id="plus2" name="value" type="radio" value="2" /><label for="plus2">+2</label>'.
				 '<input id="plus3" name="value" type="radio" value="3" /><label for="plus3">+3</label>'.
				 '<input name="rate" id="submit" type="submit" value="'.$this->get_translation('RatingSubmit').'" />';
	echo ''.$this->form_close().'</div>';
}
else
{
	$results = $this->load_single(
				"SELECT page_id, value, voters ".
				"FROM {$this->config['table_prefix']}rating ".
				"WHERE page_id = {$this->page['page_id']} ".
				"LIMIT 1");

	if ($results['voters'] > 0)			$results['ratio'] = $results['value'] / $results['voters'];
	if (is_float($results['ratio']))	$results['ratio'] = round($results['ratio'], 2);
	if ($results['ratio'] > 0)			$results['ratio'] = '+'.$results['ratio'];

	// display rating header
	echo '<div id="rateheader">';
	echo $this->get_translation('RatingHeaderResults').
	(handler_show_page_is_rated($this, $this->page['page_id']) === false
	? ' [<a href="'.$this->href('', '', 'show_rating=0').'#rateheader">'.$this->get_translation('RatingForm').'</a>]'
	: '');
	echo "</div>\n";

	// display rating results
	if (isset($results['ratio']))
	{
		echo '<div class="rating">';
		echo ''.$this->get_translation('RatingTotal').': <strong>'.$results['ratio'].'</strong>'.
					 ' '.
					 ''.$this->get_translation('RatingVoters').': <strong>'.$results['voters'].'</strong>';
		echo '</div>';
	}
	else
	{
		echo '<div class="rating">';
		echo '<em>'.$this->get_translation('RatingNotRated').'</em>';
		echo '</div>';
	}
}

?>