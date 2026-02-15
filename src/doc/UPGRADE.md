
# Upgrading from an earlier version:

Just unpack the new distribution archive wherever you need/want it; all you need from
your old WackoWiki installation is config.php and the file folder. You can also just
copy the new files over the old ones, but be careful not to overwrite your old
`config.php` or any customizations you may have applied to the source files.

Once the files are in place, browse to your WackoWiki. The update script should show
up automatically.

Mandatory installer password protection
  It is imperative to set the password for the installer in the `config/lock_setup` file.

More details on https://wackowiki.org/doc/Doc/English/Upgrade
