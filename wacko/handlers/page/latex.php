<div class="pageBefore"><img
	src="<?php echo $this->GetConfigValue("root_url"); ?>images/z.gif"
	width="1" height="1" border="0" alt="" style="display: block"
	align="top" /></div>
<div class="page"><?php
if ($this->HasAccess("read"))
{
	if (!$this->page)
	{
		print(str_replace("%1",$this->href("edit"),$this->GetResourceValue("DoesNotExists")));
	}
	else
	{
		// comment header?
		if ($this->page["comment_on"])
		{
			print("<div class=\"commentinfo\">This is a comment on ".$this->ComposeLinkToPage($this->page["comment_on"], "", "", 0).", posted by ".$this->Format($this->page["user"])." at ".$this->page["time"]."</div>");
		}

		if ($this->page["latest"] == "N")
		{
			print("<div class=\"revisioninfo\">".
			str_replace("%1",$this->href(),
			str_replace("%2",$this->GetPageTag(),
			str_replace("%3",$this->page["time"],
			$this->GetResourceValue("Revision")))).".</div>");
		}

		// display page
		$this->context[++$this->current_context] = $this->tag;

		$text = preg_replace("/{{(tableofcontents|toc).*?}}/i", "", $this->page["body"]);
		$data = $this->Format($text, "wakka");

		// Convert everything that doesn't need regexps
		$data = str_replace(
		array(
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
		),
		array(
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
		),
		$data
		);

		// Convert the cool stuff
		$data = preg_replace(
		array(
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
		),
		array(
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
		),
		$data
		);

		print '<code>'.nl2br(trim($data)).'</code>';

		$this->current_context--;

	}
}
else
{
	print($this->GetResourceValue("ReadAccessDenied"));
}
?></div>
