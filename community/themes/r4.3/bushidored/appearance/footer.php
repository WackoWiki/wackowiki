</div>
<div align="right"><?php
// Revisions link
echo $this->GetPageTime() ? "<a href=\"".$this->href("revisions")."\" title=\"".$this->GetTranslation("RevisionTip")."\">".$this->GetPageTime()."</a>" : "";
?></div>
<?php

// Don't place final </body></html> here. Wacko closes HTML automatically.
?>
</div>
</div>
<div id="footer">
  <div id="credits"><?php
if ($this->GetUser())
{
	echo $this->GetTranslation("PoweredBy")." ".$this->Link("WackoWiki:HomePage", "", "WackoWiki ".$this->GetWackoVersion());
}
?></div>
</div>
</div>
