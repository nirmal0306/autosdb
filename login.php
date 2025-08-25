<?php
session_start();
require_once "config.php";

$salt = 'XyZzy12*_';
$stored_hash = hash('md5', $salt.'php123'); // password is php123

if (isset($_POST['cancel'])) {
    header("Location: login.php");
    return;
}

$message = false;

if (isset($_POST['email']) && isset($_POST['pass'])) {
    if (strlen($_POST['email']) < 1 || strlen($_POST['pass']) < 1) {
        $message = "Email and password are required";
    } else if (strpos($_POST['email'], '@') === false) {
        $message = "Email must have an at-sign (@)";
    } else {
        $check = hash('md5', $salt.$_POST['pass']);
        if ($check == $stored_hash) {
            $_SESSION['name'] = $_POST['email'];
            error_log("Login success ".$_POST['email']);
            header("Location: autos.php?name=".urlencode($_POST['email']));
            return;
        } else {
            $message = "Incorrect password";
            error_log("Login fail ".$_POST['email']." $check");
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login - Autos Database</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h2>Welcome to Autos Database</h2>
    <?php
    if ($message !== false) {
        echo('<p class="error">'.htmlentities($message)."</p>\n");
    }
    ?>
    <form method="POST">
        <label>Email</label>
        <input type="text" name="email"><br>
        <label>Password</label>
        <input type="password" name="pass"><br>
        <button type="submit" class="btn">Log In</button>
        <button type="submit" name="cancel" class="btn cancel">Cancel</button>
    </form>
</div>
</body>
</html>
