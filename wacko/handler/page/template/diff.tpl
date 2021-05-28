[ === main === ]
	[ ' denied ' ]
	[ ' nodiff ' ]

	[= nav _ =
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
				<col span="1" class="diffmeta-a">
				<col span="1" class="diffmeta-b">
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
	=]
	[= diff _ =
		[= m0 _ =
			<br><br>
			[ ' diff ' ]
		=]
		[= m2 _ =
			[ ' nodiff ' ]
			[= added _ =
				[= browser _ =
					<br><strong>[ ' _t: SimpleDiffAdditions ' ]</strong><br>
				=]
				[= email _ =
					** %%SimpleDiffAdditions%% **<br>
					[ ' nonstatic ' ]
				=]
				<div class="additions">[ ' diff | pre ' ]</div>
			=]
			[= deleted _ =
				[= browser _ =
					<br><strong>[ ' _t: SimpleDiffDeletions ' ]</strong><br>
				=]
				[= email _ =
					<br>** %%SimpleDiffDeletions%% **<br>
					[ ' nonstatic ' ]
				=]
				<div class="deletions">[ ' diff | pre ' ]</div>
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
[= prev _ =
	<a href="[ ' href ' ]">← [ ' _t: PreviousEdit ' ]</a>
=]
[= next _ =
	<a href="[ ' href ' ]">[ ' _t: NextEdit ' ] →</a>
=]
<br>
<div class="diffdown">
	<span>[ ' version ' ]</span>
	<a href="[ ' href ' ]">
		[ ' modified | time_formatted ' ]
		<span class="dropdown-arrow">▼</span>
	</a>
	<div class="diffdown-content">
		[= r _ =
			<a href="[ ' href ' ]" [ ' class ' ]>
				<span><strong>[ ' version ' ]</strong></span>
				[ ' modified | time_formatted ' ]
				[ ' username ' ]
				[ ' editnote | enclose " [" "]" ' ]
			</a>
		=]
	</div><br>
	([ ' size ' ]) [ ' delta ' ]<br>
	[ ' username ' ]<br>
	[= m _ =
		<abbr class="minoredit" title="[ ' _t: EditMinor ' ]">[ ' minor ' ]</abbr>
	=]
	[= n _ =
		<span class="editnote">[ ' note | enclose " [" "]" ' ]</span>
	=]
</div>
