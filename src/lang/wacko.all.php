<?php

if (!defined('IN_WACKO'))
{
	exit;
}

$wacko_all_resource = [
	// link templates
	'Tpl.childpage'		=> '<a{aname} href="{pagelink}"{rel}{class}>{accicon}{icon}{page}</a>',
	'Tpl.parentpage'	=> '<a{aname} href="{pagelink}"{rel}{class}>{accicon}{icon}{page}</a>',
	'Tpl.equalpage'		=> '<a{aname} href="{pagelink}"{rel}{class}>{accicon}{icon}{page}</a>',
	'Tpl.rootpage'		=> '<a{aname} href="{pagelink}"{rel}{class}>{accicon}{icon}{page}</a>',
	'Tpl.descrpage'		=> '<a{aname} href="{pagelink}"{rel}{class} title="{pagepath}{page}">{accicon}{text}</a>',
	'Tpl.descrpagealt'	=> '<a{aname} href="{pagelink}"{rel}{class} title="{title}">{accicon}{text}</a>',

	'Tpl.wchildpage'	=> '<span class="missingpage">{icon}{page}</span><a href="{pagelink}" title="{title}">{accicon}</a>',
	'Tpl.wparentpage'	=> '<span class="missingpage">{icon}{page}</span><a href="{pagelink}" title="{title}">{accicon}</a>',
	'Tpl.wequalpage'	=> '<span class="missingpage">{icon}{page}</span><a href="{pagelink}" title="{title}">{accicon}</a>',
	'Tpl.wrootpage'		=> '<span class="missingpage">{icon}{page}</span><a href="{pagelink}" title="{title}">{accicon}</a>',
	'Tpl.wdescrpage'	=> '<span class="missingpage">{text}</span><a href="{pagelink}" title="{title}">{accicon}</a>',
	'Tpl.wdescrpagealt'	=> '<span class="missingpage">{text}</span><a href="{pagelink}" title="{title}">{accicon}</a>',
	'Tpl.pwchildpage'	=> '<span class="missingpage">{icon}{page}</span>',
	'Tpl.pwparentpage'	=> '<span class="missingpage">{icon}{page}</span>',
	'Tpl.pwequalpage'	=> '<span class="missingpage">{icon}{page}</span>',
	'Tpl.pwrootpage'	=> '<span class="missingpage">{icon}{page}</span>',
	'Tpl.pwdescrpage'	=> '<span class="missingpage">{text}</span>',

	'Tpl.anchor'		=> '<a href="{href}">{text}</a>',
	'Tpl.grouplink'		=> '<a href="{href}" title="{title}"{class}>{icon}{text}</a>',
	'Tpl.userlink'		=> '<a href="{href}" title="{title}"{class}>{icon}{text}</a>',
	'Tpl.outerimg'		=> '<a href="{href}"{rel}{target} title="{title}"{class}>{text}</a>',
	'Tpl.outerlink'		=> '<a href="{href}"{rel}{target} title="{title}"{class}>{icon}{text}</a>',
	'Tpl.interwiki'		=> '<a href="{href}"{rel}{target} title="{title}"{class}>{icon}{text}</a>',
	'Tpl.email'			=> '<a href="{href}"{rel}{target} title="{title}"{class}>{icon}{text}</a>',
	'Tpl.jabber'		=> '<a href="{href}"{rel}{target} title="{title}"{class}>{icon}{text}</a>',
	'Tpl.file'			=> '<a href="{href}"{rel}{target} title="{title}"{class}>{icon}{text}</a>',

	'Tpl.localfile'		=> '<a{aname} href="{href}" title="{title}"{class}>{icon}{text}</a>',
	'Tpl.localimage'	=> '<a href="{href}" title="{title}"{class}>{text}</a>',
	'Tpl.wlocalfile'	=> '<span class="missingpage" title="{title}">{text}</span>',
	'Tpl.lan'			=> '<a href="{href}"{target} title="{title}"{class}>{icon}{text}</a>',

	// icons
	'Icon.Child'		=> '!/',
	'Icon.Parent'		=> '../',
	'Icon.Equal'		=> '',
	'Icon.Root'			=> '/',
	'Icon.RootLink'		=> '/',
	'Icon.SubLink'		=> '!/',
	'Icon.UpLink'		=> '../',
	'Icon.Wanted'		=> '?',

	// see wacko.css in theme folder, e.g. a.fileicon .icon {
	'Icon.Outer'		=> '<span class="icon"></span>',

	'LicenseIds'	=> [
		1		=> ['CC-BY-ND',		2,	'https://creativecommons.org/licenses/by-nd/4.0/'],
		2		=> ['CC-BY-NC-SA',	2,	'https://creativecommons.org/licenses/by-nc-sa/4.0/'],
		3		=> ['CC-BY-NC-ND',	2,	'https://creativecommons.org/licenses/by-nc-nd/4.0/'],
		4		=> ['CC-BY-SA',		2,	'https://creativecommons.org/licenses/by-sa/4.0/'],
		5		=> ['CC-BY-NC',		2,	'https://creativecommons.org/licenses/by-nc/4.0/'],
		6		=> ['CC-BY',		2,	'https://creativecommons.org/licenses/by/4.0/'],
		7		=> ['CC-ZERO',		1,	'https://creativecommons.org/publicdomain/zero/1.0/'],
		8		=> ['GNU-FDL',		2,	'https://www.gnu.org/licenses/fdl.html'],
		9		=> ['PD',			1,	'https://creativecommons.org/publicdomain/mark/1.0/'],
		10		=> ['CR',			3,	''],
	],
];
