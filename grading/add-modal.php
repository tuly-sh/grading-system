<?php
session_start();
include '../config/db.php';

$error_msg = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['grade']) && !empty(trim($_POST['grade']))) {
        $grade = mysqli_real_escape_string($conn, trim($_POST['grade']));
        
        $query = "INSERT INTO grades (grade) VALUES ('$grade')";
        if (mysqli_query($conn, $query)) {
            header('Location: index.php');
            exit();
        } else {
            $error_msg = "Error: " . mysqli_error($conn);
        }
    } else {
        $error_msg = "Grade cannot be empty.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Grade</title>
    <style>
        /* General Styles */
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fa;
            color: #212529;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        /* Modal Container */
        .modal {
            max-width: 500px;
            background: #ffffff;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
            text-align: center;
        }

        /* Heading Styles */
        .modal h2 {
            font-size: 1.8rem;
            font-weight: bold;
            margin-bottom: 20px;
            color: #333;
        }

        /* Error Message Styles */
        .error-msg {
            color: #d9534f;
            margin-bottom: 15px;
            font-size: 0.9rem;
        }

        /* Form Styles */
        form {
            display: flex;
            flex-direction: column;
            gap: 15px;
            align-items: stretch; /* Ensure form elements are full width */
        }

        form input[type="text"] {
            padding: 12px 16px;
            font-size: 1rem;
            border: 1px solid #ddd;
            border-radius: 5px;
            outline: none;
            transition: all 0.3s ease;
        }

        form input[type="text"]:focus {
            border-color: #007bff;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
        }

        /* Button Styles */
        form .btn {
            padding: 12px 16px;
            font-size: 1rem;
            font-weight: 500;
            color: #ffffff;
            background-color: #007bff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        form .btn:hover {
            background-color: #0056b3;
        }

        /* Responsive Styles */
        @media (max-width: 768px) {
            .modal {
                max-width: 90%; /* Adjust modal width for smaller screens */
                padding: 20px;
            }

            form input[type="text"],
            form .btn {
                font-size: 0.9rem;
                padding: 10px 14px;
            }
        }
    </style>
</head>
<body>
    <div class="modal">
        <h2>Add New Grade</h2>
        <?php if ($error_msg): ?>
            <div class="error-msg"><?= htmlspecialchars($error_msg) ?></div>
        <?php endif; ?>
        <form action="add-grade.php" method="POST">
            <input type="text" name="grade" placeholder="Enter grade" required>
            <button type="submit" class="btn">Add Grade</button>
        </form>
    </div>
</body>
</html>
