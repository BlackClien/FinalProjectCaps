<?php
require '../includes/auth.php';
require '../includes/db.php';

if (!isAdmin()) {
    header("Location: ../index.php");
    exit();
}

$id = $_GET['id'] ?? null;
if ($id) {
    $stmt = $conn->prepare("DELETE FROM counselors WHERE counselor_id = ?");
    $stmt->bind_param('i', $id);
    $stmt->execute();
}

header("Location: counselors.php");
?>
