<?php
namespace NewsAggregator\Database;
include_once 'DbModel/DB.php';

// include 'config.php';

$db = new namespace\DB;
$category = new namespace\Category;

session_start();

// INCLUDES FOR DEPLOYMENT ==============

require '../inc_0700/config_inc.php';
get_header();
// CORE LOGIC ==============

function newDOMdoc($url, $title, $link, $items){
  $filepath = 'cache/'.$url.'.xml';
  $dom = new \DOMDocument();
  
  $root  = $dom->createElement('feeds');
  $feed = $dom->createElement('feed');
  $description = $dom->createElement('description');
  $title = $dom->createElement('title', $title);
  $href = $dom->createElement('link');
  
  $item = $dom->createTextNode($link);
  $href->appendChild($item);
  
  $feed->appendChild($title);
  $feed->appendChild($href);
  
  foreach($items as $item => $val){
    $story = $dom->createElement('story');
    
    $title = $dom->createElement('title', $val->title);
    $story->appendChild($title);
    
    $description = $dom->createElement('description');
    $desc = $dom->createTextNode($val->description);
    $description->appendChild($desc);
    $story->appendChild($description);
    
    $feed->appendChild($story);
    $root->appendChild($feed);
  }
  
  $dom->appendChild($root);
  $dom->save($filepath);
  
  $_SESSION['cache'][$url] = $filepath;
}

function formatURL($strToParse){
  $strToParse = str_replace(' ', '+', $strToParse);
  $base_uri = 'https://news.google.com/rss/search?q=&hl=en-US&gl=US&ceid=US:en';
  $base_uri = str_replace('q=', 'q='.$strToParse.'', $base_uri);
  
  return $base_uri;
}

// EXECUTION SCRIPT ============
  
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
  // make a round trip to the server
  $query = "SELECT f.name FROM category c JOIN feed f ON c.categoryID = f.categoryID";
  
  $res = $db::Query($query, 'Feed');

  foreach($res as $item) {
    $url = formatURL($item->name); // parse names, replacing spaces with +
    $response = file_get_contents($url); // fetch xml data
    $xml = simplexml_load_string($response); //create readable xml
    newDOMdoc($item->name, $xml->channel->title, $xml->channel->link, $xml->channel->item);

    echo '<h3 align="center">'.$item->name.'</h3>';
    foreach($xml->channel->item as $feedItem) {
      echo '
      <table class="table table-hover">
        <thead>
          <tr>
            <th>'.$xml->channel->title.'</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <th>
              <a href="'.$feedItem->link.'">'.$feedItem->title.'</a>
            </th>
            <td>
              '.$feedItem->description.'
            </td>
          </tr>
        </tbody>
      ';
    }
  }
// }


