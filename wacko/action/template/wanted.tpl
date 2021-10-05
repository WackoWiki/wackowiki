[ === main === ]
	[= none _ =
		[ ' _t: NoWantedPages ' ]
	=]
	[= to =
		[ ' _t: PagesLinkingTo ' ] [ ' target ' ]:<br>
		<ul>
			[= l _ =
				<li>[ ' link ' ]</li>
			=]
		</ul>
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
