<form action="<?php echo my_location() ?>?installAction=version-check" method="post">
<?php

write_config_hidden_nodes(array(
	'language' => 0,
	'is_update' => '')
);

// Check if Upgrade or Fresh Install
if(array_key_exists('wacko_version', $config))
{
	if ($config['wacko_version'][0] < 5)
	{
		echo '<ul class="security"><li>'.preg_replace(array('/%1/', '/%2/'), array($config['wacko_version'], WACKO_VERSION), $lang['PleaseUpgradeToR5'])."</li></ul>\n";
	}
	else
	{
		$config['is_update'] = '1';
		echo '<p>'.preg_replace(array('/%1/', '/%2/'), array($config['wacko_version'], WACKO_VERSION), $lang['UpgradeFromWacko'])."</p>\n";
		echo '<p>'.$lang['PleaseBackup']."</p>\n";
	}
}
else
{
	$config['is_update'] = '0';
	echo '<p>'.str_replace('%1', WACKO_VERSION, $lang['FreshInstall'])."</p>\n";
}

echo '<input type="hidden" value="'.$config['is_update'].'" name="config[is_update]">';

?>
	<p><?php echo $lang['LangDesc'];?></p>
<?php
// http://en.wikipedia.org/wiki/List_of_ISO_639-1_codes
$lang_codes = array();
$lang_codes['bg'] = '&#1041;&#1098;&#1083;&#1075;&#1072;&#1088;&#1089;&#1082;&#1080;';
$lang_codes['da'] = 'Dansk';
$lang_codes['de'] = 'Deutsch';
$lang_codes['et'] = 'Eesti';
$lang_codes['en'] = 'English';
$lang_codes['el'] = '&Epsilon;&lambda;&lambda;&eta;&nu;&iota;&kappa;&#940;';
$lang_codes['es'] = 'Espa&ntilde;ol';
$lang_codes['fr'] = 'Fran&#231;ais';
$lang_codes['it'] = 'Italiano';
$lang_codes['nl'] = 'Nederlands';
$lang_codes['pl'] = 'Polski';
$lang_codes['ru'] = '&#1056;&#1091;&#1089;&#1089;&#1082;&#1080;&#1081;';

foreach($lang_codes as $key => $value)
{
	echo "   <input type=\"radio\" id=\"lang_".$key."\" name=\"config[language]\" value=\"".$key."\"";

	// Default or Selected Language
	if ( isset ( $_POST['config']['language'] ) )
	{
		if ( $_POST['config']['language'] == $key )
		{
			echo " checked=\"checked\" ";
		}
	}
	else if ( $config['language'] == $key )
	{
		echo " checked=\"checked\" ";
	}

	echo " onClick=\"this.form.action='?installAction=lang'; submit(); \"";
	echo " class=\"input_lang\"><label for=\"lang_".$key."\" class=\"label_lang\">".$value." (".$key.")</label><br />\n";
}

if (!empty($config['is_update']))
{
?>
	<input type="submit" value="<?php echo $lang['Continue'];?>" class="next" />
<?php
}?>
</form>