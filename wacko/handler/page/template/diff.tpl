[ === main === ]
	[ ' denied ' ]
	[ ' nodiff ' ]

	[= diff _ =

		<!--nomail-->
		<div class="diffinfo">
			[ ' diffinfo ' ]
		</div>
		<br><br>
		<ul class="menu">
			[= l _ =
				[ ' diffmode ' ]
			=]
		</ul>
		<!--/nomail-->

		[= m0 _ =
			<br><br>
			[ ' diff ' ]
		=]
		[= m2 _ =
			[ ' nodiff ' ]
			[= added _ =
				<br><strong>[ ' _t: SimpleDiffAdditions ' ]</strong><br>
				<div class="additions">
					[ ' diff | pre ' ]
				
				</div>
			=]
			[= deleted _ =
				<br><strong>[ ' _t: SimpleDiffDeletions ' ]</strong><br>
				<div class="deletions">
					[ ' diff | pre ' ]
				
				</div>
			=]
		=]
		[= m6 _ =
			<br><br>
			[ ' nodiff ' ]
			[ ' diff ' ]
		=]
	=]


[= nodiff =]
<br>[ ' _t: NoDifferences ' ]
