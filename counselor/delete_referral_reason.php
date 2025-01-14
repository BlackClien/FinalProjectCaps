<?php
require '../includes/auth.php';
require '../includes/db.php';

if (!isCounselor()) {
    header("Location: ../index.php");
    exit();
}

$id = $_GET['id'] ?? null;

if ($id) {
    $stmt = $conn->prepare("DELETE FROM referral_reasons WHERE reason_id = ?");
    $stmt->bind_param('i', $id);

    if ($stmt->execute()) {
        header("Location: referral_reasons.php");
    } else {
        echo "Error: " . $conn->error;
    }
} else {
    header("Location: referral_reasons.php");
}
?>
