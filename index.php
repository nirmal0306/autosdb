<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
  <title>Nirmal Barot - Autos Database</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      height: 100vh; /* full viewport height */
      display: flex;
      justify-content: center; /* center horizontally */
      align-items: center;     /* center vertically */
      background-color: #f5f5f5;
    }
    .box {
      border: 1px solid blue;
      display: inline-block;
      padding: 40px;
      text-align: center;
      background-color: #fff;
      box-shadow: 0 4px 8px rgba(0,0,0,0.1);
      border-radius: 10px;
    }
    h1 {
      margin-top: 0;
    }
    a {
      color: #1a73e8;
      text-decoration: none;
      font-weight: bold;
    }
    a:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>
  <div class="box">
    <h1>Welcome Nirmal Barot</h1>
    <p><a href="login.php">Please Log In</a></p>
    <p>
      Attempt to go to <a href="autos.php">autos.php</a> without logging in - it should fail with an error message.
    </p>
    <p>
      <a href="http://www.wa4e.com/assn/autosdb/">Specification for this Application</a>
    </p>
  </div>
</body>
</html>
