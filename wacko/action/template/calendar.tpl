[ === main === ]
	<table style="margin: auto;">
		<tr>
			[= m _ =
				[ ' month ' ]
			=]
		</tr>
	</table>

[ == month == ]
<td class="a-top">
	<table class="calendar">
		<caption class="calendar-month">[ ' prev ' ][ ' title ' ][ ' next ' ]</caption>
		<tr>
			[= h _ =
				<th abbr="[ ' abbr ' ]">[ ' day ' ]</th>
			=]
		</tr>
		<tr>
			[= first _ =
				<td colspan="[ ' colspan ' ]"> </td>
			=]
			[= d _ =
				[ ' next ' ]
				<td class="[ ' classes ' ]">
					<a href="[ ' link ' ]">
						[ ' content ' ]
					</a>
				</td>
			=]
			[= last _ =
				<td colspan="[ ' colspan ' ]"> </td>
			=]
		</tr>
	</table>
</td>
[ ' next ' ]

[ == next == ]
[ ' nonstatic ' ]
</tr>
<tr>