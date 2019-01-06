[ === main === ]
	[= guest _ =
		<em>[ ' _t: NotLoggedInThusOwned ' ]</em>
	=]
	[= u _ =
		[ ' tabs ' ]

		[= nopages _ =
			[ ' _t: NoPagesFound ' ]
		=]

		[''' // pagination ''']

		<ul class="ul-list">
			[= page _ =
				<li><strong>[ ' day ' ][ ' char ' ]</strong>
					<ul>
						[= l _ =
							<li>
								[= t _ =
									[ ' time ' ] &mdash; 
								=]
								[ ' link ' ]
							</li>
						=]
					</ul>
				<br></li>
			=]
		</ul>

		[''' pagination ''']
	=]

[= pagination =]
<nav class="pagination">[ ' text ' ]</nav>