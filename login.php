<?php
session_start();

$salt = 'XyZzy12*_';
$stored_hash = hash('md5', $salt.'php123'); // password is php123

$message = "";   // ✅ Initialize properly

if (isset($_POST['cancel'])) {
    header("Location: index.php");
    return;
}

if (isset($_POST['who']) && isset($_POST['pass'])) {
    if (strlen($_POST['who']) < 1 || strlen($_POST['pass']) < 1) {
        $message = "Email and password are required";
    } else if (strpos($_POST['who'], '@') === false) {
        $message = "Email must have an at-sign (@)";
    } else {
        $check = hash('md5', $salt.$_POST['pass']);
        if ($check == $stored_hash) {
            $_SESSION['name'] = $_POST['who'];
            header("Location: autos.php");
            return;
        } else {
            $message = "Incorrect password"; // exact text expected
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Nirmal Barot - Autos Database</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
  <h1>Please Log In</h1>
  <?php
  if ($message !== "") {
      echo('<p class="error">'.htmlentities($message)."</p>\n");
  }
  ?>
  <form method="POST">
      <label for="id_who">Email</label>
      <input type="text" name="who" id="id_who"><br>
      <label for="id_pass">Password</label>
      <input type="password" name="pass" id="id_pass"><br>
      <input type="submit" class="btn" value="Log In">
      <input type="submit" name="cancel" class="btn cancel" value="Cancel">
  </form>
</div>
</body>
</html>
