<?php
require '../includes/auth.php';
require '../includes/db.php';

if (isset($_POST['session_id'])) {
    $session_id = $_POST['session_id'];

    // Prepare and execute the deletion query
    $stmt = $conn->prepare("DELETE FROM counseling_sessions WHERE session_id = ?");
    $stmt->bind_param('i', $session_id);

    if ($stmt->execute()) {
        // Redirect back to the counseling_sessions page after deletion
        header("Location: counseling_sessions.php");
        exit();
    } else {
        echo "Error: " . $conn->error;  // Output error message if deletion fails
    }
} else {
    header("Location: counseling_sessions.php");
    exit();
}

?>
