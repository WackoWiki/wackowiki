<?php
/**
 * Phiki Syntax Highlighter Formatter for WackoWiki
 */

use Phiki\Phiki;
use Phiki\Grammar\Grammar;
use Phiki\Theme\Theme;

$lang_input = strtolower(trim($options['_default'] ?? 'text'));

// 1. Static common aliases (fast lookup)
$grammar_map = [
	'text'			=> Grammar::Txt,
	'txt'			=> Grammar::Txt,
	'php'			=> Grammar::Php,
	'javascript'	=> Grammar::Javascript,
	'js'			=> Grammar::Javascript,
	'css'			=> Grammar::Css,
	'html'			=> Grammar::Html,
	'sql'			=> Grammar::Sql,
	'python'		=> Grammar::Python,
	'java'			=> Grammar::Java,
	'cpp'			=> Grammar::Cpp,
	'c'				=> Grammar::C,
	'json'			=> Grammar::Json,
	'xml'			=> Grammar::Xml,
	'bash'			=> Grammar::Shellscript,
	'sh'			=> Grammar::Shellscript,
	'shell'			=> Grammar::Shellscript,
	'markdown'		=> Grammar::Markdown,
	'md'			=> Grammar::Markdown,
	'http'			=> Grammar::Http,
	'diff'			=> Grammar::Diff,
	'ini'			=> Grammar::Ini,
	'yaml'			=> Grammar::Yaml,
	'yml'			=> Grammar::Yaml,
	'nginx'			=> Grammar::Nginx,
	'docker'		=> Grammar::Docker,
	'powershell'	=> Grammar::Powershell,
	'rust'			=> Grammar::Rust,
	'go'			=> Grammar::Go,
	'ruby'			=> Grammar::Ruby,
	'lua'			=> Grammar::Lua,
];

// Try mapped value first, then fall back to trying the name directly as string
$grammar			= $grammar_map[$lang_input] ?? null;
$line_numbers		= isset($options['numbers']);
$start_line			= max(1, (int)($options['start'] ?? 1));

try {
	$phiki = new Phiki();

	// 2. Hybrid Logic: Map + Automatic Alias Registration
	if (isset($grammar_map[$lang_input]))
	{
		$grammar = $grammar_map[$lang_input];
	}
	else
	{
		// Try to register the language name as alias (e.g. 'http', 'apache', 'typescript', etc.)
		$grammar = null;

		try {
			$phiki->alias($lang_input, $lang_input);
			$grammar = $lang_input;
		} catch (\Throwable $e) {
			$grammar = Grammar::Txt;
		}
	}

	$result = $phiki->codeToHtml(
		code: $text,
		grammar: $grammar,
		theme: [
			'light' => Theme::GithubLight,
			'dark'  => Theme::GithubDark,
		]
	);

	if ($line_numbers)
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