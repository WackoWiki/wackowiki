 Tabs theme.
 Common header file.

.include ../../../_common/_header.tpl

[ === DefaultHead === ]
[''' h HtmlHead ''']
<body>
<div id="mainwrapper">

<div class="Top[ ' LoggedOut ' ]">
	<div class="TopRight">

		<div id="menu-user">
			<ol>
				[= menu menuList =
					[ ' commit | void  // alternation hack ' ]
					[= item _ =
						<li>[ ' link ' ]</li>
					=]
					[= active _ =
						<li class="active"><span>[ ' item ']</span></li>
					=]
				=]
				
				<li>
					<form action="[ ' search ' ]" method="get" name="search">
						[ ' // search | hide_page ' ]
						[ ' search | regex /^[^?]*\?page=([^&]+).*?$/ '<input type="hidden" name="page" value="\1">' 1 1 ' ]
						<span class="search nobr">
							<label for="phrase">[ ' _t: SearchText ' ]</label>
							<input type="search" name="phrase" id="phrase" size="20" title="[ ' _t: SearchButton ' ]" class="ShSearch">
							<button type="submit" title="[ ' _t: SearchButton ' ]" value="[ ' _t: SearchButton ' ]">
								<img src="[ ' db: theme_url ' ]icon/spacer.png" alt="[ ' _t: SearchButton ' ]" class="btn-search">
							</button>
						</span>
					</form>
				</li>
			</ol>
		</div>
	</div>
	<div class="TopLeft">
		[== // if user are logged, shows "You are UserName" ==]
		[= uare _ =
			<img src="[ ' db: theme_url ' ]icon/role.png" width="9" height="15" alt=""><span class="nobr">[ ' _t: YouAre ' ] [ ' link ' ]</span> <small>( <span class="nobr Tune">
			[ ' account ' ]
			[= ap _ =
				| <a id="login-ap" href="[ ' link ' ]" title="[ ' _t: AdminTip ' ]" target="_blank" rel="noopener">[ ' _t: AdminText ' ]</a>
			=]
			| <a id="logout-confirm" data-logout-confirm="[ ' _t: LogoutAreYouSure ' ]" href="[ ' logout ']">[ ' _t: LogoutLink ' ]</a></span> )</small>
		=]
		[= login _ =
				[== // else shows Register / Login link ==]
				<ul>
					<li>[ ' link ' ]</li>
					[= reg _ =
						<li>[ ' link ' ]</li>
					=]
				</ul>
			=]
		
	</div>
	<br clear="all">
	<img src="[ ' db: theme_url ' ]image/spacer.png" width="1" height="1" alt=""></div>
	<div class="TopDiv"><img src="[ ' db: theme_url ' ]image/spacer.png" width="1" height="1" alt=""></div>
		<table style="width:100%;">
			<tr>
				<td style="vertical-align:top;" class="Bookmarks">&nbsp;&nbsp;<strong>[ ' _t: Bookmarks ' ]:</strong>&nbsp;&nbsp;</td>
				<td style="width:100%;" class="Bookmarks">
		
		<div id="menu-user">
			<ol>
				[= menu2 menuList2 =
					[ ' commit | void  // alternation hack ' ]
					[= item _ =
						<li>[ ' link ' ]</li>
					=]
					[= active _ =
						<li class="active"><span>[ ' item ']</span></li>
					=]
				=]
				[= dropmenu _ =
					<li class="dropdown">
						<a href="#" id="menu-more"><img src="[ ' db: theme_url ' ]icon/spacer.png" alt="-" title="[ ' _t: Bookmarks ' ]" class="btn-menu"></a>
						<ul class="dropdown_menu">
							['' menu menuList '']
						</ul>
					</li>
				=]
				[= addmark _ =
					<li>
						<a href="[ ' href ' ]">
							<img src="[ ' db: theme_url ' ]icon/spacer.png" alt="+" title="[ ' _t: AddBookmark ' ]" class="btn-addbookmark">
						</a>
					</li>
				=]
				[= removemark _ =
					<li>
						<a href="[ ' href ' ]">
							<img src="[ ' db: theme_url ' ]icon/spacer.png" alt="-" title="[ ' _t: RemoveBookmark ' ]" class="btn-removebookmark">
						</a>
					</li>
				=]
			</ol>
		</div>



&nbsp;&nbsp;
		</td>
	</tr>
</table>
<div class="TopDiv2"><img src="[ ' db: theme_url ' ]image/spacer.png" width="1" height="1" alt=""></div>
<div class="Wrapper"
[= edit _ = 
 style="margin-bottom: 0;padding-bottom: 0"
=]
 >
<div class="Print">
[= u _ =
	<a href="[ ' href: watch ' ]">[ ' watch ' ]</a>
	::
	[= addmark _ =
		<a href="[ ' href ' ]"><img src="[ ' db: theme_url ' ]icon/bookmark.png" width="12" height="12" alt="[ ' _t: AddBookmark ' ]"></a> ::
	=]
	[= removemark _ =
		<a href="[ ' href ' ]"><img src="[ ' db: theme_url ' ]icon/unbookmark.png" width="12" height="12" alt="[ ' _t: RemoveBookmark ' ]"></a> ::
	=]
=]
	<a href="[ ' href: print ' ]"><img src="[ ' db: theme_url ' ]icon/print.png" width="21" height="20" alt="[ ' _t: PrintVersion ' ]"></a> :: 
	<a href="[ ' href: wordprocessor ' ]"><img src="[ ' db: theme_url ' ]icon/wordprocessor.png" width="16" height="16" alt="[ ' _t: WordprocessorVersion ' ]"></a>
</div>
<div class="header">
	<h1><span class="Main">[ ' db: site_name ' ]:</span> [ ' pagepath ' ] </h1>
	[= noedit _ = 
		<div style="background-image:url([ ' db: theme_url ' ]icon/shade2.png);" class="Shade"><img src="[ ' db: theme_url ' ]icon/shade1.png" width="106" height="6" alt=""></div>
	=]
</div>



<header>

<nav class="menu-main">


</nav>
[ === #------------------------------ === ]
<nav class="breadcrumb">
	[ ' breadcrumbs ' ]
	[ ' // usertrail ' ]
</nav>
</header>
[ === #------------------------------ === ]
<main>
[= msg _ =
	<div id="output_messages">
		[= one _ =
			<div class="[ ' data.1 | e attr ' ]">[ ' data.0 ' ]</div>
		=]
	</div>
=]

[ === TabTitle === ]
[ ' im TabImage ' ] [ ' title ' ]
[ === TabImage === ]
<img src="[ ' db: theme_url ' ]icon/spacer.png" alt="[ ' title ' ]">

