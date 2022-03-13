<?php
//check user login

include_once '../src/sessionStatus.php';
include_once '../src/validateUserSession.php';
include_once '../src/RSSCacheModel.php';
include_once "../DbModel/DB.php";

use function NewsAggregator\helpers\check_session_status;
use function NewsAggregator\helpers\validateUserSession;
use NewsAggregator\helpers\RSSCacheModel;
use NewsAggregator\Database\Feed;

require '../../inc_0700/config_inc.php';


// check session status
!check_session_status() && session_start();

//check user login
validateUserSession() ? $_SESSION["lastPageLoad"] = "now" : header('Location:../login.php');

// $config->loadhead .= '<script src="https://use.fontawesome.com/releases/v5.15.4/js/all.js"></script>';
$config->loadhead .= '<link rel="stylesheet" href="../styles/feed_view.css" >';
get_header();


$feed = Feed::findByID($_GET['fid']);
//wrong fid
if ($feed == null) {
  header('Location:./categories_view.php');
}
$category = $feed->category;
//fetch rss 
$RSSObj = RSSCacheModel::fetchRSSData($feed->name, $category->title);

?>
<!-- <link rel="stylesheet" src="../styles/style.css"> -->

<div class="wrapper">
  <div class="header">
    <p class="navigation"> <?= ucfirst($category->title)  ?> -> <?= ucfirst($feed->name) ?> <a href="./categories_view.php">GO BACK</a> </p>
    <p class="cacheInfo">
      Data From Session:
      <?php if ($RSSObj->inSesstion) : ?>
        <span class="yes">YES</span>
        <span>Cache time: <?= $RSSObj->cacheTime->format('m/d/Y H:i') ?></span>
        <span>Expiration time: <?= $RSSObj->expiration->format('m/d/Y H:i') ?></span>
        <span><a href='javascript:document.getElementById("myform").submit();'>clean & refresh</a></span>
      <?php else : ?>
        <span class="no">NO</span>
      <?php endif; ?>
    </p>
  </div>
  <div class="rss-container">
    <?php $index = 1;
    foreach ($RSSObj->xml->channel->item as $feedItem) : ?>
      <div class="rss-item">
        <p class="rss-item-title"><a target="_blank" href="<?= $feedItem->link ?>"><?= $index . ". " . $feedItem->title ?></a></p>
        <p>pubDate: <span> <?= $feedItem->pubDate ?> </span></p>
        <p>srource: <span> <?= $feedItem->source ?> </span></p>
        <div class="rss-description">
          <span> <?= $feedItem->description ?>
        </div>
      </div>
    <?php $index++;
    endforeach; ?>
    <?php if (count($RSSObj->xml->channel->item) == 0) : ?>
      <div class="no-data" style="text-align: center;color:red">
        <i> NO DATA IN CURRENT FEED</i>
      </div>
    <?php endif; ?>
  </div>
  <form id="myform" action="feed_view.php?cid=<?= $category->categoryID ?>&fid=<?= $feed->feedID ?>" method="POST">
  </form>
  <?php
  get_footer();
  ?>