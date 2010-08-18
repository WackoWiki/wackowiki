<?php

// registering local functions
// determine if user has rated a given page
function handler_rate_page_is_rated(&$engine, $id)
{
	$cookie	= $engine->get_cookie('rating');
	$ids	= explode(';', $cookie);
	
	if (in_array($id, $ids) === true || $id == $cookie)
		return true;
	else return false;
}
// set page rating cookie
function handler_rate_set_rate_cookie(&$engine, $id)
{
	$cookie	= $engine->get_cookie('rating');
	$ids	= explode(';', $cookie);
	$ids[]	= $id;
	$cookie	= implode(';', $ids);
	$engine->set_session_cookie('rating', $cookie);
	$engine->set_persistent_cookie('rating', $cookie, 365);
	return true;
}

// update page rating
if ($this->has_access('read') && $this->page && $this->config['hide_rating'] != 1)
{
	if (isset($_POST['value']))
	{
		$id		= $this->page['page_id'];
		$value	= round((int)$_POST['value']);
		
		if ($value >  3) $value =  3;
		if ($value < -3) $value = -3;
	
		// determine if user has rated this page
		if (handler_rate_page_is_rated($this, $id) === false)
		{
			// try to load current rating entry
			if ($rating = $this->load_single(
				"SELECT page_id, value, voters ".
				"FROM {$this->config['table_prefix']}rating ".
				"WHERE page_id = $id ".
				"LIMIT 1"))
			{
				// update entry
				$this->query(
					"UPDATE {$this->config['table_prefix']}rating SET ".
					"value	= {$rating['value']} + '".quote($this->dblink, $value)."', ".
					"voters	= {$rating['voters']} + 1 ".
					"WHERE page_id = $id");
			}
			else
			{
				// create entry
				$this->query(
					"INSERT INTO {$this->config['table_prefix']}rating SET ".
					"page_id		= $id, ".
					"value	= '".quote($this->dblink, $value)."', ".
					"voters	= 1");
					// time is set automatically
			}
		
			// set cookie
			handler_rate_set_rate_cookie($this, $id);
		
			// rated successfully
			$this->set_message($this->get_translation('RatingSuccess'));
			$this->redirect($this->href('', '', 'show_rating=1').'#rating');
		}
		else
		{
			// already rated
			$this->set_message($this->get_translation('RatingDuplicate'));
			$this->redirect($this->href());
		}
	}
	else
	{
		// rating value hasn't been given
		$this->redirect($this->href());
	}
}
else
{
	echo '<div class="page">';
	echo '<h4>'.$this->get_translation('RatingDenied').'</h4>';
	echo '</div>';
}

?>
