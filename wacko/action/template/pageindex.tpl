
[ === main ===]
	[''' pagination ''']
	[= letter _ =
		<ul class="ul-letters">
		[= l _ =
			[ ' commit | void  // alternation hack ' ]
				[= active _ =
					<li class="active"><strong>[ ' ch | e ' ]</strong></li>
				=]
				[= item _ =
					<li><a href="[ ' link ' ]">[ ' ch | e ' ]</a></li>
				=]
		=]
		</ul>
		<br><br>
	=]
	[= nopages _ =
		[ ' _t: NoPagesFound ' ]
	=]
	<ul class="ul-list">
	[= page _ =
		<li><strong>[ ' ch | e ' ]</strong>
			<ul>
				[= l _ =
					<li>[ ' link ' ]</li>
				=]
			</ul>
		</li>
	=]
	</ul>
	[''' pagination ''']

[============================== // assorted utilities ==============================]

[= pagination =]
<nav class="pagination">[ ' text ' ]</nav>
