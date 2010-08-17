<?php

if (isset($vars['for']))
	$tag = $this->UnwrapLink( $vars['for'] );
else
	$tag = $this->tag;

	$rs = $this->LoadAll("SELECT hits FROM ".$this->config['table_prefix']."page WHERE tag='".quote($this->dblink, $tag)."'");

	echo $rs[0]["hits"];

?>