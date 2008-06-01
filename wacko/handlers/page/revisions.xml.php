<?php
header("Content-type: text/xml");

$xml = "<?xml version=\"1.0\" encoding=\"".$this->GetCharset()."\"?>\n";
$xml .= "<rss version=\"2.0\" xmlns:dc=\"http://purl.org/dc/elements/1.1/\">\n";
$xml .= "<channel>\n";
$xml .= "<title>".$this->GetConfigValue("wakka_name")." - ".$this->tag."</title>\n";
$xml .= "<link>".$this->GetConfigValue("base_url").$this->tag."</link>\n";
$xml .= "<description>".$this->GetResourceValue("PageRevisionsXML").$this->GetConfigValue("wakka_name")."/".$this->tag."</description>\n";
$xml .= "<lastBuildDate>".date('r')."</lastBuildDate>\n";
$xml .= "<language>en-us</language>\n";
$xml .= "<docs>http://blogs.law.harvard.edu/tech/rss</docs>\n";
$xml .= "<generator>WackoWiki ".WACKO_VERSION."</generator>\n";//!!!

if ($this->HasAccess("read"))
{
	// load revisions for this page
	if ($pages = $this->LoadRevisions($this->tag))
	{
		$max = 10;

		$c = 0;
		$_GET["b"] = -1;
		$_GET["fastdiff"] = 1;
		foreach ($pages as $page)
		{
			$c++;
			if (($c <= $max) && $c>1)
			{
				$xml .= "<item>\n";
				$xml .= "<title>".$page["time"]."</title>\n";
				$xml .= "<link>".$this->href("show").($this->GetConfigValue("rewrite_mode")?"?":"&amp;")."time=".urlencode($page["time"])."</link>\n";
				$_GET["a"] = $_GET["b"];
				$_GET["b"] = $page["id"];
				$diff = $this->IncludeBuffered("handlers/page/diff.php", "oops");

				$xml .= "<description>".str_replace("<", "&lt;", str_replace("&", "&amp;", $diff))."</description>\n";
				$xml .= "</item>\n";
			}
		}
	}
}
else
{
	$xml .= "<item>\n";
	$xml .= "<title>Error</title>\n";
	$xml .= "<link>".$this->href("show")."</link>\n";
	$xml .= "<description>".$this->GetResourceValue("AccessDeniedXML")."</description>\n";
	$xml .= "</item>\n";
}

$xml .= "</channel>\n";
$xml .= "</rss>\n";

print($xml);

?>