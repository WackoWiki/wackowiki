<?php

//don't place final </body></html> here. Wacko closes HTML automatically.
?>

<!-- wrapper -->
</td>
</tr>
</table>

<table class="bottom" align="center" border="0" cellpadding="0"
	cellspacing="0" width="100%">
	<tr>
		<td id="credits"><?php 
		if ($this->get_user()){
			echo $this->get_translation('PoweredBy').' '.$this->link('WackoWiki:WackoWiki', '', 'WackoWiki '.$this->get_wacko_version());
		}
		?></td>
	</tr>
</table>
