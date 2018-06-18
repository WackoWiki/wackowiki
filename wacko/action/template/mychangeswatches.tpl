[ === main === ]
	[= guest _ =
		<em>[ ' _t: NotLoggedInWatches ' ]</em>
	=]
	
	[= user _ =
		
		[ ' _t: MyChangesWatches ' ] (<a href="[ ' href ' ]">[ ' _t: ResetChangesWatches ' ]</a>).
		<br><br>

		[= none _ =
			<em>[ ' _t: NoChangesWatches ' ]</em>
		=]
		
		[''' pagination ''']
		<ul class="ul_list">
			[= l _ =
				<li>
					<small>([ ' time ' ])</small> [ ' link ' ]
				</li>
			=]
		</ul>
		[''' pagination ''']
	=]


[= pagination =]
<nav class="pagination">[ ' text ' ]</nav>
