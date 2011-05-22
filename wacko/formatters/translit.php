<?php

if (!defined('IN_WACKO'))
{
	exit;
}

// Translit
$this->set_language($this->user_lang);
#$this->set_language($this->page_lang);
#$this->set_language($this->config['language']);

$TranslitLettersFrom	= $this->language['TranslitLettersFrom'];
$TranslitLettersTo	= $this->language['TranslitLettersTo'];
$TranslitCaps		= $this->language['TranslitCaps'];
$TranslitSmall		= $this->language['TranslitSmall'];
$TranslitBiLetters	= $this->language['TranslitBiLetters'];

$tag = $text;
//insert _ between words
$tag = preg_replace( '/\s+/ms', '_', $tag );

$tag = strtolower( $tag );
$tag = strtr( $tag, $TranslitCaps, $TranslitSmall );
$tag = strtr( $tag, $TranslitLettersFrom, $TranslitLettersTo );
$tag = strtr( $tag, $TranslitBiLetters );

$tag = preg_replace('/[^a-z0-9_.]+/mi', '', $tag);

echo $tag;

?>