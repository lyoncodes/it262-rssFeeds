<?php
include_once "./config.php";

//reference DBModel
include_once "./DbModel/DB.php";

use NewsAggregator\Database\User;
use NewsAggregator\Database\Category;
use NewsAggregator\Database\Feed;

//----------------------------------------------//
function printdata($object, $description = "")
{
    echo '<pre>';
    echo $description . "<br>";
    echo var_export($object);
    echo '</pre>';
}
//
//for the login page
$user = User::login("ex_user", "p@ssword");
if ($user != null) {
    //login succeeded
    //todo
    printdata($user, 'user data');
} else {
    //wrong passcode or username
    //todo 
}

//----------------------------------------------//
//for the categories list page
//$userID = $_SESSION("userID");
//assume $userID = 1;
$userID = 1;
$categories  = Category::findByUserID($userID);
if (count($categories) > 0) {
    //todo
    printdata($categories, 'categories list');
} else {
    //without any data
    //todo
}

//for the feeds list page
//$categoryID = $_GET["id"];
//assume $categoryID = 1;
$categoryID = 1;
$feeds = Feed::findByCategoryID($categoryID);
if (count($feeds) > 0) {
    printdata($feeds, 'feeds list');
    //todo
} else {
    //without any data
    //todo
}

//for feed-view page
//$feedID = $_GET["id"];
//assume $feedID = 1;
$feedID = 1;
$feed = Feed::findByID($feedID);
if ($feed != null) {
    //fetch data from rss
    printdata($feed, 'feed data');
} else {
    //wrong $feedID
    //todo 
}


//The Model User, Category, Feed are like Doubly Linked List
//so you can use Models like below to get data easier 
//when you need user information in category list page 
//or you need category information in feed list page

// 1) Search the Feed information start from User
$user = User::login("ex_user", "p@ssword");
$url = $user->categories[0]->feeds[0]->URL;
echo 'Feed URL is ' . $url . '<br/><br/>';

// 2) Search the User information start from Feed
$feed = Feed::findByID($feedID);
$username = $feed->category->user->username;
echo 'Username is ' . $username;
