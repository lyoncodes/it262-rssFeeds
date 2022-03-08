<?php

namespace NewsAggregator\Database;

use \Exception;

class User
{
    public $userID;
    public $username;
    public $userpassword;

    private $categories = null;


    public static function findByID($id)
    {
        $SQL = "select * from users where userID = $id";
        $entity = DB::Query($SQL, "User", true);
        return $entity;
    }

    public static function login($username, $userpassword)
    {
        $SQL = "select * from users where username='$username' and userpassword='$userpassword'";
        $entity = DB::Query($SQL, "User", true);
        return $entity;
    }

    public function __get($name)
    {
        if ($name == "categories") {
            if ($this->categories == null) {
                $this->categories = Category::findByUserID($this->userID);
            }
            return $this->categories;
        }
        throw new Exception("Undefined property: User::$name");
    }
}
