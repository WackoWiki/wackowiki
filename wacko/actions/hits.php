<?php

// {{hits}}
// take $this->page['hits'] in the first place

if (isset($vars['for']))
{
	$tag = $this->unwrap_link( $vars['for'] );

	$rs = $this->load_all(
		"SELECT hits ".
		"FROM ".$this->config['table_prefix']."page ".
		"WHERE tag='".quote($this->dblink, $tag)."'"
	);

	if (isset($rs[0]['hits']))
	{
		echo $rs[0]['hits'];
	}
}
else
{
	echo $this->page['hits'];
}

?>