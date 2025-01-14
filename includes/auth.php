<?php
// Check if session is already started
if (session_status() === PHP_SESSION_NONE) {
    session_start(); // Start the session if not already started
}

function isAdmin() {
    return isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
}

function isCounselor() {
    return isset($_SESSION['role']) && $_SESSION['role'] === 'counselor';
}

function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

function requireLogin() {
    if (!isLoggedIn()) {
        header("Location: ../login.php");
        exit();
    }
}
?>
