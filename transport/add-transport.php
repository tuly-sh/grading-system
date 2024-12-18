<?php
session_start();
include '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $transport_name = mysqli_real_escape_string($conn, $_POST['transport_name']);
    $tracking_number = mysqli_real_escape_string($conn, $_POST['tracking_number']);
    
    $query = "INSERT INTO transport (transport_name, tracking_number) VALUES ('$transport_name', '$tracking_number')";
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
    <title>Add Transport</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
</head>
<body>
    <div class="container">
        <h1>Add New Transport</h1>
        <?php if (isset($error_msg)) { echo "<div class='error-msg'>$error_msg</div>"; } ?>
        <form action="add-transport.php" method="POST">
            <input type="text" name="transport_name" placeholder="Enter transport name" required>
            <input type="text" name="tracking_number" placeholder="Enter tracking number" required>
            <button type="submit" class="btn">Add Transport</button>
        </form>
    </div>
</body>
</html>
