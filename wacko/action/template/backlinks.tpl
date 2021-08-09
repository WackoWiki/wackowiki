[ === main === ]
	[''' pagination ''']
	[= mark _ =
		<div class="layout-box">
			<p>
				<span>[ ' _t: ReferringPages ' ]:</span>
			</p>
	=]
	[= nobacklinks _ =
		[ ' _t: NoReferringPages ' ]
	=]
		<ol start="[ ' offset ' ]">
			[= l _ =
				<li>[ ' link ' ]</li>
			=]
		</ol>
	[= emark _ =
		[ ' nonstatic ' ]
		</div>
	=]
	[''' pagination ''']

[============================== // assorted utilities ==============================]

[= pagination =]
<nav class="pagination">[ ' text ' ]</nav>
