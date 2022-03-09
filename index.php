<?php
include 'config.php';
session_start();

// INCLUDES FOR DEPLOYMENT ==============

// require '../inc_0700/config_inc.php';
// get_header();

// CORE LOGIC ==============

function newDOMdoc($url, $title, $link, $items){
  $filepath = ''.$url.'.xml';
  $dom = new DOMDocument();
  $root  = $dom->createElement('feeds');

    for($i = 0; $i < count($items); $i++) {
      $title = $items[$i]->title;
      $link = $items[$i]->link;

      $feed = $dom->createElement('feed');
      
      $title = $dom->createElement('title', $title);
      $item = $dom->createElement('link', $link);
      // $desc = $dom->createElement('description', $description);
      
      $feed->appendChild($title);
      $feed->appendChild($item);
      // $feed->appendChild($desc);
      $root->appendChild($feed);
  }
  
  $dom->appendChild($root);
  $dom->save($filepath);
  
  $_SESSION['cache'][$url] = $filepath;
  var_dump($_SESSION['cache']);
}

function formatURL($strToParse){
  $strToParse = str_replace(' ', '+', $strToParse);
  $base_uri = 'https://news.google.com/rss/search?q=&hl=en-US&gl=US&ceid=US:en';
  $base_uri = str_replace('q=', 'q='.$strToParse.'', $base_uri);
  
  return $base_uri;
}

// EXECUTION SCRIPT ============
  
// query the cache
if (isset($_SESSION['cache'])) {
  echo 'this is from the cache';
  echo '<br>';
  foreach($_SESSION['cache'] as $name => $val) {
    $xml = simplexml_load_file($val);
    echo '<h1>'.$name.'</h1>';
    foreach($xml as ${$name}){
      echo "
        <h3>{${$name}->title}</h3>
        <a href='{${$name}->link}'>{${$name}->link}</a><br>
      ";
    }
  }
} else {
  // if no cache hit...
  // make a round trip to the server
  $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
  $query = "SELECT f.name FROM category c JOIN feed f ON c.categoryID = f.categoryID";

  $res = mysqli_query($conn, $query);
  
  $list = array();
  
  while ($row = mysqli_fetch_assoc($res)){
    $url = formatURL($row["name"]); // parse row["name"], replacing spaces with +
    
    $response = file_get_contents($url); // fetch xml data
    $xml = simplexml_load_string($response); //create readable xml

    array_push($list, $xml->channel);

    newDOMdoc($row["name"], $xml->channel->title, $xml->channel->link, $xml->channel->item);

    echo '<h1>'.$xml->channel->title.'</h1>';
    foreach($xml->channel->item as $feedItem) {
      echo '<h3>'.$feedItem->title.'</h3>';
      echo '<br>';
      echo $feedItem->link;
      echo '<br>';
      echo $feedItem->description;
      echo '<br>';
    }
  }
}


