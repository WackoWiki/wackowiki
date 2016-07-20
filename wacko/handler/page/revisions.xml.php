<?php

if (!defined('IN_WACKO'))
{
	exit;
}

header('Content-type: text/xml');

echo ADD_NO_DIV;
echo "<?xml version=\"1.0\" encoding=\"".$this->get_charset()."\"?>\n";
echo "<rss version=\"2.0\" xmlns:dc=\"http://purl.org/dc/elements/1.1/\">\n";
echo "<channel>\n";
echo "<title>".$this->config['site_name']." - ".$this->tag."</title>\n";
echo "<link>".$this->config['base_url'].$this->tag."</link>\n";
echo "<description>".$this->_t('PageRevisionsXML').$this->config['site_name']."/".$this->tag."</description>\n";
echo "<lastBuildDate>".date('r')."</lastBuildDate>\n";
echo "<image>\n";
echo "<title>".$this->config['site_name'].$this->_t('RecentCommentsTitleXML')."</title>\n";
echo "<link>".$this->config['base_url']."</link>\n";
echo "<url>".$this->config['base_url']."image/wacko_logo.png"."</url>\n";
echo "<width>108</width>\n";
echo "<height>50</height>\n";
echo "</image>\n";
echo "<language>en-us</language>\n";
echo "<docs>http://blogs.law.harvard.edu/tech/rss</docs>\n";
// echo "<generator>WackoWiki ".WACKO_VERSION."</generator>\n";//!!!

if ($this->has_access('read') && !$this->hide_revisions)
{
	// load revisions for this page
	if (($revisions = $this->load_revisions($this->page['page_id'])))
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
				$_GET['b'] = $page['revision_id'];
				$_GET['c'] = ($_GET['d'] == '' ? $this->page['modified'] : $_GET['d']);


				echo "<item>\n";
				echo "<title>".$this->get_time_formatted($_GET['c'])."</title>\n";
				echo "<link>".$this->href('show', '', 'revision_id='.$_GET['a'])."</link>\n";
				echo "<guid isPermaLink=\"true\">".$this->href('', $etag)."</guid>\n";

				$diff = $this->include_buffered('page/diff.php', 'oops', '', HANDLER_DIR);

				// remove diff type navigation
				$diff = preg_replace('/(<!--nomail-->.*?<!--\/nomail-->)/si', '', $diff);

				echo "<description>".str_replace('<', "&lt;", str_replace('&', '&amp;', $diff))."</description>\n";
				echo "<pubDate>".date ('r', strtotime ($_GET['c']))."</pubDate>\n";
				echo "</item>\n";
			}
		}
	}
}
else
{
	echo "<item>\n";
	echo "<title>Error</title>\n";
	echo "<link>".$this->href('show')."</link>\n";
	echo "<description>".$this->_t('AccessDeniedXML')."</description>\n";
	echo "</item>\n";
}

echo "</channel>\n";
echo "</rss>\n";
