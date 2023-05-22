<?php

if (!defined('IN_WACKO'))
{
	exit;
}

if ($this->get_user_name())
{
	$mode_selector	= 'mode';
	$mode			= @$_GET[$mode_selector];

	// navigation
	$tabs	= [
		''					=> 'UsersPages',
		'mychanges'			=> 'UsersChanges',
		'mywatches'			=> 'UsersSubscription',
		'mychangeswatches'	=> 'UsersWatches',
	];

	if (!array_key_exists($mode, $tabs))
	{
		$mode = '';
	}

	echo $this->tab_menu($tabs, $mode, '', [], $mode_selector);

	// [0] - tab heading
	// [1] - action
	$action = [
		''					=>	['ListMyPages',
								'mypages'
		],
		'mychanges'			=>	['ListMyChanges',
								'mychanges'
		],
		'mywatches'			=>	['ListMyWatches',
								'mywatches'
		],
		'mychangeswatches'	=>	['ListMyChangesWatches',
								'mychangeswatches'
		],
	];

	echo '<h3>' . $this->_t($action[$mode][0]) . '</h3>';

	echo $this->action($action[$mode][1]);

}
else
{
	echo $this->_t('NotLoggedInThusOwned');
}
