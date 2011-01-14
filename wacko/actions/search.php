<?php

if (!function_exists('full_text_search'))
{
	function full_text_search(&$wacko, $phrase, $filter)
	{
		return $wacko->load_all(
			"SELECT tag, body, comment_on_id ".
			"FROM ".$wacko->config['table_prefix']."page ".
			"WHERE (( match(body) against('".quote($wacko->dblink, $phrase)."') ".
				"OR lower(tag) LIKE lower('%".quote($wacko->dblink, $phrase)."%')) ".
				($filter
					? "AND comment_on_id = '0'"
					: "").
				" )");
	}
}

if (!function_exists('tag_search'))
{
	function tag_search(&$wacko, $phrase)
	{
		return $wacko->load_all(
			"SELECT tag, comment_on_id ".
			"FROM ".$wacko->config['table_prefix']."page ".
			"WHERE lower(tag) LIKE binary lower('%".quote($wacko->dblink, $phrase)."%') ".
			"ORDER BY supertag");
	}
}

if (!function_exists('get_line_with_phrase'))
{
	function get_line_with_phrase($phrase, $string, $cleanup)
	{
		$lines = explode("\n", $string);
		$result = '';

		foreach ($lines as $line)
		{
			if (strpos($line, $phrase))
			{
				if ($result)
				{
					$result .= "<br/>\n";
				}

				$result .= $cleanup ? str_replace("$phrase", '', $line) : $line;
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

		// STRIP TAGS IF PREVIEW IS WITHOUT HTML
		if ($tags == 0) $text = preg_replace('/\s\s+/', ' ', strip_tags($text));

		// IF STRLEN IS SMALLER THAN LIMIT RETURN
		if (strlen($text) < $limit) return $text;

		if ($tags == 0)
		{
			return substr($text, 0, $limit) . " ...";
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

			return $return . "...";
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
				$text = str_ireplace($word, "<span class=\"highlight\">".$word."</span>", $text, $count);
				$the_count = $count + $the_count;
			}

		}
		//added to show how many keywords were found
		#echo "<br /><div class=\"emphasis\">A search for <strong>" . $words. "</strong> found <strong>" . $the_count . "</strong> matches within the " . $the_place. ".</div><br />";

		return $text;
	}
}

if (!isset($topic)) $topic = '';
if (!isset($title)) $title = '';
if (!isset($filter)) $filter = '';
if (!isset($style)) $style = '';
if (!isset($nomark)) $nomark = '';
if (!isset($for)) $for = '';

if (($topic == 1) || ($title == 1))
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

if (isset($vars[$for]))
{
	$phrase = $vars[$for];
}
else
{
	$phrase = '';
	$form = 1;
}

if ($form)
{
	echo $this->form_open('', '', 'get') ?>

<label for="searchfor"><?php echo $this->get_translation('SearchFor');?></label>
:&nbsp;
<br />
<input name="phrase" id="searchfor" size="40" value="<?php echo htmlspecialchars(isset($_GET['phrase'])? $_GET['phrase'] : ''); ?>" />
<input type="submit" value="<?php echo $this->get_translation('SearchButtonText'); ?>" />
<br />
<input type="checkbox" name="topic" <?php if ($mode == 'topic') echo "CHECKED"; ?> id="checkboxSearch" />
<label for="checkboxSearch"><?php echo $this->get_translation('TopicSearchText'); ?></label>
	<?php
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
			$results = tag_search($this, $phrase);
		}
		else
		{
			$results = full_text_search($this, $phrase, ($filter == 'all' ? 0 : 1));
		}

		$phrase = htmlspecialchars($phrase);

		// make and display results
		if ($results)
		{
			if (!$nomark) echo "<div class=\"layout-box\"><p class=\"layout-box\"><span>".
			$this->get_translation(($mode == 'topic' ? 'Topic' : '')."SearchResults").
			" \"$phrase\":</span></p>";
			// open list
			if ($style == 'ul') echo "<ul id=\"search_results\">\n";
			if ($style == 'ol') echo "<ol id=\"search_results\">\n";

			foreach ($results as $page)
			{
				if (!$this->config['hide_locked'] || $this->has_access('read', $page['tag']) )
				{
					// Don't show it if it's a comment and we're hiding comments from this user
					if($page['comment_on_id'] == 0 || ($page['comment_on_id'] != 0 && $this->user_allowed_comments()))
					{
						// open item
						if ($style == 'ul' || $style == 'ol') echo "<li>";
						if ($style == 'comma' && $i > 0) echo ",\n";

						echo "<h3>".$this->link('/'.$page['tag'], '', $page['tag'])."</h3>";

						if ($mode !== 'topic')
						{
							$context = get_line_with_phrase($phrase, $page['body'], $clean);
							$context = preview_text($text = $context, $limit = 500, $tags = 0);
							$context = highlight_this($text = $context, $words = $phrase, $the_place = 0);
							echo "<div>".str_replace("\n", '<br />', $context)."</div>";
						}

						// close item
						if ($style == 'br') echo "<br />\n";
						if ($style == 'ul' || $style == 'ol') echo "</li>\n";
						$i++;
					}
				}
			}

			// close list
			if ($style == 'ul') echo "</ul>";
			if ($style == 'ol') echo "</ol>";
			if (!$nomark) echo "</div>";
		}
		else
		if (!$nomark) echo $this->get_translation('NoResultsFor')."\"$phrase\".";
	}
	else
	{
		if (!$nomark) echo $this->get_translation('NoResultsFor')."\"$phrase\".";
	}
}

?>