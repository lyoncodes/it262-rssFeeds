<?php

namespace NewsAggregator\Database;

use \Exception;
/**
 * Database table Feed
 */
class Feed
{
    public $feedID;
    public $categoryID;
    public $title;


    /**
     * category
     * the category which current feed belong to
     * @var Category
     */
    private $category;

    /**
     * findByID
     *
     * @param  $id
     * @return Feed
     */
    public static function findByID($id)
    {
        $SQL = "select * from feed where feedID = $id";
        $entity = DB::Query($SQL, "Feed", true);
        return $entity;
    }

    public static function findByCategoryID($id)
    {
        $SQL = "select * from feed where categoryID = $id";
        $entities = DB::Query($SQL, "Feed");
        return $entities;
    }

    public function __get($name)
    {
        if ($name == "category") {
            if ($this->category == null) {
                $this->category = Category::findByID($this->categoryID);
            }
            return $this->category;
        }
        throw new Exception("Undefined property: Feed::$name");
    }
}
