<?php

require '../inc_0700/config_inc.php';

include "./DbModel/DB.php";

use NewsAggregator\Database\User;

$showLoginError = false;
if (isset($_POST["username"]) && isset($_POST["password"])) {
  $user = User::login($_POST["username"], $_POST["password"]);
  if ($user != null) {
    $_SESSION["username"] = $user->username;
    $_SESSION["userID"] = $user->userID;
    header('Location:index.php');
    exit();
  } else {
    $showLoginError  = true;
  }
}



$config->titleTag = 'Login RSS';
$config->metaDescription = 'Login Form for RSS';
$config->metaKeywords = 'Login Form for RSS';

//adds font awesome icons for arrows on pager
$config->loadhead .= '<script src="https://use.fontawesome.com/releases/v5.15.4/js/all.js"></script>';

get_header();
?>
<style>
  .wrapper {
    margin: 50px auto;
    width: 380px;
    background: rgb(237 242 245);
    border-radius: 5px;
  }

  .wrapper .title {
    line-height: 80px;
    background: #1995dc;
    padding-left: 20px;
    border-radius: 5px 5px 0px 0px;
    font-size: 25px;
    font-weight: 600;
    color: #fff;
  }

  .wrapper form {
    padding: 30px 20px 25px 20px;
  }

  .wrapper form .row {
    height: 45px;
    margin-bottom: 15px;
    position: relative;
  }

  .wrapper form .row input {
    height: 100%;
    width: 100%;
    padding-left: 60px;
    outline: none;
    border-radius: 5px;
    border: 1px solid lightgray;
  }

  .wrapper form .row input:focus {
    border-color: #16a085;
    box-shadow: inset 0px 0px 2px 2px rgba(25, 149, 220, 0.25);
  }

  .wrapper form .row svg {
    position: absolute;
    width: 40px;
    height: 100%;
    padding: 12px;
    background: #1995dc;
    border: 1px solid #1995dc;
    color: #fff;
    border-radius: 5px 0px 0px 5px;
  }

  .wrapper form .button input {
    color: #fff;
    font-size: 18px;
    font-weight: 600;
    padding-left: 0px;
    background: #1995dc;
    border: 1px solid #1995dc;
    cursor: pointer;
  }

  .wrapper form .button input:hover {
    background: #0a82c7;
  }

  .signup-link {
    margin-top: 50px;
    text-align: center;
  }

  .signup-link a,
  .pass a {
    color: #1995dc;
    text-decoration: none;
    position: relative;
  }

  .signup-link a:hover,
  .pass a:hover {
    text-decoration: underline;
  }

  .pass a:hover::before {
    display: block;
  }

  .pass a::before {
    content: "username: ex_user \A password: p@ssword";
    white-space: pre;
    position: absolute;
    top: -50PX;
    display: block;
    background: #fff;
    padding: 5px;
    left: -65px;
    border-radius: 5px;
    display: none;
    border: 1px solid #1995dc;
  }

  .error-msg {
    text-align: center;
    color: #c90909;
  }
</style>

<div class="wrapper">
  <div class="title">
    <span>Login Form</span>
  </div>
  <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
    <div class="row">
      <i class="fas fa-user"></i>
      <input type="text" placeholder="Username" name="username" required />
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
    </div>
  </form>
  <?php if ($showLoginError) : ?>
    <p class="error-msg">wrong username or password, please check the <b>Hint</b></p>
  <?php endif; ?>
</div>



<?php
get_footer();
?>