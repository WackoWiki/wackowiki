</div>
<div align="right"><?php
// Revisions link
echo $this->page['modified'] ? "<a href=\"".$this->href('revisions')."\" title=\"".$this->get_translation('RevisionTip')."\">".$this->get_page_time_formatted()."</a>" : "";
?></div>
<?php

// Don't place final </body></html> here. Wacko closes HTML automatically.
?>
</div>
</div>
<div id="footer">
  <div id="credits"><?php
if ($this->get_user())
{
	echo $this->get_translation('PoweredBy').' '.$this->link('WackoWiki:HomePage', '', 'WackoWiki '.$this->get_wacko_version());
}
?></div>
</div>
</div>
