# Wacko Default Theme

Default is a theme (a.k.a. template) for WackoWiki.


## Download and Installation

* The `default` theme is part of the distribution package.

## Features

The theme has been designed for all options you got by the wacko markup. It
contains a small main navigation including the input field for the keyword
search. At the header you find the link to the login or registration page
or if logged in links to the user page, account settings and logout.

* RTL support

## Customization

First copy the theme to a new folder, e.g. `theme/default_customized`, to not accidentally
overwrite your changes during a update or rollback.

To alternate the HTML just edit `header.tpl` and `footer.tpl` at the `appearance/template/`
folder. To change colors/etc and typographical formatting you can edit
`default.css` and `wacko.css` at the `css/` folder.

You can add i18n features when you add those menu targets and their names to the
translation files which you find at `lang/` folder.

```PHP
<?php
$theme_translation = [
	'Eureka' => 'Εύρηκα',
];

```

The theme config file `theme.all.php` overrides the default values,
it enables you to set your own config-options as well as overwriting existing ones.

```PHP
// theme options ==============
$this->db->custom_menus				= 0;
$this->db->footer_inside			= 0;
$this->db->revisions_hide_cancel	= 1;
$this->db->site_desc				= 'New Theme for WackoWiki';
// ============================

$theme_translation = [
	'EditIcon' => '...',
	'' => '',
];
```

## Bugs, Features & Support

For bug reports and feature requests you can write to [Bugtracker](https://wackowiki.org/bugs/).

## License

The [Default Theme](https://wackowiki.org/doc/Dev/Themes/Default) is part of the WackoWiki package.
BSD licence.

Icons were taken from the [Breeze Icons](https://github.com/KDE/breeze-icons) set.
Icons are licensed under the LGPLv3.


