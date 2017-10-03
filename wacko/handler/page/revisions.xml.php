<?php

if (!defined('IN_WACKO'))
{
	exit;
}

header('Content-type: text/xml');

echo ADD_NO_DIV;
echo '<?xml version="1.0" encoding="' . $this->get_charset() . '"?>' . "\n";
echo '<rss version="2.0" xmlns:dc="http://purl.org/dc/elements/1.1/">' . "\n";
echo '<channel>' . "\n";
echo '<title>' . $this->db->site_name . " - " . $this->tag . '</title>' . "\n";
echo '<link>' . $this->db->base_url . $this->tag . '</link>' . "\n";
echo '<description>' . $this->_t('PageRevisionsXML') . $this->db->site_name . "/" . $this->tag . '</description>' . "\n";
echo '<lastBuildDate>' . date('r') . '</lastBuildDate>' . "\n";
echo '<image>' . "\n";
echo '<title>' . $this->db->site_name . $this->_t('RecentCommentsTitleXML') . '</title>' . "\n";
echo '<link>' . $this->db->base_url . '</link>' . "\n";
echo '<url>' . $this->db->base_url . Ut::join_path(IMAGE_DIR, $this->db->site_logo)  . '</url>' . "\n";
echo '<width>' . $this->db->logo_width . '</width>' . "\n";
echo '<height>' . $this->db->logo_height . '</height>' . "\n";
echo '</image>' . "\n";
echo '<language>' . $this->page['page_lang'] . '</language>' . "\n";
#echo '<docs>http://www.rssboard.org/rss-specification</docs>' . "\n";
#echo '<generator>WackoWiki ' . WACKO_VERSION . '</generator>' . "\n";

if ($this->has_access('read') && !$this->hide_revisions)
{
	// load revisions for this page except minor edits
	if (list ($revisions, $pagination) = $this->load_revisions($this->page['page_id'], 1))
	{
		$max				= 10;

		$c					= 0;
		$_GET['b']			= -1;
		$_GET['diffmode']	= 2; // 2 - source diff

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


				echo '<item>' . "\n";
				echo '<title>' . $page['user_name'] . ': ' . $page['edit_note'] . '</title>' . "\n";
				echo '<link>' . $this->href('show', '', ['revision_id' => (int) $_GET['a']]) . '</link>' . "\n";
				echo '<guid isPermaLink="true">' . $this->href('', $etag) . '</guid>' . "\n";

				$diff = $this->include_buffered('page/diff.php', 'oops', '', HANDLER_DIR);

				// remove diff type navigation
				$diff = preg_replace('/(<!--nomail-->.*?<!--\/nomail-->)/si', '', $diff);

				echo '<description>' . str_replace('<', '&lt;', str_replace('&', '&amp;', $diff)) . '</description>' . "\n";
				echo '<pubDate>' . date ('r', strtotime ($_GET['c'])) . '</pubDate>' . "\n";
				echo '</item>' . "\n";
			}
		}
	}
}
else
{
	echo '<item>' . "\n";
	echo '<title>Error</title>' . "\n";
	echo '<link>' . $this->href('show') . '</link>' . "\n";
	echo '<description>' . $this->_t('AccessDeniedXML') . '</description>' . "\n";
	echo '</item>' . "\n";
}

echo '</channel>' . "\n";
echo '</rss>' . "\n";
