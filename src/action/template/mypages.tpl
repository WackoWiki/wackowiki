[ === main === ]
	[ ' help ' ]
	[= guest _ =
		<em>[ ' _t: NotLoggedInThusOwned ' ]</em>
	=]
	[= u _ =
		[ ' tabs ' ]

		[= nopages _ =
			[ ' _t: NoPagesFound ' ]
		=]

		[ '' // pagination '' ]

		<ul class="ul-list">
			[= page _ =
				<li><strong>[ ' day ' ][ ' char ' ]</strong>
					<ul class="hl-line">
						[= l _ =
							<li>
								[= t _ =
									[ ' time ' ] — 
								=]
								[ ' link ' ]
							</li>
						=]
					</ul>
				<br></li>
			=]
		</ul>

		[ '' pagination '' ]
	=]

[= pagination =]
<nav class="pagination">[ ' text ' ]</nav>