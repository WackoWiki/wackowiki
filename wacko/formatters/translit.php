<?php

if (!defined('IN_WACKO'))
{
	exit;
}

// Translit
$NpjLettersFrom	= $this->language['NpjLettersFrom'];
#$NpjLettersFrom	= "אבגדהוחטךכלםמןנסעףפû";
$NpjLettersTo	= $this->language['NpjLettersTo'];
#$NpjLettersTo	= "abvgdeziklmnoprstufy";
$NpjBiLetters	= $this->language['NpjBiLetters'];
/*$NpjBiLetters	= array(
	"י" => "jj", "¸" => "jo", "ז" => "zh", "ץ" => "kh", "ק" => "ch",
	"צ"=>"oe", "ר" => "sh", "ש" => "shh", "‎" => "je", "‏" => "ju",
	 "ÿ" => "ja", "ת" => "", "ü" => "ue",
);*/
$NpjCaps	= $this->language['NpjCaps'];
#$NpjCaps		= "ÀÁÂÃÄÅ¨ÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖ×ØÙÜÚÛÝÞ‗";
$NpjSmall	= $this->language['NpjSmall'];
#$NpjSmall		= "אבגדהו¸זחטיךכלםמןנסעףפץצקרשüתû‎‏ÿ";

$tag = $text;
//insert _ between words
$tag = preg_replace( '/\s+/ms', '_', $tag );

$tag = strtolower( $tag );
$tag = strtr( $tag, $NpjCaps, $NpjSmall );
$tag = strtr( $tag, $NpjLettersFrom, $NpjLettersTo );
$tag = strtr( $tag, $NpjBiLetters );

$tag = preg_replace('/[^a-z0-9_.]+/mi', '', $tag);

echo $tag;

?>