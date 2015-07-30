<?php

$this->use_class('javahighlighter', $this->config['formatter_path'].'/class/');

$dh = new JavaHighlighter();
echo '<!--notypo-->';
echo '<pre class="code">';
echo $dh->analysecode($text);
echo "</pre>";
echo '<!--/notypo-->';
unset($dh);

?>