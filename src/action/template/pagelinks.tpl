[ === main === ]
	[ '' pagination '' ]
	[= mark _ =
		<div class="layout-box">
			<p>
				<span>[ ' _t: LinkedPages ' ]:</span>
			</p>
	=]
	[= nolinks _ =
		[ ' _t: NoLinkedPages ' ]
	=]
		<ol start="[ ' offset ' ]" class="hl-line">
			[= l _ =
				<li>[ ' link ' ]</li>
			=]
		</ol>
	[= emark _ =
		[ ' nonstatic ' ]
		</div>
	=]
	[ '' pagination '' ]

[============================== // assorted utilities ==============================]

[= pagination =]
<nav class="pagination">[ ' text ' ]</nav>
