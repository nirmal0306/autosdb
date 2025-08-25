<?php
session_start();
require_once "config.php";

if (!isset($_SESSION['name'])) {
    die('ACCESS DENIED');
}

if (isset($_POST['logout'])) {
    header("Location: logout.php");
    return;
}

// Add a new auto
if (isset($_POST['make']) && isset($_POST['year']) && isset($_POST['mileage'])) {
    if (strlen($_POST['make']) < 1) {
        $_SESSION['error'] = "Make is required";
    } elseif (!is_numeric($_POST['year']) || !is_numeric($_POST['mileage'])) {
        $_SESSION['error'] = "Mileage and year must be numeric";
    } else {
        $stmt = $pdo->prepare('INSERT INTO autos (make, year, mileage) VALUES (:mk, :yr, :mi)');
        $stmt->execute([
            ':mk' => $_POST['make'],
            ':yr' => $_POST['year'],
            ':mi' => $_POST['mileage']
        ]);
        $_SESSION['success'] = "Record inserted";
    }
    header("Location: autos.php");
    return;
}

// Fetch autos
$rows = $pdo->query("SELECT make, year, mileage FROM autos");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Autos Database</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h2>Tracking Autos for <?= htmlentities($_SESSION['name']); ?></h2>
    <?php
    if (isset($_SESSION['error'])) {
        echo '<p class="error">'.htmlentities($_SESSION['error'])."</p>\n";
        unset($_SESSION['error']);
    }
    if (isset($_SESSION['success'])) {
        echo '<p class="success">'.htmlentities($_SESSION['success'])."</p>\n";
        unset($_SESSION['success']);
    }
    ?>
    <form method="post">
        <label for="make">Make:</label>
        <input type="text" name="make" id="make"><br>
        <label for="year">Year:</label>
        <input type="text" name="year" id="year"><br>
        <label for="mileage">Mileage:</label>
        <input type="text" name="mileage" id="mileage"><br>
        <button type="submit" class="btn">Add</button>
        <button type="submit" name="logout" class="btn cancel">Logout</button>
    </form>
    <h3>Automobiles</h3>
    <table>
        <tr><th>Make</th><th>Year</th><th>Mileage</th></tr>
        <?php
        foreach ($rows as $row) {
            echo "<tr><td>".htmlentities($row['make'])."</td>";
            echo "<td>".htmlentities($row['year'])."</td>";
            echo "<td>".htmlentities($row['mileage'])."</td></tr>";
        }
        ?>
    </table>
</div>
</body>
</html>
