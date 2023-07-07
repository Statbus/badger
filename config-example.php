<?php

session_start();
define('DME_DIR', '/usr/src/myapp/tg');
define('DME', DME_DIR."/tgstation.dme");
define('ICON_DIR', DME_DIR."/icons");

define('OUTPUT_DIR', '/usr/src/myapp/public/icons');
define('PASSWORD', '123');
if (!defined('PASSWORD')) {
    define('PASSWORD', false);
}

# You don't ned to edit anything below this line
require_once(__DIR__."/version.php");
define('VERSION', VERSION_MAJOR . '.' . VERSION_MINOR . '.' . VERSION_PATCH . VERSION_TAG);
