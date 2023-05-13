[ === main === ]
	[ ' css ' ][ ' nofile ' ]

	<div id="captioned-gallery">
		<figure class="slider">
		[= n _ =
			<figure>
				[ ' image ' ]
				<figcaption>[ ' n ' ]/[ ' count ' ] [ ' desc ' ]</figcaption>
			</figure>
		=]
		</figure>
	</div>

	[= noaccess _ =
		[ ' _t: ActionDenied ' ]
	=]
