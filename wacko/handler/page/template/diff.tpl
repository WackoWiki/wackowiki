[ === main === ]
	[ ' denied ' ]
	[ ' nodiff ' ]
	
	<!--nomail-->
	<h3>[ ' head ' ]</h3>
	<ul class="menu">
		[= l _ =
			[ ' diffmode ' ]
		=]
	</ul>
	<br><br><br>
	<table class="diff">
		<colgroup>
			<col span="1" style="width: 50%;">
			<col span="1" style="width: 50%;">
		</colgroup>
		<tr>
			<td>
				[ ' a diffmeta ' ]
			</td>
			<td>
				[ ' b diffmeta ' ]
			</td>
		</tr>
	</table>
	<!--/nomail-->

	[= diff _ =
		[= m0 _ =
			<br><br>
			[ ' diff ' ]
		=]
		[= m2 _ =
			[ ' nodiff ' ]
			[= added _ =
				<br><strong>[ ' _t: SimpleDiffAdditions ' ]</strong><br>
				<div class="additions">
					[ ' diff | pre ' ]
				
				</div>
			=]
			[= deleted _ =
				<br><strong>[ ' _t: SimpleDiffDeletions ' ]</strong><br>
				<div class="deletions">
					[ ' diff | pre ' ]
				
				</div>
			=]
		=]
		[= m6 _ =
			<br><br>
			[ ' nodiff ' ]
			[ ' diff ' ]
		=]
	=]


[= nodiff =]
<br>[ ' _t: NoDifferences ' ]

[= diffmeta =]
<div class="diffdown">
	<span>[ ' version ' ]</span>
	<a href="[ ' href ' ]">
		[ ' modified | time_formatted ' ]
		<span class="dropdown-arrow">&#9660;</span>
	</a>
	<div class="diffdown-content">
		[= r _ =
			<a href="[ ' href ' ]" [ ' class ' ]>
				<span>[ ' version ' ]</span>
				[ ' modified | time_formatted ' ]
				[ ' username ' ]
				[ ' editnote | enclose " [" "]" ' ]
			</a>
		=]
	</div><br>
	[ ' username ' ]<br>
	[= m _ =
		<abbr class="minoredit" title="[ ' _t: EditMinor ' ]">[ ' minor ' ]</abbr>
	=]
	[= n _ =
		<span class="editnote">[ ' note | enclose " [" "]" ' ]</span>
	=]
</div>
