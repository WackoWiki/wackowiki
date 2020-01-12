<?php

/*
 * additional multibyte string functions used throughout wackowiki
 */

if (!defined('IN_WACKO'))
{
	exit;
}

// taken from https://www.php.net/manual/en/function.wordwrap.php#107570
function utf8_wordwrap($string, $width = 75, $break = "\n", $cut = false)
{
	if($cut)
	{
		// Match anything 1 to $width chars long followed by whitespace or EOS,
		// otherwise match anything $width chars long
		$search = '/(.{1,' . $width . '})(?:\s|$)|(.{' . $width . '})/uS';
		$replace = '$1$2' . $break;
	}
	else
	{
		// Anchor the beginning of the pattern with a lookahead
		// to avoid crazy backtracking when words are longer than $width
		$pattern = '/(?=\s)(.{1,' . $width . '})(?:\s|$)/uS';
		$replace = '$1' . $break;
	}

	return preg_replace($search, $replace, $string);
}

// taken from https://sourceforge.net/projects/phputf8/
/**
* UTF-8 aware alternative to ucwords
* Uppercase the first character of each word in a string
* Note: requires utf8_substr_replace
* @param string
* @return string with first char of each word uppercase
* @see http://www.php.net/ucwords
*/
function utf8_ucwords($str)
{
	// Note: [\x0c\x09\x0b\x0a\x0d\x20] matches;
	// form feeds, horizontal tabs, vertical tabs, linefeeds and carriage returns
	// This corresponds to the definition of a "word" defined at http://www.php.net/ucwords
	$pattern = '/(^|([\x0c\x09\x0b\x0a\x0d\x20]+))([^\x0c\x09\x0b\x0a\x0d\x20]{1})[^\x0c\x09\x0b\x0a\x0d\x20]*/u';

	return preg_replace_callback($pattern, 'utf8_ucwords_callback', $str);
}

/**
* Callback function for preg_replace_callback call in utf8_ucwords
* You don't need to call this yourself
* @param array of matches corresponding to a single word
* @return string with first char of the word in uppercase
*/
function utf8_ucwords_callback($matches)
{
	$leadingws	= $matches[2];
	$ucfirst	= mb_strtoupper($matches[3]);
	$ucword		= utf8_substr_replace(ltrim($matches[0]),$ucfirst,0,1);

	return $leadingws . $ucword;
}

/**
* UTF-8 aware substr_replace.
*/
function utf8_substr_replace($str, $repl, $start , $length = null )
{
	preg_match_all('/./us', $str, $ar);
	preg_match_all('/./us', $repl, $rar);

	if( $length === null )
	{
		$length = mb_strlen($str);
	}

	array_splice($ar[0], $start, $length, $rar[0]);

	return implode('', $ar[0]);
}
