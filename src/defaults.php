<?php

define("BIO_RESOURCES", __DIR__.'/../public/resources/bio/');
define("ICON_PATH", __DIR__.'/../public/icons');
define("CONSOLAS_FONT", BIO_RESOURCES.'/cascadia.otf');

$mugshot_offset_x = 10;
$mugshot_offset_y = 13;

$pixelxoffset = 0;
$pixelyoffset = 0;


$colorableSpecies = ["lizard","pod","jelly","slime","golem","ethereal","digitrade"];

$defaults = [
    'species' => 'human',
    'gender' => 'male',
    'dir' => 0,
    'bg' => 'default',
    'text1' => "Employee of Nanotrasen",
    'text2' => "A. Spaceman",
    'text3' => "Bottom Text",
    'skinTone' => 'latino',
    'eyeColor' => '#6AA84F',
    'hairColor' => '#000000',
    'hairStyle' => null,
    'facial' => null,
    'facialColor' => '#000000',
    'eyeWear' => null,
    'mask' => null,
    'uniform' => null,
    'suit' => null,
    'belt' => null,
    'head' => null,
    'gloves' => null,
    'shoes' => null
];
