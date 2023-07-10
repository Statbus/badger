<?php

use App\GitRevision;

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
<h2>As of <?php echo GitRevision::getString();?></h2>
<?php

function getContrastColor($hexColor)
{
    // hexColor RGB
    $R1 = hexdec(substr($hexColor, 1, 2));
    $G1 = hexdec(substr($hexColor, 3, 2));
    $B1 = hexdec(substr($hexColor, 5, 2));

    // Black RGB
    $blackColor = "#000000";
    $R2BlackColor = hexdec(substr($blackColor, 1, 2));
    $G2BlackColor = hexdec(substr($blackColor, 3, 2));
    $B2BlackColor = hexdec(substr($blackColor, 5, 2));

    // Calc contrast ratio
    $L1 = 0.2126 * pow($R1 / 255, 2.2) +
          0.7152 * pow($G1 / 255, 2.2) +
          0.0722 * pow($B1 / 255, 2.2);

    $L2 = 0.2126 * pow($R2BlackColor / 255, 2.2) +
          0.7152 * pow($G2BlackColor / 255, 2.2) +
          0.0722 * pow($B2BlackColor / 255, 2.2);

    $contrastRatio = 0;
    if ($L1 > $L2) {
        $contrastRatio = (int)(($L1 + 0.05) / ($L2 + 0.05));
    } else {
        $contrastRatio = (int)(($L2 + 0.05) / ($L1 + 0.05));
    }

    // If contrast is more than 5, return black color
    if ($contrastRatio > 5) {
        return '#000000';
    } else {
        // if not, return white color.
        return '#FFFFFF';
    }
}

// Will return '#FFFFFF'

if(file_exists(__DIR__."/json/colors.json")) {
    $colors = json_decode(file_get_contents(__DIR__."/json/colors.json"), true);
    foreach ($colors as $name => $color) {
        if(str_starts_with($color, '#')) {
            echo "<div class='color' style='background:$color; color:".getContrastColor($color)."'><span><span class='select'>$name</span><br><span class='select big'>$color</span></span></div>";
        }
    }
} else {
    echo "<div class='color' style='background:black; color:white'><span class='select'>colors.json does not exist!</span></div>";
}
