<?php

if (!defined('IN_WACKO'))
{
	exit;
}

if (!function_exists('load_referrers'))
{
	function load_referrers(&$wacko, $query = '', $limit = 50, $parameters = '')
	{
		$limit		= (int) $limit;
		$pagination	= '';

		// count referrers
		if ($count_referrers = $wacko->load_all($query));
		{
			if ($count_referrers)
			{
				$count		= count($count_referrers);
				#$wacko->debug_print_r($count);

				$pagination = $wacko->pagination($count, $limit, 'r', $parameters, 'referrers');

				$referrers = $wacko->load_all(
					$query.
					" LIMIT {$pagination['offset']}, {$limit}");

				return array($referrers, $pagination);
			}
		}
	}
}
?>
<div id="page">
<?php

// redirect to show method if page don't exists
if (!$this->page)
{
	$this->redirect($this->href());
}

// deny for comment
if ($this->page['comment_on_id'])
{
	$this->redirect($this->href('', $this->get_page_tag($this->page['comment_on_id']), 'show_comments=1')."#".$this->page['tag']);
}

$referrers	= '';
$perpage	= '';
$bytime		= '';
$url_maxlen = 80;
$spacer		= '&nbsp;&nbsp;&rarr;&nbsp;&nbsp;'; // ' . . . . . . . . . . . . . . . . '

if (!isset($max))		$max = null;

$max	= $this->get_list_count($max);

if ($user = $this->get_user())
{
	// navigation
	if (isset($_GET['global']))
	{
		echo "<h3>".$this->get_translation('ReferrersText')." &raquo; ".$this->get_translation('ViewReferrersGlobal')."</h3>";
		echo '<ul class="menu">
			<li><a href="'.$this->href('referrers').'">'.$this->get_translation('ViewReferrersPage').'</a></li>
			<li><a href="'.$this->href('referrers', '', 'perpage=1').'">'.$this->get_translation('ViewReferrersPerPage').'</a></li>
			<li><a href="'.$this->href('referrers', '', 'bytime=1').'">'.$this->get_translation('ViewReferrersByTime').'</a></li>
			<li class="active">'.$this->get_translation('ViewReferrersGlobal')."</li>
		</ul><br /><br />\n";
	}
	else if (isset($_GET['perpage']))
	{
		echo "<h3>".$this->get_translation('ReferrersText')." &raquo; ".$this->get_translation('ViewReferrersPerPage')."</h3>";
		echo '<ul class="menu">
			<li><a href="'.$this->href('referrers').'">'.$this->get_translation('ViewReferrersPage').'</a></li>
			<li class="active">'.$this->get_translation('ViewReferrersPerPage').'</li>
			<li><a href="'.$this->href('referrers', '', 'bytime=1').'">'.$this->get_translation('ViewReferrersByTime').'</a></li>
			<li><a href="'.$this->href('referrers', '', 'global=1').'">'.$this->get_translation('ViewReferrersGlobal')."</a></li>
		</ul><br /><br />\n";
	}
	else if (isset($_GET['bytime']))
	{
		echo "<h3>".$this->get_translation('ReferrersText')." &raquo; ".$this->get_translation('ViewReferrersByTime')."</h3>";
		echo '<ul class="menu">
			<li><a href="'.$this->href('referrers').'">'.$this->get_translation('ViewReferrersPage').'</a></li>
			<li><a href="'.$this->href('referrers', '', 'perpage=1').'">'.$this->get_translation('ViewReferrersPerPage').'</a></li>
			<li class="active">'.$this->get_translation('ViewReferrersByTime').'</li>
			<li><a href="'.$this->href('referrers', '', 'global=1').'">'.$this->get_translation('ViewReferrersGlobal')."</a></li>
		</ul><br /><br />\n";
	}
	else
	{
		echo "<h3>".$this->get_translation('ReferrersText')." &raquo; ".$this->get_translation('ViewReferrersPage')."</h3>";
		echo '<ul class="menu">
			<li class="active">'.$this->get_translation('ViewReferrersPage').'</li>
			<li><a href="'.$this->href('referrers', '', 'perpage=1').'">'. $this->get_translation('ViewReferrersPerPage').'</a></li>
			<li><a href="'.$this->href('referrers', '', 'bytime=1').'">'.$this->get_translation('ViewReferrersByTime').'</a></li>
			<li><a href="'.$this->href('referrers', '', 'global=1').'">'. $this->get_translation('ViewReferrersGlobal')."</a></li>
		</ul><br /><br />\n";
	}

	if ($global = isset($_GET['global']))
	{
		$parameters = '';
		$title		= str_replace('%1', $this->href('referrers_sites', '', 'global=1'),
			str_replace('%2',
			($this->config['referrers_purge_time']
			? ($this->config['referrers_purge_time'] == 1
				? $this->get_translation('Last24Hours')
				: str_replace('%1', $this->config['referrers_purge_time'], $this->get_translation('LastDays')))
			: ''),
			$this->get_translation('ExternalPagesGlobal')));

		$query = "SELECT count( r.referrer ) AS num
			FROM ".$this->config['table_prefix']."referrer r";

		$referrers	= $this->load_referrers();
	}
	else if ($perpage = isset($_GET['perpage']))
	{
		$parameters = 'perpage=1';
		$title		= str_replace('%1', $this->href('referrers_sites', '', $parameters),
			str_replace('%2',
			($this->config['referrers_purge_time']
			? ($this->config['referrers_purge_time'] == 1
				? $this->get_translation('Last24Hours')
				: str_replace('%1', $this->config['referrers_purge_time'], $this->get_translation('LastDays')))
			: ''),
			$this->get_translation('ExternalPagesGlobal')));

		$query = "SELECT r.page_id, count( r.referrer ) AS num, p.tag, p.title, p.page_lang
			FROM ".$this->config['table_prefix']."referrer r
			LEFT JOIN ".$this->config['table_prefix']."page p ON ( p.page_id = r.page_id )
			GROUP BY r.page_id
			ORDER BY num DESC";
	}
	else if ($bytime = isset($_GET['bytime']))
	{
		$parameters = 'bytime=1';
		$title		= str_replace('%1', $this->href('referrers_sites', '', $parameters),
						str_replace('%2',
						($this->config['referrers_purge_time']
								? ($this->config['referrers_purge_time'] == 1
										? $this->get_translation('Last24Hours')
										: str_replace('%1', $this->config['referrers_purge_time'], $this->get_translation('LastDays')))
								: ''),
						$this->get_translation('ExternalPagesGlobal')));

		$query = "SELECT r.page_id, r.referrer_time, r.referrer, p.tag, p.title, p.page_lang
			FROM ".$this->config['table_prefix']."referrer r
			LEFT JOIN ".$this->config['table_prefix']."page p ON ( p.page_id = r.page_id )
			ORDER BY r.referrer_time DESC";
	}
	else
	{
		$title		= $this->get_translation('ReferringPages').":";
		echo '<strong>'.$title."</strong><br /><br />\n";

		// show backlinks
		if ($pages = $this->load_pages_linking_to($this->tag))
		{
			echo '<ol>'."\n";

			$anchor = $this->translit($this->tag);

			foreach ($pages as $page)
			{
				if ($page['tag'])
				{
					if ($this->config['hide_locked'])
					{
						$access = $this->has_access('read',$page['page_id']);
					}
					else
					{
						$access = true;
					}

					if ($access)
					{
						// cache page_id for for has_access validation in link function
						$this->page_id_cache[$page['tag']] = $page['page_id'];

						echo '<li>'.$this->link('/'.$page['tag']."#a-".$anchor, '', $page['tag'], $page['title'])."</li>\n";
					}
				}
			}

			echo "</ol>\n<p></p>";
		}
		else
		{
			echo $this->get_translation('NoReferringPages')."<p></p>";
		}

		$parameters = '';
		$title		= str_replace('%1', $this->compose_link_to_page($this->tag),
			str_replace('%2',
			($this->config['referrers_purge_time']
			? ($this->config['referrers_purge_time'] == 1
				? $this->get_translation('Last24Hours')
				: str_replace('%1', $this->config['referrers_purge_time'], $this->get_translation('LastDays')))
			: ''),
			str_replace('%3', $this->href('referrers_sites'), $this->get_translation('ExternalPages'))));

		$referrers = $this->load_referrers($this->page['page_id']);
	}

	echo '<strong>'.$title."</strong><br /><br />\n";

	if (($referrers || $perpage || $bytime) && $this->config['enable_referrers'])
	{
		// per page
		if ($perpage && list ($pages, $pagination) = load_referrers($this, $query, (int)$max, $parameters))
		{
			$show_pagination = $this->show_pagination(isset($pagination['text']) ? $pagination['text'] : '');

			// pagination
			echo $show_pagination;

			echo '<ul class="ul_list">'."\n";

			foreach ($pages as $page)
			{
				if (isset($page['page_id']))
				{
					if ($page['page_id'] == 0)
					{
						$access = true; // 404er
					}
					else if ($this->config['hide_locked'])
					{
						$access = $this->has_access('read', $page['page_id']);
					}
					else
					{
						$access = true;
					}

					if ($access)
					{
						if ($page['page_id'] == 0)
						{
							$page_link = '404';
						}
						else
						{
							// check current page lang for different charset to do_unicode_entities() against
							// - page lang
							if ($this->page['page_lang'] != $page['page_lang'])
							{
								$_lang = $page['page_lang'];
							}
							else
							{
								$_lang = '';
							}

							// cache page_id for for has_access validation in link function
							$this->page_id_cache[$page['tag']] = $page['page_id'];

							#$page_link = $this->compose_link_to_page($page['tag']);
							$page_link = $this->link('/'.$page['tag'], '', $page['title'], '', '', '', $_lang, 0);
						}

						echo '<li><strong>'.$page_link.'</strong>'.' ('.$page['num'].')';
						$referrers = $this->load_referrers($page['page_id']);

						echo "<ul>\n";

						foreach ($referrers as $referrer)
						{
							// shorten url name if too long
							if (strlen($referrer['referrer']) > $url_maxlen)
							{
								$referrer_text = substr($referrer['referrer'], 0, 30).'[..]'.substr($referrer['referrer'], -20);
							}
							else
							{
								$referrer_text = $referrer['referrer'];
							}

							echo '<li class="lined">';
							echo '<span class="list_count">'.$referrer['num'].'</span> &nbsp; ';
							echo '<span class=""><a title="'.htmlspecialchars($referrer['referrer'], ENT_COMPAT | ENT_HTML401, HTML_ENTITIES_CHARSET).'" href="'.htmlspecialchars($referrer['referrer'], ENT_COMPAT | ENT_HTML401, HTML_ENTITIES_CHARSET).'" rel="nofollow noreferrer">'.htmlspecialchars($referrer_text, ENT_COMPAT | ENT_HTML401, HTML_ENTITIES_CHARSET).'</a></span >';
							echo "</li>\n";
						}

						unset($referrers);

						echo "</ul>\n<br /></li>\n";
					}
				}
			}

			echo "</ul>\n";

			// pagination
			echo $show_pagination;
		}
		// by time
		else if ($bytime && list ($referrers, $pagination) = load_referrers($this, $query, (int)$max, $parameters))
		{
			$show_pagination = $this->show_pagination(isset($pagination['text']) ? $pagination['text'] : '');

			// pagination
			echo $show_pagination;

			echo '<ul class="ul_list">'."\n";

			foreach ($referrers as $referrer)
			{
				if (isset($referrer['page_id']))
				{
					if ($page['page_id'] == 0)
					{
						$access = true; // 404er
					}
					else if ($this->config['hide_locked'])
					{
						$access = $this->has_access('read', $referrer['page_id']);
					}
					else
					{
						$access = true;
					}

					if ($access && ($count < $max))
					{

						$count++;

						// tz offset
						$time_tz = $this->get_time_tz( strtotime($referrer['referrer_time']) );
						$time_tz = date('Y-m-d H:i:s', $time_tz);

						// day header
						list($day, $time) = explode(' ', $time_tz);

						if (!isset($curday))
						{
							$curday = '';
						}

						if ($day != $curday)
						{
							if ($curday)
							{
								echo "</ul>\n<br /></li>\n";
							}

							echo "<li><b>".date($this->config['date_format'], strtotime($day))."</b>\n<ul>\n";
							$curday = $day;
						}

						if ($referrer['page_id'] == 0)
						{
							$page_link = '404';
						}
						else
						{
							// check current page lang for different charset to do_unicode_entities() against
							// - page lang
							if ($this->page['page_lang'] != $referrer['page_lang'])
							{
								$_lang = $referrer['page_lang'];
							}
							else
							{
								$_lang = '';
							}

							// cache page_id for for has_access validation in link function
							$this->page_id_cache[$referrer['tag']] = $referrer['page_id'];

							#$page_link = $this->compose_link_to_page($page['tag']);
							$page_link = $this->link('/'.$referrer['tag'], '', $referrer['title'], '', '', '', $_lang, 0);
						}

						// shorten url name if too long
						if (strlen($referrer['referrer']) > $url_maxlen)
						{
							$referrer_text = substr($referrer['referrer'], 0, 30).'[..]'.substr($referrer['referrer'], -20);
						}
						else
						{
							$referrer_text = $referrer['referrer'];
						}

						echo '<li class="lined">';
						echo '<span class="">'.date($this->config['time_format_seconds'], strtotime( $time )).'</span> &nbsp; ';
						echo '<span class=""><a title="'.htmlspecialchars($referrer['referrer'], ENT_COMPAT | ENT_HTML401, HTML_ENTITIES_CHARSET).'" href="'.htmlspecialchars($referrer['referrer'], ENT_COMPAT | ENT_HTML401, HTML_ENTITIES_CHARSET).'" rel="nofollow noreferrer">'.htmlspecialchars($referrer_text, ENT_COMPAT | ENT_HTML401, HTML_ENTITIES_CHARSET).'</a></span >';
						echo $spacer.'<small>'.$page_link.'</small>';
						echo "</li>\n";
					}
				}
			}

			unset($referrers);

			echo "</ul>\n";

			// pagination
			echo $show_pagination;
		}
		// global
		else
		{
			if ($referrers)
			{
				echo '<ul class="ul_list">'."\n";

				foreach ($referrers as $referrer)
				{
					// shorten url name if too long
					if (strlen($referrer['referrer']) > $url_maxlen)
					{
						$referrer_text = substr($referrer['referrer'], 0, 30).'[..]'.substr($referrer['referrer'], -20);
					}
					else
					{
						$referrer_text = $referrer['referrer'];
					}

					echo '<li class="lined">';
					echo '<span class="list_count">'.$referrer['num'].'</span>&nbsp;&nbsp;&nbsp;&nbsp;';
					echo '<a title="'.htmlspecialchars($referrer['referrer'], ENT_COMPAT | ENT_HTML401, HTML_ENTITIES_CHARSET).'" href="'.htmlspecialchars($referrer['referrer'], ENT_COMPAT | ENT_HTML401, HTML_ENTITIES_CHARSET).'" rel="nofollow noreferrer">'.htmlspecialchars($referrer_text, ENT_COMPAT | ENT_HTML401, HTML_ENTITIES_CHARSET).'</a>';
					echo "</li>\n";
				}

				echo "</ul>\n";
			}
			else
			{
				echo $this->get_translation('NoneReferrers')."<br /><br />\n";
			}
		}
	}
	else
	{
		echo $this->get_translation('NoneReferrers')."<br /><br />\n";
	}

}
else
{
	$message = $this->get_translation('ReadAccessDenied');
	$this->show_message($message, 'info');
}

?>
</div>