<?php

/**
 * Delphi Syntax Highlighter
 ******************************
 * Based on the original code of FEREY Damien at Dark Skull Software
 * published on http://www.phpcs.com/article.aspx?Val=649
 * Modified by Eric Feldstein (class formatted and adapted to WackoWiki)
 ******************************
 * Can easily be adapted for other languages (vb, c, c, c++...)
 * It is enough to modify the content of the variables
 *
 **/

class DelphiHightlighter{

	var $code = '';		// the code to be hightlighed
	var $newcode = '';	// generated code
	var $tok;			// word being cut out
	var $char;			// current character
	var $i;				// current position in the code
	var $codelength;	// length of the code string
	/****************************************************************/
	/* The variables that define the behavior of the analyzer       */
	/****************************************************************/
	var $case_sensitive	= FALSE;                   // case sensitive language or not
	var $tokdelimiters	= " []()=+-/*:;,.\n\t\r  "; // word delimiters

	/***************************************************/
	/* The colors associated with each type of data    */
	/***************************************************/
	var $colorkeyword	= '';
	var $colortext		= '';
	var $colorstring	= '#000000';
	var $colorcomment	= '#FF0000';
	var $colorsymbol	= '';
	var $colornumber	= '#000080';
	var $colorpreproc	= '#008000';

	/*************************************************/
	/* Data styles for each data type                */
	/*************************************************/
	var $stylekeyword	= ['<strong>', '</strong>'];
	var $styletext		= ['', ''];
	var $stylestring	= ['<span style="background-color: yellow;">', '</span>'];
	var $stylecomment	= ['<em>', '</em>'];
	var $stylesymbol	= ['', ''];
	var $stylenumber	= ['', ''];
	var $stylepreproc	= ['<em>', '</em>'];

	/*****************/
	/* The keywords  */
	/*****************/
	var $keywords = [
	'unit','interface','implementation','initialization','finalization','uses',
	'type','var','begin','end','with','do','function','procedure','property',
	'to','as','is','while','loop','for','repeat','until','use','class','private',
	'protected','public','published','record','packed','case','of','const','array',
	'try','finally','except','message','if','then','else','out','nil','string',
	'constructor','destructor','library','set','inherited','object','overload',
	'override','virtual','abstract','read','write','default','program','absolute',
	'asm','external','stdcall','resourcestring','downto','exports','inline',
	'raise','goto','label','dispinterface','file','threadvar','not','or','and',
	'xor','mod','shl','shr','div'];

	/***********************************/
	/* Delimiters for comment */
	/***********************************/
	var $commentdelimiters = [
		["//", "\n"],
		["{", "}"],
		["(*", "*)"]
	];

	/********************************************/
	/* Delimiters for Strings */
	/********************************************/
	var $stringdelimiters = [
		["'", "'"]
	];

	/********************************************************/
	/* Delimiters for pre-processor-instructions */
	/********************************************************/
	var $preprocdelimiters = [
		["(*\$", "*)"],
		["{\$", "}"]
	];

	/////////////////////////////////////////////////////////////////////////////////////////
	// The code itself
	/////////////////////////////////////////////////////////////////////////////////////////

	/************************************************************************/
	/* Returns true if a character is visible and can be colored            */
	/************************************************************************/
	function visiblechar($char) {
		$inviblechars = " \t\n\r  ";
		return (!is_integer(strpos($inviblechars, $char)));
	}

	/************************************************************/
	/* Format a word in a special way (color + style)           */
	/************************************************************/
	function formatspecialtok($tok, $color, $style)
	{
		if (empty($color)) return sprintf("%s$tok%s", $style[0], $style[1]);
		return sprintf("%s<span style=\"color: %s;\">$tok</span>%s", $style[0], $color, $style[1]);
	}

	/*********************************************************************/
	/* Search for an element in a table without worrying about the case. */
	/*********************************************************************/
	function array_search_case($needle, $array)
	{
		if (!is_array($array)) return FALSE;
		if (empty($array)) return FALSE;

		foreach ($array as $index=>$string)
		if (strcasecmp($needle, $string) == 0) return intval($index);
		return FALSE;
	}

	/*****************************************************/
	/* Analyzes a word and returns it in formatted form  */
	/*****************************************************/
	function analyseword($tok)
	{
		// If it's a number
		if ((isset($tok[0]) && $tok[0] == '$') || (isset($tok[0]) && $tok[0] == '#') || ($tok == (string)intval($tok)))
		return $this->formatspecialtok($tok, $this->colornumber, $this->stylenumber);

		// If it's empty, we return an empty string
		if (empty($tok)) return $tok;

		// If it's a keyword
		if ((($this->case_sensitive) && (is_integer(array_search($tok, $this->keywords, FALSE)))) ||
		((!$this->case_sensitive) && (is_integer($this->array_search_case($tok, $this->keywords)))))
		return $this->formatspecialtok($tok, $this->colorkeyword, $this->stylekeyword);
		// Otherwise, the word is returned without formatting
		return $this->formatspecialtok($tok, $this->colortext, $this->styletext);
	}

	/****************************************************************/
	/* We're checking to see if we're not running into a delimiter. */
	/****************************************************************/
	function parsearray($array, $color = '#000080', $style = ['<em>', '</em>'])
	{
		// We're doing some verifications.
		if (!is_array($array))		return FALSE;
		if (!strlen($this->code))	return FALSE;
		if (!sizeof($array))		return FALSE;

		// We will try to compare the current character with the 1st
		// character of each first delimiter
		foreach ($array as $delimiterarray)
		{
			$delimiter1 = $delimiterarray[0];

			// If the 1st char matches
			if ($this->char == $delimiter1[0])
			{
				$match = TRUE;

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

					if (!is_integer($delimiterend)) $delimiterend = strlen($this->code);
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
					if ($this->i > $this->codelength) $this->char = null;
					else $this->char = $this->code[$this->i];
					// We state that we were successful in finding
					return TRUE;
				} //if
			} // if
		} // foreach

		return FALSE;
	}

	/****************************/
	/* It handles special cases */
	/****************************/
	function parsearrays()
	{
		$haschanged = TRUE;

		// With each change, the entire loop is restarted
		while($haschanged)
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
		//  error_log("$msg");
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
			$this->dump($this->i,'i');
			$this->char = $this->code[$this->i];
			$this->dump($this->char,'char');
			// We're looking for a special case.
			$this->parsearrays();

			// We're looking to see if we've reached the end of the chain.
			if ($this->char == null) return $this->newcode;

			// We've finished analyzing the comments, we're checking to see if we have a complete word.
			if (is_integer(strpos($this->tokdelimiters, $this->char)))
			{
				// We come across a delimiter, we cut the word
				$this->newcode .= $this->analyseword($this->tok);
				// We format the delimiter

				if ($this->visiblechar($this->char)) $this->newcode .= $this->formatspecialtok($this->char, $this->colorsymbol, $this->stylesymbol);
				else $this->newcode .= $this->char;
				// We reset the current word to 0
				$this->tok = '';
			}
			else {// We don't have a complete word, we complete the word
				$this->tok .= $this->char;
			}
		} // for

		// We're checking to see if we can get to the end of the code.
		if (!empty($this->tok)) $this->newcode .= $this->analyseword($this->tok);
		return $this->newcode;
	}
}
