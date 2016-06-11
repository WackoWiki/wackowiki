<?php

if (!defined('IN_WACKO'))
{
	exit;
}

// {{blog [page=cluster] [mode=latest|week|from] [date=YYYY-MM-DD] [max=Number] [title=1] [noxml=1]}}

if (!isset($page))		$page = ''; // $this->unwrap_link(isset($vars['for']) ? $vars['for'] : '');
$access	= '';
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
	if ($max)			$limit = $max;
	if (!isset($limit))	$limit = 10;
	else				$limit = (int)$limit;

	$pages			= '';
	$prefix			= $this->config['table_prefix'];
	#$blog_cluster		= $blog_cluster;
	$blog_levels		= $this->config['news_levels'];

	// hide article H1 header
	$this->config['hide_article_header'] = true;

	// check privilege
	if ($this->has_access('create') === true)
	{
		$access = true;
	}

	if ((isset($_POST['action'])) && $_POST['action'] == 'newsadd' && $access === true)
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
				$error = $this->get_translation('NewsNoName');
			}
		}
		else
		{
			$error = $this->get_translation('NewsNoName');
		}

		// if errors were found - return, else continue
		if ($error)
		{
			$this->set_message($error, 'error');
			$this->redirect($this->href());
		}
		else
		{
			// building news template
			$template	= '';

			// redirecting to the edit form
			$_SESSION['body']	= $template;
			$_SESSION['title']	= $namehead;

			if ($this->config['enable_feeds'])
			{
				#$_SESSION['feed']	= true;
			}

			// needs to be numeric for ordering
			// TODO: add this as config option to Admin panel
			// .date('Y/')							- 2011
			// .date('Y/').date('m/')				- 2011/07 (default)
			// .date('Y/').date('m/').date('d/')	- 2011/07/14
			// .date('Y/').date('W/')				- 2011/29
			$blog_cluster_structure = date('Y/').date('m/');

			$this->redirect($this->href('edit', $blog_cluster.'/'.$blog_cluster_structure.$name, '', 1));
		}
	}
	// collect data
	// heavy lifting here (watch out for REGEXPs!)
	if ($mode == 'latest')
	{
		$count	= $this->load_single(
			"SELECT COUNT(tag) AS n ".
			"FROM {$prefix}page ".
			"WHERE tag REGEXP '^{$blog_cluster}{$blog_levels}$' ".
				"AND comment_on_id = '0'".
				"AND deleted <> '1' ", true);

		$pagination = $this->pagination($count['n'], $limit, 'p', 'mode=latest');

		$pages	= $this->load_all(
			"SELECT p.page_id, p.owner_id, p.user_id, p.tag, p.title, p.created, p.comments, u.user_name AS owner ".
			"FROM {$prefix}page p ".
				"INNER JOIN {$prefix}user u ON (p.owner_id = u.user_id) ".
			"WHERE p.comment_on_id = '0' ".
				"AND p.tag REGEXP '^{$blog_cluster}{$blog_levels}$' ".
				"AND p.deleted <> '1' ".
			"ORDER BY p.created DESC ".
			"LIMIT {$pagination['offset']}, $limit", true);
	}
	else if ($mode == 'category')
	{
		$count	= $this->load_single(
			"SELECT COUNT(p.tag) AS n ".
			"FROM {$prefix}category_page c ".
			"INNER JOIN {$prefix}page p ON (c.page_id = p.page_id) ".
			"WHERE p.tag REGEXP '^{$blog_cluster}{$blog_levels}$' ".
				"AND c.category_id = '$category_id' ".
				"AND p.deleted <> '1' ".
				"AND p.comment_on_id = '0'", true);

		$pagination = $this->pagination($count['n'], $limit, 'p', 'category='.$category_id);

		$category_title	= $this->load_single(
			"SELECT category ".
			"FROM {$prefix}category ".
			"WHERE category_id = '$category_id' ", false);

		$pages	= $this->load_all(
			"SELECT p.page_id, p.owner_id, p.user_id, p.tag, p.title, p.created, p.comments, u.user_name AS owner ".
			"FROM {$prefix}page p ".
				"INNER JOIN {$prefix}user u ON (p.owner_id = u.user_id) ".
				"INNER JOIN {$prefix}category_page c  ON (c.page_id = p.page_id) ".
			"WHERE p.comment_on_id = '0' ".
				"AND p.tag REGEXP '^{$blog_cluster}{$blog_levels}$' ".
				"AND p.deleted <> '1' ".
				"AND c.category_id = '$category_id' ".
			"ORDER BY p.created DESC ".
			"LIMIT {$pagination['offset']}, $limit", true);
	}
	else if ($mode == 'week')
	{
		$count	= $this->load_single(
			"SELECT COUNT(tag) AS n ".
			"FROM {$prefix}page ".
			"WHERE tag REGEXP '^{$blog_cluster}{$blog_levels}$' ".
				"AND deleted <> '1' ".
				"AND created > DATE_SUB( NOW(), INTERVAL 7 DAY ) ".
				"AND comment_on_id = '0'", true);

		$pagination = $this->pagination($count['n'], $limit, 'p', 'mode=week');

		$pages	= $this->load_all(
			"SELECT p.page_id, p.owner_id, p.user_id, p.tag, p.title, p.created, p.comments, u.user_name AS owner ".
			"FROM {$prefix}page p ".
				"INNER JOIN {$prefix}user u ON (p.owner_id = u.user_id) ".
			"WHERE p.comment_on_id = '0' ".
				"AND p.tag REGEXP '^{$blog_cluster}{$blog_levels}$' ".
				"AND p.deleted <> '1' ".
				"AND p.created > DATE_SUB( NOW(), INTERVAL 7 DAY ) ".
			"ORDER BY p.created DESC ".
			"LIMIT {$pagination['offset']}, $limit", true);
	}
	else if ($mode == 'from' && $date)
	{
		$count	= $this->load_single(
			"SELECT COUNT(tag) AS n ".
			"FROM {$prefix}page ".
			"WHERE tag REGEXP '^{$blog_cluster}{$blog_levels}$' ".
				"AND deleted <> '1' ".
				"AND created > '$date' ".
				"AND comment_on_id = '0'", true);

		$pagination = $this->pagination($count['n'], $limit, 'p', 'mode=week');

		$date	= date("Y-m-d H:i:s", strtotime($date));
		$pages	= $this->load_all(
			"SELECT p.page_id, p.owner_id, p.user_id, p.tag, p.title, p.created, p.comments, u.user_name AS owner ".
			"FROM {$prefix}page p ".
				"INNER JOIN {$prefix}user u ON (p.owner_id = u.user_id) ".
			"WHERE p.comment_on_id = '0' ".
				"AND p.tag REGEXP '^{$blog_cluster}{$blog_levels}$' ".
				"AND p.deleted <> '1' ".
				"AND p.created > '$date' ".
			"ORDER BY p.created DESC ".
			"LIMIT {$pagination['offset']}, $limit", true);
	}

	// start output
	echo '<section class="news">';

	if ($title == 1)
	{
		if (isset($category_title))
		{
			$_category_title = ' '.$this->get_translation('For').' '.$this->get_translation('Category').' &laquo;'.$category_title['category'].'&raquo;';
		}
		else
		{
			$_category_title = '';
		}

		if ($this->page['tag'] == $blog_cluster)
		{
			$_title = $this->get_translation('News').$_category_title;
		}
		else
		{
			$_title = $this->compose_link_to_page($blog_cluster, '', $this->get_translation('News'), 0).$_category_title;
		}

		echo "<h1>".$_title."</h1>";
	}

	// displaying XML icon
	if (!(int)$noxml)
	{
		if ($this->config['news_cluster'])
		{
			if (substr($this->tag, 0, strlen($this->config['news_cluster'].'/')) == $this->config['news_cluster'].'/')
			{
				$feed_tag = 'news';
			}
		}
		else
		{
			$feed_tag = 'blog'.$this->page['page_id'];
		}

		echo '<span class="desc_rss_feed"><a href="'.$this->config['base_url'].'xml/'.$feed_tag.'_'.preg_replace('/[^a-zA-Z0-9]/', '', strtolower($this->config['site_name'])).'.xml"><img src="'.$this->config['theme_url'].'icon/spacer.png'.'" title="'.$this->get_translation('RecentNewsXMLTip').'" alt="XML" class="btn-feed"/></a></span>'."\n";
	}

	$show_pagination = $this->show_pagination(isset($pagination['text']) ? $pagination['text'] : '');

	echo '<div style="width:100%;">
			<p style="float: left">'.($access === true ? '<strong><small class="cite"><a href="#newtopic">'.$this->get_translation('ForumNewTopic').'</a></small></strong>' : '').'</p>'.
			$show_pagination.'<br style="clear:both" />
		</div>'."\n";

	// pagination
	#echo $show_pagination;

	// displaying articles
	if ($pages)
	{
		foreach ($pages as $page)
		{
			$_category = $this->get_categories($page['page_id']);
			$_category = !empty($_category) ? $this->get_translation('Category').': '.$_category.' | ' : '';

			echo '<article class="newsarticle">';
			echo '<h2 class="newstitle"><a href="'.$this->href('', $page['tag'], '').'">'.$page['title']."</a></h2>\n";
			echo '<div class="newsinfo"><span><time datetime="'.$this->page['created'].'">'.$this->get_time_formatted($page['created']).'</time> '.$this->get_translation('By').' '.$this->user_link($page['owner'], $lang = '', true, false)."</span></div>\n";
			echo '<div class="newscontent">'.$this->action('include', array('page' => '/'.$page['tag'], 'notoc' => 0, 'nomark' => 1), 1)."</div>\n";
			echo '<footer class="newsmeta">'.$_category." ".($this->has_access('write', $page['page_id']) ? $this->compose_link_to_page($page['tag'], 'edit', $this->get_translation('EditText'), 0)." | " : "")."  ".
				'<a href="'.$this->href('', $page['tag'], 'show_comments=1').'#header-comments" title="'.$this->get_translation('NewsDiscuss').' '.$page['title'].'">'.(int)$page['comments']." ".$this->get_translation('Comments_all')." &raquo; "."</a></footer>\n";
			echo "</article>\n";

			unset ($_category);
		}

		// pagination
		echo $show_pagination;
	}
	else
	{
		echo '<br /><br />'.$this->get_translation('NewsNotAvailable');
	}

	if ($access === true)
	{
		echo $this->form_open('add_topic');
		?>
		<br /><a id="newtopic"></a><br />
				<table class="formation">
			<tr>
				<td class="label"><label for="posttitle"><?php echo $this->get_translation('ForumTopicName'); ?>:</label></td>
				<td>
					<input type="hidden" name="action" value="newsadd" />
					<input type="text" id="posttitle" name="title" size="50" maxlength="100" value="" />
					<input type="submit" id="submit" value="<?php echo $this->get_translation('ForumTopicSubmit'); ?>" />
				</td>
			</tr>
		</table>

		<?php #echo $this->get_translation('NewsName'); ?>
		<?php echo $this->form_close();
	}

	echo "</section>\n";
}
else
{
	echo $this->get_translation('NewsNoClusterDefined');
}

// end output

?>