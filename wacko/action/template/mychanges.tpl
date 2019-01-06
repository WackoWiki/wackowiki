[ === main === ]
	[= guest _ =
		<em>[ ' _t: NotLoggedInThusEdited ' ]</em>
	=]
	[= u _ =
		[ ' tabs ' ]

		[= nopages _ =
			[ ' _t: DidntEditAnyPage ' ]
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
								[= e _ =
									<span class="editnote"> [[ ' note ' ]]</span>
								=]
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