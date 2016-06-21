<?php

if (!defined('IN_WACKO'))
{
	exit;
}

header('Content-type: text/xml');

$xml = "<?xml version=\"1.0\" encoding=\"".$this->get_charset()."\"?>\n";
$xml .= "<rss version=\"2.0\" xmlns:dc=\"http://purl.org/dc/elements/1.1/\">\n";
$xml .= "<channel>\n";
$xml .= "<title>".$this->config['site_name']." - ".$this->tag."</title>\n";
$xml .= "<link>".$this->config['base_url'].$this->tag."</link>\n";
$xml .= "<description>".$this->get_translation('PageRevisionsXML').$this->config['site_name']."/".$this->tag."</description>\n";
$xml .= "<lastBuildDate>".date('r')."</lastBuildDate>\n";
$xml .= "<image>\n";
$xml .= "<title>".$this->config['site_name'].$this->get_translation('RecentCommentsTitleXML')."</title>\n";
$xml .= "<link>".$this->config['base_url']."</link>\n";
$xml .= "<url>".$this->config['base_url']."image/wacko_logo.png"."</url>\n";
$xml .= "<width>108</width>\n";
$xml .= "<height>50</height>\n";
$xml .= "</image>\n";
$xml .= "<language>en-us</language>\n";
$xml .= "<docs>http://blogs.law.harvard.edu/tech/rss</docs>\n";
#$xml .= "<generator>WackoWiki ".WACKO_VERSION."</generator>\n";//!!!

if ($this->has_access('read') && $this->hide_revisions === false )
{
	// load revisions for this page
	if ($revisions = $this->load_revisions($this->page['page_id']))
	{
		$max				= 10;

		$c					= 0;
		$_GET['b']			= -1;
		$_GET['diffmode']	= 1;

		foreach ($revisions as $page)
		{
			$c++;

			if (($c <= $max) && $c > 1)
			{
				$etag = str_replace('%2F', '/', rawurlencode($page['tag']));
				$_GET['d'] = $page['modified'];
				$_GET['a'] = $_GET['b'];
				$_GET['b'] = $page['revision_m_id'];
				$_GET['c'] = ($_GET['d'] == '' ? $this->page['modified'] : $_GET['d']);


				$xml .= "<item>\n";
				$xml .= "<title>".$this->get_time_formatted($_GET['c'])."</title>\n";
				$xml .= "<link>".$this->href('show', '', 'revision_id='.$_GET['a'])."</link>\n";
				$xml .= "<guid isPermaLink=\"true\">".$this->href('', $etag)."</guid>\n";

				$diff = $this->include_buffered($this->config['handler_path'].'/page/diff.php', 'oops');

				// remove diff type navigation
				$diff = preg_replace('/(<!--nomail-->.*?<!--\/nomail-->)/si', '', $diff);

				$xml .= "<description>".str_replace('<', "&lt;", str_replace('&', '&amp;', $diff))."</description>\n";
				$xml .= "<pubDate>".date ('r', strtotime ($_GET['c']))."</pubDate>\n";
				$xml .= "</item>\n";
			}
		}
	}
}
else
{
	$xml .= "<item>\n";
	$xml .= "<title>Error</title>\n";
	$xml .= "<link>".$this->href('show')."</link>\n";
	$xml .= "<description>".$this->get_translation('AccessDeniedXML')."</description>\n";
	$xml .= "</item>\n";
}

$xml .= "</channel>\n";
$xml .= "</rss>\n";

echo $xml;

?>