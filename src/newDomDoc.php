<?php
namespace NewsAggregator\Database;

function newDomDoc($url, $title, $link, $items){
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
    
    $title = $dom->createElement('title', htmlspecialchars($val->title));
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
