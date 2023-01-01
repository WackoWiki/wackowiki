<?php

/*

Typografica library: typografica class.

https://wackowiki.org/doc/Dev/Projects/Typografica

*/

class Typografica
{
	private $options;

	public $wacko;
	public bool $skip_tags	= true;
	public string $indent1	= 'image/spacer.png" width=25 height=1 border=0 alt="">'; // <->
	public string $indent2	= 'image/spacer.png" width=50 height=1 border=0 alt="">'; // <-->
	public string $ignore	= '/(<!--notypo-->.*?<!--\/notypo-->)/usi'; // regex to be ignored
	public string $mark1	= '{:typo:markup:1:}';
	public string $mark2	= '{:typo:markup:2:}';
	public bool $de_nobr	= true;

	public array $phonemasks	= [
		[
			'/(\d{4})\-(\d{2})\-(\d{2}) (\d{2}):(\d{2}):(\d{2})/',
			'/(\d{4})\-(\d{2})\-(\d{2})/',
			'/(\([\d\+\-]+\)) ?(\d{3})\-(\d{2})\-(\d{2})/',
			'/(\([\d\+\-]+\)) ?(\d{2})\-(\d{2})\-(\d{2})/',
			'/(\([\d\+\-]+\)) ?(\d{3})\-(\d{2})/',
			'/(\([\d\+\-]+\)) ?(\d{2})\-(\d{3})/',
			'/(\d{3})\-(\d{2})\-(\d{2})/',
			'/(\d{2})\-(\d{2})\-(\d{2})/',
			'/(\d{1})\-(\d{2})\-(\d{2})/',
			'/(\d{2})\-(\d{3})/',
			'/(\d+)\-(\d+)/',
		],
		[
			"<nobr>\\1–\\2–\\3\u{00A0}\\4:\\5:\\6</nobr>",
			"<nobr>\\1–\\2–\\3</nobr>",
			"<nobr>\\1\u{00A0}\\2–\\3–\\4</nobr>",
			"<nobr>\\1\u{00A0}\\2–\\3–\\4</nobr>",
			"<nobr>\\1\u{00A0}\\2–\\3</nobr>",
			"<nobr>\\1\u{00A0}\\2–\\3</nobr>",
			"<nobr>\\1–\\2–\\3</nobr>",
			"<nobr>\\1–\\2–\\3</nobr>",
			"<nobr>\\1–\\2–\\3</nobr>",
			"<nobr>\\1–\\2</nobr>",
			"<nobr>\\1–\\2</nobr>",
		]
	];

	// contains some Russian abbreviations, also see below
	public array $glueleft	= ['рис\.', 'табл\.', 'см\.', 'им\.', 'ул\.', 'пер\.', 'кв\.', 'офис', 'оф\.', 'г\.'];
	public array $glueright	= ['руб\.', 'коп\.', 'у\.е\.', 'мин\.'];

	public array $settings	= [
		'inches'	=> 1, // convert inches into &quot;
		'apostroph'	=> 0, // apostrophe converter
		'laquo'		=> 1, // angle quotes
		'quotes'	=> 1, // English quotes
		'dash'		=> 1, // (150) - middle dash
		'emdash'	=> 1, // (151) - long dash by two minus
		'(c)'		=> 1, // special characters, as you know
		'(r)'		=> 1,
		'(tm)'		=> 1,
		'(p)'		=> 1,
		'+-'		=> 1,
		'degrees'	=> 1, // degree character
		'[--]'		=> 1, // indents like $Indent*
		'dashglue'	=> 1, // dash glue
		'wordglue'	=> 1, // word glue
		'spacing'	=> 1, // comma and spacing, exchange
		'phones'	=> 1, // phone number processing
		'html'		=> 0  // HTML tags ban
	];

	function __construct(&$wacko, &$options)
	{
		$this->options	= &$options;
		$this->wacko	= &$wacko;
		$this->indent1	= '<img src="' . $wacko->db->base_path . $this->indent1;
		$this->indent2	= '<img src="' . $wacko->db->base_path . $this->indent2;
	}

	///////////////////////////////////////////////////////////////////////////////////////////////////////////
	///////////////////////////////////////////////////////////////////////////////////////////////////////////
	function correct($data)
	{
		// -2. ignoring a (or next?) regexp
		$ignored = [];
		{
			$total	= preg_match_all($this->ignore, $data, $matches);
			$data	= preg_replace($this->ignore, $this->mark2, $data);

			for ($i = 0; $i < $total; $i++)
			{
				$ignored[] = $matches[0][$i];
			}
		}

		// -1. HTML tags ban
		if ($this->settings['html'])
		{
			$data = str_replace('&', '&amp;', $data);
		}

		// 0. Stripping tags
		// actually, tag similarity is a problem.
		//   case 1, simple (ending tag) </abcz>
		//   case 2, simple (just a tag) <abcz>
		//   case 3, a bit difficult     <abcz href="abcz">
		//   case 4, simple (just a tag) <abcz />
		//   case 5, wiki               <!--link:begin-->...==
		//   most difficult case - tag parameter contains ">" character
		//   it's here: <abcz href="abcz>">
		//  how does stripping work? let's assume a special character. Yes-yes, special character
		//    it would be stick (?like bee or mosquito?) within us =)
		//  will change all tags with special character, simultaneously store them into an array.
		//  and then believe, there are no special characters in the wild world (unexplored wilderness?).
		$tags = [];

		if ($this->skip_tags)
		{
			$re		= '/<\/?[a-z\d]+(' .			// tag name
									'\s+(' .		// repeatable statement: if only one delimiter and little body
									'[a-z]+(' .		// alpha-composed attribute, could be followed by equals character
											'=((\'[^\']*\')|(\"[^\"]*\")|([\d@\-_a-z:\/?&=\.]+))' .
											')?' .
										')?' .
									')*\/?>|' .
						'<\!--link:begin-->[^\n]*?==|' .
						'<\!--imglink:begin-->[^\n]*?==' .
					'/ui';
			$total	= preg_match_all($re, $data, $matches);
			$data	= preg_replace($re, $this->mark1, $data);

			for ($i = 0; $i < $total; $i++)
			{
				if ($this->settings['html'])
				{
					$matches[0][$i] = '&lt;' . mb_substr($matches[0][$i], 1);
				}

				$tags[] = $matches[0][$i];
			}
		}

		// 1. Commas and spaces
		if ($this->settings['spacing'])
		{
			$data = preg_replace('/(\s*)([,]*)/ui', "\\2\\1", $data);
			$data = preg_replace('/(\s*)([\.?!]*)(\s*\p{Lu})/u', "\\2\\1\\3", $data);
		}

		// 2. Special characters
		$data = $this->replace_specials($data);

		// 3. Short words and &nbsp;
		if ($this->settings['wordglue'])
		{
			$data	= ' ' . $data . ' ';
			$_data	= ' ' . $data . ' ';

			while ($_data != $data)
			{
				$_data	= $data;
				$data	= preg_replace('/(\s+)(\p{L}{1,2})(\s+)([^\\s$])/ui', "\\1\\2\u{00A0}\\4", $data);	// \u{00A0} No-Break Space (NBSP)
				$data	= preg_replace('/(\s+)(\p{L}{3})(\s+)([^\\s$])/ui',   "\\1\\2\u{00A0}\\4", $data);
			}

			foreach ($this->glueleft as $i)
			{
				$data = preg_replace('/(\s+)(' . $i . ')(\s+)/ui', "\\1\\2\u{00A0}", $data);
			}

			foreach ($this->glueright as $i)
			{
				$data = preg_replace('/(\s+)(' . $i . ')(\s+)/ui', "\u{00A0}\\2\\3", $data);
			}
		}

		// 4. Sticking flippers together. Psaw! Concatenation of hyphens
		if ($this->settings['dashglue'])
		{
			$data = preg_replace('/([\p{L}\d]+(\-[\p{L}\d]+)+)/ui', "<nobr>\\1</nobr>", $data);
		}

		// 5. Macros
		$data = $this->replace_macros($data);

		// INFINITY. Inserting tags back.
		if ($this->skip_tags)
		{
			$data = $this->insert_data($data, $tags, $this->mark1);
		}

		// INFINITY-2. inserting a (next?) ignored regexp
		{
			$data = $this->insert_data($data, $ignored, $this->mark2);
		}

		// ooh, finished
		if ($this->de_nobr)
		{
			$data = str_replace('<nobr>', '<span class="nobr">', str_replace('</nobr>', '</span>', $data));
		}

		return preg_replace('/^(\s)+/u', '',  preg_replace('/(\s)+$/u', '', $data));
	}
	///////////////////////////////////////////////////////////////////////////////////////////////////////////

	// -----------------------------------------------------------------------------------
	// Checks only special characters
	function replace_specials($data)
	{
		$mark = $this->mark1 . '|' . $this->mark2;

		// 0. inches with digits
		if ($this->settings['inches'])
		{
			$data = preg_replace('/(?<=\s)(\d{1,2}([\.,]\d{1,2})?)\"/ui', '\\1"', $data);	// \u{0022}
		}

		// 0a. apostroph
		if ($this->settings['apostroph'])
		{
			$data = preg_replace("/([\s\"][~\d’'\p{L}\-:\/\.]+)'([~єЄіІїЇаАеЕиИоОуУюЮяЯ][~\d’'\p{L}\-:\/\.]+[\s\.,:;\)<=\"])/ui", "\\1’\\2", $data );
		}

		// 1. English quotes: (\p{Latin} and English only)
		if ($this->settings['quotes'] && $this->options['lang'] == 'en')
		{
			$data	= str_replace('""',  '&quot;&quot;',  $data);
			$data	= str_replace('"."', '&quot;.&quot;', $data);
			$_data	= '""';

			while ($_data != $data)
			{
				$_data	= $data;
				$data	= preg_replace("/(^|\s|" . $mark . "|>)\"((" . $mark . ")*[\p{Latin}\d\'\!\s\.\?\,\-\&\;\:\_]+([\"”]))/ui",						"\\1“\\2", $data);	// \u{201C} <Left Double Quotation Mark>
				$data	= preg_replace("/(“([\p{Latin}\d\'\!\s\.\?\,\-\&\;\:\_]*(" . $mark . ")*).*[\p{Latin}\d][\?\.\!\,]*(" . $mark . ")*)\"/ui",		"\\1”",    $data);	// \u{201D} <Right Double Quotation Mark>
			}
		}

		// 2. angle quotes: (TODO: \p{Cyrillic} and \p{Latin} only?)
		if ($this->settings['laquo'])
		{
			$data	= str_replace('""', '&quot;&quot;', $data);
			$data	= preg_replace("/(^|\s|" . $mark . "|>|\()\"((" . $mark . ")*[~\p{L}\d\-:\/\.])/ui",					"\\1«\\2", $data);
			$data	= preg_replace("/(^|\s|" . $mark . "|>|\()\"((" . $mark . "|\/\u{00A0}|\/|\!)*[~\p{L}\d\-:\/\.])/ui",	"\\1«\\2", $data);
			$_data	= '""';

			while ($_data != $data)
			{
				$_data	= $data;
				$data	= preg_replace("/(«([^\"]*)[\p{L}\d\.\-:\/](" . $mark . ")*)\"/usi",					"\\1»", $data);
				$data	= preg_replace("/(«([^\"]*)[\p{L}\d\.\-:\/](" . $mark . ")*\?(" . $mark . ")*)\"/usi",	"\\1»", $data);
				$data	= preg_replace("/(«([^\"]*)[\p{L}\d\.\-:\/](" . $mark . "|\/|\!)*)\"/usi",				"\\1»", $data);
			}
		}

		// 2a. angle and English quotes together
		if (($this->settings['quotes']) && (($this->settings['laquo'])))
		{
			$data = preg_replace("/(“(([\p{L}\d'!\.?,\-&;:]|\s|" . $mark . ")*)«(.*)»)»/ui", "\\1”", $data);
		}

		// 3. dash
		if ($this->settings['dash'])
		{
			$data = preg_replace('/(\s|;)\-(\s)/ui', "\\1–\\2", $data);			// \u{2013}
		}

		// 3a. long dash
		if ($this->settings['emdash'])
		{
			$data = preg_replace('/(\s|;)\-\-(\s)/ui', "\\1—\\2", $data);		// \u{2014}
		}

		// 4. (c)
		if ($this->settings['(c)'])
		{
			$data = preg_replace('/\([cCсС]\)/ui', '©', $data);					// \u{00A9}
		}

		// 4a. (r)
		if ($this->settings['(r)'])
		{
			$data = str_replace('(r)', '<sup>®</sup>', $data);					// \u{00AE}
		}

		// 4b. (tm)
		if ($this->settings['(tm)'])
		{
			$data = preg_replace('/\(tm\)|\(тм\)/ui', '™', $data);				// \u{2122}
		}

		// 4c. (p)
		if ($this->settings['(p)'])
		{
			$data = str_replace('(p)', '§', $data);								// \u{00A7}
		}

		// 5. +/-
		if ($this->settings['+-'])
		{
			$data = str_replace('+-', '±', $data);								// \u{00B1}
		}

		// 5a. 12°C
		if ($this->settings['degrees'])
		{
			$data = preg_replace('/-(\d)+\^([FCСK])/u',		"-\\1°\\2",	$data);	// \u{00B0} Degree Sign
			$data = preg_replace('/\+(\d)+\^([FCСK])/u',	"+\\1°\\2",	$data);	// \u{00B0}
			$data = preg_replace('/\^([FCСK])/u',			"°\\1",		$data);	// \u{00B0}
		}

		// 6. phones
		if ($this->settings['phones'])
		{
			foreach ($this->phonemasks[0] as $i => $v)
			{
				$data = preg_replace($v, $this->phonemasks[1][$i], $data);
			}
		}

		return $data;
	}

	// -----------------------------------------------------------------------------------
	// Checks only macros
	function replace_macros($data)
	{
		// 1. Paragraph indent (indented line)
		if ($this->settings['[--]'])
		{
			$data = str_replace('[--]',  $this->indent1, $data);
			$data = str_replace('[---]', $this->indent2, $data);
		}

		return $data;
	}

	function insert_data($data, $insert, $delimiter)
	{
		$data .= ' ';
		$a = explode($delimiter, $data);

		if ($a)
		{
			$data = $a[0];
			$size = count($a);

			for ($i = 1; $i < $size; $i++)
			{
				$data = $data . $insert[$i - 1] . $a[$i];
			}
		}

		return $data;
	}

}
