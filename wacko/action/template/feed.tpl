[ === main === ]
	[= nourl _ =
		<p><em>[ ' _t: FeedNoURL ' ]</em></p>
	=]

	[= mark _ =
		<div class="layout-box" style="display: table;">
			<p>
				<span>[ ' header ' ]: <strong>[ ' title ' ]</strong> [ ' lastitems ' ]</span>
			</p>
	=]

	[= error _ =
		<p><em>[ ' _t: FeedError ' ]</em></p>
	=]

	[= nomark _ =
		<h1[ ' class ' ]>[ ' header ' ]</h1>
		[ ' lastitems ' ]
	=]

	[= i _ =
		<article class="feed">
			<h2[ ' class ' ]>[ ' link ' ]</h2>
				<p class="feed-note">
					<span>
						[= m _ =
							[ ' _t: FeedSource ' ] <a href="[ ' href ' ]">[ ' title | e ' ]</a> |
						=]
						[= t _ =
							<time datetime="[ ' utime ' ]" title="[ ' date ' ]">[ ' interval ' ]</time>
						=]
					</span>
				</p>
			<div class="feed-content">[ ' content ' ]</div>
			[= e _ =
				[= f _ =
					[ ' link ' ] ([ ' type ' ] [ ' size ' ])
				=]
				[= img _ =
					<img src="[ ' link ' ]">
				=]
			=]
		</article>
	=]

	[= emark _ =
		[ ' nonstatic ' ]
		</div>
	=]
	