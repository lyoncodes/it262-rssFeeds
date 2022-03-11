<?php
namespace NewsAggregator\Database;

use NewsAggregator\Database\User;
use NewsAggregator\Database\Category;
use NewsAggregator\Database\Feed;

// require '../../inc_0700/config_inc.php';
// get_header();

$res = ($user->__get("categories"));

for ($i = 0; $i < count($res); $i++) {
  echo '<h1 align="center">'.$res[$i]->title.'</h1>';
  $feed = Feed::findByCategoryID($i + 1);

  $ul = '<ul>';
  foreach($feed as $key => $val) {
    $ul .= '
      <li>'.$val->name.'</li>';
  }
  $ul .= '</ul>';
  
  echo $ul;
}


?>