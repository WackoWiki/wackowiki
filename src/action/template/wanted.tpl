[ === main === ]
	[ ' help ' ]
	[= none _ =
		[ ' _t: NoWantedPages ' ]
	=]
	[= to =
		[ ' _t: PagesLinkingTo ' ] [ ' target ' ]:<br>
		<ol>
			[= l _ =
				<li>[ ' link ' ]</li>
			=]
		</ol>
		[= none =
			<em>[ ' _t: NoPageLinkingTo ' ] [ ' target ' ]</em>
		=]
	=]
	[= w =
		[ '' pagination '' ]

		<ol start="[ ' offset ' ]" class="hl-line">
			[= l _ =
				<li>[ ' link ' ]  (<a href="[ ' href ' ]">[ ' count ' ]</a>)</li>
			=]
		</ol>

		[ '' pagination '' ]
	=]

[= pagination =]
<nav class="pagination">[ ' text ' ]</nav>