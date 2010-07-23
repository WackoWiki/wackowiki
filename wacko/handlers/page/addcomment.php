<?php

if ($this->HasAccess("comment") && $this->HasAccess("read"))
{
	// find number
	if ($latestComment = $this->LoadSingle("SELECT tag, page_id FROM ".$this->config["table_prefix"]."page WHERE comment_on_id != '0' ORDER BY page_id DESC LIMIT 1"))
	{
		preg_match("/^Comment([0-9]+)$/", $latestComment["tag"], $matches);
		$num = $matches[1] + 1;
	}
	else
	{
		$num = "1";
	}

	$user = $this->GetUser();
	$body = str_replace("\r", "", $_POST["body"]);
	$body = trim($_POST["body"]);

	if(isset($_POST["title"]))
	{
		$title = trim($_POST["title"]);
	}

	// watch page
	if ($this->page && $_POST['watchpage'] && $_POST['noid_publication'] != $this->tag && $user && $this->iswatched !== true)
	{
		$this->SetWatch($user['user_id'], $this->page['page_id']);
	}

	if (!$body)
	{
		if (!$user) $this->cache->CacheInvalidate($this->supertag);
		$this->SetMessage($this->GetTranslation("EmptyComment"));
	}
	else if ($_POST['preview'])
	{
		// comment preview
		if (!$user) $this->cache->CacheInvalidate($this->supertag);
		$_SESSION['preview']	= $body;
		$_SESSION['body']		= $body;
		$_SESSION['guest']		= $guest;
		$this->redirect($this->href('', '', 'show_comments=1&p=last').'#preview');
	}
	else if ($_SESSION['comment_delay'] && ((time() - $_SESSION['comment_delay']) < $this->config['comment_delay']))
	{
		// posting flood protection
		if (!$user) $this->cache->CacheInvalidate($this->supertag);
		$this->SetMessage('<div class="error">'.str_replace('%1', $this->config['comment_delay'], $this->GetRes('CommentFlooded')).'</div>');
		$_SESSION['body']			= $body;
		$_SESSION['comment_delay']	= time();
		$this->redirect($this->href('', '', 'show_comments=1&p=last'));
	}
	else
	{
		// Start Comment Captcha

		// Only show captcha if the admin enabled it in the config file
		if ($this->config["captcha_new_comment"])
		{
			// Don't load the captcha at all if the GD extension isn't enabled
			if (extension_loaded('gd'))
			{
				//check whether anonymous user
				//anonymous user has the IP or host name as name
				//if name contains '.', we assume it's anonymous
				if (strpos($this->GetUserName(), '.'))
				{
					//anonymous user, check the captcha
					if (!empty($_SESSION['freecap_word_hash']) && !empty($_POST['word']))
					{
						if ($_SESSION['hash_func'](strtolower($_POST['word'])) == $_SESSION['freecap_word_hash'])
						{
							// reset freecap session vars
							// cannot stress enough how important it is to do this
							// defeats re-use of known image with spoofed session id
							$_SESSION['freecap_attempts'] = 0;
							$_SESSION['freecap_word_hash'] = false;
							$_SESSION['freecap_old_comment'] = "";

							// now process form
							$word_ok = true;
						}
						else
						{
							$word_ok = false;
						}
					}
					else
					{
						$word_ok = false;
					}

					if (!$word_ok)
					{
						//not the right word
						$error = $this->GetTranslation("SpamAlert");
						$this->SetMessage($this->GetTranslation("SpamAlert"));
						$_SESSION['freecap_old_comment'] = $body;
					}
				}
			}
		}

		// everything's okay
		$_SESSION['preview']		= '';
		$_SESSION['body']			= '';
		$_SESSION['guest']			= '';
		$_SESSION['comment_delay']	= time();

		// publish anonymously
		if ($_POST['noid_publication'] == $this->tag)
		{
			// undefine username
			$remember_name = $this->GetUserName();
			$this->SetUserSetting('user_name', NULL);
		}

		if (!$error)
		{
			$comment_on_id = $this->GetPageId();
			// store new comment
			$this->SavePage("Comment".$num, $title, $body, $edit_note = "", $minor_edit = "0", $comment_on_id);

			// log event
			$this->Log(5, str_replace("%2", $this->tag." ".$this->page["title"], str_replace("%1", "Comment".$num, $this->GetTranslation("LogCommentPosted"))));

		// restore username after anonymous publication
		if ($_POST['noid_publication'] == $this->tag)
		{
			$this->SetUserSetting('user_name', $remember_name);
			unset($remember_name);
			if ($body_r) $this->SetUserSetting('noid_protect', true);
		}

		// now we render it internally so we can write the updated link table.
		$this->ClearLinkTable();
		$this->StartLinkTracking();
		$dummy = $this->Format($body_r, 'post_wacko');
		$this->StopLinkTracking();
		$this->WriteLinkTable('Comment'.$num);
		$this->ClearLinkTable();

			$this->SetMessage($this->GetTranslation("CommentAdded"));
		}

		// End Comment Captcha
	}

	// redirect to page
	$this->Redirect($this->href('', '', 'show_comments=1&p=last').'#Comment'.$num);
}
else
{
	print("<div id=\"page\">".$this->GetTranslation("CommentAccessDenied")."</div>\n");
}

?>