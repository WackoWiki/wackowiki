<?php 
/*
Armstrong theme.
created by yourhp.de

*/
?>
</div>
  </div>
  <div id="footer"><?php echo $this->Link("WackoWiki:WackoWiki", "", "WackoWiki ".$this->GetWackoVersion()) ?></div>
</div>

<?php

//Debug Querylog.
if ($this->GetConfigValue("debug")>=2)
{
 print("<span style=\"font-size: 11px; color: #888888\">");
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