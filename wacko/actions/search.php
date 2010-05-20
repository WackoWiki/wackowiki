<?php

if (!isset($topic)) $topic = "";
if (!isset($title)) $title = "";
if (!isset($filter)) $filter = "";
if (!isset($style)) $style = "";
if (!isset($nomark)) $nomark = "";
if (!isset($for)) $for = "";

if (!function_exists('FullTextSearch'))
{
	function FullTextSearch(&$wacko, $phrase, $filter)
	{
		return $wacko->LoadAll(
			"SELECT tag, body, comment_on_id ".
			"FROM ".$wacko->config["table_prefix"]."page ".
			"WHERE (( match(body) against('".quote($wacko->dblink, $phrase)."') ".
				"OR lower(tag) LIKE lower('%".quote($wacko->dblink, $phrase)."%')) ".
				($filter
					? "AND comment_on_id = '0'"
					: "").
				" )");
	}
}
if (!function_exists('TagSearch'))
{
	function TagSearch(&$wacko, $phrase)
	{
		return $wacko->LoadAll(
			"SELECT tag, comment_on_id ".
			"FROM ".$wacko->config["table_prefix"]."page ".
			"WHERE lower(tag) LIKE binary lower('%".quote($wacko->dblink, $phrase)."%') ".
			"ORDER BY supertag");
	}
}

if (($topic == 1) || ($title == 1))
	$mode = "topic";
else
	$mode = "full";

if (isset($_GET["topic"]) && $_GET["topic"] == "on") $mode = "topic";

//if (!$delim) $delim="---";
if (!in_array($style, array("br","ul","ol","comma"))) $style = "ol";

$i = 0;

if ($filter != "pages") $filter = "all";
if (!isset($clean)) $clean = false;

if (isset($vars[$for])) $phrase = $vars[$for];
else
{
	$phrase = "";
	$form = 1;
}

if ($form)
{
	echo $this->FormOpen("", "", "get") ?>

<label for="searchfor"><?php echo $this->GetTranslation("SearchFor");?></label>
:&nbsp;
<br />
<input
	name="phrase" id="searchfor" size="40"
	value="<?php echo htmlspecialchars(isset($_GET["phrase"])? $_GET["phrase"] : ""); ?>" />
<input
	type="submit"
	value="<?php echo $this->GetTranslation("SearchButtonText"); ?>" />
<br />
<input
	type="checkbox" name="topic"
	<?php if ($mode == "topic") echo "CHECKED"; ?> id="checkboxSearch" />
<label for="checkboxSearch"><?php echo $this->GetTranslation("TopicSearchText"); ?></label>

	<?php
	echo $this->FormClose();
}

if ($phrase == "") $phrase = (isset($_GET["phrase"]) ? $_GET["phrase"] : NULL);
if ($phrase)
{
	if ($form) print "<br />";

	if (strlen($phrase) >= 3)
	{
		if ($mode == "topic")
			$results = TagSearch($this, $phrase);
		else
			$results = FullTextSearch($this, $phrase, ($filter == "all" ? 0 : 1));

		$phrase = htmlspecialchars($phrase);

		// make and display results
		if ($results)
		{
			if (!$nomark) print(  "<div class=\"layout-box\"><p class=\"layout-box\"><span>".
			$this->GetTranslation(($mode == "topic" ? "Topic" : "")."SearchResults").
			" \"$phrase\":</span></p>");
			// open list
			if ($style == "ul") print "<ul id=\"search_results\">\n";
			if ($style == "ol") print "<ol id=\"search_results\">\n";

			foreach ($results as $page)
			{
				if (!$this->config["hide_locked"] || $this->HasAccess("read",$page["tag"]) )
				{
					// Don't show it if it's a comment and we're hiding comments from this user
					if($page["comment_on_id"] == '0' || ($page["comment_on_id"] != '0' && $this->UserAllowedComments()))
					{
						// open item
						if ($style == "ul" || $style == "ol") print "<li>";
						if ($style == "comma" && $i > 0) print ",\n";

						print("<h3>".$this->Link("/".$page["tag"],"",$page["tag"])."</h3>");
						if ($mode !== "topic")
						{
							$context = getLineWithPhrase($phrase, $page["body"], $clean);
							$context = preview_text($TEXT = $context, $LIMIT = 500, $TAGS = 0);
							$context = highlight_this($text = $context, $words = $phrase, $the_place = 0);
							print("<div>".str_replace("\n", '<br />', $context)."</div>");
						}

						// close item
						if ($style == "br") print "<br />\n";
						if ($style == "ul" || $style == "ol") print "</li>\n";
						$i++;
					}
				}
			}

			// close list
			if ($style=="ul") print "</ul>";
			if ($style=="ol") print "</ol>";
			if (!$nomark) print("</div>");
		}
		else
		if (!$nomark) echo $this->GetTranslation("NoResultsFor")."\"$phrase\".";
	}
	else
	{
		if (!$nomark) echo $this->GetTranslation("NoResultsFor")."\"$phrase\".";
	}
}

function getLineWithPhrase($phrase, $string, $cleanup)
{
	$lines = explode("\n", $string);
	$result = "";
	foreach ($lines as $line)
	{
		if (strpos($line, $phrase))
		{
			if ($result) $result .= "<br/>\n";
			$result .= $cleanup ? str_replace("$phrase", "", $line) : $line;
		}
	}
	return $result;
}

function preview_text($TEXT, $LIMIT, $TAGS = 0)
{
	// TRIM TEXT
	$TEXT = trim($TEXT);

	// STRIP TAGS IF PREVIEW IS WITHOUT HTML
	if ($TAGS == 0) $TEXT = preg_replace('/\s\s+/', ' ', strip_tags($TEXT));

	// IF STRLEN IS SMALLER THAN LIMIT RETURN
	if (strlen($TEXT) < $LIMIT) return $TEXT;

	if ($TAGS == 0) return substr($TEXT, 0, $LIMIT) . " ...";
	else
	{
		$COUNTER = 0;
		for ($i = 0; $i<= strlen($TEXT); $i++)
		{
			if ($TEXT{$i} == "<") $STOP = 1;

			if ($STOP != 1)
			{
				$COUNTER++;
			}

			if ($TEXT{$i} == ">") $STOP = 0;
			$RETURN .= $TEXT{$i};

			if ($COUNTER >= $LIMIT && $TEXT{$i} == " ") break;
		}

		return $RETURN . "...";
	}
}

function highlight_this($text, $words, $the_place)
{
	$words = trim($words);
	$the_count = 0;
	$wordsArray = explode(' ', $words);
	foreach($wordsArray as $word)
	{
		if(strlen(trim($word)) != 0)

		//exclude these words from being replaced
		$exclude_list = array("word1", "word2", "word3");

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

?>