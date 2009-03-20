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
		if ($this->GetUser()){
			echo $this->GetTranslation("PoweredBy")." ".$this->Link("WackoWiki:WackoWiki", "", "WackoWiki ".$this->GetWackoVersion());
		}
		?></td>
	</tr>
</table>
