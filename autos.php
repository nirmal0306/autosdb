<?php
session_start();
require_once "config.php";

// Redirect to login if not logged in
if (!isset($_SESSION['name'])) {
    header("Location: login.php");
    exit;
}

// Default values for sticky form
$make = "";
$year = "";
$mileage = "";

// Add a new auto
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $make = $_POST['make'] ?? "";
    $year = $_POST['year'] ?? "";
    $mileage = $_POST['mileage'] ?? "";

    if (isset($_POST['add'])) {
        if (strlen($make) < 1) {
            $_SESSION['error'] = "Make is required";
        } elseif (!is_numeric($year) || !is_numeric($mileage)) {
            $_SESSION['error'] = "Mileage and year must be numeric";
        } else {
            $stmt = $pdo->prepare(
                'INSERT INTO autos (make, year, mileage) VALUES (:mk, :yr, :mi)'
            );
            $stmt->execute([
                ':mk' => $make,
                ':yr' => $year,
                ':mi' => $mileage
            ]);
            $_SESSION['success'] = "Record inserted";
            header("Location: autos.php");
            exit;
        }
    }

    if (isset($_POST['logout'])) {
        header("Location: logout.php");
        exit;
    }
}

// Fetch autos
$stmt = $pdo->query("SELECT make, year, mileage FROM autos");
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Autos Database - <?= htmlentities($_SESSION['name']) ?></title>
    <link rel="stylesheet" href="style.css">
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; background:#f9f9f9; }
        .container { max-width: 700px; margin: auto; background:white; padding:20px; border-radius:8px; box-shadow:0 2px 6px rgba(0,0,0,0.1);}
        h1 { text-align:center; }
        .msg { color: red; font-weight: bold; }
        .success { color: green; font-weight: bold; }
        .autos-list {
            display: grid;
            grid-template-columns: 1fr 2fr 1fr;
            gap: 10px;
            padding: 10px;
            border-bottom: 1px solid #ccc;
        }
        .autos-header {
            display: grid;
            grid-template-columns: 1fr 2fr 1fr;
            font-weight: bold;
            background: #e3e3e3;
            padding: 10px;
            border-bottom: 2px solid #000;
        }
        .form-control { width: 100%; padding: 8px; margin: 4px 0; }
        .btn { padding: 8px 14px; border:none; border-radius:4px; cursor:pointer; }
        .btn.add { background: #28a745; color:white; }
        .btn.logout { background: #dc3545; color:white; float:right; }
    </style>
</head>
<body>
<div class="container">
    <h1>Tracking Autos for <?= htmlentities($_SESSION['name']); ?></h1>

    <?php
    if (isset($_SESSION['error'])) {
        echo('<p class="msg">'.htmlentities($_SESSION['error'])."</p>\n");
        unset($_SESSION['error']);
    }
    if (isset($_SESSION['success'])) {
        echo('<p class="success">'.htmlentities($_SESSION['success'])."</p>\n");
        unset($_SESSION['success']);
    }
    ?>

    <form method="post">
        <p>Make: <input type="text" name="make" class="form-control" value="<?= htmlentities($make) ?>"></p>
        <p>Year: <input type="text" name="year" class="form-control" value="<?= htmlentities($year) ?>"></p>
        <p>Mileage: <input type="text" name="mileage" class="form-control" value="<?= htmlentities($mileage) ?>"></p>
        <p>
            <button type="submit" name="add" class="btn add">Add</button>
            <button type="submit" name="logout" class="btn logout">Logout</button>
        </p>
    </form>

    <h2>Automobiles</h2>
    <?php if (count($rows) > 0) { ?>
        <div class="autos-header">
            <div>Year</div>
            <div>Make</div>
            <div>Mileage</div>
        </div>
        <?php foreach ($rows as $row) { ?>
            <div class="autos-list">
                <div><?= htmlentities($row['year']) ?></div>
                <div><?= htmlentities($row['make']) ?></div>
                <div><?= htmlentities($row['mileage']) ?></div>
            </div>
        <?php } ?>
    <?php } else { ?>
        <p>No records found</p>
    <?php } ?>
</div>
</body>
</html>
