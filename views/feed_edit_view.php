<?php

require '../../inc_0700/config_inc.php';
// require '../config.php';

include_once "../DbModel/DB.php";

use NewsAggregator\Database\Category;
use NewsAggregator\Database\Feed;

check user login
if (!isset($_SESSION["userID"])) {
    header('Location:../login.php');
    exit();
}

if (isset($_POST["save"])) {
    header('Location:./categories_view.php');
    $feed = new Feed($_POST["fid"], $_POST["cid"], $_POST["feed"]);
    $status = $feed->save();
    $_SESSION["saveSucceed"] =   $status["succeed"];
    $_SESSION["saveMsg"] =   $status["succeed"] ? "save succeed" : $status["errorMsg"];
    header('Location:./categories_view.php');
    exit();
}



$category =  isset($_GET["cid"]) ?  Category::findByID($_GET["cid"]) : null;
if ($category == null) {
    header('Location:./categories_view.php');
    exit();
}
$feed = isset($_GET["fid"]) ? Feed::findByID($_GET["fid"]) : null;

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
            <div class="form-group">
                <label for="exampleInputPassword1" class="form-label mt-4">Category: </label>
                <h4> <?= ucfirst($category->title) ?> </h4>
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1" class="form-label mt-4">Feed:</label>
                <input type="text" required class="form-control" name="feed" placeholder="feed name" value="<?= $feed == null ? "" : $feed->name ?>">
                <input type="hidden" name="cid" value="<?= $category->categoryID ?>">
                <input type="hidden" name="fid" value="<?= $feed == null ? "" : $feed->feedID ?>">
                <input type="hidden" name="save" value="yes">
            </div>
            <button type="submit" class="btn btn-primary">Save</button>
            <button type="button" class="btn btn-secondary" onclick="javascript:window.location.href ='./categories_view.php'">GO BACK</button>
        </fieldset>
    </form>
</div>

<?php
get_footer();
?>