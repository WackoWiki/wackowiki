<?php

if (!defined('IN_WACKO'))
{
	exit;
}

// highlight.js
$this->add_html('header', '<link rel="stylesheet" href="' . $this->db->base_path . 'js/highlight.js/github-dark.min.css' . '">');
$this->add_html('header', '<script src="' . $this->db->base_path . 'js/highlight.js/highlight.min.js' . '"></script>');
$this->add_html('header', '<script>hljs.highlightAll();</script>');