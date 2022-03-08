<?php

namespace NewsAggregator\Database;

use \Exception;


/**
 * DataBase Table category
 */
class Category
{

    public $categoryID;
    public $userID;
    public $title;


    /**
     * feeds
     * the feeds which belong to current category
     * @var array of Feed Class
     */
    private $feeds;
    /**
     * user
     * the User which current category belong to
     * @var User
     */
    private $user;

    /**
     * findByID
     *
     * @param   $id
     * @return Category or null
     */
    public static function findByID($id)
    {
        $SQL = "select * from category where categoryID = $id";
        $entity = DB::Query($SQL, "Category", true);
        return $entity;
    }

    /**
     * findByUserID
     *
     * @param   $id
     * @return array of Category
     */
    public static function findByUserID($id)
    {
        $SQL = "select * from category where userID = $id";
        $entities = DB::Query($SQL, "Category");
        return $entities;
    }

    /**
     * __get
     *
     * @param   $name
     * @return array of Feeds or User
     */
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
