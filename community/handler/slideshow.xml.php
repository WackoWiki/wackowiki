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
	$this->http->redirect($this->href());
}

if ($this->has_access('read'))
{
	// TODO: define more options for splitting the page body, e.g. smallest splitting header
	// split the page
	$this->context[++$this->current_context] = $this->page['tag'];

	#$body_f	= $this->format($this->page['body'], 'wiki', ['post_wacko' => true]);
	$body_f	= $this->format($this->page['body'], 'wordprocessor');

	$this->context[$this->current_context] = '~~'; // clean stack
	$this->current_context--;

	$body	= preg_split('#(<h[2-6] .*?>.*?</h[2-6]>)#u', $body_f, -1, PREG_SPLIT_DELIM_CAPTURE);

	#Ut::debug_print_r($body);

	if (!$body)
	{
		return;
	}
	else
	{
		// first slide starts with a level 1 heading
		if (preg_match('#^<h[2-6] .*?>.*?</h[2-6]>#u', $body[0]))
		{
			$first_slide = 0;
		}
		else
		{
			$first_slide = 1;
		}

		// If you do not specify a parameter, it defaults to the first slide
		$slide = (int) (($_GET['slide'] ?? 1) ?: 1);

		// HTTP header with right Charset settings
		header('Content-Type: text/html; charset=' . $this->get_charset());
		header_remove('X-Powered-By');

		$tpl->lang		= $this->page_lang;
		$tpl->dir		= $this->languages[$this->page_lang]['dir'];
		$tpl->charset	= $this->get_charset();
		$tpl->method	= $this->method;
		!Ut::is_empty($tpl->title = @$this->page['title']) || $tpl->tag = $this->add_spaces($this->tag);
		$tpl->favicon	= $this->get_favicon();

		#if (!file_exists($this->db->theme_url . 'css/slideshow.css'))
		#{
			#$tpl->css	= false;
		#}
		#else
		#{
			#$this->add_html('header', '<link rel="stylesheet" href="' . $this->db->theme_url . 'css/slideshow.css">');
		#}

		// current slide
		$c_slide = ($slide * 2) - ($first_slide * 2);

		// display navigation menu
		if (!$first_slide
			&& preg_match('#<h\d id=\"h\d+-(\d+)\" class=\"heading\">#', $body[$c_slide - 1], $match))
		{
			$section = ['section' => $match[1]];
		}

		$tpl->nav_href = $this->href('edit', '', $section ?? []);

		// If this is not the first slide, we display links "<< previous" and "[start]"
		if ($slide !== 1)
		{
			$tpl->nav_p_hrefprev	= $this->href('slideshow.xml', '', 'slide=' . ($slide - 1));
			$tpl->nav_p_hrefstart	= $this->href('slideshow.xml', '', 'slide=1');
		}

		if (isset($body[$c_slide + 2]) || $slide == 1)
		{
			$tpl->nav_n_hrefnext	=	$this->href('slideshow.xml', '', 'slide='.($slide + 1));
		}

		// first slide
		if ($slide == 1 && $first_slide == 1)
		{
			$tpl->body =
				'<h1>' . $this->page['title'] . '</h1>' . "\n" .
				$body[0];
		}
		// other slides (header + section)
		else
		{
			$tpl->body =
				$body[$c_slide - 1] .
				$body[$c_slide];
		}
	}
}
else
{
	$this->http->redirect($this->href());
}
