 Default theme.
 Common footer file.

[ === DefaultFoot === ]
</main>
<footer>
	<nav class="footer">
		<div class="page-meta">
			<ul>
				[= edit =
					<li><a href="[ ' href ' ]" accesskey="E" title="[ ' _t: EditTip ' ]">[ ' _t: EditText' ]</a></li>
				=]
				[= modHide =
					<li>
						<time datetime="[ ' time ' ]">[ ' time | time_formatted ' ]</time>
					</li>
				=]
				[= mod =
					<li>
						<a href="[ ' revisions ' ]" title="[ ' _t: RevisionTip ' ]">
						<time datetime="[ ' time ' ]">[ ' time | time_formatted ' ]</time></a>
					</li>
				=]
				[= owner =
					<li>[ ' _t: Owner ' ]: [ ' name | e ' ][ ' link ' ]</li>
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
