<?php

namespace App;

use App\IdCardStateEnums;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

class JobInfoGenerator
{
    public const JOBSFILE = OUTPUT_DIR."/../json/jobs.json";
    public const TRIMSFILE = OUTPUT_DIR."/../json/trims.json";
    public const JOBINFOFILE = OUTPUT_DIR."/../json/job_info.json";
    public const TITLESFILE = OUTPUT_DIR."/../json/titles.json";
    public const COLORSFILE = OUTPUT_DIR."/../json/colors.json";
    public const JOBICONSFILE = OUTPUT_DIR."/../json/job_icons.json";

    public static function checkForCache($regenerate = false): string
    {
        if(!file_exists(self::JOBSFILE) || $regenerate) {
            self::parseJobs();
            return "Cache generated!";
        } else {
            return "Data cached!";
        }
    }

    public static function parseJobs()
    {
        if(!is_dir(OUTPUT_DIR."/../json")) {
            mkdir(OUTPUT_DIR."/../json");
        }
        self::extractDefinesFromDmFile(DME_DIR."/code/__DEFINES/jobs.dm", self::TITLESFILE);
        self::extractDefinesFromDmFile(DME_DIR."/code/__DEFINES/colors.dm", self::COLORSFILE);
        self::extractDefinesFromDmFile(DME_DIR."/code/__DEFINES/atom_hud.dm", self::JOBICONSFILE);
        self::parseTrims();
        self::parseJobFiles();
        self::mergeJson();
    }

    public static function parseTrims()
    {
        //Lines we're hunting for
        $lines = [
            // "assignment",
            "trim_state",
            "department_color",
            "subdepartment_color",
            "sechud_icon_state",
            "department_state"
        ];
        $job = null;
        $file = explode("\n", file_get_contents(DME_DIR."/code/datums/id_trim/jobs.dm"));
        foreach($file as $line) {
            $line = trim(rtrim($line));
            if(str_starts_with($line, 'assignment = "')) {
                $job = str_replace(['assignment = "','"'], '', $line);
                $jobs[$job] = [];
            }
            if($job) {
                foreach($lines as $l) {
                    if(str_starts_with($line, $l)) {
                        $jobs[$job][$l] = trim(rtrim(str_replace([$l,'"','='], '', $line)));
                    }
                }
            }
        }

        //echo "Writing trim data to json...";
        $json = fopen(self::TRIMSFILE, "w");
        fwrite($json, json_encode($jobs));
        fclose($json);
        //echo "Done!<br>";
    }

    public static function extractDefinesFromDmFile($path, $outFile)
    {
        $contents = file_get_contents($path);
        preg_match_all("/(#define) ([A-Z_]*) \"(.*)\"/", $contents, $matches);
        foreach($matches[2] as $k => $v) {
            $output[$v] = $matches[3][$k];
        }
        //echo "Writing defines from $path to json...";
        $file = fopen($outFile, "w");
        fwrite($file, json_encode($output));
        fclose($file);
        //echo "Done!<br>";
    }

    public static function parseJobFiles()
    {
        $fileinfos = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator(DME_DIR."/code/modules/jobs/job_types")
        );
        foreach($fileinfos as $pathname => $fileinfo) {
            if (strpos($pathname, '.dm')) {
                // //echo "$pathname<br>";
                $contents = file_get_contents($pathname);
                preg_match_all("/(title = JOB_[A-Z_]+|id(_trim)? = .*)/", $contents, $matches);
                $job = null;
                foreach($matches[0] as $m) {
                    $m = explode(' = ', $m);
                    switch ($m[0]) {
                        case 'title':
                            $job['title'] = $m[1];
                            break;
                        case 'id':
                            $job['id_card'] = $m[1];
                            break;
                        case 'id_trim':
                            $job['trim'] = $m[1];
                            break;
                        default:
                            continue 2;
                            break;
                    }
                }
                if($job) {
                    $jobs[] = $job;
                }
            }
        }
        //echo "Writing job info data to json...";
        $file = fopen(self::JOBINFOFILE, "w");
        fwrite($file, json_encode($jobs));
        fclose($file);
        //echo "Done!<br>";
    }

    public static function mergeJson()
    {
        $info = json_decode(file_get_contents(self::JOBINFOFILE), true);
        $cardData = json_decode(file_get_contents(self::TRIMSFILE), true);
        $titles = json_decode(file_get_contents(self::TITLESFILE), true);
        $hudIcons = json_decode(file_get_contents(self::JOBICONSFILE), true);
        $colors = json_decode(file_get_contents(self::COLORSFILE), true);
        $output = [];
        foreach ($info as $k => &$i) {
            if(isset($i['title'])) {
                $title = $i['title'];
                $i['name'] = $titles[$title];
                if(isset($cardData[$i['name']])) {
                    $i = array_merge($i, $cardData[$i['name']]);
                }
                if(isset($i['sechud_icon_state'])) {
                    $i['sechud_icon_state'] = $hudIcons[$i['sechud_icon_state']];
                }
                if(isset($i['department_color'])) {
                    $i['department_color'] = $colors[$i['department_color']];
                } else {
                    $i['department_color'] = $colors['COLOR_ASSISTANT_GRAY'];

                }
                if(isset($i['subdepartment_color'])) {
                    $i['subdepartment_color'] = $colors[$i['subdepartment_color']];
                } else {
                    $i['subdepartment_color'] = $colors['COLOR_ASSISTANT_OLIVE'];
                }
                //Don't like doing this but I can't exactly parse out the cards
                //At the moment
                if(!isset($i['id_card'])) {
                    $i['id_card'] = "/obj/item/card/id/advanced";
                }
                $iconState = explode('/', $i['id_card']);
                switch(end($iconState)) {
                    case 'advanced':
                    default:
                        $i['iconState'] = IdCardStateEnums::DEFAULT->value;
                        break;
                    case 'silver':
                        $i['iconState'] = IdCardStateEnums::SILVER->value;
                        break;
                    case 'gold':
                        $i['iconState'] = IdCardStateEnums::GOLD->value;
                        break;
                    case 'rainbow':
                        $i['iconState'] = IdCardStateEnums::RAINBOW->value;
                        break;
                    case 'prisoner':
                        $i['iconState'] = IdCardStateEnums::PRISONER->value;
                        break;
                }
                if("JOB_PRISONER" === $i['title']) {
                    $i['trim_state'] = 'trim_warden';
                }
                if(isset($i['sechud_icon_state'])) {
                    $output[$i['name']] = $i;
                }

            }

        }
        //echo "Writing final job data to json...";
        $file = fopen(self::JOBSFILE, "w");
        fwrite($file, json_encode($output));
        fclose($file);
        //echo "Done!<br>";
    }

}
