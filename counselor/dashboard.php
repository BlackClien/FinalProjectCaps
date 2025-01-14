<?php
require '../includes/auth.php';

// Start session only if it's not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if user is a counselor
if (!isCounselor()) {
    header("Location: ../index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Counselor Dashboard</title>
    <link rel="stylesheet" href="../styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
            margin: 0;
            padding: 0;
        }

        .navbar {
            background-color: #006400;
            color: white;
            padding: 15px 20px;
            text-align: center;
        }

        .navbar a {
            color: white;
            text-decoration: none;
            margin: 0 15px;
        }

        .navbar a:hover {
            text-decoration: underline;
        }

        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            margin-top: 30px;
        }

        .content {
            background-color: white;
            width: 80%;
            max-width: 800px;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .content h1 {
            color: #006400;
            margin-bottom: 20px;
        }

        .content a {
            display: inline-block;
            background-color: #006400;
            color: white;
            padding: 10px 20px;
            margin: 10px 0;
            text-decoration: none;
            border-radius: 5px;
            font-size: 16px;
            width: 200px;
            text-align: center;
        }

        .content a:hover {
            background-color: #004d00;
        }

        footer {
            background-color: #006400;
            color: white;
            text-align: center;
            padding: 10px;
            position: fixed;
            width: 100%;
            bottom: 0;
        }
    </style>
</head>
<body>

    <div class="navbar">
        <a href="../index.php">Home</a>
        <a href="../logout.php">Logout</a>
    </div>

    <div class="container">
        <div class="content">
            <h1>Welcome to the Counselor Dashboard</h1>
            <p>Here you can manage counseling sessions, appointments, and view student information.</p>
            <a href="counseling_sessions.php">Manage Counseling Sessions</a>
            <a href="appointments.php">Manage Appointments</a>
            <a href="referral_reasons.php">Manage Referral Reasons</a>
            <a href="students.php">View Students</a>
        </div>
    </div>

    <footer>
        <p>&copy; 2024 Cedar Guidance System</p>
    </footer>

</body>
</html>
