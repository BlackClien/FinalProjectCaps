<?php
require '../includes/auth.php';
require '../includes/db.php';
require '../includes/functions.php';
check_counselor();

$students = $conn->query("SELECT * FROM students");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Counselor - Students</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="container">
        <h1>Students List</h1>

         <!-- Add Student Button -->
         <a href="add_student.php" class="btn-add">Add Student</a>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Age</th>
                    <th>Gender</th>
                    <th>Email</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($student = $students->fetch_assoc()): ?>
                <tr>
                    <td><?= $student['student_id'] ?></td>
                    <td><?= htmlspecialchars($student['student_name']) ?></td>
                    <td><?= $student['age'] ?></td>
                    <td><?= $student['gender'] ?></td>
                    <td><?= htmlspecialchars($student['email']) ?></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
