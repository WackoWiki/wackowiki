<?php

$this->UseClass("post_wacko", "formatters/classes/");

$parser = &new post_wacko( $this, $options );

$text = preg_replace_callback("/(\¢\¢(\S+?)([^\n]*?)==([^\n]*?)\¯\¯|\¡\¡[^\n]+?\¡\¡)/sm",
array( &$parser, "postcallback"), $text);

if ( !isset( $options["stripnotypo"] ) ) $options["stripnotypo"] = "";

if ( $options["stripnotypo"] ) {
	$text = str_replace("<!--notypo-->", "", $text);
	$text = str_replace("<!--/notypo-->", "", $text);
}

print($text);

?>
