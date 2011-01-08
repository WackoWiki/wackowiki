<?php
header("Content-type: text/xml");

$xml = "<?xml version=\"1.0\" encoding=\"".$this->get_charset()."\"?>\n";
$xml .= "<rss version=\"2.0\" xmlns:dc=\"http://purl.org/dc/elements/1.1/\">\n";
$xml .= "\t<channel>\n";
$xml .= "\t\t<title>".$this->tag."</title>\n";
$xml .= "\t\t<link>".$this->config['base_url']."</link>\n";
$xml .= "\t\t<description>".$this->get_translation('ExportClusterXML').$this->config['wacko_name']."/".$this->tag."</description>\n";
$xml .= "\t\t<lastBuildDate>".date('r')."</lastBuildDate>\n";
$xml .= "\t\t<language></language>\n";//!!!
$xml .= "\t\t<docs>http://blogs.law.harvard.edu/tech/rss</docs>\n";
$xml .= "\t\t<generator>WackoWiki ".WACKO_VERSION."</generator>\n";//!!!

if ($this->has_access('read'))
{
	$numOfSlashes = substr_count($this->tag, '/');

	$pages = $this->load_all(
		"SELECT * FROM ".$this->config['table_prefix']."page ".
		"WHERE (supertag = '".quote($this->dblink, $this->supertag)."'".
		" OR supertag LIKE '".quote($this->dblink, $this->supertag."/%")."')".
		" AND comment_on_id = '0'");

	foreach ($pages as $num => $page)
	{
		// check ACLS
		if (!$this->has_access('write', $page['page_id']))
		{
			continue;
		}
		// output page
		$tag = $page['tag'];

		if ($numOfSlashes == substr_count($tag, '/'))
		{
			$tag = '';
		}
		else
		{
			$_tag = explode('/', $tag);
			$tag = '';

			for ($i = 0; $i < count($_tag); $i++)
			{
				if ($i > $numOfSlashes) $tag .= $_tag[$i].'/';
			}
		}

		$xml .= "\t\t<item>\n";
		$xml .= "\t\t\t<guid>".rtrim($tag, '/')."</guid>\n";
		$xml .= "\t\t\t<title>".htmlspecialchars($page['title'])."</title>\n";
		$xml .= "\t\t\t<link>".$this->config['base_url'].$page['supertag']."</link>\n";
		$xml .= "\t\t\t<description><![CDATA[".str_replace(']]>', ']]&gt;', $page['body'])."]]></description>\n";
		$xml .= "\t\t\t<author>".$page['owner_id']."</author>\n";
		$xml .= "\t\t\t<pubDate>".gmdate('D, d M Y H:i:s \G\M\T', strtotime($page['created']))."</pubDate>\n";
		$xml .= "\t\t</item>\n";
	}
}
else
{
	$xml .= "\t\t<item>\n";
	$xml .= "\t\t\t<title>Error</title>\n";
	$xml .= "\t\t\t<link>".$this->href('show')."</link>\n";
	$xml .= "\t\t\t<description>".$this->get_translation('AccessDeniedXML')."</description>\n";
	$xml .= "\t\t</item>\n";
}

$xml .= "\t</channel>\n";
$xml .= "</rss>\n";

echo $xml;

?>