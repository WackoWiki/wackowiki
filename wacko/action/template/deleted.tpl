[ === main === ]
	[= nopages _ =
		[ ' _t: NoDeletedPages ' ]
	=]
	[''' pagination ''']

	<ul class="ul_list">
	[= page _ =
			<li><strong>[ ' day ' ]</strong>
				<ul class="lined">
					[= l _ =
						<li class="lined[ ' viewed ' ]">
							<span class="dt">[ ' time ' ]</span> &mdash; [ ' icon ' ][ ' page ' ]
							 . . . . . . . . . . . . . . . . 
							<small>
								[ ' _t: LatestCommentBy ' ]
								[ ' user ' ]
								[= n _ =
									<span class="editnote">[[ ' text ' ]]</span>
								=]
							</small>
						</li>
					=]
				</ul>
			<br></li>
		=]
	</ul>

	[''' pagination ''']

[= pagination =]
<nav class="pagination">[ ' text ' ]</nav>

[= icon =]
<img src="[ ' db: theme_url ' ]icon/spacer.png" title="[ ' _t: PageDeleted ' ]" alt="[deleted]" class="btn-delete">