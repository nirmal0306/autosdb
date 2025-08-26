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

// Fetch autos (with auto_id!)
$stmt = $pdo->query("SELECT auto_id, make, year, mileage FROM autos");
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Autos Database - <?= htmlentities($_SESSION['name']) ?></title>
    <link rel="stylesheet" href="style.css">
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; background:#f9f9f9; }
        .container { max-width: 1000px; margin: auto; background:white; padding:20px; border-radius:8px; box-shadow:0 2px 6px rgba(0,0,0,0.1);}
        h1 { text-align:center; }
        .msg { color: red; font-weight: bold; }
        .success { color: green; font-weight: bold; }
        .autos-list {
            display: grid;
            grid-template-columns: 1fr 2fr 1fr 1fr;
            gap: 10px;
            padding: 10px;
            border-bottom: 1px solid #ccc;
            align-items:center;
        }
        .autos-header {
            display: grid;
            grid-template-columns: 1fr 2fr 1fr 1fr;
            font-weight: bold;
            background: #e3e3e3;
            padding: 10px;
            border-bottom: 2px solid #000;
        }
        .form-control { width: 98%; padding: 8px; margin: 4px 0; }
        .btn { padding: 8px 14px; border:none; border-radius:4px; cursor:pointer; }
        .btn.add { background: #28a745; color:white; }
        .btn.logout { background: #dc3545; color:white; float:right; }
        .action-btn { margin-right:8px; }
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
            <div>Actions</div>
        </div>
        <?php foreach ($rows as $row) { ?>
            <div class="autos-list">
                <div><?= htmlentities($row['year']) ?></div>
                <div><?= htmlentities($row['make']) ?></div>
                <div><?= htmlentities($row['mileage']) ?></div>
                <div>
                    <a class="action-btn" href="edit.php?auto_id=<?= $row['auto_id'] ?>"><svg fill="#000000" width="24px" height="24px" viewBox="0 0 24 24" id="edit" data-name="Flat Color" xmlns="http://www.w3.org/2000/svg" class="icon flat-color"><path id="secondary" d="M21,22H3a1,1,0,0,1,0-2H21a1,1,0,0,1,0,2Z" style="fill: rgb(44, 169, 188);"></path><path id="primary" d="M20.71,3.29a2.93,2.93,0,0,0-2.2-.84,3.25,3.25,0,0,0-2.17,1L7.46,12.29a1.16,1.16,0,0,0-.25.43L6,16.72A1,1,0,0,0,7,18a.9.9,0,0,0,.28,0l4-1.17a1.16,1.16,0,0,0,.43-.25l8.87-8.88a3.25,3.25,0,0,0,1-2.17A2.91,2.91,0,0,0,20.71,3.29Z" style="fill: rgb(0, 0, 0);"></path></svg></a>
                    <a class="action-btn" href="delete.php?auto_id=<?= $row['auto_id'] ?>"><svg width="24px" height="24px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M7 4a2 2 0 0 1 2-2h6a2 2 0 0 1 2 2v2h4a1 1 0 1 1 0 2h-1.069l-.867 12.142A2 2 0 0 1 17.069 22H6.93a2 2 0 0 1-1.995-1.858L4.07 8H3a1 1 0 0 1 0-2h4V4zm2 2h6V4H9v2zM6.074 8l.857 12H17.07l.857-12H6.074zM10 10a1 1 0 0 1 1 1v6a1 1 0 1 1-2 0v-6a1 1 0 0 1 1-1zm4 0a1 1 0 0 1 1 1v6a1 1 0 1 1-2 0v-6a1 1 0 0 1 1-1z" fill="#0D0D0D"/></svg></a>
                </div>
            </div>
        <?php } ?>
    <?php } else { ?>
        <p>No records found</p>
    <?php } ?>
</div>
</body>
</html>
