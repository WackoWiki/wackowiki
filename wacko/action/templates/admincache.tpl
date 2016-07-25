
[ === main === ]
<form action="[' href | e html_attr']" method="post" name="purge_cache">
	[' // hide_page: | ']
	[' csrf: purge_cache | ']
	<div class="layout-box">
		<input type="checkbox" id="purgeconfig_cache" name="config_cache" />
		<label for="purgeconfig_cache">[''	_t: ConfigCache '']</label><br />

		<input type="checkbox" id="purgefiles_cache" name="pages_cache" />
		<label for="purgefiles_cache">[''	_t: PageCache '']</label><br />

		<input type="checkbox" id="purgesql_cache" name="sql_cache" />
		<label for="purgesql_cache">[''		_t: SQLCache '']</label><br />

		<input type="checkbox" id="purgefeeds_cache" name="feed_cache" />
		<label for="purgefeeds_cache">[''	_t: FeedCache '']</label><br /><br />

		<input type="submit" name="clear_cache" value="['' _t: ClearCache '']" />
	</div>
</form>

[ === post === ]
['' page '']['' sql '']['' config '']['' feed '']['' _t: CacheCleared '']
[ === page === ]
['' _t: PageCache ''] (['' n '']) ... ['' '']
[ === sql === ]
['' _t: SQLCache ''] (['' n '']) ... ['' '']
[ === config === ]
['' _t: ConfigCache ''] (['' n '']) ... ['' '']
[ === feed === ]
['' _t: FeedCache ''] (['' n '']) ... ['' '']

