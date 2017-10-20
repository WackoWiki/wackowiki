<?php

if (!defined('IN_WACKO'))
{
	exit;
}

// Action parameters:
// moderation=['true'|'false']	Run action in moderation context.
//								Default: 'false'
// edit_id=[id]					Edit/moderate given poll. Only
//								useful with "moderation='true'" .
//								Default: null

if (!isset($moderation)) $moderation = '';
$stop_mod	= '';
$error		= '';
$message	= '';
$mode_file	= '';
$topic		= '';
$plural		= '';
$startmod	= '';
$vars		= [];

// create polls object
$polls_obj = new Polls($this);

// define context
$admin = $this->is_admin();

// basic privilege check for moderation mode
if ($moderation === true && !$admin)
{
	$moderation = false;
}

// preloading poll data for moderation purposes
if ($moderation === true)
{
	if ($edit_id)
	{
		$header			= $polls_obj->get_poll_title($edit_id);
		$vars			= $polls_obj->get_poll_vars($edit_id);
		$topic			= $header['text'];
		$user_id		= $header['user_id'];
		$user_name		= $header['user_name'];
		$plural			= $header['plural'];
	}

	if ($mode == true && $_REQUEST['mode'] == $mode)
	{
		$mode_http	= 'mode=' . $mode.'&amp;';
		$mode_file	= $_SERVER['PHP_SELF'];
	}
	else
	{
		$mode_http	= '';
		$mode_file	= '';
	}
}

// passing variables from submitted form
if ($admin)
{
	if ($moderation === true)
	{
		if (isset($_POST['moderation']))	$edit_id	= (int) $_POST['moderation'];
		if (isset($_POST['user_id']))		$user_id	= (int) $_POST['user_id'];
	}

	if (isset($_POST['startmod']))			$startmod	= $_POST['startmod'];
}

if (isset($_POST['plural']))				$plural		= $_POST['plural'];
if (isset($_POST['topic']))					$topic		= htmlspecialchars($_POST['topic'], ENT_COMPAT | ENT_HTML5, HTML_ENTITIES_CHARSET);

$i = 1;

foreach ($_POST as $key => $value)
{
	if (preg_match('/^[0-9]{1,2}$/', $key))
	{
		$vars[] =['v_id' => $i, 'text' => htmlspecialchars($value, ENT_COMPAT | ENT_HTML5, HTML_ENTITIES_CHARSET)];
		$i++;
	}

	// strange bug with inserted keys
	unset($vars['moderation']);
	unset($vars['edit_id']);
}

// parsing and validating submitted poll
if (isset($_POST['submit_poll']))
{
	//parsing input
	$strip = ['<', '>', '[', ']', '\\', "'", '"'];

	foreach ($_POST as $key => $value)
	{
		if		($key == 'user_id')		$user_id	= str_replace($strip, '', $value);
		else if ($key == 'plural')		$plural		= str_replace($strip, '', $value);
		else if ($key == 'startmod')	$startmod	= str_replace($strip, '', $value);
		else if ($key == 'topic')		$topic		= str_replace($strip, '', $value);
		else if (preg_match('/^[0-9]{1,2}$/', $key) && str_replace(' ', '', $value))
		{
			$answers[] = str_replace($strip, '', $value);
		}
	}

	// missing poll topic
	if ($topic == '')
	{
		$error = $this->_t('PollsNeedTopic');
	}

	// we need at least two alternate answers
	if (count($answers) < 2)
	{
		$error .= ' ' . $this->_t('PollsNeedAnswers');
	}

	// captcha validation
	#if (!$this->get_user() && $this->ValidateCAPTCHA() === false)
	#	$error .= ' ' . $this->_t('CaptchaFailed');

	// in case no errors found submit poll or changes to the db
	if (!$error)
	{
		if (!isset($user_id))
		{
			$user_id	= $this->get_user_id();
		}

		if (!isset($edit_id))
		{
			$edit_id	= $polls_obj->get_last_poll_id() + 1;
		}

		// remove moderated poll
		if ($moderation === true)
		{
			$polls_obj->remove_poll($edit_id);
		}

		// save new or update moderated poll
		$polls_obj->submit_poll($edit_id, $topic, $plural, $answers, $user_id, ($startmod == 1 && $admin ? 1 : 0));

		// update page cache
		if ($this->tag)
		{
			$this->http->invalidate_page($this->supertag);
		}

		// update news RSS feed
		if ($startmod == 1)
		{
			#$xml = new Feed($this);
			#$xml->feed();
			unset($xml);
		}
		// set confirmation message
		if ($moderation !== true)
		{
			$message = $this->_t('PollsSubmitted') .
				($startmod == 1 && $admin
					? ''
					: ' ' . $this->_t('PollsSubmittedMod'));
		}

		// stopping moderation
		if ($moderation === true)
		{
			$stop_mod = true;
		}

		$user = $this->get_user_name();

		// notify wiki owner & log event
		if ($this->db->enable_email == true && $user != $this->db->admin_name && $moderation !== true)
		{
			$subject =	$this->_t('PollsNotifySubj');
			$body	 =	str_replace('%1', $user, $this->_t('PollsNotifyBody')) . "\n" .
						$this->href('', 'admin.php') . "\n\n";

			#$this->send_user_email('System', $subject, $body);

			$this->log(4, str_replace('%1', $edit_id, $this->_t('LogPollCreated', $this->db->language)));
		}
		else if ($moderation === true)
		{
			$this->log(4, str_replace('%1', $edit_id, $this->_t('LogPollChanged', $this->db->language)));
		}

		// log if we started a poll
		if ($startmod == 1 && $admin)
		{
			$this->log(4, str_replace('%1', $edit_id, $this->_t('LogPollStarted', $this->db->language)));
		}
	}
}

if ($stop_mod !== true)
{
	// managing number of survey answers
	$total_vars = count($vars);

	if (isset($_POST['addvar']) && $total_vars < 20)
	{
		$vars[] = ['v_id' => $total_vars + 1, 'text' => ''];
		$total_vars++;
	}

	if (isset($_POST['delvar']) && $total_vars > 5)
	{
		end($vars);
		$i = key($vars);
		unset($vars[$i]);
		$total_vars--;
	}

	// fill vars array for a new poll or add absent vars
	if ($total_vars < 5)
	{
		$i = $total_vars + 1;

		while ($i < 6)
		{
			$vars[] = ['v_id' => $i, 'text' => ''];
			$i++;
		}

		$total_vars = 5;
	}
}

// print error message, if any
if ($error)
{
	$this->set_message($error, 'error');
}

// for successful submit print a message
// else show input form
if ($message)
{
	$this->set_message($message);
}
else if ($stop_mod !== true)
{
	// printing form
	echo $this->form_open('add_poll', ['page_method' => $mode_file, 'href_param' => '#pollsadd_form']);
	echo ($moderation === true ? '<input type="hidden" name="mode" value="' . $mode . '">' .
		'<input type="hidden" name="moderation" value="' . $edit_id . '">' .
		'<input type="hidden" name="user_id" value="' . $user_id . '">' : '');
	echo '<table id="pollsadd_form" class="formation">';
	echo '<tr>';
		echo '<th>' . $this->_t('PollsTopic') . ':</th>';
		echo '<td class="t_left"><input type="text" name="topic" size="70" maxlength="250" value="' . $topic . '"></td>';
	echo '</tr>';

	// fill out survey answers
	foreach ($vars as $var)
	{
		echo '<tr class="lined">';
			echo '<td class="label"><label for="pollvariant_' . $var['v_id'] . '">' . $this->_t('PollsVariant') . ' ' . $var['v_id'] . ':</label></td>';
			echo '<td><input type="text" id="pollvariant_' . $var['v_id'] . '" name="' . $var['v_id'] . '" size="40" maxlength="250" value="' . htmlspecialchars($var['text'], ENT_COMPAT | ENT_HTML5, HTML_ENTITIES_CHARSET) . '"></td>';
		echo '</tr>';
	}

	echo '<tr class="lined">';
		echo '<td></td>';
		echo '<td>';

		if ($total_vars < 20)
		{
			echo '<input type="submit" name="addvar" id="submit" value="' . $this->_t('PollsAddVariant') . '"> ';
		}

		if ($total_vars > 5)
		{
			echo '<input type="submit" name="delvar" id="submit" value="' . $this->_t('PollsDelVariant') . '">';
		}

		echo '</td>';
	echo '</tr>';
	echo '<tr><td colspan="2">' .
		'<input type="checkbox" name="plural" id="plural" value="1"' . ($plural == 1 ? ' checked ' : ' ') . '> '.
		'<label for="plural">' . $this->_t('PollsPlural') . '</label>' .
		'</td></tr>';
	echo '<tr><td colspan="2">';
	// begin captcha output
	echo '<input type="submit" name="submit_poll" id="submit" value="' . $this->_t('PollsSubmit') . '"> ',
		( $this->get_user() ? false : true );
	// end captcha output
		echo ($moderation === true ? '<a href="' . $this->href('', $mode_file, $mode_http) . '" class="btn_link"><input type="button" name="cancel" id="button" value="' . $this->_t('PollsCancel') . '"></a>' : '') .
			($admin ? '&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="startmod" id="startmod" value="1"' . ($startmod == 1 ? ' checked ' : ' ') . '> '.
			'<label for="startmod">' . $this->_t('PollsStartMod') . '</label>' : '') .
			'</td></tr>';
	echo '</table>';
	echo $this->form_close();
}

// destroy polls object
unset($polls_obj);

?>
