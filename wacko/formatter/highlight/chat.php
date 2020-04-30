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

if (!isset($options['type']))		$options['type']	= 'div';
if (!isset($options['user']))		$options['user']	= 0;

// sanitize $text
$text		= htmlspecialchars($text);
$output		= '';

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

// HTML output:
foreach($matches as $log)
{
	if ($options['type'] == 'div')
	{
		$output .=
			'<div class="chat chat-u'. $names[$log[3]] .'">' .
				'[' . $log[1] . '] <span class="chat-user">' . $log[3] . '</span>: ' . $log[5] .
			'</div>';
	}
	else if ($options['type'] == 'table')
	{
		$output .=
			'<tr class="chat-u'. $names[$log[3]] .'">' .
				'<td class="chat-user">' . $log[3] . '</td>' .
				'<td class="chat-text">' . $log[5] . '</td>' .
				'<td class="chat-time">' . $log[1] . '</td>' .
			'</tr>';
	}
}

// replace \n to <br> to keep multiline messages
$output = str_replace("\n", '<br>', $output);

// show chat participants
if ($options['user'])
{
	ksort($names);
	$people = '';

	foreach($names as $name => $v)
	{
		$people .= $name . ', ';
	}

	echo '<p><b>' . trim($people, ', ') . ':</b></p>';
}

if ($options['type'] == 'div')
{
	echo '<div class="chat">' . $output . '</div>';
}
else if ($options['type'] == 'table')
{
	echo '<div><table class="chat">' . $output . '</table></div>';
}

