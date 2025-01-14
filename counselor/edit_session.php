<?php
require '../includes/auth.php';
require '../includes/db.php';

if (!isCounselor()) {
    header("Location: ../index.php");
    exit();
}

$session_id = $_GET['id'];
$session = $db->prepare("SELECT * FROM sessions WHERE session_id = ?");
$session->execute([$session_id]);
$session = $session->fetch(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $student_id = $_POST['student_id'];
    $session_date = $_POST['session_date'];
    $remarks = $_POST['remarks'];

    $db->prepare("UPDATE sessions SET student_id = ?, session_date = ?, remarks = ? WHERE session_id = ?")
       ->execute([$student_id, $session_date, $remarks, $session_id]);

    header("Location: sessions.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Edit Counseling Session</title>
    <link rel="stylesheet" href="../styles.css">
</head>
<body>
    <?php include '../includes/navbar.php'; ?>
    <div class="content">
        <h1>Edit Counseling Session</h1>
        <form method="POST">
            <select name="student_id" required>
                <option value="">Select Student</option>
                <?php
                $students = $db->query("SELECT * FROM students")->fetchAll(PDO::FETCH_ASSOC);
                foreach ($students as $student): ?>
                    <option value="<?= $student['student_id']; ?>" <?= $session['student_id'] == $student['student_id'] ? 'selected' : ''; ?>>
                        <?= $student['student_name']; ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <input type="date" name="session_date" value="<?= $session['session_date']; ?>" required>
            <textarea name="remarks" required><?= $session['remarks']; ?></textarea>
            <button type="submit">Update Session</button>
        </form>
    </div>
</body>
</html>
