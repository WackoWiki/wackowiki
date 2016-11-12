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
			echo '<div class="comment-info">' . $this->_t('ThisIsCommentOn')." ".$this->compose_link_to_page($this->get_page_tag($this->page['comment_on_id']), "", "", 0).", ".$this->_t('PostedBy')." ".($this->is_wiki_name($this->page['user_name']) ? $this->link($this->page['user_name']) : $this->page['user_name'])." ".$this->_t('At')." ".$this->page['modified']."</div>";
		}

		if (!$this->page['latest'])
		{
			echo '<div class="revisioninfo">'.
				Ut::perc_replace($this->_t('Revision'), $this->href(), $this->tag, $this->page['modified']).
				'</div>';
		}

		// display page
		$this->context[++$this->current_context] = $this->tag;
		$text = preg_replace('/{{(tableofcontents|toc).*?}}/i', '', $this->page['body']);
		$data = $this->format($text, 'wiki');

		// Convert everything that doesn't need regexps
		$data = str_replace(
		[
			"<br />\n",						// Strip newlines
			'&nbsp;',						// Blanks to blanks for easier handling
			'<strong>',						// Bold
			'</strong>',
			'<em>',							// Emphasized
			'</em>',
			'<small>',						// Small
			'</small>',
			'<tt>',							// Monospaced
			'</tt>',
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

		print '<code>'.nl2br(trim($data)).'</code>';

		$this->current_context--;

	}
}
else
{
	$message = $this->_t('ReadAccessDenied');
	$this->show_message($message, 'info');
}
