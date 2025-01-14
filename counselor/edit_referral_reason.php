<?php
require '../includes/auth.php';
require '../includes/db.php';

if (!isCounselor()) {
    header("Location: ../index.php");
    exit();
}

$id = $_GET['id'] ?? null;
if (!$id) {
    header("Location: referral_reasons.php");
    exit();
}

$reason = $conn->query("SELECT * FROM referral_reasons WHERE reason_id = $id")->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $new_reason = $_POST['reason'];

    $stmt = $conn->prepare("UPDATE referral_reasons SET reason = ? WHERE reason_id = ?");
    $stmt->bind_param('si', $new_reason, $id);

    if ($stmt->execute()) {
        header("Location: referral_reasons.php");
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
    <title>Edit Referral Reason</title>
    <link rel="stylesheet" href="../styles.css">
</head>
<body>
    <h1>Edit Referral Reason</h1>
    <form method="POST">
        <label>Reason:</label>
        <textarea name="reason" required><?= $reason['reason']; ?></textarea>
        <button type="submit">Update Reason</button>
    </form>
</body>
</html>
