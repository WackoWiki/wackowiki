<?php

/*
	Flash Action
	Uses SWFObject 2: http://code.google.com/p/swfobject/

	The first five arguments here are required.  The rest are optional.

	{{flash
	[url="file:the_movie.swf"]
	[width="100"]
	[height="100"]
	[name="TheFlashMovie"] // the id to assign to the div tag that SWFObject will replace
	[version="9.0.0"]

	// Params
	play
	loop
	menu
	quality
	scale
	salign
	wmode
	bgcolor
	base
	swliveconnect
	devicefont
	allowscriptaccess
	seamlesstabbing
	allowfullscreen
	allownetworking

	// Flashvars
	[flashvars="variable1=name&variable2=age&variable3=height"]

	// Attributes
	id
	name
	styleclass
	align
	}}
*/

if (!$url) $url = $vars[0];
$url = htmlspecialchars($url);

if(!$width) $width = 550;
if(!$height) $height = 100;
if(!$name) $name = 'flash'.rand();
if(!$version) $version = '9.0.0';

if($url)
{

	print "<script type=\"text/javascript\">\n";
	print "		// <![CDATA[\n";
	print "		swfobject.embedSWF(\"".$url."\", \"".$name."\", \"".$width."\", \"".$height."\", \"".$version."\", \"".$this->GetConfigValue("root_url")."themes/_common/expressInstall.swf\", {}, {";

	// Write Params
	$written = 0;
	$params = array("play", "loop", "menu", "quality", "scale", "salign", "wmode", "bgcolor", "base", "quality", "swliveconnect", "devicefont", "allowscriptaccess", "seamlesstabbing", "allowfullscreen", "allownetworking");
	for($i = 0; $i < count($params); $i++)
	{
		if(${$params[$i]})
		{
			if($written > 0)
			{
				print ', ';
			}

			print (${$params[$i]} ? $params[$i].':"'.${$params[$i]}.'"' : '');
			$written++;
		}
	}

	print '}, {';

	// Write Attributes
	$written = 0;
	$attributes = array("id", "name", "styleclass", "align");
	for($i = 0; $i < count($attributes); $i++)
	{
		if(${$attributes[$i]})
		{
			if($written > 0)
			{
				print ', ';
			}

			print (${$attributes[$i]} ? $attributes[$i].':"'.${$attributes[$i]}.'"' : '');
			$written++;
		}
	}

	print "});\n";
	print "   // ]]>\n";
	print "</script>\n";
	print "<div id=\"".$name."\"></div>\n";
}

?>