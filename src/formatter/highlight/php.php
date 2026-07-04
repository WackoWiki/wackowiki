<?php

$tpl->language	= 'PHP';
$tpl->token		= 'cb-' . Ut::random_token(7);
$tpl->text = highlight_string($text, true);
