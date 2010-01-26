<?php

// registering local functions
// determine if user has rated a given page
function HandlerRatePageIsRated(&$engine, $id)
{
	$cookie	= $engine->GetCookie('rating');
	$ids	= explode(';', $cookie);
	
	if (in_array($id, $ids) === true || $id == $cookie)
		return true;
	else return false;
}
// set page rating cookie
function HandlerRateSetRateCookie(&$engine, $id)
{
	$cookie	= $engine->GetCookie('rating');
	$ids	= explode(';', $cookie);
	$ids[]	= $id;
	$cookie	= implode(';', $ids);
	$engine->SetSessionCookie('rating', $cookie);
	$engine->SetPersistentCookie('rating', $cookie, 365);
	return true;
}

// update page rating
if ($this->HasAccess('read') && $this->page && $this->config['hide_rating'] != 1)
{
	if (isset($_POST['value']))
	{
		$id		= $this->page['page_id'];
		$value	= round((int)$_POST['value']);
		
		if ($value >  3) $value =  3;
		if ($value < -3) $value = -3;
	
		// determine if user has rated this page
		if (HandlerRatePageIsRated($this, $id) === false)
		{
			// try to load current rating entry
			if ($rating = $this->LoadSingle(
				"SELECT page_id, value, voters ".
				"FROM {$this->config['table_prefix']}rating ".
				"WHERE page_id = $id ".
				"LIMIT 1"))
			{
				// update entry
				$this->Query(
					"UPDATE {$this->config['table_prefix']}rating SET ".
					"value	= {$rating['value']} + '".quote($this->dblink, $value)."', ".
					"voters	= {$rating['voters']} + 1 ".
					"WHERE page_id = $id");
			}
			else
			{
				// create entry
				$this->Query(
					"INSERT INTO {$this->config['table_prefix']}rating SET ".
					"page_id		= $id, ".
					"value	= '".quote($this->dblink, $value)."', ".
					"voters	= 1");
					// time is set automatically
			}
		
			// set cookie
			HandlerRateSetRateCookie($this, $id);
		
			// rated successfully
			$this->SetMessage($this->GetTranslation('RatingSuccess'));
			$this->Redirect($this->href('', '', 'show_rating=1').'#rating');
		}
		else
		{
			// already rated
			$this->SetMessage($this->GetTranslation('RatingDuplicate'));
			$this->Redirect($this->href());
		}
	}
	else
	{
		// rating value hasn't been given
		$this->Redirect($this->href());
	}
}
else
{
	echo '<div class="page">';
	echo '<h4>'.$this->GetTranslation('RatingDenied').'</h4>';
	echo '</div>';
}

?>
