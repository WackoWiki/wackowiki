<?php

/*
 * str_replace('%1', ...) replacer:
 * i.e. perc_replace('one = %1, three = %3, two = %2', 11, 22, 33)
 */
function perc_replace()
{
	$args = func_get_args();
	return preg_replace_callback('/%[1-9]/', function ($x) use ($args) { return ($i = $x[0][1]) < count($args)? $args[$i] : $x[0]; }, $args[0]);
}

