<?php

print("<!--notypo-->");
$typo = $this->config["default_typografica"];
$this->config["default_typografica"] = false;
include("formatters/wakka.php");
$this->config["default_typografica"] = $typo;
print("<!--/notypo-->");

?>