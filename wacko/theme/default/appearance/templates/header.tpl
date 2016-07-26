 Default theme.
 Common header file.

.include ../../../_common/_header.tpl

[ === main === ]

[''' h HtmlHead ''']

<body>
<div id="mainwrapper">
	<header>
		<div id="header-main">
			<div id="header-top">
				<h1>
				[= root _ =
					[ ' db: site_name ' ]
				=]
				[= other _ =
					<a href="[ ' db: base_url ' ]" title="[ ' db: site_desc ' ]">[ ' db: site_name ' ]</a>
				=]
				</h1>
			</div>
			<div id="login-box">
				[== // if user are logged, shows "You are UserName" ==]
				[= uare _ =
					<span class="nobr">[ ' _t: YouAre ' ] [ ' link | ' ]</span>
					<small> (
						<span class="nobr Tune">
							[ ' account | ' ]
							|
							<a onclick="return confirm('[ ' _t: LogoutAreYouSure ' ]');" href="[ ' logout | ']">[ ' _t: LogoutLink ' ]</a>
						</span>
					) </small>
				=]
				[= login _ =
					[== // else shows Register / Login link ==]
					<ul>
					<li>[ ' link | ' ]</li>
					[= reg _ =
						<li>[ ' link | ' ]</li>
					=]
					[''// Show Help link
						//  echo "<li>".$this->compose_link_to_page($this->_t('HelpPage'), "", $this->_t('Help'), 0)."</li>\n"; '']
					</ul>
				=]
		</div>
	</div>

	<nav class="menu-main">
	<div id="menu-user">
	<ol>
		[= menu menuList =
			['' commit | void  // alternation hack '']
			[= item _ =
				<li>[ ' link | ' ]</li>
			=]
			[= active _ =
				<li class="active"><span>[ ' item | ']</span></li>
			=]
		=]
		[= dropmenu _ =
			<li class="dropdown">
				<a href="#" id="more"><img src="[ ' db: theme_url ' ]icon/spacer.png" alt="-" title="[ ' _t: Bookmarks ' ]" class="btn-menu"/></a>
				<ul class="dropdown_menu">
					['' menu menuList '']
				</ul>
			</li>
		=]
		[= addmark _ =
			<li>
				<a href="[ ' href | ' ]">
					<img src="[ ' db: theme_url ' ]icon/spacer.png" alt="+" title="[ ' _t: AddToBookmarks ' ]" class="btn-addbookmark"/>
				</a>
			</li>
		=]
		[= removemark _ =
			<li>
				<a href="[ ' href | ' ]">
					<img src="[ ' db: theme_url ' ]icon/spacer.png" alt="-" title="[ ' _t: RemoveFromBookmarks ' ]" class="btn-removebookmark"/>
				</a>
			</li>
		=]
	</ol>
	</div>

	[ === // control tabs menu === ]
	<div id="handler">
	<ul class="submenu">

		[= tab TabList =
			<li class="[ ' class ' ][ ' active ' ]">
				[= in _ =
					<span>[ '' t TabTitle | trim '' ]</span>
				=]
				[= out _ =
					<a href="[ ' method | ' ]" title="[ ' hint | e attr ' ]"
						[ ' key | e attr | enclose ' accesskey="' '"' | ' ][ ' params | ' ]>[ '' t TabTitle | trim '' ]</a>
				=]
			</li>
		=]
		[= droptab _ =
			<li class="dropdown"><a href="#" id="more">[ ' _t: PageHandlerMoreTip ' ]<span class="dropdown_arrow">&#9660;</span></a>
				<ul class="dropdown_menu">
					['' tab TabList '']
					['' // last empty '']
					<li></li>
				</ul>
			</li>
		=]


		<li class="search">
		<div id="search_box">
			<form action="[ ' search | ' ]" method="get" name="search">
				['' search | hide_page | '']
				<span class="search nobr">
					<label for="phrase">[ ' _t: SearchText ' ]</label>
					<input type="search" name="phrase" id="phrase" size="20" />
					<input type="submit" class="submitinput" title="[ ' _t: SearchButtonText ' ]" value="[ ' _t: SearchButtonText ' ]"/>
				</span>
			</form>
		</div>
		</li>
	</ul>
	</div>
	</nav>

	<nav class="breadcrumb">
		['' breadcrumbs | '']
		['' // echo '<br />'.$this->get_user_trail($titles = true, $separator = ' &gt; ', $linking = true, $size = 8); '']
	</nav>
	</header>

	<main>

	[= msg _ =
		<div class="[ ' data.1 | e attr ' ]">[ ' data.0 | ' ]</div>
	=]

[ === TabTitle === ]
['' im TabImage ''] ['' title '']
[ === TabImage === ]
<img src="[ ' db: theme_url ' ]icon/spacer.png" alt="[ ' title | e attr ' ]" />
