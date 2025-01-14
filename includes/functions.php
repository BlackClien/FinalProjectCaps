<?php

// Include database connection
require_once 'db.php';

/**
 * Hash a password securely.
 *
 * @param string $password
 * @return string
 */
function hashPassword($password) {
    return password_hash($password, PASSWORD_DEFAULT);
}

function check_admin() {
    // Logic to check if the user is an admin
}

function check_counselor() {
    // Logic to check if the user is an admin
}

/**
 * Verify a password against its hash.
 *
 * @param string $password
 * @param string $hash
 * @return bool
 */
function verifyPassword($password, $hash) {
    return password_verify($password, $hash);
}

/**
 * Authenticate a user (admin or counselor).
 *
 * @param string $username
 * @param string $password
 * @param string $userType - 'admin' or 'counselor'
 * @return bool
 */
function authenticateUser($username, $password, $userType) {
    global $conn;

    $table = $userType === 'admin' ? 'admins' : 'counselors';
    $stmt = $conn->prepare("SELECT * FROM $table WHERE username = ?");
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        if (verifyPassword($password, $user['password'])) {
            $_SESSION['user_id'] = $user[$userType . '_id'];
            $_SESSION['user_type'] = $userType;
            $_SESSION['username'] = $user['username'];
            return true;
        }
    }
    return false;
}


/**
 * Logout the current user.
 */
function logout() {
    session_unset();
    session_destroy();
}

/**
 * Redirect to a specific page.
 *
 * @param string $page
 */
function redirect($page) {
    header("Location: $page");
    exit;
}

/**
 * Add flash message to display after redirection.
 *
 * @param string $message
 * @param string $type - 'success', 'error', 'info'
 */
function setFlashMessage($message, $type = 'info') {
    $_SESSION['flash_message'] = ['message' => $message, 'type' => $type];
}

/**
 * Display flash message (if any).
 */
function displayFlashMessage() {
    if (isset($_SESSION['flash_message'])) {
        $flash = $_SESSION['flash_message'];
        echo "<div class='flash-message {$flash['type']}'>{$flash['message']}</div>";
        unset($_SESSION['flash_message']);
    }
}
?>
