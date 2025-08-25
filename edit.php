<?php
require_once "config.php";
session_start();

if (!isset($_SESSION['name'])) {
    die("ACCESS DENIED");
}

if (!isset($_GET['autos_id'])) {
    $_SESSION['error'] = "Missing autos_id";
    header("Location: autos.php");
    return;
}

if (isset($_POST['make']) && isset($_POST['model']) 
    && isset($_POST['year']) && isset($_POST['mileage'])) {
    
    $stmt = $pdo->prepare("UPDATE autos SET make=:mk, model=:md, year=:yr, mileage=:mi
                           WHERE autos_id=:id");
    $stmt->execute([
        ':mk' => $_POST['make'],
        ':md' => $_POST['model'],
        ':yr' => $_POST['year'],
        ':mi' => $_POST['mileage'],
        ':id' => $_GET['autos_id']
    ]);
    $_SESSION['success'] = "Record updated";
    header("Location: autos.php");
    return;
}

$stmt = $pdo->prepare("SELECT * FROM autos WHERE autos_id=:id");
$stmt->execute([':id' => $_GET['autos_id']]);
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if ($row === false) {
    $_SESSION['error'] = "Bad value for autos_id";
    header("Location: autos.php");
    return;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Automobile</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<h2>Edit Automobile</h2>
<form method="post">
    <p>Make: <input type="text" name="make" value="<?= htmlentities($row['make']) ?>"></p>
    <p>Model: <input type="text" name="model" value="<?= htmlentities($row['model']) ?>"></p>
    <p>Year: <input type="text" name="year" value="<?= htmlentities($row['year']) ?>"></p>
    <p>Mileage: <input type="text" name="mileage" value="<?= htmlentities($row['mileage']) ?>"></p>
    <p><input type="submit" value="Save">
       <a href="autos.php">Cancel</a></p>
</form>
</body>
</html>
