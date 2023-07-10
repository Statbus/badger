<?php

namespace App;

enum IdCardStateEnums: string
{
    case DEFAULT = 'card_grey';
    case GOLD = 'card_gold';
    case SILVER = 'card_silver';
    case RAINBOW = 'card_rainbow';
    case PRISONER = 'card_prisoner';

}
