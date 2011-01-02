<?php

// bbcode parsing class
class bbcode
{
	var $object;

	function __construct(&$object)
	{
		$this->object	= &$object;
		// this template is equally applicable to the "raw" bbcode
		// markup (as it's stored in the phpBB DB) as to the "user" markup
		$this->template	= '/('.
						  '\"\".*?\"\"|'.
						  '\\[b(?:\:[\\w]+?)??\\].*?\\[\/b(?:\:[\\w]+?)??\\]|'.
						  '\\[i(?:\:[\\w]+?)??\\].*?\\[\/i(?:\:[\\w]+?)??\\]|'.
						  '\\[u(?:\:[\\w]+?)??\\].*?\\[\/u(?:\:[\\w]+?)??\\]|'.
						  '\\[quote(?:\:[\\w]+?)??(?:="[\\w]+?")*\\]|\\[\/quote(?:\:[\\w]+?)??\\][\n\r]*|'.
						  '\\[url(?:=.+?)*\\].+?\\[\/url\\]|'.
						  '\\[img(?:\:[\\w]+?)??\\].+?\\[\/img(?:\:[\\w]+?)??\\]|'.
						  '\\[code(?:\:[:\\w]+?)??\\].*?\\[\/code(?:\:[:\\w]+?)??\\]|'.
						  '\\[size\=[\\d]+?(?:\:[\\w]+?)??\\].*?\\[\/size(?:\:[\\w]+?)??\\]|'.
						  '\\[color\=[\\#]??[\\w]+?(?:\:[\\w]+?)??\\].*?\\[\/color(?:\:[\\w]+?)??\\]|'.
						  '\\[list(?:\=\\w)??(?:\:[\\w]+?)??\\].*?\\[\/list(?:\:[:\\w]+?)??\\][\n\r]*'.
						  ')/sm';
	}

	function wrapper($input)
	{
		$engine		= &$this->object;
		$rewrite	= array(&$this, 'wrapper');
		$string		= $input[1];

		// ignore
		if (preg_match('/^\"\"(.*)\"\"$/s', $string, $substring))
		{
			return '""'.$substring[1].'""';
		}
		// bold
		if (preg_match('/^\\[b(?:\:[\\w]+?)??\\](.*)\\[\/b(?:\:[\\w]+?)??\\]$/s', $string, $substring))
		{
			return '**'.str_replace('**', '""**""', preg_replace_callback($this->template, $rewrite, $substring[1])).'**';
		}
		// italic
		if (preg_match('/^\\[i(?:\:[\\w]+?)??\\](.*)\\[\/i(?:\:[\\w]+?)??\\]$/s', $string, $substring))
		{
			return '//'.str_replace('//', '""//""', preg_replace_callback($this->template, $rewrite, $substring[1])).'//';
		}
		// underline
		if (preg_match('/^\\[u(?:\:[\\w]+?)??\\](.*)\\[\/u(?:\:[\\w]+?)??\\]$/s', $string, $substring))
		{
			return '__'.str_replace('__', '""__""', preg_replace_callback($this->template, $rewrite, $substring[1])).'__';
		}
		// superscript
		if (preg_match('/^\\[sup\\](.*)\\[\/sup\\]$/s', $string, $substring))
		{
			return '^^'.str_replace('^^', '""^^""', preg_replace_callback($this->template, $rewrite, $substring[1])).'^^';
		}
		// subscript
		if (preg_match('/^\\[sub\\](.*)\\[\/sub\\]$/s', $string, $substring))
		{
			return 'vv'.str_replace('vv', '""vv""', preg_replace_callback($this->template, $rewrite, $substring[1])).'vv';
		}
		// code
		if (preg_match('/^\\[code(?:\:[:\\w]+?)??\\](.*)\\[\/code(?:\:[:\\w]+?)??\\]$/s', $string, $substring))
		{
			return "%%\n".$substring[1]."\n%%";
		}
		// open quote
		else if (preg_match('/\\[quote(?:\:[\\w]+?)??(?:="([\\w]+?)")??\\]/s', $string, $substring))
		{
			return '<[ '.($substring[1] ? '**//'.$substring[1]."://**\n" : '');
		}
		// close quote
		else if (preg_match('/\\[\/quote(?:\:[\\w]+?)??\\][\n\r]*/s', $string, $substring))
		{
			return "\n ]>\n";
		}
		// lists
		else if (preg_match('/[\n\r]??\\[list(?:\=(\\w))??(?:\:[\\w]+?)??\\][\n\r]+(.*?)\\[\/list(?:\:[:\\w]+?)??\\][\n\r]??/s', $string, $substring))
		{
			if		($substring[1] == '1')		$mark = '  1. ';
			else if ($substring[1] == 'a')		$mark = '  a. ';
			else if ($substring[1] == 'A')		$mark = '  a. ';
			else								$mark = '  * ';

			$substring[2] = preg_replace('/\\[\\*(?:\:[\\w]+?)??\\]/', $mark, $substring[2]);

			return preg_replace_callback($this->template, $rewrite, $substring[2])."\n";
		}
		// simple url or image
		else if (preg_match('/\\[(?:url|img)(?:\:[\\w]+?)??\\](http:\/\/|https:\/\/|ftp:\/\/|nntp:\/\/)+(.+?)\\[\/(?:url|img)(?:\:[\\w]+?)??\\]/s', $string, $substring))
		{
			return $substring[1].$substring[2];
		}
		// url with text
		else if (preg_match('/\\[url=(http:\/\/|https:\/\/|ftp:\/\/|nntp:\/\/)+(.+?)\\](.+?)\\[\/url\\]/s', $string, $substring))
		{
			return '[['.$substring[1].$substring[2].' '.$substring[3].']]';
		}
		// font size
		else if (preg_match('/\\[size\=([\\d]+?)(?:\:[\\w]+?)??\\](.*?)\\[\/size(?:\:[\\w]+?)??\\]/s', $string, $substring))
		{
			if		($substring[1] < 13)	return '++'.str_replace('++', '', preg_replace_callback($this->template, $rewrite, $substring[2])).'++';
			else if ($substring[1] > 15)	return '**'.str_replace(array('**', '[b]', '[/b]'), '', preg_replace_callback($this->template, $rewrite, $substring[2])).'**';
			else							return		$substring[2];
		}
		// font color
		else if (preg_match('/\\[color=(\\#)??([\\w]+?)(?:\:[\\w]+?)??\\](.*?)\\[\/color(?:\:[\\w]+?)??\\]/s', $string, $substring))
		{
			if (!$substring[1])
			{
				if		(stristr($substring[2], 'red')		== true)	return '!!'.preg_replace_callback($this->template, $rewrite, $substring[3]).'!!';
				else if	(stristr($substring[2], 'green')	== true)	return '!!(green)'.preg_replace_callback($this->template, $rewrite, $substring[3]).'!!';
				else if	(stristr($substring[2], 'blue')		== true)	return '!!(blue)'.preg_replace_callback($this->template, $rewrite, $substring[3]).'!!';
				else if	(stristr($substring[2], 'grey')		== true)	return '!!(grey)'.preg_replace_callback($this->template, $rewrite, $substring[3]).'!!';
			}
			else if (preg_match('/^([a-fA-F0-9]{2})([a-fA-F0-9]{2})([a-fA-F0-9]{2})$/', $substring[2], $color))
			{
				$r = hexdec($color[1]);
				$g = hexdec($color[2]);
				$b = hexdec($color[3]);

				if		($r == $g && $r == $b)	return '!!(grey)'.preg_replace_callback($this->template, $rewrite, $substring[3]).'!!';
				else if	($r >= $g && $r >= $b)	return '!!'.preg_replace_callback($this->template, $rewrite, $substring[3]).'!!';
				else if	($g >= $r && $g >= $b)	return '!!(green)'.preg_replace_callback($this->template, $rewrite, $substring[3]).'!!';
				else if	($b >= $r && $b >= $g)	return '!!(blue)'.preg_replace_callback($this->template, $rewrite, $substring[3]).'!!';
			}
			return preg_replace_callback($this->template, $rewrite, $substring[3]);
		}
		return $string;
	}
}

?>