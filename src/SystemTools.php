<?php

namespace App;

class SystemTools
{
    public static function ensurePublicJsonDirectory()
    {
        if(!is_dir(OUTPUT_DIR."/../json")) {
            mkdir(OUTPUT_DIR."/../json");
        }
    }

}
