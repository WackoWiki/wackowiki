<?php

if (!defined('IN_WACKO'))
{
	exit;
}

if (!function_exists('full_text_search'))
{
	function full_text_search(&$wacko, $phrase, $for, $limit = 50, $filter, $deleted = 0)
	{
		$limit		= (int) $limit;
		$pagination	= '';

		$count_results = $wacko->load_all(
			"SELECT a.page_id ".
			"FROM ".$wacko->config['table_prefix']."page a ".
			($for
				? "LEFT JOIN ".$wacko->config['table_prefix']."page b ON (a.comment_on_id = b.page_id) "
				: "").
			"WHERE (( MATCH(a.body) AGAINST('".quote($wacko->dblink, $phrase)."' IN BOOLEAN MODE) ".
				"OR lower(a.title) LIKE lower('%".quote($wacko->dblink, $phrase)."%') ".
				"OR lower(a.tag) LIKE lower('%".quote($wacko->dblink, $phrase)."%')) ".
				($for
					? "AND (a.supertag LIKE '".quote($wacko->dblink, $wacko->translit($for))."/%' ".
					  "OR b.supertag LIKE '".quote($wacko->dblink, $wacko->translit($for))."/%' )"
					: "").
				($filter
					? "AND a.comment_on_id = '0' "
					: "").
				($deleted != 1
					? ($for
							? "AND (a.deleted <> '1' OR b.deleted <> '1')"
							: "AND a.deleted <> '1'")
					: "").
				" )", true);

		$count		= count($count_results);
		$pagination = $wacko->pagination($count, $limit, 'p', 'phrase='.$phrase);

		// load search results
		$results = $wacko->load_all(
			"SELECT a.page_id, a.title, a.tag, a.body, a.comment_on_id, a.lang, MATCH(a.body) AGAINST('".quote($wacko->dblink, $phrase)."' IN BOOLEAN MODE) AS score ". //
			"FROM ".$wacko->config['table_prefix']."page a ".
			($for
				? "LEFT JOIN ".$wacko->config['table_prefix']."page b ON (a.comment_on_id = b.page_id) "
				: "").
			"WHERE (( MATCH(a.body) AGAINST('".quote($wacko->dblink, $phrase)."' IN BOOLEAN MODE) ".
				"OR lower(a.title) LIKE lower('%".quote($wacko->dblink, $phrase)."%') ".
				"OR lower(a.tag) LIKE lower('%".quote($wacko->dblink, $phrase)."%')) ".
				($for
					? "AND (a.supertag LIKE '".quote($wacko->dblink, $wacko->translit($for))."/%' ".
					  "OR b.supertag LIKE '".quote($wacko->dblink, $wacko->translit($for))."/%' )"
					: "").
				($filter
					? "AND a.comment_on_id = '0' "
					: "").
				($deleted != 1
					? ($for
							? "AND (a.deleted <> '1' OR b.deleted <> '1')"
							: "AND a.deleted <> '1'")
					: "").
				" ) ".
			"ORDER BY score DESC ".
			"LIMIT {$pagination['offset']}, $limit");

		return array($results, $pagination);
	}
}

if (!function_exists('tag_search'))
{
	function tag_search(&$wacko, $phrase, $for, $limit = 50)
	{
		$limit		= (int) $limit;
		$pagination	= '';

		$count_results = $wacko->load_all(
			"SELECT a.page_id ".
			"FROM ".$wacko->config['table_prefix']."page a ".
			($for
				? "LEFT JOIN ".$wacko->config['table_prefix']."page b ON (a.comment_on_id = b.page_id) "
				: "").
			"WHERE lower(a.tag) LIKE binary lower('%".quote($wacko->dblink, $phrase)."%') ".
				"OR lower(a.title) LIKE lower('%".quote($wacko->dblink, $phrase)."%') ".
			($for
				? "AND (a.supertag LIKE '".quote($wacko->dblink, $wacko->translit($for))."/%' ".
					  "OR b.supertag LIKE '".quote($wacko->dblink, $wacko->translit($for))."/%' )"
				: "")
			, true);

		$count		= count($count_results);
		$pagination = $wacko->pagination($count, $limit, 'p', 'phrase='.$phrase);

		// load search results
		$results = $wacko->load_all(
			"SELECT a.page_id, a.tag, a.title, a.comment_on_id, a.lang ".
			"FROM ".$wacko->config['table_prefix']."page a ".
			($for
				? "LEFT JOIN ".$wacko->config['table_prefix']."page b ON (a.comment_on_id = b.page_id) "
				: "").
			"WHERE lower(a.tag) LIKE binary lower('%".quote($wacko->dblink, $phrase)."%') ".
				"OR lower(a.title) LIKE lower('%".quote($wacko->dblink, $phrase)."%') ".
			($for
				? "AND (a.supertag LIKE '".quote($wacko->dblink, $wacko->translit($for))."/%' ".
					  "OR b.supertag LIKE '".quote($wacko->dblink, $wacko->translit($for))."/%' )"
					: "").
			"ORDER BY a.supertag ".
			"LIMIT {$pagination['offset']}, $limit");

		return array($results, $pagination);
	}
}

if (!function_exists('get_line_with_phrase'))
{
	function get_line_with_phrase($phrase, $string, $insensitive = true, $cleanup = '')
	{
		$lines	= explode("\n", $string);
		$result	= '';

		foreach ($lines as $line)
		{
			if ($insensitive == true)
			{
				if (stripos($line, $phrase))
				{
					if ($result)
					{
						$result .= "<br/>\n";
					}
				}
			}
			else
			{
				if (strpos($line, $phrase))
				{
					if ($result)
					{
						$result .= "<br/>\n";
					}
				}

				$result .= $cleanup ? str_replace('$phrase', '', $line) : $line;
			}
		}

		return $result;
	}
}

if (!function_exists('preview_text'))
{
	function preview_text($text, $limit, $tags = 0)
	{
		// trim text
		$text = trim($text);

		// strip tags if preview is without HTML
		if ($tags == 0)
		{
			$text = preg_replace('/\s\s+/', ' ', strip_tags($text));
		}

		// if strlen is smaller than limit return
		if (strlen($text) < $limit)
		{
			return $text;
		}

		if ($tags == 0)
		{
			return substr($text, 0, $limit) . " [..]";
		}
		else
		{
			$counter = 0;

			for ($i = 0; $i<= strlen($text); $i++)
			{
				if ($text{$i} == '<')
				{
					$stop = 1;
				}

				if ($stop != 1)
				{
					$counter++;
				}

				if ($text{$i} == '>')
				{
					$stop = 0;
				}

				$return .= $text{$i};

				if ($counter >= $limit && $text{$i} == ' ')
				{
					break;
				}
			}

			return $return . "[..]";
		}
	}
}

if (!function_exists('highlight_this'))
{
	function highlight_this($text, $words, $the_place)
	{
		$words			= trim($words);
		$the_count		= 0;
		$words_array	= explode(' ', $words);

		foreach($words_array as $word)
		{
			if(strlen(trim($word)) != 0)
			{
				//exclude these words from being replaced
				$exclude_list = array('word1', 'word2', 'word3');
			}

			// Check if it's excluded
			if ( in_array( strtolower($word), $exclude_list ) )
			{

			}
			else
			{
				#$text = str_ireplace($word, "<span class=\"highlight\">".$word."</span>", $text, $count); // XXX: replaced with preg_replace()
				// escape bad regex characters
				$word = preg_quote($word);
				// highlight uppercase and lowercase correctly
				$text = preg_replace('/('.$word.')/i','<span class="highlight">$1</span>' , $text, -1 , $count);
				$the_count = $count + $the_count;
			}

		}
		//added to show how many keywords were found
		#echo '<br /><div class="emphasis">A search for <strong>' . $words. '</strong> found <strong>' . $the_count . '</strong> matches within the ' . $the_place. '.</div><br />';

		return array($text, $the_count);
	}
}

// end functions

if (!isset($topic))		$topic		= '';
if (!isset($title))		$title		= '';
if (!isset($filter))	$filter		= '';
if (!isset($style))		$style		= '';
if (!isset($nomark))	$nomark		= '';
if (!isset($for))		$for		= '';
if (!isset($term))		$term		= '';
if (!isset($options))	$options	= 1;
$output = '';

if ($user = $this->get_user())
{
	$usermax = $user['changes_count'];

	if ($usermax == 0)
	{
		$usermax = 10;
	}
}
else
{
	$usermax = 50;
}
if (!isset($max) || $usermax < $max)
{
	$max = $usermax;
}

if ($max > 100)
{
	$max	= 100;
}

if ($topic == 1)
{
	$mode = 'topic';
}
else
{
	$mode = 'full';
}

if (isset($_GET['topic']) && $_GET['topic'] == 'on')
{
	$mode = 'topic';
}

//if (!$delim) $delim="---";
if (!in_array($style, array('br', 'ul', 'ol', 'comma')))
{
	$style = 'ol';
}

$i = 0;

if ($filter != 'pages')
{
	$filter = 'all';
}

if (!isset($clean)) $clean = false;

if (isset($vars[$term]))
{
	$phrase = $vars[$term];
}
else
{
	$phrase	= '';
	$form	= 1;
}

if ($form)
{
	echo $this->form_open('search', '', 'get');

	echo '<label for="searchfor">'.$this->get_translation('SearchFor').':</label><br />';
	echo '<input type="search" name="phrase" id="searchfor" size="40" value="'.(isset($_GET['phrase']) ? htmlspecialchars($_GET['phrase'], ENT_COMPAT | ENT_HTML401, HTML_ENTITIES_CHARSET) : '').'" />';
	echo '<input type="submit" value="'.$this->get_translation('SearchButtonText').'" /><br />';

	if ($options == 1)
	{
		echo '<input type="checkbox" name="topic" '.($mode == 'topic' ? ' checked="checked"' : '' ).' id="checkboxSearch" />';
		echo '<label for="checkboxSearch">'.$this->get_translation('TopicSearchText').'</label>';
	}

	echo $this->form_close();
}

if ($phrase == '')
{
	$phrase = (isset($_GET['phrase']) ? $_GET['phrase'] : null);
}

if ($phrase)
{
	if ($form)
	{
		echo "<br />";
	}

	if (strlen($phrase) >= 3)
	{
		if ($mode == 'topic')
		{
			$results = tag_search($this, $phrase, $for, (int)$max);
		}
		else
		{
			$results = full_text_search($this, $phrase, $for, (int)$max ,($filter == 'all' ? 0 : 1));
		}

		$phrase = htmlspecialchars($phrase, ENT_COMPAT | ENT_HTML401, HTML_ENTITIES_CHARSET);

		// make and display results
		if (list ($pages, $pagination) = $results)
		{


			// open list
			if ($style == 'ul') $output .= "<ul id=\"search_results\">\n";
			if ($style == 'ol') $output .= "<ol id=\"search_results\">\n";

			foreach ($pages as $page)
			{
				if (!$this->config['hide_locked'] || $this->has_access('read', $page['page_id']) )
				{
					// Don't show it if it's a comment and we're hiding comments from this user
					if($page['comment_on_id'] == 0 || ($page['comment_on_id'] != 0 && $this->user_allowed_comments()))
					{
						// open item
						if ($style == 'ul' || $style == 'ol')	$output .= "<li>";
						if ($style == 'comma' && $i > 0)		$output .= ",\n";

						$_lang = '';

						if ($this->page['lang'] != $page['lang'])
						{
							#$page['title'] = $this->do_unicode_entities($page['title'], $page['lang']);
							$_lang = $page['lang'];
						}

						// generate preview
						if ($mode !== 'topic' && $this->has_access('read', $page['page_id']))
						{
							$body		= $this->format($page['body'], 'cleanwacko');
							$context	= get_line_with_phrase($phrase, $body, $clean);
							$context	= preview_text($text = $context, $limit = 500, $tags = 0);
							$context	= highlight_this($text = $context, $words = $phrase, $the_place = 0);
							list($context, $count) = $context;
							$preview	= "<div>".str_replace("\n", '<br />', $context)."</div>";
						}

						$output .= '<h3 style="display: inline;">'.$this->link('/'.$page['tag'], '', (isset($title) ? $page['title'] : $page['tag']), '', '', '', $_lang )."</h3>".' ('.$count.')';
						$output .= $preview;

						// close item
						if ($style == 'br')
						{
							$output .= "<br />\n";
						}

						if ($style == 'ul' || $style == 'ol')
						{
							$output .= "</li>\n";
						}

						$i++;
					}
				}
			}

			// pagination
			if (isset($pagination['text']))
			{
				echo '<span class="pagination">'.$pagination['text']."</span><br />\n";
			}

			if (!$nomark)
			{
				echo '<div class="layout-box"><p class="layout-box"><span>'.
					$this->get_translation(($mode == 'topic' ? 'Topic' : '').'SearchResults').
					' "'.$phrase.'" (<b>'.$i.'</b>):</span></p>';
			}

			//show results
			echo $output;

			// close list
			if ($style == 'ul') echo "</ul>";
			if ($style == 'ol') echo "</ol>";
			if (!$nomark) echo "</div>";

			// pagination
			if (isset($pagination['text']))
			{
				echo '<span class="pagination">'.$pagination['text']."</span><br />\n";
			}
		}
		else
		if (!$nomark) echo $this->get_translation('NoResultsFor').'"'.$phrase.'".';
	}
	else
	{
		if (!$nomark) echo $this->get_translation('NoResultsFor').'"'.$phrase.'".';
	}
}

?>