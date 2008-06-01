<?php

if ($this->NpjTranslit($this->config["allpageindex_page"]) != $this->NpjTranslit($this->tag))
{
	echo "<em>".$this->GetResourceValue("ActionDenied")."</em> ";
}
else
if ($pages = $this->LoadAllPages())
{
	foreach ($pages as $page)
	{
		if (!preg_match("/^Comment/", $page["tag"])) {
			$firstChar = strtoupper($page["tag"][0]);
			if (!preg_match("/".$this->language["ALPHA"]."/", $firstChar)) {
				$firstChar = "#";
			}

			if ($firstChar != $curChar) {
				if ($curChar) print("<br />\n");
				print("<strong>$firstChar</strong><br />\n");
				$curChar = $firstChar;
			}

			print($this->Link($page["tag"])."<br />\n");
		}
	}
}
else
{
	echo $this->GetResourceValue("NoPagesFound");
}

?>