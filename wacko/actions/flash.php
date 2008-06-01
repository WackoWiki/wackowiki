<?php

/*
 Flash Action
 Uses UFO: http://www.bobbyvandersluis.com/ufo/

 The first three arguments here are required.  The rest are optional
 however it should be noted that the majorversion and build will be set to 9 and 0 as default

 {{flash
 [url="file:the_movie.swf"]
 [width="100"]
 [height="100"]
 [name="TheFlashMovie"] // the id to assign to the div tag that UFO will replace
 [majorversion="9"] // major version of the Flash player required to view this file
 [build="0"] // minor version of the Flash player to view this file
 [swliveconnect=true|false]
 [base="/someotherdirectory"] // sets the directory that relative paths inside the Flash movie will start from
 [flashvars="var0=bob&var1=alice"] // flashvars variable to pass into flash
 [bgcolor=f1f1f1] // color for Stage background
 [wmode=transparent|opaque] // give the Flash movie a transparent background?
 [allowscriptaccess=never|always] // http://www.adobe.com/go/tn_16494
 [xi=true] // use the UFO express install feature?
 [ximovie:"/express_install.swf"] // URL of express install Flash movie
 [xiwidth:"100"]
 [xiheight:"100"]
 [xiurlcancel:"/cancel.swf"] // URL of cancel page
 [xiurlfailed:"/failed.swf"] // URL of failed page
 [setcontainercss:"true"]
 }}
 */

$url = htmlspecialchars($url);

if(!$width) $width = 550;
if(!$height) $height = 100;
if(!$name) $name = 'flash'.rand();

if($url)
{
	echo '<script type="text/javascript">
                  var FO = { movie:"'.$url.'", width:"'.$width.'", height:"'.$height.'", majorversion:"9", build:"0"'.($xi ? ', xi:"true"' : '').($flashvars ? ', flashvars:"'.$flashvars.'"' : '').($bgcolor ? ', bgcolor:"'.$bgcolor.'"' : '').($wmode ? ', wmode:"'.$wmode.'"' : '').($allowscriptaccess ? ', allowscriptaccess:"'.$allowscriptaccess.'"' : '').($swliveconnect ? ', swliveconnect:"'.$swliveconnect.'"' : '').($base ? ', base:"'.$base.'"' : '').($ximovie ? ', ximovie:"'.$ximovie.'"' : '').($xiwidth ? ', xiwidth:"'.$xiwidth.'"' : '').($xiheight ? ', xiheight:"'.$xiheight.'"' : '').($xiurlcancel ? ', xiurlcancel:"'.$xiurlcancel.'"' : '').($xiurlfailed ? ', xiurlfailed:"'.$xiurlfailed.'"' : '').($setcontainercss ? ', setcontainercss:"true"' : '').' };
                  UFO.create(FO, "'.$name.'");
               </script>
               <div id="'.$name.'"></div>';
}
?>