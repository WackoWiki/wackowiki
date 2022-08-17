<?php

if (!defined('IN_WACKO'))
{
	exit;
}

// registering local functions
// determine if user has rated a given page
function handler_rate_page_is_rated(&$engine, $page_id)
{
	$cookie	= $engine->sess->get_cookie('rating');
	$ids	= explode(';', $cookie);

	if (in_array($page_id, $ids) === true || $page_id == $cookie)
	{
		return true;
	}
	else
	{
		return false;
	}
}

// set page rating cookie
function handler_rate_set_rate_cookie(&$engine, $page_id)
{
	$cookie	= $engine->sess->get_cookie('rating');
	$ids	= explode(';', $cookie);
	$ids[]	= $page_id;
	$cookie	= implode(';', $ids);
	$engine->sess->set_cookie('rating', $cookie, 365);

	return true;
}

// update page rating
if ($this->has_access('read') && $this->page && $this->db->footer_rating && ($this->db->footer_rating != 2 || $this->get_user()))
{
	if (isset($_POST['value']))
	{
		$page_id	= $this->page['page_id'];
		$value		= round((int) $_POST['value']);

		if ($value >  3) $value =  3;
		if ($value < -3) $value = -3;

		// determine if user has rated this page
		if (handler_rate_page_is_rated($this, $page_id) === false)
		{
			// try to load current rating entry
			if ($rating = $this->db->load_single(
				"SELECT page_id, value, voters " .
				"FROM " . $this->db->table_prefix . "rating " .
				"WHERE page_id = " . (int) $page_id . " " .
				"LIMIT 1"))
			{
				// update entry
				$this->db->sql_query(
					"UPDATE " . $this->db->table_prefix . "rating SET " .
						"value		= {$rating['value']} + " . $this->db->q($value) . ", " .
						"voters		= {$rating['voters']} + 1 " .
					"WHERE page_id = " . (int) $page_id . "");
			}
			else
			{
				// create entry
				$this->db->sql_query(
					"INSERT INTO " . $this->db->table_prefix . "rating SET " .
						"page_id		= " . (int) $page_id . ", " .
						"value			= " . $this->db->q($value) . ", " .
						"voters			= 1, " .
						"rating_time	= UTC_TIMESTAMP()");
			}

			// set cookie
			handler_rate_set_rate_cookie($this, $page_id);

			// rated successfully
			$this->set_message($this->_t('RatingSuccess'));
			$this->http->redirect($this->href('', '', ['show_rating' => 1]) . '#rating');
		}
		else
		{
			// already rated
			$this->set_message($this->_t('RatingDuplicate'));
			$this->http->redirect($this->href());
		}
	}
	else
	{
		// rating value hasn't been given
		$this->http->redirect($this->href());
	}
}
else
{
	$this->show_message($this->_t('RatingDenied'), 'error');
}
