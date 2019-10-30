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
			[= prev _ =
				<a href="[ ' href ' ]">« [ ' _t: Back ' ]</a> |
			=]
			 <a href="[ ' href ' ]"> [ ' _t: Files ' ]</a> 
			[= next _ =
				| <a href="[ ' href ' ]">[ ' _t: Next ' ] »</a>
			=]
			<br><br>
			[ ' img ' ]
			<figcaption>
				<span>
					[ ' description ' ]
				</span>
			</figcaption>
			<br><br>
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