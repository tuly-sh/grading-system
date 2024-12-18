<?php
session_start();
include '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $package_name = mysqli_real_escape_string($conn, $_POST['package_name']);
    
    $query = "INSERT INTO packages (package_name) VALUES ('$package_name')";
    if (mysqli_query($conn, $query)) {
        header('Location: index.php');
        exit();
    } else {
        $error_msg = "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Package</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
</head>
<body>
    <div class="container">
        <h1>Add New Package</h1>
        <?php if (isset($error_msg)) { echo "<div class='error-msg'>$error_msg</div>"; } ?>
        <form action="add-package.php" method="POST">
            <input type="text" name="package_name" placeholder="Enter package name" required>
            <button type="submit" class="btn">Add Package</button>
        </form>
    </div>
</body>
</html>
