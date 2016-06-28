<?php

if (!defined('IN_WACKO'))
{
	exit;
}

// {{hashid}}

require_once('lib/hashids/Hashids.php');
$hashids = new Hashids($this->config['system_seed']);

$ids = [$this->page['page_id'], (isset($this->page['revision_id'])? $this->page['revision_id'] : 0)];
sscanf(hash('sha1', $ids[0] . $this->config['system_seed'] . $ids[1]), '%7x', $ids[2]);

$id = $hashids->encode($ids);

echo '<a href="' . $this->href('', $id) . '" title="' . $this->get_translation('PermaLinkTip') . '" rel="nofollow">' . $this->get_translation('PermaLink') . '</a>';

?>
