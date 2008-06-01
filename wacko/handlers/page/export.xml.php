<?php
header("Content-type: text/xml");

$xml = "<?xml version=\"1.0\" encoding=\"".$this->GetCharset()."\"?>\n";
$xml .= "<rss version=\"2.0\" xmlns:dc=\"http://purl.org/dc/elements/1.1/\">\n";
$xml .= "<channel>\n";
$xml .= "<title>".$this->tag."</title>\n";
$xml .= "<link>".$this->GetConfigValue("base_url")."</link>\n";
$xml .= "<description>".$this->GetResourceValue("ExportClusterXML").$this->GetConfigValue("wakka_name")."/".$this->tag."</description>\n";
$xml .= "<lastBuildDate>".date('r')."</lastBuildDate>\n";
$xml .= "<language></language>\n";//!!!
$xml .= "<docs>http://blogs.law.harvard.edu/tech/rss</docs>\n";
$xml .= "<generator>WackoWiki ".WACKO_VERSION."</generator>\n";//!!!

if ($this->HasAccess("read"))
{

	$numOfSlashes = substr_count($this->tag, "/");

	$pages = $this->LoadAll("select * from ".
	$this->config["table_prefix"]."pages where (supertag = '".quote($this->dblink, $this->supertag)."'".
            " OR supertag like '".quote($this->dblink, $this->supertag."/%")."')".
            " and comment_on = ''");
	foreach ($pages as $num=>$page)
	{
		// check ACLS
		if (!$this->HasAccess("write", $page["tag"])) continue;
		// output page
		$tag = $page["tag"];
		if ($numOfSlashes == substr_count($tag, "/")) $tag = "";
		else
		{
			$_tag = explode("/", $tag);
			$tag = "";
			for ($i=0; $i<count($_tag); $i++)
			{
				if ($i>$numOfSlashes) $tag .= $_tag[$i]."/";
			}
		}

		$xml .= "<item>\n";
		$xml .= "<guid>".rtrim($tag, "/")."</guid>\n";
		$xml .= "<title></title>\n";
		$xml .= "<link>".$this->GetConfigValue("base_url").$page["supertag"]."</link>\n";
		$xml .= "<description><![CDATA[".str_replace("]]>","]]&gt;",$page["body"])."]]></description>\n";
		$xml .= "<author>".$page["owner"]."</author>\n";
		$xml .= "<pubDate>".gmdate('D, d M Y H:i:s \G\M\T', strtotime($page["time"]))."</pubDate>\n";
		$xml .= "</item>\n";
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