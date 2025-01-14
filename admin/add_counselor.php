<?php
require '../includes/auth.php';
require '../includes/db.php';
require '../includes/functions.php';
check_admin();

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $email = $_POST['email'];

    $stmt = $conn->prepare("INSERT INTO counselors (username, password, email) VALUES (?, ?, ?)");
    $stmt->bind_param('sss', $username, $password, $email);

    if ($stmt->execute()) {
        header('Location: counselors.php');
        exit;
    } else {
        $error = 'Error adding counselor. Please try again.';
    }
    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Counselor</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="container">
        <h1>Add New Counselor</h1>
        <?php if ($error): ?>
            <p class="error"><?= $error; ?></p>
        <?php endif; ?>
        <form method="POST">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" name="username" id="username" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" required>
            </div>
            <button type="submit">Add Counselor</button>
        </form>
    </div>
</body>
</html>
