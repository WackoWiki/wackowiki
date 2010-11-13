<?php

// {{news [mode=latest|week|from] [date=YYYY-MM-DD] [max=Number] [title=1] [noxml=1]}}

if (!empty($this->config['news_cluster']))
{
	if (!isset($max))	$max = '';
	if (isset($_GET['category']))
	{
		$mode = 'category';
		$category_id = $_GET['category'];
	}
	if (!isset($mode))	$mode = 'latest';
	if (!isset($title))	$title = 1;
	if (!isset($noxml))	$noxml = 0;
	if ($max)			$limit = $max;
	if (!isset($limit))	$limit = 10;
	else				$limit = (int)$limit;

	$pages = '';
	$prefix			= $this->config['table_prefix'];
	$newscluster	= $this->config['news_cluster'];
	$newslevels		= $this->config['news_levels'];

	// collect data
	// heavy lifting here (watch out for REGEXPs!)
	if ($mode == 'latest')
	{
		$count	= $this->load_single(
				"SELECT COUNT(tag) AS n ".
				"FROM {$prefix}page ".
				"WHERE tag REGEXP '^{$newscluster}{$newslevels}$' ".
					"AND comment_on_id = '0'", 1);

		$pagination = $this->pagination($count['n'], $limit, 'p', 'mode=latest');

		$pages	= $this->load_all(
			"SELECT p.page_id, p.owner_id, p.user_id, p.tag, p.title, p.created, p.comments, u.user_name AS  owner ".
			"FROM {$prefix}page p ".
				"INNER JOIN {$prefix}user u ON (p.owner_id = u.user_id) ".
			"WHERE p.comment_on_id = '0' ".
				"AND p.tag REGEXP '^{$newscluster}{$newslevels}$' ".
			"ORDER BY p.created DESC ".
			"LIMIT {$pagination['offset']}, $limit", 1);
	}
	else if ($mode == 'category')
	{
		$count	= $this->load_single(
			"SELECT COUNT(p.tag) AS n ".
			"FROM {$prefix}category_page c ".
			"INNER JOIN {$prefix}page p ON (c.page_id = p.page_id) ".
			"WHERE p.tag REGEXP '^{$newscluster}{$newslevels}$' ".
				"AND c.category_id = '$category_id' ".
				"AND p.comment_on_id = '0'", 1);

		$pagination = $this->pagination($count['n'], $limit, 'p', 'mode=week');

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
				"AND p.tag REGEXP '^{$newscluster}{$newslevels}$' ".
				"AND c.category_id = '$category_id' ".
			"ORDER BY p.created DESC ".
			"LIMIT {$pagination['offset']}, $limit", 1);
	}
	else if ($mode == 'week')
	{
		$count	= $this->load_single(
			"SELECT COUNT(tag) AS n ".
			"FROM {$prefix}page ".
			"WHERE tag REGEXP '^{$newscluster}{$newslevels}$' ".
				"AND created > DATE_SUB( NOW(), INTERVAL 7 DAY ) ".
				"AND comment_on_id = '0'", 1);

		$pagination = $this->pagination($count['n'], $limit, 'p', 'mode=week');

		$pages	= $this->load_all(
			"SELECT p.page_id, p.owner_id, p.user_id, p.tag, p.title, p.created, p.comments, u.user_name AS owner ".
			"FROM {$prefix}page p ".
				"INNER JOIN {$prefix}user u ON (p.owner_id = u.user_id) ".
			"WHERE p.comment_on_id = '0' ".
				"AND p.tag REGEXP '^{$newscluster}{$newslevels}$' ".
				"AND p.created > DATE_SUB( NOW(), INTERVAL 7 DAY ) ".
			"ORDER BY p.created DESC ".
			"LIMIT {$pagination['offset']}, $limit", 1);
	}
	else if ($mode == 'from' && $date)
	{
		$count	= $this->load_single(
			"SELECT COUNT(tag) AS n ".
			"FROM {$prefix}page ".
			"WHERE tag REGEXP '^{$newscluster}{$newslevels}$' ".
				"AND created > '$date' ".
				"AND comment_on_id = '0'", 1);

		$pagination = $this->pagination($count['n'], $limit, 'p', 'mode=week');

		$date	= date("Y-m-d H:i:s", strtotime($date));
		$pages	= $this->load_all(
			"SELECT p.page_id, p.owner_id, p.user_id, p.tag, p.title, p.created, p.comments, u.user_name AS owner ".
			"FROM {$prefix}page p ".
				"INNER JOIN {$prefix}user u ON (p.owner_id = u.user_id) ".
			"WHERE p.comment_on_id = '0' ".
				"AND p.tag REGEXP '^{$newscluster}{$newslevels}$' ".
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
		if ($this->page['tag'] == $this->config['news_cluster'])
		{
			$_title = $this->get_translation('News').$_category_title;
		}
		else
		{
			$_title = $this->compose_link_to_page($this->config['news_cluster'], '', $this->get_translation('News'), 0).$_category_title;
		}

		echo "<h1>".$_title."</h1>";
	}

	// displaying XML icon
	if (!(int)$noxml)
	{
		echo "<span class=\"desc_rss_feed\"><a href=\"".$this->config['base_url']."xml/news_".preg_replace('/[^a-zA-Z0-9]/', '', strtolower($this->config['wacko_name'])).".xml\"><img src=\"".$this->config['theme_url']."icons/xml.gif"."\" title=\"".$this->get_translation('RecentNewsXMLTip')."\" alt=\"XML\" /></a></span>\n";
	}

	// displaying articles
	if ($pages)
	{
		// pagination
		if (isset($pagination['text']))
		{
			echo "<br /><span class=\"pagination\">{$pagination['text']}</span>\n";
		}

		foreach ($pages as $page)
		{
			$_category = '';

			$categories	= $this->load_all(
				"SELECT
					c.category_id, c.category
				FROM
					{$prefix}category_page p
				INNER JOIN {$prefix}category c ON (p.category_id = c.category_id)
				WHERE
					p.page_id = '{$page['page_id']}'", 0);

			foreach ($categories as $id => $category)
			{
				if ($id > 0)
				{
					$_category .= ', ';
				}

				$_category .= '<a href="'.$this->href('', '', 'category='.$category['category_id']).'">' .htmlspecialchars($category['category']).'</a>';
			}
			$_category = !empty($_category) ? $this->get_translation('Category').': '.$_category.' | ' : '';

			echo "<div class=\"newsarticle\">";
			echo '<h2 class="newstitle"><a href="'.$this->href('', $page['tag'], '').'">'.$page['title']."</a></h2>\n";
			echo "<div class=\"newsinfo\"><span>".$this->get_time_string_formatted($page['created']).' '.$this->get_translation('By').' '.( $page['owner'] == '' ? '<em>'.$this->get_translation('Guest').'</em>' : '<a href="'.$this->href('', $this->config['users_page'], 'profile='.$page['owner']).'">'.$page['owner'].'</a>' )."</span></div>\n";
			echo "<div class=\"newscontent\">".$this->action('include', array('page' => '/'.$page['tag'], 'notoc' => 0, 'nomark' => 1), 1)."</div>\n";
			echo "<div class=\"newsmeta\">".$_category." ".($this->has_access('write', $page['page_id']) ? $this->compose_link_to_page($page['tag'], 'edit', $this->get_translation('EditText'), 0)." | " : "")."  ".
				'<a href="'.$this->href('', $page['tag'], 'show_comments=1').'#comments" title="'.$this->get_translation('NewsDiscuss').' '.$page['title'].'">'.(int)$page['comments']." ".$this->get_translation('Comments_all')." &raquo; "."</a></div>\n";
			echo "</div>";

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
		echo "<br /><br />".$this->get_translation('NewsNotAvailable');
	}
	echo "</div>";
}
else
{
	echo $this->get_translation('NewsNoClusterDefined');
}

// end output

?>