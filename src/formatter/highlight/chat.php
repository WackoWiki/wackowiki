<?php
/*
	Chat highlighter
	Supports various date-username-message chat log formats
	Installation: copy to /wacko/formatter/highlight/chat.php

	Usage:

	%%(chat)
	[12:04:34 01.05.2010] User: Message text by User.
	%%
 */

// defaults
if (!isset($options['type']))		$options['type']	= 'div';
if (!isset($options['user']))		$options['user']	= 0;

// sanitize $text
$text		= htmlspecialchars($text);

// replace text links to HMTL
$text		= preg_replace('/\b(https?|ftp|file|nntp|telnet):\/\/\S+/u', '<a href="\\0" target="_blank">\\0</a>', $text);
$pattern	= '/^[\[\(]([^\r\n\]\)]*)[\]\)]\s*(&lt;)?([^:\&\r\n]*)(&gt;)?\s*:?((?:(?!^[\[\(]).*(?:\r?\n)*)*)/um';

// split the $text into $matches: $1 - date, $3 - username, $5 - message
preg_match_all($pattern, $text, $matches, PREG_SET_ORDER);

// build the $names array of usernames in chat
$names	= [];
$c		= 1;

foreach($matches as $match)
{
	if (!array_key_exists($match[3], $names))
	{
		$names[$match[3]] = $c++;
	}
}

if ($options['type'] == 'div')
{
	$type = 'd';
}
else if ($options['type'] == 'table')
{
	$type = 't';
}

// HTML output:
$tpl->enter($type . '_n_');

foreach($matches as $log)
{
	$tpl->name	= $names[$log[3]];
	$tpl->time	= $log[1];
	$tpl->user	= $log[3];
	// replace \n to <br> to keep multiline messages
	$tpl->text	= str_replace("\n", '<br>', $log[5]);
}

$tpl->leave(); // d_ / t_

// show chat participants
if ($options['user'])
{
	ksort($names);
	$people = '';

	foreach($names as $name => $v)
	{
		$people .= $name . ', ';
	}

	$tpl->u_people = trim($people, ', ');
}

