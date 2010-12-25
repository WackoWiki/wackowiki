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
if (!isset($play)) $play = '';
if (!isset($loop)) $loop = '';
if (!isset($menu)) $menu = '';
if (!isset($quality)) $quality = '';
if (!isset($scale)) $scale = '';
if (!isset($salign)) $salign = '';
if (!isset($wmode)) $wmode = '';
if (!isset($bgcolor)) $bgcolor = '';
if (!isset($base)) $base = '';
if (!isset($swliveconnect)) $swliveconnect = '';
if (!isset($devicefont)) $devicefont = '';
if (!isset($allowscriptaccess)) $allowscriptaccess = '';
if (!isset($seamlesstabbing)) $seamlesstabbing = '';
if (!isset($allowfullscreen)) $allowfullscreen = '';
if (!isset($allownetworking)) $allownetworking = '';

if (!isset($url)) $url = '';
if (!isset($width)) $width = '';
if (!isset($height)) $height = '';
if (!isset($name)) $name = '';
if (!isset($version)) $version = '';
if (!isset($id)) $id = '';
if (!isset($styleclass)) $styleclass = '';
if (!isset($align)) $align = '';

if (!$url) $url = isset($vars['url']) ? $vars['url'] : "";
$url = htmlspecialchars($url);

if(!$width) $width = 550;
if(!$height) $height = 100;
if(!$name) $name = 'flash'.mt_rand();
if(!$version) $version = '10.0.0';

if (!$url)
{
	echo "<p><i>".$this->get_translation('FlashNoURL')."</i></p>\n";
}
else if($url)
{
	// Load swfobject with header
	$this->config['allow_swfobject'] = 1;

	echo "<script type=\"text/javascript\">\n";
	echo "		// <![CDATA[\n";
	echo "		swfobject.embedSWF(\"".$url."\", \"".$name."\", \"".$width."\", \"".$height."\", \"".$version."\", \"".$this->config['base_url']."themes/_common/expressInstall.swf\", {}, {";

	// Write Params
	$written = 0;
	$params = array('play', 'loop', 'menu', 'quality', 'scale', 'salign', 'wmode', 'bgcolor', 'base', 'quality', 'swliveconnect', 'devicefont', 'allowscriptaccess', 'seamlesstabbing', 'allowfullscreen', 'allownetworking');
	for($i = 0; $i < count($params); $i++)
	{
		if(${$params[$i]})
		{
			if($written > 0)
			{
				echo ', ';
			}

			echo (${$params[$i]} ? $params[$i].':"'.${$params[$i]}.'"' : '');
			$written++;
		}
	}

	echo '}, {';

	// Write Attributes
	$written = 0;
	$attributes = array('id', 'name', 'styleclass', 'align');
	for($i = 0; $i < count($attributes); $i++)
	{
		if(${$attributes[$i]})
		{
			if($written > 0)
			{
				echo ', ';
			}

			echo (${$attributes[$i]} ? $attributes[$i].':"'.${$attributes[$i]}.'"' : '');
			$written++;
		}
	}

	echo "});\n";
	echo "   // ]]>\n";
	echo "</script>\n";
	echo "<div id=\"".$name."\"></div>\n";
}

?>