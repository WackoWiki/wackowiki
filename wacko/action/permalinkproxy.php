<?php

if (!defined('IN_WACKO'))
{
	exit;
}

// {{permalinkproxy page_id=[number] preview=[0|1] permanent=[0|1]}}

if (isset($_GET['page_id']))
{
	$page_id = (int)$_GET['page_id'];
}

$revision_id = (int)@$_GET['rev_id'];

if (!isset($preview)) $preview = 0;
if (!isset($permanent)) $permanent = 0;

if (isset($page_id))
{
	$page_tag = $this->get_page_tag($page_id);

	// TODO: check permissions if page is accessible
	// show?revision_id=970

	if ($page_tag)
	{
		if ($permanent && !headers_sent())
		{
			header('HTTP/1.1 301 Moved Permanently');
		}

		if ($_page = $this->load_page('', $page_id, $revision_id, LOAD_CACHE, LOAD_META))
		{
			if ($user = $this->get_user() || $preview)
			{
				if ($user['dont_redirect'] == 1 || (isset($_POST['redirect']) && $_POST['redirect'] == 'no') || $preview)
				{
					// This is the current revision of this page, as edited by [user_name] at [modified]. The present address (URL) is a permanent link to this version.
					// This is an old revision of this page, as edited by [user_name] at [modified]. It may differ significantly from the current revision.
					$this->show_message($this->_t((isset($revision_id) ? 'PermaLinkRevision' :'PermaLinkRecent'))." ".$this->link('/'.$page_tag));

					if (isset($revision_id))
					{
						echo '<div class="revisioninfo">'.
							Ut::perc_replace($this->_t('Revision'),
								$this->href(),
								$this->tag,
								$this->get_time_formatted($_page['modified']),
								$this->user_link($_page['user_name'], '', true, false)).
							'</div>';
					}

					echo "<div class=\"\">".$this->action('include', array('page' => '/'.$page_tag, 'notoc' => 0, 'nomark' => 0, 'revision_id' => $revision_id), 1)."</div>\n";
				}
				else
				{
					$this->set_message($this->_t('PermaLinkRedirected').': '.$page_id);
					$this->redirect($this->href('', $page_tag, (!empty($revision_id) ? 'revision_id='.$revision_id : '') ));
				}
			}
			else
			{
				#$this->set_message($this->_t('PermaLinkRedirected').': '.$page_id);
				$this->redirect($this->href('', $page_tag, (!empty($revision_id) ? 'revision_id='.$revision_id : '') ));
			}
		}
		else
		{
			$this->show_message('<em>'.$this->_t('WrongPage4Redirect').'</em>');
		}
	}
	else
	{
		$this->show_message('<em>'.$this->_t('WrongPage4Redirect').'</em>');
	}
}
else
{
	$this->show_message($this->_t('PermaLinkEmpty'));

}
