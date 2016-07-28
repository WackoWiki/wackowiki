<?php
header('Content-Type: text/html; charset='.$this->get_charset());
?>
<!DOCTYPE html>

<head>
<title><?php echo htmlspecialchars($this->db->site_name, ENT_COMPAT | ENT_HTML401, HTML_ENTITIES_CHARSET)." : ".(isset($this->page['title']) ? $this->page['title'] : $this->tag); ?></title>

</head>

<body>



<div class="">
