<?php

namespace App;

use DateTime;
use DateTimeZone;
use App\SystemTools;

class GitRevision
{
    public const OUTFILE = OUTPUT_DIR."/../json/revision.json";

    public static function getRevision(): array
    {
        $commitHash = trim(exec('cd '.DME_DIR.' && git log --pretty="%h" -n1 HEAD'));

        $commitDate = new \DateTime(trim(exec('cd '.DME_DIR.' && git log -n1 --pretty=%ci HEAD')));
        $commitDate->setTimezone(new \DateTimeZone('UTC'));

        return [
            'hash' => $commitHash,
            'date' => $commitDate->format('Y-m-d H:i:s')
        ];

    }

    public static function cacheRevision(): array
    {
        $revision = self::getRevision();
        SystemTools::ensurePublicJsonDirectory();
        $file = fopen(self::OUTFILE, "w");
        fwrite($file, json_encode($revision));
        fclose($file);
        return $revision;
    }

    public static function get(): Object
    {
        if(file_exists(self::OUTFILE)) {
            $revision = json_decode(file_get_contents(self::OUTFILE));
        } else {
            $revision = (object) self::cacheRevision();
        }
        return $revision;
    }

    public static function getString($regenRev = false): string
    {
        if($regenRev) {
            $revision = (object) self::cacheRevision();
        } else {
            $revision = self::get();
        }
        $revision->date = new DateTime($revision->date, new DateTimeZone('UTC'));
        return sprintf('<a href="'.REPO_URL_COMMIT.'/%s" target="_blank">%s</a> (%s)', $revision->hash, $revision->hash, $revision->date->format('Y-m-d H:i:s'));
    }
}
