[ === main === ]
	<h3>[ ' _t: ReferrersText ' ] » [ ' header ' ]</h3>
	[ ' menu ' ]
	[= b _ =
		<strong>[ ' _t: ReferringPages ' ]:</strong><br><br>
		[ ' links ' ]
		<p></p>
	=]

	<strong>[ ' title ' ]</strong><br><br>

	[ '' pagination '' ]

	<ul class="ul-list">
		[= p _ =
			<li><strong>[ ' link ' ]</strong> ([ ' num ' ])
				<ul class="hl-line">
					[= l _ =
						<li>
							<span class="[ ' vclass ' ]">[ ' val ' ]</span>
							<span class="">
								<a title="[ ' ref | e ' ]" href="[ ' ref | e ' ]" rel="nofollow noreferrer">[ ' trunc | e ' ]</a>
							</span>
						</li>
					=]
				</ul><br>
			</li>
		=]
		[= t _ =
			<li><strong>[ ' day ' ]</strong>
				<ul class="hl-line">
					[= l _ =
						<li>
							<span class="[ ' vclass ' ]">[ ' val ' ]</span>
							<span class="">
								<a title="[ ' ref | e ' ]" href="[ ' ref | e ' ]" rel="nofollow noreferrer">[ ' trunc | e ' ]</a>
							</span>
							[= l _ =
								&nbsp;&nbsp;→&nbsp;&nbsp;<small>[ ' link ' ]</small>
							=]
						</li>
					=]
				</ul><br>
			</li>
		=]
		[= g _ =
			[= l _ =
				<li>
					<span class="[ ' vclass ' ]">[ ' val ' ]</span>
					<span class="">
						<a title="[ ' ref | e ' ]" href="[ ' ref | e ' ]" rel="nofollow noreferrer">[ ' trunc | e ' ]</a>
					</span>
				</li>
			=]
		=]
		[= none _ =
			[ ' _t: NoneReferrers ' ]<br><br>
		=]
	</ul>

	[ '' pagination '' ]


[= pagination =]
<nav class="pagination">[ ' text ' ]</nav>