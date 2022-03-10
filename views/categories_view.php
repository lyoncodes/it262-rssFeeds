<?php
namespace NewsAggregator\Database;
include_once "../DbModel/DB.php";
include_once "../DbModel/Category.php";
include_once "../DbModel/Feed.php";
include_once "../DbModel/User.php";

use NewsAggregator\Database\User;
use NewsAggregator\Database\Category;
use NewsAggregator\Database\Feed;

require '../../inc_0700/config_inc.php';
get_header();


$result = Category::findByUserID(1);
$feed1 = Feed::findByCategoryID(1);

for ($i = 0; $i < count($result); $i++) {
    echo '<h1>'.$result[$i]->title.'</h1>';
    $feed = Feed::findByCategoryID($i + 1);
    foreach($feed as $key => $val) {
      echo $val->name;
    }
  }


?>