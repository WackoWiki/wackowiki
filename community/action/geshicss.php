<?php

if (!defined('IN_WACKO'))
{
	exit;
}

if ($this->is_admin())
{
	$info = <<<EOD
Description:
	Generates custom CSS files for GeSHi.

	Requires GeSHi class.

Usage:
	{{geshicss}}

Options:
	[custom=0|1]
	[wiki_text=0|1]		prints seleted languages as table in wiki syntax
EOD;

	// set defaults
	$custom		??= false;
	$help		??= 0;
	$wiki_text	??= true;

	if ($help)
	{
		$tpl->help	= $this->help($info, 'geshicss');
		return;
	}

	$checked	= (bool) ($_GET['all']	?? false);
	$none		= (bool) ($_GET['none']	?? false);

	require_once 'lib/geshi/geshi.php';

	$geshi		= new GeSHi();
	$languages	= $geshi->get_supported_languages();
	sort($languages);

	// [a] create stylesheet
	if (isset($_POST['langs']) && is_array($_POST['langs']))
	{
		foreach ($_POST['langs'] as $lang => $dummy)
		{
			if (in_array($lang, $languages))
			{
				$_languages[] = $lang;
			}
		}

		$tpl->enter('post_');

		foreach ($_languages as $i => $language)
		{
			$geshi->set_language($language);
			$css	= $geshi->get_stylesheet(false);
			// remove comments
			$styles	.= preg_replace('/^\/\*\*.*?\*\//s', '', $css);

			if ($wiki_text)
			{
				$tpl->enter('syntax_');

				$geshi->set_language($language);
				$tpl->n_n_num	= $i + 1;
				$tpl->n_n_name	= $geshi->get_language_name();
				$tpl->n_n_lang	= $language;

				$tpl->leave();	// syntax_
				$tpl->commit	= true;
			}
		}

		$tpl->stylesheet	= $styles;
		$tpl->size			= $this->factor_multiples(strlen($styles), 'binary', true, true);
		$tpl->reset			= true;
		$tpl->leave();	// post_
	}
	// [b] select languages
	else
	{
		$tpl->enter('form_');
		$tpl->n_select	= $this->href('', '', ['all' => 1]);
		$tpl->n_none	= $this->href('', '', ['none' => 1]);

		// set a preselection
		$pre_selected = [
			'css',
			'diff',
			'email',
			'html5',
			'ini',
			'javascript',
			'latex',
			'php',
			'python',
			'sql',
			'xml'
		];

		foreach ($languages as $language)
		{
			$tpl->lang_lang		= $language;

			if ($checked || (!$none && in_array($language, $pre_selected)))
			{
				$tpl->lang_checked	= ' checked';
			}
		}

		if ($custom)
		{
			$new_lang = [
				'overall'			=> ['Style for the overall code block:',
										'border: 1px dotted #a0a0a0; font-family: "Courier New", Courier, monospace; background-color: #f0f0f0; color: #0000bb;'],
				'default-styles'	=> ['Default Styles',
										'font-weight:normal;background:transparent;color:#000; padding-left: 5px;'],
				'keywords-1'		=> ['Keywords I (if, do, while etc)',
										'color: #a1a100;'],
				'keywords-2'		=> ['Keywords II (null, true, false etc)',
										'color: #000; font-weight: bold;'],
				'keywords-3'		=> ['Inbuilt Functions (echo, print etc)',
										'color: #000066;'],
				'keywords-4'		=> ['Data Types (int, boolean etc)',
										'color: #f63333;'],
				'comments'			=> ['Comments (//, <!--  --> etc)',
										'color: #808080;'],
				'escaped-chars'		=> ['Escaped Characters (\n, \t etc)',
										'color: #000033; font-weight: bold;'],
				'brackets'			=> ['Brackets ( ([{}]) etc)',
										'color: #66cc66;'],
				'strings'			=> ['Strings ("foo" etc)',
										'color: #ff0000;'],
				'numbers'			=> ['Numbers (1, -54, 2.5 etc)',
										'color: #ff33ff;'],
				'methods'			=> ['Methods (Foo.bar() etc)',
										'color: #006600;'],
			];

			$tpl->enter('custom_');

			foreach ($new_lang as $type => $style)
			{
				$tpl->style_type	= $type;
				$tpl->style_text	= $style[0];
				$tpl->style_style	= $style[1];
			}

			$tpl->leave();	// custom_
		}

		$tpl->leave();	// form_
	}
}
