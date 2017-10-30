<?php

echo	'<!--notypo-->' .
			'<pre class="code">' .
				htmlspecialchars($text, ENT_COMPAT | ENT_HTML5, HTML_ENTITIES_CHARSET) .
			'</pre>' .
		'<!--/notypo-->';

?>