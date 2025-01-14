<?php
require '../includes/auth.php';
require '../includes/db.php';

if (!isCounselor()) {
    header("Location: ../index.php");
    exit();
}

$id = $_GET['id'] ?? null;
if (!$id) {
    header("Location: counseling_sessions.php");
    exit();
}

$session = $conn->query("SELECT * FROM counseling_sessions WHERE session_id = $id")->fetch_assoc();
$students = $conn->query("SELECT * FROM students");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $student_id = $_POST['student_id'];
    $session_date = $_POST['session_date'];
    $notes = $_POST['notes'];

    // Change 'notes' to 'session_notes' here
    $stmt = $conn->prepare("UPDATE counseling_sessions SET student_id = ?, session_date = ?, session_notes = ? WHERE session_id = ?");
    $stmt->bind_param('issi', $student_id, $session_date, $notes, $id);

    if ($stmt->execute()) {
        header("Location: counseling_sessions.php");
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
    <title>Edit Counseling Session</title>
    <link rel="stylesheet" href="../styles.css">
</head>
<body>
    <h1>Edit Counseling Session</h1>
    <form method="POST">
        <label>Student:</label>
        <select name="student_id" required>
            <?php while ($row = $students->fetch_assoc()): ?>
                <option value="<?= $row['student_id']; ?>" <?= $row['student_id'] == $session['student_id'] ? 'selected' : ''; ?>>
                    <?= $row['student_name']; ?> <!-- Use the correct column name here -->
                </option>
            <?php endwhile; ?>
        </select>
        <label>Session Date:</label>
        <input type="date" name="session_date" value="<?= $session['session_date']; ?>" required>
        <label>Notes:</label>
        <textarea name="notes" required><?= $session['session_notes']; ?></textarea> <!-- Change 'notes' to 'session_notes' here -->
        <button type="submit">Update Session</button>
    </form>
</body>
</html>
