<?php
require 'includes/db.php'; // Database connection
require 'includes/functions.php'; // Utility functions

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ajax'])) {
    $response = ['status' => 'error', 'message' => 'Invalid login details.'];

    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $role = trim($_POST['role']);

    if ($role === 'admin') {
        $query = "SELECT * FROM admins WHERE username = ?";
    } elseif ($role === 'counselor') {
        $query = "SELECT * FROM counselors WHERE username = ?";
    } else {
        $response['message'] = 'Invalid role selected.';
        echo json_encode($response);
        exit();
    }

    $stmt = $conn->prepare($query);
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user && password_verify($password, $user['password'])) {
        // Set session variables
        $_SESSION['user_id'] = $user[$role . '_id'];
        $_SESSION['role'] = $role;
        $_SESSION['username'] = $user['username'];

        // Debugging: Log session variables
        error_log('Session Initialized: ' . print_r($_SESSION, true));

        if (!isset($_SESSION['user_id'])) {
            $response['message'] = 'Session variable user_id is not set.';
            echo json_encode($response);
            exit();
        }

        $response = [
            'status' => 'success',
            'redirect' => $role === 'admin' ? 'admin/dashboard.php' : 'counselor/dashboard.php',
        ];
    }

    echo json_encode($response);
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cedar Guidance System - Login</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
</head>
<body class="bg-success d-flex justify-content-center align-items-center vh-100">
    <div class="container bg-white p-4 rounded shadow-lg">
        <h1 class="text-center text-success">Login</h1>
        <form id="loginForm">
            <div id="errorMessage" class="alert alert-danger d-none"></div>
            <div class="mb-3">
                <label for="username" class="form-label">Username:</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password:</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div class="mb-3">
                <label for="role" class="form-label">Role:</label>
                <select class="form-select" id="role" name="role" required>
                    <option value="">Select Role</option>
                    <option value="admin">Admin</option>
                    <option value="counselor">Counselor</option>
                </select>
            </div>
            <button type="submit" class="btn btn-success w-100">Login</button>
        </form>
    </div>

    <!-- Bootstrap Bundle (JS) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Handle form submission via AJAX
        $('#loginForm').on('submit', function(e) {
            e.preventDefault();
            $('#errorMessage').addClass('d-none').text('');

            $.ajax({
                url: '', // Same page
                type: 'POST',
                data: $(this).serialize() + '&ajax=1',
                dataType: 'json',
                success: function(response) {
                    if (response.status === 'success') {
                        window.location.href = response.redirect;
                    } else {
                        $('#errorMessage').removeClass('d-none').text(response.message);
                    }
                },
                error: function() {
                    $('#errorMessage').removeClass('d-none').text('An error occurred. Please try again.');
                }
            });
        });
    </script>
</body>
</html>
