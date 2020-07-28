[ === main === ]
	[= form _ =
		<form action="[ ' href ' ]" method="get" name="search">
			[ ' href | hide_page ' ]
			<label for="searchfor">[ ' _t: SearchFor ' ]:</label><br>
			<input type="search" name="phrase" id="searchfor" size="40" value="[ ' phrase | e attr ' ]">
			<input type="submit" value="[ ' _t: SearchButton ' ]"><br>
			[= options _ =
				<input type="checkbox" name="topic"[ ' topic | format ' checked' ' ] id="checkboxSearch">
				<label for="checkboxSearch">[ ' _t: TopicSearchText ' ]</label>
			=]
		</form>
		<br>
	=]
	[= none _ =
		[ ' _t: NoResultsFor ' ] "<b>[ ' phrase | e ' ]</b>"
	=]
	[= s _ =
		[''' pagination ''']
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
						<span class="search-meta">[ ' mtime | time_formatted ' ] - [ ' userlink ' ] - [ ' psize ' ] [ ' lang ' ]
						[= comments =
							- <img src="[ ' db: theme_url ' ]icon/spacer.png" class="btn-comment">[ ' n ' ]
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
					['' l SearchItem '']
				</li>
			=]
			</ol>
		=]
		[= comma _ =
			[= l _ =
				[ ' delim | list '' , ' ]
				['' l SearchItem '']
			=]
		=]
		[= br _ =
			[= l _ =
				[ ' delim | list '' '<br>' ' ]
				['' l SearchItem '']
			=]
		=]
		[= emark _ =
			[ ' nonstatic ' ]
			</div>
		=]
		[''' pagination ''']
	=]

[= pagination =]
<nav class="pagination">[ ' text ' ]</nav>

