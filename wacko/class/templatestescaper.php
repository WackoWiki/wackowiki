<?php

// with gratitides took from bsd licensed Zend Framework (http://framework.zend.com/)

class TemplatestEscaper
{
    protected static $encoding = 'utf-8';

	// lowest common denominator as of HTML5's XML Serialisation 
    protected static $htmlNamedEntityMap =
	[
        34 => 'quot',         // quotation mark
        38 => 'amp',          // ampersand
        60 => 'lt',           // less-than sign
        62 => 'gt',           // greater-than sign
    ];

    // List of all encoding supported by htmlspecialchars
    protected static $supportedEncodings =
	[
        'iso-8859-1',   'iso8859-1',    'iso-8859-5',   'iso8859-5',
        'iso-8859-15',  'iso8859-15',   'utf-8',        'cp866',
        'ibm866',       '866',          'cp1251',       'windows-1251',
        'win-1251',     '1251',         'cp1252',       'windows-1252',
        '1252',         'koi8-r',       'koi8-ru',      'koi8r',
        'big5',         '950',          'gb2312',       '936',
        'big5-hkscs',   'shift_jis',    'sjis',         'sjis-win',
        'cp932',        '932',          'euc-jp',       'eucjp',
        'eucjp-win',    'macroman'
    ];


    static function setEncoding($encoding)
    {
		$encoding = (string) $encoding;
		if ($encoding === '')
		{
			throw new Exception\InvalidArgumentException(
				__CLASS__ . ' constructor parameter does not allow a blank value'
			);
		}

		$encoding = strtolower($encoding);
		if (!in_array($encoding, static::$supportedEncodings))
		{
			throw new Exception\InvalidArgumentException(
				'Value of \'' . $encoding . '\' passed to ' . __CLASS__
				. ' constructor parameter is invalid. Provide an encoding supported by htmlspecialchars()'
			);
		}

		static::$encoding = $encoding;
    }

    static function getEncoding()
    {
        return static::$encoding;
    }

    static function escapeHtml($string)
    {
        return htmlspecialchars($string, ENT_QUOTES | ENT_SUBSTITUTE, static::$encoding);
    }

    static function escapeHtmlAttr($string)
    {
        $string = static::toUtf8($string);
        if ($string === '' || ctype_digit($string)) {
            return $string;
        }

        $result = preg_replace_callback('/[^a-z0-9,\.\-_]/iSu',
			function ($matches)
			{
				$chr = $matches[0];
				$ord = ord($chr);

				/**
				 * The following replaces characters undefined in HTML with the
				 * hex entity for the Unicode replacement character.
				 */
				if (($ord <= 0x1f && $chr != "\t" && $chr != "\n" && $chr != "\r")
					|| ($ord >= 0x7f && $ord <= 0x9f)
				) {
					return '&#xFFFD;';
				}

				/**
				 * Check if the current character to escape has a name entity we should
				 * replace it with while grabbing the integer value of the character.
				 */
				if (strlen($chr) > 1) {
					$chr = static::convertEncoding($chr, 'UTF-32BE', 'UTF-8');
				}

				$hex = bin2hex($chr);
				$ord = hexdec($hex);
				if (isset(static::$htmlNamedEntityMap[$ord]))
				{
					return '&' . static::$htmlNamedEntityMap[$ord] . ';';
				}

				/**
				 * Per OWASP recommendations, we'll use upper hex entities
				 * for any other characters where a named entity does not exist.
				 */
				if ($ord > 255) {
					return sprintf('&#x%04X;', $ord);
				}

				return sprintf('&#x%02X;', $ord);
			}, $string);

        return static::fromUtf8($result);
    }

    static function escapeJs($string)
    {
        $string = static::toUtf8($string);
        if ($string === '' || ctype_digit($string)) {
            return $string;
        }

        $result = preg_replace_callback('/[^a-z0-9,\._]/iSu',
			function ($matches)
			{
				$chr = $matches[0];
				if (strlen($chr) == 1)
				{
					return sprintf('\\x%02X', ord($chr));
				}
				$chr = static::convertEncoding($chr, 'UTF-16BE', 'UTF-8');
				$hex = strtoupper(bin2hex($chr));
				if (strlen($hex) <= 4)
				{
					return sprintf('\\u%04s', $hex);
				}
				$highSurrogate = substr($hex, 0, 4);
				$lowSurrogate = substr($hex, 4, 4);
				return sprintf('\\u%04s\\u%04s', $highSurrogate, $lowSurrogate);
			}, $string);

        return static::fromUtf8($result);
    }

    static function escapeUrl($string)
    {
        return rawurlencode($string);
    }

    static function escapeCss($string)
    {
        $string = static::toUtf8($string);
        if ($string === '' || ctype_digit($string)) {
            return $string;
        }

        $result = preg_replace_callback('/[^a-z0-9]/iSu',
			function ($matches)
			{
				$chr = $matches[0];
				if (strlen($chr) == 1)
				{
					$ord = ord($chr);
				}
				else
				{
					$chr = static::convertEncoding($chr, 'UTF-32BE', 'UTF-8');
					$ord = hexdec(bin2hex($chr));
				}
				return sprintf('\\%X ', $ord);
			}, $string);

        return static::fromUtf8($result);
    }

    static protected function toUtf8($string)
    {
        if (static::getEncoding() === 'utf-8')
		{
            $result = $string;
        }
		else
		{
            $result = static::convertEncoding($string, 'UTF-8', static::getEncoding());
        }

        if (!static::isUtf8($result))
		{
            throw new Exception\RuntimeException(
                sprintf('String to be escaped was not valid UTF-8 or could not be converted: %s', $result)
            );
        }

        return $result;
    }

    static protected function fromUtf8($string)
    {
        if (static::getEncoding() === 'utf-8')
		{
            return $string;
        }

        return static::convertEncoding($string, static::getEncoding(), 'UTF-8');
    }

    static protected function isUtf8($string)
    {
        return ($string === '' || preg_match('/^./su', $string));
    }

    static protected function convertEncoding($string, $to, $from)
    {
        if (function_exists('iconv'))
		{
            $result = iconv($from, $to, $string);
        }
		else if (function_exists('mb_convert_encoding'))
		{
            $result = mb_convert_encoding($string, $to, $from);
        }
		else
		{
            throw new Exception\RuntimeException(
                __CLASS__
                . ' requires either the iconv or mbstring extension to be installed'
                . ' when escaping for non UTF-8 strings.'
            );
        }

        if ($result === false) {
            return ''; // return non-fatal blank string on encoding errors from users
        }

        return $result;
    }
}
