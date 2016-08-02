<?php

if (!defined('IN_WACKO'))
{
	exit;
}

// {{blog [page=cluster] [mode=latest|week|from] [date=YYYY-MM-DD] [max=Number] [title=1] [noxml=1]}}

if (!isset($page))		$page = $this->unwrap_link(isset($for) ? $for : '');
$error	= '';

$blog_cluster = $page;

if (!empty($blog_cluster))
{
	if (!isset($max))	$max = '';
	if (isset($_GET['category']))
	{
		$mode			= 'category';
		$category_id	= $_GET['category'];
	}
	if (!isset($mode))	$mode = 'latest';
	if (!isset($title))	$title = 1;
	if (!isset($noxml))	$noxml = 0;

	$pages			= '';
	$prefix			= $this->db->table_prefix;
	#$blog_cluster		= $blog_cluster;
	$blog_levels		= $this->db->news_levels;

	// hide article H1 header
	$this->hide_article_header = true;

	// check privilege
	$access = $this->has_access('create');

	if (@$_POST['_action'] === 'add_topic' && $access)
	{
		// checking user input
		if (isset($_POST['title']))
		{
			$name		= trim($_POST['title'], ". \t");
			$namehead	= $name;
			$name		= ucwords($name);
			$name		= preg_replace('/[^- \\w]/', '', $name);
			$name		= str_replace(array(' ', "\t"), '', $name);

			if ($name == '')
			{
				$error = $this->_t('NewsNoName');
			}
		}
		else
		{
			$error = $this->_t('NewsNoName');
		}

		// if errors were found - return, else continue
		if ($error)
		{
			$this->set_message($error, 'error');
			$this->http->redirect($this->href());
		}
		else
		{
			// building news template
			$template	= '';

			// redirecting to the edit form
			$this->sess->body	= $template;
			$this->sess->title	= $namehead;

			if ($this->db->enable_feeds)
			{
				#$this->sess->feed	= true;
			}

			// needs to be numeric for ordering
			// TODO: add this as config option to Admin panel
			// .date('Y/')							- 2011
			// .date('Y/').date('m/')				- 2011/07 (default)
			// .date('Y/').date('m/').date('d/')	- 2011/07/14
			// .date('Y/').date('W/')				- 2011/29
			$blog_cluster_structure = date('Y/').date('m/');

			$this->http->redirect($this->href('edit', $blog_cluster.'/'.$blog_cluster_structure.$name, '', 1));
		}
	}
	// collect data
	// heavy lifting here (watch out for REGEXPs!)
	if ($mode == 'latest')
	{
		$count	= $this->db->load_single(
			"SELECT COUNT(tag) AS n ".
			"FROM {$prefix}page ".
			"WHERE tag REGEXP '^{$blog_cluster}{$blog_levels}$' ".
				"AND comment_on_id = '0' ".
				"AND deleted <> '1' ", true);

		$pagination = $this->pagination($count['n'], $max, 'p', ['mode' => 'latest']);

		$pages	= $this->db->load_all(
			"SELECT p.page_id, p.owner_id, p.user_id, p.tag, p.title, p.created, p.comments, u.user_name AS owner ".
			"FROM {$prefix}page p ".
				"INNER JOIN {$prefix}user u ON (p.owner_id = u.user_id) ".
			"WHERE p.comment_on_id = '0' ".
				"AND p.tag REGEXP '^{$blog_cluster}{$blog_levels}$' ".
				"AND p.deleted <> '1' ".
			"ORDER BY p.created DESC ".
			$pagination['limit'], true);
	}
	else if ($mode == 'category')
	{
		$count	= $this->db->load_single(
			"SELECT COUNT(p.tag) AS n ".
			"FROM {$prefix}category_page c ".
				"INNER JOIN {$prefix}page p ON (c.page_id = p.page_id) ".
			"WHERE p.tag REGEXP '^{$blog_cluster}{$blog_levels}$' ".
				"AND c.category_id = '$category_id' ".
				"AND p.deleted <> '1' ".
				"AND p.comment_on_id = '0'", true);

		$pagination = $this->pagination($count['n'], $max, 'p', ['category' => $category_id]);

		$category_title	= $this->db->load_single(
			"SELECT category ".
			"FROM {$prefix}category ".
			"WHERE category_id = '$category_id' ", false);

		$pages	= $this->db->load_all(
			"SELECT p.page_id, p.owner_id, p.user_id, p.tag, p.title, p.created, p.comments, u.user_name AS owner ".
			"FROM {$prefix}page p ".
				"INNER JOIN {$prefix}user u ON (p.owner_id = u.user_id) ".
				"INNER JOIN {$prefix}category_page c  ON (c.page_id = p.page_id) ".
			"WHERE p.comment_on_id = '0' ".
				"AND p.tag REGEXP '^{$blog_cluster}{$blog_levels}$' ".
				"AND p.deleted <> '1' ".
				"AND c.category_id = '$category_id' ".
			"ORDER BY p.created DESC ".
			$pagination['limit'], true);
	}
	else if ($mode == 'week')
	{
		$count	= $this->db->load_single(
			"SELECT COUNT(tag) AS n ".
			"FROM {$prefix}page ".
			"WHERE tag REGEXP '^{$blog_cluster}{$blog_levels}$' ".
				"AND deleted <> '1' ".
				"AND created > DATE_SUB( UTC_TIMESTAMP(), INTERVAL 7 DAY ) ".
				"AND comment_on_id = '0'", true);

		$pagination = $this->pagination($count['n'], $max, 'p', ['mode' => 'week']);

		$pages	= $this->db->load_all(
			"SELECT p.page_id, p.owner_id, p.user_id, p.tag, p.title, p.created, p.comments, u.user_name AS owner ".
			"FROM {$prefix}page p ".
				"INNER JOIN {$prefix}user u ON (p.owner_id = u.user_id) ".
			"WHERE p.comment_on_id = '0' ".
				"AND p.tag REGEXP '^{$blog_cluster}{$blog_levels}$' ".
				"AND p.deleted <> '1' ".
				"AND p.created > DATE_SUB( UTC_TIMESTAMP(), INTERVAL 7 DAY ) ".
			"ORDER BY p.created DESC ".
			$pagination['limit'], true);
	}
	else if ($mode == 'from' && $date)
	{
		$count	= $this->db->load_single(
			"SELECT COUNT(tag) AS n ".
			"FROM {$prefix}page ".
			"WHERE tag REGEXP '^{$blog_cluster}{$blog_levels}$' ".
				"AND deleted <> '1' ".
				"AND created > '$date' ".
				"AND comment_on_id = '0'", true);

		$pagination = $this->pagination($count['n'], $max, 'p', ['mode' => 'week']);

		$date	= date(SQL_DATE_FORMAT, strtotime($date)); // TODO sql date/tz 
		$pages	= $this->db->load_all(
			"SELECT p.page_id, p.owner_id, p.user_id, p.tag, p.title, p.created, p.comments, u.user_name AS owner ".
			"FROM {$prefix}page p ".
				"INNER JOIN {$prefix}user u ON (p.owner_id = u.user_id) ".
			"WHERE p.comment_on_id = '0' ".
				"AND p.tag REGEXP '^{$blog_cluster}{$blog_levels}$' ".
				"AND p.deleted <> '1' ".
				"AND p.created > '$date' ".
			"ORDER BY p.created DESC ".
			$pagination['limit'], true);
	}

	// start output
	echo '<section class="news">';

	if ($title == 1)
	{
		if (isset($category_title))
		{
			$_category_title = ' '.$this->_t('For').' '.$this->_t('Category').' &laquo;'.$category_title['category'].'&raquo;';
		}
		else
		{
			$_category_title = '';
		}

		if ($this->page['tag'] == $blog_cluster)
		{
			$_title = $this->_t('News').$_category_title;
		}
		else
		{
			$_title = $this->compose_link_to_page($blog_cluster, '', $this->_t('News'), 0).$_category_title;
		}

		echo "<h1>".$_title."</h1>";
	}

	// displaying XML icon
	if (!(int)$noxml)
	{
		if ($this->db->news_cluster)
		{
			if (substr($this->tag, 0, strlen($this->db->news_cluster.'/')) == $this->db->news_cluster.'/')
			{
				$feed_tag = 'news';
			}
		}
		else
		{
			$feed_tag = 'blog'.$this->page['page_id'];
		}

		echo '<span class="desc_rss_feed"><a href="'.$this->db->base_url.'xml/'.$feed_tag.'_'.preg_replace('/[^a-zA-Z0-9]/', '', strtolower($this->db->site_name)).'.xml"><img src="'.$this->db->theme_url.'icon/spacer.png'.'" title="'.$this->_t('RecentNewsXMLTip').'" alt="XML" class="btn-feed"/></a></span>'."\n";
	}

	echo '<div style="width:100%;">
			<p style="float: left">'.($access? '<strong><small class="cite"><a href="#newtopic">'.$this->_t('ForumNewTopic').'</a></small></strong>' : '').'</p>';
	$this->print_pagination($pagination);
	echo '<br style="clear:both" />
		</div>'."\n";

	// displaying articles
	if ($pages)
	{
		foreach ($pages as $page)
		{
			$_category = $this->get_categories($page['page_id']);
			$_category = !empty($_category) ? $this->_t('Category').': '.$_category.' | ' : '';

			echo '<article class="newsarticle">';
			echo '<h2 class="newstitle"><a href="'.$this->href('', $page['tag'], '').'">'.$page['title']."</a></h2>\n";
			echo '<div class="newsinfo"><span><time datetime="'.$this->page['created'].'">'.$this->get_time_formatted($page['created']).'</time> '.$this->_t('By').' '.$this->user_link($page['owner'], '', true, false)."</span></div>\n";
			echo '<div class="newscontent">'.$this->action('include', array('page' => '/'.$page['tag'], 'notoc' => 0, 'nomark' => 1), 1)."</div>\n";
			echo '<footer class="newsmeta">'.$_category." ".($this->has_access('write', $page['page_id']) ? $this->compose_link_to_page($page['tag'], 'edit', $this->_t('EditText'), 0)." | " : "")."  ".
				'<a href="'.$this->href('', $page['tag'], 'show_comments=1').'#header-comments" title="'.$this->_t('NewsDiscuss').' '.$page['title'].'">'.(int)$page['comments']." ".$this->_t('Comments_all')." &raquo; "."</a></footer>\n";
			echo "</article>\n";

			unset ($_category);
		}

		$this->print_pagination($pagination);
	}
	else
	{
		echo '<br /><br />'.$this->_t('NewsNotAvailable');
	}

	if ($access)
	{
		echo $this->form_open('add_topic');
		?>
		<br /><a id="newtopic"></a><br />
				<table class="formation">
			<tr>
				<td class="label"><label for="posttitle"><?php echo $this->_t('ForumTopicName'); ?>:</label></td>
				<td>
					<input type="text" id="posttitle" name="title" size="50" maxlength="250" value="" />
					<input type="submit" id="submit" value="<?php echo $this->_t('ForumTopicSubmit'); ?>" />
				</td>
			</tr>
		</table>

		<?php #echo $this->_t('NewsName'); ?>
		<?php echo $this->form_close();
	}

	echo "</section>\n";
}
else
{
	echo $this->_t('NewsNoClusterDefined');
}
