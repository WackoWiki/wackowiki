<?php

if (!defined('IN_WACKO'))
{
	exit;
}

if (!function_exists('full_text_search'))
{
	function full_text_search(&$wacko, $phrase, $for, $limit = 50, $filter, $lang, $deleted = 0)
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
							? "AND (a.deleted <> '1' OR b.deleted <> '1') "
							: "AND a.deleted <> '1' ")
					: "").
				" )", true);

		$count		= count($count_results);
		$pagination = $wacko->pagination($count, $limit, 'p', 'phrase='.$phrase);

		// load search results
		$results = $wacko->load_all(
			"SELECT a.page_id, a.title, a.tag, a.created, a.modified, a.body, a.comment_on_id, a.page_lang, MATCH(a.body) AGAINST('".quote($wacko->dblink, $phrase)."' IN BOOLEAN MODE) AS score, u.user_name, o.user_name as owner_name ". //
			"FROM ".$wacko->config['table_prefix']."page a ".
				"LEFT JOIN ".$wacko->config['table_prefix']."user u ON (a.user_id = u.user_id) ".
				"LEFT JOIN ".$wacko->config['table_prefix']."user o ON (a.owner_id = o.user_id) ".
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
							? "AND (a.deleted <> '1' OR b.deleted <> '1') "
							: "AND a.deleted <> '1' ")
					: "").
				" ) ".
			"ORDER BY score DESC ".
			"LIMIT {$pagination['offset']}, $limit");

		return array($results, $pagination);
	}
}

if (!function_exists('tag_search'))
{
	function tag_search(&$wacko, $phrase, $for, $limit = 50, $filter, $lang, $deleted = 0)
	{
		$limit		= (int) $limit;
		$pagination	= '';

		$count_results = $wacko->load_all(
			"SELECT a.page_id ".
			"FROM ".$wacko->config['table_prefix']."page a ".
			($for
				? "LEFT JOIN ".$wacko->config['table_prefix']."page b ON (a.comment_on_id = b.page_id) "
				: "").
			"WHERE ( lower(a.tag) LIKE binary lower('%".quote($wacko->dblink, $phrase)."%') ".
				"OR lower(a.title) LIKE lower('%".quote($wacko->dblink, $phrase)."%')) ".
			($for
				? "AND (a.supertag LIKE '".quote($wacko->dblink, $wacko->translit($for))."/%' ".
					  "OR b.supertag LIKE '".quote($wacko->dblink, $wacko->translit($for))."/%' )"
				: "").
			($filter
				? "AND a.comment_on_id = '0' "
				: "").
			($deleted != 1
				? ($for
					? "AND (a.deleted <> '1' OR b.deleted <> '1') "
					: "AND a.deleted <> '1' ")
				: "")
			, true);

		$count		= count($count_results);
		$pagination = $wacko->pagination($count, $limit, 'p', 'phrase='.$phrase);

		// load search results
		$results = $wacko->load_all(
			"SELECT a.page_id, a.title, a.tag, a.created, a.modified, a.comment_on_id, a.page_lang, u.user_name, o.user_name as owner_name ".
			"FROM ".$wacko->config['table_prefix']."page a ".
				"LEFT JOIN ".$wacko->config['table_prefix']."user u ON (a.user_id = u.user_id) ".
				"LEFT JOIN ".$wacko->config['table_prefix']."user o ON (a.owner_id = o.user_id) ".
			($for
				? "LEFT JOIN ".$wacko->config['table_prefix']."page b ON (a.comment_on_id = b.page_id) "
				: "").
			"WHERE (lower(a.tag) LIKE binary lower('%".quote($wacko->dblink, $phrase)."%') ".
				"OR lower(a.title) LIKE lower('%".quote($wacko->dblink, $phrase)."%')) ".
			($for
				? "AND (a.supertag LIKE '".quote($wacko->dblink, $wacko->translit($for))."/%' ".
					  "OR b.supertag LIKE '".quote($wacko->dblink, $wacko->translit($for))."/%' )"
				: "").
			($filter
				? "AND a.comment_on_id = '0' "
				: "").
			($deleted != 1
				? ($for
					? "AND (a.deleted <> '1' OR b.deleted <> '1') "
					: "AND a.deleted <> '1' ")
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

			for ($i = 0; $i <= strlen($text); $i++)
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

$output = '';

if (!isset($topic))		$topic		= '';
if (!isset($title))		$title		= '';
if (!isset($filter))	$filter		= '';
if (!isset($style))		$style		= '';
if (!isset($nomark))	$nomark		= '';
if (!isset($for))		$for		= '';
if (!isset($lang))		$lang		= '';
if (!isset($term))		$term		= '';
if (!isset($options))	$options	= 1;
if (!isset($max))		$max		= null;

$user	= $this->get_user();
$max	= $this->get_list_count($max);

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
			$results = tag_search($this, $phrase, $for, (int)$max, ($filter == 'all' ? 0 : 1), $lang);
		}
		else
		{
			$results = full_text_search($this, $phrase, $for, (int)$max ,($filter == 'all' ? 0 : 1), $lang);
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

						$_lang		= '';
						$preview	= '';

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

						// check current page lang for different charset to do_unicode_entities() against
						if ($this->page['page_lang'] != $page['page_lang'])
						{
							#$page['title'] = $this->do_unicode_entities($page['title'], $page['page_lang']);
							$_lang		= $page['page_lang'];
							$preview	= $this->do_unicode_entities($preview, $_lang);
						}

						$output .= '<h3 style="display: inline;">'.$this->link('/'.$page['tag'], '', (isset($title) ? $page['title'] : $page['tag']), '', '', '', $_lang )."</h3>". ($mode != 'topic' ? ' ('.$count.')' : '');
						$output .= '<br /><span style="color: #808080; line-height: 1.24; white-space: nowrap;">'.$page['user_name'].' '.$this->get_time_formatted($page['modified']).'</span>';

						if ($mode != 'topic')
						{
							$output .= $preview;
						}

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

			$show_pagination = $this->show_pagination(isset($pagination['text']) ? $pagination['text'] : '');

			// pagination
			echo $show_pagination;

			if (!$nomark)
			{
				echo '<div class="layout-box"><p class="layout-box"><span>'.
					$this->get_translation(($mode == 'topic' ? 'Topic' : '').'SearchResults').
					' "'.$phrase.'" (<strong>'.$i.'</strong>):</span></p>';
			}

			//show results
			echo $output;

			// close list
			if ($style == 'ul')		echo "</ul>\n";
			if ($style == 'ol')		echo "</ol>\n";
			if (!$nomark)			echo "</div>\n";

			// pagination
			echo $show_pagination;
		}
		else if (!$nomark)
		{
			echo $this->get_translation('NoResultsFor').'"'.$phrase.'".';
		}
	}
	else
	{
		if (!$nomark) echo $this->get_translation('NoResultsFor').'"'.$phrase.'".';
	}
}

?>