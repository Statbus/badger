<?php

session_start();
define('DME_DIR', '/tg');
define('DME', DME_DIR."/tgstation.dme");
define('ICON_DIR', DME_DIR."/icons");

define('OUTPUT_DIR', '/usr/src/myapp/public/icons');
define('PASSWORD', '123');
if (!defined('PASSWORD')) {
    define('PASSWORD', false);
}
