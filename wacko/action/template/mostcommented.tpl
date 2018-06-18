[ === main === ]
	[= mark _ =
		<div class="layout-box">
			<p>
				<span>[ ' _t: MostCommentedPages ' ]: [ ' legend ' ]</span>
			</p>
	=]
	[= none _ =

	=]
	<table class="">
		[= l _ =
			<tr>
				<td>&nbsp;&nbsp;[ ' num ' ]</td>
				<td>[ ' link ' ]</td>
				<td>&nbsp;&nbsp;</td>
				<td><a href="[ ' href ' ]">[ ' comments | number 0 , . ' ]</a></td>
			</tr>
		=]
	</table>
	[= emark _ =
		[ ' nonstatic ' ]
		</div>
	=]
	[''' pagination ''']


[= pagination =]
<nav class="pagination">[ ' text ' ]</nav>
