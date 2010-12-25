<?php

$text = htmlspecialchars($text);

$text = preg_replace("/\(Link: ((https?|ftp|file|nntp|telnet):\/\/[^ \t\)]+)\)/","", $text);
$text = preg_replace("/\b(https?|ftp|file|nntp|telnet):\/\/\S+/","<a href='\\0'>\\0</a>", $text);

preg_match_all( "/".
             "^(\[[0-9]{1,2}:[0-9]{1,2}\])\s*(.*?)\s*:".
             "(\s*(.*?))".
             "(?=^(\[[0-9]{1,2}:[0-9]{1,2}\]))/ims",
$text,
$matches, PREG_SET_ORDER);
$names = array();
foreach( $matches as $m )
$names[ $m[2] ] = 1;
/*
 */
$endstr = "[00:00] end: (end of log)";
$text.= "\n$endstr\n";



$text = preg_replace( "/".
             "^(\[[0-9]{1,2}:[0-9]{1,2}\])\s*(.*?)\s*:".
             "(\s*(.*?))".
             "(?=^(\[[0-9]{1,2}:[0-9]{1,2}\]))/ims",
             "<tr style='$2'><td class='micq1'>$2</td><td class='micq3'>$4</td><td class='micq2'>$1</td></tr>", $text );
$text = str_replace( "\n", "<br />", $text );


$colors = array( "#eeffee", "#eeeeff", "#ffffee", "#ff9999" );

$c=0;
foreach( $names as $k=>$n )
{
	$text = str_replace( "<tr style='".$k."'>",
                       "<tr style='background:".$colors[$c++]."'>",
	$text );
}

$people = "";
foreach( $names as $name=>$v )
{
	$people .= "<li>".$name."</li>";
}

$text = str_replace( $endstr, "", $text );

echo "<pre class=\"code\"><table>".$text."</table></pre>";
?>