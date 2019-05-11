 Tabs theme.
 Common footer file.

.include ../../../../handler/page/template/_files.tpl
.include ../../../../handler/page/template/_comments.tpl
.include ../../../../handler/page/template/_rating.tpl

[ === DefaultFoot === ]
</main>


<div class="Footer">
<img src="[ ' db: theme_url ' ]image/spacer.png" width="5" height="1" alt="" align="left">
<img src="[ ' db: theme_url ' ]image/spacer.png" width="5" height="1" alt="" align="right">


	[= tab TabList =
		<div class="Tab[ ' class ' ][ ' bonus ' ]" style="background-image:url([ ' db: theme_url ' ]icon/tabbg[ ' bonus1 ' ].png);">
			<table >
				<tr>
					<td><img src='[ ' db: theme_url ' ]icon/tabr[ ' appendix ' ][ ' bonus2 ' ].png' width="[ ' xsize ' ]" align='top' height="[ ' ysize ' ]" alt=""></td>
					<td><div class='TabText'>
						[= in _ =
							[ ' title ' ]
						=]
						[= out _ =
							<a href="[ ' method ' ]" title="[ ' hint ' ]" [ ' key | e attr | enclose ' accesskey="' '"' ' ][ ' params ' ]>[ ' title ' ]</a>
						=]
						</div></td>
					<td><img src='[ ' db: theme_url ' ]icon/tabl[ ' appendix ' ][ ' bonus2 ' ].png' width="[ ' xsize ' ]" align="top" height="[ ' ysize ' ]" alt=""></td>
				</tr>
			</table>
		</div>
		
		
	=]

<div class="TabSpace">
<div class="TabText" style="padding-left: 10px">
	[= owner =
		[ ' _t: Owner ' ]: [ ' name | e ' ][ ' link ' ]
	=]
	[= claim =
		[ ' _t: Nobody ' ][ ' take Take ' ]
	=]
	[= perma permalink =
		[ ' link ' ]
	=]
</div>
</div>
</div>
</div>

	[''' fp FilePanel ''']
	[''' cp CommentPanel ''']
	[''' rp RatingPanel ''']

<footer>
	<nav class="footer">
		<div class="page-meta">
			<ul>
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
 
 [ === TabTitle === ]
[ ' im TabImage ' ] [ ' title ' ]
[ === TabImage === ]
<img src="[ ' db: theme_url ' ]icon/spacer.png" alt="[ ' title ' ]">
