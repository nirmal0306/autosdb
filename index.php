<?php
session_start();

// If already logged in, go to autos.php
if (isset($_SESSION['name'])) {
    header("Location: autos.php");
    return;
}

// Otherwise go to login
header("Location: login.php");
return;
