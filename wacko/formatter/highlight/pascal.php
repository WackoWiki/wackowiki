<?php

$dh = new DelphiHightlighter();
echo '<!--notypo-->';
echo '<pre class="code">';
echo $dh->analysecode($text);
echo "</pre>";
echo '<!--/notypo-->';
unset($dh);
