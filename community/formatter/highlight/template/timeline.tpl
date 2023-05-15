[ === main === ]
<ignore>
<!--notypo-->
	[ ' style ' ]
	<ul class="timeline">
		[= n _ =
		<li>
			<div class="direction-[ ' direction ' ]">
				<div class="flag-wrapper">
					<span class="flag">[ ' flag | e ' ]</span>
					<span class="time-wrapper">
						<span class="time">[ ' time | e ' ]</span>
					</span>
				</div>
				<div class="desc">[ ' description ' ]</div>
			</div>
		</li>
		=]
	</ul>	
<!--/notypo-->
</ignore>

[ === style === ]
<style>[ ' n css ' ]</style>

[ === css === ]
[ ' nonstatic ' ]
/* ================ The Timeline ================ */

.timeline {
	position: relative;
	width: 660px;
	margin: 0 auto;
	margin-top: 20px;
	padding: 1em 0;
	list-style-type: none;
}

.timeline:before {
	position: absolute;
	left: 50%;
	top: 0;
	content: ' ';
	display: block;
	width: 6px;
	height: 100%;
	margin-left: -3px;
	background: rgb(80,80,80);
	background: linear-gradient(to bottom, rgba(80,80,80,0) 0%, rgb(80,80,80) 8%, rgb(80,80,80) 92%, rgba(80,80,80,0) 100%);

	z-index: 5;
}

.timeline li {
	padding: 1em 0;
}

.timeline li:after {
	content: '';
	display: block;
	height: 0;
	clear: both;
	visibility: hidden;
}

.timeline div:hover {
	background: var(--ww-hover-secondary);
}

.direction-l {
	position: relative;
	width: 300px;
	float: left;
	text-align: right;
}

.direction-r {
	position: relative;
	width: 300px;
	float: right;
}

.flag-wrapper {
	position: relative;
	display: inline-block;

	text-align: center;
}

.flag {
	position: relative;
	display: inline;
	background: rgb(248,248,248);
	padding: 6px 10px;
	border-radius: 5px;

	font-weight: 600;
	text-align: left;
}

.direction-l .flag {
	box-shadow: -1px 1px 1px rgba(0,0,0,0.15), 0 0 1px rgba(0,0,0,0.15);
}

.direction-r .flag {
	box-shadow: 1px 1px 1px rgba(0,0,0,0.15), 0 0 1px rgba(0,0,0,0.15);
}

.direction-l .flag:before,
.direction-r .flag:before {
	position: absolute;
	top: 50%;
	right: -40px;
	content: ' ';
	display: block;
	width: 12px;
	height: 12px;
	margin-top: -10px;
	background: #fff;
	border-radius: 10px;
	border: 4px solid rgb(255,80,80);
	z-index: 10;
}

.direction-r .flag:before {
	left: -40px;
}

.direction-l .flag:after {
	content: '';
	position: absolute;
	left: 100%;
	top: 50%;
	height: 0;
	width: 0;
	margin-top: -8px;
	border: solid transparent;
	border-left-color: rgb(248,248,248);
	border-width: 8px;
	pointer-events: none;
}

.direction-r .flag:after {
	content: '';
	position: absolute;
	right: 100%;
	top: 50%;
	height: 0;
	width: 0;
	margin-top: -8px;
	border: solid transparent;
	border-right-color: rgb(248,248,248);
	border-width: 8px;
	pointer-events: none;
}

.time-wrapper {
	display: inline;
	
	line-height: 1rem;
	font-size: 0.66666rem;
	color: rgb(250,80,80);
	vertical-align: middle;
}

.direction-l .time-wrapper {
	float: left;
}

.direction-r .time-wrapper {
	float: right;
}

.time {
	display: inline-block;
	padding: 4px 6px;
	background: rgb(248,248,248);
}

.desc {
	margin: 1rem 0.75rem 0 0;
	
	font-size: 0.77777rem;
	font-style: italic;
	line-height: 1.5rem;
}

.direction-r .desc {
	margin: 1em 0 0 0.75rem;
}

/* ================ Timeline Media Queries ================ */

@media screen and (max-width: 660px) {

	.timeline {
		width: 100%;
		padding: 4rem 0 1rem 0;
	}
	
	.timeline li {
		padding: 2rem 0;
	}
	
	.direction-l,
	.direction-r {
		float: none;
		width: 100%;
	
		text-align: center;
	}
	
	.flag-wrapper {
		text-align: center;
	}
	
	.flag {
		background: rgb(255,255,255);
		z-index: 15;
	}
	
	.direction-l .flag:before,
	.direction-r .flag:before {
		position: absolute;
		top: -30px;
		left: 50%;
		content: ' ';
		display: block;
		width: 12px;
		height: 12px;
		margin-left: -9px;
		background: #fff;
		border-radius: 10px;
		border: 4px solid rgb(255,80,80);
		z-index: 10;
	}
	
	.direction-l .flag:after,
	.direction-r .flag:after {
		content: '';
		position: absolute;
		left: 50%;
		top: -8px;
		height: 0;
		width: 0;
		margin-left: -8px;
		border: solid transparent;
		border-bottom-color: rgb(255,255,255);
		border-width: 8px;
		pointer-events: none;
	}
	
	.time-wrapper {
		display: block;
		position: relative;
		margin: 4px 0 0 0;
		z-index: 14;
	}
	
	.direction-l .time-wrapper {
		float: none;
	}
	
	.direction-r .time-wrapper {
		float: none;
	}
	
	.desc {
		position: relative;
		margin: 1rem 0 0 0;
		padding: 1rem;
		background: rgb(245,245,245);
		box-shadow: 0 0 1px rgba(0,0,0,0.20);
	
		z-index: 15;
	}
	
	.direction-l .desc,
	.direction-r .desc {
		position: relative;
		margin: 1rem 1em 0 1rem;
		padding: 1rem;
	
		z-index: 15;
	}

}

@media screen and (min-width: 400px ?? max-width: 660px) {

	.direction-l .desc,
	.direction-r .desc {
		margin: 1em 4em 0 4em;
	}

}