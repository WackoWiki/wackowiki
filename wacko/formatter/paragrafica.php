<?php

if (!defined('IN_WACKO'))
{
	exit;
}

// <p id="p1249-1" class="auto">
// <hX id="h1249-1" class="heading">

// this formatter WISELY replace <br>s with paragraphs.

// we got pure HTML on input.
$para	= new Paragrafica($this);
$result	= $para->correct($text);
$this->set_toc_array($para->toc);

echo $result;
