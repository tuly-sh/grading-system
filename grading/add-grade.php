<?php
session_start();
include '../config/db.php';

$error_msg = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['grade']) && !empty(trim($_POST['grade']))) {
        $grade = mysqli_real_escape_string($conn, trim($_POST['grade']));
        
        if ($conn) {
            $query = "INSERT INTO grades (grade) VALUES ('$grade')";
            if (mysqli_query($conn, $query)) {
                header('Location: index.php');
                exit();
            } else {
                $error_msg = "Error: " . mysqli_error($conn);
            }
        } else {
            $error_msg = "Database connection error.";
        }
    } else {
        $error_msg = "Grade name cannot be empty.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Grade</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
    
</head>
<body>
    <div class="container">
        <h1>Add New Grade</h1>
        <?php if ($error_msg): ?>
            <div class="error-msg"><?= htmlspecialchars($error_msg) ?></div>
        <?php endif; ?>
        <form action="add-grade.php" method="POST">
            <input type="text" name="grade" placeholder="Enter grade name" required>
            <button type="submit" class="btn">Add Grade</button>
        </form>
    </div>
</body>
</html>
