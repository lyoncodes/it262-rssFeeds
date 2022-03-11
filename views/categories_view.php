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



  echo '<div class="flex-container" style="display:flex; flex-direction:column; justify-content:space-around; flex-wrap:wrap; margin:0 auto;">';
for ($i = 0; $i < count($result); $i++) {
    echo '<div class="flex-item" style="width:40%; margin:1em;">';
    echo '<h1>'.ucfirst($result[$i]->title).'</h1>';
    $feed = Feed::findByCategoryID($i + 1);
    echo '<ul>';
    foreach($feed as $key => $val) {
      echo '<li style="font-weight:bold;">' . ucfirst($val->name) . '</li>';
    }
    echo '</ul>';
    echo '</div>'; //close flex-item
  }

    echo '</div>'; // close flex-container


?>