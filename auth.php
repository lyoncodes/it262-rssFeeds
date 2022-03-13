<?php
namespace NewsAggregator\Database;

include 'config.php';
include "./DbModel/DB.php";

use NewsAggregator\Database\User;

$showSignUpError = false;
if (isset($_POST["username"]) && isset($_POST["password"])) {
  $valid = User::signup($_POST["username"], $_POST["password"]);
  if ($valid){
    $_SESSION["username"] = $_POST["username"];
    header('Location:login.php');
  }
}
?>
<link rel="stylesheet" href="../styles/style.css">
<div class="wrapper">
  <div class="title">
    <span>Sign Up Form</span>
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
      <input type="submit" value="Sign Up" />
      <div class="signup-link">
        <a href="../login.php"> Back To Login</a>
      </div>
    </div>
  </form>
  <?php if ($showSignUpError) : ?>
    <p class="error-msg">wrong username or password, please check the <b>Hint</b></p>
  <?php endif; ?>
</div>
