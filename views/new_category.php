<?php

namespace NewsAggregator;

include_once '../src/sessionStatus.php';
include_once '../src/validateUserSession.php';
require '../../inc_0700/config_inc.php';
// require '../config.php';
include_once "../DbModel/DB.php";

use NewsAggregator\Database\Category;
use function NewsAggregator\helpers\check_session_status;
use function NewsAggregator\helpers\validateUserSession;

// check session status
!check_session_status() && session_start();

if (!isset($_SESSION["userID"])) {
  header('Location:../login.php');
  exit();
}

if (isset($_POST["cat"])) {
  Category::createCategory($_SESSION["userID"], $_POST["cat"]);
  header('Location:./categories_view.php');
}

$config->loadhead .= '<script src="https://use.fontawesome.com/releases/v5.15.4/js/all.js"></script>';
get_header();

?>

<style>
    .wrapper {
        width: 450px;
        margin: 100px auto;
    }
</style>

<div class="wrapper">
  <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
    <fieldset>
      <h4>Add New Category</h4>
      <div class="form-group">
        <input type="text" required class="form-control" name="cat" placeholder="category name">
      </div>
      <button type="submit" class="btn btn-primary">Save</button>
      <button type="button" class="btn btn-secondary" onclick="javascript:window.location.href ='./categories_view.php'">GO BACK</button>
    </fieldset>
  </form>
</div>

<?php
get_footer();
?>