<?php
require_once "config.php";
session_start();

if (!isset($_SESSION['name'])) {
    die("ACCESS DENIED");
}

if (isset($_POST['make']) && isset($_POST['model']) 
    && isset($_POST['year']) && isset($_POST['mileage'])) {
    
    if (strlen($_POST['make']) < 1 || strlen($_POST['model']) < 1) {
        $_SESSION['error'] = "Make and Model are required";
        header("Location: add.php");
        return;
    }

    if (!is_numeric($_POST['year']) || !is_numeric($_POST['mileage'])) {
        $_SESSION['error'] = "Year and Mileage must be numeric";
        header("Location: add.php");
        return;
    }

    $stmt = $pdo->prepare("INSERT INTO autos (make, model, year, mileage) 
                           VALUES (:mk, :md, :yr, :mi)");
    $stmt->execute([
        ':mk' => $_POST['make'],
        ':md' => $_POST['model'],
        ':yr' => $_POST['year'],
        ':mi' => $_POST['mileage']
    ]);
    $_SESSION['success'] = "Record added";
    header("Location: autos.php");
    return;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Add Automobile</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<h2>Add Automobile</h2>
<?php
if (isset($_SESSION['error'])) {
    echo "<p class='error'>" . $_SESSION['error'] . "</p>";
    unset($_SESSION['error']);
}
?>
<form method="post">
    <p>Make: <input type="text" name="make"></p>
    <p>Model: <input type="text" name="model"></p>
    <p>Year: <input type="text" name="year"></p>
    <p>Mileage: <input type="text" name="mileage"></p>
    <p><input type="submit" value="Add">
       <a href="autos.php">Cancel</a></p>
</form>
</body>
</html>
