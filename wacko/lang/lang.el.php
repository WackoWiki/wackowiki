<?php

if (!defined('IN_WACKO'))
{
	exit;
}

$wacko_language = [
	'name'					=> "Greek",
	'code'					=> "el",
	'charset'				=> "utf-8",
	'locale'				=> "el_GR",
	'utfdecode'				=> [],
	//http://en.wikipedia.org/wiki/ISO-8859-7
	'UPPER_P'				=> "A-Z\xc1\xb6\xc2-\xc5\xb8\xc6\xc7\xb9\xc8\xc9\xba\xda\xca-\xcf\xbc\xd0-\xd5\xbe\xdb\xd6-\xd9\xbf",
	'LOWER_P'				=> "a-z\xe1\xdc\xe2-\xe5\xdd\xe6\xe7\xde\xe8\xe9\xdf\xfa\xc0\xea-\xef\xfc\xf0-\xf5\xfd\xfb\xe0\xf6-\xf9\xfe\/'",
	'ALPHA_P'				=> "A-Za-z\xb6\xb8-\xba\xbc\xbe-\xfe\/'",
	'TranslitLettersFrom'	=> "ΆΈΉΊΌΎΏΐΪΫάέήίΰϊϋόύώαβγδεζηικλμνοπρσςτυφχωΑΒΓΔΕΖΗΙΚΛΜΝΟΠΡΣΤΥΦΧΩ",
	'TranslitLettersTo'		=> "aehioywiiyaehiyiyoywavgdezhiklmnoprsstyfxwavgdezhiklmnoprstyfxw",
	'TranslitCaps'			=> "ΐΑΒΓΔΕ¨ΖΗΘΙΚΛΜΝΞΟΠΡ