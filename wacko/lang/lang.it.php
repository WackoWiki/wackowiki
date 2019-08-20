<?php

if (!defined('IN_WACKO'))
{
	exit;
}

$wacko_language = [
	'name'					=> "Italian",
	'code'					=> "it",
	'charset'				=> "utf-8",
	'locale'				=> ["it","it_IT","italian"],
	'UPPER_P'				=> "A-ZÀ-ÖØ-Ý",
	'LOWER_P'				=> "a-zß-öø-ýÿ\/''",
	'ALPHA_P'				=> "A-Za-zÀ-ÖØ-Ýß-öø-ýÿ\_\-\/'",
	'TranslitLettersFrom'	=> "àáâãåçèéêëìíîïñòóôõùúûýÞÀÁÂÃÅÇÈÉÊËÌÍÎÏÑÒÓÔÕÙÚÛÝþ",
	'TranslitLettersTo'		=> "aaaaaceeeeiiiinoooouuuyyAAAAACEEEEIIIINOOOOUUUYY",
	'TranslitCaps'			=> "ABCDEFGHIJKLMNOPQRSTUVWXYZÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝÞ",
	'TranslitSmall'			=> "abcdefghijklmnopqrstuvwxyzàáâãäåæçèéêëìíîïðñòóôõöøùúûüýþ",
	'TranslitBiLetters'		=> [
								"ä"=>"ae", "ñ"=>"ny", "ö"=>"oe", "ø"=>"oe", "ü"=>"ue", "æ"=>"ae", "Ä"=>"Ae",
								"Ñ"=>"Ny", "Ö"=>"Oe", "Ø"=>"Oe", "Ü"=>"Ue", "Æ"=>"Ae", "ÿ"=>"yu", "ß"=>"ss",
								],
];

