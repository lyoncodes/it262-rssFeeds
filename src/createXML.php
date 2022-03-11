<?php
namespace NewsAggregator\Frontend;

class DomDoc
{
  public $url;
  public $title;
  public $link;
  public $list;
  public function __construct(
    string $url,
    string $title,
    string $link,
    array $list
  ){
    $this->url = $url;
    $this->title = $title;
    $this->link = $link;
    $this->list = $list;
  }

  public static function newDocument($url, $title, $link, $list){
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

    foreach($list as $item => $val){
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
    
    DomDoc::cacheThis($url, $filepath);
  }

  public static function cacheThis($name, $filepath){
    $_SESSION['cache'][$name] = $filepath;
  }
}
class CacheDoc extends DomDoc
{
  
}
