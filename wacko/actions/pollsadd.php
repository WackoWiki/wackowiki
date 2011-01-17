<?php

// Action parameters:
// moderation=["true","false"]	Run action in moderation context.
//								Default: "false"
// edit_id=[id]					Edit/moderate given poll. Only
//								useful with "moderation='true'".
//								Default: null

if (!isset($moderation)) $moderation = '';
$stop_mod = '';
$error = '';
$message = '';
$mode_file = '';
$topic = '';
$plural = '';
$startmod = '';

// create polls object
$this->use_class('polls');
$polls_obj = new Polls($this);

// define context
$admin = $this->is_admin();

// basic privilege check for moderation mode
if ($moderation === true && !$admin) $moderation === false;

// preloading poll data for moderation purposes
if ($moderation === true)
{
	if ($edit_id)
	{
		$header			= $polls_obj->get_poll_title($edit_id);
		$vars			= $polls_obj->get_poll_vars($edit_id);
		$topic			= $header['text'];
		$user			= $header['user_name'];
		$plural			= $header['plural'];
	}

	if ($mode == true && $_REQUEST['mode'] == $mode)
	{
		$mode_http = 'mode='.$mode.'&amp;';
		$mode_file = $_SERVER['PHP_SELF'];
	}
	else
	{
		$mode_http = '';
		$mode_file = '';
	}
}

// passing variables from submitted form
if ($admin)
{
	if ($moderation === true)
	{
		if (isset($_POST['moderation']))	$edit_id	= $_POST['moderation'];
		if (isset($_POST['user']))			$user		= $_POST['user'];
	}
	if (isset($_POST['startmod']))			$startmod	= $_POST['startmod'];
}
if (isset($_POST['plural']))				$plural		= $_POST['plural'];
if (isset($_POST['topic']))					$topic		= $_POST['topic'];

$i = 1;
foreach ($_POST as $key => $value)
{
	if (preg_match('/^[0-9]{1,2}$/', $key))
	{
		$vars[] = array('v_id' => $i, 'text' => $value);
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
	$strip = array('<', '>', '[', ']', '\\', "'", '"');

	foreach ($_POST as $key => $value)
	{
		if		($key == 'user')		$user		= str_replace($strip, '', $value);
		else if ($key == 'plural')		$plural		= str_replace($strip, '', $value);
		else if ($key == 'startmod')	$startmod	= str_replace($strip, '', $value);
		else if ($key == 'topic')		$topic		= str_replace($strip, '', $value);
		else if (preg_match('/^[0-9]{1,2}$/', $key) && str_replace(' ', '', $value))
			$answers[] = str_replace($strip, '', $value);
	}

	// missing poll topic
	if ($topic == '') $error = $this->get_translation('PollsNeedTopic');

	// we need at least two alternate answers
	if (count($answers) < 2) $error .= ' '.$this->get_translation('PollsNeedAnswers');

	// captcha validation
	#if (!$this->get_user() && $this->ValidateCAPTCHA() === false)
	#	$error .= ' '.$this->get_translation('CaptchaFailed');

	// in case no errors found submit poll or changes to the db
	if (!$error)
	{
		if (!isset($user_id))		$user_id		= $this->get_user_id();
		#if (!$user)				$user		= $this->get_user_ip();
		if (!isset($edit_id))	$edit_id	= $polls_obj->get_last_poll_id() + 1;
		// remove moderated poll
		if ($moderation === true)	$polls_obj->remove_poll($edit_id);
		// save new or update moderated poll
		$polls_obj->submit_poll($edit_id, $topic, $plural, $answers, $user_id, ($startmod == 1 && $admin ? 1 : 0));
		// update page cache
		if ($this->tag) $this->cache->cache_invalidate($this->supertag);
		// update news RSS feed
		if ($startmod == 1)
		{
			#$this->use_class('rss');
			#$xml = new rss($this);
			#$xml->news();
			unset($xml);
		}
		// set confirmation message
		if ($moderation !== true)	  $message = $this->get_translation('PollsSubmitted').
									  ($startmod == 1 && $admin
									  	? ''
										: ' '.$this->get_translation('PollsSubmittedMod'));
		// stopping moderation
		if ($moderation === true)	  $stop_mod = true;
		// notify wiki owner & log event
		if ($user != $this->config['admin_name'] && $moderation !== true)
		{
			$subject = $this->config['wacko_name'].'. '.$this->get_translation('PollsNotifySubj');
			$body	 = $this->get_translation('MailHello').
					   $this->config['admin_name'].".\n\n".
					   str_replace('%1', $user, $this->get_translation('PollsNotifyBody'))."\n".
					   $this->href('', 'admin.php')."\n\n".
					   $this->get_translation('MailGoodbye')."\n".
					   $this->config['wacko_name']."\n".
					   $this->config['base_url'];
			$this->send_mail($this->config['admin_email'], $subject, $body);
			$this->log(4, str_replace('%1', $edit_id, $this->get_translation('LogPollCreated', $this->config['language'])));
		}
		else if ($moderation === true)
		{
			$this->log(4, str_replace('%1', $edit_id, $this->get_translation('LogPollChanged', $this->config['language'])));
		}

		// log if we started a poll
		if ($startmod == 1 && $admin)
		{
			$this->log(4, str_replace('%1', $edit_id, $this->get_translation('LogPollStarted', $this->config['language'])));
		}
	}
}

if ($stop_mod !== true)
{
	// managing number of survey answers
	$total_vars = count($vars);
	if (isset($_POST['addvar']) && $total_vars < 20) {
		$vars[] = array('v_id' => $total_vars + 1, 'text' => '');
		$total_vars++;
	}
	if (isset($_POST['delvar']) && $total_vars > 5) {
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
			$vars[] = array('v_id' => $i, 'text' => '');
			$i++;
		}
		$total_vars = 5;
	}
}

// print error message, if any
if ($error) $this->set_message($error);

// for successful submit print a message
// else show input form
if ($message)
{
	$this->set_message($message);
}
else if ($stop_mod !== true)
{
	// printing form
	echo $this->form_open('', $mode_file, 'post', '', '', '#pollsadd_form');
	echo ($moderation === true ? '<input name="mode" type="hidden" value="'.$mode.'" />'.
		'<input name="moderation" type="hidden" value="'.$edit_id.'" />'.
		'<input name="user" type="hidden" value="'.$user.'" />' : '');
	echo '<a name="pollsadd_form"></a><table cellspacing="3" class="formation">';
	echo '<tr>';
		echo '<th>'.$this->get_translation('PollsTopic').':</th>';
		echo '<th style="text-align:left;"><input name="topic" type="text" size="70" maxlength="250" value="'.$topic.'" style="font-weight:normal;" /></th>';
	echo '</tr>';
	// fill out survey answers
	foreach ($vars as $var)
	{
		echo '<tr>';
			echo '<td class="label">'.$this->get_translation('PollsVariant').' '.$var['v_id'].':</td>';
			echo '<td><input name="'.$var['v_id'].'" type="text" size="40" maxlength="250" value="'.$var['text'].'" /></td>';
		echo '</tr>';
	}
	echo '<tr class="lined">';
		echo '<td></td>';
		echo '<td>';
		if ($total_vars < 20)
			echo '<input name="addvar" id="submit" type="submit" value="'.$this->get_translation('PollsAddVariant').'" /> ';
		if ($total_vars > 5)
			echo '<input name="delvar" id="submit" type="submit" value="'.$this->get_translation('PollsDelVariant').'" />';
		echo '</td>';
	echo '</tr>';
	echo '<tr><td colspan="2">'.
		'<input name="plural" type="checkbox" id="plural" value="1"'.($plural == 1 ? ' checked="checked" ' : ' ').'/> '.
		'<label for="plural">'.$this->get_translation('PollsPlural').'</label>'.
		'</td></tr>';
	echo '<tr><td colspan="2">';
	// begin captcha output
	echo '<input name="submit_poll" id="submit" type="submit" value="'.$this->get_translation('PollsSubmit').'" /> ',
		( $this->get_user() ? false : true );
	// end captcha output
		echo ($moderation === true ? '<input name="cancel" id="button" type="button" value="'.$this->get_translation('PollsCancel').'" onclick="document.location=\''.addslashes($this->href('', $mode_file, $mode_http)).'\';" />' : '').
			($admin ? '&nbsp;&nbsp;&nbsp;&nbsp;<input name="startmod" type="checkbox" id="startmod" value="1"'.($startmod == 1 ? ' checked="checked" ' : ' ').'/> '.
			'<label for="startmod">'.$this->get_translation('PollsStartMod').'</label>' : '').
			'</td></tr>';
	echo '</table>';
	echo $this->form_close();
}

// destroy polls object
unset($polls_obj);

?>
