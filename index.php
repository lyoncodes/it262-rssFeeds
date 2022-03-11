<?php
namespace NewsAggregator\Database;

include_once 'DbModel/DB.php';
include_once 'src/createXML.php';

use NewsAggregator\Database\User;
use NewsAggregator\Database\Category;
use NewsAggregator\Database\Feed;
use NewsAggregator\Frontend\DomDoc;

include 'config.php';

$db = new namespace\DB;
// $category = new namespace\Category;

session_start();

// INCLUDES FOR DEPLOYMENT ==============

// require '../inc_0700/config_inc.php';
// get_header();
// CORE LOGIC ==============


function formatURL($strToParse){
  $strToParse = str_replace(' ', '+', $strToParse);
  $base_uri = 'https://news.google.com/rss/search?q=&hl=en-US&gl=US&ceid=US:en';
  $base_uri = str_replace('q=', 'q='.$strToParse.'', $base_uri);
  
  return $base_uri;
}

// EXECUTION SCRIPT ============
include 'views/categories_view.php';

// query the cache
// if (isset($_SESSION['cache'])) {
//   echo 'this is from the cache';
//   echo '<br>';
//   foreach($_SESSION['cache'] as $name => $val) {
//     $xml = simplexml_load_file($val);
//     echo '<h1>'.$name.'</h1>';
//     foreach($xml->feed->story as $story){
//       echo "
//         <h3>$story->title}</h3><br>
//         $story->description
//       ";
//     }
//   }
// } else {
  // if no cache hit...
  // make a round trip to the server to grab our categories, and cache the urls
  $res = ($user->__get("categories"));

  foreach($res as $item) {
    $url = formatURL($item->title); // parse names, replacing spaces with +
    $response = file_get_contents($url); // fetch xml data
    $xml = simplexml_load_string($response); //create readable xml
    
    DomDoc::newDocument($item->title, $xml->channel->title, $xml->channel->link, $xml->channel->item);

    echo '<h3 align="center">'.$item->title.'</h3>';
    // foreach($xml->channel->item as $feedItem) {
    //   echo '
    //   <table class="table table-hover">
    //     <thead>
    //       <tr>
    //         <th><h4>'.$feedItem->title.'<h4></th>
    //       </tr>
    //     </thead>
    //     <tbody>
    //       <tr>
    //         <th>
    //           <a href="'.$feedItem->link.'">'.$feedItem->source.'</a>
    //         </th>
    //       </tr>
    //     </tbody>
    //   ';
    // }
  }

// }


