<?php

// {{permalinkproxy page_id=[number] preview=[0|1] permanent="0 or 1"}}

if (isset($_GET['page_id']))
{
	$page_id = (int)$_GET['page_id'];
}

if (isset($_GET['rev_id']))
{
	$revision_id = (int)$_GET['rev_id'];
}
else
{
	$revision_id = 0;
}

if (!isset($preview)) $preview = 0;

if ( isset($page_id) )
{
	$page_tag = $this->get_page_tag_by_id($page_id);

	#$is_permanent	= (isset($vars['permanent']) ? $vars['permanent'] : 0);

	// TODO: check permissions if page is accessible
	// show?revision_id=970

	if ($page_tag)
	{
		if (isset($is_permanent))
		{
			header("HTTP/1.0 301 Moved Permanently");
		}

		if ($_page = $this->load_page('', $page_id, $revision_id, LOAD_CACHE, LOAD_META))
		{
			if ($user = $this->get_user() || $preview)
			{
				if ($user['dont_redirect'] == 1 || (isset($_POST['redirect']) && $_POST['redirect'] == 'no') || $preview)
				{
					// This is the current revision of this page, as edited by [user_name] at [modified]. The present address (URL) is a permanent link to this version.
					// This is an old revision of this page, as edited by [user_name] at [modified]. It may differ significantly from the current revision.
					echo '<div class="info">'.$this->get_translation((isset($revision_id) ? 'PermaLinkRevision' :'PermaLinkRecent'))." ".$this->link('/'.$page_tag).'</div>';

					if (isset($revision_id))
					{
						echo "<div class=\"revisioninfo\">".
						str_replace('%1', $this->href(),
						str_replace('%2', $this->tag,
						str_replace('%3', $this->get_time_string_formatted($_page['modified']),
						str_replace('%4', '<a href="'.$this->href('', $this->config['users_page'], 'profile='.$_page['user_name']).'">'.$_page['user_name'].'</a>',
						$this->get_translation('Revision')))));
						echo "</div>";
					}

					echo "<div class=\"\">".$this->action('include', array('page' => '/'.$page_tag, 'notoc' => 0, 'nomark' => 0, 'revision_id' => $revision_id), 1)."</div>\n";
				}
				else
				{
					$this->set_message($this->get_translation('PermaLinkRedirected').': '.$page_id);
					$this->redirect($this->href('', $page_tag, (!empty($revision_id) ? 'revision_id='.$revision_id : '') ));
				}
			}
			else
			{
				#$this->set_message($this->get_translation('PermaLinkRedirected').': '.$page_id);
				$this->redirect($this->href('', $page_tag, (!empty($revision_id) ? 'revision_id='.$revision_id : '') ));
			}
		}
		else
		{
			echo '<div class="info"><i>'.$this->get_translation('WrongPage4Redirect').'</i></div>';
		}
	}
	else
	{
		echo '<div class="info"><i>'.$this->get_translation('WrongPage4Redirect').'</i></div>';
	}
}
else
{
	echo '<div class="info">'.$this->get_translation('PermaLinkEmpty').'</div>';

};

?>