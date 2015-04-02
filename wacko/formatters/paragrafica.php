<?php

if (!defined('IN_WACKO'))
{
	exit;
}

//     <p class="auto" id="p1249-1">
//     <hX id="h1249-1>

// this formatter WISELY replace <BR>s with paragraphs.

$this->use_class('paragrafica', 'formatters/classes/');

// we got pure HTML on input.
$para	= new paragrafica( $this );
$result	= $para->correct($text);
$this->set_toc_array($para->toc);

echo $result;

?>