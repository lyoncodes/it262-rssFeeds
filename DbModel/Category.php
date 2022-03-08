<?php

namespace NewsAggregator\Database;

use \Exception;

class Category
{
    public $categoryID;
    public $userID;
    public $title;

    private $feeds;
    private $user;

    public static function findByID($id)
    {
        $SQL = "select * from category where categoryID = $id";
        $entity = DB::Query($SQL, "Category", true);
        return $entity;
    }

    public static function findByUserID($id)
    {
        $SQL = "select * from category where userID = $id";
        $entities = DB::Query($SQL, "Category");
        return $entities;
    }

    public function __get($name)
    {
        if ($name == "feeds") {
            if ($this->feeds == null) {
                $this->feeds = Feed::findByCategoryID($this->categoryID);
            }
            return $this->feeds;
        }
        if ($name == "user") {
            if ($this->user == null) {
                $this->user = User::findByID($this->userID);
            }
            return $this->user;
        }
        throw new Exception("Undefined property: Category::$name");
    }
}
