<?php

namespace App;

enum PathEnums: string
{
    case HUMAN = OUTPUT_DIR."/mob/species/human/bodyparts_greyscale";
    case FACIAL = OUTPUT_DIR."/mob/species/human/human_face";
    case EYEWEAR = OUTPUT_DIR."/mob/clothing/eyes";
    case MASK = OUTPUT_DIR."/mob/clothing/mask";
    case UNIFORM = OUTPUT_DIR."/mob/clothing/under";
    case SUIT = OUTPUT_DIR."/mob/clothing/suits";
    case BELT = OUTPUT_DIR."/mob/clothing/belt";
    case HEAD = OUTPUT_DIR."/mob/clothing/head";
    case GLOVES = OUTPUT_DIR."/mob/clothing/hands";
    case SHOES = OUTPUT_DIR."/mob/clothing/feet";
}
