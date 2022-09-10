<?php
/*
Handler slideshow.xml
uses .xml.php because then it does not load the theme header and footer by default
*/

if (!defined('IN_WACKO'))
{
	exit;
}

// redirect to show method if page don't exists
if (!$this->page)
{
	$this->http->redirect($this->href('show'));
}

if ($this->has_access('read'))
{
	// TODO: define more options for splitting the page body
	// split the page
	$body_f	= $this->format($this->page['body_r'], 'post_wacko', ['strip_notypo' => true]);
	$body	= preg_split('/(<h2 .*>.*<\/h2>)/u', $body_f, -1, PREG_SPLIT_DELIM_CAPTURE);

	if (isset($_GET['debug']) && $_GET['debug'] == 1)
	{
		# echo "<div style=\"display: none\">\n";
		$tpl->debug =  Ut::debug_print_r($body);
		# echo "</div>\n\n";
	}

	// If the first slide starts with a level 1 heading
	if (preg_match('/^<h2 .*>.*<\/h2>/u', $body_f))
	{
		$first_slide = 0;
	}
	else
	{
		$first_slide = 1;
	}

	// we test all the parameters of the handler 'slideshow',
	// if there is none, this is the "slide = 1" parameter is invoked by default

	if (!$body)
	{
		return;
	}
	else
	{
		// If you do not specify a parameter, it defaults to the first slide
		if (!isset($_GET['slide']) || $_GET['slide'] == 1)
		{
			$slide = 1;
		}
		else
		{
			$slide = (int) ($_GET['slide'] ?? '');
		}

		// HTTP header with right Charset settings
		header('Content-Type: text/html; charset=' . $this->get_charset());
		header_remove('X-Powered-By');

		$tpl->lang		= $this->page_lang;
		$tpl->dir		= $this->languages[$this->page_lang]['dir'];
		$tpl->charset	= $this->get_charset();
		$tpl->method	= $this->method;
		!Ut::is_empty($tpl->title = @$this->page['title']) || $tpl->tag = $this->add_spaces($this->tag);
		$tpl->favicon	= $this->get_favicon();

		if (!file_exists($this->db->theme_url . 'css/slideshow.css'))
		{
			#$tpl->css	= false;
		}
		else
		{
			#echo '<link rel="stylesheet" href="'.$this->config['theme_url'].'css/slideshow.css">';
		}

		// display navigation menu

		// If this is not the first slide, we display links "<< previous" and "[start]"
		if ($slide !== 1)
		{
			$tpl->nav_p_hrefprev	= $this->href('slideshow.xml', '', 'slide=' . ($_GET['slide'] - 1));
			$tpl->nav_p_hrefstart	= $this->href('slideshow.xml', '', 'slide=1');
		}

		if (isset($body[($slide) * 2 - ($first_slide * 2) + 2]) || $slide == 1)
		{
			$tpl->nav_n_hrefnext	=	$this->href('slideshow.xml', '', 'slide='.($slide + 1));
		}

		// showing content

		// if this is the first slide
		if ($slide == 1 && $first_slide == 1)
		{
			$tpl->body = $body[0];
		}
		// from the second slide
		else
		{
			$tpl->body =  $body[($slide * 2) - ($first_slide * 2) - 1] . $body[($slide * 2) - ($first_slide * 2)];
		}
	}
}
else
{
	$message = $this->_t('ReadAccessDenied');
	$this->show_message($message, 'info');
}
