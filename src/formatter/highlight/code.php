<?php

echo
	'<ignore><!--notypo-->' .
		'<pre class="code">' .
			Ut::html($text) .
		'</pre>' .
	'<!--/notypo--></ignore>';
