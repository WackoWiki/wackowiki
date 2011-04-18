<?php

if (!defined('IN_WACKO'))
{
	exit;
}

// Translit
$this->set_language($this->user_lang);
#$this->set_language($this->page_lang);
#$this->set_language($this->config['language']);

$NpjLettersFrom	= $this->language['NpjLettersFrom'];
$NpjLettersTo	= $this->language['NpjLettersTo'];
$NpjCaps		= $this->language['NpjCaps'];
$NpjSmall		= $this->language['NpjSmall'];
$NpjBiLetters	= $this->language['NpjBiLetters'];

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