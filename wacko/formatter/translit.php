<?php

if (!defined('IN_WACKO'))
{
	exit;
}

// Translit
if (isset($this->user_lang))
{
	$this->set_language($this->user_lang);
}
else
{
	#$this->set_language($this->page_lang);
	$this->set_language($this->db->language);
}

$TranslitLettersFrom	= $this->language['TranslitLettersFrom'];
$TranslitLettersTo		= $this->language['TranslitLettersTo'];
$TranslitCaps			= $this->language['TranslitCaps'];
$TranslitSmall			= $this->language['TranslitSmall'];
$TranslitBiLetters		= $this->language['TranslitBiLetters'];

$tag = $text;

//insert _ between words
$tag = preg_replace('/\s+/ms', '_', $tag);

$tag = mb_strtolower($tag);
$tag = mb_strtr($tag, $TranslitCaps, $TranslitSmall);
$tag = mb_strtr($tag, $TranslitLettersFrom, $TranslitLettersTo);
$tag = mb_strtr($tag, $TranslitBiLetters);

$tag = preg_replace('/[^a-z0-9_.]+/mi', '', $tag);

echo $tag;
