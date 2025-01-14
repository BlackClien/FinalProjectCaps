<?php
require '../includes/auth.php';
require '../includes/db.php';

if (!isCounselor()) {
    header("Location: ../index.php");
    exit();
}

$sessions = $db->query("SELECT * FROM sessions")->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add'])) {
        $student_id = $_POST['student_id'];
        $session_date = $_POST['session_date'];
        $remarks = $_POST['remarks'];

        $db->prepare("INSERT INTO sessions (student_id, session_date, remarks) VALUES (?, ?, ?)")
           ->execute([$student_id, $session_date, $remarks]);

        header("Location: sessions.php");
        exit();
    }

    if (isset($_POST['delete'])) {
        $session_id = $_POST['session_id'];
        $db->prepare("DELETE FROM sessions WHERE session_id = ?")->execute([$session_id]);
        header("Location: sessions.php");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Manage Counseling Sessions</title>
    <link rel="stylesheet" href="../styles.css">
</head>
<body>
    <?php include '../includes/navbar.php'; ?>
    <div class="content">
        <h1>Manage Counseling Sessions</h1>

        <!-- Add Session -->
        <form method="POST">
            <h3>Add Session</h3>
            <select name="student_id" required>
                <option value="">Select Student</option>
                <?php
                $students = $db->query("SELECT * FROM students")->fetchAll(PDO::FETCH_ASSOC);
                foreach ($students as $student): ?>
                    <option value="<?= $student['student_id']; ?>"><?= $student['student_name']; ?></option>
                <?php endforeach; ?>
            </select>
            <input type="date" name="session_date" required>
            <textarea name="remarks" placeholder="Remarks" required></textarea>
            <button type="submit" name="add">Add Session</button>
        </form>

        <!-- List of Sessions -->
        <h3>Existing Sessions</h3>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Student</th>
                    <th>Date</th>
                    <th>Remarks</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($sessions as $session): ?>
                    <tr>
                        <td><?= $session['session_id']; ?></td>
                        <td><?= $session['student_id']; ?></td>
                        <td><?= $session['session_date']; ?></td>
                        <td><?= $session['remarks']; ?></td>
                        <td>
                            <a href="edit_session.php?id=<?= $session['session_id']; ?>" class="button">Edit</a>
                            <form method="POST" style="display:inline;">
                                <input type="hidden" name="session_id" value="<?= $session['session_id']; ?>">
                                <button type="submit" name="delete" onclick="return confirm('Are you sure you want to delete this session?');">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
