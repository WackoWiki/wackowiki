[ === main === ]
	[ ' help ' ]
	[ ' tabs ' ]
	[ ' title | e ' ]<br><br>
	[= denied =
		<em>[ ' _t: NotLoggedInWatches ' ]</em>
	=]
	[= none =
		<em>[ ' text ' ]</em>
	=]
	[= w =
		<table class="category-browser">
			<tr>
				<td>
					<ul class="ul-list">
					[= page _ =
						<li><strong>[ ' ch | e ' ]</strong>
							<ul class="hl-line">
								[= l _ =
									<li>
										<a href="[ ' href ' ]" class="[ ' class | e ' ]">
											<img src="[ ' db: theme_url ' ]icon/spacer.png" title="[ ' title | e ' ]" alt="[ ' title | e ' ]">
										</a>
										[ ' link ' ]
									</li>
					[= m _ =
						[ ' nonstatic ' ]
						[ ' // next column hack ' ]
								</ul>
							</li>
						</ul>
					</td>
					<td>
						<ul class="ul-list">
					=]
								=]
							[= e _ =
								[ ' nonstatic ' ]
								</ul>
							=]
					=]
						</li>
					</ul>
				</td>
			</tr>
		</table>
		<br>
	
		[ '' pagination '' ]
	=]

[= pagination =]
<nav class="pagination">[ ' text ' ]</nav>
	