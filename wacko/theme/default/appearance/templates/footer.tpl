 Default theme.
 Common footer file.


[ === main === ]
</main>
<footer>
<nav class="footer">
<div class="footerlist">
<ul>
['' edit '']
['' modHide '']
['' mod '']
['' owner '']
['' claim '']
['' perma permalink '']
</ul>
</div>
</nav>
<div id="credits">
['' by '']
['' policy '']
</div>
</footer>
</div>
[''
	// Don't place final </body></html> here. Wacko closes HTML automatically.
'']

[ === edit === ]
<li><a href="['' href | e attr '']" accesskey="E" title="['' _t: EditTip '']">['' _t: EditText'']</a></li>
[ === modHide === ]
<li><time datetime="['' time '']">['' time | time_formatted '']</time></li>
[ === mod === ]
<li><a href="['' revisions | '']" title="['' _t: RevisionTip '']">
<time datetime="['' time '']">['' time | time_formatted '']</time></a></li>
[ === owner === ]
<li>['' _t: Owner '']: ['' name '']['' link | '']</li>
[ === claim === ]
<li>['' _t: Nobody '']['' take '']</li>
[ === take === ]
 (<a href="['' href | e attr '']">['' _t: TakeOwnership '']</a>)
[ === permalink === ]
<li>['' link | '']</li>

[ === by === ]
['' _t: PoweredBy ''] ['' home | ''] ['' version '']['' patchlevel '']<br />

[ === policy === ]
<a href="['' url | e attr '']">['' _t: TermsOfUse '']</a><br />'
