<?php

namespace NewsAggregator;

include_once '../src/sessionStatus.php';
include_once '../src/validateUserSession.php';
include_once "../DbModel/DB.php";

use function NewsAggregator\helpers\check_session_status;
use function NewsAggregator\helpers\validateUserSession;

use NewsAggregator\Database\Category;

require '../../inc_0700/config_inc.php';


// check session status
!check_session_status() && session_start();

//check user login
validateUserSession() ? $_SESSION["lastPageLoad"] = "now" : header('Location:../login.php');

$config->loadhead .= '<script src="https://use.fontawesome.com/releases/v5.15.4/js/all.js"></script>';
$config->loadhead .= '<link rel="stylesheet" href="../styles/categories_view.css" >';
get_header();

$showSaveAction = null;
$saveActionMsg = null;
if (isset($_SESSION["saveSucceed"])) {
  $showSaveAction = $_SESSION["saveSucceed"];
  $saveActionMsg  = $_SESSION["saveMsg"];
  unset($_SESSION["saveSucceed"]);
}

//seach category by user id
//$categories = Category::findByUserID($_SESSION["userID"]);
//serch all categories
$categories = Category::all();
?>
<link rel="stylesheet" src="../styles/style.css">
<div class="wrapper">

  <?php if ($showSaveAction !== null) : ?>

    <div class="myalert alert alert-dismissible <?= $showSaveAction ? "alert-success" : "alert-danger" ?>">
      <strong><?= $showSaveAction ? "Well done!" : "Oh snap!" ?></strong> <a href="#" class="alert-link"><?= $saveActionMsg ?></a>.
    </div>

  <?php endif; ?>

  <?php foreach ($categories as $category) :
    $feeds = $category->feeds;
  ?>
    <div class="category">
      <h1><?= ucfirst($category->title)  ?> </h1>
      <ul>
        <?php foreach ($feeds as $feed) : ?>
          <li> <a href="./feed_view.php?cid=<?= $category->categoryID ?>&fid=<?= $feed->feedID ?>"><?= $feed->name ?> </a> <span class="edit-action"> <a href="./feed_edit_view.php?cid=<?= $category->categoryID ?>&fid=<?= $feed->feedID ?>"><i class="far fa-edit"></i></a> </span> </li>
        <?php endforeach; ?>
        <li><a class="add-action" href="./feed_edit_view.php?cid=<?= $category->categoryID ?>"><i class="far fa-plus-square"></i></a> </li>
      </ul>
    </div>
  <?php endforeach; ?>
</div>

<?php
get_footer();
?>