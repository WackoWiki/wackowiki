<?php

// Translit
$NpjLettersFrom = "���������������������";
$NpjLettersTo   = "abvgdeziklmnoprstufcy";
$NpjBiLetters = array(
      "�" => "jj", "�" => "jo", "�" => "zh", "�" => "kh", "�" => "ch", 
      "�" => "sh", "�" => "shh", "�" => "je", "�" => "ju", "�" => "ja",
      "�" => "", "�" => "",
);

$NpjCaps  = "�����Ũ��������������������������";
$NpjSmall = "��������������������������������";

$tag = $text;
//insert _ between words
$tag = preg_replace( "/\s+/ms", "_", $tag );

$tag = strtolower( $tag );
$tag = strtr( $tag, $NpjCaps, $NpjSmall );
$tag = strtr( $tag, $NpjLettersFrom, $NpjLettersTo );
$tag = strtr( $tag, $NpjBiLetters );

$tag = preg_replace("/[^a-z0-9_.]+/mi", "", $tag);

echo $tag;

?>