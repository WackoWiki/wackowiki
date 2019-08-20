<?php

if (!defined('IN_WACKO'))
{
	exit;
}

$wacko_language = [
	'name'					=> "Russian",
	'code'					=> "ru",
	'charset'				=> "utf-8",
	'locale'				=> ["ru_RU","russian","ru_SU","ru"],
	'utfdecode'				=> [],
	'UPPER_P'				=> "A-Z\xc0-\xdf\xa8",
	'LOWER_P'				=> "a-z\xe0-\xff\xb8\/\'",
	'ALPHA_P'				=> "A-Za-z\xc0-\xff\xa8\xb8\_\/\'",
	'TranslitLettersFrom'	=> "абвгдезиклмнопрстуфхъьцыАБВГДЕЗИКЛМНОПРСТУФХЪЬЦЫ",
	'TranslitLettersTo'		=> "abvgdeziklmnoprstufx__cyABVGDEZIKLMNOPRSTUFX__CY",
	'TranslitCaps'			=> "АБВГДЕЁЖЗИЙКЛМНОПРСТУФХЦЧШЩЬЪЫЭЮЯ",
	'TranslitSmall'			=> "абвгдеёжзийклмнопрстуфхцчшщьъыэюя",
	'TranslitBiLetters'		=> [
								"й" => "jj", "ё" => "jo", "ж" => "zh", "ч" => "ch",
								"ш" => "sh", "щ" => "shh", "э" => "je", "ю" => "ju", "я" => "ja",
								"Й" => "Jj", "Ё" => "Jo", "Ж" => "Zh", "Ч" => "Ch",
								"Ш" => "Sh", "Щ" => "Shh", "Э" => "Je", "Ю" => "Ju", "Я" => "Ja",
								],
];

?>