<?php

function myLocation()
{
	list($url, ) = explode("?", $_SERVER["REQUEST_URI"]);
	return $url;
}

// Draws a tick or cross next to a result
function output_image($ok)
{
	GLOBAL $lang;
	return "<img src=\"".myLocation()."setup/images/".($ok ? "tick" : "cross").".png\" width=\"20\" height=\"20\" alt=\"".($ok ? $lang["OK"] : $lang["Problem"])."\" title=\"".($ok ? $lang["OK"] : $lang["Problem"])."\" class=\"tickcross\" />";
}

function is__writable($path)
{
	// http://uk2.php.net/manual/en/function.is-writable.php
	// legolas558 d0t users dot sf dot net - 02-Mar-2007 08:18
	// Will work in despite of Windows ACLs bug
	// NOTE: use a trailing slash for folders!!!
	// see http://bugs.php.net/bug.php?id=27609
	// see http://bugs.php.net/bug.php?id=30931

	if($path{strlen($path)-1}=='/') // recursively return a temporary file path
	return is__writable($path.uniqid(mt_rand()).'.tmp');
	else if (is_dir($path))
	return is__writable($path.'/'.uniqid(mt_rand()).'.tmp');
	// check tmp file for read/write capabilities
	$rm = file_exists($path);
	$f = @fopen($path, 'a');
	if ($f===false)
	return false;
	fclose($f);
	if(!$rm)
	unlink($path);
	return true;
}

// Fetch Configuration
if ( isset ( $_POST["config"] ) ) {
	$config = $_POST["config"];
	$config2 = array_merge((array)$wackoConfig, (array)$_POST["config"]);
}

if (!isset($config["language"]) || !@file_exists("setup/lang/installer.".$config["language"].".php")) $config["language"] = "en";
require_once("setup/lang/installer.".$config["language"].".php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"
	xml:lang="<?php echo $config["language"]; ?>"
	lang="<?php echo $config["language"]; ?>">
<head>
<title><?php echo $lang["Title"];?></title>
<meta http-equiv="Content-Type"
	content="text/html; charset=<?php echo $lang["Charset"]; ?>" />
<link rel="stylesheet"
	href="<?php echo myLocation() ?>setup/css/installer.css"
	type="text/css" />
<link rel="shortcut icon"
	href="<?php echo myLocation() ?>setup/favicon.ico" type="image/x-icon" />
</head>
<body>
<div class="installer">
<h1><?php echo $lang["Title"];?></h1>
<h1 class="white">&nbsp;:&nbsp;</h1>
<h1><?php $installAction == "lang" ? print $lang["Lang"] : print $lang[$installAction]; ?></h1>
<ul class="menu">
	<li
		class="<?php echo $installAction == 'lang' ? 'current' : 'item'; ?>"><?php echo $lang["Lang"]; ?></li>
	<li>&gt;</li>
	<li
		class="<?php echo $installAction == 'version-check' ? 'current' : 'item'; ?>"><?php echo $lang["version-check"]; ?></li>
	<li>&gt;</li>
	<li
		class="<?php echo $installAction == 'site-config' ? 'current' : 'item'; ?>"><?php echo $lang["site-config"]; ?></li>
	<li>&gt;</li>
	<?php
	if ( !isset ( $wackoConfig["wakka_version"] ) ) {
		?>
	<li
		class="<?php echo $installAction == 'database-config' ? 'current' : 'item'; ?>"><?php echo $lang["database-config"]; ?></li>
	<li>&gt;</li>
	<?php
	}
	?>
	<li
		class="<?php echo $installAction == 'database-install' ? 'current' : 'item'; ?>"><?php echo $lang["database-install"]; ?></li>
	<li>&gt;</li>
	<li
		class="<?php echo $installAction == 'write-config' ? 'current' : 'item'; ?>"><?php echo $lang["write-config"]; ?></li>
</ul>
<div class="fake_hr">
<hr />
</div>