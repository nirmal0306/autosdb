<?php
require_once "config.php";
session_start();

if (!isset($_SESSION['name'])) {
    die("ACCESS DENIED");
}

if (isset($_POST['delete']) && isset($_POST['auto_id'])) {
    $stmt = $pdo->prepare("DELETE FROM autos WHERE auto_id = :id");
    $stmt->execute([':id' => $_POST['auto_id']]);
    $_SESSION['success'] = "Record deleted";
    header("Location: autos.php");
    return;
}

if (!isset($_GET['auto_id'])) {
    $_SESSION['error'] = "Missing auto_id";
    header("Location: autos.php");
    return;
}

$stmt = $pdo->prepare("SELECT make, year, mileage, auto_id FROM autos WHERE auto_id = :id");
$stmt->execute([':id' => $_GET['auto_id']]);
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if ($row === false) {
    $_SESSION['error'] = "Bad value for auto_id";
    header("Location: autos.php");
    return;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Delete Automobile</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<h2>Confirm: Deleting <?= htmlentities($row['make']) ?> (Year <?= htmlentities($row['year']) ?>)</h2>
<form method="post">
    <input type="hidden" name="auto_id" value="<?= $row['auto_id'] ?>">
    <p><input type="submit" name="delete" value="Delete">
       <a href="autos.php">Cancel</a></p>
</form>
</body>
</html>
