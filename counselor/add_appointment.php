<?php
require '../includes/auth.php';
require '../includes/db.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Debug: Check session data
if (!isset($_SESSION['user_id']) && !isset($_SESSION['counselor_id'])) {
    error_log("Session Data: " . print_r($_SESSION, true));
    die("Error: Counselor ID is not set in the session. Please log in again.");
}
$counselor_id = $_SESSION['user_id'] ?? $_SESSION['counselor_id'];

// Start the session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Ensure the user is logged in as a counselor
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'counselor') {
    die("Error: Counselor ID is not set in the session. Please log in again.");
}

$counselor_id = $_SESSION['user']['id']; // Retrieve the counselor ID from the session

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $student_id = $_POST['student_id'];
    $counselor_id = $_POST['counselor_id'];
    $appointment_date = $_POST['appointment_date'];
    $appointment_time = $_POST['appointment_time'];
    $reason = $_POST['reason'];

    $stmt = $conn->prepare("INSERT INTO appointments (student_id, counselor_id, appointment_date, appointment_time, reason) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param('iisss', $student_id, $counselor_id, $appointment_date, $appointment_time, $reason);

    if ($stmt->execute()) {
        header("Location: appointments.php");
        exit();
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
    <title>Add Appointment</title>
    <link rel="stylesheet" href="../styles.css">
</head>
<body>
    <h1>Add Appointment</h1>
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
        <label>Date:</label>
        <input type="date" name="appointment_date" required>
        <label>Time:</label>
        <input type="time" name="appointment_time" required>
        <label>Reason:</label>
        <textarea name="reason" required></textarea>
        <button type="submit">Add Appointment</button>
    </form>
</body>
</html>
