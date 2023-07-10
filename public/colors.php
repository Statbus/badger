<?php

use App\GitRevision;
use App\SystemTools;

require_once(__DIR__."/../vendor/autoload.php");
require_once(__DIR__."/../config.php");
?>
<style>
    body {
        display: flex;
        flex-wrap: wrap;
        box-sizing: border-box;
        padding: 0;
        margin: 0;
    }
    *{font-family:Verdana, Geneva, Tahoma, sans-serif; font-size: 14px;}
    .color {
        width: 25%;
        height: 25%;
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
    }
    h1 {
        flex-grow: 1;
        width: 100%;
        padding: 10px 20px;
        color: green;
        background-color: black;
        font-size: 2rem;
        margin: 0;
    }
    h2 {
        flex-grow: 1;
        width: 100%;
        padding: 10px 20px;
        color: green;
        background-color: black;
        font-size: 1rem;
        margin: 0; 
    }
    .select {
        user-select: all;
    }
    .big {
        display: block;
        font-size: 2rem;
        padding: 10px 0 0 0;
    }
</style>
<h1>Statbus Presents: Colors defined in code/__DEFINES/colors.dm</h1>
<h2>As of <?php echo GitRevision::getString();?> (non-hex colors excluded)</h2>
<?php

if(file_exists(__DIR__."/json/colors.json")) {
    $colors = json_decode(file_get_contents(__DIR__."/json/colors.json"), true);
    foreach ($colors as $name => $color) {
        if(str_starts_with($color, '#')) {
            echo "<div class='color' style='background:$color; color:".SystemTools::getContrastColor($color)."'><span><span class='select'>$name</span><br><span class='select big'>$color</span></span></div>";
        }
    }
} else {
    echo "<div class='color' style='background:black; color:white'><span class='select'>colors.json does not exist!</span></div>";
}
