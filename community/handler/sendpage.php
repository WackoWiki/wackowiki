<?php

if (!defined('IN_WACKO'))
{
	exit;
}

if (!$this->page)
{
	$this->http->redirect($this->href());
}

if ($this->has_access('write'))
{
	if (!empty($_POST['email']))
	{
		$email_to		= $_POST['email'];

		if (!$this->validate_email_address($email_to))
		{
			$tpl->message = $this->show_message($this->_t('NotAEmail'), 'error', false);
		}
		else
		{
			$subject	= $this->page['title'];
			$user		= $this->get_user();
			$message	=
							$this->_t('EmailSubject') . $user['user_name'] . ' - ' . /* $user['email']  .*/ "\n\n" .

							$this->href('', $tag, null, null, null, null, true, true) . "\n\n" .
							$this->page['title'] . "\n" .
							"----------------------------------------------------------------------\n\n" .
							Ut::amp_decode($this->page['body']) . "\n\n" .
							"----------------------------------------------------------------------\n\n" .

							$this->_t('EmailDoNotReply') . "\n\n" .
							$this->db->site_name . "\n" .
							$this->db->base_url;

			$email = new Email($this);
			$email->send_mail($email_to, $email_to, $subject, $message);

			$this->set_message($this->_t('SendPage'));

			$this->http->redirect($this->href());
		}
	}
	else
	{
		#$tpl->data = $this->format($this->page['body'], 'wiki');
		$tpl->data = $this->format($this->page['body'], 'source'); // -> [ ' data | pre ' ]
	}
}
else
{
	$this->http->redirect($this->href());
}
