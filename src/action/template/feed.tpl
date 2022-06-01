[ === main === ]
	[= nourl _ =
		<p><em>[ ' _t: FeedNoURL ' ]</em></p>
	=]
	<a id="[ ' token ' ]"></a>
	[= xml =
		<span class="desc-rss-feed">
			<a href="[ ' href ' ]">
				<img src="[ ' db: theme_url ' ]icon/spacer.png" title="[ ' _t: FeedXMLTip ' ]" alt="XML" class="btn-feed">
			</a>
		</span>
		<br>
	=]
	[= mark _ =
		<div class="layout-box" style="display: table;">
			<p>
				<span>[ ' header ' ]: <strong>[ ' title ' ]</strong></span>
			</p>
	=]
	[= error _ =
		<p><em>[ ' _t: FeedError ' ]</em><br>[ ' message ' ]</p>
	=]
	[= nomark _ =
		<h1[ ' class ' ]>[ ' header ' ]</h1>
	=]
	[ '' pagination '' ]<br>
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
	[ '' pagination '' ]
	[= emark _ =
		[ ' nonstatic ' ]
		</div>
	=]

[ == pagination == ]
<nav class="pagination">[ ' text ' ]</nav>
