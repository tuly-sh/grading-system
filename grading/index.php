<?php
session_start();
include '../config/db.php';

// Check if the user is logged in and has admin rights
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header('Location: ../auth/login.php');
    exit();
}

// Fetch all grades from the database and group by grade
$query = "SELECT grade, COUNT(*) as count FROM grades GROUP BY grade";
$result = mysqli_query($conn, $query);

// Check for query errors
if (!$result) {
    die("Error fetching data: " . mysqli_error($conn));
}

// Prepare data for the chart
$grades = [];
$gradeCounts = [];

while ($row = mysqli_fetch_assoc($result)) {
    $grades[] = $row['grade'];
    $gradeCounts[] = $row['count'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grading Dashboard</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> <!-- Chart.js Library -->

    <style>
        /* General Styles */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
            color: #343a40;
        }

        .container {
            max-width: 900px;
            margin: 20px auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #007bff;
            margin-bottom: 20px;
        }

        a {
            text-decoration: none;
        }

        /* Buttons */
        .btn {
            display: inline-block;
            padding: 10px 20px;
            font-size: 14px;
            font-weight: bold;
            text-align: center;
            color: #ffffff;
            background-color: #007bff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .btn:hover {
            background-color: #0056b3;
        }

        .btn:active {
            transform: scale(0.98);
        }

        /* Chart Container */
        .chart-container {
            padding: 20px;
            background-color: #f1f1f1;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        /* Table Styles */
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .table th,
        .table td {
            padding: 12px 15px;
            text-align: left;
            border: 1px solid #ddd;
        }

        .table th {
            background-color: #007bff;
            color: #ffffff;
            font-weight: bold;
        }

        .table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .table tr:hover {
            background-color: #f1f1f1;
        }

        .table td a.btn {
            padding: 5px 10px;
            font-size: 12px;
        }

        .table td {
            text-align: center;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .chart-container {
                width: 90%;
            }

            .btn {
                font-size: 12px;
                padding: 8px 15px;
            }

            .table th,
            .table td {
                font-size: 14px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Grading Dashboard</h1>
        <a href="add-modal.php" class="btn">Add New Grade</a>

        <div class="chart-container" style="width: 50%; margin: auto;">
            <canvas id="gradesChart"></canvas>
        </div>

        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Grade</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Reset the result set pointer for rendering the table
                $query = "SELECT * FROM grades";
                $result = mysqli_query($conn, $query);
                if (mysqli_num_rows($result) > 0):
                    while ($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['id']); ?></td>
                            <td><?php echo htmlspecialchars($row['grade']); ?></td>
                            <td>
                                <a href="edit.php?id=<?php echo htmlspecialchars($row['id']); ?>" class="btn">Edit</a>
                                <a href="delete.php?id=<?php echo htmlspecialchars($row['id']); ?>" class="btn" onclick="return confirm('Are you sure you want to delete this grade?');">Delete</a>
                            </td>
                        </tr>
                    <?php endwhile;
                else: ?>
                    <tr>
                        <td colspan="3" style="text-align: center;">No grades found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <script>
        // Pass PHP data to JavaScript
        const grades = <?php echo json_encode($grades); ?>;
        const gradeCounts = <?php echo json_encode($gradeCounts); ?>;

        // Create the Chart.js bar chart
        const ctx = document.getElementById('gradesChart').getContext('2d');
        const gradesChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: grades,
                datasets: [{
                    label: 'Number of Grades',
                    data: gradeCounts,
                    backgroundColor: 'rgba(75, 192, 192, 0.6)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: true
                    },
                    tooltip: {
                        enabled: true
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
</body>
</html>
