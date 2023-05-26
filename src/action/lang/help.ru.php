<?php

if (!defined('IN_WACKO'))
{
	exit;
}

$help = [

	'changes' =>
<<<EOD
Описание:
	Выводит список последних изменений в каком-либо кластере.

Usage:
	{{changes}}

Опции:
	[page="Cluster"]
	[date="YYYY-MM-DD"]
	[max=номер]
	[title=1]
	[noxml=1]
EOD,

	'edit' =>
<<<EOD
Описание:
	Позволяет включить линк на правку другой страницы.

Usage:
	{{edit}}

Опции:
	[page="ДругаяСтраница"]
	[text="your text"]
EOD,

];