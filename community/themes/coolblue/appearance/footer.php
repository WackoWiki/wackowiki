</div>
  </div>
  <div id="credits"><?php
if ($this->get_user())
{
	echo $this->get_translation('PoweredBy').' '.$this->link('WackoWiki:HomePage', '', 'WackoWiki '.$this->get_wacko_version());
}
?></div>
</div>

<?php

// Don't place final </body></html> here. Wacko closes HTML automatically.
?>