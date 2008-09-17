<?php
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

//don't place final </body></html> here. Wacko closes HTML automatically.
?>

<!-- wrapper -->
		</td>
	</tr>
</table>

<table class="bottom" align="center" border="0" cellpadding="0" cellspacing="0" width="100%">
<tr>
 <td class="copyright">
  		Powered by <?php echo $this->Link("WackoWiki:HomePage", "", "WackoWiki ".$this->GetWackoVersion()) ?>
   </td>
</tr>

</table>