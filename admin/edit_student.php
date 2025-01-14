<?php
require '../includes/auth.php';
require '../includes/db.php';

if (!isAdmin()) {
    header("Location: ../index.php");
    exit();
}

$id = $_GET['id'] ?? null;
if (!$id) {
    header("Location: students.php");
    exit();
}

$student = $conn->query("SELECT * FROM students WHERE student_id = $id")->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $course = $_POST['course'];

    $stmt = $conn->prepare("UPDATE students SET name = ?, email = ?, course = ? WHERE student_id = ?");
    $stmt->bind_param('sssi', $name, $email, $course, $id);

    if ($stmt->execute()) {
        header("Location: students.php");
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Student</title>
    <link rel="stylesheet" href="../styles.css">
</head>
<body>
    <h1>Edit Student</h1>
    <form method="POST">
        <label>Name:</label>
        <input type="text" name="name" value="<?= $student['name']; ?>" required>
        <label>Email:</label>
        <input type="email" name="email" value="<?= $student['email']; ?>" required>
        <label>Course:</label>
        <input type="text" name="course" value="<?= $student['course']; ?>" required>
        <button type="submit">Update Student</button>
    </form>
</body>
</html>
