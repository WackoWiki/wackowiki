
[ === main === ]
	[ ' help ' ]
	[= form _ =
		<form action="[ ' href ' ]" method="post" name="purge_cache">
			[ ' csrf: purge_cache ' ]
			<div class="layout-box">
				<input type="checkbox" id="purge_config_cache" name="config_cache">
				<label for="purge_config_cache">[ ' _t: ConfigCache ' ]</label><br>

				<input type="checkbox" id="purge_pages_cache" name="pages_cache">
				<label for="purge_pages_cache">[ ' _t: PageCache ' ]</label><br>

				<input type="checkbox" id="purge_sql_cache" name="sql_cache">
				<label for="purge_sql_cache">[ ' _t: SQLCache ' ]</label><br>

				<input type="checkbox" id="purge_feeds_cache" name="feed_cache">
				<label for="purge_feeds_cache">[ ' _t: FeedCache ' ]</label><br>

				<input type="checkbox" id="purge_templates_cache" name="template_cache">
				<label for="purge_templates_cache">[ ' _t: TemplateCache ' ]</label><br>

				<input type="checkbox" id="purge_thumb_cache" name="thumb_cache">
				<label for="purge_thumb_cache">[ ' _t: ThumbCache ' ]</label><br><br>

				<button type="submit" name="clear_cache">[ ' _t: ClearCache ' ]</button>
			</div>
		</form>
	=]

[ === post === ]
[ ' page ' ][ ' sql ' ][ ' config ' ][ ' feed ' ][ ' template ' ][ ' thumbnail ' ][ ' _t: CacheCleared ' ]

[ === page === ]
[ ' _t: PageCache ' ] ([ ' n | e ' ]) ... ['' '']

[ === sql === ]
[ ' _t: SQLCache ' ] ([ ' n | e ' ]) ... ['' '']

[ === config === ]
[ ' _t: ConfigCache ' ] ([ ' n | e ' ]) ... ['' '']

[ === feed === ]
[ ' _t: FeedCache ' ] ([ ' n | e ' ]) ... ['' '']

[ === template === ]
[ ' _t: TemplateCache ' ] ([ ' n | e ' ]) ... ['' '']

[ === thumbnail === ]
[ ' _t: ThumbCache ' ] ([ ' n | e ' ]) ... ['' '']
