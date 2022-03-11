<?php
namespace NewsAggregator\Database;
use NewsAggregator\Database\User;
use NewsAggregator\Database\Category;
use NewsAggregator\Database\Feed;

// require '../../inc_0700/config_inc.php';
// get_header();
$categories = (Category::findByUserId($_SESSION["userID"]));

  $view = '<div class="flex-container" style="display:flex; flex-direction:column; justify-content:space-around; flex-wrap:wrap; margin:0 auto;">';

  for ($i = 0; $i < count($categories); $i++) {
    echo '<div class="flex-item" style="width:40%; margin:1em;">
    <h1>'.ucfirst($categories[$i]->title).'</h1>';
    $feed = Feed::findByCategoryID($i + 1);
    echo '<ul>';
    foreach($feed as $key => $val) {
      echo '<li style="font-weight:bold;">' . ucfirst($val->name) . '</li>';
    }
    echo '</ul>
    </div>';
  }
  echo '</div>'; // close flex-container
