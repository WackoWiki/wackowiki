[ === main === ]
	[''' pagination ''']

	[= mark _ =
		<div class="layout-box">
			<p>
				<span>[ ' title | e ' ]:</span>
			</p>
	=]

	[= div _ =
		<div class="gallery t-center">
			[ ' nonstatic ' ]
	=]
	[= table _ =
		<table class="t-center" style="width:100%;">
		[ ' nonstatic ' ]
	=]
	[= items _ =
		[ ' row ' ]
		[= table _ =
			<td class="t-center">
			[ ' nonstatic ' ]
		=]
		<figure class="zoom">
			<a href="[ ' href ' ]"[ ' datafancybox ' ][ ' datacaption ' ] alt="[ ' alt ' ]" title="[ ' description ' ]">[ ' img ' ]</a>
			[= caption _ =
				<figcaption>
					<span>[ ' description ' ]</span>
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
		<figure id="[ ' token ' ]" class="t-center">
			[ ' img ' ]
			<figcaption>
				<span>
					[ ' description ' ]
				</span>
			</figcaption>
			<br><br>
			<a href="[ ' href ' ]">&lt;[ ' _t: Back ' ]</a>
		</figure>
	=]
	[= emark _ =
		[ ' nonstatic ' ]
		</div>
	=]

	[''' pagination ''']

	[= noaccess _ =
		[ ' _t: ActionDenied ' ]
	=]

[============================== // assorted utilities ==============================]

[= pagination =]
<nav class="pagination">[ ' text ' ]</nav>