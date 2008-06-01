<?php

if ($vars[0] && $vars[0]!=$vars["nomark"])
$tag = $this->UnwrapLink( $vars[0] );
else
$tag = $this->getPageTag();

$rs = $this->LoadAll("select hits from ".$this->config["table_prefix"]."pages where tag='".quote($this->dblink, $tag)."'");

echo $rs[0]["hits"];

?>