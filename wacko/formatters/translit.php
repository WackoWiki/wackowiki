<?php

// Translit
$NpjLettersFrom = "אבגדהוחטךכלםמןנסעףפצû";
$NpjLettersTo   = "abvgdeziklmnoprstufcy";
$NpjBiLetters = array(
	"י" => "jj", "¸" => "jo", "ז" => "zh", "ץ" => "kh", "ק" => "ch",
	"ר" => "sh", "ש" => "shh", "‎" => "je", "‏" => "ju", "ÿ" => "ja",
	"ת" => "", "ü" => "",
);

$NpjCaps  = "ÀÁÂÃÄÅ¨ÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖ×ØÙÜÚÛÝÞ‗";
$NpjSmall = "אבגדהו¸זחטיךכלםמןנסעףפץצקרשüתû‎‏ÿ";

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