<?php

if (!defined('IN_WACKO'))
{
	exit;
}

$wacko_language = [
	'name'					=> "Estonian",
	'code'					=> "et",
	'dir'					=> "ltr",
	'charset'				=> "utf-8",
	'locale'				=> "et_EE.UTF-8",
	'UPPER_P'				=> "A-Z\xc0-\xd6\xd8-\xdd",
	'LOWER_P'				=> "a-z\xdf-\xf6\xf8-\xfd\xff\/'",
	'ALPHA_P'				=> "A-Za-z\xc0-\xd6\xd8-\xdd\xdf-\xf6\xf8-\xfd\xff\_\-\/'",
	'TranslitLettersFrom'	=> "äąįāćåēčéźėģķīļņóōõüöłśūżÄĄĮĀĆÅĒČÉŹĖĢĶĪĻŅÓŌÕÜÖŁŚŪŻ",
	'TranslitLettersTo'		=> "aaiacaecezegkilnoooyolsuzAAIACAECEZEGKILNOOOYOLSUZ",
	'TranslitCaps'			=> "ĄĮĀĆÄÅØĘĒČÉŹĖĢĶĪĻŠŃŅÓŌÕÖ×ŲŁÜŚŪŻŽß",
	'TranslitSmall'			=> "ąįāćäåøęēčéźėģķīļšńņóōõö÷ųłüśūżž˙",
	'TranslitBiLetters'		=> ["ž"=>"zh", "š"=>"sh", "Ž"=>"Zh", "Š"=>"Sh", ],
];
