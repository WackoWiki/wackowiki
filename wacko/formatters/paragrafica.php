<?php
//     <a name="p1249-1"></a><p...>
//     <a name="h1249-1"></a><hX..>

// this formatter WISELY replace <BR>s with paragraphs.

$this->use_class('paragrafica', 'formatters/classes/');

// we got pure HTML on input.
$para = new paragrafica( $this );
$result = $para->correct($text);
$this->set_toc_array($para->toc);

echo $result;

?>