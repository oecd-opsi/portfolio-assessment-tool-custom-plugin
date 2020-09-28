# Portfolio Assessment Tool custom plugin #

A WordPress plugin to make Portfolio Assessment Tool works on OECD OPSI website.

## Installation ##

1. Click on the `Download ZIP` button at the right to download the plugin.
2. Go to Plugins > Add New in your WordPress admin. Click on `Upload Plugin` and browse for the zip file.
3. Activate the plugin.

## Usage ##

1. Connect to your server using a FTP client and navigate to the plugin directory.
2. Upload the files you want to use/load in the corresponding directories inside the `assets` directory.
3. Edit `plugin.php` and use the commented sample code as an example to add enqueue or other site-specific code. While there you may also want to edit the plugin's header with your name, plugin and author URLs etc.

## Notes ##
Insert in wp-config.php
// Define wp-mPDF constant
define( '_MPDF_TTFONTDATAPATH', WP_CONTENT_DIR.'/wp-mpdf-themes/ttfonts/' );
define( '_MPDF_TTFONTPATH', WP_CONTENT_DIR.'/wp-mpdf-themes/ttfonts/' );
define( '_MPDF_SYSTEM_TTFONTS_CONFIG', WP_CONTENT_DIR.'/wp-mpdf-themes/ttfonts/config_fonts.php' );
-- -- -- -- -- -- -- -- -- -- -- --
Use with wp-mpdf and the custom wp-mpdf-themes directory

## Changelog ##

### 1.0.0 ###
* Initial Release
