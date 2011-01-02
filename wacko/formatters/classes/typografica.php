<?php
/*

Typografica library: typografica class.
v.2.6
23 February 2005.

---------

Copyright (c) 2004, Kuso Mendokusee <mailto:mendokusee@yandex.ru>
All rights reserved.

*/

class typografica
{

	var $wacko;
	var $skip_tags = true;
	var $p_prefix = "<p class=typo>";
	var $p_postfix = "</p>";
	var $asoft = true;
	var $indent1 = "images/z.gif width=25 height=1 border=0 alt=\'\' align=top />"; // <->
	var $indent2 = "images/z.gif width=50 height=1 border=0 alt=\'\' align=top />"; // <-->
	var $fixed_size = 80; // maximum width
	var $ignore = "/(<!--notypo-->.*?<!--\/notypo-->)/si"; // regex to be ignored
	var $de_nobr = true;

	var $phonemasks = array(
						array(
								"/([0-9]{4})\-([0-9]{2})\-([0-9]{2}) ([0-9]{2}):([0-9]{2}):([0-9]{2})/",
								"/([0-9]{4})\-([0-9]{2})\-([0-9]{2})/",
								"/(\([0-9\+\-]+\)) ?([0-9]{3})\-([0-9]{2})\-([0-9]{2})/",
								"/(\([0-9\+\-]+\)) ?([0-9]{2})\-([0-9]{2})\-([0-9]{2})/",
								"/(\([0-9\+\-]+\)) ?([0-9]{3})\-([0-9]{2})/",
								"/(\([0-9\+\-]+\)) ?([0-9]{2})\-([0-9]{3})/",
								"/([0-9]{3})\-([0-9]{2})\-([0-9]{2})/",
								"/([0-9]{2})\-([0-9]{2})\-([0-9]{2})/",
								"/([0-9]{1})\-([0-9]{2})\-([0-9]{2})/",
								"/([0-9]{2})\-([0-9]{3})/",
								"/([0-9]+)\-([0-9]+)/",
							),
						array(
								"<nobr>\\1&ndash;\\2&ndash;\\3&nbsp;\\4:\\5:\\6</nobr>",
								"<nobr>\\1&ndash;\\2&ndash;\\3</nobr>",
								"<nobr>\\1&nbsp;\\2&ndash;\\3&ndash;\\4</nobr>",
								"<nobr>\\1&nbsp;\\2&ndash;\\3&ndash;\\4</nobr>",
								"<nobr>\\1&nbsp;\\2&ndash;\\3</nobr>",
								"<nobr>\\1&nbsp;\\2&ndash;\\3</nobr>",
								"<nobr>\\1&ndash;\\2&ndash;\\3</nobr>",
								"<nobr>\\1&ndash;\\2&ndash;\\3</nobr>",
								"<nobr>\\1&ndash;\\2&ndash;\\3</nobr>",
								"<nobr>\\1&ndash;\\2</nobr>",
								"<nobr>\\1&ndash;\\2</nobr>",
							)
						);

	var $glueleft = array( "ðèñ\.", "òàáë\.", "ñì\.", "èì\.", "óë\.", "ïåð\.", "êâ\.", "îôèñ", "îô\.", "ã\." ); // contains some Russian abberviations, also see below
	var $glueright = array( "ðóá\.", "êîï\.", "ó\.å\.", "ìèí\." );

	var $settings = array ( 'inches' => 1, // convert inches into &quot;
							'apostroph' => 1, // apostroph convertor
							'laquo' => 0,  // angle quotes
							'farlaquo' => 0,  // angle quotes for FAR (greater&less characters)
							'quotes' => 0, // English quotes
							'dash' => 1,   // (150) - middle dash
							'emdash' => 1, // (151) - long dash by two minus
							'(c)' => 1, '(r)' => 1, '(tm)' => 1, '(p)' => 1, '+-' => 1, // special characters, as you know
							'degrees' => 1, // degree character
							'[--]' => 1,    // indents like $Indent*
							'dashglue' => 1, 'wordglue' => 1, // dash and word glues
							'spacing' => 1, // comma and spacing, exchange
							'phones' => 0,  // phone number processing
							'fixed' => 0,   // fit to fixed width
							'html' => 0     // HTML tags ban
	);

	function __construct( &$wacko )
	{
		$this->wacko = &$wacko;
		$this->indent1 = "<img src=".$wacko->config['base_url'].$this->indent1;
		$this->indent2 = "<img src=".$wacko->config['base_url'].$this->indent2;
	}

	///////////////////////////////////////////////////////////////////////////////////////////////////////////
	///////////////////////////////////////////////////////////////////////////////////////////////////////////
	function correct($data, $noParagraph = false)
	{
		// -2. ignoring a (or next?) regexp
		$ignored = array();
		{
			$total = preg_match_all($this->ignore, $data, $matches);
			$data = preg_replace($this->ignore, "{:typo:markup:2:}", $data);

			for ($i = 0; $i < $total; $i++)
			{
				$ignored[] = $matches[0][$i];
			}
		}

		// -1. HTML tags ban
		if ($this->settings['html'])
		{
			$data = str_replace( "&", "&amp;", $data );
		}
		// 0. Stripping tags
		// actulally, tag similarity is a problem.
		//   case 1, simple (ending tag) </abcz>
		//   case 2, simple (just a tag) <abcz>
		//   case 3, a bit difficult     <abcz href="abcz">
		//   case 4, simple (just a tag) <abcz />
		//   case 5, wiki               <!--link:begin--> (was: \xA2\xA2)...==
		//   most difficult case - tag parameter contains ">" character
		//   it's here: <abcz href="abcz>">
		//  how does stripping work? let's assume a special character. Yes-yes, special character
		//    it would be stick (?like bee or mosquito?) within us =)
		//  will change all tags with special character, simultaneously store them into an array.
		//  and then beleive, there are no special characters in the wild world (unexplored wilderness?).
		$tags = array();

		if ($this->skip_tags)
		{
			$re =  "/<\/?[a-z0-9]+(". // tag name
									"\s+(". // repeatable statement: if only one delimiter and little body
									"[a-z]+(". // alpha-composed attribute, could be followed by equals character
											"=((\'[^\']*\')|(\"[^\"]*\")|([0-9@\-_a-z:\/?&=\.]+))". //
											")?".
										")?".
									")*\/?>|<\!--link:begin-->[^\n]*?==/i";
			$total = preg_match_all($re, $data, $matches);
			$data = preg_replace($re, "{:typo:markup:1:}", $data);

			for ($i = 0; $i < $total; $i++)
			{
				if ($this->settings['html'])
				{
					$matches[0][$i] = "&lt;"+substr($matches[0][$i],1);
				}

				$tags[] = $matches[0][$i];
			}
		}

		// 1. Commas and spaces
		if ($this->settings['spacing'])
		{
			$data = preg_replace('/(\s*)([,]*)/i', '\\2\\1', $data );
			$data = preg_replace('/(\s*)([\.?!]*)(\s*[¨À-ßA-Z])/', '\\2\\1\\3', $data );
		}

		// 2. Splitting to strings with length no more than XX characters
		// --- not ported to wacko ---
		// --- not ported to wacko ---

		// 3. Special characters
		$data = $this->replace_specials( $data );

		// 4. Short words and &nbsp;
		if ($this->settings['wordglue'])
		{
			$data = " ".$data." ";
			$_data = " ".$data." ";

			while ($_data != $data)
			{
				$_data = $data;
				$data = preg_replace('/(\s+)([a-zà-ÿÀ-ß]{1,2})(\s+)([^\\s$])/i', '\\1\\2&nbsp;\\4', $data );
				$data = preg_replace('/(\s+)([a-zà-ÿÀ-ß]{3})(\s+)([^\\s$])/i',   '\\1\\2&nbsp;\\4', $data );
			}
			foreach ($this->glueleft as $i)
			{
				$data = preg_replace('/([\\s]+)(".$i.")(\s+)/i', "\\1\\2&nbsp;", $data );
			}
			foreach ($this->glueright as $i)
			{
				$data = preg_replace('/([\\s]+)(".$i.")(\s+)/i', "&nbsp;\\2\\3", $data );
			}
		}

		// 5. Sticking flippers together. Psaw! Concatenation of hyphens
		if ($this->settings['dashglue'])
		{
			$data = preg_replace('/([a-zà-ÿÀ-ß0-9]+(\-[a-zà-ÿÀ-ß0-9]+)+)/i', '<nobr>\\1</nobr>', $data );
		}

		// 6. Macros
		$data = $this->replace_macros($data, $noParagraph);

		// 7. Line feeds
		// --- not ported to wacko ---
		// --- not ported to wacko ---

		// INFINITY. Inserting tags back.
		if ($this->skip_tags)
		{
			$data .= ' ';
			$a = explode('{:typo:markup:1:}', $data );

			if ($a)
			{
				$data = $a[0];
				$size = count($a);

				for ($i = 1; $i < $size; $i++)
				{
					$data= $data.$tags[$i-1].$a[$i];
				}
			}
		}

		// INFINITY-2. inserting a (next?) ignored regexp
		{
			$data .= ' ';
			$a = explode('{:typo:markup:2:}', $data );

			if ($a)
			{
				$data = $a[0];
				$size = count($a);

				for ($i = 1; $i < $size; $i++)
				{
					$data= $data.$ignored[$i-1].$a[$i];
				}
			}
		}

		// BONUS: link scrolling via A(...)
		// --- not ported to wacko ---
		// --- not ported to wacko ---

		// ooh, finished
		if ($this->de_nobr)
		{
			$data = str_replace('<nobr>', '<span class="nobr">', str_replace('</nobr>', '</span>', $data ));
		}

		return preg_replace('/^(\s)+/', '',  preg_replace('/(\s)+$/', '', $data));
	}
	///////////////////////////////////////////////////////////////////////////////////////////////////////////

	// -----------------------------------------------------------------------------------
	// Method is only for internal use. Checks only special characters
	function replace_specials( $data )
	{
		//print "(($data))";
		// 0. inches with digits
		if ($this->settings['inches'])
		{
			$data = preg_replace('/(?<=\s)(([0-9]{1,2}([\.,][0-9]{1,2})?))\"/i', '\\1&quot;', $data );
		}

		// 0a. apostroph
		if ($this->settings['apostroph'])
		{
			$data = preg_replace( "/([\s\"][~0-9¸¨´¥ºª³²¿¯’'A-Za-zÀ-ßà-ÿ\-:\/\.]+)'([~ºª³²¿¯àÀåÅèÈîÎóÓþÞÿß][~0-9¸¨´¥ºª³²¿¯’'A-Za-zÀ-ßà-ÿ\-:\/\.]+[\s\.,:;\)<=\"])/i", "\\1’\\2", $data );
		}

		// 1. English quotes
		if ($this->settings['quotes'])
		{
			$data = preg_replace('/\"\"/i', '&quot;&quot;', $data);
			$data = preg_replace('/\"\.\"/i', '&quot;.&quot;', $data);
			$_data = "\"\"";

			while ($_data != $data)
			{
				$_data = $data;
				$data = preg_replace('/(^|\s|\{:typo:markup:2:}|{:typo:markup:1:}|>)\"([0-9A-Za-z\'\!\s\.\?\,\-\&\;\:\_{:typo:markup:1:}{:typo:markup:2:}]+(\"|&#148;))/i', "\\1&#147;\\2", $data);
				$data = preg_replace('/(\&\#147\;([A-Za-z0-9\'\!\s\.\?\,\-\&\;\:{:typo:markup:1:}{:typo:markup:2:}\_]*).*[A-Za-z0-9][{:typo:markup:1:}{:typo:markup:2:}\?\.\!\,]*)\"/i', "\\1&#148;", $data);
			}
		}

		// 2. angle quotes
		if ($this->settings['laquo'])
		{
			$data = preg_replace('/\"\"/i', '&quot;&quot;', $data );
			$data = preg_replace("/(^|\s|{:typo:markup:2:}|{:typo:markup:1:}|>|\()\"(({:typo:markup:2:}|{:typo:markup:1:})*[~0-9¸¨´¥ºª³²¿¯’'A-Za-zÀ-ßà-ÿ\-:\/\.])/i", "\\1&laquo;\\2", $data);
			// nb: wacko only regexp follows:
			$data = preg_replace("/(^|\s|\{:typo:markup:2:}|{:typo:markup:1:}|>|\()\"(({:typo:markup:2:}|{:typo:markup:1:}|\/&nbsp;|\/|\!)*[~0-9¸¨´¥ºª³²’'A-Za-zÀ-ßà-ÿ\-:\/\.])/i", "\\1&laquo;\\2", $data);
			$_data = "\"\"";

			while ($_data != $data)
			{
				$_data = $data;
				$data = preg_replace("/(\&laquo\;([^\"]*)[¸¨´¥ºª³²¿¯’'A-Za-zÀ-ßà-ÿ0-9\.\-:\/](\{:typo:markup:2:}|{:typo:markup:1:})*)\"/si", "\\1&raquo;", $data);
				// nb: wacko only regexps follows:
				$data = preg_replace("/(\&laquo\;([^\"]*)[¸¨´¥ºª³²¿¯’'A-Za-zÀ-ßà-ÿ0-9\.\-:\/](\{:typo:markup:2:}|{:typo:markup:1:})*\?({:typo:markup:2:}|{:typo:markup:1:})*)\"/si", "\\1&raquo;", $data);
				$data = preg_replace("/(\&laquo\;([^\"]*)[¸¨´¥ºª³²¿¯’'A-Za-zÀ-ßà-ÿ0-9\.\-:\/](\{:typo:markup:2:}|{:typo:markup:1:}|\/|\!)*)\"/si", "\\1&raquo;", $data);
			}
		}

		// 2a. angle quotes for FAR manager
		// --- not ported to wacko ---
		// --- not ported to wacko ---

		// 2b. angle and English quotes together
		if (($this->settings['quotes']) && (($this->settings['laquo']) || ($this->settings['farlaquo'])))
		{
			$data = preg_replace("/(\&\#147\;(([A-Za-z0-9'!\.?,\-&;:]|\s|{:typo:markup:1:}|{:typo:markup:2:})*)&laquo;(.*)&raquo;)&raquo;/i", "\\1&#148;", $data);
		}

		// 3. dash
		if ($this->settings['dash'])
		{
			$data = preg_replace("/(\s|;)\-(\s)/i", "\\1&ndash;\\2", $data);
		}
		// 3a. long dash
		if ($this->settings['emdash'])
		{
			$data = preg_replace("/(\s|;)\-\-(\s)/i", "\\1&mdash;\\2", $data);
		}

		// 4. (ñ)
		if ($this->settings['(c)'])
		{
			$data = preg_replace("/\([cCñÑ]\)/i", "&copy;", $data);
			# $data = preg_replace("/\([cCñÑ]\)((?=\w)|(?=\s[0-9]+))/i", "&copy;", $data); // not working (?)
		}
		// 4a. (r)
		if ($this->settings['(r)'])
		{
			$data = preg_replace("/\(r\)/i", "<sup>&#174;</sup>", $data);
		}
		// 4b. (tm)
		if ($this->settings['(tm)'])
		{
			$data = preg_replace("/\(tm\)|\(òì\)/i", "&#153;", $data);
		}
		// 4c. (p)
		if ($this->settings['(p)'])
		{
			$data = preg_replace("/\(p\)/i", "&#167;", $data);
		}

		// 5. +/-
		if ($this->settings['+-'])
		{
			$data = preg_replace("/\+\-/i", "&#177;", $data);
		}
		// 5a. 12^C
		if ($this->settings['degrees'])
		{
			$data = preg_replace("/-([0-9])+\^([FCÑK])/", "&ndash;\\1&#176\\2", $data);
			$data = preg_replace("/\+([0-9])+\^([FCÑK])/", "+\\1&#176\\2", $data);
			$data = preg_replace("/\^([FCÑK])/", "&#176\\1", $data);
		}

		// 6. phones
		if ($this->settings['phones'])
		{
			foreach ($this->phonemasks[0] as $i => $v)
			{
				$data = preg_replace( $v, $this->phonemasks[1][$i], $data );
			}
		}

		return $data;
	}

	// -----------------------------------------------------------------------------------
	// Method is only for internal use. Checks only macros
	function replace_macros($data, $noParagraph)
	{
		// 1. Paragraphs
		// --- not ported to wacko ---
		// 2. Paragpaph indent (indented line)
		if ($this->settings['[--]'])
		{
			$data = preg_replace('/\[--\]/i', $this->indent1, $data);
			$data = preg_replace('/\[---\]/i', $this->indent2, $data);
		}
		// 3. mailto:
		// --- not ported to wacko ---
		// 4. http://
		// --- not ported to wacko ---
		return $data;
	}

}

?>