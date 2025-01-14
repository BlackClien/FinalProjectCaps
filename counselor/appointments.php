<?php
require '../includes/auth.php';
require '../includes/db.php';
require '../includes/functions.php';

if (!isCounselor()) {
    header("Location: ../index.php");
    exit();
}

$appointments = $conn->query("SELECT * FROM appointments ORDER BY appointment_date ASC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointments</title>
    <link rel="stylesheet" href="../styles.css">
</head>
<style>
        .btn {
            display: inline-block;
            margin-top: 20px;
            margin-left: 10px;
            padding: 10px 20px;
            background-color:rgb(36, 145, 223); /* Red button */
            color: white;
            border: none;
            cursor: pointer;
            text-decoration: none;
            border-radius: 5px;
        }
    </style>
<body>
    <h1>Appointments</h1>
    <a href="add_appointment.php" class="btn">+Add Appointment</a>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Student</th>
                <th>Date</th>
                <th>Time</th>
                <th>Reason</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $appointments->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['appointment_id']; ?></td>
                    <td><?= $row['student_id']; ?></td>
                    <td><?= $row['appointment_date']; ?></td>
                    <td><?= $row['appointment_time']; ?></td>
                    <td><?= $row['reason']; ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</body>
</html>
