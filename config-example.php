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

define('DEFAULT_SPRITE', '[{"name":"dir","value":"0"},{"name":"gender","value":"male"},{"name":"eyeColor","value":"#6aa84f"},{"name":"skinTone","value":"latino"},{"name":"bg","value":"default"},{"name":"text3","value":""},{"name":"text1","value":""},{"name":"text2","value":""},{"name":"hairStyle","value":""},{"name":"hairColor","value":"#994500"},{"name":"facial","value":""},{"name":"facialColor","value":"#000000"},{"name":"eyeWear","value":""},{"name":"mask","value":""},{"name":"uniform","value":""},{"name":"suit","value":""},{"name":"head","value":""},{"name":"belt","value":""},{"name":"gloves","value":""},{"name":"shoes","value":""}]');
