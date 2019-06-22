<?php

if (!defined('IN_WACKO'))
{
	exit;
}

// redirect to show method if page don't exists
if (!$this->page)
{
	$this->http->redirect($this->href());
}

if ($this->has_access('read'))
{
	if (!$this->page)
	{
		echo Ut::perc_replace($this->_t('DoesNotExists'), $this->href('edit'));
	}
	else
	{
		// comment header?
		if ($this->page['comment_on_id'])
		{
			$comment_on = $this->load_page('', $this->page['comment_on_id'], '', '', LOAD_META);
			$message = $this->this_is_comment_on(
				$comment_on['tag'],
				$comment_on['title'],
				$this->page['user_name'],
				$this->page['modified']);
			$this->show_message($message, 'comment-info');
		}

		if (!$this->page['latest'])
		{
			echo '<div class="revision-info">' .
				Ut::perc_replace($this->_t('RevisionHint'), $this->href(), $this->tag, $this->page['modified']) .
				'</div>';
		}

		// display page
		$this->context[++$this->current_context] = $this->tag;
		$text = preg_replace('/{{(toc).*?}}/i', '', $this->page['body']);
		$data = $this->format($text, 'wiki');

		// Convert everything that doesn't need regexps
		$data = str_replace(
		[
			"<br>\n",						// Strip newlines
			'&nbsp;',						// Blanks to blanks for easier handling
			'<strong>',						// Bold
			'</strong>',
			'<em>',							// Emphasized
			'</em>',
			'<small>',						// Small
			'</small>',
			'<code>',						// Monospaced
			'</code>',
			'<li>',							// List item
			'</li>',
			'</ul>',						// End of unnumbered list
			'</ol>',						// End of numbered list
		],
		[
			"\n",
			' ',
			'\textbf{',
			'}',
			'\emph{',
			'}',
			'\textsmaller{',
			'}',
			'\texttt{',
			'}',
			'&nbsp;&nbsp;&nbsp;&nbsp;\item ',
			"\n",
			"\\end{itemize}\n\n",
			"\\end{enumerate}\n\n",
		],
		$data
		);

		// Convert the cool stuff
		$data = preg_replace(
		[
			'|%%\(math\)(.*)%%|Us',			// Math formula
			'|%%\(math outline\)(.*)%%|Us',	// Math outline
			'|<h1>\s*?(.*)\s*</h1>|U',		// Headings
			'|<h2>\s*?(.*)\s*</h2>|U',
			'|<h3>\s*?(.*)\s*</h3>|U',
			'|<ul[^>]*>|U',					// Unnumbered list
			'|<ol[^>]*>|U',					// Numbered list
			'|<p.*>(.*)</p>|Us',			// Separate paragraphs by blank line
			'|</?.*>|U',					// Strip all other HTML tags
			'|( *\n){3,}|m',				// Cut all \n\n\n... to \n\n
		],
		[
			'$\\1$',
			'$$\1$$',
			"\n\\section{\\1}\n",
			"\n\\subsection{\\1}\n",
			"\n\\subsubsection{\\1}\n",
			"\n\\begin{itemize}\n",
			"\n\\begin{enumerate}\n",
			"\\1\n\n",
			'',
			"\n\n",
		],
		$data
		);

		echo '<code>' . nl2br(trim($data)) . '</code>';

		$this->current_context--;

	}
}
else
{
	$this->http->status(403);

	$message = $this->_t('ReadAccessDenied');
	$this->show_message($message, 'info');
}
