[ === main === ]
	[= top _ =
		[= mark _ =
			<div class="layout-box">
				<p>
					<span>[ ' _t: RatingTopPages ' ]:</span>
				</p>
		=]
		[= none _ =
			<em>[ ' _t: RatingNoPagesRated ' ]</em>
		=]
		[ '' n list '' ]
		[= emark _ =
			[ ' nonstatic ' ]
			</div>
		=]
		[ '' //pagination '' ]
	=]
	[= bottom _ =
		[= mark _ =
			<div class="layout-box">
				<p>
					<span>[ ' _t: RatingBottomPages ' ]:</span>
				</p>
		=]
		[= none _ =
			<em>[ ' _t: RatingNoPagesRated ' ]</em>
		=]
		[ '' n list '' ]
		[= emark _ =
			[ ' nonstatic ' ]
			</div>
		=]
		[ '' //pagination '' ]
	=]

[= list =]
<table class="hl-line most-col-num most-col-value">
	[= l _ =
		<tr>
			<td>[ ' link ' ]</td>
			<td>[ ' rating | number 0 , . ' ]</td>
		</tr>
	=]
</table>

[= pagination =]
<nav class="pagination">[ ' text ' ]</nav>
