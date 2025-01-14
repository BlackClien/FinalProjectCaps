<?php
require '../includes/auth.php';
require '../includes/db.php';

if (!isCounselor()) {
    header("Location: ../index.php");
    exit();
}

$query = "
    SELECT rr.reason_id, rr.reason_description, s.student_name 
    FROM referral_reasons rr
    JOIN students s ON rr.student_id = s.student_id
    ORDER BY rr.reason_id ASC
";
$reasons = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Referral Reasons</title>
    <link rel="stylesheet" href="../styles.css">
</head>
<style>
    .btn {
        display: inline-block;
        margin-top: 20px;
        margin-left: 10px;
        padding: 10px 20px;
        background-color: rgb(36, 145, 223);
        color: white;
        border: none;
        cursor: pointer;
        text-decoration: none;
        border-radius: 5px;
    }
</style>
<body>
    <h1>Referral Reasons</h1>
    <a href="add_referral_reason.php" class="btn">+Add Referral Reason</a>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Student Name</th>
                <th>Reason</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $reasons->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['reason_id']; ?></td>
                    <td><?= $row['student_name']; ?></td>
                    <td><?= $row['reason_description']; ?></td>
                    <td>
                        <a href="edit_referral_reason.php?id=<?= $row['reason_id']; ?>">Edit</a>
                        <a href="delete_referral_reason.php?id=<?= $row['reason_id']; ?>" onclick="return confirm('Are you sure?');">Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</body>
</html>
