</div>
  </div>
  <div id="credits"><?php
if ($this->get_user())
{
	echo $this->_t('PoweredBy') . ' ' . $this->link('WackoWiki:HomePage', '', 'WackoWiki');
}
?></div>
</div>

<?php

// Don't place final </body></html> here. Wacko closes HTML automatically.
?>