</div>
<div align="right"><?php

// Revisions link
echo (( $this->config['hide_revisions'] == false || ($this->config['hide_revisions'] == 1 && $this->get_user()) || ($this->config['hide_revisions'] == 2 && $this->user_is_owner()) || $this->is_admin() )
		? "<li><a href=\"".$this->href('revisions')."\" title=\"".$this->get_translation('RevisionTip')."\">".$this->get_time_string_formatted($this->page['modified'])."</a></li>\n"
		: "<li>".$this->get_time_string_formatted($this->page['modified'])."</li>\n"
	);

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
