<?php

if (!defined('IN_WACKO'))
{
	exit;
}

// Translit
$NpjLettersFrom	= $this->language['NpjLettersFrom'];
#$NpjLettersFrom	= "��������������������";
$NpjLettersTo	= $this->language['NpjLettersTo'];
#$NpjLettersTo	= "abvgdeziklmnoprstufy";
$NpjBiLetters	= $this->language['NpjBiLetters'];
/*$NpjBiLetters	= array(
	"�" => "jj", "�" => "jo", "�" => "zh", "�" => "kh", "�" => "ch",
	"�"=>"oe", "�" => "sh", "�" => "shh", "�" => "je", "�" => "ju",
	 "�" => "ja", "�" => "", "�" => "ue",
);*/
$NpjCaps	= $this->language['NpjCaps'];
#$NpjCaps		= "�����Ũ��������������������������";
$NpjSmall	= $this->language['NpjSmall'];
#$NpjSmall		= "��������������������������������";

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