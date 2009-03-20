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

// Don't place final </body></html> here. Wacko closes HTML automatically.
?>