<?php

if (!defined('IN_WACKO'))
{
	exit;
}

?>
<div id="page" class="page">
<?php

if (!isset ($this->config['comments_count']))
{
	$this->config['comments_count'] = 15;
}

// redirect from comment page to the commented one
if ($this->page['comment_on_id'])
{
	// count previous comments
	$count = $this->load_single(
		"SELECT COUNT(tag) AS n ".
		"FROM {$this->config['table_prefix']}page ".
		"WHERE comment_on_id = '".quote($this->dblink, $this->page['comment_on_id'])."' ".
			"AND created <= '".quote($this->dblink, $this->page['created'])."' ".
		"GROUP BY comment_on_id ".
		"LIMIT 1", 1);

	// determine comments page number where this comment is located
	$p = ceil($count['n'] / $this->config['comments_count']);

	// forcibly open page
	$this->redirect($this->href('', $this->get_page_tag($this->page['comment_on_id']), 'show_comments=1&p='.$p).'#'.$this->page['tag']);
}

// display page body
if ($this->has_access('read'))
{
	if (!$this->page)
	{
		// Not sure what the point of wrapping it in the conditional was
		// if (function_exists('virtual')) header('HTTP/1.0 404 Not Found');
		header('HTTP/1.0 404 Not Found');

		echo '<br /><div class="notice">'.
			$this->get_translation('DoesNotExists') ." ".( $this->has_access('create') ?  str_replace('%1', $this->href('edit', '', '', 1), $this->get_translation('PromptCreate')) : '').
			'</div>';
	}
	else
	{
		// comment header?
		if ($this->page['comment_on_id'])
		{
			echo "<div class=\"commentinfo\">".$this->get_translation('ThisIsCommentOn')." ".$this->compose_link_to_page($this->get_page_tag($this->page['comment_on_id']), '', '', 0).", ".$this->get_translation('PostedBy')." ".($this->is_wiki_name($this->page['user_name']) ? $this->link($this->page['user_name']) : $this->page['user_name'])." ".$this->get_translation('At')." ".$this->get_time_string_formatted($this->page['modified'])."</div>";
		}

		// revision header
		if ($this->page['latest'] == 0)
		{
			echo "<div class=\"revisioninfo\">".
			str_replace('%1', $this->href(),
			str_replace('%2', $this->tag,
			str_replace('%3', $this->get_page_time_formatted(),
			str_replace('%4', '<a href="'.$this->href('', $this->config['users_page'], 'profile='.$this->page['user_name']).'">'.$this->page['user_name'].'</a>',
			$this->get_translation('Revision')))));

			// if this is an old revision, display ReEdit button
			if ($this->has_access('write'))
			{
				$latest = $this->load_page($this->tag);
				?>
				<br />
				<?php echo $this->form_open('edit') ?>
				<input type="hidden" name="previous" value="<?php echo $latest['modified'] ?>" />
				<input type="hidden" name="id" value="<?php echo htmlspecialchars($this->page['page_id']) ?>" />
				<input type="hidden" name="body" value="<?php echo htmlspecialchars($this->page['body']) ?>" />
				<input type="submit" value="<?php echo $this->get_translation('ReEditOldRevision') ?>" />
				<input name="cancel" id="button" type="button" value="<?php echo $this->get_translation('EditCancelButton') ?>" onclick="document.location='<?php echo addslashes($this->href()) ?>';" />
				<?php echo $this->form_close(); ?>
				<?php
			}

			echo "</div>";
		}

		// count page hit (we don't count for page owner)
		if ($this->get_user_id() != $this->page['owner_id'])
		{
			$this->sql_query(
				"UPDATE ".$this->config['table_prefix']."page ".
				"SET hits = hits + 1 ".
				"WHERE page_id = '".quote($this->dblink, $this->page['page_id'])."'");
		}

		$this->set_language($this->page_lang);

		// recompile if necessary
		if (($this->page['body_r'] == '') ||
		(($this->page['body_toc'] == '') && $this->config['paragrafica']))
		{
			// build html body
			$this->page['body_r'] = $this->format($this->page['body'], 'wacko');

			// build toc
			if ($this->config['paragrafica'])
			{
				$this->page['body_r']	= $this->format($this->page['body_r'], 'paragrafica');
				$this->page['body_toc']	= $this->body_toc;
			}

			// store to DB
			if ($this->page['latest'] != 0)
			{
				$this->sql_query(
					"UPDATE ".$this->config['table_prefix']."page SET ".
						"body_r		= '".quote($this->dblink, $this->page['body_r'])."', ".
						"body_toc	= '".quote($this->dblink, $this->page['body_toc'])."' ".
					"WHERE page_id = '".quote($this->dblink, $this->page['page_id'])."' ".
					"LIMIT 1");
			}
		}

		// display page
		$data = $this->format($this->page['body_r'], 'post_wacko', array('bad' => 'good'));
		$data = $this->numerate_toc( $data ); //  numerate toc if needed
		echo $data;

		$this->set_language($this->user_lang);
		?>
		<script type="text/javascript">
			var dbclick = "page";
		</script>
		<?php
	}
}
else
{
	// Not sure what the point of wrapping it in the conditional was
	// if (function_exists('virtual')) header('HTTP/1.0 403 Forbidden');
	if (!headers_sent())
	{
		header('HTTP/1.0 403 Forbidden');
	}

	echo $this->get_translation('ReadAccessDenied');
}
?>
<br style="clear: both" />&nbsp;</div>
<?php
// page comments and files
if ($this->method == 'show' && $this->page['latest'] > 0 && !$this->page['comment_on_id'])
{
	// revoking payload
	if (isset($_SESSION['guest']))
	{
		$guest					= $_SESSION['guest'];
		$_SESSION['guest']		= '';
	}
	else
	{
		$guest					= $this->get_cookie('guest');
	}

	if (isset($_SESSION['body']))
	{
		$payload				= $_SESSION['body'];
		$_SESSION['body']		= '';
	}

	if (isset($_SESSION['title']))
	{
		$title					= $_SESSION['title'];
		$_SESSION['title']		= '';
	}

	if (isset($_SESSION['preview']))
	{
		$preview				= $_SESSION['preview'];
		$_SESSION['preview']	= '';
	}

	if (!isset($this->config['footer_inside']))
	{
		// files code starts
		if ($this->config['footer_files'] == 1 || ($this->config['footer_files'] == 2 && $this->get_user()))
		{
			require_once('handlers/page/_files.php');
		}

		// comments form output  starts
		if (($this->config['footer_comments'] == 1 || ($this->config['footer_comments'] == 2 && $this->get_user()) ) && $this->user_allowed_comments())
		{
			require_once('handlers/page/_comments.php');
		}

		// rating form output begins
		if ($this->has_access('read') && $this->page && $this->config['footer_rating'] == 1 || ($this->config['footer_rating'] == 2 && $this->get_user()))
		{
			require_once('handlers/page/_rating.php');
		}
	}
}

?>