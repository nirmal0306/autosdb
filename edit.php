<?php
require_once "config.php";
session_start();

if (!isset($_SESSION['name'])) {
    die("ACCESS DENIED");
}

if (!isset($_GET['auto_id'])) {
    $_SESSION['error'] = "Missing auto_id";
    header("Location: autos.php");
    return;
}

if (isset($_POST['make']) && isset($_POST['year']) && isset($_POST['mileage'])) {
    $stmt = $pdo->prepare("UPDATE autos 
                           SET make = :mk, year = :yr, mileage = :mi
                           WHERE auto_id = :id");
    $stmt->execute([
        ':mk' => $_POST['make'],
        ':yr' => $_POST['year'],
        ':mi' => $_POST['mileage'],
        ':id' => $_GET['auto_id']
    ]);
    $_SESSION['success'] = "Record updated";
    header("Location: autos.php");
    return;
}

$stmt = $pdo->prepare("SELECT * FROM autos WHERE auto_id = :id");
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
    <title>Edit Automobile</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; background:#f9f9f9; }
        .container { max-width: 600px; margin: auto; background:white; padding:20px; border-radius:8px; box-shadow:0 2px 6px rgba(0,0,0,0.1);}
        h2 { text-align:center; }
        .form-group { margin-bottom: 15px; }
        .form-label { display:block; font-weight:bold; margin-bottom:5px; }
        .form-control { width: 100%; padding: 8px; border:1px solid #ccc; border-radius:4px; }
        .btn { padding: 8px 14px; border:none; border-radius:4px; cursor:pointer; }
        .btn.save { background: #28a745; color:white; }
        .btn.cancel { background: #dc3545; color:white; text-decoration:none; padding:8px 14px; border-radius:4px}
        .btn.cancel:hover { background:#5a6268; }
    </style>
</head>
<body>
<div class="container">
    <h2>Edit Automobile</h2>
    <form method="post" class="edit-form">
        <div class="form-group">
            <label class="form-label">Make:</label>
            <input type="text" name="make" class="form-control" value="<?= htmlentities($row['make']) ?>">
        </div>
        <div class="form-group">
            <label class="form-label">Year:</label>
            <input type="text" name="year" class="form-control" value="<?= htmlentities($row['year']) ?>">
        </div>
        <div class="form-group">
            <label class="form-label">Mileage:</label>
            <input type="text" name="mileage" class="form-control" value="<?= htmlentities($row['mileage']) ?>">
        </div>
        <div class="form-actions">
            <input type="submit" value="Save" class="btn save">
            <a href="autos.php" class="btn cancel">Cancel</a>
        </div>
    </form>
</div>
</body>
</html>
