<?php

if (!defined('IN_WACKO'))
{
	exit;
}

// chose your favorite style (e.g. stackoverflow-dark.min.css)
$hljs_css		= 'default.min.css';

// local
$hljs_styles	= $this->db->base_path . 'js/highlight.js/' . $hljs_css;
$hljs_script	= $this->db->base_path . 'js/highlight.js/highlight.min.js';

// CDN (see Highlight.js README.md)
#$hljs_styles	= 'https://cdn.jsdelivr.net/gh/highlightjs/cdn-release@11.7.0/build/styles/' . $hljs_css;
#$hljs_script	= 'https://cdn.jsdelivr.net/gh/highlightjs/cdn-release@11.7.0/build/es/highlight.min.js';

// highlight.js
$this->add_html('header', '<link rel="stylesheet" href="' . $hljs_styles .  '">');
$this->add_html('footer', '<script src="' . $hljs_script . '"></script>');
$this->add_html('footer', '<script>hljs.highlightAll();</script>');