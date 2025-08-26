<?php
// Database connection settings
$pdo = new PDO('mysql:host=localhost;port=3306;dbname=autosdb', 
   'root', ''); // Change username/password as needed
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
