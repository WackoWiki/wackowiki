<?php

if ($text == "") return;

$this->UseClass("typografica", "formatters/classes/");

$typo = &new typografica( $this );

// kuso@npj: since dashglued cause rendering bugs in Firefox, this option is now turned off.
$typo->settings["dashglue"] = false;

print $typo->correct($text, false);

?>
