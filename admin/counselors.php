<?php
require '../includes/auth.php';
require '../includes/db.php';
require '../includes/functions.php';
check_admin();

$counselors = $conn->query("SELECT * FROM counselors");

if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $conn->query("DELETE FROM counselors WHERE counselor_id = $id");
    header('Location: counselors.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Counselors</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="container">
        <h1>Counselors Management</h1>
        <a href="add_counselor.php" class="btn">Add New Counselor</a>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($counselor = $counselors->fetch_assoc()): ?>
                <tr>
                    <td><?= $counselor['counselor_id'] ?></td>
                    <td><?= htmlspecialchars($counselor['username']) ?></td>
                    <td><?= htmlspecialchars($counselor['email']) ?></td>
                    <td>
                        <a href="?delete=<?= $counselor['counselor_id'] ?>" class="btn-delete" onclick="return confirm('Are you sure?')">Delete</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
