</div>
  </div>
  <div id="credits"><?php
if ($this->GetUser())
{
	echo $this->GetTranslation("PoweredBy")." ".$this->Link("WackoWiki:HomePage", "", "WackoWiki ".$this->GetWackoVersion());
}
?></div>
</div>

<?php

// Don't place final </body></html> here. Wacko closes HTML automatically.
?>