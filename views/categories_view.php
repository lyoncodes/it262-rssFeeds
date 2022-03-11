<?php
//check user login

require '../../inc_0700/config_inc.php';
include_once "../DbModel/DB.php";

use NewsAggregator\Database\Category;

if (!isset($_SESSION["userID"])) {
  header('Location:../login.php');
  exit();
}
$config->loadhead .= '<script src="https://use.fontawesome.com/releases/v5.15.4/js/all.js"></script>';
get_header();

$showSaveAction = null;
$saveActionMsg = null;
if (isset($_SESSION["saveSucceed"])) {
  $showSaveAction = $_SESSION["saveSucceed"];
  $saveActionMsg  = $_SESSION["saveMsg"];
  unset($_SESSION["saveSucceed"]);
}


$categories = Category::findByUserID($_SESSION["userID"]);

?>
<style>
  .wrapper a {
    font-size: 20px;
  }

  .wrapper ul li {
    padding: 0px 8px;
  }

  .edit-action {
    margin-left: 20px;
    cursor: pointer;
    font-size: 16px;
  }

  .edit-action a {
    color: #8e8e8e;
  }

  .edit-action:hover a {
    color: #2fa4e7;
  }

  .add-action {
    color: #52b052;
  }

  .myalert {
    margin-top: 20px;
    animation-name: myalert;
    animation-duration: 3s;
    animation-delay: 3s;
    animation-fill-mode: forwards;
    overflow: hidden;
    pointer-events: none;
  }

  @keyframes myalert {
    0% {
      opacity: 1;
    }

    100% {
      opacity: 0;
    }
  }
</style>

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
          <li> <a href="../index.php?cid=<?= $category->categoryID ?>&fid=<?= $feed->feedID ?>"><?= $feed->name ?> </a> <span class="edit-action"> <a href="./feed_edit_view.php?cid=<?= $category->categoryID ?>&fid=<?= $feed->feedID ?>"><i class="far fa-edit"></i></a> </span> </li>
        <?php endforeach; ?>
        <li><a class="add-action" href="./feed_edit_view.php?cid=<?= $category->categoryID ?>"><i class="far fa-plus-square"></i></a> </li>
      </ul>
    </div>
  <?php endforeach; ?>
</div>

<?php
get_footer();
?>