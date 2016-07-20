<?php

if (!defined('IN_WACKO'))
{
	exit;
}

header('Content-type: text/xml');

echo ADD_NO_DIV;
echo "<?xml version=\"1.0\" encoding=\"".$this->get_charset()."\"?>\n";
echo "<rss version=\"2.0\" xmlns:dc=\"http://purl.org/dc/elements/1.1/\">\n";
echo "\t<channel>\n";
echo "\t\t<title>".$this->tag."</title>\n";
echo "\t\t<link>".$this->config['base_url']."</link>\n";
echo "\t\t<description>".$this->_t('ExportClusterXML').$this->config['site_name']."/".$this->tag."</description>\n";
echo "\t\t<lastBuildDate>".date('r')."</lastBuildDate>\n";
echo "\t\t<language></language>\n";//!!!
echo "\t\t<docs>http://blogs.law.harvard.edu/tech/rss</docs>\n";
echo "\t\t<generator>WackoWiki ".WACKO_VERSION."</generator>\n";//!!!

if ($this->has_access('read'))
{
	$num_slashes = substr_count($this->tag, '/');

	$pages = $this->load_all(
		"SELECT page_id, owner_id, tag, supertag, title, created, body ".
		"FROM ".$this->config['table_prefix']."page ".
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

		if ($num_slashes == substr_count($tag, '/'))
		{
			$tag = '';
		}
		else
		{
			$_tag = explode('/', $tag);
			$tag = '';

			for ($i = 0; $i < count($_tag); $i++)
			{
				if ($i > $num_slashes) $tag .= $_tag[$i].'/';
			}
		}

		echo "\t\t<item>\n";
		echo "\t\t\t<guid>".rtrim($tag, '/')."</guid>\n";
		echo "\t\t\t<title>".htmlspecialchars($page['title'], ENT_COMPAT | ENT_HTML401, HTML_ENTITIES_CHARSET)."</title>\n";
		echo "\t\t\t<link>".$this->config['base_url'].$page['supertag']."</link>\n";
		echo "\t\t\t<description><![CDATA[".str_replace(']]>', ']]&gt;', $page['body'])."]]></description>\n";
		echo "\t\t\t<author>".$page['owner_id']."</author>\n";
		echo "\t\t\t<pubDate>".Ut::http_date(strtotime($page['created']))."</pubDate>\n";
		echo "\t\t</item>\n";
	}
}
else
{
	echo "\t\t<item>\n";
	echo "\t\t\t<title>Error</title>\n";
	echo "\t\t\t<link>".$this->href('show')."</link>\n";
	echo "\t\t\t<description>".$this->_t('AccessDeniedXML')."</description>\n";
	echo "\t\t</item>\n";
}

echo "\t</channel>\n";
echo "</rss>\n";
