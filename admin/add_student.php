<?php
require '../includes/auth.php';
require '../includes/db.php';
require '../includes/functions.php';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Check if all the required fields are set and not empty
    if (isset($_POST['student_name'], $_POST['age'], $_POST['gender'], $_POST['email']) &&
        !empty($_POST['student_name']) && !empty($_POST['age']) && !empty($_POST['gender']) && !empty($_POST['email'])) {

        // Get form data
        $student_name = $_POST['student_name'];
        $age = $_POST['age'];
        $gender = $_POST['gender'];
        $email = $_POST['email'];
        $parent_name = isset($_POST['parent_name']) ? $_POST['parent_name'] : null; // Optional
        $parent_contact_number = isset($_POST['parent_contact_number']) ? $_POST['parent_contact_number'] : null; // Optional

        // Prepare SQL query to insert data into students table
        $stmt = $conn->prepare("INSERT INTO students (student_name, age, gender, email, parent_name, parent_contact_number) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sissss", $student_name, $age, $gender, $email, $parent_name, $parent_contact_number);

        // Execute the query
        if ($stmt->execute()) {
            echo "<div class='container success-message'>Student added successfully!</div>";
        } else {
            echo "<div class='container error-message'>Error adding student: " . $conn->error . "</div>";
        }
    } else {
        echo "<div class='container error-message'>Please fill in all required fields.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Student</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="container">
        <h1>Add New Student</h1>
        <form method="POST" action="add_student.php" class="login-form">
            <div class="form-group">
                <label for="student_name">Name:</label>
                <input type="text" name="student_name" required>
            </div>

            <div class="form-group">
                <label for="age">Age:</label>
                <input type="number" name="age" required>
            </div>

            <div class="form-group">
                <label for="gender">Gender:</label>
                <select name="gender" required>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                    <option value="Other">Other</option>
                </select>
            </div>

            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" name="email" required>
            </div>

            <div class="form-group">
                <label for="parent_name">Parent Name (optional):</label>
                <input type="text" name="parent_name">
            </div>

            <div class="form-group">
                <label for="parent_contact_number">Parent Contact Number (optional):</label>
                <input type="text" name="parent_contact_number">
            </div>

            <button type="submit">Add Student</button>
        </form>
    </div>
</body>
</html>
