<?php
// include 'config.php';
// session_start();

$auth = array(
  'username' => 'username',
  'password' => 'password'
);

$errors = [];

function setSessionVariables($arr){
  foreach($arr as $cred => $val) {
    $_SESSION["$cred"] = $val;
  }
  echo var_dump($_SESSION);
}

function generateToken($pw){
  return md5($pw);
}

if(isset($_POST['auth'])) {
  $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
  
  foreach($auth as $field) {
    ${$field} = mysqli_real_escape_string($conn, $_POST[$field]);
    if (empty( ${$field} )) {
      $error_msg = str_replace('_', ' ', $field);
      array_push($errors, "$error_msg is required");
    }
  }
  
  if(empty($errors)){
    $sql = "SELECT * FROM users WHERE username = '$username' AND userpassword = '$password'";
    $query = mysqli_query($conn, $sql);
    $results = mysqli_fetch_assoc($query);
    header('Location:index.php');
  }
  
  if (count($results) > 0) {
    setSessionVariables(['username' => $results['username'], 'id' => $results['userID']]);
  } else {
    array_push($errors, 'The username/password is incorrect');
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<body>
  <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ;?>" method="POST">
    <label for="username">Username</label>
    <input type="text" name="username" value="<?php if(isset($_POST['username'])) echo $_POST['username'];?>">
    <label for="password">Password</label>
    <input type="password" name="password">
    <button type="submit" name="auth">Login</button>
  </form>
</body>
</html>
