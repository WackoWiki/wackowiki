 Default theme.
 Common footer file.

[ === DefaultFoot === ]
</main>
<footer[ ' dir ' ]>
	<nav class="footer">
		<div class="page-meta">
			<ul>
				[= edit =
					<li><a href="[ ' href ' ]" title="[ ' _t: EditTip ' ]">[ ' _t: EditText' ]</a></li>
				=]
				[= modHide =
					<li>
						<time datetime="[ ' time ' ]">[ ' time | time_format ' ]</time>
					</li>
				=]
				[= mod =
					<li>
						<a href="[ ' revisions ' ]" title="[ ' _t: RevisionTip ' ]">
						<time datetime="[ ' time ' ]">[ ' time | time_format ' ]</time></a>
					</li>
				=]
				[= owner =
					<li>[ ' _t: OwnerColon ' ] [ ' name | e ' ][ ' link ' ]</li>
				=]
				[= claim =
					<li>[ ' _t: Nobody ' ][ ' take Take ' ]</li>
				=]
				[= perma permalink =
					<li>[ ' link ' ]</li>
				=]
			</ul>
		</div>
	</nav>
	[= credits =
	<div id="credits">
		[= by =
			[ ' _t: PoweredBy ' ] [ ' home ' ] [ ' version ' ][ ' patchlevel ' ]
		=]
		<br>
		[= license =
			<div id="license">
				[ ' text ' ]
			</div>
		=]
		<ul>
			[= help =
				<li><a href="[ ' href ' ]">[ ' _t: Help ' ]</a></li>
			=]
			[= privacy =
				<li><a href="[ ' href ' ]">[ ' _t: PrivacyPolicy ' ]</a></li>
			=]
			[= terms =
				<li><a href="[ ' href ' ]">[ ' _t: TermsOfUse ' ]</a></li>
			=]
		</ul>
	</div>
	=]
</footer>
</div>

[= f =
	[ ' additions ' ]
=]

[ '
	// Don't place final </body></html> here. Wacko closes HTML automatically.
' ]

[ === Take === ]
 (<a href="[ ' href ' ]">[ ' _t: TakeOwnership ' ]</a>)
