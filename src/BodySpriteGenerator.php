<?php

namespace App;

use App\PathEnums;

class BodySpriteGenerator
{
    public static function getSprites(object $data): array
    {
        switch($data->species) {
            case 'human':
            default:
                return self::getSpritesForHuman($data->gender, $data->dir);
                break;
        }
    }

    public static function getSpritesForHuman(
        string $gender = "male",
        int $dir = 0
    ): array {

        $path = PathEnums::HUMAN->value;

        $sprites = [
            "rArm"=> "$path/human_r_arm-$dir.png",
            "lArm"=> "$path/human_l_arm-$dir.png",
            "lLeg"=> "$path/human_l_leg-$dir.png",
            "rLeg"=> "$path/human_r_leg-$dir.png",
            "rHand"=>"$path/human_r_hand-$dir.png",
            "lHand"=>"$path/human_l_hand-$dir.png",
        ];
        if ($gender == 'male') {
            $sprites["head"] =  "$path/human_head_m-$dir.png";
            $sprites["chest"] = "$path/human_chest_m-$dir.png";
        } else {
            $sprites["head"]  = "$path/human_head_f-$dir.png";
            $sprites["chest"] = "$path/human_chest_f-$dir.png";
        }
        return $sprites;
    }

}
