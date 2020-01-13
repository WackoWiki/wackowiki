<?php

if (!defined('IN_WACKO'))
{
	exit;
}

// Converts parsed WackoWiki Markup to LaTeX

if ($text == '')
{
	return;
}

$text = preg_replace('/{{(toc).*?}}/ui', '', $text);
$data = $this->format($text, 'wiki');

// convert everything that doesn't need regexps
$data = str_replace(
[
	"<br>\n",							// Strip newlines
	'&nbsp;',							// Blanks to blanks for easier handling
	'<strong>',							// Bold
	'</strong>',
	'<em>',								// Emphasized
	'</em>',
	'<small>',							// Small
	'</small>',
	'<del>',							// Strikethough
	'</del>',
	'<blockquote>',						// Blockquote
	'</blockquote>',
	'</pre>',							// Preformatted
	'<code>',							// Monospaced
	'</code>',
	'<li>',								// List item
	'</li>',
	'</ul>',							// End of unnumbered list
	'</ol>',							// End of numbered list
],
[
	"\n",								// <br>
	' ',								// &nbsp;
	'\textbf{',							// strong
	'}',
	'\emph{',							// em
	'}',
	'\textsmaller{',					// small
	'}',
	'\sout{',							// del
	'}',
	"\n\\begin{quotation}\n",			// blockquote
	"\n\\end{quotation}\n\n",
	"\n\\end{verbatim}",				// </pre>
	'\texttt{',							// code
	'}',
	'&nbsp;&nbsp;&nbsp;&nbsp;\item ',	// li
	"\n",
	"\\end{itemize}\n\n",				// </ul>
	"\\end{enumerate}\n\n",				// </ol>
],
$data
);

// convert the cool stuff
$data = preg_replace(
[
	'|%%\(math\)(.*)%%|Us',				// Math formula
	'|%%\(math outline\)(.*)%%|Us',		// Math outline
	'|<h1[^>]*>\s*?(.*)\s*</h1>|U',		// Headings
	'|<h2[^>]*>\s*?(.*)\s*</h2>|U',
	'|<h3[^>]*>\s*?(.*)\s*</h3>|U',
	'|<h4[^>]*>\s*?(.*)\s*</h4>|U',
	'|<h5[^>]*>\s*?(.*)\s*</h5>|U',
	'|<h6[^>]*>\s*?(.*)\s*</h6>|U',
	'|<pre[^>]*>|U',					// Preformatted
	'|<ul[^>]*>|U',						// Unnumbered list
	'|<ol[^>]*>|U',						// Numbered list
	# '|<!--\([^<]*\)-->|U',				// Comment
	'|<span class="underline">(.*)</span>|U',	// Separate paragraphs by blank line
	'|<p.*>(.*)</p>|Us',				// Separate paragraphs by blank line
	'|</?.*>|U',						// Strip all other HTML tags
	'|( *\n){3,}|m',					// Cut all \n\n\n... to \n\n
],
[
	'$\\1$',
	'$$\1$$',
	"\n\\chapter{\\1}\n",				// h1
	"\n\\section{\\1}\n",				// h2
	"\n\\subsection{\\1}\n",			// h3
	"\n\\subsubsection{\\1}\n",			// h4
	"\n\\paragraph{\\1}\n",				// h5
	"\n\\subparagraph{\\1}\n",			// h6
	"\n\\begin{verbatim}\n",			// </pre>
	"\n\\begin{itemize}\n",				// ul
	"\n\\begin{enumerate}\n",			// ol
	# "\n\\begin{comment}{\1}\\end{comment}\n",	// <!-- comment -->
	"\underline{\\1}",					// underline
	"\\1\n\n",							// p
	'',
	"\n\n",
],
$data
);

echo nl2br(trim($data));
