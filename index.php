<?php
include 'config.php';
session_start();

// if there is no username value in the session array, include user auth process
if (!isset($_SESSION['username'])) {
  include 'login.php';
} else {
  // else we're good to go
  echo '<p>hello '.$_SESSION['username'].', your user id is: '. $_SESSION['id'].'</p>';
  // query the cache
  // if no cache hit...
  
  // make a round trip to the server
  $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
  $sql = "SELECT (feed.URL) FROM category JOIN feed ON category.categoryID = feed.categoryID WHERE userID = ";
  $sql .= $_SESSION['id'];
  $query = mysqli_query($conn, $sql);
  $results = mysqli_fetch_assoc($query);
  $url =  ($results["URL"]);
  
  
  // visit the fetched url and call the xml
  $response = file_get_contents($url);
  $xml = simplexml_load_string($response);
  print '<h1>' . $xml->channel->title . '</h1>';
  foreach($xml->channel->item as $story)
  {
    echo '<a href="' . $story->link . '">' . $story->title . '</a><br />'; 
    echo '<p>' . $story->description . '</p><br /><br />';
  }
}


