<?php
require '../includes/auth.php';
require '../includes/db.php';

if (!isCounselor()) {
    header("Location: ../index.php");
    exit();
}

$students = $db->query("SELECT * FROM students")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>View Students</title>
    <link rel="stylesheet" href="../styles.css">
</head>
<body>
    <?php include '../includes/navbar.php'; ?>
    <div class="content">
        <h1>View Students</h1>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Age</th>
                    <th>Gender</th>
                    <th>Email</th>
                    <th>Parent Name</th>
                    <th>Parent Contact</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($students as $student): ?>
                    <tr>
                        <td><?= $student['student_id']; ?></td>
                        <td><?= $student['student_name']; ?></td>
                        <td><?= $student['age']; ?></td>
                        <td><?= $student['gender']; ?></td>
                        <td><?= $student['email']; ?></td>
                        <td><?= $student['parent_name']; ?></td>
                        <td><?= $student['parent_contact_number']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
