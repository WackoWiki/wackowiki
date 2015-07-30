<?php

$this->use_class('delphihightlighter', $this->config['formatter_path'].'/class/');

$dh = new DelphiHightlighter();
echo '<!--notypo-->';
echo '<pre class="code">';
echo $dh->analysecode($text);
echo "</pre>";
echo '<!--/notypo-->';
unset($dh);

?>