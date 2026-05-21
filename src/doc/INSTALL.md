
# WackoWiki Installation

## Recommended Installation Method

1. Go to the [WackoWiki Releases page](https://github.com/WackoWiki/wackowiki/releases)
2. Download the latest **full distribution archive**:
   - `wackowiki-x.y.z.zip`  (recommended for most users)
   - or `wackowiki-x.y.z.tar.gz`
3. Unpack the archive into a directory accessible via the web (e.g. `wacko/`).
4. Open that directory in your browser (e.g. `https://www.example.com/wacko/`).
5. Follow the web-based installer.

> **Note**: The release archives include all required dependencies (`vendor/` folder), so you don't need to run Composer.

## Installing from Source (Git)

If you prefer to install from Git:

```bash
git clone https://github.com/WackoWiki/wackowiki.git wacko
cd wacko/src
php composer.phar install --no-dev --optimize-autoloader
```

Or if you have Composer installed globally:

```bash
cd wacko/src
composer install --no-dev --optimize-autoloader
```

## Manual Setup after Unpacking
After unpacking (or cloning) the files:

### Permissions:

For configuration purposes, you'll probably want to make `config/config.php` writable
by the web server, at least temporarily.

Please make sure the following subdirectories are writable, since this is where the files are stored.

Adjust the file permissions according to the permission group you're in.

  `chmod 0755 _cache/config/ _cache/feed/ _cache/page/ _cache/query/ _cache/session/ _cache/template/ file/backup/ file/data/ file/global/ file/perpage/ file/thumb/ file/thumb_local/ xml/`
  `chmod 666 config/config.php config/lock config/lock_ap`

Reset file permissions of the config file after installation.

  `chmod 644 config/config.php`


Check if the provided path for `CACHE_SESSION_DIR` in `config/constants.php` is correct.

  The default value set in `constants.php` is `/tmp` but may vary in your environment.
  You may want to change this to a custom folder (e.g. `_cache/session` or `/var/tmp`)


Mandatory installer password protection
  It is imperative to set the password for the installer in the `config/lock_setup` file.


### Important Notes

- WackoWiki distributions (release archives) normally include the version in the folder name. Rename it to `wacko` or create a symbolic link.
- The `vendor/` directory is **not** present when downloading the green "Code → Download ZIP" button from GitHub. Always use the **Releases** page for the full package.
- Composer is only required if you install from Git or want to manage dependencies yourself.
- Detailed instructions and troubleshooting are available in the [official documentation](https://wackowiki.org/doc/Doc/English/Installation).


## Backend / Admin Setup

After installation:

- Log in as Administrator.
- Create a recovery password using the `{{admin_recovery}}` action.
- Add the generated hash to `config/config.php` under `'recovery_password'`.
- Clear the configuration cache using `{{admincache}}`.
