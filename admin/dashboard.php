<?php
session_start();

// Redirect if not logged in or not admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../index.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        header {
            background-color: #333;
            color: #fff;
            padding: 20px;
            text-align: center;
        }
        nav {
            background-color: #444;
            padding: 10px;
            text-align: center;
        }
        nav a {
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            margin: 0 10px;
            border-radius: 5px;
            background-color: #555;
        }
        nav a:hover {
            background-color: #777;
        }
        main {
            padding: 20px;
            text-align: center;
        }
        footer {
            background-color: #333;
            color: white;
            padding: 10px;
            text-align: center;
            position: fixed;
            bottom: 0;
            width: 100%;
        }
    </style>
</head>
<body>

<header>
    <h1>Admin Dashboard</h1>
    <p>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>! You are logged in as Admin.</p>
</header>

<nav>
    <a href="counselors.php">Manage Counselors</a>
    <a href="students.php">Manage Students</a>
    <a href="../logout.php">Logout</a>
</nav>

<main>
    <p>Use the navigation links above to manage counselors and students, or log out.</p>
</main>

<footer>
    <p>&copy; 2024 Admin Dashboard. All rights reserved.</p>
</footer>

</body>
</html>
