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
	$blogcluster	= $blog_cluster;
	$bloglevels		= $this->config['news_levels'];

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
			$this->set_message('<div class="error">'.$error.'</div>');
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
				$_SESSION['feed']	= true;
			}

			// needs to be numeric for ordering
			// TODO: add this as config option to Admin panel
			// .date('Y/')							- 2011
			// .date('Y/').date('m/')				- 2011/07 (default)
			// .date('Y/').date('m/').date('d/')	- 2011/07/14
			// .date('Y/').date('W/')				- 2011/29
			$blog_cluster_structure = date('Y/').date('m/');

			$this->redirect($this->href('edit', $blogcluster.'/'.$blog_cluster_structure.$name, '', 1));
		}
	}
	// collect data
	// heavy lifting here (watch out for REGEXPs!)
	if ($mode == 'latest')
	{
		$count	= $this->load_single(
			"SELECT COUNT(tag) AS n ".
			"FROM {$prefix}page ".
			"WHERE tag REGEXP '^{$blogcluster}{$bloglevels}$' ".
				"AND comment_on_id = '0'", 1);

		$pagination = $this->pagination($count['n'], $limit, 'p', 'mode=latest');

		$pages	= $this->load_all(
			"SELECT p.page_id, p.owner_id, p.user_id, p.tag, p.title, p.created, p.comments, u.user_name AS  owner ".
			"FROM {$prefix}page p ".
				"INNER JOIN {$prefix}user u ON (p.owner_id = u.user_id) ".
			"WHERE p.comment_on_id = '0' ".
				"AND p.tag REGEXP '^{$blogcluster}{$bloglevels}$' ".
			"ORDER BY p.created DESC ".
			"LIMIT {$pagination['offset']}, $limit", 1);
	}
	else if ($mode == 'category')
	{
		$count	= $this->load_single(
			"SELECT COUNT(p.tag) AS n ".
			"FROM {$prefix}category_page c ".
			"INNER JOIN {$prefix}page p ON (c.page_id = p.page_id) ".
			"WHERE p.tag REGEXP '^{$blogcluster}{$bloglevels}$' ".
				"AND c.category_id = '$category_id' ".
				"AND p.comment_on_id = '0'", 1);

		$pagination = $this->pagination($count['n'], $limit, 'p', 'category='.$category_id);

		$category_title	= $this->load_single(
			"SELECT category ".
			"FROM {$prefix}category ".
			"WHERE category_id = '$category_id' ", 0);

		$pages	= $this->load_all(
			"SELECT p.page_id, p.owner_id, p.user_id, p.tag, p.title, p.created, p.comments, u.user_name AS owner ".
			"FROM {$prefix}page p ".
				"INNER JOIN {$prefix}user u ON (p.owner_id = u.user_id) ".
				"INNER JOIN {$prefix}category_page c  ON (c.page_id = p.page_id) ".
			"WHERE p.comment_on_id = '0' ".
				"AND p.tag REGEXP '^{$blogcluster}{$bloglevels}$' ".
				"AND c.category_id = '$category_id' ".
			"ORDER BY p.created DESC ".
			"LIMIT {$pagination['offset']}, $limit", 1);
	}
	else if ($mode == 'week')
	{
		$count	= $this->load_single(
			"SELECT COUNT(tag) AS n ".
			"FROM {$prefix}page ".
			"WHERE tag REGEXP '^{$blogcluster}{$bloglevels}$' ".
				"AND created > DATE_SUB( NOW(), INTERVAL 7 DAY ) ".
				"AND comment_on_id = '0'", 1);

		$pagination = $this->pagination($count['n'], $limit, 'p', 'mode=week');

		$pages	= $this->load_all(
			"SELECT p.page_id, p.owner_id, p.user_id, p.tag, p.title, p.created, p.comments, u.user_name AS owner ".
			"FROM {$prefix}page p ".
				"INNER JOIN {$prefix}user u ON (p.owner_id = u.user_id) ".
			"WHERE p.comment_on_id = '0' ".
				"AND p.tag REGEXP '^{$blogcluster}{$bloglevels}$' ".
				"AND p.created > DATE_SUB( NOW(), INTERVAL 7 DAY ) ".
			"ORDER BY p.created DESC ".
			"LIMIT {$pagination['offset']}, $limit", 1);
	}
	else if ($mode == 'from' && $date)
	{
		$count	= $this->load_single(
			"SELECT COUNT(tag) AS n ".
			"FROM {$prefix}page ".
			"WHERE tag REGEXP '^{$blogcluster}{$bloglevels}$' ".
				"AND created > '$date' ".
				"AND comment_on_id = '0'", 1);

		$pagination = $this->pagination($count['n'], $limit, 'p', 'mode=week');

		$date	= date("Y-m-d H:i:s", strtotime($date));
		$pages	= $this->load_all(
			"SELECT p.page_id, p.owner_id, p.user_id, p.tag, p.title, p.created, p.comments, u.user_name AS owner ".
			"FROM {$prefix}page p ".
				"INNER JOIN {$prefix}user u ON (p.owner_id = u.user_id) ".
			"WHERE p.comment_on_id = '0' ".
				"AND p.tag REGEXP '^{$blogcluster}{$bloglevels}$' ".
				"AND p.created > '$date' ".
			"ORDER BY p.created DESC ".
			"LIMIT {$pagination['offset']}, $limit", 1);
	}

	// start output
	echo "<div class=\"news\">";

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

		if ($this->page['tag'] == $blogcluster)
		{
			$_title = $this->get_translation('News').$_category_title;
		}
		else
		{
			$_title = $this->compose_link_to_page($blogcluster, '', $this->get_translation('News'), 0).$_category_title;
		}

		echo "<h1>".$_title."</h1>";
	}

	// displaying XML icon
	if (!(int)$noxml)
	{
		echo "<span class=\"desc_rss_feed\"><a href=\"".$this->config['base_url']."xml/news_".preg_replace('/[^a-zA-Z0-9]/', '', strtolower($this->config['site_name'])).".xml\"><img src=\"".$this->config['theme_url']."icons/xml.png"."\" title=\"".$this->get_translation('RecentNewsXMLTip')."\" alt=\"XML\" /></a></span>\n";
	}

	echo '<div style="width:100%;"><p style="float: left">'.($access === true ? '<strong><small class="cite"><a href="#newtopic">'.$this->get_translation('ForumNewTopic').'</a></small></strong>' : '').'</p>'.
			'<p style="float: right">'.(isset($pagination['text']) && $pagination['text'] == true ? '<small>'.$pagination['text'].'</small>' : '').'</p><br style="clear:both" /></div>'."\n";

	// pagination
	if (isset($pagination['text']))
	{
		#echo "<br /><span class=\"pagination\">{$pagination['text']}</span>\n";
	}

	// displaying articles
	if ($pages)
	{
		foreach ($pages as $page)
		{

			$_category = $this->get_categories($page['page_id']);
			$_category = !empty($_category) ? $this->get_translation('Category').': '.$_category.' | ' : '';

			echo "<article class=\"newsarticle\">";
			echo '<h2 class="newstitle"><a href="'.$this->href('', $page['tag'], '').'">'.$page['title']."</a></h2>\n";
			echo "<div class=\"newsinfo\"><span>".$this->get_time_string_formatted($page['created']).' '.$this->get_translation('By').' '.( $page['owner'] == '' ? '<em>'.$this->get_translation('Guest').'</em>' : '<a href="'.$this->href('', $this->config['users_page'], 'profile='.$page['owner']).'">'.$page['owner'].'</a>' )."</span></div>\n";
			echo "<div class=\"newscontent\">".$this->action('include', array('page' => '/'.$page['tag'], 'notoc' => 0, 'nomark' => 1), 1)."</div>\n";
			echo "<div class=\"newsmeta\">".$_category." ".($this->has_access('write', $page['page_id']) ? $this->compose_link_to_page($page['tag'], 'edit', $this->get_translation('EditText'), 0)." | " : "")."  ".
				'<a href="'.$this->href('', $page['tag'], 'show_comments=1').'#commentsheader" title="'.$this->get_translation('NewsDiscuss').' '.$page['title'].'">'.(int)$page['comments']." ".$this->get_translation('Comments_all')." &raquo; "."</a></div>\n";
			echo "</article>";

			unset ($_category);
		}
		// pagination
		if (isset($pagination['text']))
		{
			echo "<br /><span class=\"pagination\">{$pagination['text']}</span>\n";
		}
	}
	else
	{
		echo '<br /><br />'.$this->get_translation('NewsNotAvailable');
	}

	if ($access === true)
	{
		echo $this->form_open();
		?>
		<br /><a id="newtopic"></a><br />
				<table class="formation">
			<tr>
				<td class="label"><label for="posttitle"><?php echo $this->get_translation('ForumTopicName'); ?>:</label></td>
				<td>
					<input type="hidden" name="action" value="newsadd" />
					<input id="posttitle" name="title" size="50" maxlength="100" value="" />
					<input id="submit" type="submit" value="<?php echo $this->get_translation('ForumTopicSubmit'); ?>" />
				</td>
			</tr>
		</table>

		<?php #echo $this->get_translation('NewsName'); ?>
		<?php echo $this->form_close();
	}

	echo "</div>";
}
else
{
	echo $this->get_translation('NewsNoClusterDefined');
}

// end output

?>