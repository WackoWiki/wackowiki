<?php
header("Content-Type: text/html; charset=iso-8859-1");

function test($text, $condition, $errorText = "", $stopOnError = 1)
   {
      GLOBAL $lang;
      print("$text ");
      if($condition)
         {
            print("<span class=\"ok\">OK</span><br />\n");
         }
      else
         {
            print("<span class=\"failed\">".$lang["failed"]."</span>");
            if ($errorText) print(": ".$errorText);
            print("<br />\n");
            if ($stopOnError) exit;
         }
   }

function myLocation()
   {
      list($url, ) = explode("?", $_SERVER["REQUEST_URI"]);
      return $url;
   }

// Fetch Configuration
$config = $_POST["config"];
$config2 = array_merge((array)$wakkaConfig, (array)$_POST["config"]);

if (!isset($config["language"]) || !@file_exists("setup/lang/installer.".$config["language"].".php")) $config["language"]="en";
require_once("setup/lang/installer.".$config["language"].".php");

?>
<html>
<head>
   <title><?php echo $lang["title"];?></title>
   <style>
      P, BODY, TD, LI, INPUT, SELECT, TEXTAREA { font-family: Verdana; font-size: 13px; }
      INPUT { color: #880000; }
      .ok { color: #008800; font-weight: bold; }
      .failed { color: #880000; font-weight: bold; }
      .warning { color: #DD0000; font-weight: bold; }
      A { color: #0000FF; }
   </style>
</head>
<body>