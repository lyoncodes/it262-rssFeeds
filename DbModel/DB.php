<?php

namespace NewsAggregator\Database;

include_once __DIR__ . "/User.php";
include_once __DIR__ . "/Category.php";
include_once __DIR__ . "/Feed.php";

class DB
{
    private static $namespace = 'NewsAggregator\Database\\';

    /**
     * Query
     *
     * @param   $SQL
     * @param   $entityName
     * @param   $single -- if true return a entity, otherwise, return an array
     * @return  array or a entity
     */
    public static function Query($SQL, $entityName, $single = false)
    {
        $entities = [];
        $link = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        $result = mysqli_query($link, $SQL) or die(mysqli_error($link));
        $entityName =  DB::$namespace . $entityName;

        while ($row = mysqli_fetch_assoc($result)) {
            //create a empty object instance
            $entity = new $entityName();
            //set entity's property value
            foreach ($row as $property => $value) {
                $entity->$property  = $value;
            }
            //push the entity to result array
            $entities[] = $entity;
        }

        mysqli_free_result($result);
        mysqli_close($link);
        //for the list page return a array
        if (!$single) {
            return  $entities;
        }
        //for the view page return a entity
        return count($entities) > 0 ?  $entities[0] : null;
    }

    public static function execute($sql)
    {
        $result =  array("succeed" => true, "errorMsg" => "");
        $link = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        $stmt = mysqli_prepare($link, $sql);
        if (!$stmt || !mysqli_stmt_execute($stmt)) {
            $result["succeed"] = false;
            $result["errorMsg"] = $link->error;
        }
        mysqli_close($link);
        return $result;
    }
}
