<?php

if ($vars[0] && $vars[0] != $vars["nomark"])
	$tag = $this->UnwrapLink( $vars[0] );
else
	$tag = $this->tag;

	$rs = $this->LoadAll("SELECT hits FROM ".$this->config["table_prefix"]."pages WHERE tag='".quote($this->dblink, $tag)."'");

	echo $rs[0]["hits"];

?>