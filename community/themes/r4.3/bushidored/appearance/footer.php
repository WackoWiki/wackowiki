<?php 
/*
Bushido Alfeld e.V. theme
created by yourhp.de

Common header file.

*/
?>
</div>
<div align="right"><?php
// Revisions link
echo $this->GetPageTime() ? "<a href=\"".$this->href("revisions")."\" title=\"".$this->GetTranslation("RevisionTip")."\">".$this->GetPageTime()."</a>" : "";
?></div>
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
</div>
</div>
<div id="footer">
  <div class="copyright"> Powered by <?php echo $this->Link("WackoWiki:WackoWiki", "", "WackoWiki ".$this->GetWackoVersion()) ?> </div>
</div>
</div>
