<?php 
/*
lernjournal theme.

*/
?>
</div>

  <div id="footer"><?php 
if ($this->GetUser()){
	echo $this->GetTranslation("PoweredBy")." ".$this->Link("WackoWiki:WackoWiki", "", "WackoWiki ".$this->GetWackoVersion());
}
?></div>
  </div>

<?php

//Debug Querylog.
if ($this->GetConfigValue("debug")>=2)
{
 print("<span class=\"debug\">");
 print("<strong>Query log:</strong><br />\n");
 foreach ($this->queryLog as $query)
 {
  print($query["query"]." (".$query["time"].")<br />\n");
  $zz++;
 }
 print("<b>total: $zz</b>");
 print("</span>");
}
// Don't place final </body></html> here. Wacko closes HTML automatically.
?>