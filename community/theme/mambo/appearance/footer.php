<?php

//don't place final </body></html> here. Wacko closes HTML automatically.
?>

<!-- wrapper -->
</td>
</tr>
</table>

<table class="bottom" style="text-align:center; width:100%;">
	<tr>
		<td id="credits"><?php
		if ($this->get_user()){
			echo $this->_t('PoweredBy').' ' . $this->link('WackoWiki:WackoWiki', '', 'WackoWiki');
		}
		?></td>
	</tr>

</table>
