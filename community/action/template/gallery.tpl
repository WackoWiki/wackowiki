[ === main === ]
	[ '' pagination '' ]

	[= mark _ =
		<div class="layout-box">
			<p>
				<span>[ ' title | e ' ]:</span>
			</p>
	=]

	[= div _ =
		<div class="gallery" id="gallery--[ ' token ' ]">
		[ ' nonstatic ' ]
	=]
	[= table _ =
		<table class="gallery" id="gallery--[ ' token ' ]">
		[ ' nonstatic ' ]
	=]
	[= items _ =
		[ ' row ' ]
		[= table _ =
			<td>
			[ ' nonstatic ' ]
		=]
		<figure>
			<a href="[ ' href ' ]"[ ' datawidth ' ][ ' dataheight ' ][ ' target ' ]>
				[ ' img ' ]
				[= data _ =
				<span class="pswp-caption-content">[ ' caption ' ]</span>
				=]
			</a>
			[= caption _ =
				<figcaption>
					<span>[ ' caption ' ]</span>
				</figcaption>
			=]
		</figure>
			[ ' next ' ]
	=]
	[= etable _ =
			[ ' nonstatic ' ]
				</td>
			</tr>
		</table>
	=]
	[= ediv _ =
		[ ' nonstatic ' ]
		</div>
	=]
	[= item _ =
		<a id="[ ' token ' ]" href="[ ' href ' ]">← [ ' _t: ToOverview ' ]</a>
		[ '' navigation '' ]
		<br><br>
		<figure class="t-center">
			[ ' img ' ]
			<figcaption>
				<span>
					[ ' caption ' ]
				</span>
			</figcaption>
			<br>
		</figure>
		[ '' navigation '' ]
	=]
	[= emark _ =
		[ ' nonstatic ' ]
		</div>
	=]

	[ '' pagination '' ]

	[= noaccess _ =
		[ ' _t: ActionDenied ' ]
	=]

[============================== // assorted utilities ==============================]

[= pagination =]
<nav class="pagination">[ ' text ' ]</nav>

[= navigation =]
<nav class="pagination">
	[= prev _ =
		<a href="[ ' href ' ]">« [ ' _t: Back ' ]</a>
	=]
	[= separator _ =
		[ ' nonstatic ' ]
		 | 
	=]
	[= next _ =
		<a href="[ ' href ' ]">[ ' _t: Next ' ] »</a>
	=]
</nav>