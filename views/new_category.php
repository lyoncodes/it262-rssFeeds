<?php

namespace NewsAggregator;

include_once '../src/sessionStatus.php';
include_once '../src/validateUserSession.php';
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
}

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
      <h1>Add New Category</h1>
      <div class="form-group">
        <input type="text" required class="form-control" name="cat" placeholder="category name">
      </div>
      <button type="submit" class="btn btn-primary">Save</button>
      <button type="button" class="btn btn-secondary" onclick="javascript:window.location.href ='./categories_view.php'">GO BACK</button>
    </fieldset>
  </form>
</div>

<?php
// get_footer();
?>