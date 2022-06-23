<?php

/**
 * Java Syntax Highlighting
 ******************************
 * Port to java highlighting (c) Mark Hissink Muller, 2004
 ******************************
* Based on the original code of FEREY Damien at Dark Skull Software
 * published on http://www.phpcs.com/article.aspx?Val=649
 * Modified by Eric Feldstein (class formatted and adapted to WackoWiki)
 ******************************
 * Can easily be adapted for other languages (vb, c, c, c++...)
 * It is enough to modify the content of the variables
 *
 **/

class JavaHighlighter
{
	public $code = '';		// the code to be hightlighed
	public $newcode = '';	// the generated code
	public $tok;			// word being cut out
	public $char;			// current character
	public $i;				// current position in the code
	public $codelength;	// length of the code string
	/****************************************************************/
	/* The variables that define the behavior of the analyzer       */
	/****************************************************************/
	public $case_sensitive	= true;						// case sensitive language or not
	public $tokdelimiters	= " []()=+-/*:;,.\n\t\r  ";	// word delimiters

	/***************************************************/
	/* The colors associated with each type of data    */
	/***************************************************/
	public $colorkeyword	= '#0000CC';
	public $colortext		= '';
	public $colorstring	= '#000000';
	public $colorcomment	= '#006600';
	public $colorsymbol	= '';
	public $colornumber	= '#000080';
	public $colorpreproc	= '#008000';

	/*************************************************/
	/* Data styles for each data type                */
	/*************************************************/
	public $stylekeyword	= ['<strong>', '</strong>'];
	public $styletext		= ['', ''];
	//public $stylestring	= ['<span style="background-color: yellow">', '</span>');
	public $stylestring	= ['', ''];
	public $stylecomment	= ['<em>', '</em>'];
	public $stylesymbol	= ['', ''];
	public $stylenumber	= ['', ''];
	public $stylepreproc	= ['<em>', '</em>'];

	/*****************/
	/* Keywords */
	/*****************/
	public $keywords = [
	'abstract','double','double','strictfp','boolean','else',
	'interface','super','break','extends','long','switch','byte','final','native',
	'synchronized','case','finally','new','this','catch','float','package','throw','char','for',
	'protected','public','published','record','packed','case','of','const','array',
	'private','throws','class','goto','protected','transient','const','if','public','try',
	'constructor','destructor','library','set','inherited','object','overload',
	'continue','implements','return','void','default','import','short','volatile',
	'do','instanceof','static','while'];
	/***********************************/
	/* Delimiters for comment */
	/***********************************/
	public $commentdelimiters = [
		["//", "\n"],
		["/*", "*/"],
		["/**", "*/"]
	];

	/********************************************/
	/* Delimiters for Strings */
	/********************************************/
	public $stringdelimiters = [
		["\"", "\""]
	];

	/********************************************************/
	/* Delimiters for pre-processor-instructions */
	/********************************************************/
	public $preprocdelimiters = [
		["(*\$", "*)"],
		["{\$", "}"]
	];

	/////////////////////////////////////////////////////////////////////////////////////////
	// The code itself
	/////////////////////////////////////////////////////////////////////////////////////////

	/************************************************************************/
	/* Returns true if a character is visible and can be colored            */
	/************************************************************************/
	function visiblechar($char)
	{
		$inviblechars = " \t\n\r  ";

		return (!is_integer(strpos($inviblechars, $char)));
	}

	/************************************************************/
	/* Format a word in a special way (color + style)           */
	/************************************************************/
	function formatspecialtok($tok, $color, $style)
	{
		if (empty($color))
		{
			return sprintf("%s$tok%s", $style[0], $style[1]);
		}

		return sprintf("%s<span style=\"color: %s;\">$tok</span>%s", $style[0], $color, $style[1]);
	}

	/*********************************************************************/
	/* Search for an element in a table without worrying about the case. */
	/*********************************************************************/
	function array_search_case($needle, $array)
	{
		if (!is_array($array))	return false;
		if (empty($array))		return false;

		foreach ($array as $index => $string)
		{
			if (strcasecmp($needle, $string) == 0)
			{
				return intval($index);
			}
		}

		return false;
	}

	/*****************************************************/
	/* Analyzes a word and returns it in formatted form  */
	/*****************************************************/
	function analyseword($tok)
	{
		// If it's a number
		if (($tok[0] == '$') || ($tok[0] == '#') || ($tok == (string)intval($tok)))
		{
			return $this->formatspecialtok($tok, $this->colornumber, $this->stylenumber);
		}

		// If it's empty, we return an empty string
		if (empty($tok)) return $tok;

		// If it's a keyword
		if (   (($this->case_sensitive) && (is_integer(array_search($tok, $this->keywords, false))))
			|| ((!$this->case_sensitive) && (is_integer($this->array_search_case($tok, $this->keywords)))))
		{
			return $this->formatspecialtok($tok, $this->colorkeyword, $this->stylekeyword);
		}

		// Otherwise, the word is returned without formatting
		return $this->formatspecialtok($tok, $this->colortext, $this->styletext);
	}

	/****************************************************************/
	/* We're checking to see if we're not running into a delimiter. */
	/****************************************************************/
	function parsearray($array, $color = '#000080', $style = ['<em>', '</em>'])
	{
		// We're doing some verifications.
		if (!is_array($array))		return false;
		if (!strlen($this->code))	return false;
		if (!count($array))			return false;

		// We will try to compare the current character with the 1st
		// character of each first delimiter
		foreach ($array as $delimiterarray)
		{
			$delimiter1 = $delimiterarray[0];

			// If the 1st char matches
			if ($this->char == $delimiter1[0])
			{
				$match = true;

				// We'll try to compare all the other characters
				// To check that we have the complete delimiter
				for ($j = 1; ($j < strlen($delimiter1)) && $match; $j++)
				{
					$match = ($this->code[$this->i + $j] == $delimiter1[$j]);
				} // for

				// If we have it in its entirety
				if ($match)
				{
					$delimiter2 = $delimiterarray[1];
					// So we're looking for the end delimiter
					$delimiterend = strpos($this->code, $delimiter2, $this->i + strlen($delimiter1));
					// If we don't find the end delimiter, we take the whole file

					if (!is_integer($delimiterend))
					{
						$delimiterend = strlen($this->code);
					}
					// Now that we have everything, we analyze the word before the delimiter, if it exists.

					if (!empty($this->tok))
					{
						$this->newcode .= $this->analyseword($this->tok);
						$this->tok = '';
					}

					// Then, the text is placed between the delimiters
					$this->newcode .= $this->formatspecialtok(substr($this->code, $this->i, $delimiterend - $this->i + strlen($delimiter2)), $color, $style);
					// We put the clue back in the right place
					$this->i = $delimiterend + strlen($delimiter2);

					// Finally we get the current character
					if ($this->i > $this->codelength)
					{
						$this->char = null;
					}
					else
					{
						$this->char = $this->code[$this->i];
					}

					// We state that we were successful in finding
					return true;
				} //if
			} // if
		} // foreach

		return false;
	}

	/****************************/
	/* It handles special cases */
	/****************************/
	function parsearrays()
	{
		$haschanged = true;

		// With each change, the entire loop is restarted
		while ($haschanged)
		{
			// We're checking to see if we're not running into a comment delimiter
			$haschanged = $this->parsearray($this->preprocdelimiters, $this->colorpreproc, $this->stylepreproc);

			if (!$haschanged)
			{
				// We're checking to see if we're not running into a comment delimiter
				$haschanged = $this->parsearray($this->commentdelimiters, $this->colorcomment, $this->stylecomment);

				if (!$haschanged)
				{
					// Or a string of characters
					$haschanged = $this->parsearray($this->stringdelimiters, $this->colorstring, $this->stylestring);
				} // if
			} // if
		} // while
	} // parsearrays

	function dump($var,$name)
	{
		//  echo "<pre>$name = \n";
		//  print_r($var);
		//  echo "</pre><br>";
	}

	function trace($msg)
	{
		error_log("$msg");
	}
	/***************************/
	/*Analyse the complete code */
	/***************************/
	function analysecode($text)
	{
		// Initialize variables
		$this->newcode		= '';
		$this->tok			= '';
		$this->char			= null;
		$this->code			= $text;
		$this->codelength	= strlen($this->code);

		$this->trace('debut analysecode');
		$this->dump($this->codelength, 'codelength');
		$this->dump($this->code, 'code');

		for ($this->i = 0; $this->i < $this->codelength; $this->i++ )
		{
			$this->dump($this->i, 'i');
			$this->char = $this->code[$this->i];
			$this->dump($this->char,'char');
			// We're looking for a special case.
			$this->parsearrays();

			// We're looking to see if we've reached the end of the chain.
			if ($this->char == null)
			{
				return $this->newcode;
			}

			// We've finished analyzing the comments, we're checking to see if we have a complete word.
			if (is_integer(strpos($this->tokdelimiters, $this->char)))
			{
				// We come across a delimiter, we cut the word
				$this->newcode .= $this->analyseword($this->tok);
				// We format the delimiter

				if ($this->visiblechar($this->char))
				{
					$this->newcode .= $this->formatspecialtok($this->char, $this->colorsymbol, $this->stylesymbol);
				}
				else
				{
					$this->newcode .= $this->char;
				}
				// We reset the current word to 0
				$this->tok = '';
			}
			else
			{
				// We don't have a complete word, we complete the word
				$this->tok .= $this->char;
			}
		} // for

		// We're checking to see if we can get to the end of the code.
		if (!empty($this->tok))
		{
			$this->newcode .= $this->analyseword($this->tok);
		}

		return $this->newcode;
	}
}
