[ === main === ]
	[ ' help ' ]
	[ '' icon '' ]
	[= label _ =
		[ ' _t: LastEditedBy ' ]:
	=]
	[= user =
		[ ' name | e ' ][ ' link ' ]
	=]
	<small>
	[= modHide =
		([ '' modified '' ])
	=]
	[= mod =
		(<a href="[ ' href ' ]" title="[ ' _t: RevisionTip ' ]">[ '' modified '' ]</a>)
	=]
	[ ' notes ' ]
	</small>
	
[ === icon === ]
<img src="[ ' db: theme_url ' ]icon/spacer.png" alt="[ ' _t: LastEditedBy ' ]" title="[ ' _t: LastEditedBy ' ]" class="btn-revisions btn-sm">

[ === modified === ]
<time datetime="[ ' time ' ]">[ ' time | time_format ' ]</time>
	