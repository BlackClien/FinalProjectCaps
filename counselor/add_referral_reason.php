<?php
require '../includes/auth.php';
require '../includes/db.php';


if (!isCounselor()) {
    header("Location: ../index.php");
    exit();
}

// Check if the counselor_id is set in the session
if (isset($_SESSION['user']['counselor_id'])) {
    $counselor_id = $_SESSION['user']['counselor_id'];
} else {
    echo "Error: Counselor ID not found in session. Please log in again.";
    exit();
}

// Fetch students for the dropdown
$students = $conn->query("SELECT student_id, student_name FROM students");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $student_id = $_POST['student_id'];
    $reason = $_POST['reason'];

    // Insert into referral_reasons
    $stmt = $conn->prepare("INSERT INTO referral_reasons (student_id, counselor_id, reason_description) VALUES (?, ?, ?)");
    $stmt->bind_param('iis', $student_id, $counselor_id, $reason);

    if ($stmt->execute()) {
        header("Location: referral_reasons.php");
        exit();
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
    <title>Add Referral Reason</title>
    <link rel="stylesheet" href="../styles.css">
</head>
<body>
    <h1>Add Referral Reason</h1>
    <form method="POST">
        <label for="student_id">Student Name:</label>
        <select name="student_id" id="student_id" required>
            <option value="">Select a student</option>
            <?php while ($row = $students->fetch_assoc()): ?>
                <option value="<?= $row['student_id']; ?>"><?= $row['student_name']; ?></option>
            <?php endwhile; ?>
        </select>
        <br><br>
        <label for="reason">Reason:</label>
        <textarea name="reason" id="reason" required></textarea>
        <br><br>
        <button type="submit">Add Reason</button>
    </form>
</body>
</html>
