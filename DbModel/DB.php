<?php

namespace NewsAggregator\Database;

include_once __DIR__ . "/User.php";
include_once __DIR__ . "/Category.php";
include_once __DIR__ . "/Feed.php";

class DB
{
    private static $namespace = 'NewsAggregator\Database\\';

    public static function Query($SQL, $entityName, $single = false)
    {
        $entities = [];
        $link = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        $result = mysqli_query($link, $SQL) or die(mysqli_error($link));
        $entityName =  DB::$namespace . $entityName;

        while ($row = mysqli_fetch_assoc($result)) {
            $entity = new $entityName();
            foreach ($row as $property => $value) {
                $entity->$property  = $value;
            }
            $entities[] = $entity;
        }

        mysqli_free_result($result);
        mysqli_close($link);

        if (!$single) {
            return  $entities;
        }
        return count($entities) > 0 ?  $entities[0] : null;
    }
}
