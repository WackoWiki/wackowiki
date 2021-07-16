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
		<caption class="calendar-month">[ ' p nav ' ] [ ' title ' ] [ ' n nav ' ]</caption>
		<tr>
			[= h _ =
				<th abbr="[ ' abbr ' ]">[ ' day ' ]</th>
			=]
		</tr>
		<tr>
			[ ' first colspans ' ]
			[= d _ =
			[ ' next ' ]
				<td[ ' class ' ]>[ ' content ' ]</td>
			=]
			[ ' last colspans ' ]
		</tr>
	</table>
</td>
[ ' next ' ]

[ == next == ]
[ ' nonstatic ' ]
</tr>
<tr>
[ == colspans == ]
<td colspan="[ ' colspan ' ]"></td>
[ == nav == ]
<span class="[ ' class ' ]">[ ' text ' ]</span>
