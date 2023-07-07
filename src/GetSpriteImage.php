<?php

namespace App;

use GdImage;

class GetSpriteImage
{
    public static function get(string $path): GdImage
    {
        return imagecreatefrompng($path);
    }

    public static function getSpriteWithColor(string $icon, string $color): GdImage
    {
        $image = self::get($icon);
        $imageColor = str_replace('#', '', $color);
        $imageColor = str_split($imageColor, 2);
        foreach ($imageColor as &$c) {
            $c = 255 - hexdec($c);
        }
        imagefilter($image, IMG_FILTER_NEGATE);
        imagefilter($image, IMG_FILTER_COLORIZE, $imageColor[0], $imageColor[1], $imageColor[2], 0);
        imagefilter($image, IMG_FILTER_NEGATE);
        return $image;
    }

    public static function getHair(string $icon, string $color, int $dir = 0): GdImage
    {
        $path = PathEnums::FACIAL->value."/$icon-$dir.png";
        return self::getSpriteWithColor($path, $color);
    }

    public static function getFacialHair(string $icon, string $color, int $dir = 0): GdImage
    {
        $path = PathEnums::FACIAL->value."/facial_$icon-$dir.png";
        return self::getSpriteWithColor($path, $color);
    }

    public static function getEyeWear(string $icon, int $dir): GdImage
    {
        return self::get(PathEnums::EYEWEAR->value."/$icon-$dir.png");
    }

    public static function getMask(string $icon, int $dir): GdImage
    {
        return self::get(PathEnums::MASK->value."/$icon-$dir.png");
    }

    public static function getUniform(string $icon, int $dir): GdImage
    {
        return self::get(PathEnums::UNIFORM->value."/$icon-$dir.png");
    }

    public static function getSuit(string $icon, int $dir): GdImage
    {
        return self::get(PathEnums::SUIT->value."/$icon-$dir.png");
    }

    public static function getBelt(string $icon, int $dir): GdImage
    {
        return self::get(PathEnums::BELT->value."/$icon-$dir.png");
    }

    public static function getHead(string $icon, int $dir): GdImage
    {
        return self::get(PathEnums::HEAD->value."/$icon-$dir.png");
    }

    public static function getGloves(string $icon, int $dir): GdImage
    {
        return self::get(PathEnums::GLOVES->value."/$icon-$dir.png");
    }

    public static function getShoes(string $icon, int $dir): GdImage
    {
        return self::get(PathEnums::SHOES->value."/$icon-$dir.png");
    }

}
