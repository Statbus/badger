<?php

use App\BodySpriteGenerator;
use App\HumanSkintoneEnum;
use App\GetSpriteImage;

require_once(__DIR__ . "/../config.php");
require_once(__DIR__ . "/../vendor/autoload.php");
require_once(__DIR__ . "/../src/defaults.php");

//Merge our data with data from the user
$data = (object) array_merge($defaults, $_POST);

//Start with the base image, a 32x32 transparent png
$body = imagecreatetruecolor(32, 32);
imagesavealpha($body, true);
$alpha = imagecolorallocatealpha($body, 0, 0, 0, 127);
imagefill($body, 0, 0, $alpha);

//Get the sprites we ned for the body
$sprites = BodySpriteGenerator::getSprites($data);

//Get the image, copy it to the body, destroy the temporary image
foreach ($sprites as $position => $sprite) {
    $img = imagecreatefrompng($sprite);
    imagecopy($body, $img, 0, 0, 0, 0, 32, 32);
    imagedestroy($img);
}

//Get skintone (or color if the species doesn't use skintones)
if ('human' === $data->species) {
    $skinTone = (string) HumanSkintoneEnum::fromName($data->skinTone)->value;
} else {
    $skinTone = $data->skinColor;
}
$skinTone = str_replace('#', '', $skinTone);
$skinTone = str_split($skinTone, 2);
foreach ($skinTone as &$c) {
    $c = 255 - hexdec($c);
}

//Apply the skincolor
imagefilter($body, IMG_FILTER_NEGATE);
if (in_array($data->species, $colorableSpecies)) {
    imagefilter($body, IMG_FILTER_COLORIZE, $skinTone[0], $skinTone[1], $skinTone[2], 50);
}
imagefilter($body, IMG_FILTER_NEGATE);

//Eyecolor
$eyeColor = str_replace('#', '', $data->eyeColor);
$eyeColor = str_split($eyeColor, 2);
foreach ($eyeColor as &$c) {
    $c = hexdec($c);
}
$eyeColor = imagecolorallocate($body, $eyeColor[0], $eyeColor[1], $eyeColor[2]);
switch ($data->dir) {
    case '0':
    default:
        imagefilledrectangle($body, 14, 6, 14, 6, $eyeColor); //Left
        imagefilledrectangle($body, 16, 6, 16, 6, $eyeColor); //Right
        break;

    case '1':
        // imagefilledrectangle($body, 14, 6, 14, 6, $eyeColor);//Left
        // imagefilledrectangle($body, 16, 6, 16, 6, $eyeColor);//Right
        break;

    case '2':
        imagefilledrectangle($body, 18, 6, 18, 6, $eyeColor);
        break;

    case '3':
        imagefilledrectangle($body, 13, 6, 13, 6, $eyeColor);
        break;
}

//Hair
if ($data->hairStyle) {
    $hair = GetSpriteImage::getHair($data->hairStyle, $data->hairColor, $data->dir);
    if (null != $hair) {
        imagecopy($body, $hair, 0, 0, 0, 0, 32, 32);
    }
    imagedestroy($hair);
}
//Facial hair
if ('human' === $data->species && $data->facial) {
    $facial = GetSpriteImage::getFacialHair($data->facial, $data->facialColor, $data->dir);
    if (null != $facial) {
        imagecopy($body, $facial, 0, 0, 0, 0, 32, 32);
    }
    imagedestroy($facial);
}

if ($data->eyeWear) {
    $eyeWear = GetSpriteImage::getEyeWear($data->eyeWear, $data->dir);
    if (null != $eyeWear) {
        imagecopy($body, $eyeWear, 0, 0, 0, 0, 32, 32);
    }
    imagedestroy($eyeWear);
}

if ($data->mask) {
    $mask = GetSpriteImage::getMask($data->mask, $data->dir);
    if (null != $mask) {
        imagecopy($body, $mask, 0, 0, 0, 0, 32, 32);
    }
    imagedestroy($mask);
}

if ($data->uniform) {
    $uniform = GetSpriteImage::getUniform($data->uniform, $data->dir);
    if (null != $uniform) {
        imagecopy($body, $uniform, 0, 0, 0, 0, 32, 32);
    }
    imagedestroy($uniform);
}

if ($data->suit) {
    $suit = GetSpriteImage::getSuit($data->suit, $data->dir);
    if (null != $suit) {
        imagecopy($body, $suit, 0, 0, 0, 0, 32, 32);
    }
    imagedestroy($suit);
}

if ($data->belt) {
    $belt = GetSpriteImage::getBelt($data->belt, $data->dir);
    if (null != $belt) {
        imagecopy($body, $belt, 0, 0, 0, 0, 32, 32);
    }
    imagedestroy($belt);
}

if ($data->head) {
    $head = GetSpriteImage::getHead($data->head, $data->dir);
    if (null != $head) {
        imagecopy($body, $head, 0, 0, 0, 0, 32, 32);
    }
    imagedestroy($head);
}

if ($data->gloves) {
    $gloves = GetSpriteImage::getGloves($data->gloves, $data->dir);
    if (null != $gloves) {
        imagecopy($body, $gloves, 0, 0, 0, 0, 32, 32);
    }
    imagedestroy($gloves);
}

if ($data->shoes) {
    $shoes = GetSpriteImage::getShoes($data->shoes, $data->dir);
    if (null != $shoes) {
        imagecopy($body, $shoes, 0, 0, 0, 0, 32, 32);
    }
    imagedestroy($shoes);
}

//Create the corporate ID image
$corp = @imagecreatefrompng(BIO_RESOURCES . "/bg/$data->bg.png");
@imagesavealpha($corp, true);
//Get text colors for the corporate ID
$useborder = false;
switch ($data->bg) {
    case 'default':
    default:
        $bg = BIO_RESOURCES . "/bg/$data->bg.png";
        $text_color_title = imagecolorallocate($corp, 0x3b, 0x3b, 0x3b);
        $text_color_title_b = imagecolorallocate($corp, 0x93, 0x93, 0x93);
        $text_color1 = imagecolorallocate($corp, 0x3b, 0x3b, 0x3b);
        $text_color1_b = imagecolorallocate($corp, 0x93, 0x93, 0x93);
        $text_color2 = imagecolorallocate($corp, 0x93, 0x93, 0x93);
        $text_color2_b = imagecolorallocate($corp, 0x3b, 0x3b, 0x3b);
        $useborder = 1;
        break;

    case 'head':
        $bg = BIO_RESOURCES . "/bg/$data->bg.png";
        $text_color_title = imagecolorallocate($corp, 0xf5, 0xce, 0x68);
        $text_color_title_b = imagecolorallocate($corp, 0x93, 0x93, 0x93);
        $text_color1 = imagecolorallocate($corp, 0xf5, 0xce, 0x68);
        $text_color1_b = imagecolorallocate($corp, 0x93, 0x93, 0x93);
        $text_color2 = imagecolorallocate($corp, 0x93, 0x93, 0x93);
        $text_color2_b = imagecolorallocate($corp, 0x3b, 0x3b, 0x3b);
        $useborder = 1;
        break;

    case 'centcom':
        $bg = BIO_RESOURCES . "/bg/$data->bg.png";
        $text_color_title = imagecolorallocate($corp, 0x5d, 0x00, 0x00);
        $text_color_title_b = imagecolorallocate($corp, 0x93, 0x93, 0x93);
        $text_color1 = imagecolorallocate($corp, 0x5d, 0x00, 0x00);
        $text_color1_b = imagecolorallocate($corp, 0x93, 0x93, 0x93);
        $text_color2 = imagecolorallocate($corp, 0x93, 0x93, 0x93);
        $text_color2_b = imagecolorallocate($corp, 0x3b, 0x3b, 0x3b);
        $useborder = 1;
        break;

    case 'ocean':
        $bg = BIO_RESOURCES . "/bg/$data->bg.png";
        $text_color_title = imagecolorallocate($corp, 0xb7, 0xba, 0xce);
        $text_color1 = imagecolorallocate($corp, 0xc8, 0xca, 0xd9);
        $text_color2 = imagecolorallocate($corp, 0xb7, 0xba, 0xce);
        break;

    case 'lava':
        $bg = BIO_RESOURCES . "/bg/$data->bg.png";
        $text_color_title = imagecolorallocate($corp, 0xC4, 0xDF, 0xE1);
        $text_color1 = imagecolorallocate($corp, 0xFF, 0xFF, 0xFF);
        $text_color2 = imagecolorallocate($corp, 0xC4, 0xDF, 0xE1);
        break;

    case 'old':
        $bg = BIO_RESOURCES . "/bg/$data->bg.png";
        $text_color_title = imagecolorallocate($corp, 0xC4, 0xDF, 0xE1);
        $text_color1 = imagecolorallocate($corp, 0xFF, 0xFF, 0xFF);
        $text_color2 = imagecolorallocate($corp, 0xC4, 0xDF, 0xE1);
        break;

    case 'ice':
        $bg = BIO_RESOURCES . "/bg/$data->bg.png";
        $text_color_title = imagecolorallocate($corp, 0x3e, 0x46, 0x7a);
        $text_color1 = imagecolorallocate($corp, 0x59, 0x64, 0xab);
        $text_color2 = imagecolorallocate($corp, 0x3e, 0x46, 0x7a);
        break;

    case 'captain':
        $bg = BIO_RESOURCES . "/bg/$data->bg.png";
        $text_color_title = imagecolorallocate($corp, 0x4a, 0x38, 0x00);
        $text_color1 = imagecolorallocate($corp, 0x4a, 0x38, 0x00);
        $text_color2 = imagecolorallocate($corp, 0x6a, 0x55, 0x00);
        $data->text1 = strtoupper($data->text1);
        break;
}

//Create a corporate ID card from one of the backgrounds
$corp = @imagecreatefrompng($bg);
@imagesavealpha($corp, true);

//Set the corproate ID mugshot background
$mughostbgcolor = imagecolorallocate($corp, 0xB0, 0xB0, 0xB0);
imagefilledrectangle($corp, $mugshot_offset_x + $pixelxoffset, $mugshot_offset_y + $pixelyoffset - 3, $mugshot_offset_x + $pixelxoffset + 45 - 1, $mugshot_offset_y + $pixelyoffset + 42 - 1, $mughostbgcolor);

//Stick the body into the corporate ID's mugshot box
imagecopyresized($corp, $body, 10, 13, 8, 0, 45, 42, 15, 14);

//CARD TEXT
$str_employee_size = 11;
$line1size = 15;
$line2size = 9;
$str_employee_x = 183;
$line1x = 183;
$line2x = 183;
$str_employee_y = 20;
$line1y = 40;
$line2y = 54;

$font = 4;
$height = imagefontheight($font);

$string1 = $data->text1;
$string2 = $data->text2;

$size1 = ImageTTFBBox($line1size, 0, CONSOLAS_FONT, $string1);
while ($size1[2] > 200) {
    $line1size -= 1;
    $size1 = ImageTTFBBox($line1size, 0, CONSOLAS_FONT, $string1);
}

$size2 = ImageTTFBBox($line2size, 0, CONSOLAS_FONT, $string2);
while ($size2[2] > 200) {
    $line2size -= 1;
    $size2 = ImageTTFBBox($line2size, 0, CONSOLAS_FONT, $string2);
}

$title = $data->text3;
$sizetitle = ImageTTFBBox($str_employee_size, 0, CONSOLAS_FONT, $title);
if ($useborder == 1) {
    imagettftext($corp, $str_employee_size, 0, $str_employee_x - floor($sizetitle[2] / 2) - 1, $str_employee_y - 1, $text_color_title_b, CONSOLAS_FONT, $title);
    imagettftext($corp, $str_employee_size, 0, $str_employee_x - floor($sizetitle[2] / 2) - 1, $str_employee_y + 1, $text_color_title_b, CONSOLAS_FONT, $title);
    imagettftext($corp, $str_employee_size, 0, $str_employee_x - floor($sizetitle[2] / 2) + 1, $str_employee_y - 1, $text_color_title_b, CONSOLAS_FONT, $title);
    imagettftext($corp, $str_employee_size, 0, $str_employee_x - floor($sizetitle[2] / 2) + 1, $str_employee_y + 1, $text_color_title_b, CONSOLAS_FONT, $title);
}
imagettftext($corp, $str_employee_size, 0, $str_employee_x - floor($sizetitle[2] / 2), $str_employee_y, $text_color_title, CONSOLAS_FONT, $title);
if ($useborder == 1) {
    imagettftext($corp, $line1size, 0, $line1x - floor($size1[2] / 2) - 1, $line1y - 1, $text_color1_b, CONSOLAS_FONT, $string1);
    imagettftext($corp, $line1size, 0, $line1x - floor($size1[2] / 2) - 1, $line1y + 1, $text_color1_b, CONSOLAS_FONT, $string1);
    imagettftext($corp, $line1size, 0, $line1x - floor($size1[2] / 2) + 1, $line1y - 1, $text_color1_b, CONSOLAS_FONT, $string1);
    imagettftext($corp, $line1size, 0, $line1x - floor($size1[2] / 2) + 1, $line1y + 1, $text_color1_b, CONSOLAS_FONT, $string1);
}
imagettftext($corp, $line1size, 0, $line1x - floor($size1[2] / 2), $line1y, $text_color1, CONSOLAS_FONT, $string1);
if ($useborder == 1) {
    imagettftext($corp, $line2size, 0, $line2x - floor($size2[2] / 2) - 1, $line2y - 1, $text_color2_b, CONSOLAS_FONT, $string2);
    imagettftext($corp, $line2size, 0, $line2x - floor($size2[2] / 2) - 1, $line2y + 1, $text_color2_b, CONSOLAS_FONT, $string2);
    imagettftext($corp, $line2size, 0, $line2x - floor($size2[2] / 2) + 1, $line2y - 1, $text_color2_b, CONSOLAS_FONT, $string2);
    imagettftext($corp, $line2size, 0, $line2x - floor($size2[2] / 2) + 1, $line2y + 1, $text_color2_b, CONSOLAS_FONT, $string2);
}
imagettftext($corp, $line2size, 0, $line2x - floor($size2[2] / 2), $line2y, $text_color2, CONSOLAS_FONT, $string2);

//Create a station ID card on a transparent background
$idcard = imagecreatetruecolor(32, 32);
imagesavealpha($body, true);
$alpha = imagecolorallocatealpha($idcard, 0, 0, 0, 127);
imagefill($idcard, 0, 0, $alpha);
$card = imagecreatefrompng(OUTPUT_DIR . "/obj/card/card_grey-0.png");
imagecopy($idcard, $card, 0, 0, 0, 0, 32, 32);
imagedestroy($card);

//Output corporate ID card
ob_start();
imagesavealpha($corp, true);
imagepng($corp, null, 9);
$payload['corp'] = base64_encode(ob_get_contents());
imagedestroy($corp);
ob_end_clean();

//Output station ID card
ob_start();
$idcard = imagescale($idcard, 128, 128, IMG_NEAREST_NEIGHBOUR);
imagesavealpha($idcard, true);
imagepng($idcard, null, 9);
$payload['card'] = base64_encode(ob_get_contents());
imagedestroy($idcard);
ob_end_clean();

//Output mugshot
ob_start();
$body = imagescale($body, 128, 128, IMG_NEAREST_NEIGHBOUR);
imagesavealpha($body, true);
imagepng($body, null, 9);
$payload['mugshot'] = base64_encode(ob_get_contents());
imagedestroy($body);
ob_end_clean();

header('Content-type', 'application/json');
echo json_encode($payload);
