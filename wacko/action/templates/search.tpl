[ === main === ]
	[= form _ =
		<form action="[ ' href | ' ]" method="get" name="search">
			[ ' href | hide_page | ' ]
			<label for="searchfor">[ ' _t: SearchFor ' ]:</label><br />
			<input type="search" name="phrase" id="searchfor" size="40" value="[ ' phrase ' ]" />
			<input type="submit" value="[ ' _t: SearchButtonText ' ]" /><br />
			[= options _ =
				<input type="checkbox" name="topic"[ ' topic | format ' checked="checked"' ' ] id="checkboxSearch" />
				<label for="checkboxSearch">[ ' _t: TopicSearchText ' ]</label>
			=]
		</form>
		<br />
	=]
	[= none _ =
		[ ' _t: NoResultsFor ' ] "[ ' phrase ' ]"
	=]
	[= s _ =
		[''' pagination ''']
		[= mark _ =
			<div class="layout-box">
			<p class="layout-box">
				<span>[ ' diag ' ] "[ ' phrase ' ]" (<strong>[ ' count ' ]</strong>):</span>
			</p>
		=]
		[= ul _ =
			<ul id="search_results">
			[= l _ =
				[ ' delim | void ' ]
				<li>
					[= l SearchItem =
						<h3 style="display: inline;">[ ' link | ' ]</h3>[ ' count | enclose " (" ")" ' ]
						<br />
						<span style="color: #808080; line-height: 1.24; white-space: nowrap;">[ ' userlink | ' ] [ ' mtime | time_formatted ' ]</span>
						[ ' preview | nl2br | ' ]
					=]
				</li>
			=]
			</ul>
		=]
		[= ol _ =
			<ol id="search_results">
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
				[ ' delim | list '' '<br />' | ' ]
				['' l SearchItem '']
			=]
		=]
		[= emark _ =
			[ ' nonstatic ' ]
			</div>
		=]
		[''' pagination ''']
	=]
