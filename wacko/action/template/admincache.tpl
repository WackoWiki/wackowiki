
[ === main === ]
	<form action="[ ' href ' ]" method="post" name="purge_cache">
		['' csrf: purge_cache '']
		<div class="layout-box">
			<input type="checkbox" id="purgeconfig_cache" name="config_cache">
			<label for="purgeconfig_cache">[ ' _t: ConfigCache ' ]</label><br>

			<input type="checkbox" id="purgefiles_cache" name="pages_cache">
			<label for="purgefiles_cache">[ ' _t: PageCache ' ]</label><br>

			<input type="checkbox" id="purgesql_cache" name="sql_cache">
			<label for="purgesql_cache">[ ' _t: SQLCache ' ]</label><br>

			<input type="checkbox" id="purgefeeds_cache" name="feed_cache">
			<label for="purgefeeds_cache">[ ' _t: FeedCache ' ]</label><br>

			<input type="checkbox" id="purgetemplates_cache" name="template_cache">
			<label for="purgetemplates_cache">[ ' _t: TemplateCache ' ]</label><br><br>

			<input type="submit" name="clear_cache" value="[ ' _t: ClearCache ' ]">
		</div>
	</form>

[ === post === ]
['' page '']['' sql '']['' config '']['' feed '']['' template '']['' _t: CacheCleared '']

[ === page === ]
['' _t: PageCache ''] (['' n |e '']) ... ['' '']

[ === sql === ]
['' _t: SQLCache ''] (['' n |e '']) ... ['' '']

[ === config === ]
['' _t: ConfigCache ''] (['' n |e '']) ... ['' '']

[ === feed === ]
['' _t: FeedCache ''] (['' n |e '']) ... ['' '']

[ === template === ]
['' _t: TemplateCache ''] (['' n |e '']) ... ['' '']
