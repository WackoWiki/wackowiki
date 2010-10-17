<?php
## MENU FUNCTION ##
if (!function_exists('mainMenu'))
{
    function mainMenu ($wobj)
    {

        /* == Edit your main menu here ====================================== */

        $menu = array(
                    /* 'WikiSiteLink or URL' => 'Name' */ // you can put those WikiSites and Names to your translation file for i18n
                    $wobj->config['root_page'] => $wobj->config['root_page'],
                    'PageIndex' => 'Page Index',
                    'RecentChanges' => 'Recent Changes'
                );

        /* == Stop here! ... and let it flow ================================ */

	    $language = $wobj->config['language'];
	    $base_url = $wobj->config['base_url'];
        $current_page = $wobj->tag;

        $menulist = null;

        foreach($menu as $menutarget => $menuname)
        {
            $t_menutarget = $wobj->get_translation($menutarget);
            if ($t_menutarget) $menutarget = $t_menutarget;
            if (!(strpos($menutarget, 'http://') === 0 ||
                strpos($menutarget, 'https://') === 0 ||
                strpos($menutarget, 'mailto:') === 0))
            {
                $menutarget = $base_url.$menutarget;
            }

            $t_menuname = $wobj->get_translation($menuname);
            if ($t_menuname) $menuname = $t_menuname;

            $link = '<li><a href="'.$menutarget.'">'.$menuname.'</a></li>';

            // check active path
            if (strpos($base_url.$current_page, $menutarget) !== false)
                $link = str_replace('<li>', '<li class="active">', $link);

            $menulist .= $link.PHP_EOL;
        }

	    echo $menulist;
    }
}

?>
