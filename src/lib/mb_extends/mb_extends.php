<?php

/*
 * additional multibyte string functions used throughout wackowiki
 */

if (!defined('IN_WACKO'))
{
	exit;
}

/*
 * The character list of the native trim(). The multibyte functions of PHP
 * 8.4 remove every Unicode space by default, the wiki keeps the smaller list
 * of the native trim() so that a page name is trimmed the same way as
 * before.
 */
const WACKO_TRIM_CHARACTERS = " \t\n\r\0\x0B";

/**
 * UTF-8 aware replacement for wordwrap().
 *
 * The text is broken at the given width. Without the cut a word that is
 * longer than the width is moved to the next line, with the cut it is
 * divided. The break is appended to the last line as well.
 *
 * @see https://php.net/wordwrap
 */
function utf8_wordwrap(string $string, int $width = 75, string $break = "\n", bool $cut = false): string
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

	return preg_replace($search, $replace, $string) ?? $string;
}

/**
 * UTF-8 aware replacement for ltrim().
 *
 * The character list holds literal characters. The range syntax of the
 * native ltrim() is not supported, a range is read as the characters it is
 * written with.
 *
 * @see https://php.net/ltrim
 */
function utf8_ltrim(?string $str, string|false $charlist = false): string
{
	$str ??= '';

	if ($charlist === false)
	{
		return mb_ltrim($str, WACKO_TRIM_CHARACTERS);
	}

	return mb_ltrim($str, $charlist);
}

/**
 * UTF-8 aware replacement for rtrim().
 *
 * The character list holds literal characters. The range syntax of the
 * native rtrim() is not supported, a range is read as the characters it is
 * written with.
 *
 * @see https://php.net/rtrim
 */
function utf8_rtrim(?string $str, string|false $charlist = false): string
{
	$str ??= '';

	if ($charlist === false)
	{
		return mb_rtrim($str, WACKO_TRIM_CHARACTERS);
	}

	return mb_rtrim($str, $charlist);
}

/**
 * UTF-8 aware replacement for str_pad().
 *
 * The padding may contain multibyte characters. The padding of the type
 * STR_PAD_BOTH is split evenly, the odd character goes to the right side.
 *
 * @see https://php.net/str_pad
 */
function utf8_str_pad(string $input, int $length, string $pad_str = ' ', int $type = STR_PAD_RIGHT): string
{
	$input_len = mb_strlen($input);

	if ($length <= $input_len)
	{
		return $input;
	}

	if ($pad_str === '')
	{
		return $input;
	}

	$pad_strlen	= mb_strlen($pad_str);
	$pad_len	= $length - $input_len;

	if ($type == STR_PAD_LEFT)
	{
		$repeat_times = ceil($pad_len / $pad_strlen);

		return mb_substr(str_repeat($pad_str, $repeat_times), 0, $pad_len) . $input;
	}

	if ($type == STR_PAD_BOTH)
	{
		$pad_len /= 2;
		$pad_amount_left	= floor($pad_len);
		$pad_amount_right	= ceil($pad_len);
		$repeat_times_left	= ceil($pad_amount_left / $pad_strlen);
		$repeat_times_right	= ceil($pad_amount_right / $pad_strlen);

		$padding_left		= mb_substr(str_repeat($pad_str, $repeat_times_left), 0, $pad_amount_left);
		$padding_right	= mb_substr(str_repeat($pad_str, $repeat_times_right), 0, $pad_amount_right);

		return $padding_left . $input . $padding_right;
	}

	if ($type != STR_PAD_RIGHT)
	{
		throw new ValueError('utf8_str_pad: Unknown padding type (' . $type . ')');
	}

	$repeat_times = ceil($pad_len / $pad_strlen);

	return mb_substr($input . str_repeat($pad_str, $repeat_times), 0, $length);
}

/**
 * UTF-8 aware replacement for trim().
 *
 * The character list holds literal characters. The range syntax of the
 * native trim() is not supported, a range is read as the characters it is
 * written with.
 *
 * @see https://php.net/trim
 */
function utf8_trim(?string $str, string|false $charlist = false): string
{
	$str ??= '';

	if ($charlist === false)
	{
		return mb_trim($str, WACKO_TRIM_CHARACTERS);
	}

	return mb_trim($str, $charlist);
}

/**
 * UTF-8 aware alternative to ucfirst().
 *
 * Make a string's first character uppercase.
 */
function utf8_ucfirst(string $str): string
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
 * UTF-8 aware alternative to ucwords().
 *
 * Uppercase the first character of each word in a string.
 *
 * @see https://php.net/ucwords
 */
function utf8_ucwords(string $str): string
{
	// Note: [\x0c\x09\x0b\x0a\x0d\x20] matches;
	// form feeds, horizontal tabs, vertical tabs, linefeeds and carriage returns
	// This corresponds to the definition of a "word" defined at http://www.php.net/ucwords
	$pattern = '/(^|([\x0c\x09\x0b\x0a\x0d\x20]+))([^\x0c\x09\x0b\x0a\x0d\x20]{1})[^\x0c\x09\x0b\x0a\x0d\x20]*/u';

	return preg_replace_callback($pattern, static function (array $matches): string {
		$leadingws	= $matches[2];
		$ucfirst	= mb_strtoupper($matches[3]);
		$ucword		= utf8_substr_replace(ltrim($matches[0]), $ucfirst, 0, 1);

		return $leadingws . $ucword;
	}, $str) ?? $str;
}

/**
 * UTF-8 aware substr_replace().
 */
function utf8_substr_replace(string $str, string $repl, int $start, ?int $length = null): string
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
 * UTF-8 aware count_chars().
 *
 * The keys of the result hold the character and not its byte value, so that
 * the count of a character can be read directly. A multibyte character is
 * not a byte value and is therefore not counted.
 *
 * @see http://php.net/count_chars
 */
function utf8_count_chars(string $string, int $mode = 0): array|string
{
	$result = array_fill(0, 256, 0);

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
 * UTF-8 aware replacement for str_word_count().
 *
 * Counts the number of words in the UTF-8 string. A word is a run of
 * letters, digits, hyphens and underscores.
 *
 * @see https://php.net/str_word_count
 */
function utf8_word_count(string $string): int
{
	$string	= preg_replace('/[^\p{L}\p{Nd}\-_]+/u', '-', $string);
	$string	= trim($string, '_-');

	if ($string === '')
	{
		return 0;
	}

	return count(explode('-', $string));
}
