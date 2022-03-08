<?php
include 'config.php';
session_start();
require '../inc_0700/config_inc.php';
get_header();
// if there is no username value in the session array, include user auth process
if (!isset($_SESSION['username'])) {
  include 'login.php';
} else {
  // else we're good to go
  echo '<p>hello '.$_SESSION['username'].', your user id is: '. $_SESSION['id'].'</p>';
  
  // query the cache
  if (isset($_SESSION['cache']) && count($_SESSION['cache']) > 0) {
    echo 'this is from the cache';
    echo '<br>';
    foreach($_SESSION['cache'] as $cached){
      // var_dump($_SESSION['cache']);
      // echo '<br>';
      echo '<pre>'.var_dump($cached).'</pre>';
      // print '<h1>' . $cached->channel->title . '</h1>';
      // foreach($cached->channel->item as $story)
      // {
      //   echo '<a href="' . $story->link . '">' . $story->title . '</a><br />'; 
      //   echo '<p>' . $story->description . '</p><br /><br />';
      // }
    }
  } else {
    // if no cache hit...
    
    // make a round trip to the server
    $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    $query = "SELECT f.URL, f.title FROM category c JOIN feed f ON c.categoryID = f.categoryID WHERE c.userID = ";
    $query .= $_SESSION['id'];

    $res = mysqli_query($conn, $query);
    
    while ($row = mysqli_fetch_assoc($res)){
      $response = file_get_contents($row['URL']);
      $xml = simplexml_load_string($response);
      foreach($xml->channel->item as $feedItem) {
        // echo $feedItem->link;
        echo '<br>';
        echo '<h1>'.$feedItem->title.'</h1>';
        echo '<br>';
        echo $feedItem->description;
        echo '<br>';
        $_SESSION['cache'][] = $feedItem->asXML();
      }
    }

    // foreach($_SESSION['cache'] as $cached){
    //   print '<h1>' . $cached->channel->title . '</h1>';
    //   foreach($cached->channel->item as $story)
    //   {
    //     echo '<a href="' . $story->link . '">' . $story->title . '</a><br />'; 
    //     echo '<p>' . $story->description . '</p><br /><br />';
    //   }
    // }
  
  }
}


