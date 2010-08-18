<?php

if (isset($vars['for']))
	$tag = $this->unwrap_link( $vars['for'] );
else
	$tag = $this->tag;

	$rs = $this->load_all("SELECT hits FROM ".$this->config['table_prefix']."page WHERE tag='".quote($this->dblink, $tag)."'");

	echo $rs[0]["hits"];

?>