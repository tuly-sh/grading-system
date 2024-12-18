<?php
session_start();
include '../config/db.php';

if (!isset($_GET['id'])) {
    header('Location: index.php');
    exit();
}

$transport_id = $_GET['id'];

// Fetch the specific transport record
$query = "SELECT * FROM transport WHERE id = '$transport_id'";
$result = mysqli_query($conn, $query);
$transport = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Transport</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
</head>
<body>
    <div class="container">
        <h1>View Transport</h1>
        <table class="table">
            <tr>
                <th>ID</th>
                <td><?php echo $transport['id']; ?></td>
            </tr>
            <tr>
                <th>Transport Name</th>
                <td><?php echo $transport['transport_name']; ?></td>
            </tr>
            <tr>
                <th>Tracking Number</th>
                <td><?php echo $transport['tracking_number']; ?></td>
            </tr>
        </table>
    </div>
</body>
</html>
