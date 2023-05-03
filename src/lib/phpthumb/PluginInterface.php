<?php

namespace PHPThumb;

interface PluginInterface
{
	public function execute(PHPThumb $phpthumb): PHPThumb;
}
