<?php 
/*
lernjournal theme.

*/
?>
</div>

  <div id="footer"><?php 
if ($this->get_user()){
	echo $this->get_translation('PoweredBy').' '.$this->link('WackoWiki:WackoWiki', '', 'WackoWiki '.$this->get_wacko_version());
}
?></div>
  </div>

<?php

// Don't place final </body></html> here. Wacko closes HTML automatically.
?>