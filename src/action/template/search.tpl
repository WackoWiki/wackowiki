[ === main === ]
	[ ' help ' ]
	[= form _ =
		<form action="[ ' href ' ]" method="get" name="search">
			[ ' href | hide_page ' ]
			<label for="searchfor">[ ' _t: SearchFor ' ]</label><br>
			<input type="search" id="searchfor" name="phrase" size="40" value="[ ' phrase | e attr ' ]" required>
			<button type="submit">[ ' _t: SearchButton ' ]</button><br>
			[= options _ =
				[= l _ =
					<label for="language">[ ' _t: AccountLanguage ' ]</label><br>
					<select id="language" name="lang">
						<option value=""[ ' selected ' ]>[ ' _t: Any ' ]</option>
						[= o _ =
							<option value="[ ' iso ' ]"[ ' selected ' ]>[ ' lang ' ] ([ ' iso ' ])</option>
						=]
					</select><br>
				=]
				<input type="checkbox" id="checkboxSearch" name="topic"[ ' topic | format ' checked' ' ]>
				<label for="checkboxSearch">[ ' _t: TopicSearchText ' ]</label><br>
			=]
		</form>
		<br>
	=]
	[= none _ =
		[ ' _t: NoResultsFor ' ] "<b>[ ' phrase | e ' ]</b>"
	=]
	[= s _ =
		[ '' pagination '' ]
		[= mark _ =
			<div class="layout-box">
			<p>
				<span>[ ' diag ' ] «<strong>[ ' phrase | e ' ]</strong>» ([ ' count | e ' ]):</span>
			</p>
		=]
		[= ul _ =
			<ul id="search-results">
			[= l _ =
				[ ' delim | void ' ]
				<li>
					[= l SearchItem =
						<h3>[ ' link ' ]</h3>
						<span class="search-meta">
							<time datetime="[ ' mtime ' ]">[ ' mtime | time_format ' ]</time> - [ ' userlink ' ] - [ ' psize ' ] [ ' lang ' ]
						[= comments =
							- <img src="[ ' db: theme_url ' ]icon/spacer.png" class="btn-comment btn-sm">[ ' n ' ]
						=]
						</span><br>
						[ ' preview | nl2br ' ]

						[ ' category ' ]
					=]
				</li>
			=]
			</ul>
		=]
		[= ol _ =
			<ol id="search-results" start="[ ' offset ' ]">
			[= l _ =
				[ ' delim | void ' ]
				<li>
					[ '' l SearchItem '' ]
				</li>
			=]
			</ol>
		=]
		[= comma _ =
			[= l _ =
				[ ' delim | list '' , ' ]
				[ '' l SearchItem '' ]
			=]
		=]
		[= br _ =
			[= l _ =
				[ ' delim | list '' '<br>' ' ]
				[ '' l SearchItem '' ]
			=]
		=]
		[= emark _ =
			[ ' nonstatic ' ]
			</div>
		=]
		[ '' pagination '' ]
	=]

[= pagination =]
<nav class="pagination">[ ' text ' ]</nav>

