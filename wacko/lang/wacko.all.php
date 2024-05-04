<?php

if (!defined('IN_WACKO'))
{
	exit;
}

$wacko_all_resource = [
	// link templates
	'Tpl.childpage'		=> '<a {aname} href="{pagelink}" {rel} class="{class}">{accicon}{icon}{page}</a>',
	'Tpl.parentpage'	=> '<a {aname} href="{pagelink}" {rel} class="{class}">{accicon}{icon}{page}</a>',
	'Tpl.equalpage'		=> '<a {aname} href="{pagelink}" {rel} class="{class}">{accicon}{icon}{page}</a>',
	'Tpl.rootpage'		=> '<a {aname} href="{pagelink}" {rel} class="{class}">{accicon}{icon}{page}</a>',
	'Tpl.descrpage'		=> '<a {aname} href="{pagelink}" {rel} class="{class}" title="{pagepath}{page}">{accicon}{text}</a>',
	'Tpl.descrpagealt'	=> '<a {aname} href="{pagelink}" {rel} class="{class}" title="{title}">{accicon}{text}</a>',

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
	'Tpl.grouplink'		=> '<a href="{href}" title="{title}" class="{class}">{icon}{text}</a>',
	'Tpl.userlink'		=> '<a href="{href}" title="{title}" class="{class}">{icon}{text}</a>',
	'Tpl.outerimg'		=> '<a href="{href}" {rel} {target} title="{title}" class="{class}">{text}</a>',
	'Tpl.outerlink'		=> '<a href="{href}" {rel} {target} title="{title}" class="{class}">{icon}{text}</a>',
	'Tpl.interwiki'		=> '<a href="{href}" {rel} {target} title="{title}" class="{class}">{icon}{text}</a>',
	'Tpl.email'			=> '<a href="{href}" {rel} {target} title="{title}" class="{class}">{icon}{text}</a>',
	'Tpl.jabber'		=> '<a href="{href}" {rel} {target} title="{title}" class="{class}">{icon}{text}</a>',
	'Tpl.file'			=> '<a href="{href}" {rel} {target} title="{title}" class="{class}">{icon}{text}</a>',

	'Tpl.localfile'		=> '<a href="{href}" title="{title}" class="{class}">{icon}{text}</a>',
	'Tpl.localimage'	=> '<a href="{href}" title="{title}" class="{class}">{text}</a>',
	'Tpl.wlocalfile'	=> '<span class="missingpage" title="{title}">{text}</span>',
	'Tpl.lan'			=> '<a href="{href}" {target} title="{title}" class="{class}">{icon}{text}</a>',

	//icons
	'ChildIcon'			=> '!/',
	'ParentIcon'		=> '../',
	'EqualIcon'			=> '',
	'RootIcon'			=> '/',
	#'IwIcon'			=> '',
	'RootLinkIcon'		=> '/',
	'SubLinkIcon'		=> '!/',
	'UpLinkIcon'		=> '../',
	'WantedIcon'		=> '?',

	// see wacko.css in theme folder, e.g. a.fileicon .icon {
	'OuterIcon'			=> '<span class="icon"></span>',

];