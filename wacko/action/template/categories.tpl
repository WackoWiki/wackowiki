[ === main === ]
	[= o _ =
		[= mark _ =
			<div class="layout-box">
				<p>
					<span>[ ' _t: Categories ' ]:</span>
				</p>
		=]
		<ol>
			[= l _ =
				<li>
					<a href="[ ' href ' ]" class="tag" rel="tag">[ ' category | e ' ]</a>
				</li>
			=]
		</ol>
	=]

	[= d _ =
		[= mark _ =
			[ ' nonstatic ' ]
			<div class="layout-box">
		=]
		[= label _ =
			[ ' _t: Categories ' ]:
		=]
		[ '' icon '' ] [ '' l link '' ]
	=]

	[= emark _ =
		[ ' nonstatic ' ]
		</div>
	=]

[ === icon === ]
<img src="[ ' db: theme_url ' ]icon/spacer.png" alt="[ ' _t: Categories ' ]" title="[ ' _t: Categories ' ]" class="btn-tag">

[ === link === ]
[ ' delim ' ]<a href="[ ' href ' ]" class="tag" rel="tag">[ ' category | e ' ]</a>
