<?php
/**
 * Phiki Syntax Highlighter Formatter for WackoWiki
 */

use Phiki\Phiki;
use Phiki\Grammar\Grammar;
use Phiki\Theme\Theme;

$lang_input = strtolower(trim($options['_default'] ?? 'text'));

$grammar_map = [
	'text'       => Grammar::Txt,
	'txt'        => Grammar::Txt,
	'php'        => Grammar::Php,
	'javascript' => Grammar::Javascript,
	'js'         => Grammar::Javascript,
	'css'        => Grammar::Css,
	'html'       => Grammar::Html,
	'sql'        => Grammar::Sql,
	'python'     => Grammar::Python,
	'java'       => Grammar::Java,
	'cpp'        => Grammar::Cpp,
	'c'          => Grammar::C,
	'json'       => Grammar::Json,
	'xml'        => Grammar::Xml,
	'bash'       => Grammar::Shellscript,
	'sh'         => Grammar::Shellscript,
	'shell'      => Grammar::Shellscript,
	'markdown'   => Grammar::Markdown,
	'md'         => Grammar::Markdown,
];

$grammar = $grammar_map[$lang_input] ?? Grammar::Txt;

$theme = Theme::GithubLight;

if (!empty($options['theme']))
{
	$t = strtolower(trim($options['theme']));

	if (in_array($t, ['light', 'githublight', 'github-light'], true))
	{
		$theme = Theme::GithubLight;
	}
}

$use_dual_themes	= !empty($options['dual']) || !empty($options['light-dark']);
$show_line_numbers	= isset($options['numbers']) || isset($options['line-numbers']) || isset($options['gutter']);
$start_line			= max(1, (int)($options['start'] ?? $options['starting-line'] ?? 1));

try {
	$phiki = new Phiki();

	$result = $phiki->codeToHtml(
		code: $text,
		grammar: $grammar,
		theme: $use_dual_themes ? [
			'light' => Theme::GithubLight,
			'dark'  => Theme::GithubDark,
		] : $theme
		);

	if ($show_line_numbers)
	{
		$result = $result
			->withGutter()
			->startingLine($start_line);
	}

	$tpl->text = $result->toString();

} catch (\Throwable $e) {
	$tpl->text = '<pre class="code-error">' . Ut::html($text) . '</pre>';
	error_log('Phiki Formatter Error: ' . $e->getMessage());
}