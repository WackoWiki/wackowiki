 Default theme.
 Common header file.

.include ../../../_common/_header.tpl

[ === DefaultHead === ]
[''' h HtmlHead ''']
<body>
<div id="mainwrapper">
<header[ ' dir ' ]>
	<div id="header-main">
		<div id="header-site">
			<h1>
			[= site _ =
				[= link _ =
					<a href="[ ' db: base_path ' ]" title="[ ' db: site_desc | e ' ]">
				=]
				[= logo _ =
					<img src="[ ' path ' ]" alt="[ ' db: site_name | e ' ]" height="[ ' db: logo_height ' ]" width="[ ' db: logo_width ' ]">
				=]
				[= title _ =
					<span>[ ' db: site_name | e ' ]</span>
				=]
				[= clink _ =
					[ ' nonstatic ' ]
					</a>
				=]
			=]
			</h1>
		</div>
		<div id="login-box">
			[== // if user are logged, shows "UserName ( Account | Admin | Logout )" ==]
			[= uare _ =
				<span class="nobr">[ ' link ' ]</span>
				<small> (
					<span class="nobr Tune">
						[ ' account ' ]
						[= ap _ =
							| <a id="login-ap" href="[ ' link ' ]" title="[ ' _t: AdminTip ' ]" target="_blank" rel="noopener">[ ' _t: AdminText ' ]</a>
						=]
						|
						<a id="logout-confirm" data-logout-confirm="[ ' _t: LogoutAreYouSure ' ]" href="[ ' logout ']">[ ' _t: LogoutLink ' ]</a>
					</span>
				) </small>
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
	</div>
	<nav class="menu-main">
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
				[= dropmenu _ =
					<li class="dropdown">
						<a href="#" id="menu-more"><img src="[ ' db: theme_url ' ]icon/spacer.png" alt="-" title="[ ' _t: Bookmarks ' ]" class="btn-overflow-menu"></a>
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
		[ === // control tabs menu === ]
		<div id="page-handler">
			<ul class="submenu">

				[= tab TabList =
					<li class="[ ' class ' ][ ' active ' ]">
						[= in _ =
							<span>[ '' t TabTitle | trim '' ]</span>
						=]
						[= out _ =
							<a href="[ ' method ' ]" title="[ ' hint ' ]" [ ' key | e attr | enclose ' accesskey="' '"' ' ][ ' params ' ]>
								[ '' t TabTitle | trim '' ]</a>
						=]
					</li>
				=]
				[= droptab _ =
					<li class="dropdown"><a href="#" id="handler-more">[ ' _t: PageHandlerMoreTip ' ]<span class="dropdown-arrow">▼</span></a>
						<ul class="dropdown_menu">
							['' tab TabList '']
							['' // last empty '']
							<li></li>
						</ul>
					</li>
				=]
				<li class="search">
					<div id="search-box">
						<form action="[ ' search ' ]" method="get" name="search">
							[ ' // search | hide_page ' ]
							[ ' search | regex /^[^?]*\?page=([^&]+).*?$/ '<input type="hidden" name="page" value="\1">' 1 1 ' ]
							<span class="search nobr">
								<label for="phrase" class="visuallyhidden">[ ' _t: SearchText ' ]</label>
								<input type="search" name="phrase" id="phrase" size="20" title="[ ' _t: SearchButton ' ]">
								<button type="submit" title="[ ' _t: SearchButton ' ]" value="[ ' _t: SearchButton ' ]">
									<img src="[ ' db: theme_url ' ]icon/spacer.png" alt="[ ' _t: SearchButton ' ]" class="btn-search">
								</button>
							</span>
						</form>
					</div>
				</li>
			</ul>
		</div>
	</nav>
	[ === #------------------------------ === ]
	<nav class="breadcrumb">
		[ ' breadcrumbs ' ]
		[ ' // usertrail ' ]
	</nav>
	[ === #------------------------------ === ]
</header>

<main>
[= msg _ =
	<div id="output_messages">
		[= one _ =
			<div class="msg [ ' data.1 | e attr ' ]">[ ' data.0 ' ]</div>
		=]
	</div>
=]

[ === TabTitle === ]
[ ' im TabImage ' ] [ ' title | e ' ]
[ === TabImage === ]
<img src="[ ' db: theme_url ' ]icon/spacer.png" alt="[ ' title | e attr ' ]">

