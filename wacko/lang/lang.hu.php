<?php

if (!defined('IN_WACKO'))
{
	exit;
}

$wacko_language = [
	'name'					=> "Hungarian",
	'code'					=> "hu",
	'charset'				=> "utf-8",
	'locale'				=> "hu_HU",
	'utfdecode'				=> [],
	'UPPER_P'				=> "A-Z\xa1\xa3\xa5\xa6\xa9-\xac\xae\xaf\xc0-\xd6\xd8-\xde",
	'LOWER_P'				=> "a-z\xb1\xb3\xb5\xb6\xb9-\xbc\xbe\xbf\xdf-\xf6\xf8-\xfe\/'",
	'ALPHA_P'				=> "A-Za-z\xa1\xa3\xa5\xa6\xa9-\xac\xae\xaf\xb1\xb3\xb5\xb6\xb9-\xbc\xbe-\xd6\xd8-\xf6\xf8-\xfe\_\-\/'",
	'TranslitLettersFrom'	=> "ÁÂÇÉËÍÎÓÔÚÝáâçéëíîóôúýĂăĄąĆćČčĎďĐđĘęĚěĹĺĽľŁłŃńŇňŐőŔŕŘřŚśŞşŠšŢţŤťŮůŰűŹźŻżŽž",
	'TranslitLettersTo'		=> "AACEEIIOOUYaaceeiioouyAaAaCcCcDdDdEeEeLlLlLlNnNnOoRrRrSsSsSsTtTtUuUuZzZzZz",
	'TranslitCaps'			=> "ŔÁÂĂÄĹ¨ĆÇČÉĘËĚÍÎĎĐŃŇÓÔŐÖ×ŘŮÜÚŰÝŢß",
	'TranslitSmall'			=> "ŕáâăäĺ¸ćçčéęëěíîďđńňóôőö÷řůüúűýţ˙",
	'TranslitBiLetters'		=> [
								"ä"=>"ae", "ö"=>"oe", "ü"=>"ue", "Ä"=>"Ae",
								"Ö"=>"Oe", "Ü"=>"Ue", "ß"=>"ss",
								],
];

?>