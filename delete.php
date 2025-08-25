<?php
require_once "config.php";
session_start();

if (!isset($_SESSION['name'])) {
    die("ACCESS DENIED");
}

if (isset($_POST['delete']) && isset($_POST['autos_id'])) {
    $stmt = $pdo->prepare("DELETE FROM autos WHERE autos_id=:id");
    $stmt->execute([':id' => $_POST['autos_id']]);
    $_SESSION['success'] = "Record deleted";
    header("Location: autos.php");
    return;
}

$stmt = $pdo->prepare("SELECT make, model, autos_id FROM autos WHERE autos_id=:id");
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
    <title>Delete Automobile</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<h2>Confirm: Deleting <?= htmlentities($row['make']) ?> <?= htmlentities($row['model']) ?></h2>
<form method="post">
    <input type="hidden" name="autos_id" value="<?= $row['autos_id'] ?>">
    <p><input type="submit" name="delete" value="Delete">
       <a href="autos.php">Cancel</a></p>
</form>
</body>
</html>
