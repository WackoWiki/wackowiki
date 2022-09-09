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

class DelphiHightlighter
{
	public $code = '';		// the code to be hightlighed
	public $newcode = '';	// generated code
	public $tok;			// word being cut out
	public $char;			// current character
	public $i;				// current position in the code
	public $code_length;	// length of the code string
	/****************************************************************/
	/* The variables that define the behavior of the analyzer       */
	/****************************************************************/
	public $case_sensitive	= false;                   // case sensitive language or not
	public $tok_delimiters	= " []()=+-/*:;,.\n\t\r  "; // word delimiters

	/***************************************************/
	/* The colors associated with each type of data    */
	/***************************************************/
	public $color_keyword	= '';
	public $color_text		= '';
	public $color_string	= '#000000';
	public $color_comment	= '#FF0000';
	public $color_symbol	= '';
	public $color_number	= '#000080';
	public $color_preproc	= '#008000';

	/*************************************************/
	/* Data styles for each data type                */
	/*************************************************/
	public $style_keyword	= ['<strong>', '</strong>'];
	public $style_text		= ['', ''];
	public $style_string	= ['<span style="background-color: yellow;">', '</span>'];
	public $style_comment	= ['<em>', '</em>'];
	public $style_symbol	= ['', ''];
	public $style_number	= ['', ''];
	public $style_preproc	= ['<em>', '</em>'];

	/*****************/
	/* Keywords */
	/*****************/
	public $keywords = [
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
	public $comment_delimiters = [
		["//", "\n"],
		["{", "}"],
		["(*", "*)"]
	];

	/********************************************/
	/* Delimiters for Strings */
	/********************************************/
	public $string_delimiters = [
		["'", "'"]
	];

	/********************************************************/
	/* Delimiters for pre-processor-instructions */
	/********************************************************/
	public $preproc_delimiters = [
		["(*\$", "*)"],
		["{\$", "}"]
	];

	/////////////////////////////////////////////////////////////////////////////////////////
	// The code itself
	/////////////////////////////////////////////////////////////////////////////////////////

	/************************************************************************/
	/* Returns true if a character is visible and can be colored            */
	/************************************************************************/
	function visible_char($char)
	{
		$inviblechars = " \t\n\r  ";

		return (!is_integer(strpos($inviblechars, $char)));
	}

	/************************************************************/
	/* Format a word in a special way (color + style)           */
	/************************************************************/
	function format_specialtok($tok, $color, $style)
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
	function analyse_word($tok)
	{
		// If it's a number
		if ((isset($tok[0]) && $tok[0] == '$') || (isset($tok[0]) && $tok[0] == '#') || ($tok == (string) intval($tok)))
		{
			return $this->format_specialtok($tok, $this->color_number, $this->style_number);
		}

		// If it's empty, we return an empty string
		if (empty($tok)) return $tok;

		// If it's a keyword
		if (   (($this->case_sensitive) && (is_integer(array_search($tok, $this->keywords, false))))
			|| ((!$this->case_sensitive) && (is_integer($this->array_search_case($tok, $this->keywords)))))
		{
			return $this->format_specialtok($tok, $this->color_keyword, $this->style_keyword);
		}

		// Otherwise, the word is returned without formatting
		return $this->format_specialtok($tok, $this->color_text, $this->style_text);
	}

	/****************************************************************/
	/* We're checking to see if we're not running into a delimiter. */
	/****************************************************************/
	function parse_array($array, $color = '#000080', $style = ['<em>', '</em>'])
	{
		// We're doing some verifications.
		if (!is_array($array))		return false;
		if (!strlen($this->code))	return false;
		if (!count($array))			return false;

		// We will try to compare the current character with the 1st
		// character of each first delimiter
		foreach ($array as $delimiter_array)
		{
			$delimiter1 = $delimiter_array[0];

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
					$delimiter2 = $delimiter_array[1];
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
						$this->newcode .= $this->analyse_word($this->tok);
						$this->tok = '';
					}

					// Then, the text is placed between the delimiters
					$this->newcode .= $this->format_specialtok(substr($this->code, $this->i, $delimiterend - $this->i + strlen($delimiter2)), $color, $style);
					// We put the clue back in the right place
					$this->i = $delimiterend + strlen($delimiter2);

					// Finally we get the current character
					if ($this->i > $this->code_length)
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
	function parse_arrays()
	{
		$has_changed = true;

		// With each change, the entire loop is restarted
		while ($has_changed)
		{
			// We're checking to see if we're not running into a comment delimiter
			$has_changed = $this->parse_array($this->preproc_delimiters, $this->color_preproc, $this->style_preproc);

			if (!$has_changed)
			{
				// We're checking to see if we're not running into a comment delimiter
				$has_changed = $this->parse_array($this->comment_delimiters, $this->color_comment, $this->style_comment);

				if (!$has_changed)
				{
					// Or a string of characters
					$has_changed = $this->parse_array($this->string_delimiters, $this->color_string, $this->style_string);
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
	function analyse_code($text)
	{
		// Initialize variables
		$this->newcode		= '';
		$this->tok			= '';
		$this->char			= null;
		$this->code			= $text;
		$this->code_length	= strlen($this->code);

		$this->trace('debut analyse_code');
		$this->dump($this->code_length, 'code_length');
		$this->dump($this->code, 'code');

		for ($this->i = 0; $this->i < $this->code_length; $this->i++ )
		{
			$this->dump($this->i, 'i');
			$this->char = $this->code[$this->i];
			$this->dump($this->char,'char');
			// We're looking for a special case.
			$this->parse_arrays();

			// We're looking to see if we've reached the end of the chain.
			if ($this->char == null)
			{
				return $this->newcode;
			}

			// We've finished analyzing the comments, we're checking to see if we have a complete word.
			if (is_integer(strpos($this->tok_delimiters, $this->char)))
			{
				// We come across a delimiter, we cut the word
				$this->newcode .= $this->analyse_word($this->tok);
				// We format the delimiter

				if ($this->visible_char($this->char))
				{
					$this->newcode .= $this->format_specialtok($this->char, $this->color_symbol, $this->style_symbol);
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
			$this->newcode .= $this->analyse_word($this->tok);
		}

		return $this->newcode;
	}
}
