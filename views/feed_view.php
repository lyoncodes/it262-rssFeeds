<?php
//check user login

// require '../../inc_0700/config_inc.php';
require '../config.php';

include_once "../DbModel/DB.php";

use NewsAggregator\Database\Category;
use NewsAggregator\Database\Feed;

// $config->loadhead .= '<script src="https://use.fontawesome.com/releases/v5.15.4/js/all.js"></script>';
// get_header();

$showSaveAction = null;
// $saveActionMsg = null;
// if (isset($_SESSION["saveSucceed"])) {
//   $showSaveAction = $_SESSION["saveSucceed"];
//   $saveActionMsg  = $_SESSION["saveMsg"];
//   unset($_SESSION["saveSucceed"]);
// }

function formatURL($strToParse){
  $strToParse = str_replace(' ', '+', $strToParse);
  $base_uri = 'https://news.google.com/rss/search?q=&hl=en-US&gl=US&ceid=US:en';
  $base_uri = str_replace('q=', 'q='.$strToParse.'', $base_uri);
  
  return $base_uri;
}

$feed = Feed::findByID($_GET['fid']);
$url = formatURL($feed->name); // parse names, replacing spaces with +
$response = file_get_contents($url); // fetch xml data
$xml = simplexml_load_string($response); //create readable xml

// foreach($xml->channel->item as $feedItem) {
//   echo '
//     <table class="table table-hover">
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

?>
<link rel="stylesheet" src="../styles/style.css">

<div class="wrapper">

  <?php if ($showSaveAction !== null) : ?>

    <div class="myalert alert alert-dismissible <?= $showSaveAction ? "alert-success" : "alert-danger" ?>">
      <strong><?= $showSaveAction ? "Well done!" : "Oh snap!" ?></strong> <a href="#" class="alert-link"><?= $saveActionMsg ?></a>.
    </div>

  <?php endif; ?>

  <?php foreach($xml->channel->item as $feed) :
  ?>
    <div class="feed">
      <h4><?= ucfirst($feed->title)  ?> </h4>
      <ul>
        <li>
          <a href="<?=$feed->link?>"><?=$feed->source?></a>
        </li>
        <!-- <?php foreach ($feeds as $feed) : ?>
          <li> <a href="../index.php?cid=<?= $feed->feedID ?>&fid=<?= $feed->feedID ?>"><?= $feed->name ?> </a> <span class="edit-action"> <a href="./feed_edit_view.php?cid=<?= $feed->feedID ?>&fid=<?= $feed->feedID ?>"><i class="far fa-edit"></i></a> </span> </li>
        <?php endforeach; ?> -->
        <li><a class="add-action" href="./feed_edit_view.php?cid=<?= $feed->feedID ?>"><i class="far fa-plus-square"></i></a> </li>
      </ul>
    </div>
  <?php endforeach; ?>
</div>

<?php
// get_footer();
?>
