<?php

if (!defined('IN_WACKO'))
{
	exit;
}

$help = [

	'changes' =>
<<<EOD
Beschreibung:
	Zeigt die Liste der letzten Änderungen in jedem Cluster.

Verwendung:
	{{changes}}

Optionen:
	[page="Cluster"]
	[date="YYYY-MM-DD"]
	[max=Number]
	[title=1]
	[noxml=1]
EOD,

	'edit' =>
<<<EOD
Beschreibung:
	Erstellt einen Verweis zum Bearbeiten einer bestimmten Seite, wenn der Nutzer das Recht hat diese zu bearbeiten.

Verwendung:
	{{edit}}

Optionen:
	[page="SeiteZumBearbeiten"]
	[text="Dein Text"]
EOD,

];