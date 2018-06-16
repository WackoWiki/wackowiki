<?php
if (!defined('IN_WACKO'))
{
	exit;
}

header('Content-type: text/xml');

$tpl->charset	= $this->get_charset();
$tpl->tag		= $this->tag;
$tpl->date		= date('r');
$tpl->lang		= $this->page_lang;
$tpl->logo		= Ut::join_path(IMAGE_DIR, $this->db->site_logo);

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

		$tpl->enter('p_');

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

				$tpl->user		= $page['user_name'];
				$tpl->note		= $page['edit_note'];
				$tpl->link		= $this->href('show', '', ['revision_id' => (int) $_GET['a']]);
				$tpl->perma		= $this->href('', $etag);

				// get diff
				$diff = $this->include_buffered('page/diff.php', 'oops', '', HANDLER_DIR);

				// remove diff type navigation
				$diff = preg_replace('/(<!--nomail-->.*?<!--\/nomail-->)/si', '', $diff);

				$tpl->diff		= str_replace('<', '&lt;', str_replace('&', '&amp;', $diff));
				$tpl->date		= date ('r', strtotime ($_GET['c']));

			}
		}

		$tpl->leave();
	}
}
else
{
	$tpl->denied = true;
}

