<?php

$wacko_all_resource = array(
	//link templates
	'tpl.childpage'		=> '<a {aname} href="{pagelink}" class="{class}">{accicon}{icon}{page}</a>',
	'tpl.parentpage'	=> '<a {aname} href="{pagelink}" class="{class}">{accicon}{icon}{page}</a>',
	'tpl.equalpage'		=> '<a {aname} href="{pagelink}" class="{class}">{accicon}{icon}{page}</a>',
	'tpl.rootpage'		=> '<a {aname} href="{pagelink}" class="{class}">{accicon}{icon}{page}</a>',
	'tpl.descrpage'		=> '<a {aname} href="{pagelink}" class="{class}" title="{pagepath}{page}">{accicon}{text}</a>',
	'tpl.wchildpage'	=> '<span class="missingpage">{icon}{page}</span><a href="{pagelink}" title="{title}">{accicon}</a>',
	'tpl.wparentpage'	=> '<span class="missingpage">{icon}{page}</span><a href="{pagelink}" title="{title}">{accicon}</a>',
	'tpl.wequalpage'	=> '<span class="missingpage">{icon}{page}</span><a href="{pagelink}" title="{title}">{accicon}</a>',
	'tpl.wrootpage'		=> '<span class="missingpage">{icon}{page}</span><a href="{pagelink}" title="{title}">{accicon}</a>',
	'tpl.wdescrpage'	=> '<span class="missingpage">{text}</span><a href="{pagelink}" title="{title}">{accicon}</a>',
	'tpl.anchor'		=> '<a href="{url}">{text}</a>',
	'tpl.pwchildpage'	=> '<span class="missingpage">{icon}{page}</span>',
	'tpl.pwparentpage'	=> '<span class="missingpage">{icon}{page}</span>',
	'tpl.pwequalpage'	=> '<span class="missingpage">{icon}{page}</span>',
	'tpl.pwrootpage'	=> '<span class="missingpage">{icon}{page}</span>',
	'tpl.pwdescrpage'	=> '<span class="missingpage">{text}</span>',
	'tpl.anchor'		=> '<a href="{url}">{text}</a>',
	'tpl.outerlink'		=> '<a href="{url}" title="{title}" class="{class}">{icon}{text}</a>',
	'tpl.interwiki'		=> '<a href="{url}" title="{title}" class="{class}">{icon}{text}</a>',
	'tpl.email'			=> '<a href="{url}" title="{title}" class="{class}">{icon}{text}</a>',
	'tpl.jabber'		=> '<a href="{url}" title="{title}" class="{class}">{icon}{text}</a>',
	'tpl.file'			=> '<a href="{url}" title="{title}" class="{class}">{icon}{text}</a>',
	'tpl.localfile'		=> '<a href="{url}" title="{title}" class="{class}">{icon}{text}</a>',
	'tpl.wlocalfile'	=> '<span class="missingpage" title="{title}">{text}</span>',
	'tpl.lan'			=> '<a href="{url}" title="{title}" class="{class}">{icon}{text}</a>',

	//icons
	'childicon'		=> '!/',
	'parenticon'	=> '../',
	'equalicon'		=> '',
	'rooticon'		=> '/',
	'iwicon'		=> '',
	'lanicon'		=> '',
	'RootLinkIcon'	=> '/',
	'SubLinkIcon'	=> '!/',
	'UpLinkIcon'	=> '../',

	// mime (temp)
	'texticon'  => '<img src="{theme}icons/txt.png" alt="Text" />',
	'imageicon'  => '<img src="{theme}icons/image.png" alt="Image" />',
);

?>