[ === main === ]
<!--noinclude-->
	[ ' help ' ] 
	<nav class="nav-chapter no-print">
	[= tbl _ =
		<table>
			<tr>
				<td>
				[= prev _ =
					[ ' link ' ]
				=]
				</td>
				<td>
				[= main _ =
					[ ' link ' ]
				=]
				</td>
				<td>
				[= next _ =
					[ ' link ' ]
				=]
				</td>
			</tr>
		</table>
	=]
	[= div _ =
		[= main _ =
			[ ' link ' ]
		=]
		<div class="pagination">
		[= prev _ =
			[ ' link ' ]
		=]
		[= separator _ =
			[ ' nonstatic ' ]
		 | 
		=]
		[= next _ =
			[ ' link ' ]
		=]
		</div>
	=]
	</nav>
<!--/noinclude-->