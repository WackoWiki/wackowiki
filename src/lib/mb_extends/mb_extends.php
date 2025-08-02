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
	if ($cut)
	{
		// Match anything 1 to $width chars long followed by whitespace or EOS,
		// otherwise match anything $width chars long
		$search		= '/(.{1,' . $width . '})(?:\s|$)|(.{' . $width . '})/uS';
		$replace	= '$1$2' . $break;
	}
	else
	{
		// Anchor the beginning of the pattern with a lookahead
		// to avoid crazy backtracking when words are longer than $width
		$search		= '/(?=\s)(.{1,' . $width . '})(?:\s|$)/uS';
		$replace	= '$1' . $break;
	}

	return preg_replace($search, $replace, $string);
}

// taken from phputf8 https://sourceforge.net/projects/phputf8/

/**
* UTF-8 aware replacement for ltrim()
* Note: you only need to use this if you are supplying the charlist
* optional arg and it contains UTF-8 characters. Otherwise, ltrim will
* work normally on a UTF-8 string
* @see https://www.php.net/ltrim
* @return string
*/
function utf8_ltrim($str, $charlist = false)
{
	if ($charlist === false)
	{
		return ltrim($str);
	}

	// quote charlist for use in a characterclass
	$charlist = preg_replace('!([\\\\\\-\\]\\[/^])!', '\\\${1}', $charlist);

	return preg_replace('/^[' . $charlist . ']+/u', '', $str);
}

/**
* UTF-8 aware replacement for rtrim()
* Note: you only need to use this if you are supplying the charlist
* optional arg and it contains UTF-8 characters. Otherwise, rtrim will
* work normally on a UTF-8 string
* @see https://www.php.net/rtrim
* @return string
*/
function utf8_rtrim($str, $charlist = false)
{
	if (!isset($str))	$str	= '';

	if ($charlist === false)
	{
		return rtrim($str);
	}

	// quote charlist for use in a characterclass
	$charlist = preg_replace('!([\\\\\\-\\]\\[/^])!', '\\\${1}', $charlist);

	return preg_replace('/[' . $charlist . ']+$/u', '', $str);
}

/**
* Replacement for str_pad. $pad_str may contain multibyte characters.
* @param string $input
* @param int $length
* @param string $pad_str
* @param int $type ( same constants as str_pad )
* @return string
* @see https://www.php.net/str_pad
*/
function utf8_str_pad($input, $length, $pad_str = ' ', $type = STR_PAD_RIGHT)
{
	$input_len = mb_strlen($input);

	if ($length <= $input_len)
	{
		return $input;
	}

	$pad_strlen	= mb_strlen($pad_str);
	$pad_len	= $length - $input_len;

	if ($type == STR_PAD_RIGHT)
	{
		$repeat_times = ceil($pad_len / $pad_strlen);

		return mb_substr($input . str_repeat($pad_str, $repeat_times), 0, $length);
	}

	if ($type == STR_PAD_LEFT)
	{
		$repeat_times = ceil($pad_len / $pad_strlen);

		return mb_substr(str_repeat($pad_str, $repeat_times), 0, floor($pad_len)) . $input;
	}

	if ($type == STR_PAD_BOTH)
	{
		$pad_len/= 2;
		$pad_amount_left	= floor($pad_len);
		$pad_amount_right	= ceil($pad_len);
		$repeat_times_left	= ceil($pad_amount_left / $pad_strlen);
		$repeat_times_right	= ceil($pad_amount_right / $pad_strlen);

		$padding_left		= mb_substr(str_repeat($pad_str, $repeat_times_left), 0, $pad_amount_left);
		$padding_right		= mb_substr(str_repeat($pad_str, $repeat_times_right), 0, $pad_amount_left);

		return $padding_left . $input . $padding_right;
	}

	trigger_error('utf8_str_pad: Unknown padding type (' . $type . ')',E_USER_ERROR);
}

/**
* UTF-8 aware replacement for trim()
* Note: you only need to use this if you are supplying the charlist
* optional arg and it contains UTF-8 characters. Otherwise, trim will
* work normally on a UTF-8 string
* @see https://www.php.net/trim
* @return string
*/
function utf8_trim($str, $charlist = false)
{
	if ($charlist === false)
	{
		return trim($str);
	}

	return utf8_ltrim(utf8_rtrim($str, $charlist), $charlist);
}

/**
* UTF-8 aware alternative to ucfirst
* Make a string's first character uppercase
* @param string $str
* @return string with first character as upper case (if applicable)
*/
function utf8_ucfirst($str)
{
	switch (mb_strlen($str))
	{
		case 0:
			return '';
		case 1:
			return mb_strtoupper($str);
		default:
			preg_match('/^(.)(.*)$/us', $str, $matches);
			return mb_strtoupper($matches[1]) . $matches[2];
	}
}

/**
* UTF-8 aware alternative to ucwords
* Uppercase the first character of each word in a string
* Note: requires utf8_substr_replace
* @param string
* @return string with first char of each word uppercase
* @see https://www.php.net/ucwords
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

	if ($length === null)
	{
		$length = mb_strlen($str);
	}

	array_splice($ar[0], $start, $length, $rar[0]);

	return implode('', $ar[0]);
}

/**
* UTF-8 aware count_chars.
* @see http://www.php.net/count_chars
* taken from https://www.php.net/manual/en/function.count-chars.php#118726
*/
function utf8_count_chars($string, $mode = 0)
{
	$result =  array_fill(0, 256, 0);

	for ($i = 0, $size = mb_strlen($string); $i < $size; $i++)
	{
		$char = mb_substr($string, $i, 1);
		if (strlen($char) > 1)
		{
			continue;
		}

		$code = ord($char);
		if ($code >= 0 && $code <= 255)
		{
			$result[$code]++;
		}
	}

	switch ($mode)
	{
		case 1: // same as 0 but only byte-values with a frequency greater than zero are listed.
			foreach ($result as $key => $value)
			{
				if ($value == 0)
				{
					unset($result[$key]);
				}
			}
			break;
		case 2: // same as 0 but only byte-values with a frequency equal to zero are listed.
			foreach ($result as $key => $value)
			{
				if ($value > 0)
				{
					unset($result[$key]);
				}
			}
			break;
		case 3: // a string containing all unique characters is returned.
			$build_string = '';
			foreach ($result as $key => $value)
			{
				if ($value > 0)
				{
					$build_string .= chr($key);
				}
			}
			return $build_string;
		case 4: // a string containing all not used characters is returned.
			$build_string = '';
			foreach ($result as $key => $value)
			{
				if ($value == 0)
				{
					$build_string .= chr($key);
				}
			}
			return $build_string;
	}

	// change key names...
	foreach ($result as $key => $value)
	{
		$result[chr($key)] = $value;
		unset($result[$key]);
	}

	return $result;
}

/**
* UTF-8 aware replacement for str_word_count()
* Counts number of words in the UTF-8 string
* @param    string $string The input string
* @return   int The number of words in the string
* @see https://www.php.net/str_word_count
*/
function utf8_word_count($string)
{
	$string	= preg_replace( '/[^\\p{L}\\p{Nd}\-_]+/u' , '-' , $string );
	$string	= trim( $string , '_-' );

	return count( explode( '-' , $string ) );
}
