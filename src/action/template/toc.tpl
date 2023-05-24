[ === main === ]
	[ ' help ' ]
	[= mark _ =
		<nav class="layout-box">
			<p>
				<span>[ ' _t: TocTitle ' ] [ ' cluster ' ]</span>
			</p>
	=]
	[ ' message ' ]

	[ ' // h1 -> h6 ' ]
	<ul id="toc">
	[= li _ =
		<li>[ ' commit | void ' ][ ' toc ' ]
		[= ul _ =
			<ul>[ ' commit | void ' ]
			[= li _ =
				<li>[ ' commit | void ' ][ ' toc ' ]
				[= ul _ =
					<ul>[ ' commit | void ' ]
					[= li _ =
						<li>[ ' commit | void ' ][ ' toc ' ]
						[= ul _ =
							<ul>[ ' commit | void ' ]
							[= li _ =
								<li>[ ' commit | void ' ][ ' toc ' ]
								[= ul _ =
									<ul>[ ' commit | void ' ]
									[= li _ =
										<li>[ ' commit | void ' ][ ' toc ' ]
										[= ul _ =
											<ul>
											[= li _ =
												<li>[ ' toc ' ]</li>
											=]
											</ul>
										=]
										</li>
									=]
									</ul>
								=]
								</li>
							=]
							</ul>
						=]
						</li>
					=]
					</ul>
				=]
				</li>
			=]
			</ul>
		=]
		</li>
	=]
	</ul>

	[= emark _ =
		[ ' nonstatic ' ]
		</nav>
	=]

[ == toc == ]
<a href="[ ' href ' ]">[ ' n numerate ' ][ ' i text ' ]</a>

[ == numerate == ]
<span class="tocnumber">[ ' number ' ]</span>

[ == text == ]
<span class="toctext">[ ' item ' ]</span>