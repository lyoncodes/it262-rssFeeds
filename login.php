<?php

require '../inc_0700/config_inc.php';
// require 'config.php';

include_once "./DbModel/DB.php";
include_once './src/sessionStatus.php';

use NewsAggregator\Database\User;
use function NewsAggregator\helpers\check_session_status;
// check session status
!check_session_status() && session_start();

$showLoginError = false;
if (isset($_POST["username"]) && isset($_POST["password"])) {
  $user = User::login($_POST["username"], $_POST["password"]);
  if ($user != null) {
    $_SESSION["username"] = $user->username;
    $_SESSION["userID"] = $user->userID;
    header('Location:views/categories_view.php');
    exit();
  } else {
    $showLoginError  = true;
  }
}



$config->titleTag = 'Login RSS';
$config->metaDescription = 'Login Form for RSS';
$config->metaKeywords = 'Login Form for RSS';

// adds font awesome icons for arrows on pager
$config->loadhead .= '<script src="https://use.fontawesome.com/releases/v5.15.4/js/all.js"></script>';
$config->loadhead .= '<link rel="stylesheet" href="./styles/login.css" >';
get_header();
?>
<link rel="stylesheet" href="../styles/login.css">
<div class="wrapper">
  <div class="title">
    <span>Login Form</span>
  </div>
  <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
    <div class="row">
      <i class="fas fa-user"></i>
      <input type="text" placeholder="Username" name="username" value="<?= isset($_SESSION["username"]) ? $_SESSION["username"] : "" ?>" required />
    </div>
    <div class="row">
      <i class="fas fa-lock"></i>
      <input type="password" placeholder="Password" name="password" required />
    </div>
    <div class="row button">
      <div class="pass">
        <a href="#">Hint</a>
      </div>
      <input type="submit" value="Login" />
      <div class="signup-link">
        <a href="auth.php">Create Account</a>
      </div>
    </div>
  </form>
  <?php if ($showLoginError) : ?>
    <p class="error-msg">wrong username or password, please check the <b>Hint</b></p>
  <?php endif; ?>
</div>



<?php
// get_footer();
?>