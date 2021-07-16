[ === main === ]
	[= r _ =
		[= mark _ =
			<div class="layout-box">
				<p>
					<span>[ ' _t: PagesCategory ' ]: <strong class="tag">[ ' words ' ]</strong> [ ' cluster ' ] [ ' link ' ]</span>
				</p>
		=]
		[= d _ =
			<div class="note">[ ' description ' ]</div><br>
		=]
		<ol>
			[= l _ =
				<li>
					[= d _ =
						<small>[ ' created ' ]</small>
					=]
					[ ' link ' ]
				</li>
			=]
		</ol>
		[ ' message ' ]
		[= emark _ =
			[ ' nonstatic ' ]
			</div>
		=]
	=]

	[= c _ =
		[= ml _ =
			<form action="[ ' href: ' ]" method="post" name="category_lang">
				[ ' csrf: category_lang ' ]
				<p class="t-right">
					[ ' lang ' ]
					<button type="submit" name="update" id="submit">[ ' _t: UpdateButton ' ]</button>
				</p>
			</form>
		=]
		[= mark _ =
			<div class="layout-box">
				<p>
					<span>[ ' _t: Categories ' ] [ ' cluster ' ] [ ' link ' ]:</span>
				</p>
		=]
		<table class="category-browser">
			<tr>
				<td>
					<ul class="ul-list hl-line">
						[= l _ =
							<li>
								[ ' link ' ]
								[= c _ =
									<ul>
										[= l _ =
											<li>[ ' link ' ]</li>
										=]
									</ul>
								=]
							</li>
							[= next _ =
								[ ' nonstatic ' ]
								[ ' // next column hack ' ]
								</ul>
							</td>
							<td>
								<ul class="ul-list hl-line">
							=]
						=]
					</ul>
				</td>
			</tr>
		</table>
		[ ' message ' ]
		[= emark _ =
			[ ' nonstatic ' ]
			</div>
		=]
	=]
