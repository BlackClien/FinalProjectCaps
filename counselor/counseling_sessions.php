<?php
require '../includes/auth.php';
require '../includes/db.php';

if (!isCounselor()) {
    header("Location: ../index.php");
    exit();
}

$sessions = $conn->query("SELECT * FROM counseling_sessions ORDER BY session_id ASC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Counseling Sessions</title>
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
    <h1>Counseling Sessions</h1>
    <a href="add_counseling_session.php" class="btn">+Add Counseling Session</a>
    <table>
        <thead>
            <tr>
                <th>Counseling ID</th>
                <th>Student ID</th>
                <th>Session Date</th>
                <th>Notes</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $sessions->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['session_id']; ?></td>
                    <td><?= $row['student_id']; ?></td>
                    <td><?= $row['session_date']; ?></td>
                    <td><?= $row['session_notes']; ?></td> <!-- Changed from 'notes' to 'session_notes' -->
                    <td>
                        <a href="edit_counseling_session.php?id=<?= $row['session_id']; ?>">Edit</a>
                        <a href="delete_counseling_session.php?id=<?= $row['session_id']; ?>" onclick="return confirm('Are you sure?');">Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</body>
</html>
