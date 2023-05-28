
[ === main === ]
	[= post _ =
		<div class="info type-success">
			<div class="info-content">
				<p class="info-title">Here is your completed stylesheet.</p>
				Note that it may not be perfect - no regular expression styles are included for one thing,
				you'll have to add those yourself (php and xml are just two languages that use them), and line numbers are not included, however
				it includes most of the basic information.
			</div>
		</div>
		[ '' reset ResetButton '' ]<br><br>
		<strong>theme/_common/geshi.css</strong> ([ ' size ' ])
		<pre class="code">
			[ ' stylesheet | pre' ]
		</pre>

		[= syntax _ =
			<strong>syntax wiki table</strong>
			<pre class="code">
				[ '' n table '' ]
			</pre>
		=]
		
		[ '' reset ResetButton '' ]
	=]

	[= form _ =
		<form action="[ ' href: ' ]" method="post" name="geshi_css">
			[ ' csrf: geshi_css ' ]
			What languages are you wanting to make this stylesheet for?<br><br>
			[ '' CreateButton '' ]<br><br>
			[ '' n selection '' ]<br>
			<div class="wrapper-col5">
			[= lang _ =
				<input type="checkbox" name="langs[[ ' lang ' ]]" id="lang_[ ' lang ' ]"[ ' checked ' ]>
				<label for="lang_[ ' lang ' ]">[ ' lang ' ]</label><br>
			=]
			</div>
			<br>
			[ '' n selection '' ]
			<br>

			[= custom _ =
				If you'd like any other languages not detected here to be supported, please enter
				them here, one per line:<br>
				<textarea rows="4" cols="20" name="extra-langs"></textarea><br>
				<br>
				Styles:
				<table>
				[= style _ =
					<tr>
						<th>[ ' text ' ]</th>
						<td><input type="text" name="[ ' type ' ]" value="[ ' style ' ]"></td>
					</tr>
				=]
				</table>
			=]

			[ '' CreateButton '' ]
		</form>
	=]

[ == selection == ]
Select: <a href="[ ' select ' ]">All</a>, <a href="[ ' none ' ]">None</a>, <a href="[ ' href: ' ]">[ ' _t: ResetButton ' ]</a><br>

[ == CreateButton == ]
<button type="submit" class="btn-ok">Create CSS</button>

[ == ResetButton == ]
<a href="[ ' href: ' ]" class="btn-link"><button type="button" class="btn-cancel">[ ' _t: ResetButton ' ]</button></a>

[ == table == ]
#|
*| # | Formatter | Language |* 
[= n _ =
|| [ ' num ' ] | ##[ ' lang ' ]## | [ ' name ' ] ||
[ ' commit | void' ]
=]
|#
