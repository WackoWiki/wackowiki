[ === RatingPanel === ]
	[= s _ =
		<section id="section-rating">
			<header id="header-rating">
				<h1>[ ' title | e ' ] 
				[= l _ =
					[<a href="[ ' href ' ]" title="[ ' title | e attr ' ]">[ ' text ' ]</a>]</h1>
				=]
			</header>
			[= f _ =
				<div class="rating">
					<form action="[ ' href: rate ' ]" method="post" name="rate">
						[ ' csrf: rate ' ]
						[= i _ =
							<input type="radio" id="[ ' label ' ]" name="value" value="[ ' value ' ]">
							<label for="[ ' label ' ]">[ ' value ' ]</label>
						=]
						&nbsp;&nbsp;
						<input type="submit" name="rate" id="submit" value="[ ' _t: SubmitButton ' ]">
					</form>
				</div>
			=]
			[= r _ =
				<div class="rating">
					[= rated _ =
						[ ' _t: RatingTotal ' ]: <strong>[ ' ratio ' ]</strong> 
						[ ' _t: RatingVoters ' ]: <strong>[ ' voters ' ]</strong>
					=]
					[= notrated _ =
						<em>[ ' _t: RatingNotRated ' ]</em>
					=]
				</div>
			=]
		</section>
	=]