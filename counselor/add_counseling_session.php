<?php
require '../includes/auth.php';
require '../includes/db.php';

if (!isCounselor()) {
    header("Location: ../index.php");
    exit();
}

$counselor_id = $_SESSION['user_id']; // Get the logged-in counselor's ID

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $student_id = $_POST['student_id'];
    $session_date = $_POST['session_date'];
    $notes = $_POST['notes'];

    // Check if the counselor ID exists in the counselors table
    $stmt = $conn->prepare("SELECT counselor_id FROM counselors WHERE counselor_id = ?");
    $stmt->bind_param('i', $counselor_id);
    $stmt->execute();
    $stmt->store_result();
    
    // If no counselor with that ID exists, we throw an error.
    if ($stmt->num_rows === 0) {
        echo "Error: Counselor ID not found.";
        exit();
    }

    // Proceed with the insert now that counselor_id is validated
    $stmt = $conn->prepare("INSERT INTO counseling_sessions (student_id, counselor_id, session_date, session_notes) VALUES (?, ?, ?, ?)");
    $stmt->bind_param('iiss', $student_id, $counselor_id, $session_date, $notes);

    if ($stmt->execute()) {
        header("Location: counseling_sessions.php");
    } else {
        echo "Error: " . $conn->error;
    }
}

$students = $conn->query("SELECT * FROM students");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Counseling Session</title>
    <link rel="stylesheet" href="../styles.css">
</head>
<body>
    <h1>Add Counseling Session</h1>
    <form method="POST">
        <label>Student:</label>
        <select name="student_id" required>
            <option value="">Select Student</option>
            <?php while ($row = $students->fetch_assoc()): ?>
                <option value="<?= htmlspecialchars($row['student_id']); ?>">
                    <?= htmlspecialchars($row['student_name']); ?>
                </option>
            <?php endwhile; ?>
        </select>
        <label>Session Date:</label>
        <input type="date" name="session_date" required>
        <label>Notes:</label>
        <textarea name="notes" required></textarea>
        <button type="submit">Add Session</button>
    </form>
</body>
</html>
