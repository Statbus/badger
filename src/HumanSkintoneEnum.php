<?php

namespace App;

enum HumanSkintoneEnum: string
{
    case caucasian1  =   '#ffe0d1';
    case caucasian2  =   '#fcccb3';
    case caucasian3  =   '#e8b59b';
    case latino      =   '#d9ae96';
    case mediterranean = '#c79b8b';
    case asian1      =   '#ffdeb3';
    case asian2      =   '#e3ba84';
    case arab        =   '#c4915e';
    case indian      =   '#b87840';
    case african1    =   '#754523';
    case african2    =   '#471c18';
    case albino      =   '#fff4e6';
    case orange      =   '#ffc905';

    public static function fromName(string $name)
    {

        return constant("self::$name");
    }
}
