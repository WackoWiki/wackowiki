<?php

if (!defined('IN_WACKO'))
{
	exit;
}

$options['strip_marker'] ??= false;

$parser = new PostWacko($this, $options);

echo $parser->format(
	$text ?? '',
	(bool) $options['strip_marker']
);
