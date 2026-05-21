<?php
/**
 * Phiki Syntax Highlighter Formatter for WackoWiki
 */

use Phiki\Phiki;
use Phiki\Grammar\Grammar;
use Phiki\Theme\Theme;

$lang_input = strtolower(trim($options['_default'] ?? 'text'));

// 1. Static common aliases (fast lookup)
$grammar = match($lang_input) {
	'apache', 'htaccess'    => Grammar::Apache,
	'c++', 'cpp'            => Grammar::Cpp,
	'csharp', 'cs', 'c#'    => Grammar::Csharp,
	'cmake'                 => Grammar::CMake,
	'css'                   => Grammar::Css,
	'dart'                  => Grammar::Dart,
	'diff'                  => Grammar::Diff,
	'docker', 'dockerfile'  => Grammar::Docker,
	'go', 'golang'          => Grammar::Go,
	'html'                  => Grammar::Html,
	'http'                  => Grammar::Http,
	'ini'                   => Grammar::Ini,
	'java'                  => Grammar::Java,
	'javascript', 'js'      => Grammar::Javascript,
	'json'                  => Grammar::Json,
	'kotlin', 'kt'          => Grammar::Kotlin,
	'latex', 'tex'          => Grammar::Latex,
	'lua'                   => Grammar::Lua,
	'makefile'              => Grammar::Makefile,
	'markdown', 'md'        => Grammar::Markdown,
	'nginx'                 => Grammar::Nginx,
	'perl'                  => Grammar::Perl,
	'php'                   => Grammar::Php,
	'powershell', 'ps'      => Grammar::Powershell,
	'python'                => Grammar::Python,
	'r'                     => Grammar::R,
	'regex', 'regexp'       => Grammar::Regex,
	'ruby', 'rb'            => Grammar::Ruby,
	'rust', 'rs'            => Grammar::Rust,
	'scala'                 => Grammar::Scala,
	'bash', 'sh', 'shell'   => Grammar::Shellscript,
	'sql'                   => Grammar::Sql,
	'swift'                 => Grammar::Swift,
	'text', 'txt'           => Grammar::Txt,
	'toml'                  => Grammar::Toml,
	'typescript', 'ts'      => Grammar::Typescript,
	'xml'                   => Grammar::Xml,
	'yaml', 'yml'           => Grammar::Yaml,
	default                 => null,
};

$line_numbers	= isset($options['numbers']);
$start_line		= max(1, (int)($options['start'] ?? 1));

try {
	$phiki = new Phiki();

	// 2. Try dynamic alias registration if not in static map
	if ($grammar === null) {
		try {
			// Test if grammar exists by attempting a small highlight (cheap test)
			$phiki->codeToHtml('// test', $lang_input, Theme::GithubDark);
			#$phiki->alias($lang_input, $lang_input);
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

	$highlighted	= $result->toString();
	$token			= 'cb-' . Ut::random_token(7);

	$tpl->token		= $token;

	$highlighted = preg_replace(
		'/<pre([^>]*)>/i',
		'<pre id="' . $token . '"$1>',
		$highlighted,
		1
	);

	$tpl->language	= !empty($lang_input) && $lang_input !== 'text' ? strtoupper($lang_input) : '';
	$tpl->text		= $highlighted;

} catch (\Throwable $e) {
	$tpl->text = '<pre class="code-error">' . Ut::html($text) . '</pre>';
	error_log('Phiki Formatter Error: ' . $e->getMessage());
}
